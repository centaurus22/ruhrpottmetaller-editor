<?php

namespace ruhrpottmetaller;

/**
 * Class to access and manipulate data saved in the session
 * Version 1.0.0
 */
class ModelSession
{
    /**
     * Initialize the session if it is not already initialized.
     *
     * @return int 1 if a session is activated or was already active,
     *  -1 if PHP sessions are disabled.
     */
    public function __construct()
    {
        switch(session_status()) {
            case PHP_SESSION_NONE:
            session_start();
            //no break
        case PHP_SESSION_ACTIVE:
            return 1;
        default:
            return -1;
        }

    }

    /**
     * Add an empty array to the PHP Session to save the lineup in the concert
     * editor if it is not already available.
     *
     * @return void
     */
    private function initLineUp(): void
    {
        if(!isset($_SESSION['lineup'])) {
            $_SESSION['lineup'] = array();
        }
    }

    /**
     * Get the lineup.
     *
     * @return array Array with the lineup data.
     */
    public function getBandsLineUp(): array
    {
        $this->initLineUp();
        return $_SESSION['lineup'];
    }

    /**
     * Delete the array witch contains the export statuses of the concerts.
     *
     * @return int Always 1.
     */
    public function delConcertDisplayStatus(): int
    {
        if (isset($_SESSION['concert_display_status'])) {
            unset($_SESSION['concert_display_status']);
        }
        return 1;
    }

    /**
     * Add a new band to the lineup array.
     *
     * @param int $row Number of the row under which the new band is added.
     * @return int 1-> parameter is an integer, -1-> parameter is no integer.
     */
    public function setBandLineUp(int $row): int
    {
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

    /**
     * Change information in a specific row of the lineup-.
     *
     * @param int $row Number of the row.
     * @param string $field Session variable which is filled.
     * @param mixed $value Value which is written in the session variable.
     * @return int 1-> row and band_id parameter are integers, -1-> one of
     *  those parameters are no integer.
     */
    public function updateBandLineUp(int $row, string $field, $value): int
    {
        $this->initLineUp();
        $_SESSION['lineup'][$row][$field] = $value;
        return 1;
    }

    /**
     * Delete a band from the lineup array.
     *
     * @param int $row Number of the row which is deleted.
     * @return int 1-> parameter is an integer, -1-> parameter is no integer.
     */
    public function delBandLineUp(int $row): int
    {
        $this->initLineUp();
        array_splice($_SESSION['lineup'], $row, 1);
        return 1;
}

    /**
     * Shift a band up or down in the lineup.
     *
     * @param int $row Number of the row which is deleted.
     * @param string $direction Direction in which the band is shifted.
     * @return int 1-> correct parameters, -1-> wrong parameters.
     */
    public function shiftBandLineup(int $row, string $direction): int
    {
        if ($direction == "up" or $direction == "down") {
            $this->initLineUp();
            $length_lineup = count($_SESSION['lineup']);
            if ($length_lineup > 1) {
                $band_tmp = $_SESSION['lineup'][$row];
                if ($direction == "up" and $row > 0) {
                    $_SESSION['lineup'][$row] = $_SESSION['lineup'][$row - 1];
                    $_SESSION['lineup'][$row - 1] = $band_tmp;
                } elseif ($direction == "down" and $row < $length_lineup - 1) {
                    $_SESSION['lineup'][$row] = $_SESSION['lineup'][$row + 1];
                    $_SESSION['lineup'][$row + 1] = $band_tmp;
                }
            }
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Delete the complete lineup array.
     *
     * @return int Always 1.
     */
    public function delLineUp(): int
    {
        unset($_SESSION['lineup']);
        return 1;
    }
}
