<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\DataType\DataTypeArray;
use ruhrpottmetaller\DataType\DataTypeString;
use ruhrpottmetaller\DataType\DataTypeBool;
use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeDate;
use ruhrpottmetaller\DataSet\AbstractEventDataSet;
use ruhrpottmetaller\DataSet\QueryConcertDataSet;
use ruhrpottmetaller\DataSet\QueryFestivalDataSet;

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
                $DataSet = QueryFestivalDataSet::new()
                       ->setDateStart(DataTypeDate::new($Object->date_start))
                       ->setNumberOfDays(DataTypeInt::new($Object->number_days));
            } else {
                $DataSet = QueryConcertDataSet::new()
                       ->setDate(DataTypeDate::new($Object->date_start));
            }

            $DataSet = $this->addGeneralData($DataSet, $Object);
            $this->Array->add($DataSet);
        }
        return $this->Array;
    }

    private function addGeneralData(
        AbstractEventDataSet $DataSet,
        \stdClass $Object
    ): AbstractEventDataSet {
        return $DataSet->setName(DataTypeString::new($Object->name))
                       ->setVenueName(DataTypeString::new($Object->venue_name))
                       ->setCityName(DataTypeString::new($Object->city_name))
                       ->setUrl(DataTypeString::new($Object->url))
                       ->setIsSoldOut(DataTypeBool::new($Object->is_sold_out))
                       ->setIsCanceled(DataTypeBool::new($Object->is_canceled));
    }
}
