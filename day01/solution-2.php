<?php

declare(strict_types=1);

function solution(array $input) {
    $result = 0;

    $replacement = [
        'oneight' => '18',
        'eightwo' => '82',
        'twone' => '21',
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9',
    ];

    foreach ($input as $line) {
        $line = str_replace(array_keys($replacement), $replacement, $line);
        preg_match_all('#\d#', $line, $matches);
        $value = $matches[0][0];
        $value .= array_pop($matches[0]);
        $result += (int) $value;
    }

    return $result;
}

