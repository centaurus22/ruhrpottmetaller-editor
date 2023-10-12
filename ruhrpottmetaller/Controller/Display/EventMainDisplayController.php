<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseEventQueryModel;
use ruhrpottmetaller\View\View;

class EventMainDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseEventQueryModel $queryEventDatabaseModel;

    public function __construct(
        View $view,
        DatabaseEventQueryModel $queryEventDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryEventDatabaseModel = $queryEventDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        $events = $this->queryEventDatabaseModel
            ->getEventsByMonth(RmDate::new($this->filterByParameter));

        if (!$events->hasCurrent()) {
            $this->view->setTemplate(RmString::new('event_main_empty'));
            return;
        }

        $this->view->set('events', $events);
    }
}