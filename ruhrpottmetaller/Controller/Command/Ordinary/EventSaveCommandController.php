<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

use ruhrpottmetaller\Data\HighLevel\Event;
use ruhrpottmetaller\Model\Command\DatabaseCityCommandModel;
use ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel;

class EventSaveCommandController extends AbstractOrdinaryCommandController
{
    private DatabaseVenueCommandModel $venueCommandModel;
    private DatabaseCityCommandModel $cityCommandModel;

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
        if ($venue->getId()->get() == 1) {
            $newVenueId = $this->venueCommandModel->addVenue($venue);
            $venue->setId($newVenueId);
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
