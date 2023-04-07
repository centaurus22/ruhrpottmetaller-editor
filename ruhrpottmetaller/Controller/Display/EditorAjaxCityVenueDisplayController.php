<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\LowLevel\Bool\RmFalse;
use ruhrpottmetaller\Data\LowLevel\Bool\RmTrue;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\VenueQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxCityVenueDisplayController extends AbstractDataMainDisplayController
{
    private CityQueryModel $cityQueryModel;
    private VenueQueryModel $venueQueryModel;
    private AbstractRmInt $cityId;
    public function __construct(
        View $view,
        CityQueryModel $cityQueryModel,
        VenueQueryModel $venueQueryModel
    ) {
        parent::__construct($view);
        $this->cityQueryModel = $cityQueryModel;
        $this->venueQueryModel = $venueQueryModel;
    }

    protected function prepareThisController(): void
    {
        $this->view->set('cities', $this->cityQueryModel->getCities());
        $this->view->set('venues', $this->venueQueryModel->getVenues());
        if ($this->cityId->get() === 1) {
            $this->view->set('getNewVenue', RmTrue::new(true));
        } else {
            $this->view->set('getNewVenue', RmFalse::new(false));
        }
    }

    public function setCityId(AbstractRmInt $cityId)
    {
        $this->cityId = $cityId;
    }
}
