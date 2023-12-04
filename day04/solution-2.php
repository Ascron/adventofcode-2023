<?php

declare(strict_types=1);

function solution (array $input) {
    $cards = [];
    $result = [];

    // Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
    foreach ($input as $line) {
        $line = explode(':', trim($line));
        preg_match("#\d+#", $line[0], $matches);
        $game = (int) $matches[0];

        [$winningNumbers, $myNumbers] = explode('|', $line[1]);
        preg_match_all('#\d+#', $winningNumbers, $matches);
        $winningNumbers = $matches[0];
        preg_match_all('#\d+#', $myNumbers, $matches);
        $myNumbers = $matches[0];
        $power = 0;
        foreach ($myNumbers as $myNumber) {
            if (in_array($myNumber, $winningNumbers)) {
                $power++;
            }
        }

        $cards[$game] = $power;
    }

    $lastGame = $game;

    for ($i = $lastGame; $i > 0; $i--) {
        if ($cards[$i] === 0) {
            $result[$i] = 1;
            continue;
        }
        $copies = 0;
        for ($j = 1; $j <= $cards[$i]; $j++) {
            if (!isset($result[$i + $j])) {
                continue;
            }

            $copies += $result[$i + $j];
        }
        $result[$i] = 1 + $copies;
    }

    return array_sum($result);
}