<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\NotNullBehaviour;

final class NotNullBehaviourTest extends TestCase
{
    private NotNullBehaviour $isNullBehaviour;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnFalse(): void
    {
        $this->isNullBehaviour = new NotNullBehaviour();
        $this->assertIsBool($this->isNullBehaviour->isNull());
        $this->assertEquals(false, $this->isNullBehaviour->isNull());
    }
}
