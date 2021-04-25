<?php


namespace ruhrpottmetaller\ModelMySQL;


use Mysqli;
use ruhrpottmetaller\Container\AbstractShelf;

interface IQueryStrategy
{
    public function get(Mysqli $mysqli, string $filter, array $parameters): AbstractShelf|bool;

    public function set(Mysqli $mysqli, AbstractShelf $Shelf): void;

    public function update(Mysqli $mysqli, AbstractShelf $Shelf): void;
}