<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryCityDatabaseModel $queryCityDatabaseModel;

    public function __construct(
        View $view,
        QueryCityDatabaseModel $queryCityDatabaseModel,
        AbstractRmString $filterByParameter,
        AbstractRmString $orderByParameter
    ) {
        parent::__construct($view, $filterByParameter, $orderByParameter);
        $this->queryCityDatabaseModel = $queryCityDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->setGetParameters();
        $cities = $this->queryCityDatabaseModel->getCities();

        if (!$cities->hasCurrent()) {
            $this->view->setTemplate(RmString::new('city_main_empty'));
            return;
        }

        $this->view->set('cities', $cities);
    }
}
