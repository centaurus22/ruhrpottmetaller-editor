<?php

namespace ruhrpottmetaller\DataManagement;

/**
 * Class to access and manipulate the data in the band table.
 * Version 1.0.0
 */
class ModelBand
{
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
     * Get band data from the database
     *
     * @param string $initial Initial letter of the band name in capital letters
     *  or an empty string for all bands or a % for bands witch names start with
     *  a special character.
     * @return array Array with band data.
     */


    /**
     * Insert data about a band into the database
     *
     * @param string $name Name of the band.
     * @param integer $nazi Export status of the band. 0 -> exportable
     *  1-> non-exportable
     * @return integer Returns id of the new band, -1 for an error.
     */
    public function setBand($name)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO band SET name=?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $mysqli->insert_id;
        $stmt->close();
        return ($result);
    }

    /**
     * Update band data in the database
     *
     * @param integer $id Id of the band which is updated.
     * @param string $name Name of the band.
     * @param integer $nazi Export status of the band. 0 -> exportable
     *  1-> non-exportable
     * @return integer Returns 1 for successful operation,
     *  0 for a non-existent id, -1 for an error.
     */
    public function updateBand($id, $name, $visible)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE band SET name=?, visible=? WHERE id=?');
        $stmt->bind_param('sii', $name, $visible, $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return ($result);
    }
}
