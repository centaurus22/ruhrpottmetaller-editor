<?php


namespace ruhrpottmetaller\Commands;

class SetCommand extends AbstractCommand
{
    public function __construct(string $product_name)
    {
        $this->product_name = $product_name;
    }

}