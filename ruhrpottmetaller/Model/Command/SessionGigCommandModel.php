<?php

namespace ruhrpottmetaller\Model\Command;

use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\HighLevel\NullBand;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class SessionGigCommandModel
{
    protected DatabaseBandQueryModel $bandModel;

    public function __construct(DatabaseBandQueryModel $bandQueryModel)
    {
        $this->bandModel = $bandQueryModel;
        session_start();
    }

    public static function new(DatabaseBandQueryModel $bandQueryModel): SessionGigCommandModel
    {
        return new static($bandQueryModel);
    }

    public function load(RmArray $gigs): void
    {
        $_SESSION['gigs'] = $gigs;
    }

    public function addGigAfter(RmInt $position): void
    {
        $band = NullBand::new();
        $gig = Gig::new()->setBand($band)->setAdditionalInformation(RmString::new(null));
        $_SESSION['gigs']->addAfter($position, $gig);
    }

    public function changeGigAt(RmInt $position, RmInt $bandId): void
    {
        $band = $this->bandModel->getBandById($bandId);
        $_SESSION['gigs']->get($position)->setBand($band);
    }

    public function deleteGigAt(RmInt $position): void
    {
        $_SESSION['gigs']->delete($position);
    }

    public function shiftGigUpAt(RmInt $position): void
    {
        $_SESSION['gigs']->switch(RmInt::new($position->get() - 1), $position);
    }

    public function shiftGigDownAt(RmInt $position): void
    {
        $_SESSION['gigs']->switch(RmInt::new($position->get() + 1), $position);
    }

    public function setBandNewName(RmInt $position, RmString $bandNewName): void
    {
        $_SESSION['gigs']->get($position)->setBandNewName($bandNewName);
    }

    public function setAdditionalInformation(
        RmInt $position,
        RmString $additionalInformation
    ): void {
        $_SESSION['gigs']->get($position)->setAdditionalInformation($additionalInformation);
    }
}
