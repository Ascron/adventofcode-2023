<?php

declare(strict_types=1);

[$script, $day, $solution] = $_SERVER['argv'];

$solutionDir = __DIR__ . "/day{$day}";

require_once $solutionDir . "/solution-{$solution}.php";

if (!function_exists('solution')) {
    echo 'Solution func does not exists' . PHP_EOL;
    exit;
}

if (!file_exists($solutionDir . '/input.txt')) {
    echo 'Input file does not exists' . PHP_EOL;
    exit;
}

$input = file($solutionDir . '/input.txt');

if (file_exists($solutionDir . "/test-{$solution}.txt")) {
    $testInput = file($solutionDir . "/test-{$solution}.txt");
    if (function_exists('testSolution')) {
        $testResult = testSolution($testInput);
    } else {
        $testResult = solution($testInput);
    }
    $expectedResult = file_get_contents($solutionDir . "/test-result-{$solution}.txt");
    if ((string) $testResult !== $expectedResult) {
        echo "Test failed, expected {$expectedResult}, got {$testResult}" . PHP_EOL;
        exit;
    }

    echo 'Test ok' . PHP_EOL;
}

echo 'Result:' . PHP_EOL . solution($input) . PHP_EOL;