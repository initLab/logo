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
	$buffer .= $index . ': #' . dechex($color) . PHP_EOL;
}

$buffer .= PHP_EOL;

$buffer .= implode(PHP_EOL, array_map(function($row) {
	return implode('', $row);
}, $pixels));

file_put_contents($txtDir . '/logo-pixel-map.txt', $buffer);
