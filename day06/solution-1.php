<?php

declare(strict_types=1);

function solution (array $input) {
    // Time:      7  15   30
    // Distance:  9  40  200

    $games = [];

    foreach ($input as $line) {
        $line = trim($line);
        if (str_starts_with($line, 'Time:')) {
            preg_match_all("#\d+#", $line, $matches);
            foreach ($matches[0] as $match) {
                $games[] = [
                    'time' => (int) $match,
                ];
            }
        }

        if (str_starts_with($line, 'Distance:')) {
            preg_match_all("#\d+#", $line, $matches);
            foreach ($matches[0] as $index => $match) {
                $games[$index]['distance'] = (int) $match;
            }
        }
    }

    $result = 1;

    foreach ($games as $game) {
        $midHold = $game['time'] / 2;
        $closestInt1 = (int) round($midHold);

        $x1 = ($game['time'] + sqrt($game['time'] * $game['time'] - 4 * $game['distance'])) / 2;
        $x2 = ($game['time'] - sqrt($game['time'] * $game['time'] - 4 * $game['distance'])) / 2;
        $answer = (int) ceil(max($x1, $x2));
        $answerCount = $answer - $closestInt1;
        if ($game['time'] % 2 === 1) {
            $result *= 2 * ($answerCount);
        } else {
            $result *= 2 * ($answerCount - 1) + 1;
        }

    }

    return $result;
}