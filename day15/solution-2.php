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
    $boxes = [];
    foreach ($input as $line) {
        // rn=1,cm-,qp=3,cm=2,qp-,pc=4,ot=9,ab=5,pc-,pc=6,ot=7
        $line = trim($line);
        $line = explode(',', $line);
        foreach ($line as $sequence) {
            if (str_contains($sequence, '=')) {
                [$string, $number] = explode('=', $sequence);

                $boxNumber = findHash($string);
                $replaced = false;
                if (array_key_exists($boxNumber, $boxes)) {
                    foreach ($boxes[$boxNumber] as $index => $lens) {
                        if ($lens['label'] === $string) {
                            $boxes[$boxNumber][$index]['str'] = $number;
                            $replaced = true;
                            break;
                        }
                    }
                }

                if (!$replaced) {
                    $boxes[$boxNumber][] = ['label' => $string, 'str' => $number];
                }
            } else {
                [$string] = explode('-', $sequence);

                $boxNumber = findHash($string);
                if (array_key_exists($boxNumber, $boxes)) {
                    foreach ($boxes[$boxNumber] as $index => $lens) {
                        if ($lens['label'] === $string) {
                            unset($boxes[$boxNumber][$index]);
                            break;
                        }
                    }
                }
            }
        }
    }

    foreach ($boxes as $boxNumber => $box) {
        $index = 1;
        foreach ($box as $item) {
            $result += $item['str'] * ($boxNumber + 1) * $index;
            $index++;
        }
    }

    return $result;
}