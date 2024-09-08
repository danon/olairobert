<?php
namespace Plast\Laravel\Bootstrap;

use Plast\ImageDriver;

readonly class PublicImages
{
    private ImageDriver $driver;

    public function __construct(private string $publicPath)
    {
        $this->driver = new ImageDriver();
    }

    public function saveInOptimalFormat(string $filename): array
    {
        return $this->createThumbnailsAndCovertWebp($filename, $this->mapExtension($filename, 'webp'));
    }

    private function createThumbnailsAndCovertWebp(string $fileOriginal, string $fileWebp): array
    {
        return $this->driver->saveAsWebp(
            $this->path('originals', $fileOriginal),
            $this->path('thumbnails', $fileWebp),
            $this->path('images', $fileWebp));
    }

    private function mapExtension(string $filename, string $extension): string
    {
        $extensionLength = \strLen(\pathInfo($filename, \PATHINFO_EXTENSION));
        return \subStr($filename, 0, -$extensionLength) . $extension;
    }

    private function path(string $publicPath, string $filename): string
    {
        return $this->publicPath . DIRECTORY_SEPARATOR . $publicPath . DIRECTORY_SEPARATOR . $filename;
    }
}
