<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmFalse;

final class RmFalseTest extends TestCase
{
    private $Bool;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnTrue(): void
    {
        $this->Bool = RmFalse::new(false);
        $this->assertIsBool($this->Bool->isFalse());
        $this->assertEquals(true, $this->Bool->isFalse());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnFalse(): void
    {
        $this->Bool = RmBool::new(false);
        $this->assertIsBool($this->Bool->isTrue());
        $this->assertEquals(false, $this->Bool->isTrue());
    }
}
