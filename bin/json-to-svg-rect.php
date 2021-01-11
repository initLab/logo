#!/usr/bin/env php
<?php
$baseDir = __DIR__ . '/..';
$imgDir = $baseDir . '/img';
$srcDir = $baseDir . '/src';

/**
 * @var int[] $palette
 * @var int[][] $pixels
 */
extract(json_decode(file_get_contents($srcDir . '/logo.json'), true));

$width = count($pixels[0]);
$height = count($pixels);

$lines = [];

foreach ($pixels as $y => $row) {
	foreach ($row as $x => $color) {
		$lines[] = '<rect x="' . $x . '" y="' . $y . '" width="0.1" height="0.1" stroke="#' . dechex($palette[$color]) . '"/>';
	}
}

$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 ' . $width . ' ' . $height . '" shape-rendering="crispEdges">
' . implode(PHP_EOL, $lines) . '
</svg>';

file_put_contents($imgDir . '/logo-rect.svg', $svg);
