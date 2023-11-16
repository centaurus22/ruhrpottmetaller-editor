<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\View\View;

class CityNavSecondaryDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseCityQueryModel $queryModel;

    public function __construct(View $view, DatabaseCityQueryModel $queryModel)
    {
        parent::__construct($view);
        $this->queryModel = $queryModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();
        $this->view->set(
            'cities',
            $this->queryModel->getCities()
        );
    }
}
