<?php

namespace ruhrpottmetaller;

class ModelSession
{
    public function __construct()
    {
        switch (session_status()) {
            case PHP_SESSION_NONE:
                session_start();
                //no break
            case PHP_SESSION_ACTIVE:
                return 1;
            default:
                return -1;
        }
    }

    private function initLineUp(): void
    {
        if (!isset($_SESSION['lineup'])) {
            $_SESSION['lineup'] = array();
        }
    }

    public function getBandsLineUp(): array
    {
        $this->initLineUp();
        return $_SESSION['lineup'];
    }

    public function delConcertDisplayStatus(): int
    {
        if (isset($_SESSION['concert_display_status'])) {
            unset($_SESSION['concert_display_status']);
        }
        return 1;
    }

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

    public function updateBandLineUp(int $row, string $field, $value): int
    {
        $this->initLineUp();
        $_SESSION['lineup'][$row][$field] = $value;
        return 1;
    }

    public function delBandLineUp(int $row): int
    {
        $this->initLineUp();
        array_splice($_SESSION['lineup'], $row, 1);
        return 1;
    }

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

    public function delLineUp(): int
    {
        unset($_SESSION['lineup']);
        return 1;
    }
}
