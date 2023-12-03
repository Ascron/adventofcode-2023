<?php

declare(strict_types=1);

function solution (array $input) {
    $result = 0;
    $symbols = [];

    foreach ($input as $y => $line) {
        $input[$y] = str_split(trim($line));
        $line = $input[$y];

        foreach ($line as $x => $char) {
            if (!is_numeric($char) && $char !== '.') {
                $symbols[$y][$x] = $char;
            }
        }
    }

    $digits = [];
    foreach ($input as $y => $line) {
        $isTypingChar = false;
        $charX = 0;
        $charY = 0;
        foreach ($line as $x => $char) {
            if (is_numeric($char)) {
                if ($isTypingChar) {
                    $digits[$charY][$charX] .= $char;
                    $digits[$charY][$charX] = (int) $digits[$charY][$charX];
                } else {
                    $charX = $x;
                    $charY = $y;

                    $digits[$charY][$charX] = (int) $char;

                    $isTypingChar = true;
                }
            } else {
                $isTypingChar = false;
            }
        }
    }

    foreach ($digits as $y => $digitLine) {
        foreach ($digitLine as $x => $digit) {
            $size = strlen((string) $digit);

            $possibleYs = [$y - 1, $y, $y + 1];
            $possibleXs = [];
            for ($i = -1; $i <= $size; $i++) {
                $possibleXs[] = $x + $i;
            }

            foreach ($possibleYs as $possibleY) {
                foreach ($possibleXs as $possibleX) {
                    if (isset($symbols[$possibleY][$possibleX])) {
                        $result += $digit;
                        break 2;
                    }
                }
            }
        }
    }

    return $result;
}