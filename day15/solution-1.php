<?php

declare(strict_types=1);

function findHash($string) {
    $counter = 0;
    foreach (str_split($string) as $char) {
        $counter += ord($char);
        $counter *= 17;
        $counter %= 256;
    }

    return $counter;
}

function solution (array $input) {
    $result = 0;
    foreach ($input as $line) {
        // rn=1,cm-,qp=3,cm=2,qp-,pc=4,ot=9,ab=5,pc-,pc=6,ot=7
        $line = trim($line);
        $line = explode(',', $line);
        foreach ($line as $sequence) {
//            if (str_contains('=', $sequence)) {
//                [$string, $number] = explode('=', $sequence);
//            } else {
//                [$string] = explode('-', $sequence);
//            }
            $result += findHash($sequence);
        }
    }

    return $result;
}