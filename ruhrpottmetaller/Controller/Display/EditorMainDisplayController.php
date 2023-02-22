<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\IEvent;
use ruhrpottmetaller\Data\HighLevel\NullEvent;
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
        if ($this->event->getId()->isNull()) {
            $this->view->set('event', NullEvent::new());
        } else {
            $this->view->set(
                'event',
                $this->model->getEventById($this->event->getId())
            );
        }
    }
}
