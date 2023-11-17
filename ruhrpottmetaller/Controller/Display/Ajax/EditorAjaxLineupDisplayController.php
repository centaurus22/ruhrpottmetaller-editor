<?php

namespace ruhrpottmetaller\Controller\Display\Ajax;

use ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxLineupDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseGigQueryModel $gigQueryModel;
    private AbstractRmInt $eventId;

    public function __construct(
        View $view,
        DatabaseGigQueryModel $gigQueryModel,
        AbstractRmInt $eventId
    ) {
        parent::__construct($view);
        $this->gigQueryModel = $gigQueryModel;
        $this->eventId = $eventId;
    }

    protected function prepareThisController(): void
    {
        $gigs = $this->gigQueryModel->getGigsByEventId($this->eventId);
        $this->view->set('gigs', $gigs);
    }
}
