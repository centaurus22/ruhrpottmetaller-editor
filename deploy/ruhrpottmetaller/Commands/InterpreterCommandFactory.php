<?php


namespace ruhrpottmetaller\Commands;


use ruhrpottmetaller\Products\ProductFactory;
use ruhrpottmetaller\Storage\Storage;

class InterpreterCommandFactory extends AbstractCommandFactory
{
    private array $request_parameters;
    private  const PRODUCT_CLASS_FOLDER = 'ruhrpottmetaller/Products/';
    private string $display_type;

    public function __construct(
        Storage $commandStorage,
        array $request_parameters,
        ProductFactory $productFactory,
    ) {
        $this->commandStorage = $commandStorage;
        $this->request_parameters = $request_parameters;
        $this->productFactory = $productFactory;
    }

    public function factoryMethod(): Storage
    {
        $this->display_type = $this->getDisplayType();
        $this->productFactory->setDisplayType($this->display_type);
        $this->productFactory->setProductName($this->getProductName());
        $this->productFactory->setFilters($this->getFilters());

        $this->commandStorage->addItem(new GetCommand(productFactory: $this->productFactory));
        return $this->commandStorage;
    }

    private function getProductName(): string
    {
        if (
            isset($this->request_parameters[$this->display_type])
            and $this->isProductName($this->request_parameters[$this->display_type])
        ) {
            return $this->request_parameters[$this->display_type];
        }
        return 'event';
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

    protected function isProductName(string $product_name): bool
    {
        $product_class_file_name = ucfirst($product_name) . '.php';
        return in_array($product_class_file_name, $this->getFilesInProductClassFolder());
    }

    protected function getFilesInProductClassFolder(): array
    {
        return scandir(directory: self::PRODUCT_CLASS_FOLDER);
    }

}