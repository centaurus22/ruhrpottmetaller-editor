<?php
namespace ruhrpottmetaller\DataManagement;

class DataBook
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