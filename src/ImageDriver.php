<?php
namespace Plast;

use Intervention\Image\ImageManager;

readonly class ImageDriver
{
    private ImageManager $driver;

    public function __construct()
    {
        $this->driver = ImageManager::imagick();
    }

    public function saveAsWebp(
        string $input,
        string $thumbnailDestination,
        string $originalDestination,
    ): array
    {
        $hasOriginal = \file_exists($originalDestination);
        $hasThumbnail = \file_exists($thumbnailDestination);
        if ($hasOriginal && $hasThumbnail) {
            return [];
        }
        $image = $this->driver->read($input);
        $results = [];
        if (!$hasOriginal) {
            $image->encodeByExtension('webp')->save($originalDestination);
            $results[] = $originalDestination;
        }
        if (!$hasThumbnail) {
            $image->scaleDown(200, 200)->encodeByExtension('webp')->save($thumbnailDestination);
            $results[] = $thumbnailDestination;
        }
        return $results;
    }
}
