<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\BaseDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class DisplayFactory extends AbstractRmObject
{
    private IMainDisplayFactoryBehaviour $mainDisplayFactoryBehaviour;
    private IHeadDisplayFactoryBehaviour $headDisplayFactoryBehaviour;
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
            $this->headDisplayFactoryBehaviour->getDisplayController($this->templatePath)
        )->addSubController(
            'mainDisplayController',
            $this->mainDisplayFactoryBehaviour->getDisplayController(
                $this->templatePath,
                $pathToDatabaseConfig
            )
        );
    }

    public function setFactoryBehaviours(array $input): DisplayFactory
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
            $mainBehaviourClass = $allowedBehaviours[$input['display']];
            $pageName = RmString::new($input['display']);
        } else {
            $mainBehaviourClass = 'Event';
            $pageName = RmString::new('events');
        }
        $mainBehaviourClass = __NAMESPACE__ . '\\' . $mainBehaviourClass . 'MainDisplayFactoryBehaviour';

        $this->mainDisplayFactoryBehaviour = new $mainBehaviourClass();
        $this->headDisplayFactoryBehaviour = new GeneralHeadDisplayFactoryBehaviour($pageName);
        return $this;
    }
}
