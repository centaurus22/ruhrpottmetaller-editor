<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class GeneralHeadDisplayController extends AbstractDisplayController
{
    private RmString $pageName;

    public function __construct(View $view, RmString $pageName)
    {
        parent::__construct($view);
        $this->pageName = $pageName;
    }

    protected function prepareThisController(): void
    {
        $this->view->set('pageName', $this->pageName);
    }
}
