<?php


namespace ruhrpottmetaller\Container;


class PreferencesShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
        "export_language" => array("variableType" => "string", "required" => false),
        "header_text" => array("variableType" => "string", "required" => false),
        "footer_text" => array("variableType" => "string", "required" => false)
    );
}