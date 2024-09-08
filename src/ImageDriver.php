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
    ): void
    {
        $image = $this->driver->read($input);
        $image->encodeByExtension('webp')->save($originalDestination);
        $image->scaleDown(200, 200)->encodeByExtension('webp')->save($thumbnailDestination);
    }
}
