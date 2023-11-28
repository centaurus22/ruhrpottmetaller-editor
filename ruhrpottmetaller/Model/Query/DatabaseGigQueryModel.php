<?php

namespace ruhrpottmetaller\Model\Query;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class DatabaseGigQueryModel extends DatabaseQueryModel
{
    private DatabaseBandQueryModel $bandQueryModel;

    public function __construct(
        ?mysqli $connection,
        DatabaseBandQueryModel $bandQueryModel
    ) {
        $this->bandQueryModel = $bandQueryModel;
        parent::__construct($connection);
    }

    public static function new(
        ?mysqli $connection,
        DatabaseBandQueryModel $bandQueryModel
    ): DatabaseGigQueryModel {
        return new static($connection, $bandQueryModel);
    }

    public function getGigsByEventId(AbstractRmInt $eventId): RmArray
    {
        $query = 'SELECT band_id, additional_information FROM gig
                        WHERE event_id = ? ORDER BY id';
        return $this->query($query, 'i', [$eventId->get()]);
    }

    protected function getDataFromResult(stdClass $object): Gig
    {
        return Gig::new()
            ->setAdditionalInformation(RmString::new($object->additional_information))
            ->setBand($this->bandQueryModel->getBandById(RmInt::new($object->band_id)));
    }
}
