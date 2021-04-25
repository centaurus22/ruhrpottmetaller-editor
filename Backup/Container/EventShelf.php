<?php


namespace ruhrpottmetaller\Container;


class EventShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
        "date_start" => array("variableType" => "date", "required" => true),
        "url" => array("variableType" => "string", "required" => true),
        "published" => array("variableType" => "bool", "required" => false),
        "sold_out" => array("variableType" => "bool", "required" => false),
    );
}