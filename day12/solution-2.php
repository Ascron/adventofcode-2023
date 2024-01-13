<?php

declare(strict_types=1);

function placeSprings(&$record, &$cache, $index, $arrangements) {
    $result = 0;

    $noRecursion = false;

    if (count($arrangements) === 1) {
        $noRecursion = true;
    }

    $arrangement = (int) array_shift($arrangements);
    for ($i = $index, $c = mb_strlen($record); $i < $c; $i++) {
        if ($i - 1 >= 0 && $record[$i - 1] === '#') {
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
            $charCount = count_chars(mb_substr($record, $i + $arrangement, $c - $i - $arrangement), 1);
            if (isset($charCount[ord('#')])) {
                $noDataInRecord = false;
            }

            if ($noDataInRecord) {
                $result++;
            }

        } else {
            if ($i + $arrangement + 1 < $c) {
                if (array_sum($arrangements) + count($arrangements) - 1 > $c - $i - $arrangement - 1) {
                    break;
                }

                $cacheKey = ($i + $arrangement + 1) . '-' . array_sum($arrangements);

                if (isset($cache[$cacheKey])) {
                    $placeResult = $cache[$cacheKey];
                } else {
                    $placeResult = placeSprings($record, $cache, $i + $arrangement + 1, $arrangements);
                    $cache[$cacheKey] = $placeResult;
                }
                $result += $placeResult;
            }
        }
    }

    return $result;
}

function solution (array $input) {
    $result = 0;
    // ?#?#?#?#?#?#?#? 1,3,1,6
    foreach ($input as $index => $line) {
        [$record, $arrangements] = explode(' ', trim($line));
        $record = str_split(trim($record));
        $record = array_merge($record, ['?'], $record, ['?'], $record, ['?'], $record, ['?'], $record);
        $record = implode('', $record);
        $arrangements = explode(',', $arrangements);
        $arrangements = array_merge($arrangements, $arrangements, $arrangements, $arrangements, $arrangements);
        $cache = [];

        $start = hrtime(true);
        $newResult = placeSprings($record, $cache, 0, $arrangements);
        $result += $newResult;
        echo 'Completed ' . $index . ' line with result ' . $newResult . ' time: ' . (hrtime(true) - $start) / 1e6 . PHP_EOL;
    }
    return $result;
}