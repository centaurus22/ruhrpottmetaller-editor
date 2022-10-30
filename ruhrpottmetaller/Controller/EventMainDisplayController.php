<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;
use ruhrpottmetaller\View\View;

class EventMainDisplayController extends AbstractDisplayController
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
        $events = $this->queryEventDatabaseModel->getEventsByMonth($this->month);
        $this->view->set('month', $this->month);

        if (!$events->hasCurrent()) {
            return;
        }

        $this->view->set(
            'events',
            $this->queryEventDatabaseModel->getEventsByMonth($this->month)
        );
    }
}
