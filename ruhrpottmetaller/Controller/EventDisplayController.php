<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;

class EventDisplayController extends AbstractDisplayController
{
    private QueryEventDatabaseModel $queryEventDatabaseModel;
    private RmString $Month;

    public function __construct(
        View $View,
        QueryEventDatabaseModel $queryEventDatabaseModel
    ) {
        parent::__construct($View);
        $this->queryEventDatabaseModel = $queryEventDatabaseModel;
    }

    public function setMonth(RmString $Month)
    {
        $this->Month = $Month;
    }

    protected function prepareThisController(): void
    {
        $this->View->set(
            'events',
            $this->queryEventDatabaseModel->getEventsByMonth($this->Month)
        );
    }
}