<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\DataType;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeString;
use ruhrpottmetaller\DataType\IDataType;
use PHPUnit\Framework\TestCase;

final class EventQueryControllerTest extends TestCase
{
    private \ruhrpottmetaller\Controller\EventQueryController $Controller;

    /**
     * @covers \ruhrpottmetaller\Controller\AbstractEventController
     * @covers \ruhrpottmetaller\Controller\EventQueryController
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     */
    public function testShouldSetIdAndGetTheSameId(): void
    {
        $this->Controller = \ruhrpottmetaller\Controller\EventQueryController::new();
        $this->Controller->setId(DataTypeInt::new(23));
        $this->assertEquals(23, $this->Controller->getId()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Controller\EventQueryController
     * @covers \ruhrpottmetaller\Controller\AbstractEventController
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testShouldThrowTypeErrorIfNoDataTypeIntIsSetToId(): void
    {
        $this->expectException(\TypeError::class);
        $this->Controller = \ruhrpottmetaller\Controller\EventQueryController::new();
        $this->Controller->setId(DataTypeString::new('Iron Maiden'));
    }
}
