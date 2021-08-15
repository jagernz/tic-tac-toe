<?php

namespace App\Http\Controllers;


use App\Http\Services\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllGames()
    {
        $result = Logger::getGames();

        if ( !is_string($result) ) {
            return response()->json($result);
        }

        return response()->json(['reason' => $result], 400);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function startNewGame()
    {
        $game = app('New Game');
        $result = Logger::startGame($game);

         if ( !is_string($result) ) {
             return response()->json(['location' => URL::current() . '/' . $game->getId()]);
         }

         return response()->json(['reason' => $result], 400);
    }

    /**
     * @param $gameId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGame($gameId)
    {
        $result = Logger::getGame($gameId);

        if ( !is_string($result) ) {
            return response()->json($result);
        }

        return response()->json(['reason' => $result], 400);
    }

    /**
     * @param Request $request
     * @param $gameId
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeMove(Request $request, $gameId)
    {
        $result = Logger::getGame($gameId);

        if ( !is_string($result) ) {

            $result = Logger::makeMove(
                $request->post('board'),
                $result
            );

            return response()->json($result);
        }

        return response()->json(['reason' => $result], 400);
    }

    /**
     * @param $gameId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGame($gameId)
    {
        $result = Logger::deleteGame($gameId);

        if ( !is_string($result) ) {
            return response()->json(['Game successfully deleted']);
        }

        return response()->json(['reason' => $result], 400);
    }
}
