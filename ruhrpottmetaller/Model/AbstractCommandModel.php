<?php

namespace ruhrpottmetaller\Model;

class AbstractCommandModel extends AbstractModel
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
