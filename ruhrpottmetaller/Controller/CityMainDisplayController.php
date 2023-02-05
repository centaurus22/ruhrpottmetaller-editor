<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayController extends AbstractDataMainDisplayController
{
    private CityQueryModel $cityQueryModel;

    public function __construct(
        View $view,
        CityQueryModel $queryCityDatabaseModel
    ) {
        parent::__construct($view);
        $this->cityQueryModel = $queryCityDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        if ($this->filterByParameter->get() == '%') {
            $data = $this->cityQueryModel->getCitiesWithSpecialChar();
        } elseif ($this->filterByParameter->isEmpty()) {
            $data = $this->cityQueryModel->getCities();
        } else {
            $data = $this->cityQueryModel->getCitiesByFirstChar($this->filterByParameter);
        }

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('city_main_empty'));
            return;
        }

        $this->view->set('cities', $data);
    }
}
