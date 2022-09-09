<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmDate;

final class RmDateTest extends TestCase
{
    public RmDate $Date;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnCurrentDateAfterAcceptingEmptyString(): void
    {
        $this->Date = new RmDate('');
        $this->assertEquals(date('Y-m-d'), $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnSameDateStringAfterAcceptingDateString(): void
    {
        $this->Date = new RmDate('2020-03-01');
        $this->assertEquals('2020-03-01', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Date = new RmDate(null);
        $this->assertTrue(is_null($this->Date->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnDateStringAfterAcceptingDateStringBySetId(): void
    {
        $this->Date = new RmDate('');
        $this->Date->set('2020-04-23');
        $this->assertEquals('2020-04-23', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('2022-10-09');
        $this->Date = new RmDate('2022-10-09');
        echo $this->Date;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Date = new RmDate(null);
        echo $this->Date;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @throws \Exception
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->Date = RmDate::new('2020-10-11');
        $this->assertEquals('2020-10-11', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @throws \Exception
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            '2001-02-01',
            RmDate::new('2011-02-03')->set('2001-02-01')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @throws \Exception
     */
    public function testGetShouldReturnLastChainedSetAfterInitializedWithNull(): void
    {
        $this->assertEquals(
            '2001-02-01',
            RmDate::new(null)->set('2001-02-01')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @throws \Exception
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Date = RmDate::new('1982-02-01')->set('1992-12-12');
        $this->assertEquals('1992-12-12', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @throws \Exception
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('2010-05-05');
        echo RmDate::new('2010-01-01')->set('2010-05-05');
    }
}
