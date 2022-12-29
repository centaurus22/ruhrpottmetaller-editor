<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{AbstractEvent, Concert, Festival};
use ruhrpottmetaller\Data\LowLevel\{
    Bool\RmBool,
    Date\RmDate,
    Int\RmInt,
    String\RmString
};
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryEventModel extends AbstractModel
{
    private QueryVenueModel $queryVenueDatabaseModel;

    public function __construct(
        ?\mysqli $connection,
        QueryVenueModel $queryVenueDatabaseModel
    ) {
        parent::__construct($connection);
        $this->queryVenueDatabaseModel = $queryVenueDatabaseModel;
    }

    public static function new(
        ?\mysqli $connection,
        QueryVenueModel $queryVenueDatabaseModel
    ): QueryEventModel {
        return new static($connection, $queryVenueDatabaseModel);
    }

    public function getEventsByMonth(RmDate $month): RmArray
    {
        $query = 'SELECT
                event.name AS name,
                date_start,
                number_of_days,
                venue_id,
                url,
                is_sold_out,
                is_canceled
            FROM event
            WHERE date_start LIKE ? ORDER BY date_start;';
        $statement = $this->connection->prepare($query);
        $monthSql = $month->format('Y-m') . '%';
        $statement->bind_param('s', $monthSql);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        $array = RmArray::new();
        while ($object = $result->fetch_object()) {
            if ($object->number_of_days > 1) {
                $dataSet = Festival::new()
                       ->setDateStart(RmDate::new($object->date_start))
                       ->setNumberOfDays(RmInt::new($object->number_of_days));
            } else {
                $dataSet = Concert::new()
                       ->setDate(RmDate::new($object->date_start));
            }

            $dataSet = $this->addGeneralData($dataSet, $object);
            $array->add($dataSet);
        }
        return $array;
    }

    private function addGeneralData(
        AbstractEvent $dataSet,
        stdClass $object
    ): AbstractEvent {
        $venue = $this->queryVenueDatabaseModel
            ->getVenueById(RmInt::new($object->venue_id));
        return $dataSet
           ->setName(RmString::new($object->name))
           ->setVenue($venue)
           ->setUrl(RmString::new($object->url))
           ->setIsSoldOut(RmBool::new($object->is_sold_out))
           ->setIsCanceled(RmBool::new($object->is_canceled));
    }
}
