<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\String;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString, RmNullString};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

final class RmStringTest extends TestCase
{
    public AbstractRmString $String;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = RmString::new('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnSameStringAfterAcceptingString(): void
    {
        $this->String = AbstractRmString::new('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = AbstractRmString::new(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnIntegerAsStringAfterOverwritingEmptyString(): void
    {
        $this->String = RmString::new('')->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = AbstractRmString::new(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNullBySet(): void
    {
        $this->String = RmString::new('')->set(null);
        $this->assertInstanceOf(RmNullString::class, $this->String);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = RmString::new('Band');
        echo $this->String;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = AbstractRmString::new(null);
        echo $this->String;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = RmString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            'City',
            RmString::new('Venue')->set('City')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        echo RmString::new('Venue')->set('VenueConcert');
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = RmString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldConcatTwoStrings(): void
    {
        $this->String = RmString::new('Value')->concatWith(RmString::new('Test'));
        $this->assertEquals('ValueTest', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testIsNullShouldReturnFalse(): void
    {
        $this->String = RmString::new('Value');
        $this->assertEquals(false, $this->String->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnATableCell(): void
    {
        $this->String = RmString::new('Value');
        $this->assertEquals(
            '<div class="rm_table_cell">Value</div>',
            $this->String->asTableCell()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnAnInputField(): void
    {
        $this->String = RmString::new('Value');
        $expectedString = '<label for="name_1" class="visually-hidden">Name</label>
            <input id="name_1" name="name" value="Value" placeholder="Name">';
        $this->assertEquals(
            $expectedString,
            $this->String->asTableInput(
                RmString::new('name'),
                RmString::new('Name'),
                RmInt::new(1)
            )
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnAnInputFieldWithDifferentLabel(): void
    {
        $this->String = RmString::new('Value');
        $expectedString = '<label for="city_name_1" class="visually-hidden">Name</label>
            <input id="city_name_1" name="city_name" value="Value" placeholder="Name">';
        $this->assertEquals(
            $expectedString,
            $this->String->asTableInput(
                RmString::new('city_name'),
                RmString::new('Name'),
                RmInt::new(1)
            )
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnAnUrl(): void
    {
        $this->String = RmString::new('https://www.kulttempel.com');
        $this->assertEquals(
            '<a href="https://www.kulttempel.com">www</a>',
            $this->String->asWwwUrl()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnStringWithFirstCharInUppercase(): void
    {
        $this->String = RmString::new('iron Kobra');
        $this->assertEquals(
            'Iron Kobra',
            $this->String->asFirstUppercase()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnNullString(): void
    {
        $this->String = RmString::new(null);
        $this->assertNull(
            $this->String->asFirstUppercase()->get()
        );
    }
}
