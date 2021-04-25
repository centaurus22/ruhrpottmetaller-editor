<?php


namespace ruhrpottmetaller\Container;


class VenueShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
        "name" => array("variableType" => "bool", "required" => true),
        "city_id" => array("variableType" => "int", "required" => true),
        "standard_url" => array("variableType" => "string", "required" => false),
        "visible" => array("variableType" => "bool", "required" => false)
    );
}