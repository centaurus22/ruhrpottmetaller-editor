<?php

namespace ruhrpottmetaller;

class Controller
{
    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }
}