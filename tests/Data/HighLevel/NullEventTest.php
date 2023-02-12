<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\NullEvent;

final class NullEventTest extends TestCase
{
    private NullEvent $dataSet;

    protected function setUp(): void
    {
        $this->dataSet = NullEvent::new();
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */
    public function testShouldGetName(): void
    {
        $this->assertTrue($this->dataSet->getName()->isNull());
    }
}
