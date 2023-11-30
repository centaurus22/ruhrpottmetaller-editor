<?php

namespace ruhrpottmetaller\Controller\Display\Ajax;

use ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
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

        if (!$gigs->hasCurrent()) {
            $this->view->setTemplate(RmString::new('ajax/editor_lineup_empty'));
            return;
        }

        $this->view->set('gigs', $gigs);
    }
}
