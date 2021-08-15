<?php


namespace App\Http\Services;

/**
 * Class Game
 * @package App\Http\Services
 */
class Game
{
    private $id;
    private $board;
    private $status;

    /**
     * Game constructor.
     * @param $board
     */
    public function __construct($board)
    {
        $this->id = $this->generateHash();
        $this->board = $board;
        $this->status = Status::RUNNING;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generateHash(): string
    {
        return md5(time() . random_int(1, 1000000));
    }

    /**
     * @return mixed
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param Board $board
     */
    public function setBoard(Board $board): void
    {
        $this->board = $board;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'id'        =>  $this->getId(),
            'board'     =>  $this->getBoard(),
            'status'    =>  $this->getStatus()
        ];
    }

    public function checkWinOrDraw(): void
    {
        $cells = $this->board->getCells();

        for ($i = 0; $i < 3; $i++) {

            //row
            if ($cells[$i][0] === $cells[$i][1] && $cells[$i][1] === $cells[$i][2] && $cells[$i][0] !== '-') {
                if ($cells[$i][0] === 'X') {
                    $this->setStatus(Status::X_WON);
                } else {
                    $this->setStatus(Status::O_WON);
                }
            }

            //column
            if ($cells[0][$i] === $cells[1][$i] && $cells[1][$i] === $cells[2][$i] && $cells[0][$i] !== '-') {
                if ($cells[0][$i] === 'X') {
                    $this->setStatus(Status::X_WON);
                } else {
                    $this->setStatus(Status::O_WON);
                }
            }

            //diagonal left
            if ($cells[0][0] === $cells[1][1] && $cells[1][1] === $cells[2][2] && $cells[0][0] !== '-') {
                if ($cells[0][0] === 'X') {
                    $this->setStatus(Status::X_WON);
                } else {
                    $this->setStatus(Status::O_WON);
                }
            }

            //diagonal right
            if ($cells[2][0] === $cells[1][1] && $cells[1][1] === $cells[0][2] && $cells[2][0] !== '-') {
                if ($cells[2][0] === 'X') {
                    $this->setStatus(Status::X_WON);
                } else {
                    $this->setStatus(Status::O_WON);
                }
            }
        }

        //check draw
        $draw = true;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($cells[$i][$j] === '-') {
                    $draw = false;
                }
            }
        }

        if ($draw && $this->getStatus() === Status::RUNNING) {
            $this->setStatus(Status::DRAW);
        }
    }

    public function makeAvailableMove(): void
    {
        $cells = $this->board->getCells();
        $availableMoves = [];

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($cells[$i][$j] === '-') {
                    $availableMoves[] = $i . $j;
                }
            }
        }

        $move = (string) array_rand(array_flip($availableMoves), 1);
        $cells[$move[0]][$move[1]] = '0';

        $board = new Board();
        $board->setCells($cells);
        $this->setBoard($board);
    }
}
