<?php

namespace ruhrpottmetaller\Controller\Display\Ajax;

use ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController;
use ruhrpottmetaller\Model\Query\SessionGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxUpdatedLineupDisplayController extends AbstractDataMainDisplayController
{
    private SessionGigQueryModel $gigQueryModel;

    public function __construct(
        View $view,
        SessionGigQueryModel $gigQueryModel,
    ) {
        parent::__construct($view);
        $this->gigQueryModel = $gigQueryModel;
    }

    protected function prepareThisController(): void
    {
        $gigs = $this->gigQueryModel->read();
        $gigs->resetPointer();
        $this->view->set('gigs', $gigs);
    }
}
