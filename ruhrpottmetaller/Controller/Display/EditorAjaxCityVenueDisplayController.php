<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxCityVenueDisplayController extends AbstractDataMainDisplayController
{
    private CityQueryModel $cityQueryModel;
    public function __construct(
        View $view,
        CityQueryModel $cityQueryModel
    ) {
        parent::__construct($view);
        $this->cityQueryModel = $cityQueryModel;
    }

    protected function prepareThisController(): void
    {
        $this->view->set('cities', $this->cityQueryModel->getCities());
    }
}
