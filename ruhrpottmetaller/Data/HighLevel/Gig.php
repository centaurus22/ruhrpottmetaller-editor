<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class Gig extends AbstractRmObject implements IData
{
    private AbstractRmString $additionalInformation;
    private Band $band;

    public function setBand(Band $band): Gig
    {
        $this->band = $band;
        return $this;
    }

    public function getAdditionalInformation(): AbstractRmString
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(AbstractRmString $additional_information): Gig
    {
        $this->additionalInformation = $additional_information;
        return $this;
    }

    public function getBandName(): AbstractRmString
    {
        return $this->band->getName();
    }

    public function getBandFirstChar(): RmString
    {
        $bandName = $this->band->getName();
        if ($bandName->isNull()) {
            return RmString::new(' ');
        } elseif ($bandName->hasSpecialFirstChar()) {
            return RmString::new('%');
        } else {
            return $bandName->getFirstChar()->asFirstUppercase();
        }
    }

    public function isBandVisible(): AbstractRmBool
    {
        return $this->band->getIsVisible();
    }
}
