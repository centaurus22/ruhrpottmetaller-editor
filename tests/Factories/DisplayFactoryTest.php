<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\BaseDisplayController;
use ruhrpottmetaller\Factories\DisplayFactory;
use PHPUnit\Framework\TestCase;

class DisplayFactoryTest extends TestCase
{
    public DisplayFactory $DisplayFactory;

    /**
     * @covers \ruhrpottmetaller\Factories\DisplayFactory
     * @uses  \ruhrpottmetaller\Controller\AbstractDisplayController
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\RmString
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
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\RmString
     **/
    public function testNewShouldCreateDisplayFactory()
    {
        $this->DisplayFactory = DisplayFactory::new();
        $this->assertInstanceOf(
            DisplayFactory::class,
            $this->DisplayFactory
        );
    }
    /**
     * @covers \ruhrpottmetaller\Factories\DisplayFactory
     * @uses  \ruhrpottmetaller\Controller\AbstractDisplayController
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\RmString
     * @uses  \ruhrpottmetaller\View\View
     **/
    public function testShouldGetBaseDisplayController()
    {
        $this->DisplayFactory = new DisplayFactory();
        $this->assertInstanceOf(
            BaseDisplayController::class,
            $this->DisplayFactory->getDisplayController([])
        );
    }
}
