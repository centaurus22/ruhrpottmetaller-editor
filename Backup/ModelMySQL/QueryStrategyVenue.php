<?php


namespace ruhrpottmetaller\ModelMySQL;


use Mysqli;
use mysqli_stmt;
use ruhrpottmetaller\Container\AbstractShelf;
use ruhrpottmetaller\Container\VenueShelf;

class QueryStrategyVenue implements IQueryStrategy
{
    public function get(Mysqli $mysqli, string $filter, array $parameters): AbstractShelf|bool
    {
        $Venue_Shelf = new VenueShelf();
        if ($filter == "id" and isset($parameters["id"])) {
            $statement = $this->getVenueByIdStatement($mysqli, $parameters["id"]);
        } elseif (
            $filter == "all"
            or $filter == "city" and isset($parameters["city_id"]) and $parameters["city_id"] = ''
        ) {
            $statement = $this->getVenuesStatement($mysqli);
        } elseif ($filter == "city" and isset($parameters["city_id"])) {
            $statement = $this->getVenuesByCityStatement($mysqli, $parameters["firstChar"]);
        } else {
            return false;
        }
        $mysqliResult =  Model::executeStatement($statement);
        return Model::fillShelfWithBooks($Venue_Shelf, $mysqliResult);
    }

    public function set(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $stmt = $mysqli->prepare('INSERT INTO location SET name=?, stadt_id=?, url=?');
        while ($dataRow = $Shelf->getNextBook()) {
            $stmt->bind_param('ss', $dataRow["name"], $dataRow["stadt_id"], $dataRow["standardUrl"]);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function update(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $statement = $mysqli->prepare('UPDATE band SET name=?, visible=? WHERE id=?');
        while ($dataRow = $Shelf->getNextBook())
        {
            $statement->bind_param(
                'sii',
                $dataRow["name"],
                $dataRow["standardURL"],
                $dataRow["visible"],
                $dataRow["id"]
            );
            $statement->execute();
        }
        $statement->close();
    }

    private function getVenueByIdStatement(Mysqli $mysqli, int $id): mysqli_stmt
    {
        $statement = $mysqli->prepare('SELECT id, name, stadt_id, url as standardUrl, visible FROM location
            WHERE id=? ORDER BY name');
        $statement->bind_param('i', $id);
        return $statement;
    }

    private function getVenuesStatement(Mysqli $mysqli): mysqli_stmt
    {
        return $mysqli->prepare('SELECT id, name, visible FROM location ORDER BY name');
    }

    private function getVenuesByCityStatement(Mysqli $mysqli, string $city_id): mysqli_stmt
    {
        switch($city_id) {
            case '%':
                $statement = $mysqli->prepare('SELECT id, name, visible from location
                    WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
                break;
            default:
                $statement = $mysqli->prepare('SELECT id, name, visible FROM location WHERE name LIKE ?
                    ORDER BY name');
                $city_id .= '%';
                $statement->bind_param('s', $city_id);
        }
        return $statement;
    }
}