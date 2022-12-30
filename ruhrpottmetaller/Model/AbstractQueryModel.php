<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\RmArray;

abstract class AbstractQueryModel extends AbstractModel
{
    protected function query(
        string $query,
        ?string $parameterTypes = null,
        ?array $parameters = null
    ): RmArray {
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        $array = RmArray::new();
        while ($object = $result->fetch_object()) {
            $array->add($this->getDataFromResult($object));
        }
        return $array;
    }

    protected function queryOne(
        string $query,
        ?string $parameterTypes = null,
        ?array $parameters = null
    ) {
        $statement = $this->connection->prepare($query);
        $statement->bind_param($parameterTypes, ...$parameters);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        return $this->getDataFromResult($result->fetch_object());
    }
}
