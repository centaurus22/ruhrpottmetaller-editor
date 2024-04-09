<?php

namespace tests\ruhrpottmetaller\Model\Command;

use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class SessionGigCommandModelMock extends SessionGigCommandModel
{
    public function __construct(DatabaseBandQueryModel $bandQueryModel)
    {
        $this->bandModel = $bandQueryModel;
    }
}
