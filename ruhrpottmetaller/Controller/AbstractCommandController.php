<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData;
use ruhrpottmetaller\Model\AbstractCommandModel;

abstract class AbstractCommandController
{
    protected AbstractCommandModel $commandModel;
    protected AbstractHighLevelData $highLevelData;

    public function __construct(
        AbstractCommandModel $commandModel,
        AbstractHighLevelData $highLevelData
    ) {
        $this->commandModel = $commandModel;
        $this->highLevelData = $highLevelData;
    }

    public static function new(
        AbstractCommandModel $commandModel,
        AbstractHighLevelData $highLevelData
    ) {
        return new static($commandModel, $highLevelData);
    }
}
