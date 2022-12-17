<?php

namespace ruhrpottmetaller\Controller;

use Exception;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class AbstractDataMainDisplayController extends AbstractDisplayController
{
    protected AbstractRmString $filterByValue;
    protected AbstractRmString $orderByValue;

    public function __construct(
        View $view,
        AbstractRmString $filterByValue,
        AbstractRmString $orderByValue
    ) {
        $this->filterByValue = $filterByValue;
        $this->orderByValue = $orderByValue;
        parent::__construct($view);
    }

    protected function getGetParameters(RmString $dataType): RmString
    {
        return RmString::new('?show=')
            ->concatWith($dataType)
            ->concatWith($this->filterByValue->asPrefixedWidth(RmString::new('&filter_by=')))
            ->concatWith($this->orderByValue->asPrefixedWidth(RmString::new('&order_by=')));
    }
}
