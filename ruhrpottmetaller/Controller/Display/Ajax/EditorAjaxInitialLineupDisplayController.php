<?php

namespace ruhrpottmetaller\Controller\Display\Ajax;

use ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxInitialLineupDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseGigQueryModel $gigQueryModel;
    private SessionGigCommandModel $gigCommandModel;
    private AbstractRmInt $eventId;

    public function __construct(
        View $view,
        DatabaseGigQueryModel $gigQueryModel,
        SessionGigCommandModel $gigCommandModel,
        AbstractRmInt $eventId
    ) {
        parent::__construct($view);
        $this->gigQueryModel = $gigQueryModel;
        $this->gigCommandModel = $gigCommandModel;
        $this->eventId = $eventId;
    }

    protected function prepareThisController(): void
    {
        $gigs = $this->gigQueryModel->getGigsByEventId($this->eventId);
        $this->gigCommandModel->load($gigs);
        $this->view->set('gigs', $gigs);
    }
}
