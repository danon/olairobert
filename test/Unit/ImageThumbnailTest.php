<?php
namespace Test\Unit;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Plast\Image;

class ImageThumbnailTest extends TestCase
{
    private Image $image;

    #[Before]
    public function initialize(): void
    {
        $this->image = new Image();
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function resizeHorizontal(): void
    {
        $this->image->saveThumbnailAsWebp('resources/starryNight.png', 'resources/starryNight.expected.webp');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function resizeVertical(): void
    {
        $this->image->saveThumbnailAsWebp('resources/cafeTerrace.png', 'resources/cafeTerrace.expected.webp');
    }
}
