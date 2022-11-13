<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayController extends AbstractDisplayController
{
    private QueryCityDatabaseModel $queryCityDatabaseModel;

    public function __construct(
        View $view,
        QueryCityDatabaseModel $queryCityDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryCityDatabaseModel = $queryCityDatabaseModel;
    }

    /**
     * @throws Exception
     */
    protected function prepareThisController(): void
    {
        $cities = $this->queryCityDatabaseModel->getCities();

        if (!$cities->hasCurrent()) {
            $this->view->setTemplate(RmString::new('city_main_empty'));
            return;
        }

        $this->view->set('cities', $cities);
    }
}
