<?php
namespace Plast;

use Intervention\Image\ImageManager;

class Image
{
    public function saveThumbnailAs(string $original, string $destination): void
    {
        $image = ImageManager::imagick()->read($original);
        $image->scaleDown(200, 200);
        $image->save($destination);
    }
}
