<?php


namespace ruhrpottmetaller\Container;


class BandShelf extends AbstractShelf
{
    protected array $bookDefinition = array(
      "name" => array("required" => true)
    );
}