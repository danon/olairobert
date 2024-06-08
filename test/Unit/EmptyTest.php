<?php
namespace Test\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EmptyTest extends TestCase
{
    #[Test]
    public function test(): void
    {
        $this->assertTrue(true);
    }
}
