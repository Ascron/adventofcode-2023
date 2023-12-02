<?php

declare(strict_types=1);

function solution(array $input) {
    $result = 0;
    foreach ($input as $line) {
        preg_match_all('#\d#', $line, $matches);

        $value = (int) ($matches[0][0] . '' . array_pop($matches[0]));
        $result += $value;
    }

    return $result;
}

