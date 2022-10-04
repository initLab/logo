#!/usr/bin/env php
<?php
$baseDir = __DIR__ . '/..';
$txtDir = $baseDir . '/txt';
$srcDir = $baseDir . '/src';

/**
 * @var int[] $palette
 * @var int[][] $pixels
 */
extract(json_decode(file_get_contents($srcDir . '/logo.json'), true));

$buffer = '';

foreach ($palette as $index => $color) {
	$buffer .= $symbols[$index] . ': #' . dechex($color) . PHP_EOL;
}

$buffer .= PHP_EOL;

$buffer .= implode(PHP_EOL, array_map(function($row) use ($symbols) {
	return implode('', array_map(static fn($pixel) => $symbols[$pixel], $row));
}, $pixels));

file_put_contents($txtDir . '/logo-symbol-map.txt', $buffer);
