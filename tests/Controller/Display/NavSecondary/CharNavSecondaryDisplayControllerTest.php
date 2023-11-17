<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display\NavSecondary;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\NavSecondary\CharNavSecondaryDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class CharNavSecondaryDisplayControllerTest extends TestCase
{
    private CharNavSecondaryDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\NavSecondary\CharNavSecondaryDisplayController
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\View\View
     */
    public function testShouldSetListOfFirstChars()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new CharNavSecondaryDisplayController(
            $BaseView
        );

        $this->Controller
            ->setGetParameters(RmString::new(null), RmString::new(null))
            ->render();

        $this->assertArrayHasKey('firstChars', $this->Controller->getViewData());
        $this->assertInstanceOf(
            RmArray::class,
            ($this->Controller->getViewData())['firstChars']
        );
        $this->assertInstanceOf(
            RmString::class,
            ($this->Controller->getViewData()['firstChars'])->getCurrent()
        );
    }
}
