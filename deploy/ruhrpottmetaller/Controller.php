<?php

namespace ruhrpottmetaller;

class Controller
{
    private array $requestParameters;
    private object $mainProductStorage;

    public function __construct(array $requestParameters)
    {
        $this->requestParameters = $requestParameters;
    }

    public function getOutput(): string
    {
        $mainProductCreator = new MainProductCreator($this->requestParameters);
        $this->mainProductStorage = $mainProductCreator->factoryMethod();

    }

    private function displayProducts(): string
    {

    }

    private function displayForm(): string
    {

    }
}