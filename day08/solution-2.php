<?php

declare(strict_types=1);

function solution (array $input) {
    $path = str_split(trim(array_shift($input)));
    array_shift($input);
    $ways = [];
    foreach ($input as $line) {
        // AAA = (BBB, CCC)
        preg_match_all('#\w+#', $line, $matches);
        $ways[$matches[0][0]] = [
            'L' => $matches[0][1],
            'R' => $matches[0][2]
        ];
    }

    $currentPlaces = [];
    foreach (array_keys($ways) as $place) {
        if (str_ends_with($place, 'A')) {
            $currentPlaces[] = $place;
        }
    }

    $isItFinishYet = function ($places) {
        foreach ($places as $place) {
            if (!str_ends_with($place, 'Z')) {
                return false;
            }
        }
        return true;
    };

    $pathLength = 0;
    $finishes = [];
    $start = $currentPlaces;
    while (count($finishes) < count($start)) {
        foreach ($currentPlaces as $index => $currentPlace) {
            $currentPlaces[$index] = $ways[$currentPlace][$path[$pathLength % count($path)]];
            if ($isItFinishYet([$currentPlace])) {
                $finishes[$start[$index]][] = $pathLength;
            }
        }
        $pathLength++;
    }

    $path = gmp_init(min($finishes[array_keys($finishes)[0]]));
    for ($i = 1, $c = count($finishes); $i < $c; $i++) {
        $path = gmp_lcm($path, gmp_init(min($finishes[array_keys($finishes)[$i]])));
    }

    return gmp_strval($path);
}