<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\LowLevel\String\RmString;

class DatabaseConnectHelper extends AbstractConnectHelper
{
    private RmString $ConnectionInformationFile;
    private \mysqli $Connection;
    private string $databaseHost = '';
    private string $databaseUserName = '';
    private string $databaseUserPassword = '';
    private string $databaseTable = '';

    public function __construct($ConnectionInformationFile)
    {
        $this->ConnectionInformationFile = $ConnectionInformationFile;
    }

    public static function new($ConnectionInformationFile): DatabaseConnectHelper
    {
        return new self($ConnectionInformationFile);
    }

    public function connect(): DatabaseConnectHelper
    {
        if (!is_file($this->ConnectionInformationFile->get())) {
            throw new \Error('File with database connection information not found.');
        }

        include(
            $this->ConnectionInformationFile->get()
        );

        $this->Connection = new \mysqli(
            $this->databaseHost,
            $this->databaseUserName,
            $this->databaseUserPassword,
            $this->databaseTable
        );

        return $this;
    }

    public function getConnection(): \mysqli
    {
        return $this->Connection;
    }
}
