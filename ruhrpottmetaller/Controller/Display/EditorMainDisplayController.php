<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\IEvent;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\EventQueryModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayController extends AbstractDataMainDisplayController
{
    private EventQueryModel $eventQueryModel;
    private CityQueryModel $cityQueryModel;
    private IEvent $event;
    public function __construct(
        View $view,
        EventQueryModel $eventQueryModel,
        CityQueryModel $cityQueryModel,
        IEvent $event
    ) {
        parent::__construct($view);
        $this->eventQueryModel = $eventQueryModel;
        $this->cityQueryModel = $cityQueryModel;
        $this->event = $event;
    }

    protected function prepareThisController(): void
    {
        if (
            $this->event->getId()->isNull()
            or !$this->event->getName()->isNull()
            or !$this->event->getVenueId()->isNull()
            or !$this->event->getUrl()->isNull()
        ) {
            $this->view->set('event', $this->event);
        } else {
            $this->view->set(
                'event',
                $this->eventQueryModel->getEventById($this->event->getId())
            );
        }

        $this->view->set('cities', $this->cityQueryModel->getCities());
    }
}
