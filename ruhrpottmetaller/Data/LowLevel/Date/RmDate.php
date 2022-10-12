<?php

namespace ruhrpottmetaller\Data\LowLevel\Date;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class RmDate extends \DateTime implements IDataObject
{
    private bool $isNull;

    public function __construct(?string $value)
    {
        parent::__construct($value);
        $this->processInputValue($value);
    }

    public function __toString()
    {
        if ($this->isNull) {
            return '';
        } else {
            return parent::format('Y-m-d');
        }
    }

    /**
     * @throws \Exception
     */
    public static function new(?string $value): RmDate
    {
        return new self($value);
    }

    public function set(?string $value): RmDate
    {
        parent::modify($value);
        $this->processInputValue($value);
        return $this;
    }

    public function get(): ?string
    {
        if ($this->isNull) {
            return null;
        }

        return parent::format('Y-m-d');
    }

    public function getMonthChangerMenu(): AbstractRmString
    {
        $OneMonth = \DateInterval::createFromDateString('1 month');
        return RmString::new(
            '<div>'
            . $this->getButtonToPreviousMonth($OneMonth)
            . $this->getButtonToCurrentMonth()
            . $this->getButtonToNextMonth($OneMonth)
            . $this->getMonthDisplay()
            . '</div>'
        );
    }

    private function processInputValue(?string $value)
    {
        if (is_null($value)) {
            $this->processNull();
        } else {
            $this->processString();
        }
    }

    private function processString()
    {
        $this->isNull = false;
        parent::setTime('0', '0');
    }

    private function ProcessNull(): void
    {
        $this->isNull = true;
    }
    private function getButtonToPreviousMonth(\DateInterval $OneMonth): string
    {
        $NextMonth = (clone $this)->sub($OneMonth);
        return sprintf(
            '<a href="?month=%1$s"><button>&nbsp;&lt;&lt;&nbsp;</button></a>',
            $NextMonth->format('Y-m')
        );
    }

    private function getButtonToCurrentMonth(): string
    {
        return sprintf(
            '<a href="?month=%1$s"><button>&nbsp;o&nbsp;</button></a>',
            date('Y-m')
        );
    }

    private function getButtonToNextMonth(\DateInterval $OneMonth): string
    {
        $NextMonth = (clone $this)->add($OneMonth);
        return sprintf(
            '<a href="?month=%1$s"><button>&nbsp;&gt;&gt;&nbsp;</button></a>',
            $NextMonth->format('Y-m')
        );
    }

    private function getMonthDisplay(): string
    {
        return '<div>' . $this->format('M Y') . '</div>';
    }
}
