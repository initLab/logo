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

$img = imagecreate($width, $height);

$paletteColors = array_map(function($color) use ($img) {
	return imagecolorallocate(
		$img,
		$color >> 16,
		($color >> 8) & 0xFF,
		$color & 0xFF
	);
}, $palette);

foreach ($pixels as $y => $row) {
	foreach ($row as $x => $index) {
		imagesetpixel($img, $x, $y, $paletteColors[$index]);
	}
}

imagepng($img, $imgDir . '/logo-indexed.png', 9);
imagedestroy($img);
