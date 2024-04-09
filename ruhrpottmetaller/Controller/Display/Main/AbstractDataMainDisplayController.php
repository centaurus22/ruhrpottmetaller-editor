<?php

namespace ruhrpottmetaller\Controller\Display\Main;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

abstract class AbstractDataMainDisplayController extends AbstractDisplayController
{
    protected AbstractRmString $filterByParameter;
    protected AbstractRmString $orderByParameter;

    public function setGetParameters(
        AbstractRmString $filterByParameter,
        AbstractRmString $orderByParameters
    ): AbstractDataMainDisplayController {
        $this->filterByParameter = $filterByParameter;
        $this->orderByParameter = $orderByParameters;
        return $this;
    }

    protected function transferGetParametersToView(): AbstractDataMainDisplayController
    {
        $this->view->set('filterByParameter', $this->filterByParameter);
        $this->view->set('orderByParameter', $this->orderByParameter);
        return $this;
    }
}
