<?php

declare(strict_types=1);

function solution (array $input) {
    $seeds = [];

    $convertorTypes = [];
    $map = null;

    foreach ($input as $line) {
        $line = trim($line);

        if ($line === '') {
            $map = null;
            continue;
        }

        if (str_starts_with($line, 'seeds:')) {
            // seeds: 79 14 55 13
            $line = str_replace('seeds: ', '', $line);
            $seeds = array_map(intval(...), explode(' ', $line));
            continue;
        }

        if (str_contains($line, 'map:')) {
            // seed-to-soil map:
            $map = explode(' ', $line)[0];
            $convertorTypes[$map] = [];
            continue;
        }

        if ($map !== null) {
            // 0 15 37
            $convertor = explode(' ', $line);
            $convertorTypes[$map][] = [
                'destination' => (int) $convertor[0],
                'source' => (int) $convertor[1],
                'range' => (int) $convertor[2]
            ];
        }
    }

    $result = [];

    foreach ($seeds as $seed) {
        $source = $seed;
        foreach ($convertorTypes as $convertors) {
            foreach ($convertors as $convertor) {
                if ($convertor['source'] <= $source && $source < $convertor['source'] + $convertor['range']) {
                    $source = $convertor['destination'] + ($source - $convertor['source']);
                    break;
                }
            }
        }

        $result[] = $source;
    }

    return min($result);
}