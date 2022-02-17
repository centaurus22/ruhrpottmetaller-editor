<?php

namespace ruhrpottmetaller;

class ModelPreferences
{
    private ?\mysqli $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getPreferences(): array
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('
            SELECT export_lang, export_header as header, export_footer as footer 
            FROM preferences
            WHERE id = 1
        ');
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getPreferencesExportLang(): array
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT export_lang FROM preferences WHERE id = 1');
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function updatePreferences(string $export_lang, string $header, string $footer): int
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE preferences SET export_lang=?, export_header=?, export_footer=?');
        $stmt->bind_param('sss', $export_lang, $header, $footer);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
