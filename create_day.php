<?php

declare(strict_types=1);

[$script] = $_SERVER['argv'];

$dayDirs = glob(__DIR__ . '/day*');

$days = [];
foreach ($dayDirs as $dayDir) {
    preg_match('#day(\d+)#', $dayDir, $matches);
    $days[] = (int) $matches[1];
}

$newDay = max($days) + 1;

$solutionDir = sprintf('%s/day%02d', __DIR__, $newDay);
mkdir($solutionDir);
copy(__DIR__ . '/templates/solution.php', $solutionDir . '/solution-1.php');
copy(__DIR__ . '/templates/solution.php', $solutionDir . '/solution-2.php');
copy(__DIR__ . '/templates/input.txt', $solutionDir . '/input.txt');
copy(__DIR__ . '/templates/test.txt', $solutionDir . '/test-1.txt');
copy(__DIR__ . '/templates/test.txt', $solutionDir . '/test-2.txt');
copy(__DIR__ . '/templates/test-result.txt', $solutionDir . '/test-result-1.txt');
copy(__DIR__ . '/templates/test-result.txt', $solutionDir . '/test-result-2.txt');

