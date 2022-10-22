<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\String;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour;

final class NotNullBehaviourTest extends TestCase
{
    private NotNullBehaviour $isNullBehaviour;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\NotNullBehaviour
     */
    public function testShouldReturnFalse(): void
    {
        $this->isNullBehaviour = new NotNullBehaviour();
        $this->assertIsBool($this->isNullBehaviour->isNull());
        $this->assertEquals(false, $this->isNullBehaviour->isNull());
    }
}
