<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\View\View;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;

class EventDisplayController extends AbstractDisplayController
{
    private QueryEventDatabaseModel $queryEventDatabaseModel;
    private RmDate $Month;

    public function __construct(
        View $View,
        QueryEventDatabaseModel $queryEventDatabaseModel
    ) {
        parent::__construct($View);
        $this->queryEventDatabaseModel = $queryEventDatabaseModel;
    }

    public function setMonth(RmDate $Month)
    {
        $this->Month = $Month;
    }

    /**
     * @throws \Exception
     */
    protected function prepareThisController(): void
    {
        $Events = $this->queryEventDatabaseModel->getEventsByMonth($this->Month);
        $this->View->set('month', $this->Month);

        if (!$Events->hasCurrent()) {
            return;
        }

        $this->View->set(
            'events',
            $this->queryEventDatabaseModel->getEventsByMonth($this->Month)
        );
    }
}