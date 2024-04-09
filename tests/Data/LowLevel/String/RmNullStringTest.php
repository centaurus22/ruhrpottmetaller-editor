<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\String;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmNullStringTest extends TestCase
{
    private RmNullString $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnNullString(): void
    {
        $this->value = RmNullString::new(null);
        $this->assertNull(
            $this->value->asFirstUppercase()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnStringPrefixedWithAnotherString(): void
    {
        $this->value = RmNullString::new(null);
        $this->assertEquals(
            '',
            $this->value->asPrefixedWidth(RmString::new('?'))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnTrue(): void
    {
        $this->value = RmNullString::new(null);
        $this->assertTrue(
            $this->value->isEmpty()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnFalse(): void
    {
        $this->value = RmNullString::new(null);
        $this->assertFalse(
            $this->value->hasSpecialFirstChar()
        );
    }
}
