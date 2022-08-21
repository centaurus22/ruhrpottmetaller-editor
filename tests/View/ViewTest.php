<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\View;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\View\View;

final class ViewTest extends TestCase
{
    private View $View;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldThrowErrorIfTemplateIsNotAvailable(): void
    {
        $this->View = new View(
            RmString::new('View/'),
            RmString::new('testTemplate')
        );
        $this->expectError();
        $this->expectErrorMessage('Template "View/testTemplate.inc.php" is not available');
        $this->View->getOutput();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldThrowErrorIfAnotherTemplateIsNotAvailable(): void
    {
        $this->View = new View(
            RmString::new('test/'),
            RmString::new('test')
        );
        $this->expectError();
        $this->expectErrorMessage('Template "test/test.inc.php" is not available');
        $this->View->getOutput();
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputTheLoadedTemplate()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate1')
        );
        $output = $this->View->getOutput();
        $this->assertEquals('<div>', substr($output, 0, 5));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputTheImagePath()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate1')
        );
        $output = $this->View->getOutput();
        $this->assertEquals('web/assets/images/', substr($output, 5, 18));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputViaObjectMethod()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate2')
        );
        $this->View->set('value', RmString::new('test'));
        $output = $this->View->getOutput();
        $this->assertEquals('test', substr($output, 5, 4));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldBeInitializeWithStaticNew()
    {
        $this->View = View::new(
            RmString::new('tests/View/'),
            RmString::new('testTemplate2')
        );
        $this->View->set('value', RmString::new('test'));
        $output = $this->View->getOutput();
        $this->assertEquals('test', substr($output, 5, 4));
    }
}
