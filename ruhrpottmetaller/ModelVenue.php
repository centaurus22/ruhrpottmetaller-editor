<?php

namespace ruhrpottmetaller;

class ModelVenue
{
    private ?\mysqli $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getVenues()
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, stadt_id, url FROM location
            ORDER BY name');
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getVenuesByCity(string $city_id)
    {
        $mysqli = $this->mysqli;
        if ($city_id == '') {
            $stmt = $mysqli->prepare('SELECT location.id, location.name,
                stadt.name AS city_name,
                location.stadt_id, location.url FROM location
                JOIN stadt ON location.stadt_id = stadt.id
                ORDER BY stadt.name, location.name');
        } else {
            $stmt = $mysqli->prepare('SELECT location.id, location.name,
                stadt.name AS city_name,
                location.stadt_id, location.url  FROM location
                JOIN stadt ON location.stadt_id = stadt.id
                WHERE stadt_id=? ORDER BY name');
            $stmt->bind_param('i', $city_id);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getVenueById(int $id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, stadt_id, url FROM location
            WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function setVenue(string $name, int $city_id, string $url): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO location SET name=?, stadt_id=?, url=?');
        $stmt->bind_param('sis', $name, $city_id, $url);
        $stmt->execute();
        $result = $this->mysqli->insert_id;
        $stmt->close();
        return $result;
    }

    public function updateVenue(int $id, string $name, string $url): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE location SET name=?, url=? WHERE id=?');
        $stmt->bind_param('ssi', $name, $url, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
