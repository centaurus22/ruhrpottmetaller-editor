<?php


namespace ruhrpottmetaller\Container;


class BandShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
        "name" => array("variableType" => "bool", "required" => true),
        "visible" => array("variableType" => "bool", "required" => false)
    );
}