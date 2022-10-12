<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Date;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;

final class RmDateTest extends TestCase
{
    public RmDate $Date;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldReturnCurrentDateAfterAcceptingEmptyString(): void
    {
        $this->Date = new RmDate('');
        $this->assertEquals(date('Y-m-d'), $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldReturnSameDateStringAfterAcceptingDateString(): void
    {
        $this->Date = new RmDate('2020-03-01');
        $this->assertEquals('2020-03-01', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Date = new RmDate(null);
        $this->assertTrue(is_null($this->Date->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldReturnDateStringAfterAcceptingDateStringBySetId(): void
    {
        $this->Date = new RmDate('');
        $this->Date->set('2020-04-23');
        $this->assertEquals('2020-04-23', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('2022-10-09');
        $this->Date = new RmDate('2022-10-09');
        echo $this->Date;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Date = new RmDate(null);
        echo $this->Date;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @throws \Exception
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->Date = RmDate::new('2020-10-11');
        $this->assertEquals('2020-10-11', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
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
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
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
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @throws \Exception
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Date = RmDate::new('1982-02-01')->set('1992-12-12');
        $this->assertEquals('1992-12-12', $this->Date->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @throws \Exception
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('2010-05-05');
        echo RmDate::new('2010-01-01')->set('2010-05-05');
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @throws \Exception
     *@uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldPrintMonthChangerMenu()
    {
        $month = date('Y-m');
        $buttonToPreviousMonth = '<a href="?month=2022-09"><button>&nbsp;&lt;&lt;&nbsp;</button></a>';
        $buttonToCurrentMonth = sprintf(
            '<a href="?month=%1$s"><button>&nbsp;o&nbsp;</button></a>',
            $month
        );
        $buttonToNextMonth = '<a href="?month=2022-11"><button>&nbsp;&gt;&gt;&nbsp;</button></a>';
        $monthDisplay = '<div>Oct 2022</div>';
        $this->assertEquals(
            '<div>' . $buttonToPreviousMonth . $buttonToCurrentMonth . $buttonToNextMonth . $monthDisplay . '</div>',
            RmDate::new('2022-10')->getMonthChangerMenu()->get()
        );
    }
}
