<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Bool;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\{AbstractRmBool, RmBool, RmFalse};

final class RmFalseTest extends TestCase
{
    private AbstractRmBool $Bool;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnTrue(): void
    {
        $this->Bool = RmFalse::new(false);
        $this->assertIsBool($this->Bool->isFalse());
        $this->assertEquals(true, $this->Bool->isFalse());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnFalse(): void
    {
        $this->Bool = RmBool::new(false);
        $this->assertIsBool($this->Bool->isTrue());
        $this->assertEquals(false, $this->Bool->isTrue());
    }
}
