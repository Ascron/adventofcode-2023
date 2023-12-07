<?php

declare(strict_types=1);

function solution (array $input) {
    // A, K, Q, J, T, 9, 8, 7, 6, 5, 4, 3, or 2
    // e, d, c, b, a, 9, 8, 7, 6, 5, 4, 3, or 2

    $recode = [
        'A' => 'e',
        'K' => 'd',
        'Q' => 'c',
        'J' => 'b',
        'T' => 'a',
        '9' => '9',
        '8' => '8',
        '7' => '7',
        '6' => '6',
        '5' => '5',
        '4' => '4',
        '3' => '3',
        '2' => '2',
    ];

    $handTypes = [
        'high_card' => '1',
        'one_pair' => '2',
        'two_pairs' => '3',
        'three_of_a_kind' => '4',
        'full_house' => '5',
        'four_of_a_kind' => '6',
        'five_of_a_kind' => '7',
    ];

    $code = function ($cards, $recode) {
        $result = '';
        foreach (str_split($cards) as $card) {
            $result .= $recode[$card];
        }
        return $result;
    };

    $plays = [];

    foreach ($input as $line) {
        // T55J5 684
        [$cards, $bid] = explode(' ', trim($line));

        $cardCounts = count_chars($cards, 1);

        $handType = null;
        if (max($cardCounts) === 5) {
            $handType = 'five_of_a_kind';
        } elseif (max($cardCounts) === 4) {
            $handType = 'four_of_a_kind';
        } elseif (max($cardCounts) === 3) {
            if (min($cardCounts) === 2) {
                $handType = 'full_house';
            } else {
                $handType = 'three_of_a_kind';
            }
        } elseif (max($cardCounts) === 2) {
            if (count($cardCounts) === 3) {
                $handType = 'two_pairs';
            } else {
                $handType = 'one_pair';
            }
        } else {
            $handType = 'high_card';
        }

        $plays[] = ['hand' => $cards, 'value' => hexdec($handTypes[$handType] . $code($cards, $recode)), 'handType' => $handType, 'bid' => $bid];
    }

    $x = 1;

    usort($plays, function ($a, $b) {
        return $a['value'] <=> $b['value'];
    });

    $result = 0;

    foreach ($plays as $index => $item) {
        $result += $item['bid'] * ($index + 1);
    }

    return $result;
}