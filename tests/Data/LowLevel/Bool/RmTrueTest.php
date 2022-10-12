<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Bool;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Bool\RmTrue;

final class RmTrueTest extends TestCase
{
    private $Bool;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnTrue(): void
    {
        $this->Bool = RmTrue::new(true);
        $this->assertIsBool($this->Bool->isTrue());
        $this->assertEquals(true, $this->Bool->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnFalse(): void
    {
        $this->Bool = RmBool::new(true);
        $this->assertIsBool($this->Bool->isFalse());
        $this->assertEquals(false, $this->Bool->isFalse());
    }
}
