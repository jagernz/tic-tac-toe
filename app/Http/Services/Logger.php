<?php


namespace App\Http\Services;


/**
 * Class Logger
 * @package App\Http\Services
 */
class Logger
{
    const FILEPATH = __DIR__ . '/games.txt';

    /**
     * @param Game $game
     * @return bool|string
     */
    public static function startGame(Game $game)
    {
        if (file_exists(self::FILEPATH)) {

            $saveGames = json_decode(file_get_contents(self::FILEPATH), true);

            foreach ($saveGames as $saveGame) {
                if ($saveGame['id'] === $game->getId()) {
                    return 'Game\'s Id is already exist.';
                }
            }

            $saveGames[] = $game->toArray();

            if (file_put_contents(self::FILEPATH, json_encode($saveGames))) {
                return true;
            }

            return 'Cannot save this Game.';

        }

        if (file_put_contents(self::FILEPATH, json_encode([$game->toArray()]))) {
            return true;
        }

        return 'Cannot save this Game.';
    }

    /**
     * @return array
     */
    public static function getGames(): array
    {
        if (file_exists(self::FILEPATH)) {
            return json_decode(file_get_contents(self::FILEPATH), true);
        }

        return [];
    }

    /**
     * @param $id
     */
    public static function deleteGame($id)
    {
        if (file_exists(self::FILEPATH)) {

            $saveGames = json_decode(file_get_contents(self::FILEPATH), true);

            $ifGameExist = false;

            foreach ($saveGames as $key => $saveGame) {
                if ($saveGame['id'] === $id) {
                    array_splice($saveGames, $key, 1);
                    $ifGameExist = true;
                }
            }

            if ($ifGameExist) {
                if (file_put_contents(self::FILEPATH, json_encode($saveGames))) {
                    return true;
                }
                return 'Cannot save this Game.';
            }

            return 'No games with this Id.';

        }

        return 'There are no file with saved Games.';
    }

    /**
     * @param $id
     * @param false $onlyExist
     * @return mixed|string
     */
    public static function getGame($id)
    {
        if (file_exists(self::FILEPATH)) {

            $saveGames = json_decode(file_get_contents(self::FILEPATH), true);

            foreach ($saveGames as $saveGame) {
                if ($saveGame['id'] === $id) {
                    return $saveGame;
                }
            }

            return 'No games with this Id.';

        }

        return 'There are no file with saved Games.';
    }

    /**
     * @param $boardString
     * @param $gameArray
     * @return mixed|string
     */
    public static function makeMove($boardString, $gameArray)
    {
        $row0 = str_split(str_split($boardString, 3)[0]);
        $row1 = str_split(str_split($boardString, 3)[1]);
        $row2 = str_split(str_split($boardString, 3)[2]);

        $board = new Board();

        $board->setCells([
            $row0,
            $row1,
            $row2
        ]);

        $game = new Game($board);
        $game->setId($gameArray['id']);
        $game->setStatus($gameArray['status']);

        //analyze board;
        $game->checkWinOrDraw();

        //save move;
        self::saveGame($game);

        //win or draw
        if ($game->getStatus() !== Status::RUNNING) {
            return self::getGame($game->getId());
        }

        //make available move;
        $game->makeAvailableMove();

        //analyze board;
        $game->checkWinOrDraw();

        //save move;
        self::saveGame($game);

        return self::getGame($game->getId());
    }

    /**
     * @param Game $game
     */
    private static function saveGame(Game $game)
    {
        $saveGames = json_decode(file_get_contents(self::FILEPATH), true);

        $newData = [];

        foreach ($saveGames as $saveGame) {

            if ($saveGame['id'] === $game->getId()) {
                $saveGame['board'] = $game->getBoard()->convertToString();
                $saveGame['status'] = $game->getStatus();
                $newData[] = $saveGame;
            } else {
                $newData[] = $saveGame;
            }
        }

        file_put_contents(self::FILEPATH, json_encode($newData));
    }
}
