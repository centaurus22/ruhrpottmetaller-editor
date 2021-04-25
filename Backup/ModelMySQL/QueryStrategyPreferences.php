<?php


namespace ruhrpottmetaller\ModelMySQL;


use Mysqli;
use mysqli_stmt;
use ruhrpottmetaller\Container\AbstractShelf;
use ruhrpottmetaller\Container\PreferencesShelf;

class QueryStrategyPreferences implements IQueryStrategy
{
    public function get(Mysqli $mysqli, string $filter, array $parameters): AbstractShelf|bool
    {
        $City_Shelf = new PreferencesShelf();
        if ($filter == "all") {
            $statement = $this->getPreferencesStatement($mysqli);
        } elseif ($filter == "exportLanguage") {
            $statement = $this->getExportLanguagePreferenceStatement($mysqli);
        } else {
            return false;
        }
        $mysqliResult =  Model::executeStatement($statement);
        return Model::fillShelfWithBooks($City_Shelf, $mysqliResult);
    }

    public function set(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
    }

    public function update(Mysqli $mysqli, AbstractShelf $Shelf): void
    {
        $statement = $mysqli->prepare('UPDATE preferences SET export_lang=?, header=?, footer=? WHERE id=1');
        while ($dataRow = $Shelf->getNextBook())
        {
            $statement->bind_param(
                'sss',
                $dataRow["export_language"],
                $dataRow["header"],
                $dataRow["footer"]
            );
            $statement->execute();
        }
        $statement->close();
    }

    private function getPreferencesStatement(Mysqli $mysqli): mysqli_stmt
    {
        return $mysqli->prepare('SELECT export_lang, header, footer FROM preferences');
    }

    private function getExportLanguagePreferenceStatement(Mysqli $mysqli): mysqli_stmt
    {
        return $mysqli->prepare('SELECT export_lang FROM preferences');
    }
}