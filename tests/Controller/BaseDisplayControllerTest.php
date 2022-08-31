<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\BaseDisplayController;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\View\View;

final class BaseDisplayControllerTest extends TestCase
{
    private BaseDisplayController $Controller;

   /**
    * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
    * @covers \ruhrpottmetaller\Data\LowLevel\RmString
    * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
    * @covers \ruhrpottmetaller\Controller\BaseDisplayController
    */
    public function testShouldAddSubController()
    {
        $View = View::new(RmString::new(null), RmString::new(null));
        $this->expectNotToPerformAssertions();
        $this->Controller = BaseDisplayController::new($View);
        $SubController = BaseDisplayController::new($View);
        $this->Controller->addSubController(
            'subController',
            $SubController
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\BaseDisplayController
     * @covers \ruhrpottmetaller\View\View
     */
    public function testShouldRender()
    {
        $View = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );
        $this->Controller = BaseDisplayController::new($View);
        $this->assertEquals('This is a concert.', $this->Controller->render()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\BaseDisplayController
     * @covers \ruhrpottmetaller\View\View
     */
    public function testShouldRenderASubControllers()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testBaseTemplate1')
        );
        $SubView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );
        $this->Controller = BaseDisplayController::new($BaseView)->addSubController(
                'sub1',
                BaseDisplayController::new($SubView)
            );
        $output = $this->Controller->render()->get();
        $this->assertEquals(
            'This is a concert. This is a concert.',
            $output
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\BaseDisplayController
     * @covers \ruhrpottmetaller\View\View
     */
    public function testShouldRenderTwoSubControllers()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testBaseTemplate2')
        );
        $SubView1 = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );
        $SubView2 = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );
        $this->Controller = BaseDisplayController::new($BaseView)->addSubController(
            'sub1',
            BaseDisplayController::new($SubView1)
        );
        $this->Controller->addSubController(
            'sub2',
            BaseDisplayController::new($SubView2)
        );
        $output = $this->Controller->render()->get();
        $this->assertEquals(
            'This is a concert. This is a concert. This is a concert.',
            $output
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\BaseDisplayController
     * @covers \ruhrpottmetaller\View\View
     */
    public function testShouldSetMenu()
    {
        $this->expectExceptionMessage('The Array does not contain data at this position.');
        $BaseView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );

        $this->Controller = BaseDisplayController::new($BaseView);
        $this->Controller->render();
        $menu = ($this->Controller->getViewData())['menu'];
        $this->assertIsObject($menu);
        $this->assertEquals('events', $menu->getCurrent()->get());
        $menu->pointAtNext();
        $this->assertEquals('bands', $menu->getCurrent()->get());
        $menu->pointAtNext();
        $this->assertEquals('cities', $menu->getCurrent()->get());
        $menu->pointAtNext();
        $this->assertEquals('venues', $menu->getCurrent()->get());
        $menu->pointAtNext();
        $menu->getCurrent();
    }
}