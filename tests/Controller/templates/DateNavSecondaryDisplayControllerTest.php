<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\templates;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\DateNavSecondaryDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class DateNavSecondaryDisplayControllerTest extends TestCase
{
    private DateNavSecondaryDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CharNavSecondaryDisplayController
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
