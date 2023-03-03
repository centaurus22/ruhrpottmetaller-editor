<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\VenueQueryModel;
use ruhrpottmetaller\View\View;

class VenueMainDisplayController extends AbstractDataMainDisplayController
{
    private VenueQueryModel $queryVenueDatabaseModel;

    public function __construct(
        View $view,
        VenueQueryModel $queryVenueDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryVenueDatabaseModel = $queryVenueDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        if ($this->filterByParameter->isEmpty()) {
            $venues = $this->queryVenueDatabaseModel->getVenues();
        } else {
            $venues = $this->queryVenueDatabaseModel->getVenuesByCityName($this->filterByParameter);
        }

        if (!$venues->hasCurrent()) {
            $this->view->setTemplate(RmString::new('venue_main_empty'));
            return;
        }

        $this->view->set('venues', $venues);
    }
}
