<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;

abstract class Event extends AbstractNamedHighLevelData implements IEvent
{
    protected AbstractRmInt $numberOfDays;
    protected RmArray $gigs;
    protected IVenue $venue;
    protected AbstractRmString $url;
    protected AbstractRmBool $isSoldOut;
    protected AbstractRmBool $isCanceled;

    public function __construct()
    {
        $this->gigs = RmArray::new();
    }

    public function setVenue(IVenue $venue): Event
    {
        $this->venue = $venue;
        return $this;
    }

    public function setUrl(AbstractRmString $url): Event
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl(): AbstractRmString
    {
        return $this->url;
    }

    public function setIsSoldOut(AbstractRmBool $isSoldOut): Event
    {
        $this->isSoldOut = $isSoldOut;
        return $this;
    }

    public function getIsSoldOut(): AbstractRmBool
    {
        return $this->isSoldOut;
    }

    public function setIsCanceled(AbstractRmBool $isCanceled): Event
    {
        $this->isCanceled = $isCanceled;
        return $this;
    }

    public function getIsCanceled(): AbstractRmBool
    {
        return $this->isCanceled;
    }

    public function getVenueId(): AbstractRmInt
    {
        return $this->venue->getId();
    }

    public function getVenue(): IVenue
    {
        return $this->venue;
    }

    public function getCityId(): AbstractRmInt
    {
        return $this->venue->getCityId();
    }

    public function getVenueAndCityName(): AbstractRmString
    {
        return $this->venue->asVenueAndCity();
    }

    public function getFormattedVenueAndCityName(): AbstractRmString
    {
        return $this->venue->getFormattedVenueAndCity();
    }

    public function addGigs(RmArray $gigs): Event
    {
        $this->gigs = $gigs;
        return $this;
    }

    public function getGigs(): RmArray
    {
        return $this->gigs;
    }

    public function getBandList(): RmString
    {
        $bandList = RmString::new('');
        while ($this->gigs->hasCurrent()) {
            if ($this->gigs->isFirst()) {
                $bandList = $this->getFormattedBandName();
            } else {
                $bandList->concatWith(RmString::new(', '))->concatWith($this->getFormattedBandName());
            }
            $this->gigs->pointAtNext();
        }
        return $bandList;
    }

    private function getFormattedBandName(): RmString
    {
        if ($this->gigs->getCurrent()->isBandVisible()->get()) {
            return $this->gigs
                ->getCurrent()
                ->getBandName()
                ->concatWith($this->getFormattedAdditionalInformation());
        }
        return RmString::new('<span class="invisible">')
            ->concatWith($this->gigs->getCurrent()->getBandName())
            ->concatWith(RmString::new('</span>'))
            ->concatWith($this->getFormattedAdditionalInformation());
    }

    private function getFormattedAdditionalInformation(): RmString
    {
        if ($this->gigs->getCurrent()->getAdditionalInformation()->isEmpty()) {
            return RmString::new('');
        }

        return RmString::new(' (' . $this->gigs->getCurrent()->getAdditionalInformation()->get() . ')');
    }
}
