<?php

declare(strict_types=1);

function placeSprings(&$record, $index, $arrangements) {
    $result = 0;

    $noRecursion = false;

    if (count($arrangements) === 1) {
        $noRecursion = true;
    }

    $arrangement = (int) array_shift($arrangements);
    for ($i = $index, $c = count($record); $i < $c; $i++) {
        if (isset($record[$i - 1]) && $record[$i - 1] === '#') {
            break;
        }
        if (isset($record[$i + $arrangement]) && $record[$i + $arrangement] === '#') {
            continue;
        }

        if ($c < $i + $arrangement) {
            continue;
        }
        for ($j = $i, $limit = $i + $arrangement; $j < $limit; $j++) {
            if ($record[$j] === '.') {
                continue 2;
            }
        }

        if ($noRecursion) {
            $noDataInRecord = true;
            for ($k = $i + $arrangement; $k < $c; $k++) {
                if ($record[$k] === '#') {
                    $noDataInRecord = false;
                    break;
                }
            }

            if ($noDataInRecord) {
                $result++;
            }

        } else {
            if ($i + $arrangement + 1 < $c) {
                $result += placeSprings($record, $i + $arrangement + 1, $arrangements);
            }
        }
    }

    return $result;
}

function solution (array $input) {
    $result = 0;
    // ?#?#?#?#?#?#?#? 1,3,1,6
    foreach ($input as $line) {
        [$record, $arrangements] = explode(' ', trim($line));
        $record = str_split(trim($record));
        $arrangements = explode(',', $arrangements);

        $result += placeSprings($record, 0, $arrangements);
    }
    return $result;
}