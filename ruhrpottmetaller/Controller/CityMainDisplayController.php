<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryCityModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryCityModel $queryCityDatabaseModel;

    public function __construct(
        View $view,
        QueryCityModel $queryCityDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryCityDatabaseModel = $queryCityDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();
        $cities = $this->queryCityDatabaseModel->getCities();

        if (!$cities->hasCurrent()) {
            $this->view->setTemplate(RmString::new('city_main_empty'));
            return;
        }

        $this->view->set('cities', $cities);
    }
}
