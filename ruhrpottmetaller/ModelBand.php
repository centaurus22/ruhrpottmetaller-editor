<?php

namespace ruhrpottmetaller;

class ModelBand
{
    private ?\mysqli $mysqli = null;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getBands(string $initial): array
    {
        $mysqli = $this->mysqli;
        switch ($initial) {
            case '':
                $stmt = $mysqli->prepare('SELECT id, name, visible FROM band
                    ORDER BY name');
                break;
            case '%':
                $stmt = $mysqli->prepare('SELECT id, name, visible from band
                    WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
                break;
            default:
                $stmt = $mysqli->prepare('SELECT id, name, visible FROM band
                    WHERE name LIKE ? ORDER BY name');
                $initial = $initial . '%';
                $stmt->bind_param('s', $initial);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getBand(int $id): array
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name, visible FROM band WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function setBand(string $name): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO band SET name=?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $mysqli->insert_id;
        $stmt->close();
        return ($result);
    }

    public function updateBand(int $id, string $name, $visible): int
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
