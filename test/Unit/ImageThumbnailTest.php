<?php
namespace Test\Unit;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Plast\ImageDriver;

class ImageThumbnailTest extends TestCase
{
    private ImageDriver $driver;

    #[Before]
    public function initialize(): void
    {
        $this->driver = new ImageDriver();
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function resizeHorizontal(): void
    {
        $this->driver->saveAsWebp(
            'resources/starryNight.png',
            'resources/starryNight.expected.t.webp',
            'resources/starryNight.expected.o.webp');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function resizeVertical(): void
    {
        $this->driver->saveAsWebp(
            'resources/cafeTerrace.png',
            'resources/cafeTerrace.expected.t.webp',
            'resources/cafeTerrace.expected.o.webp',
        );
    }
}
