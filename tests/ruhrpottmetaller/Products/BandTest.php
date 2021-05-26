<?php

namespace ruhrpottmetaller\Products;

use PHPUnit\Framework\TestCase;

class BandTest extends TestCase
{
    private IProduct $band;

    protected function setUp(): void
    {
        parent::setUp();
        $this->band = new Band();
    }

    public function testGetId_CloneObjectAndDataAndReceiveProvidedIdBack()
    {
        $band = clone $this->band;
        $band->setInitialData(array('id' => 4, 'name' => 'null', 'visible' => false));
        self::assertEquals(4, $band->getId());
    }

    public function testGetId_CloneObjectAndDataAndReceiveProvidedNameBack()
    {
        $band = clone $this->band;
        $band->setInitialData(array('id' => 0, 'name' => 'Iron Kobra', 'visible' => true));
        self::assertEquals('Iron Kobra', $band->getName());
    }

    public function testGetId_CloneObjectAndDataAndReceiveProvidedVisibleStatusBack()
    {
        $band = clone $this->band;
        $band->setInitialData(array('id' => 4, 'name' => 'null', 'visible' => false));
        self::assertEquals(false, $band->getVisibilityStatus());
    }
}
