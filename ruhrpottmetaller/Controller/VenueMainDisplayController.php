<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryVenueModel;
use ruhrpottmetaller\View\View;

class VenueMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryVenueModel $queryVenueDatabaseModel;

    public function __construct(
        View $view,
        QueryVenueModel $queryVenueDatabaseModel
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
