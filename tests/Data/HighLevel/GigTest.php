<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class GigTest extends TestCase
{
    private Gig $dataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Gig
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetAdditionalInformationStringAndGetSameStringBack(): void
    {
        $this->dataSet = Gig::new();
        $this->dataSet->setAdditionalInformation(RmString::new('Akustikkonzert'));
        $this->assertEquals(
            'Akustikkonzert',
            $this->dataSet->getAdditionalInformation()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Gig
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetBandAndGetBandName(): void
    {
        $band = Band::new()->setName(RmString::new('Sabiendas'));
        $this->dataSet = Gig::new()->setBand($band);
        $this->assertEquals(
            'Sabiendas',
            $this->dataSet->getBandName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Gig
     * @covers \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     */
    public function testShouldGetBandVisibleStatus(): void
    {
        $band = Band::new()->setIsVisible(RmBool::new(true));
        $this->dataSet = Gig::new()->setBand($band);
        $this->assertTrue(
            $this->dataSet->isBandVisible()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Gig
     * @uses  \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     */
    public function testShouldGetBandVisibleStatusIfInvisible(): void
    {
        $band = Band::new()
            ->setIsVisible(RmBool::new(false));
        $this->dataSet = Gig::new()->setBand($band);
        $this->assertFalse(
            $this->dataSet->isBandVisible()->get()
        );
    }
}
