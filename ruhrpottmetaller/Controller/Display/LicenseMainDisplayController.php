<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\View\View;

class LicenseMainDisplayController extends AbstractDataMainDisplayController
{

    public function __construct(
        View $view
    ) {
        parent::__construct($view);
    }

    protected function prepareThisController(): void
    {
    }
}
