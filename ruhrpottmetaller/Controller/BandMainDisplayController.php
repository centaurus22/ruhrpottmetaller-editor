<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryBandDatabaseModel;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayController extends AbstractDisplayController
{
    private QueryBandDatabaseModel $queryBandDatabaseModel;

    public function __construct(
        View $view,
        QueryBandDatabaseModel $queryBandDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryBandDatabaseModel = $queryBandDatabaseModel;
    }

    /**
     * @throws Exception
     */
    protected function prepareThisController(): void
    {
        $cities = $this->queryBandDatabaseModel->getBands();

        if (!$cities->hasCurrent()) {
            $this->view->setTemplate(RmString::new('band_main_empty'));
            return;
        }

        $this->view->set('bands', $cities);
    }
}
