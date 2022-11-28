<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryBandDatabaseModel extends AbstractDatabaseModel
{
    /**
     * @throws \Exception
     */
    public function getBands(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM band ORDER BY name';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        while ($object = $result->fetch_object()) {
            $this->array->add($this->getBandFromDatabaseResult($object));
        }
        return $this->array;
    }

    private function getBandFromDatabaseResult(stdClass $object): Band
    {
        return Band::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
