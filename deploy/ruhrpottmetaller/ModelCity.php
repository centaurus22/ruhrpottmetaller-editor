<?php

namespace ruhrpottmetaller;

/**
 * Class to acces and manipulate the data in the band table.
 * Version 1.0.0
 */
class ModelCity
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
     * Get city data from the database
     *
     * @return array Array with city data.
     */
    public function getCities($initial)
    {
        $mysqli = $this->mysqli;
        switch($initial) {
            case '':
                $stmt = $mysqli->prepare('SELECT id, name FROM stadt
                    ORDER BY name');
                break;
            case '%':
                $stmt = $mysqli->prepare('SELECT id, name  from stadt
                    WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
                break;
            default:
                $stmt = $mysqli->prepare('SELECT id, name FROM stadt
                    WHERE name LIKE ? ORDER BY name');
                $initial = $initial . '%';
                $stmt->bind_param('s', $initial);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Get city data from one city which is linked to the submitted id.
     *
     * @param integer $id Id of the city.
     * @return array Array with city data.
     */
    public function getCity($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name FROM stadt WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Insert data about a city into the database
     *
     * @param string $name Name of the city.
     * @return integer Returns 1 for successful operation, -1 for an error.
     */
    public function setCity($name)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO stadt SET name=?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $mysqli->insert_id;
        $stmt->close();
        return $result;
    }

    /**
     * Update city data in the database
     *
     * @param integer $id Id of the band which is updated.
     * @param string $name Name of the city.
     * @return integer Returns 1 for success, 0 for a non-existent id, -1 for an
     *  error.
     */
    public function updateCity($id, $name)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE stadt SET name=? WHERE id=?');
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
