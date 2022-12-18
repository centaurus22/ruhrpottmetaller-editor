<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

class AbstractDataMainDisplayController extends AbstractDisplayController
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
