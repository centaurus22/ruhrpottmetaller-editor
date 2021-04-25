<?php


namespace ruhrpottmetaller\ModelMySQL;


use Mysqli;
use mysqli_stmt;
use ruhrpottmetaller\Container\AbstractShelf;
use ruhrpottmetaller\Container\BandShelf;

class QueryStrategyBand implements IQueryStrategy
{
    public function get(Mysqli $mysqli, string $filter, array $parameters): AbstractShelf|bool
    {
        $Band_Shelf = new BandShelf();
        if ($filter == "id" and isset($parameters["id"])) {
            $statement = $this->getBandByIdStatement($mysqli, $parameters["id"]);
        } elseif ($filter == "firstChar" and isset($parameters["firstChar"])) {
            $statement = $this->getBandsByFirstCharStatement($mysqli, $parameters["firstChar"]);
        } else {
            return false;
        }
        $mysqliResult =  Model::executeStatement($statement);
        return Model::fillShelfWithBooks($Band_Shelf, $mysqliResult);
    }

    public function set(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $stmt = $mysqli->prepare('INSERT INTO band SET name=?');
        while ($dataRow = $Shelf->getNextBook()) {
            $stmt->bind_param('s', $dataRow["name"]);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function update(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $statement = $mysqli->prepare('UPDATE band SET name=?, visible=? WHERE id=?');
        while ($dataRow = $Shelf->getNextBook())
        {
            $statement->bind_param('sii', $dataRow["name"], $dataRow["visible"], $dataRow["id"]);
            $statement->execute();
        }
        $statement->close();
    }

    private function getBandByIdStatement(Mysqli $mysqli, int $id): mysqli_stmt
    {
        $statement = $mysqli->prepare('SELECT id, name, visible FROM band WHERE id=?');
        $statement->bind_param('i', $id);
        return $statement;
    }

    private function getBandsByFirstCharStatement(Mysqli $mysqli, string $firstChar): mysqli_stmt
    {
        switch($firstChar) {
            case '':
                $statement = $mysqli->prepare('SELECT id, name, visible FROM band ORDER BY name');
                break;
            case '%':
                $statement = $mysqli->prepare('SELECT id, name, visible from band 
                    WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
                break;
            default:
                $statement = $mysqli->prepare('SELECT id, name, visible FROM band WHERE name LIKE ? ORDER BY name');
                $firstChar .= '%';
                $statement->bind_param('s', $firstChar);
        }
        return $statement;
    }
}