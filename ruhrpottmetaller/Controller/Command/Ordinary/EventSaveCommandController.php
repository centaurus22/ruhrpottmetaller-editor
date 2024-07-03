<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

use ruhrpottmetaller\Data\HighLevel\Event;
use ruhrpottmetaller\Model\Command\DatabaseCityCommandModel;
use ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\SessionGigQueryModel;

class EventSaveCommandController extends AbstractOrdinaryCommandController
{
    private DatabaseVenueCommandModel $venueCommandModel;
    private DatabaseCityCommandModel $cityCommandModel;
    private SessionGigQueryModel $sessionGigQueryModel;
    private SessionGigCommandModel $sessionGigCommandModel;

    public function __construct(
        $commandModel,
        Event $data,
        DatabaseVenueCommandModel $venueCommandModel,
        DatabaseCityCommandModel $cityCommandModel
    ) {
        parent::__construct($commandModel, $data);
        $this->venueCommandModel = $venueCommandModel;
        $this->cityCommandModel = $cityCommandModel;
    }

    public function execute(): void
    {
        $venue = $this->data->getVenue();
        $city = $venue->getCity();

        if ($city->getId()->get() == 1) {
            $city->setId($this->cityCommandModel->addCity($city));
        } elseif ($city->getId()->isNull()) {
            throw new \Exception('A city must be provided');
        }

        if ($venue->getId()->get() == 1) {
            $venue->setId($this->venueCommandModel->addVenue($venue));
        } elseif ($venue->getId()->isNull()) {
            throw new \Exception('A venue must be provided');
        }

        if ($this->data->getId()->get() === 0) {
            $this->commandModel->addEvent($this->data);
        } else {
            $this->commandModel->replaceData($this->data);
        }


    }
}
