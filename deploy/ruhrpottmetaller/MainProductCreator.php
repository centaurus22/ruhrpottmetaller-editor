<?php

namespace ruhrpottmetaller;

class MainProductCreator extends AbstractProductCreator
{
    private array $requestParameters;
    private string $product;

    public function __construct(array $requestParameters)
    {
        $this->requestParameters = $requestParameters;
        $this->product = $this->getProductNameByRequestParameters();

    }

    public function factoryMethod(): ProductStorage
    {
    }

    private function getProductNameByRequestParameters(): string
    {
        if(isset($this->requestParameters['edit'])) {
            $possibleProducts[] = $this->requestParameters['edit'];
        }
        if(isset($this->requestParameters['display'])) {
            $possibleProducts[] = $this->requestParameters['display'];
        }
        $possibleProducts[] = 'event';

        foreach ($possibleProducts as $product) {
            if ($this->isProduct($product)) {
                return $product;
            }
        }

    }
}

