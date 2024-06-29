<?php

namespace ruhrpottmetaller\Model\Command;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Model\DatabaseModel;

class DatabaseCommandModel extends DatabaseModel
{
    protected function query(
        string $query,
        ?string $parameterTypes = null,
        ?array $parameters = null
    ): void {
        $statement = $this->connection->prepare($query);
        $statement->bind_param($parameterTypes, ...$parameters);
        $statement->execute();
        $statement->close();
    }

    protected function getLastInsertedId(): RmInt
    {
        return RmInt::new(($this->connection->query('SELECT LAST_INSERT_ID() AS id')->fetch_assoc())['id']);
    }
}
