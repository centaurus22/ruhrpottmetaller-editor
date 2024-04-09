<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Bool;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\{AbstractRmBool, RmBool, RmNullBool};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmNullTest extends TestCase
{
    private RmNullBool $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmNullBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnAYesNoEmptySelectWithSelectedEmpty(): void
    {
        $this->value = RmBool::new(null);
        $expectedString = '<label for="sold_out_33" class="visually-hidden">Sold out</label>
            <select id="sold_out_33" name="sold_out">
                <option value="" selected="selected"></option>
                <option value="1">yes</option>
                <option value="0">no</option>
            </select>';
        $this->assertEquals(
            $expectedString,
            $this->value->asTableInput(
                RmString::new('sold_out'),
                RmString::new('Sold out'),
                RmInt::new(33)
            )
        );
    }
}
