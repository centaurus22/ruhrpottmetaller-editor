<?php


namespace ruhrpottmetaller\Container;


class CityShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
        "name" => array("variableType" => "bool", "required" => true),
    );
}