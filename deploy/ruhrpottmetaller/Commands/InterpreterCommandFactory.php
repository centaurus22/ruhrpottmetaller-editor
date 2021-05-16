<?php


namespace ruhrpottmetaller\Commands;


use ruhrpottmetaller\Products\ProductFactory;
use ruhrpottmetaller\Storage;

class InterpreterCommandFactory extends AbstractCommandFactory
{
    private array $request_parameters;

    public function __construct(Storage $commandStorage, array $request_parameters, ProductFactory $productFactory)
    {
        $this->commandStorage = $commandStorage;
        $this->request_parameters = $request_parameters;
        $this->productFactory = $productFactory;
    }

    public function factoryMethod(): Storage
    {
        $this->productFactory->setProductName($this->getProductName());
        $this->productFactory->setDisplayType($this->getDisplayType());
        $this->productFactory->setFilters($this->getFilters());

        $this->commandStorage->addItem(new GetCommand(productFactory: $this->productFactory));
        return $this->commandStorage;
    }

    private function getProductName(): string
    {
        if(isset($this->request_parameters['edit'])) {
            return $this->request_parameters['edit'];
        } elseif (isset($this->request_parameters['display'])) {
            return $this->request_parameters['display'];
        } else {
            return 'event';
        }
    }

    private function getDisplayType(): string
    {
        if (isset($this->request_parameters['edit']))
            return 'edit';
        return 'display';
    }

    private function getFilters(): array
    {
        $display_prefix = 'display_';
        $filter = array();
        foreach (array_keys($this->request_parameters) as $request_parameter_key) {
            $is_filter_key = strpos($request_parameter_key, $display_prefix);
            if ($is_filter_key !== false) {
                $filter = $this->addFilterToFilters(
                    filter: $filter,
                    request_parameter_key: $request_parameter_key,
                    display_prefix: $display_prefix
                );
            }
        }
        return $filter;
    }

    private function addFilterToFilters(
        array $filter,
        string $request_parameter_key,
        string $display_prefix
    ): array {
        $request_parameter_key_without_prefix = str_replace($display_prefix, '', $request_parameter_key);
        $filter[$request_parameter_key_without_prefix] = $this->request_parameters[$request_parameter_key];
        return $filter;
    }
}