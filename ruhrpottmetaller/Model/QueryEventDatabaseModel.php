<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\AbstractEvent;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\DataTypeArray;
use ruhrpottmetaller\Data\LowLevel\DataTypeBool;
use ruhrpottmetaller\Data\LowLevel\DataTypeDate;
use ruhrpottmetaller\Data\LowLevel\DataTypeInt;
use ruhrpottmetaller\Data\LowLevel\DataTypeString;

class QueryEventDatabaseModel extends AbstractDatabaseModel
{
    public function __construct(\mysqli $Connection, DataTypeArray $Array)
    {
        parent::__construct($Connection, $Array);
    }

    public function getEventsByMonth(DataTypeString $Month): DataTypeArray
    {
        $query = 'SELECT event.name AS name, date_start, number_days,
            venue.name AS venue_name, city.name AS city_name, url,
            is_sold_out, is_canceled
            FROM event
            LEFT JOIN venue ON event.venue_id = venue.id
            LEFT JOIN city ON venue.city_id = city.id
            WHERE date_start LIKE ?';
        $Statement = $this->Connection->prepare($query);
        $month = $Month->get() . '%';
        $Statement->bind_param('s', $month);
        $Statement->execute();
        $Result = $Statement->get_result();
        $Statement->close();

        while ($Object = $Result->fetch_object()) {
            if ($Object->number_days > 1) {
                $DataSet = Festival::new()
                       ->setDateStart(DataTypeDate::new($Object->date_start))
                       ->setNumberOfDays(DataTypeInt::new($Object->number_days));
            } else {
                $DataSet = Concert::new()
                       ->setDate(DataTypeDate::new($Object->date_start));
            }

            $DataSet = $this->addGeneralData($DataSet, $Object);
            $this->Array->add($DataSet);
        }
        return $this->Array;
    }

    private function addGeneralData(
        AbstractEvent $DataSet,
        \stdClass     $Object
    ): AbstractEvent {
        return $DataSet->setName(DataTypeString::new($Object->name))
                       ->setVenueName(DataTypeString::new($Object->venue_name))
                       ->setCityName(DataTypeString::new($Object->city_name))
                       ->setUrl(DataTypeString::new($Object->url))
                       ->setIsSoldOut(DataTypeBool::new($Object->is_sold_out))
                       ->setIsCanceled(DataTypeBool::new($Object->is_canceled));
    }
}
