<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Gig;
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
        $this->dataSet->setAdditionalInformation(RmString::new('Akoustikkonzert'));
        $this->assertEquals(
            'Akoustikkonzert',
            $this->dataSet->getAdditionalInformation()->get()
        );
    }
}
