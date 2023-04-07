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
    private AbstractRmInt $venueId;
    private const NEW_CITY = 1;
    private const NEW_VENUE = 1;
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

        if ($this->cityId->get() === self::NEW_CITY) {
            $this->setValuesIfNewCity();
        } else {
            $this->setValuesIfNoNewCity();
        }
    }

    public function setCityId(AbstractRmInt $id)
    {
        $this->cityId = $id;
    }

    public function setVenueId(AbstractRmInt $id)
    {
        $this->venueId = $id;
    }

    private function setValuesIfNewCity()
    {
        $this->view->set('getNewCity', RmTrue::new(true));
        $this->view->set('getNewVenue', RmTrue::new(true));
    }

    private function setValuesIfNoNewCity()
    {
        $this->view->set('getNewCity', RmFalse::new(false));

        if ($this->venueId->get() === self::NEW_VENUE) {
            $this->view->set('getNewVenue', RmTrue::new(true));
        } else {
            $this->view->set('getNewVenue', RmFalse::new(false));
        }
    }
}
