<?php

declare(strict_types=1);

function getHorizontalLine(array $figure, int $y): int {
    $line = '';
    foreach ($figure[$y] as $cell) {
        $line .= $cell === '#' ? '1' : '0';
    }
    return bindec($line);
}

function getVerticalLine(array $figure, int $x): int {
    $line = '';
    foreach ($figure as $row) {
        $line .= $row[$x] === '#' ? '1' : '0';
    }
    return bindec($line);
}

function hasOneDifference($line1, $line2) {
    $diff = decbin($line1 ^ $line2);
    return substr_count($diff, '1') === 1;
}

function printFigure($figure) {
    foreach ($figure as $row) {
        echo implode('', $row) . PHP_EOL;
    }
    echo PHP_EOL;
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
        for ($y = 0, $maxY = count($figure) - 1; $y <= $maxY - 1; $y++) {
            $line1 = getHorizontalLine($figure, $y);
            $line2 = getHorizontalLine($figure, $y + 1);
            $hasOneDiff = 0;
            if (hasOneDifference($line1, $line2)) {
                $hasOneDiff++;
            }

            if ($line1 === $line2 || $hasOneDiff === 1) {
                $mirrored = true;
                for ($yMove = 1; $yMove <= $y; $yMove++) {
                    if (!array_key_exists($y + $yMove + 1, $figure)) {
                        break;
                    }
                    $line1 = getHorizontalLine($figure, $y + $yMove + 1);
                    $line2 = getHorizontalLine($figure, $y - $yMove);
                    if (hasOneDifference($line1, $line2)) {
                        $hasOneDiff++;
                    }
                    if ($line1 !== $line2 && ($hasOneDiff !== 1 || !hasOneDifference($line1, $line2))) {
                        $mirrored = false;
                    }
                }

                if ($mirrored && $hasOneDiff === 1) {
                    $above += $y + 1;
                    echo $index . ' above ' . ($y + 1) . PHP_EOL;
                }
            }
        }

        // check vertical
        for ($x = 0, $maxX = count(reset($figure)) - 1; $x <= $maxX - 1; $x++) {
            $line1 = getVerticalLine($figure, $x);
            $line2 = getVerticalLine($figure, $x + 1);
            $hasOneDiff = 0;
            if (hasOneDifference($line1, $line2)) {
                $hasOneDiff++;
            }
            if ($line1 === $line2 || $hasOneDiff === 1) {
                $mirrored = true;
                for ($xMove = 1; $xMove <= $x; $xMove++) {
                    if (!array_key_exists($x + $xMove + 1, $figure[0])) {
                        break;
                    }

                    $line1 = getVerticalLine($figure, $x + $xMove + 1);
                    $line2 = getVerticalLine($figure, $x - $xMove);
                    if (hasOneDifference($line1, $line2)) {
                        $hasOneDiff++;
                    }
                    if ($line1 !== $line2 && ($hasOneDiff !== 1 || !hasOneDifference($line1, $line2))) {
                        $mirrored = false;
                    }
                }

                if ($mirrored && $hasOneDiff === 1) {
                    $left += $x + 1;
                    echo $index . ' left ' . ($x + 1) . PHP_EOL;
                }
            }
        }
    }

    return $above * 100 + $left;
}