<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class Festival extends AbstractEvent
{
    protected AbstractRmInt $numberOfDays;
    protected RmDate $dateStart;

    public function setDateStart(RmDate $dateStart): Festival
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateStart(): RmDate
    {
        return $this->dateStart;
    }

    public function setNumberOfDays(AbstractRmInt $numberOfDays): Festival
    {
        $this->numberOfDays = $numberOfDays;
        return $this;
    }

    public function getNumberOfDays(): AbstractRmInt
    {
        return $this->numberOfDays;
    }

    /**
     * @throws \Exception
     */
    public function getFormattedDate(): AbstractRmString
    {
        $numberOfDays = new \DateInterval('P' . ($this->numberOfDays->get() - 1) . 'D');
        $formattedDateStart = $this->dateStart->getFormatted('D, d.');
        $formattedDateEnd = $this->dateStart->add($numberOfDays)
            ->getFormatted('D, d.');
        return RmString::new('<div class="rm_table_cell">')
            ->concatWith($formattedDateStart)
            ->concatWith(RmString::new(' – '))
            ->concatWith($formattedDateEnd)
            ->concatWith(RmString::new('</div>'));
    }
}
