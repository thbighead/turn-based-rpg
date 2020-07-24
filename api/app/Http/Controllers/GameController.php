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
            'game_id' => 'required|exists:games,_id'
        ]);

        $game = $this->gameRepository->find($request->get('game_id'));

        return $this->battleRepository->createGameBattle($game);
    }

    public function log(Request $request)
    {
        $this->validate($request, [
            'game_id' => 'required|exists:games,_id'
        ]);

        $game = $this->gameRepository->find($request->get('game_id'));

        if ($request->header('Accept') === 'application/json') {
            return response()->json(['full_game_log' => $game->log]);
        }

        return nl2br($game->log);
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
