<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\View\View;

class CityNavSecondaryDisplayController extends AbstractDataMainDisplayController
{
    private CityQueryModel $queryModel;

    public function __construct(View $view, CityQueryModel $queryModel)
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
