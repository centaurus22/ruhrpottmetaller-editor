<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\GeneralHeadDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

final class GeneralHeadDisplayControllerTest extends TestCase
{
    private GeneralHeadDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\GeneralHeadDisplayController
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
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
