<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData;
use ruhrpottmetaller\Model\Command\DatabaseCommandModel;

abstract class AbstractCommandController
{
    protected ?DatabaseCommandModel $commandModel;
    protected ?AbstractNamedHighLevelData $highLevelData;

    public function __construct(
        ?DatabaseCommandModel       $commandModel,
        ?AbstractNamedHighLevelData $highLevelData
    ) {
        $this->commandModel = $commandModel;
        $this->highLevelData = $highLevelData;
    }

    public static function new(
        ?DatabaseCommandModel       $commandModel,
        ?AbstractNamedHighLevelData $highLevelData
    ): AbstractCommandController {
        return new static($commandModel, $highLevelData);
    }
}
