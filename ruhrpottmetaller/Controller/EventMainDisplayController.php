<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString};
use ruhrpottmetaller\Model\QueryEventDatabaseModel;
use ruhrpottmetaller\View\View;

class EventMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryEventDatabaseModel $queryEventDatabaseModel;
    private RmDate $month;

    public function __construct(
        View $view,
        QueryEventDatabaseModel $queryEventDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryEventDatabaseModel = $queryEventDatabaseModel;
    }

    public function setMonth(RmDate $month)
    {
        $this->month = $month;
    }

    /**
     * @throws Exception
     */
    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        $events = $this->queryEventDatabaseModel->getEventsByMonth($this->month);
        $this->view->set('month', $this->month);

        if (!$events->hasCurrent()) {
            $this->view->setTemplate(RmString::new('event_main_empty'));
            return;
        }

        $this->view->set('events', $events);
    }
}
