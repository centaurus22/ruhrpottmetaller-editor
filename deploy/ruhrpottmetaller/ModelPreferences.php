<?php

namespace ruhrpottmetaller;

/**
 * Class to access and manipulate the data in the preferences table.
 * Version 1.0.0
 */
class ModelPreferences
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
     * Read the preferences from the database.
     *
     * @return array Array with preferences. If no preferences are set it returns
     *  an empty array.
     */
    public function getPreferences()
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT export_lang, header, footer
            FROM preferences WHERE id = 1');
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Read preferences about the export language from the database.
     *
     * @return array Array with language preferences. If no preferences are set
     *  it returns an empty array.
     */
    public function getPreferencesExportLang()
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('SELECT export_lang FROM preferences
            WHERE id = 1');
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Set the preferences in the database.
     *
     * @param string $export_lang Language in which the concerts should be
     *  exported.
     * @param string $header Header of the monthly overview of concerts.
     * @param string $footer Footer of the monthly overview of concerts.
     * @return integer Integer with a value greater 1 for a succesfully write of
     *  preferences, 0 for no changes, -1 for an error.
     */
    public function updatePreferences($export_lang, $header, $footer)
    {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare('UPDATE preferences SET export_lang=?, header=?,
            footer=?');
        $stmt->bind_param('sss', $export_lang, $header, $footer);
        $stmt->execute();
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}
