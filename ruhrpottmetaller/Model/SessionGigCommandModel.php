<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\RmArray;

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
        $_SESSION['gigs']->addAfter($position, Gig::new());
    }

    public function changeGigAt(RmInt $position, RmInt $bandId): void
    {
        if ($bandId->get() == 3) {
            $band = $this->bandModel->getBandById($bandId);
        } else {
            $band = Band::new();
        }
        $gig = Gig::new()->setBand($band);
        $_SESSION['gigs']->set($position, $gig);
    }

    public function deleteGigAt(RmInt $position): void
    {
        $_SESSION['gigs']->deleteAt($position);
    }

    public function shiftUpGigAt(RmInt $position): void
    {
        $_SESSION['gigs']->switch(RmInt::new($position->get() - 1), $position);
    }

    public function shiftDownGigAt(RmInt $position): void
    {
        $_SESSION['gigs']->switch(RmInt::new($position->get() + 1), $position);
    }
}
