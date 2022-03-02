<?php

namespace ruhrpottmetaller;

class ModelConcert
{
    private ?\mysqli $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getConcerts(string $month): array
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            SELECT
                event.id,
                event.date_start,
                event.date_end,
                event.name AS name,
                event.url,
                event_instagram.time_published_last as published,
                event.sold_out AS ausverkauft,
                venue.name AS venue_name,
                city.name AS city_name
            FROM 
                event
            LEFT JOIN 
                venue ON event.venue_id = venue.id
            LEFT JOIN 
                city ON venue.city_id = city.id
            LEFT JOIN
                event_instagram ON event.id = event_instagram.event_id
            WHERE 
                date_start LIKE ?
            ORDER BY
                event.date_end
        ');
        $month = $month . '%';
        $stmt->bind_param('s', $month);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $stmt = $mysqli->prepare('
            SELECT band.name, band.visible, event_band.additional_information AS zusatz
            FROM event_band
            LEFT JOIN band ON event_band.band_id = band.id
            WHERE event_band.event_id = ?
        ');
        for ($i = 0; $i < count($result); $i++) {
            $stmt->bind_param('i', $result[$i]['id']);
            $stmt->execute();
            $bands = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $result[$i]['bands'] = $bands;
        }
        $stmt->close();
        return $result;
    }

    public function getConcert(int $id): array
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            SELECT
                event.id,
                event.date_start,
                event.date_end,
                event.name,
                event.url,
                event_instagram.time_published_last as published,
                event.sold_out AS ausverkauft,
                venue.name AS venue_name,
                venue.id as venue_id,
                city.name AS city_name,
                city.id AS city_id
            FROM 
                 event
            LEFT JOIN 
                venue ON event.venue_id = venue.id
            LEFT JOIN
                city ON venue.city_id = city.id
            LEFT JOIN
                event_instagram ON event.id = event_instagram.event_id
            WHERE
                event.id = ?
            ORDER BY
                event.date_start
        ');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $bands = $this->getBands($id);
        $result[0]['bands'] = $bands;
        return $result;
    }

    public function updateConcert(
        int $id,
        string $name,
        string $date_start,
        ?string $date_end,
        int $venue_id,
        string $url
    ): int {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            UPDATE event
            SET name = ?, date_start = ?, date_end = ?, venue_id = ?, url = ?
            WHERE id = ?
        ');
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

    public function setConcert(string $name, string $date_start, ?string $date_end, int $venue_id, string $url): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            INSERT INTO event SET name = ?, date_start = ?, date_end = ?, venue_id = ?, url = ?');
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

    public function delConcert(int $id): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            DELETE event, event_band 
            FROM event
            LEFT JOIN event_band ON event.id = event_band.event_id
            WHERE event.id = ?
        ');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    public function getBands(int $id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            SELECT band.id, band.name, band.visible, event_band.additional_information as zusatz
            FROM event_band
            LEFT JOIN band ON event_band.band_id = band.id
            WHERE event_band.event_id = ?
        ');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function setBand(int $id, int $band_id, string $addition): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO event_band SET event_id = ?, band_id = ?, additional_information = ?');
        $stmt->bind_param('iis', $id, $band_id, $addition);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }

    public function delBands(int $id)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('DELETE FROM event_band WHERE event_band.event_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }


    public function setSoldOut(int $id): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE event SET sold_out=1 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
