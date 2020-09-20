<?php

namespace rpmetaller;

/**
 * Class to access and manipulate data saved in the session
 * Version 1.0.0
 */
class ModelSession
{
    /**
     * Initialize the session if it is not already initialized.
     *
     * @return integer 1 if a session is activated or was already active,
     *  -1 if PHP sessions are disabled.
     */
    public function __construct()
    {
        switch(session_status()) {
        case PHP_SESSION_DISABLED:
            return -1;
            break;
        case PHP_SESSION_NONE:
            session_start();
        case PHP_SESSION_ACTIVE:
            return 1;
            break;
        }
    }

    /**
     * Add an empty array to the PHP Session to save the status of the concert
     *  exports on the default site (opened / closed) if it is not already
     *  available.
     *
     * @return integer Always 1.
     */
    private function initConcertDisplayStatus()
    {
        if(!isset($_SESSION['concert_display_status'])) {
            $_SESSION['concert_display_status'] = array();
        }
        return 1;

    }

    /**
     * Add an empty array to the PHP Session to save the lineup in the concert
     * editor if it is not already available.
     *
     * @return integer Always 1.
     */
    private function initLineUp()
    {
        if(!isset($_SESSION['lineup'])) {
            $_SESSION['lineup'] = array();
        }
        return 1;
    }

    /**
     * Check the export status of a concert.
     *
     * @param integer $id Id of the concert which export status should be
     *  checked.
     * @return integer 1-> Export status is open, 0-> Export status is closed,
     *  -1-> id is no integer.
     */
    public function getConcertDisplayStatus($id)
    {
        if (is_numeric($id)) {
            $this->initConcertDisplayStatus();
            if (
                isset($_SESSION['concert_display_status']["$id"])
                and $_SESSION['concert_display_status']["$id"]
            ) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }

    /**
     * Change the export status of a concert.
     *
     * @param integer $id Id of the concert.
     * @return integer 1-> The Id is an integer, -1-> the id is no ingeger.
     */
    public function changeConcertDisplayStatus ($id)
    {
        if (is_numeric($id)) {
            $this->initConcertDisplayStatus();
            if ($this->getConcertDisplayStatus ($id) == 1) {
                $_SESSION['concert_display_status']["$id"] = 0;
            } else {
                $_SESSION['concert_display_status']["$id"] = 1;
            }
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Get the lineup.
     *
     * @return array Array with the lineup data.
     */
    public function getBandsLineUp()
    {
        $this->initLineUp();
        return $_SESSION['lineup'];;
    }

    /**
     * Delete the array witch contains the export statuses of the concerts.
     *
     * @return integer Always 1.
     */
    public function delConcertDisplayStatus()
    {
        if (isset($_SESSION['concert_display_status'])) {
            unset($_SESSION['concert_display_status']);
        }
        return 1;
    }

    /**
     * Add a new band to the lineup array.
     *
     * @param integer $row Number of the row under which the new band is added.
     * @return integer 1-> parameter is an integer, -1-> parameter is no integer.
     */
    public function setBandLineUp($row)
    {
        if (is_numeric($row)) {
            $this->initLineUp();
            $band[] = array(
                'first_sign' => '',
                'band_id' => 0,
                'band_new_name' => null,
                'addition' => null
            );
            array_splice($_SESSION['lineup'], $row, 0, $band);
            return 1;
        }
        else {
            return -1;
        }
    }

    /**
     * Change information in a specific row of the lineup-.
     *
     * @param integer $row Number of the row.
     * @param string $field Session variable which is filled.
     * @param integer $value Value which is written in the session variable.
     * @return integer 1-> row and band_id parameter are integers, -1-> one of
     *  those parameters are no integer.
     */
    public function updateBandLineUp($row, $field, $value)
    {
        if (is_numeric($row)) {
            $this->initLineUp();
            $_SESSION['lineup'][$row][$field] = $value;
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Delete a band from the lineup array.
     *
     * @param integer $row Number of the row which is deleted.
     * @return integer 1-> parameter is an integer, -1-> parameter is no integer.
     */
    public function delBandLineUp($row)
    {
        if (is_numeric($row)) {
            $this->initLineUp();
            array_splice($_SESSION['lineup'], $row, 1);
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Shift a band up or down in the lineup.
     *
     * @param integer $row Number of the row which is deleted.
     * @param string $direction Direction in which the band is shifted.
     * @return integer 1-> correct parameters, -1-> wrong parameters.
     */
    public function shiftBandLineup($row, $direction)
    {
        if (is_numeric($row) and ($direction == "up" or $direction == "down")) {
            $this->initLineUp();
            $lenght_lineup = count($_SESSION['lineup']);
            if ($lenght_lineup > 1) {
                $band_tmp = $_SESSION['lineup'][$row];
                if ($direction == "up" and $row > 0) {
                    $_SESSION['lineup'][$row] = $_SESSION['lineup'][$row - 1];
                    $_SESSION['lineup'][$row - 1] = $band_tmp;
                } elseif ($direction == "down" and $row < $lenght_lineup - 1) {
                    $_SESSION['lineup'][$row] = $_SESSION['lineup'][$row + 1];
                    $_SESSION['lineup'][$row + 1] = $band_tmp;
                }
            }
        } else {
            return -1;
        }
    }

    /**
     * Delete the complete lineup array.
     *
     * @return integer Always 1.
     */
    public function delLineUp()
    {
        unset($_SESSION['lineup']);
        return 1;
    }
}
