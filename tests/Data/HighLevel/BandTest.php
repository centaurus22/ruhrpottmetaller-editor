<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

final class BandTest extends TestCase
{
    private Band $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldSetNameAndGetSameNameBack(): void
    {
        $this->DataSet = Band::new();
        $this->DataSet->setName(RmString::new('Iron Kobra'));
        $this->assertEquals(
            'Iron Kobra',
            $this->DataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldSetIdAndGetSameIdBack(): void
    {
        $this->DataSet = Band::new();
        $this->DataSet->setId(RmInt::new(21));
        $this->assertEquals(
            '21',
            $this->DataSet->getId()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     */
    public function testShouldSetIsVisibleAndGetSameIsVisibleValue(): void
    {
        $this->DataSet = Band::new();
        $this->DataSet->setIsVisible(RmBool::new(true));
        $this->assertEquals(
            true,
            $this->DataSet->getIsVisible()->get()
        );
    }
}
