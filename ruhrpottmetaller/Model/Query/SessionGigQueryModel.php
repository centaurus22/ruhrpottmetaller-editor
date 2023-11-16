<?php

namespace ruhrpottmetaller\Model\Query;

use ruhrpottmetaller\Data\RmArray;

class SessionGigQueryModel
{
    protected DatabaseBandQueryModel $bandModel;

    public function __construct()
    {
        session_start();
    }

    public static function new(): SessionGigQueryModel
    {
        return new static;
    }

    public function read(): RmArray
    {
        return $_SESSION['gigs'];
    }
}
