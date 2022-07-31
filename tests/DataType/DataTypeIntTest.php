<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\DataType;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeString;
use PHPUnit\Framework\TestCase;

final class DataTypeIntTest extends TestCase
{
    /**
     * @var DataTypeInt|\ruhrpottmetaller\DataType\IDataType
     */
    private $Int;

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldReturnSameIntAfterAcceptingInt(): void
    {
        $this->Int = new DataTypeInt(2);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(2, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldReturnConvertibleStringAsIntegerAfterAcceptingString(): void
    {
        $this->Int = new DataTypeInt('33');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(33, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testGetItShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->Int = new DataTypeInt(42);
        $this->Int->set('42');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(42, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Int = new DataTypeInt(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->Int = new DataTypeInt(3);
        $this->Int->set(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('23');
        $this->Int = new DataTypeInt(23);
        $this->Int->Print();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Int = new DataTypeInt(null);
        $this->Int->Print();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testNewShouldAcceptIntAndGetShouldProvideItAgain(): void
    {
        $this->Int = DataTypeInt::new(3);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(3, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(13, DataTypeInt::new(4)->set(13)->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1337');
        DataTypeInt::new(13)->print()->set(37)->print();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = DataTypeInt::new(12)->set(24);
        $this->assertEquals(24, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testShouldReturnStringObject(): void
    {
        $this->Int = DataTypeInt::new(12);
        $this->assertInstanceOf(DataTypeString::class, $this->Int->asString());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testShouldReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = DataTypeInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testShoultReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = DataTypeInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testAsStringShouldBeChainable(): void
    {
        $this->assertIsString(DataTypeInt::new(12)->asString()->get());
        $this->assertEquals('12', DataTypeInt::new(12)->asString()->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testAsStringShouldBeChainableAndSavedToAVariable(): void
    {
        $String = DataTypeInt::new(12)->set(3)->asString();
        $this->assertInstanceOf(DataTypeString::class, $String);
    }
}
