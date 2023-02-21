<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\BandQueryModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayController extends AbstractDataMainDisplayController
{
    private BandQueryModel $bandQueryModel;

    public function __construct(
        View $view,
        BandQueryModel $bandQueryModel
    ) {
        parent::__construct($view);
        $this->bandQueryModel = $bandQueryModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();
        $data = $this->bandQueryModel->getBands();

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('band_main_empty'));
            return;
        }

        $this->view->set('bands', $data);
    }
}
