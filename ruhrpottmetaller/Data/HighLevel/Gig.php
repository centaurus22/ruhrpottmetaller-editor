<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

class Gig extends AbstractRmObject implements IData
{
    private AbstractRmString $additionalInformation;

    public function getAdditionalInformation(): AbstractRmString
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(AbstractRmString $additional_information): Gig
    {
        $this->additionalInformation = $additional_information;
        return $this;
    }
}
