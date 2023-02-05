<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class BandQueryModel extends AbstractQueryModel
{
    public static function new(?\mysqli $connection)
    {
        return new static($connection);
    }

    public function getBands(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM band ORDER BY name';
        return $this->query($query);
    }

    public function getBandsByFirstChar(RmString $firstChar): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM band WHERE name LIKE ? ORDER BY name';
        return $this->query($query, 's', [$firstChar->get() . '%']);
    }

    public function getBandsWithSpecialChar(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM band WHERE name NOT REGEXP "^[A-Z]" ORDER BY name';
        return $this->query($query);
    }

    public function getBandById(RmInt $id): Band
    {
        $query = 'SELECT id, name, is_visible FROM band WHERE id = ?';
        return $this->queryOne($query, 'i', [$id->get()]);
    }

    protected function getDataFromResult(stdClass $object): Band
    {
        return Band::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
