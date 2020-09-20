<?php

namespace rpmetaller;

//use mysqli;

/**
 * Class to make a database connection
 * Version 1.0.0
 */
class UtilityConnect
{
    /**
     * Make the database connection.
     *
     * @return link identifier
     */
    public static function db_connect()
    {
        $dbhost = '';
        $dbuser = '';
        $dbuserpass = '';
        $db='';
        include('includes/db_preferences.inc.php');
        $mysqli = new \mysqli($dbhost, $dbuser, $dbuserpass, $db);
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }
        $query='SET NAMES "utf8" COLLATE "utf8_general_ci";';
        $mysqli->query($query);
        if ($mysqli->error) {
            die('MySQL Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        return $mysqli;
    }
}
