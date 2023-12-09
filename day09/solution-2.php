<?php

declare(strict_types=1);

function findPrevNumber(array $numbers) {
    $diffs = [];

    $allZero = true;
    for ($i = 1, $c = count($numbers); $i < $c; $i++) {
        $diff = $numbers[$i] - $numbers[$i - 1];
        if ($diff !== 0) {
            $allZero = false;
        }
        $diffs[] = $diff;
    }

    if ($allZero) {
        return reset($numbers);
    }

    $newDiff = findPrevNumber($diffs);
    return reset($numbers) - $newDiff;
}

function solution (array $input) {
    $result = 0;
    foreach ($input as $line) {
        $numbers = array_map(intval(...), explode(' ', trim($line)));

        $result += findPrevNumber($numbers);
    }

    return $result;
}