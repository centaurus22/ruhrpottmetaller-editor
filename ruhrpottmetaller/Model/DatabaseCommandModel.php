<?php

namespace ruhrpottmetaller\Model;

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
}
