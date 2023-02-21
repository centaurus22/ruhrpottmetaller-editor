<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData;
use ruhrpottmetaller\Model\AbstractCommandModel;

abstract class AbstractCommandController
{
    protected ?AbstractCommandModel $commandModel;
    protected ?AbstractNamedHighLevelData $highLevelData;

    public function __construct(
        ?AbstractCommandModel $commandModel,
        ?AbstractNamedHighLevelData $highLevelData
    ) {
        $this->commandModel = $commandModel;
        $this->highLevelData = $highLevelData;
    }

    public static function new(
        ?AbstractCommandModel $commandModel,
        ?AbstractNamedHighLevelData $highLevelData
    ) {
        return new static($commandModel, $highLevelData);
    }
}
