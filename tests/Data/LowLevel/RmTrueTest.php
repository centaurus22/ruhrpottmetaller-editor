<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmTrue;

final class RmTrueTest extends TestCase
{
    private $Bool;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmTrue
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnTrue(): void
    {
        $this->Bool = RmTrue::new(true);
        $this->assertIsBool($this->Bool->isTrue());
        $this->assertEquals(true, $this->Bool->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmTrue
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnFalse(): void
    {
        $this->Bool = RmBool::new(true);
        $this->assertIsBool($this->Bool->isFalse());
        $this->assertEquals(false, $this->Bool->isFalse());
    }
}
