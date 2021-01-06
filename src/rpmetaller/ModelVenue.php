<?php

namespace rpmetaller;

/**
 * Class to acces and maintain venue data.
 * Version 1.0.0
 */
class ModelVenue
{
    //Link identifier for the connection to the database
    private $mysqli = null;

    /**
     * Call the function which initialize the database connection and write the
     * link identifier into the class variable.
     */
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * Get data of all venues from the database.
     *
     * @return array|int Array with venue data or -1 for an error.
     */
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

    /**
     * Get data of all venues in the supplied city from the database.
     *
     * @param int $city_id Id of the city.
     * @return array|int Array with venue data or -1 for an error.
     */
    public function getVenuesByCity($city_id)
    {
        $mysqli = $this->mysqli;
        if ($city_id == '') {
            $stmt = $mysqli->prepare('SELECT location.id, location.name,
                stadt.name AS city_name,
                location.stadt_id, location.url, location.anzeigen FROM location
                JOIN stadt ON location.stadt_id = stadt.id
                ORDER BY stadt.name, location.name');
        } else {
            $stmt = $mysqli->prepare('SELECT location.id, location.name,
                stadt.name AS city_name,
                location.stadt_id, location.url, location.anzeigen FROM location
                JOIN stadt ON location.stadt_id = stadt.id
                WHERE stadt_id=? ORDER BY name');
            $stmt->bind_param('i', $city_id);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Get data of the venue with the submitted id.
     *
     * @param int $venue_id Id of the venue.
     * @return array|int Array with venue data or -1 for an error.
     */
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

    /**
     * Insert a new venue into the database.
     *
     * @param string $name Name of the venue.
     * @param int $city_id Id of the city in which the venue is located.
     * @paramt string $url Standard URL of the venue. If the venue has one
     *  webpage with information about all concert, this value is interesting.
     * @return int if of the new venue or -1 for an error.
     */
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

    /**
     * Update a venue in the database.
     *
     * @param string $name Name of the venue.
     * @param int $city_id Id of the city in which the venue is located.
     * @paramt string $url Standard URL of the venue. If the venue has one
     *  webpage with information about all concert, this value is interesting.
     * @return int 1 for success or 0 for an error.
     */
    public function updateVenue($id, $name, $url, $export)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE location SET name=?, anzeigen=?, url=?
            WHERE id=?');
        $stmt->bind_param('sisi', $name, $export, $url, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
