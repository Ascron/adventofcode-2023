<?php

declare(strict_types=1);

function getHorizontalLine(array $figure, int $y): string {
    return implode('', $figure[$y] ?? []);
}

function getVerticalLine(array $figure, int $x): string {
    $line = '';
    foreach ($figure as $row) {
        $line .= $row[$x] ?? '';
    }
    return $line;
}

function solution (array $input) {
    $figures = [];
    $index = 0;
    foreach ($input as $line) {
        $line = trim($line);
        if ($line === '') {
            $index++;
            continue;
        }

        $figures[$index][] = str_split($line);
    }

    $left = 0;
    $above = 0;

    foreach ($figures as $index => $figure) {
        // check horizontal
        for ($y = 0, $maxY = count($figure) - 1; $y <= $maxY; $y++) {
            if (getHorizontalLine($figure, $y) === getHorizontalLine($figure, $y + 1)) {
                $mirrored = true;
                for ($yMove = 1; $yMove <= $y; $yMove++) {
                    if (!array_key_exists($y + $yMove + 1, $figure)) {
                        break;
                    }
                    if (getHorizontalLine($figure, $y + $yMove + 1) !== getHorizontalLine($figure, $y - $yMove)) {
                        $mirrored = false;
                    }
                }

                if ($mirrored) {
                    $above += $y + 1;
                    echo $index . ' above ' . ($y + 1) . PHP_EOL;
                }
            }
        }

        // check vertical
        for ($x = 0, $maxX = count(reset($figure)) - 1; $x <= $maxX; $x++) {
            if (getVerticalLine($figure, $x) === getVerticalLine($figure, $x + 1)) {
                $mirrored = true;
                for ($xMove = 1; $xMove <= $x; $xMove++) {
                    if (!array_key_exists($x + $xMove + 1, $figure[0])) {
                        break;
                    }

                    if (getVerticalLine($figure, $x + $xMove + 1) !== getVerticalLine($figure, $x - $xMove)) {
                        $mirrored = false;
                    }
                }

                if ($mirrored) {
                    $left += $x + 1;
                    echo $index . ' left ' . ($x + 1) . PHP_EOL;
                }
            }
        }
    }

    return $above * 100 + $left;
}