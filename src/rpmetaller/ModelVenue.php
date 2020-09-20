<?php

namespace rpmetaller;

/**
 * Class to acces and maintain venue data.
 */
class ModelVenue
{
    private $mysqli = null;

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

    public function getVenuesByCity($city_id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, stadt_id, url FROM location
            WHERE stadt_id=? ORDER BY name');
        $stmt->bind_param('i', $city_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getVenueById($id)
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

    public function setVenue($name, $city_id, $url)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO location SET name=?, stadt_id=?,
            url=?');
        $stmt->bind_param('sis', $name, $city_id, $url);
        $stmt->execute();
        $result = $this->mysqli->insert_id;
        $stmt->close();
        return $result;
    }

    public function updateVenue($id, $name, $city_id, $url)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE location SET name=?, stadt_id=?, url=?
            WHERE id=?');
        $stmt->bind_param('sisi', $name, $city_id, $url, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
