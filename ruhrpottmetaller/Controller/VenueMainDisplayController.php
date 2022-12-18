<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString};
use ruhrpottmetaller\Model\QueryVenueDatabaseModel;
use ruhrpottmetaller\View\View;

class VenueMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryVenueDatabaseModel $queryVenueDatabaseModel;

    public function __construct(
        View $view,
        QueryVenueDatabaseModel $queryVenueDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryVenueDatabaseModel = $queryVenueDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();
        $venues = $this->queryVenueDatabaseModel->getVenues();

        if (!$venues->hasCurrent()) {
            $this->view->setTemplate(RmString::new('venue_main_empty'));
            return;
        }

        $this->view->set('venues', $venues);
    }
}
