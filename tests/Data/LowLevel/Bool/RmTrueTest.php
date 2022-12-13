<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Bool;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Bool\RmTrue;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmTrueTest extends TestCase
{
    private AbstractRmBool $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnTrue(): void
    {
        $this->value = RmTrue::new(true);
        $this->assertIsBool($this->value->isTrue());
        $this->assertEquals(true, $this->value->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnFalse(): void
    {
        $this->value = RmBool::new(true);
        $this->assertIsBool($this->value->isFalse());
        $this->assertEquals(false, $this->value->isFalse());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnAYesNoSelectWithSelectedYes(): void
    {
        $this->value = RmBool::new(true);
        $expectedString = '<label for="is_visible_1" class="visually-hidden">Visible</label>
            <select id="is_visible_1" name="is_visible">
                <option value="1" selected="selected">yes</option>
                <option value="0">no</option>
            </select>';
        $this->assertEquals(
            $expectedString,
            $this->value->asTableInput(
                RmString::new('is_visible'),
                RmString::new('Visible'),
                RmInt::new(1)
            )
        );
    }
}
