<?php
namespace Plast;

use Intervention\Image\ImageManager;

class Image
{
    public function saveAsWebp(
        string $input,
        string $thumbnailDestination,
        string $originalDestination,
    ): void
    {
        $this->saveOriginalAsWebp($input, $originalDestination);
        $this->saveThumbnailAsWebp($input, $thumbnailDestination);
    }

    private function saveThumbnailAsWebp(string $original, string $destination): void
    {
        $image = ImageManager::imagick()->read($original);
        $image->scaleDown(200, 200);
        $image->encodeByExtension('webp')->save($destination);
    }

    private function saveOriginalAsWebp(string $original, string $destination): void
    {
        $image = ImageManager::imagick()->read($original);
        $image->encodeByExtension('webp')->save($destination);
    }
}
