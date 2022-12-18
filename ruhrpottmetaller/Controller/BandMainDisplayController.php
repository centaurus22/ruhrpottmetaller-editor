<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryBandDatabaseModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryBandDatabaseModel $queryBandDatabaseModel;

    public function __construct(
        View $view,
        QueryBandDatabaseModel $queryBandDatabaseModel,
        AbstractRmString $filterByParameter,
        AbstractRmString $orderByParameter
    ) {
        parent::__construct($view, $filterByParameter, $orderByParameter);
        $this->queryBandDatabaseModel = $queryBandDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->setGetParameters();
        $data = $this->queryBandDatabaseModel->getBands();

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('band_main_empty'));
            return;
        }

        $this->view->set('bands', $data);
    }
}
