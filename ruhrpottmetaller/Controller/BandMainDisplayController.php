<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryBandModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryBandModel $queryBandDatabaseModel;

    public function __construct(
        View $view,
        QueryBandModel $queryBandDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryBandDatabaseModel = $queryBandDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();
        $data = $this->queryBandDatabaseModel->getBands();

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('band_main_empty'));
            return;
        }

        $this->view->set('bands', $data);
    }
}
