<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class GigQueryModel extends AbstractQueryModel
{
    private BandQueryModel $bandQueryModel;

    public function __construct(
        BandQueryModel $bandQueryModel,
        ?\mysqli $connection
    ) {
        $this->bandQueryModel = $bandQueryModel;
        parent::__construct($connection);
    }

    public static function new(
        BandQueryModel $bandQueryModel,
        ?\mysqli $connection
    ): GigQueryModel {
        return new static($bandQueryModel, $connection);
    }

    public function getGigsByEventId(RmInt $eventId): RmArray
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
