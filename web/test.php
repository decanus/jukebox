<?php

// Max vert or horiz resolution
$maxsize = 200;

// create new Imagick object
$image = new Imagick(__DIR__ . '/test1.jpeg');

$width = $image->getImageWidth();
$height = $image->getImageHeight();

if ($height > $width) {
    $scalingFactor = $maxsize / $width;
    $newWidth = $maxsize;
    $newHeight = $height * $scalingFactor;
} else {
    $scalingFactor = $maxsize / $height;
    $newHeight = $maxsize;
    $newWidth = $width * $scalingFactor;
}

$image->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
$image->writeImage(__DIR__ . '/test2.jpeg');