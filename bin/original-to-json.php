#!/usr/bin/env php
<?php
$debug = $_SERVER['argv'][1] ?? false;
$baseDir = __DIR__ . '/..';
$imgDir = $baseDir . '/img';
$srcDir = $baseDir . '/src';

$symbolMap = [
    'ffe51b' => '⬝',
    '2b2e34' => '■',
    '3bb5e6' => '★',
    'ffffff' => '☐',
    '4c63b3' => '▲',
    'a96eb6' => 'L',
    'e83d71' => 'C',
    'ee2c28' => '4',
    'ff542d' => 'O',
    'ff8939' => 'X',
];

$img = imagecreatefrompng($imgDir . '/logo-original.png');
$w = imagesx($img);
$h = imagesy($img);

if ($debug) {
	$black = imagecolorallocate($img, 0, 0, 0);
	$red = imagecolorallocate($img, 255, 0, 0);
}

$widthPixels = 0;
$heightPixels = 0;

// draw lines that define each pixel

$coeffX = 26.63;
$coeffY = 26.65;

for ($x = 0; $x < $w; $x += $coeffX) {
	if ($x > 0) {
		$widthPixels++;
	}

	if ($debug) {
		imageline($img, $x, $widthPixels % 10 ? 10 : 0, $x, $h - ($widthPixels % 10 ? 10 : 0), $black);
	}
}

for ($y = 0; $y < $h; $y += $coeffY) {
	if ($y > 0) {
		$heightPixels++;
	}

	if ($debug) {
		imageline($img, $heightPixels % 10 ? 10 : 0, $y, $w - ($heightPixels % 10 ? 10 : 0), $y, $black);
	}
}

// final dimensions should be 54x47

// create palette

$palette = [];
$symbols = [];
$pixels = [];

for ($y = $coeffY / 2; $y < $h; $y += $coeffY) {
	$row = [];
	for ($x = $coeffX / 2; $x < $w; $x += $coeffX) {
		$color = imagecolorat($img, $x, $y);
		$index = array_search($color, $palette, true);

		if ($index === false) {
			$palette[] = $color;
            $symbols[] = $symbolMap[dechex($color)];
			$row[] = count($palette) - 1;
		}
		else {
			$row[] = $index;
		}

		if ($debug) {
			imagesetpixel($img, $x, $y, $red);
		}
	}
	$pixels[] = $row;
}

if ($debug) {
	imagepng($img, $imgDir . '/logo-original-debug.png');
}

imagedestroy($img);

file_put_contents($srcDir . '/logo.json', json_encode(compact('palette', 'symbols', 'pixels')));
