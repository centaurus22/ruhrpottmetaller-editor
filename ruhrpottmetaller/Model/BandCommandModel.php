<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Band;

class BandCommandModel extends AbstractCommandModel
{
    public static function new(?\mysqli $connection): BandCommandModel
    {
        return new static($connection);
    }

    public function updateBand(Band $band)
    {
        $query = 'UPDATE band SET name = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'sii',
            [
                $band->getName()->get(),
                $band->getIsVisible()->get(),
                $band->getId()->get()
            ]
        );
    }
}
