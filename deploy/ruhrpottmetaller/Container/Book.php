<?php


namespace ruhrpottmetaller\Container;


class Book
{
    private array $data = array();

    public function setDataRow(array $data): void
    {
        $this->data = $data;
    }

    public function getDataRow(): array
    {
        return $this->data;
    }
}