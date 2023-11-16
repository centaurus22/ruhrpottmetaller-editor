<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseBandQueryModel $bandQueryModel;

    public function __construct(
        View $view,
        DatabaseBandQueryModel $bandQueryModel
    ) {
        parent::__construct($view);
        $this->bandQueryModel = $bandQueryModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        if ($this->filterByParameter->get() == '%') {
            $data = $this->bandQueryModel->getBandsWithSpecialChar();
        } elseif ($this->filterByParameter->isEmpty()) {
            $data = $this->bandQueryModel->getBands();
        } else {
            $data = $this->bandQueryModel->getBandsByFirstChar($this->filterByParameter);
        }

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('band_main_empty'));
            return;
        }

        $this->view->set('bands', $data);
    }
}
