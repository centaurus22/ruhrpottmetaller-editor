<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\String;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString, RmNullString};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

final class RmStringTest extends TestCase
{
    public AbstractRmString $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->value = RmString::new('');
        $this->assertEquals('', $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnSameStringAfterAcceptingString(): void
    {
        $this->value = AbstractRmString::new('Festival');
        $this->assertEquals('Festival', $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->value = AbstractRmString::new(33);
        $this->assertEquals('33', $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnIntegerAsStringAfterOverwritingEmptyString(): void
    {
        $this->value = RmString::new('')->set(42);
        $this->assertEquals('42', $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->value = AbstractRmString::new(null);
        $this->assertTrue(is_null($this->value->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNullBySet(): void
    {
        $this->value = RmString::new('')->set(null);
        $this->assertInstanceOf(RmNullString::class, $this->value);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->value = RmString::new('Band');
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->value = AbstractRmString::new(null);
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->value = RmString::new('Venue');
        $this->assertEquals('Venue', $this->value->get());
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
        $this->value = RmString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldConcatTwoStrings(): void
    {
        $this->value = RmString::new('Value')->concatWith(RmString::new('Test'));
        $this->assertEquals('ValueTest', $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testIsNullShouldReturnFalse(): void
    {
        $this->value = RmString::new('Value');
        $this->assertEquals(false, $this->value->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnATableCell(): void
    {
        $this->value = RmString::new('Value');
        $this->assertEquals(
            '<div class="rm_table_cell">Value</div>',
            $this->value->asTableCell()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnATableCellWithExtraCssClass(): void
    {
        $this->value = RmString::new('Value');
        $this->assertEquals(
            '<div class="rm_table_cell event">Value</div>',
            $this->value->asTableCell(RmString::new('event'))
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
        $this->value = RmString::new('Value');
        $expectedString = '<label for="name_1" class="visually-hidden">Name</label>
            <input id="name_1" name="name" value="Value" placeholder="Name">';
        $this->assertEquals(
            $expectedString,
            $this->value->asTableInput(
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
        $this->value = RmString::new('Value');
        $expectedString = '<label for="city_name_1" class="visually-hidden">Name</label>
            <input id="city_name_1" name="city_name" value="Value" placeholder="Name">';
        $this->assertEquals(
            $expectedString,
            $this->value->asTableInput(
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
        $this->value = RmString::new('https://www.kulttempel.com');
        $this->assertEquals(
            '<a href="https://www.kulttempel.com">www</a>',
            $this->value->asWwwUrl()
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
        $this->value = RmString::new('iron Kobra');
        $this->assertEquals(
            'Iron Kobra',
            $this->value->asFirstUppercase()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnStringPrefixedWithAnotherString(): void
    {
        $this->value = RmString::new('filter_by');
        $this->assertEquals(
            '?filter_by',
            $this->value->asPrefixedWidth(RmString::new('?'))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnStringAsSubmitButtonLabel(): void
    {
        $this->value = RmString::new('Save');
        $this->assertEquals(
            '<button type="submit">Save</button>',
            $this->value->asSubmitButton()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnTrue(): void
    {
        $this->value = RmString::new('');
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
    public function testShouldReturnTrueIfStringBeginsWithSpecialChar(): void
    {
        $this->value = RmString::new('Ølstykke');
        $this->assertTrue(
            $this->value->hasSpecialFirstChar()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnFalseIfStringBeginsNotWithSpecialChar(): void
    {
        $this->value = RmString::new('Haltern');
        $this->assertFalse(
            $this->value->hasSpecialFirstChar()
        );
    }
}
