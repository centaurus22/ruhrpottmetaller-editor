<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\String;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmStringTest extends TestCase
{
    public AbstractRmString $String;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = RmString::new('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnSameStringAfterAcceptingString(): void
    {
        $this->String = AbstractRmString::new('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = AbstractRmString::new(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnIntegerAsStringAfterOverwritingEmptyString(): void
    {
        $this->String = RmString::new('')->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = AbstractRmString::new(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNullBySet(): void
    {
        $this->String = RmString::new('')->set(null);
        $this->assertInstanceOf(RmNullString::class, $this->String);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = RmString::new('Band');
        echo $this->String;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = AbstractRmString::new(null);
        echo $this->String;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = RmString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        echo RmString::new('Venue')->set('VenueConcert');
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = RmString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldConcatTwoStrings(): void
    {
        $this->String = RmString::new('Value')->concatWith(RmString::new('Test'));
        $this->assertEquals('ValueTest', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour
     */
    public function testShouldReturnTrue(): void
    {
        $this->String = RmString::new('Value');
        $this->assertEquals(false, $this->String->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour
     */
    public function testShouldReturnNullString(): void
    {
        $this->String = RmString::new(null);
        $this->assertNull(
            $this->String->asFirstUppercase()->get()
        );
    }
}
