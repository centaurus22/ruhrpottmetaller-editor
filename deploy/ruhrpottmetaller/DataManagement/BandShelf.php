<?php


namespace ruhrpottmetaller\DataManagement;


class BandShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
      "name" => array("required" => true)
    );
}