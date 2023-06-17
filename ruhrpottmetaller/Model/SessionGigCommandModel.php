<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\RmArray;

class SessionGigCommandModel
{
    private DatabaseBandQueryModel $bandModel;

    public function __construct(DatabaseBandQueryModel $bandModel)
    {
        $this->bandModel = $bandModel;
        session_start();
    }

    public function load(RmArray $gigs): void
    {
        $_SESSION['gigs'] = $gigs;
    }

    public function read(): RmArray
    {
        return $_SESSION['gigs'];
    }

    public function addGigAfter(RmInt $position): void
    {
        $_SESSION['gigs']->addAfter($position, Gig::new());
    }

    public function changeGigAt(RmInt $position, RmInt $bandId): void
    {
        $gig = Gig::new()->setBand($this->bandModel->getBandById($bandId));
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
