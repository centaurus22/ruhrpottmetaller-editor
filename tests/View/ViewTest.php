<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\View;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\DataType\DataTypeString;
use ruhrpottmetaller\View\View;

final class ViewTest extends TestCase
{
    private View $View;

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldThrowErrorIfTemplateIsNotAvailable(): void
    {
        $this->View = new View(
            DataTypeString::new('View/'),
            DataTypeString::new('testTemplate')
        );
        $this->expectError();
        $this->expectErrorMessage('Template "View/testTemplate.inc.php" is not available');
        $this->View->getOutput();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldThrowErrorIfAnotherTemplateIsNotAvailable(): void
    {
        $this->View = new View(
            DataTypeString::new('test/'),
            DataTypeString::new('test')
        );
        $this->expectError();
        $this->expectErrorMessage('Template "test/test.inc.php" is not available');
        $this->View->getOutput();
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldOutputTheLoadedTemplate()
    {
        $this->View = new View(
            DataTypeString::new('tests/View/'),
            DataTypeString::new('testTemplate1')
        );
        $output = $this->View->getOutput();
        $this->assertEquals('<div>', substr($output, 0, 5));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldOutputTheImagePath()
    {
        $this->View = new View(
            DataTypeString::new('tests/View/'),
            DataTypeString::new('testTemplate1')
        );
        $output = $this->View->getOutput();
        $this->assertEquals('web/assets/images/', substr($output, 5, 18));
    }

    /**
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldOutputViaObjectMethod()
    {
        $this->View = new View(
            DataTypeString::new('tests/View/'),
            DataTypeString::new('testTemplate2')
        );
        $this->View->set('value', DataTypeString::new('test'));
        $output = $this->View->getOutput();
        $this->assertEquals('test', substr($output, 5, 4));
    }
}
