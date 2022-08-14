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
        $this->Date = new \ruhrpottmetaller\Data\LowLevel\RmDate('');
        $this->assertEquals(date('Y-m-d'), $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnSameDateStringAfterAcceptingDateString(): void
    {
        $this->Date = new \ruhrpottmetaller\Data\LowLevel\RmDate('2020-03-01');
        $this->assertEquals('2020-03-01', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Date = new \ruhrpottmetaller\Data\LowLevel\RmDate(null);
        $this->assertTrue(is_null($this->Date->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldReturnDateStringAfterAcceptingDateStringBySetId(): void
    {
        $this->Date = new \ruhrpottmetaller\Data\LowLevel\RmDate('');
        $this->Date->set('2020-04-23');
        $this->assertEquals('2020-04-23', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('2022-10-09');
        $this->Date = new \ruhrpottmetaller\Data\LowLevel\RmDate('2022-10-09');
        $this->Date->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Date = new \ruhrpottmetaller\Data\LowLevel\RmDate(null);
        $this->Date->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->Date = \ruhrpottmetaller\Data\LowLevel\RmDate::new('2020-10-11');
        $this->assertEquals('2020-10-11', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
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
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Date = RmDate::new('1982-02-01')->set('1992-12-12');
        $this->assertEquals('1992-12-12', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('2010-01-012010-05-05');
        RmDate::new('2010-01-01')->print()->set('2010-05-05')->print();
    }
}
