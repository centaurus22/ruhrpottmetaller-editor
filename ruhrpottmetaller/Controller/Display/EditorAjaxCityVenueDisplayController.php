<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmFalse;
use ruhrpottmetaller\Data\LowLevel\Bool\RmTrue;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxCityVenueDisplayController extends AbstractDataMainDisplayController
{
    private CityQueryModel $cityQueryModel;
    private DatabaseVenueQueryModel $venueQueryModel;
    private AbstractRmInt $cityId;
    private AbstractRmInt $venueId;
    private const NEW_CITY = 1;
    private const NEW_VENUE = 1;
    public function __construct(
        View $view,
        CityQueryModel $cityQueryModel,
        DatabaseVenueQueryModel $venueQueryModel
    ) {
        parent::__construct($view);
        $this->cityQueryModel = $cityQueryModel;
        $this->venueQueryModel = $venueQueryModel;
    }

    protected function prepareThisController(): void
    {
        $cities = $this->cityQueryModel->getCities();
        $this->view->set('cityId', $this->cityId);
        $cities->add(City::new()->setId(RmInt::new(1))->setName(RmString::new('New city')));
        $this->view->set('cities', $cities);

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

        if ($this->cityId->get() >= 1) {
            $this->view->set(
                'venues',
                $this->addNewVenueObject($this->venueQueryModel->getVenuesByCityId($this->cityId))
            );
            $this->view->set('venueId', $this->venueId);
        } else {
            $this->view->set('venues', $this->addNewVenueObject($this->venueQueryModel->getVenues()));
        }

        if ($this->venueId->get() === self::NEW_VENUE) {
            $this->view->set('getNewVenue', RmTrue::new(true));
        } else {
            $this->view->set('getNewVenue', RmFalse::new(false));
        }
    }

    private function addNewVenueObject(RmArray $venues): RmArray
    {
        return $venues->add(Venue::new()->setId(RmInt::new(1))->setName(RmString::new('New venue')));
    }
}
