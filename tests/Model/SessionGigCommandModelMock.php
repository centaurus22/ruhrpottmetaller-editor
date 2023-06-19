<?php

namespace tests\ruhrpottmetaller\Model;

use ruhrpottmetaller\Model\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\SessionGigCommandModel;

class SessionGigCommandModelMock extends SessionGigCommandModel
{
    public function __construct(DatabaseBandQueryModel $bandQueryModel)
    {
        $this->bandModel = $bandQueryModel;
    }
}
