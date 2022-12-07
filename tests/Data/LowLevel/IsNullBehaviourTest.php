<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\IsNullBehaviour;

final class IsNullBehaviourTest extends TestCase
{
    private IsNullBehaviour $isNullBehaviour;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldReturnTrue(): void
    {
        $this->isNullBehaviour = new IsNullBehaviour();
        $this->assertIsBool($this->isNullBehaviour->isNull());
        $this->assertEquals(true, $this->isNullBehaviour->isNull());
    }
}
