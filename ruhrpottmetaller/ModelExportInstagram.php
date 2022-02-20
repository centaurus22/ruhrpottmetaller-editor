<?php

namespace ruhrpottmetaller;

class ModelExportInstagram
{
    private ?\mysqli $mysqli = null;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function setPublished(int $id): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE export_instagram SET time_published_last = NOW() WHERE event_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
