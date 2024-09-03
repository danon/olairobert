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
        $this->image->saveThumbnailAs('resources/starryNight.png', 'resources/starryNight.expected.png');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function resizeVertical(): void
    {
        $this->image->saveThumbnailAs('resources/cafeTerrace.png', 'resources/cafeTerrace.expected.png');
    }
}
