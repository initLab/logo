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

foreach ($palette as $paletteIndex => $paletteColor) {
    $colorLines = [];

    foreach ($pixels as $y => $row) {
        $rowStart = null;
        $rowLines = [];

        foreach ($row as $x => $colorIndex) {
            if ($colorIndex !== $paletteIndex) {
                $rowStart = null;
                continue;
            }

            if ($rowStart === null) {
                $rowStart = $x;
                $rowLines[$x] = $x + 1;
            }
            else {
                $rowLines[$rowStart]++;
            }
        }

        foreach ($rowLines as $xStart => $xEnd) {
            $colorLines[] = 'M' . $xStart . ' ' . $y . 'H' . $xEnd;
        }
    }

    $lines[] = '<path stroke="#' . dechex($paletteColor) . '" d="' . implode('', $colorLines) . '"/>';
}

$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $width . ' ' . $height . '" shape-rendering="crispEdges">
' . implode(PHP_EOL, $lines) . '
</svg>';

file_put_contents($imgDir . '/logo-path.svg', $svg);
