<?php

namespace Jukebox\Backend\EventHandlers\Import
{

    use Imagick;
    use Jukebox\Backend\EventHandlers\EventHandlerInterface;

    abstract class AbstractArtistImportEventHandler implements EventHandlerInterface
    {
        protected function downloadImage(string $uri): string
        {
            $handle = fopen($uri, 'rb');
            $image = new Imagick;
            $image->readImageFile($handle);

            $width = $image->getImageWidth();
            $height = $image->getImageHeight();

            $maxSize = 200;

            if ($height > $width) {
                $scalingFactor = $maxSize / $width;
                $newWidth = $maxSize;
                $newHeight = $height * $scalingFactor;
            } else {
                $scalingFactor = $maxSize / $height;
                $newHeight = $maxSize;
                $newWidth = $width * $scalingFactor;
            }

            $splitUri = explode('/', $uri);
            $sliced  = array_slice($splitUri, -1);
            $filename = array_pop($sliced);
            $image->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
            $image->writeImage('/var/www/CDN/artists/' . $filename);
            $image->clear();

            return $filename;
        }
    }
}
