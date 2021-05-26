<?php


namespace ruhrpottmetaller\ModelMySQL;


use mysqli;
use ruhrpottmetaller\Container\AbstractShelf;
use ruhrpottmetaller\Container\Book;

class Model
{
    private Mysqli $mysqli;
    private IQueryStrategy $QueryStrategy;

    public function __construct(IQueryStrategy $QueryStrategy)
    {
        $this->QueryStrategy = $QueryStrategy;
        $this->initDataBaseConnection();
    }

    public function get(string $filter, array $parameters): AbstractShelf|bool
    {
        $this->QueryStrategy->get($this->mysqli, $filter, $parameters);
    }

    public function set(AbstractShelf $shelf): mixed
    {
        $this->QueryStrategy->set($this->mysqli, $shelf);
    }

    public function update(AbstractShelf $shelf): bool
    {
        $this->QueryStrategy->update($this->mysqli, $shelf);
    }

    private function initDataBaseConnection(): void
    {
        $dbHost = '';
        $dbUser = '';
        $dbUserPass = '';
        $db='';
        include('includes/db_preferences.inc.php');
        $Mysqli = new mysqli($dbHost, $dbUser, $dbUserPass, $db);
        if ($Mysqli->connect_error) {
            die('Connect Error (' . $Mysqli->connect_errno . ') ' . $Mysqli->connect_error);
        }
        $query='SET NAMES "utf8" COLLATE "utf8_general_ci";';
        $Mysqli->query($query);
        if ($Mysqli->error) {
            die('MySQL Error (' . $Mysqli->errno . ') ' . $Mysqli->error);
        }
        $this->mysqli = $Mysqli;
    }

    public static function executeStatement($Statement): \mysqli_result
    {
        $Statement->execute();
        $result = $Statement->get_result();
        $Statement->close();
        return $result;
    }

    public static function fillShelfWithBooks(AbstractShelf $Shelf, \mysqli_result $mysqliResult): bool|AbstractShelf
    {
        while ($dataRow = $mysqliResult->fetch_all(MYSQLI_ASSOC)) {
            $Book = new Book($dataRow);
            $isDataRowComplete = $Shelf->addBook($Book);
            if ($isDataRowComplete === false) {
                return false;
            }
        }
        return $Shelf;
    }
}