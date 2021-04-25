<?php

namespace ruhrpottmetaller\ModelMySQL;

use ruhrpottmetaller\Container\PreferencesShelf;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    private object $stub;

    public function setUp(): void
    {
        chdir("../../../deploy/");
        parent::setUp();
        $this->stub = new Model(new QueryStrategyPreferences());
    }
}
