<?php

namespace ruhrpottmetaller\Model;

use mysqli;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class DatabaseConnection
{
    private RmString $connectionInformationFile;
    private mysqli $connection;
    private string $databaseHost = '';
    private string $databaseUserName = '';
    private string $databaseUserPassword = '';
    private string $databaseName = '';

    public function __construct($connectionInformationFile)
    {
        $this->connectionInformationFile = $connectionInformationFile;
    }

    public static function new($connectionInformationFile): DatabaseConnection
    {
        return new self($connectionInformationFile);
    }

    public function connect(): DatabaseConnection
    {
        if (!is_file($this->connectionInformationFile->get())) {
            throw new \Error('File with database connection information not found.');
        }

        include(
            $this->connectionInformationFile->get()
        );

        $this->connection = new mysqli(
            $this->databaseHost,
            $this->databaseUserName,
            $this->databaseUserPassword,
            $this->databaseName
        );

        return $this;
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}
