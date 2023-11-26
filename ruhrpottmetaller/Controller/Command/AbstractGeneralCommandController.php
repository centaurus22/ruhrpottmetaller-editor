<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData;

abstract class AbstractGeneralCommandController extends AbstractCommandController
{
    protected ?AbstractNamedHighLevelData $highLevelData;

    public function __construct(
        $commandModel,
        ?AbstractNamedHighLevelData $highLevelData
    ) {
        parent::__construct($commandModel);
        $this->highLevelData = $highLevelData;
    }

    public static function new(
        $commandModel,
        ?AbstractNamedHighLevelData $highLevelData
    ): AbstractCommandController {
        return new static($commandModel, $highLevelData);
    }

    abstract public function execute(): void;
}
