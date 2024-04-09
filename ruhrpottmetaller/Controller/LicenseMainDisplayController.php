<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\CityQueryModel;
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
