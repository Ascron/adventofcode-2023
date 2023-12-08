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

    $pathLength = 0;
    $currentPlace = 'AAA';
    while ($currentPlace !== 'ZZZ') {
        $currentPlace = $ways[$currentPlace][$path[$pathLength % count($path)]];
        $pathLength++;
    }

    return $pathLength;
}