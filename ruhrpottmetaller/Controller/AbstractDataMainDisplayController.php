<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\View\View;

class AbstractDataMainDisplayController extends AbstractDisplayController
{
    protected AbstractRmString $filterByParameter;
    protected AbstractRmString $orderByParameter;

    public function __construct(
        View $view,
        AbstractRmString $filterByParameter,
        AbstractRmString $orderByParameter
    ) {
        $this->filterByParameter = $filterByParameter;
        $this->orderByParameter = $orderByParameter;
        parent::__construct($view);
    }

    protected function setGetParameters(): AbstractDataMainDisplayController
    {
        $this->view->set('filterByParameter', $this->filterByParameter);
        $this->view->set('orderByParameter', $this->orderByParameter);
        return $this;
    }
}
