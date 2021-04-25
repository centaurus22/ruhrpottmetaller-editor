<?php

namespace ruhrpottmetaller;

class Controller
{
    private array $requestParameters;

    public function __construct(array $requestParameters)
    {
        $this->requestParameters = $requestParameters;
    }
}