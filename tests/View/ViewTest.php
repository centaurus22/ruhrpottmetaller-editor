<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\View;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

final class ViewTest extends TestCase
{
    private View $View;

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
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
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldOutputTheLoadedTemplate()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate1')
        );
        $output = $this->View->getOutput()->get();
        $this->assertEquals('<div>', substr($output, 0, 5));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldOutputTheImagePath()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate1')
        );
        $output = $this->View->getOutput()->get();
        $this->assertEquals('web/assets/images/', substr($output, 5, 18));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldGetTheRenderedTemplate()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate2')
        );
        $this->View->set('value', RmString::new('test'));
        $output = $this->View->getOutput()->get();
        $this->assertEquals('test', substr($output, 5, 4));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldBeInitializeWithStaticNew()
    {
        $this->View = View::new(
            RmString::new('tests/View/'),
            RmString::new('testTemplate2')
        );
        $this->View->set('value', RmString::new('test'));
        $output = $this->View->getOutput()->get();
        $this->assertEquals('test', substr($output, 5, 4));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldOverwriteTemplate()
    {
        $this->View = new View(
            RmString::new('tests/View/'),
            RmString::new('testTemplate2')
        );
        $this->View
            ->setTemplate(RmString::new('testTemplate2'))
            ->set('value', RmString::new('test'));
        $output = $this->View->getOutput()->get();
        $this->assertEquals('test', substr($output, 5, 4));
    }
}
