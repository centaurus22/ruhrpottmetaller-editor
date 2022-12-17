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
        AbstractRmString $filterByValue,
        AbstractRmString $orderByValue
    ) {
        parent::__construct($view, $filterByValue, $orderByValue);
        $this->queryBandDatabaseModel = $queryBandDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->view->set(
            'getParameters',
            $this->getGetParameters(RmString::new('bands'))
        );
        $data = $this->queryBandDatabaseModel->getBands();

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('band_main_empty'));
            return;
        }

        $this->view->set('bands', $data);
    }
}
