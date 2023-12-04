<?php

declare(strict_types=1);

function solution (array $input) {
    $result = 0;

    // Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
    foreach ($input as $line) {
        $line = explode(':', trim($line));
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

        if ($power > 0) {
            $result += 2 ** ($power - 1);
        }
    }


    return $result;
}