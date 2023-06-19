<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\IEvent;
use ruhrpottmetaller\Model\DatabaseEventQueryModel;
use ruhrpottmetaller\Model\SessionGigCommandModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseEventQueryModel $eventQueryModel;
    private SessionGigCommandModel $gigCommandModel;
    private IEvent $event;
    public function __construct(
        View $view,
        DatabaseEventQueryModel $databaseEventQueryModel,
        SessionGigCommandModel $sessionGigCommandModel,
        IEvent $event
    ) {
        parent::__construct($view);
        $this->eventQueryModel = $databaseEventQueryModel;
        $this->gigCommandModel = $sessionGigCommandModel;
        $this->event = $event;
    }

    protected function prepareThisController(): void
    {
        if (
            !$this->event->getId()->isNull()
            and $this->event->getName()->isNull()
            and $this->event->getVenueId()->isNull()
            and $this->event->getUrl()->isNull()
        ) {
            $this->event = $this->eventQueryModel->getEventById($this->event->getId());
        }
        $this->view->set('event', $this->event);
        $this->gigCommandModel->load($this->event->getGigs());
    }
}
