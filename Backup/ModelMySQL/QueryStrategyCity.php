<?php


namespace ruhrpottmetaller\ModelMySQL;


use Mysqli;
use mysqli_stmt;
use ruhrpottmetaller\Container\AbstractShelf;
use ruhrpottmetaller\Container\EventShelf;

class QueryStrategyCity implements IQueryStrategy
{
    public function get(Mysqli $mysqli, string $filter, array $parameters): AbstractShelf|bool
    {
        $City_Shelf = new EventShelf();
        if ($filter == "id" and isset($parameters["id"])) {
            $statement = $this->getCityByIdStatement($mysqli, $parameters["id"]);
        } elseif ($filter == "firstChar" and isset($parameters["firstChar"])) {
            $statement = $this->getCitiesByFirstCharStatement($mysqli, $parameters["firstChar"]);
        } else {
            return false;
        }
        $mysqliResult =  Model::executeStatement($statement);
        return Model::fillShelfWithBooks($City_Shelf, $mysqliResult);
    }

    public function set(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $statement = $mysqli->prepare('INSERT INTO stadt SET name=?');
        while ($dataRow = $Shelf->getNextBook()) {
            $statement->bind_param('s', $dataRow["name"]);
            $statement->execute();
        }
        $statement->close();
    }

    public function update(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $statement = $mysqli->prepare('UPDATE stadt SET name=? WHERE id=?');
        while ($dataRow = $Shelf->getNextBook())
        {
            $statement->bind_param('si', $dataRow["name"], $dataRow["id"]);
            $statement->execute();
        }
        $statement->close();
    }

    private function getCityByIdStatement(Mysqli $mysqli, int $id): mysqli_stmt
    {
        $statement = $mysqli->prepare('SELECT id, name FROM band WHERE id=?');
        $statement->bind_param('i', $id);
        return $statement;
    }

    private function getCitiesByFirstCharStatement(Mysqli $mysqli, string $firstChar): mysqli_stmt
    {
        switch($firstChar) {
            case '':
                $statement = $mysqli->prepare('SELECT id, name FROM stadt ORDER BY name');
                break;
            case '%':
                $statement =  $mysqli->prepare('SELECT id, name from stadt WHERE name NOT REGEXP "^[A-Z,a-z]" 
                    ORDER BY name');
                break;
            default:
                $statement = $mysqli->prepare('SELECT id, name, visible FROM stadt WHERE name LIKE ? ORDER BY name');
                $firstChar .= '%';
                $statement->bind_param('s', $firstChar);
        }
        return $statement;
    }
}