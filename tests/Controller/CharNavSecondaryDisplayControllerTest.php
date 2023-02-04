<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\CharNavSecondaryDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class CharNavSecondaryDisplayControllerTest extends TestCase
{
    private CharNavSecondaryDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CharNavSecondaryDisplayController
     */
    public function testShouldSetCityList()
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
