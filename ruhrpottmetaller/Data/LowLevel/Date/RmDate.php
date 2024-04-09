<?php

namespace ruhrpottmetaller\Data\LowLevel\Date;

use DateInterval;
use Exception;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString};

class RmDate extends \DateTime implements IData
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

    public function getFormatted(string $format = 'Y-m-d'): AbstractRmString
    {
        return RmString::new(parent::format($format));
    }

    public function getMonthChangerMenu(): AbstractRmString
    {
        $oneMonth = DateInterval::createFromDateString('1 month');
        return RmString::new(
            $this->getButtonToPreviousMonth($oneMonth)
            . $this->getButtonToCurrentMonth()
            . $this->getButtonToNextMonth($oneMonth)
            . $this->getMonthDisplay()
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

    private function processNull(): void
    {
        $this->isNull = true;
    }

    private function getButtonToPreviousMonth(DateInterval $oneMonth): string
    {
        $NextMonth = (clone $this)->sub($oneMonth);
        return sprintf(
            '<a href="?filter_by=%1$s"><button>&nbsp;&lt;&lt;&nbsp;</button></a>',
            $NextMonth->format('Y-m')
        );
    }

    private function getButtonToCurrentMonth(): string
    {
        return sprintf(
            '<a href="?filter_by=%1$s"><button>&nbsp;o&nbsp;</button></a>',
            date('Y-m')
        );
    }

    private function getButtonToNextMonth(DateInterval $oneMonth): string
    {
        $nextMonth = (clone $this)->add($oneMonth);
        return sprintf(
            '<a href="?filter_by=%1$s"><button>&nbsp;&gt;&gt;&nbsp;</button></a>',
            $nextMonth->format('Y-m')
        );
    }

    private function getMonthDisplay(): string
    {
        return '<div>' . $this->format('M Y') . '</div>';
    }
}
