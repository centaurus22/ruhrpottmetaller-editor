<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Factories;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Factories\DisplayFactory;

class DisplayFactoryTest extends TestCase
{
    public DisplayFactory $DisplayFactory;

    /**
     * @covers \ruhrpottmetaller\Factories\DisplayFactory
     * @uses  \ruhrpottmetaller\Controller\AbstractDisplayController
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     **/
    public function testShouldCreateDisplayFactory()
    {
        $this->DisplayFactory = new DisplayFactory();
        $this->assertInstanceOf(
            DisplayFactory::class,
            $this->DisplayFactory
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Factories\DisplayFactory
     * @uses  \ruhrpottmetaller\Controller\AbstractDisplayController
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     **/
    public function testNewShouldCreateDisplayFactory()
    {
        $this->DisplayFactory = DisplayFactory::new();
        $this->assertInstanceOf(
            DisplayFactory::class,
            $this->DisplayFactory
        );
    }
}
