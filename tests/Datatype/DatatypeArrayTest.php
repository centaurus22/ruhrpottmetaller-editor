<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Datatype;

use ruhrpottmetaller\Datatype\DatatypeArray;
use ruhrpottmetaller\Datatype\DatatypeInt;
use ruhrpottmetaller\Datatype\IDatatype;
use PHPUnit\Framework\TestCase;

final class DatatypeArrayTest extends TestCase
{
    private DatatypeArray $Array;

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     */
    public function testShouldInitADatatypeArray(): void
    {
        $this->assertInstanceOf(DatatypeArray::class, new DatatypeArray());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     */
    public function testShouldImplementTheIDatatypeInterface(): void
    {
        $this->assertInstanceOf(IDatatype::class, new DatatypeArray());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     */
    public function testNewShouldInitADatatypeArray(): void
    {
        $this->assertInstanceOf(DatatypeArray::class, DatatypeArray::new());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @doesNotPerformAssertions
     */
    public function testAddShouldAcceptVariable(): void
    {
        $this->Array = DatatypeArray::new();
        $this->Array->add(DatatypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue
     */
    public function testGetShouldReturnSameVariable(): void
    {
        $this->Array = DatatypeArray::new();
        $this->Array->add(DatatypeInt::new(3));
        $this->assertEquals(3, $this->Array->get()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue
     */
    public function testAddShouldBeChainable(): void
    {
        $this->Array = DatatypeArray::new();
        $this->assertEquals(
            3,
            $this->Array->add(DatatypeInt::new(3))->get()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue
     */
    public function testShouldReturnTwoVariablesInTheSameOrderAsAdded(): void
    {
        $this->Array = DatatypeArray::new();
        $this->Array->add(DatatypeInt::new(5))->add(DatatypeInt::new(7));
        $this->assertEquals(5, $this->Array->get()->get());
        $this->assertEquals(7, $this->Array->pointAtNext()->get()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue
     */
    public function testIsCurrentShouldReturnTrueIfNextElementIsAvailable(): void
    {
        $this->Array = DatatypeArray::new();
        $this->Array->add(DatatypeInt::new(5));
        $this->assertTrue($this->Array->isCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue
     */
    public function testIsCurrentShouldReturnFalseIfCurrentElementIsNotAvailable(): void
    {
        $this->Array = DatatypeArray::new();
        $this->assertFalse($this->Array->isCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeArray
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue
     */
    public function testGetShouldThrowAnErrorIfCurrentElementIsNotAvailable(): void
    {
        $this->expectExceptionMessage('The Array does not contain data at this position.');
        $this->Array = DatatypeArray::new()->get();
    }
}
