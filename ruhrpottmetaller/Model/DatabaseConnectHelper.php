<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\DataType\DataTypeString;

class DatabaseConnectHelper extends AbstractConnectHelper
{
    private DataTypeString $ConnectionInformationFile;
    private \mysqli $Connection;

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

        $databaseHost = '';
        $databaseUserName = '';
        $databaseUserPassword = '';
        $databaseTable = '';

        include(
            $this->ConnectionInformationFile->get()
        );

        $this->Connection = new \mysqli(
            $databaseHost,
            $databaseUserName,
            $databaseUserPassword,
            $databaseTable
        );

        return $this;
    }

    public function getConnection(): \mysqli
    {
        return $this->Connection;
    }
}
