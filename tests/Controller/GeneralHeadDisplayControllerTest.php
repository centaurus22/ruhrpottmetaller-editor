<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\EventMainDisplayController;
use ruhrpottmetaller\Controller\GeneralHeadDisplayController;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class GeneralHeadDisplayControllerTest extends TestCase
{
    private GeneralHeadDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\GeneralHeadDisplayController
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\View\View
     */
    public function testShouldSetPageName()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new GeneralHeadDisplayController(
            $BaseView,
            RmString::new('events')
        );

        $this->Controller->render();

        $this->assertArrayHasKey('pageName', $this->Controller->getViewData());
        $this->assertInstanceOf(
            RmString::class,
            ($this->Controller->getViewData())['pageName']
        );
        $this->assertInstanceOf(
            RmString::class,
            ($this->Controller->getViewData()['pageName'])
        );

        $this->assertEquals('events', $this->Controller->getViewData()['pageName']);
    }
}
