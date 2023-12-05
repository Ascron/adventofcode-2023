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
            $rawSeeds = array_map(intval(...), explode(' ', $line));
            $seeds = [];
            foreach ($rawSeeds as $index => $seed) {
                $seeds[(int) floor($index / 2)][] = $seed;
            }
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

    $findSeed = function ($destination, $convertorTypes) {

        foreach (array_reverse($convertorTypes) as $convertors) {
            foreach ($convertors as $convertor) {
                if ($destination >= $convertor['destination'] && $destination < $convertor['destination'] + $convertor['range']) {
                    $destination = $convertor['source'] + ($destination - $convertor['destination']);
                    break;
                }
            }
        }

        return $destination;
    };

    $isSeedExists = function ($seed, $seeds) {
        foreach ($seeds as $seedRange) {
            if ($seed >= $seedRange[0] && $seed < $seedRange[0] + $seedRange[1]) {
                return true;
            }
        }

        return false;
    };

    $finalConvertors = array_pop($convertorTypes);

    $min = min(array_column($finalConvertors, 'destination'));
    for ($i = 0; $i < $min; $i++) {
        $seed = $findSeed($i, $convertorTypes);
        if ($isSeedExists($seed, $seeds)) {
            return $i;
        }
    }

    while (count($finalConvertors) > 0) {
        $min = min(array_column($finalConvertors, 'destination'));

        foreach ($finalConvertors as $index => $convertor) {
            $minConverter = null;
            if ($convertor['destination'] === $min) {

                $minConverter = $convertor;
                unset($finalConvertors[$index]);
                break;
            }
        }

        echo 'found min converter with desc ' . $minConverter['destination'] . '-' . ($minConverter['destination'] + $minConverter['range']) . PHP_EOL;

        for ($i = 0; $i < $minConverter['range']; $i++) {
            $destination = $minConverter['destination'] + $i;
            $seed = $findSeed($minConverter['source'] + $i, $convertorTypes);
            if ($isSeedExists($seed, $seeds)) {
                return $destination;
            }
        }
    }

    return null;
}