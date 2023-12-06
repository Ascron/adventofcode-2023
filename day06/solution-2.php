<?php

declare(strict_types=1);

function solution (array $input) {
    // Time:      7  15   30
    // Distance:  9  40  200

    $games = [];

    foreach ($input as $line) {
        $line = trim($line);
        if (str_starts_with($line, 'Time:')) {
            $line = str_replace(' ', '', $line);
            $games[] = [
                'time' => (int) (explode(':', $line)[1]),
            ];
        }

        if (str_starts_with($line, 'Distance:')) {
            $line = str_replace(' ', '', $line);
            $games[0]['distance'] = (int) (explode(':', $line)[1]);
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