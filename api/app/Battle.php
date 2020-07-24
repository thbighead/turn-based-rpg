<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Battle
 *
 * @package App
 *
 * @property bool $finished
 * @property int $turn
 * @property array $initiatives
 * @property array $damages
 * @property-read Character $character
 * @property-read Game $game
 */
class Battle extends Model
{
    const ENEMY_NAME = 'Enemy';
    private $turnLog = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'finished',
        'turn',
        'initiatives',
        'damages',
    ];

    public function character()
    {
        return $this->embedsOne(Character::class);
    }

    public function calculateWholeTurn()
    {
        $this->turn++;
        $player_total_hp = $this->game->player->character->hit_points;
        $player_remaining_hp = $this->game->player->character->hit_points - $this->damages['player'];
        $enemy_total_hp = $this->character->hit_points;
        $enemy_remaining_hp = $this->character->hit_points - $this->damages['enemy'];
        $this->turnLog = "=== Turn {$this->turn} ===\nYou: {$player_remaining_hp}/{$player_total_hp}HP\n"
            . self::ENEMY_NAME . ": {$enemy_remaining_hp}/{$enemy_total_hp}HP";

        $this->rollInitiatives();
        $this->rollAttacks();

        $this->save();

        return $this->turnLog;
    }

    private function fight(
        $first_character_name, Character $firstCharacter,
        $last_character_name, Character $lastCharacter
    )
    {
        $this->turnLog .= "\n-> Rolling tests!";
        $first_character_attack_test_result = $firstCharacter->rollAttackTest();
        $last_character_defense_test_result = $lastCharacter->rollDefenseTest();
        $this->turnLog .= "\n$first_character_name rolled $first_character_attack_test_result points of attack!";
        $this->turnLog .= "\n$last_character_name rolled $last_character_defense_test_result points of defense!";

        if ($first_character_attack_test_result > $last_character_defense_test_result) {
            $damage = $firstCharacter->rollAttackDamage();
            $this->turnLog .=
                "\n$first_character_name attack succeeded and dealt $damage points of damage to $last_character_name!";
            $damages = $this->damages;
            $damages[$first_character_name === self::ENEMY_NAME ? 'player' : 'enemy'] += $damage;
            $this->damages = $damages;

            return $this->ko();
        } else {
            $this->turnLog .= "\n$last_character_name avoided the $first_character_name attack!";
        }

        return false;
    }

    private function ko()
    {
        if ($this->game->player->character->hit_points <= $this->damages['player']) {
            $final_message = '-> You Lose!';
            $this->finished = true;
            $this->turnLog .= "\n\n$final_message";
            return $final_message;
        }

        if ($this->character->hit_points <= $this->damages['enemy']) {
            $final_message = '-> You Win!';
            $this->finished = true;
            $this->turnLog .= "\n\n$final_message";
            return $final_message;
        }

        return false;
    }

    private function rollAttacks()
    {
        if ($this->initiatives['player'] > $this->initiatives['enemy']) {
            $first_character_name = $this->game->player->nickname;
            $firstCharacter = $this->game->player->character;
            $last_character_name = self::ENEMY_NAME;
            $lastCharacter = $this->character;
        } else {
            $first_character_name = self::ENEMY_NAME;
            $firstCharacter = $this->character;
            $last_character_name = $this->game->player->nickname;
            $lastCharacter = $this->game->player->character;
        }

        $first_attack_result = $this
            ->fight($first_character_name, $firstCharacter, $last_character_name, $lastCharacter);
        if (!$first_attack_result)
            return $this->fight($last_character_name, $lastCharacter, $first_character_name, $firstCharacter);

        return $first_attack_result;
    }

    private function rollInitiatives()
    {
        $this->initiatives = [
            'player' => null,
            'enemy' => null,
        ];

        $this->turnLog .= "\n-> Rolling initiatives!";
        while ($this->initiatives['player'] == $this->initiatives['enemy']) {
            $this->initiatives = [
                'player' => $this->game->player->character->rollInitiative(),
                'enemy' => $this->character->rollInitiative(),
            ];

            $this->turnLog .= "\n{$this->game->player->nickname} initiative is {$this->initiatives['player']}.";
            $this->turnLog .= "\n" . self::ENEMY_NAME . " initiative is {$this->initiatives['enemy']}.";

            if ($this->initiatives['player'] == $this->initiatives['enemy']) {
                $this->turnLog .= "\nIt's a tie! Rolling again!";
            }
        }
    }
}
