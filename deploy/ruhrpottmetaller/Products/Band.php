<?php


namespace ruhrpottmetaller\Products;


class Band implements IProduct
{
    private int $id;
    private string $name;
    private bool $visible;

    public function __clone(): void
    {

    }

    public function setInitialData(array $product_data): void
    {
        $this->id = $product_data['id'];
        $this->name = $product_data['name'];
        $this->visible = $product_data['visible'];
    }
}