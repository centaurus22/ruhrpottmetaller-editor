<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Bool;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\{AbstractRmBool, RmBool, RmFalse};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmFalseTest extends TestCase
{
    private AbstractRmBool $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnTrue(): void
    {
        $this->value = RmFalse::new(false);
        $this->assertIsBool($this->value->isFalse());
        $this->assertEquals(true, $this->value->isFalse());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnFalse(): void
    {
        $this->value = RmBool::new(false);
        $this->assertIsBool($this->value->isTrue());
        $this->assertEquals(false, $this->value->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnAYesNoSelectWithSelectedNo(): void
    {
        $this->value = RmBool::new(false);
        $expectedString = '<label for="is_visible_4" class="visually-hidden">Visible</label>
            <select id="is_visible_4" name="is_visible">
                <option value="1">yes</option>
                <option value="0" selected="selected">no</option>
            </select>';
        $this->assertEquals(
            $expectedString,
            $this->value->asTableInput(
                RmString::new('is_visible'),
                RmString::new('Visible'),
                RmInt::new(4)
            )
        );
    }
}
