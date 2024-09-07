<?php
namespace Plast;

use Intervention\Image\ImageManager;

class Image
{
    public function saveThumbnailAsWebp(string $original, string $destination): void
    {
        $image = ImageManager::imagick()->read($original);
        $image->scaleDown(200, 200);
        $image->encodeByExtension('webp')->save($destination);
    }

    public function saveOriginalAsWebp(string $original, string $destination): void
    {
        $image = ImageManager::imagick()->read($original);
        $image->encodeByExtension('webp')->save($destination);
    }
}
