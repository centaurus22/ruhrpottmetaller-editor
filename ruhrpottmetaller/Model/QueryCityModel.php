<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{ICity, City, NullCity};
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\{AbstractRmInt, RmInt};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryCityModel extends AbstractQueryModel
{
    public static function new(?\mysqli $connection): QueryCityModel
    {
        return new static($connection);
    }

    public function getCities(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM city ORDER BY name';
        return $this->query($query);
    }



    public function getCityById(AbstractRmInt $cityId): ICity
    {
        if ($cityId->isNull()) {
            return NullCity::new();
        }

        $query = 'SELECT id, name, is_visible FROM city WHERE id = ?';
        return $this->queryOne($query, 'i', [$cityId->get()]);
    }

    protected function getDataFromResult(stdClass $object): ICity
    {
        return City::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
