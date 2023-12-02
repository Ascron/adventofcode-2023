<?php

declare(strict_types=1);

function solution (array $input) {
    $result = 0;

    foreach ($input as $line) {
        $red = 0;
        $green = 0;
        $blue = 0;
        // Game 78: 8 red, 19 blue, 4 green; 18 blue, 2 red; 12 blue, 4 green, 8 red; 17 blue, 2 green, 9 red; 9 red, 10 blue, 1 green; 6 green, 9 blue, 1 red
        $game = explode(':', $line);
        $gameNumber = (int) explode(' ', $game[0])[1];
        $game = trim($game[1]);
        $parties = explode(';', $game);
        foreach ($parties as $party) {
            $party = explode(',', $party);
            foreach ($party as $play) {
                if (str_contains($play, 'red')) {
                    $red = max((int) $play, $red);
                }
                if (str_contains($play, 'green')) {
                    $green = max((int) $play, $green);
                }
                if (str_contains($play, 'blue')) {
                    $blue = max((int) $play, $blue);
                }
            }
        }

        $result += $red * $green * $blue;
    }

    return $result;
}