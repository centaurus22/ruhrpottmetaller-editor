<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\IEvent;
use ruhrpottmetaller\Model\EventQueryModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayController extends AbstractDataMainDisplayController
{
    private EventQueryModel $model;
    private IEvent $event;
    public function __construct(
        View $view,
        EventQueryModel $model,
        IEvent $event
    ) {
        parent::__construct($view);
        $this->model = $model;
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
                $this->model->getEventById($this->event->getId())
            );
        }
    }
}
