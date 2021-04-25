<?php


namespace ruhrpottmetaller\ModelMySQL;


use Mysqli;
use mysqli_stmt;
use ruhrpottmetaller\Container\AbstractShelf;
use ruhrpottmetaller\Container\EventShelf;

class QueryStrategyEvent implements IQueryStrategy
{
    public function get(Mysqli $mysqli, string $filter, array $parameters): AbstractShelf|bool
    {
        $Event_Shelf = new EventShelf();
        if ($filter == "id" and isset($parameters["id"])) {
            $statement = $this->getEventByIdStatement($mysqli, $parameters["id"]);
        } elseif ($filter == "month" and isset($parameters["month"])) {
            $statement = $this->getEventsByMonthStatement($mysqli, $parameters["firstChar"]);
        } else {
            return false;
        }
        $mysqliResult =  Model::executeStatement($statement);
        return Model::fillShelfWithBooks($Event_Shelf, $mysqliResult);
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

    private function getEventByIdStatement(Mysqli $mysqli, int $id): mysqli_stmt
    {
        $statement = $mysqli->prepare('SELECT event.id, datum_beginn, datum_ende, event.name as name, event.url, ausverkauft,  
            location.name as venue_name, stadt.name as city_name FROM event
            JOIN location ON event.location_id = location.id  JOIN stadt on location.stadt_id = stadt.id
            WHERE event.id=?');
        $statement->bind_param('i', $id);
        return $statement;
    }

    private function getEventsByMonthStatement(Mysqli $mysqli, string $month): mysqli_stmt
    {
        $statement = $mysqli->prepare('SELECT event.id, datum_beginn, datum_ende, event.name as name, event.url, ausverkauft,  
            location.name as venue_name, stadt.name as city_name FROM event
            JOIN location ON event.location_id = location.id  JOIN stadt on location.stadt_id = stadt.id
            WHERE datum_beginn=?');
        $month .= "%";
        $statement->bind_param('s', $month);
        return $statement;
    }
}