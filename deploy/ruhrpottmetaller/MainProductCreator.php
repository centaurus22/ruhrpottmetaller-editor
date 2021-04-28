<?php

namespace ruhrpottmetaller;

class MainProductCreator extends AbstractProductCreator
{
    private array $requestParameters;

    public function __construct(array $requestParameters)
    {
        $this->requestParameters = $requestParameters;
    }

    public function factoryMethod(): ProductStorage
    {
    }
}

