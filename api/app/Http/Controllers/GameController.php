<?php

namespace App\Http\Controllers;

use App\Repository\BattleRepository;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private $battleRepository;
    private $gameRepository;
    private $playerRepository;

    /**
     * Create a new controller instance.
     *
     * @param BattleRepository $battleRepository
     * @param GameRepository $gameRepository
     * @param PlayerRepository $playerRepository
     */
    public function __construct(
        BattleRepository $battleRepository,
        GameRepository $gameRepository,
        PlayerRepository $playerRepository
    )
    {
        $this->battleRepository = $battleRepository;
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    public function battle(Request $request)
    {
        $this->validate($request, [
            'game_id' => 'required'
        ]);

        $game = $this->gameRepository->find($request->get('game_id'));

        return $this->battleRepository->createGameBattle($game);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required'
        ]);

        $player = $this->playerRepository->findOrCreateByNickname($request->get('nickname'));

        return response()->json([
            'is_new_player' => $player->wasRecentlyCreated,
            'nickname' => $player->nickname,
        ]);
    }

    public function play(Request $request)
    {
        return $this->gameRepository->createPlayerGame($request->user());
    }
}
