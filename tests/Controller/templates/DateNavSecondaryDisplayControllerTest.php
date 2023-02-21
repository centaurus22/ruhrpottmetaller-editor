<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\templates;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\DateNavSecondaryDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

final class DateNavSecondaryDisplayControllerTest extends TestCase
{
    private DateNavSecondaryDisplayController $Controller;

    /**
     * @covers   \ruhrpottmetaller\AbstractRmObject
     * @covers  \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\DateNavSecondaryDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldSetListOfFirstChars()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new DateNavSecondaryDisplayController(
            $BaseView
        );

        $this->Controller
            ->setGetParameters(RmString::new('2022-10-11'), RmString::new(null))
            ->render();

        $this->assertArrayHasKey('filterByParameter', $this->Controller->getViewData());
    }
}
