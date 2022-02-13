<?php

namespace ruhrpottmetaller;

class ModelCity
{
    private ?\mysqli $mysqli = null;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getCities($initial): array
    {
        $mysqli = $this->mysqli;
        switch ($initial) {
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

    public function getCity(int $id): array
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT id, name FROM stadt WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function setCity(string $name): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('INSERT INTO stadt SET name=?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $mysqli->insert_id;
        $stmt->close();
        return $result;
    }

    public function updateCity(int $id, string $name): int
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
