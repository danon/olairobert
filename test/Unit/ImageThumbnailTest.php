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
        $this->image->saveAsWebp(
            'resources/starryNight.png',
            'resources/starryNight.expected.t.webp',
            'resources/starryNight.expected.o.webp');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function resizeVertical(): void
    {
        $this->image->saveAsWebp(
            'resources/cafeTerrace.png',
            'resources/cafeTerrace.expected.t.webp',
            'resources/cafeTerrace.expected.o.webp',
        );
    }
}
