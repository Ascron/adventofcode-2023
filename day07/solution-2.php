<?php

declare(strict_types=1);

function solution (array $input) {
    // A, K, Q, J, T, 9, 8, 7, 6, 5, 4, 3, or 2
    // e, d, c, b, a, 9, 8, 7, 6, 5, 4, 3, or 2

    $recode = [
        'A' => 'e',
        'K' => 'd',
        'Q' => 'c',
        'T' => 'a',
        '9' => '9',
        '8' => '8',
        '7' => '7',
        '6' => '6',
        '5' => '5',
        '4' => '4',
        '3' => '3',
        '2' => '2',
        'J' => '1',
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

        $joker = ord('J');

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

        if (array_key_exists($joker, $cardCounts) && $cardCounts[$joker] > 0) {
            $oldType = $handType;
            switch ($cardCounts[$joker]) {
                case 4:
                    $handType = 'five_of_a_kind';
                    break;
                case 3:
                    if ($handType === 'three_of_a_kind') {
                        $handType = 'four_of_a_kind';
                    } elseif ($handType === 'full_house') {
                        $handType = 'five_of_a_kind';
                    }
                    break;
                case 2:
                    if ($handType === 'full_house') {
                        $handType = 'five_of_a_kind';
                    } elseif ($handType === 'two_pairs') {
                        $handType = 'four_of_a_kind';
                    } elseif ($handType === 'one_pair') {
                        $handType = 'three_of_a_kind';
                    }
                    break;
                case 1:
                    $handType = match ($handType) {
                        'four_of_a_kind' => 'five_of_a_kind',
                        'full_house' => 'four_of_a_kind',
                        'three_of_a_kind' => 'four_of_a_kind',
                        'two_pairs' => 'full_house',
                        'one_pair' => 'three_of_a_kind',
                        'high_card' => 'one_pair',
                    };
                    break;
            }
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