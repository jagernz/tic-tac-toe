<?php


namespace App\Http\Services;

/**
 * Class Board
 * @package App\Http\Services
 */
class Board
{
    private $cells;

    /**
     * Board constructor.
     */
    public function __construct()
    {
        $this->cells = [
            ['-', '-', '-'],
            ['-', '-', '-'],
            ['-', '-', '-']
        ];
    }

    /**
     * @param array $cells
     */
    public function setCells(array $cells): void
    {
        $this->cells = $cells;
    }

    /**
     * @return \string[][]
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @return string
     */
    public function convertToString(): string
    {
        $string = '';

        foreach ($this->cells as $row) {
            foreach ($row as $cell) {
                $string .= $cell;
            }
        }

        return $string;
    }
}
