<?php

namespace App\Http\Controllers;

use App\Repository\BattleRepository;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use Illuminate\Http\Request;

class BattleController extends Controller
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

    public function nextTurn(Request $request)
    {
        $this->validate($request, [
            'game_id' => 'required|exists:games,_id'
        ]);

        $game = $this->gameRepository->find($request->get('game_id'));

        if (!$game->battle) return response()->json([
            'message' => 'Battle hasn\'t began yet',
            'game' => $game
        ], 405);

        if ($game->over()) return response()->json(['message' => 'Game Over', 'game' => $game]);

        $game->appendBattleLog($game->battle->calculateWholeTurn());

        return $game;
    }
}
