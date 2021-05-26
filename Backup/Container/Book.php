<?php


namespace ruhrpottmetaller\Container;


class Book
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getDataRow(): array
    {
        return $this->data;
    }
}