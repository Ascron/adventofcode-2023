<?php

declare(strict_types=1);

function goNorth(&$map, $y, $x) {
    while (isset($map[$y - 1][$x]) && $map[$y - 1][$x] === '.') {
        $map[$y - 1][$x] = 'O';
        $map[$y][$x] = '.';
        $y--;
    }
}

function goSouth(&$map, $y, $x) {
    while (isset($map[$y + 1][$x]) && $map[$y + 1][$x] === '.') {
        $map[$y + 1][$x] = 'O';
        $map[$y][$x] = '.';
        $y++;
    }
}

function goWest(&$map, $y, $x) {
    while (isset($map[$y][$x - 1]) && $map[$y][$x - 1] === '.') {
        $map[$y][$x - 1] = 'O';
        $map[$y][$x] = '.';
        $x--;
    }
}

function goEast(&$map, $y, $x) {
    while (isset($map[$y][$x + 1]) && $map[$y][$x + 1] === '.') {
        $map[$y][$x + 1] = 'O';
        $map[$y][$x] = '.';
        $x++;
    }
}

function printMap($map) {
    foreach ($map as $line) {
        echo implode('', $line) . PHP_EOL;
    }
    echo PHP_EOL;
}

function storeMap($map) {
    $result = '';
    foreach ($map as $line) {
        $result .= implode('', $line);
    }
    return md5($result);
}

function solution (array $input) {
    $map = [];
    foreach ($input as $line) {
        $map[] = str_split(trim($line));
    }

    $runIndex = 1;

    $northHistory = [];
    $westHistory = [];
    $southHistory = [];
    $eastHistory = [];

    $countFastForward = false;

    $runLimit = 1000000000;

    while ($runIndex <= $runLimit) {
        // north
        foreach ($map as $y => $line) {
            foreach ($line as $x => $point) {
                if ($point === 'O') {
                    goNorth($map, $y, $x);
                }
            }
        }

        $mapHash = storeMap($map);
        if (in_array($mapHash, $northHistory)) {
            if (!$countFastForward) {
                $countCycle = $runIndex - array_search($mapHash, $northHistory, true);
                $runIndex += floor(($runLimit - $runIndex) / $countCycle) * $countCycle;
                $countFastForward = true;
            }
        }
        $northHistory[$runIndex] = $mapHash;
//        printMap($map);

        // west
        foreach ($map as $y => $line) {
            foreach ($line as $x => $point) {
                if ($point === 'O') {
                    goWest($map, $y, $x);
                }
            }
        }

        $mapHash = storeMap($map);
        if (in_array($mapHash, $westHistory)) {
            if (!$countFastForward) {
                $countCycle = $runIndex - array_search($mapHash, $westHistory, true);
                $runIndex += (int) floor(($runLimit - $runIndex) / $countCycle) * $countCycle;
                $countFastForward = true;
            }
        }
        $westHistory[$runIndex] = $mapHash;
//        printMap($map);

        // south
        for ($y = count($map) - 1; $y >= 0; $y--) {
            $line = $map[$y];
            foreach ($line as $x => $point) {
                if ($point === 'O') {
                    goSouth($map, $y, $x);
                }
            }
        }

        $mapHash = storeMap($map);
        if (in_array($mapHash, $southHistory)) {
            if (!$countFastForward) {
                $countCycle = $runIndex - array_search($mapHash, $southHistory, true);
                $runIndex += floor(($runLimit - $runIndex) / $countCycle) * $countCycle;
                $countFastForward = true;
            }
        }
        $southHistory[$runIndex] = $mapHash;
//        printMap($map);

        // east
        foreach ($map as $y => $line) {
            for ($x = count($line) - 1; $x >= 0; $x--) {
                if ($line[$x] === 'O') {
                    goEast($map, $y, $x);
                }
            }
        }

        $mapHash = storeMap($map);
        if (in_array($mapHash, $eastHistory)) {
            if (!$countFastForward) {
                $countCycle = $runIndex - array_search($mapHash, $eastHistory, true);
                $runIndex += floor(($runLimit - $runIndex) / $countCycle) * $countCycle;
                $countFastForward = true;
            }
        }
        $eastHistory[$runIndex] = $mapHash;
        $runIndex++;

//        printMap($map);
    }





    $result = 0;
    foreach ($map as $y => $line) {
        $load = count($map) - $y;
        foreach ($line as $x => $point) {
            if ($point === 'O') {
                $result += $load;
            }
        }
    }

    return $result;
}