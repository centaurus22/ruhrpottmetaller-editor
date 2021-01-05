<?php

namespace rpmetaller;

/**
 * Class to access and manipulate the data in the event table and the event_band
 * table
 * Version 1.0.0
 */
class ModelConcert
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
     * Read data about concerts in a specified month from the database and
     * deliver it as a three dimensional array.
     *
     * @param string $month Month from which the concert is read.
     * @return array Array with the concert data. If no concerts are present in
     *  this month it returns an empty array.
     */
    public function getConcerts($month)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT event.id,
            event.datum_beginn AS date_start, event.datum_ende AS date_end,
            event.name AS name, event.url, event.publiziert, event.ausverkauft,
            location.name AS venue_name, stadt.name AS city_name FROM event
            LEFT JOIN location ON event.location_id = location.id
            LEFT JOIN stadt ON location.stadt_id = stadt.id
            WHERE datum_beginn LIKE ?
            ORDER BY event.datum_beginn ASC');
        $month = $month . '%';
        $stmt->bind_param('s', $month);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $stmt = $mysqli->prepare('SELECT band.name, band.nazi, event_band.zusatz
            FROM event_band LEFT JOIN band ON event_band.band_id = band.id
            WHERE event_band.event_id = ?');
        for($i = 0; $i < count($result); $i++) {
            $stmt->bind_param('i', $result[$i]['id']);
            $stmt->execute();
            $bands = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $result[$i]['bands'] = $bands;
        }
        $stmt->close();
        return $result;
    }

    /**
     * Read the data of one concert from the database and deliver it as a two
     * dimensional array.
     *
     * @param integer $id Id of the concert which data is read.
     * @return array Array with the concert data. If no concert with this id
     *  exist it returns an empty array.
     */
    public function getConcert($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT event.id,
            event.datum_beginn AS date_start,
            event.datum_ende AS date_end,
            event.name,
            event.url, event.publiziert, event.ausverkauft,
            location.name AS venue_name, location.id as venue_id,
            stadt.name AS city_name, stadt.id AS city_id
            FROM event LEFT JOIN location ON event.location_id = location.id
            LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE event.id = ?
            ORDER BY event.datum_beginn ASC');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        //get the corresponding bands.
        $bands = $this->getBands($id);
        $result[0]['bands'] = $bands;
        return $result;
    }

    /**
     * Update the data of one concert in the database.
     *
     * @param integer $id Id of the concert which data is updated.
     * @param string $name The name of the concert.
     * @param string $date_start It contains the date on which the concert takes
     *  place. If the concert is a multi-day festival it contains the date of the
     *  first day.
     * @param string $date_end If the concert is a multi-day festival this string
     *  contains the date of the last day in the format YYYY-MM-DD. If it is just
     *  on one day, the string is empty.
     * @param integer $venue_id The id of the venue where the concert takes place
     * @param string $url URL which links to information about a concert
     * @return integer The id of the last updated concert.
     */
    public function updateConcert(
            $id,
            $name,
            $date_start,
            $date_end,
            $venue_id,
            $url
        ) {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE event SET name = ?, datum_beginn = ?,
            datum_ende = ?, location_id = ?, url = ? WHERE id = ?');
        $stmt->bind_param(
                'sssisi',
                $name,
                $date_start,
                $date_end,
                $venue_id,
                $url,
                $id
            );
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    /**
     * Insert a concert into the database.
     *
     * @param string $name The name of the concert.
     * @param string $date_start It contains the date on which the concert takes
     *  place. If the concert is a multi-day festival it contains the date of the
     *  first day.
     * @param string $date_end If the concert is a multi-day festival this string
     *  contains the date of the last day in the format YYYY-MM-DD. If it is just
     *  on one day, the string is empty.
     * @param integer $venue_id The id of the venue where the concert takes place
     * @param string $url URL which links to information about a concert
     * @return integer The id of the last inserted concert.
     */
    public function setConcert($name, $date_start, $date_end, $venue_id, $url)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO event SET name = ?,
            datum_beginn = ?, datum_ende = ?, location_id = ?, url = ?');
        $stmt->bind_param(
                'sssis',
                $name,
                $date_start,
                $date_end,
                $venue_id,
                $url
            );
        $stmt->execute();
        $result = $mysqli->insert_id;
        $stmt->close();
        return $result;
    }

    /**
     * Delete one concert in the database.
     *
     * @param integer $id Id of the concert which is deleted.
     * @return integer Returns 1 for successful operation,
     *  0 for a non-existent id, -1 for an error.
     */
    public function delConcert($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('DELETE event, event_band FROM event
            LEFT JOIN event_band ON event.id=event_band.event_id
            WHERE event.id= ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    /**
     * Retrieve band data of bands which are playing on a concert.
     *
     * @param integer $id Id of the concert from which the band data is
     *  retrieved.
     * @return array|integer Array with band id, export bit and additional
     * information about the appearance of a band, or an integer with -1 in case
     * of an error.
     */
    public function getBands($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT band.id, band.name, band.nazi,
            event_band.zusatz FROM event_band
            LEFT JOIN band ON event_band.band_id = band.id
            WHERE event_band.event_id LIKE ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Insert band data of a band which is playing at a concert.
     *
     * @param integer id Id of the concert on which the band is playing.
     * @param integer $band_id Band id of the band which is playing.
     * @param addition $string Additional information about the appearance.
     * @return integer Returns 1 for a successful operation, 0 for a non-existent
     *  id, -1 for an error.
     */
    public function setBand($id, $band_id, $addition)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO event_band SET event_id = ?,
            band_id = ?, zusatz = ?');
        $stmt->bind_param('iis', $id, $band_id, $addition);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    /**
     * Retrieve band data of band which are playing on a concert.
     *
     * @param integer $id Id of the concert from which the band data is
     *  retrieved.
     * @return array|integer Array with band id, export bit and additional
     *  information about the appearance of a band, or an integer with -1 in case
     *  of an error.
     */
    public function delBands($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('DELETE FROM event_band
            WHERE event_band.event_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    /**
     * Set a concert as sold out.
     *
     * @param integer $id Id of the concert which should be set sold out.
     * @return integer Returns 1 for a successful operation,
     *  0 for a non-existent id, -1 for an error.
     */
    public function setSoldOut ($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE event SET ausverkauft=1 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    /**
     * Set a concert as published.
     *
     * @param integer $id Id of the concert which should be set published.
     * @return integer Returns 1 for a successful operation,
     *  0 for a non-existent id, -1 for an error.
     */
    public function setPublished ($id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE event SET publiziert=1 WHERE id= ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
