<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\BaseDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class DisplayFactory extends AbstractRmObject
{
    private IFactoryBehaviour $factoryBehaviour;
    private RmString $templatePath;

    public function __construct()
    {
        $this->templatePath = RmString::new('../templates/');
    }

    /**
     * @throws \Exception
     */
    public function getDisplayController(): AbstractDisplayController
    {
        $baseDisplayController =  new BaseDisplayController(
            View::new(
                $this->templatePath,
                RmString::new('ruhrpottmetaller-editor')
            )
        );

        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        return $baseDisplayController->addSubController(
            'headDisplayController',
            $this->factoryBehaviour->getHeadDisplayController($this->templatePath)
        )->addSubController(
            'mainDisplayController',
            $this->factoryBehaviour->getMainDisplayController(
                $this->templatePath,
                $pathToDatabaseConfig
            )
        );
    }

    public function setFactoryBehaviour(array $input): DisplayFactory
    {
        $allowedBehaviours = [
            'events' => 'Event',
            'bands' => 'Band',
            'venues' => 'Venue',
            'cities' => 'City'
        ];

        if (
            isset($input['display'])
            and array_key_exists($input['display'], $allowedBehaviours)
        ) {
            $behaviour = $allowedBehaviours[$input['display']];
        } else {
            $behaviour = 'Event';
        }
        $behaviour = __NAMESPACE__ . '\\' . $behaviour . 'FactoryBehaviour';

        $this->factoryBehaviour = new $behaviour();
        return $this;
    }
}
