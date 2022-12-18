<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Controller\{AbstractDisplayController, BaseDisplayController};
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

    public function setFactoryBehaviours(array $input): DisplayFactory
    {
        $allowedBehaviours = [
            'events' => 'Event',
            'bands' => 'Band',
            'venues' => 'Venue',
            'cities' => 'City'
        ];

        if (
            isset($input['show'])
            and array_key_exists($input['show'], $allowedBehaviours)
        ) {
            $mainBehaviourClass = $allowedBehaviours[$input['show']];
            $pageName = RmString::new($input['show']);
        } else {
            $mainBehaviourClass = 'Event';
            $pageName = RmString::new('events');
        }
        $mainBehaviourClass = __NAMESPACE__ . '\\' . $mainBehaviourClass . 'MainDisplayFactoryBehaviour';

        $this->mainDisplayFactoryBehaviour = new $mainBehaviourClass();
        $this->headDisplayFactoryBehaviour = new GeneralHeadDisplayFactoryBehaviour($pageName);
        return $this;
    }

    public function getDisplayController(array $input): AbstractDisplayController
    {
        $baseDisplayController =  new BaseDisplayController(
            View::new(
                $this->templatePath,
                RmString::new('ruhrpottmetaller-editor')
            )
        );

        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $mainDisplayController = $this->mainDisplayFactoryBehaviour->getDisplayController(
            $this->templatePath,
            $pathToDatabaseConfig
        )->setGetParameters(
            RmString::new($input['filter_by'] ?? null),
            RmString::new($input['order_by'] ?? null)
        );

        return $baseDisplayController
            ->addSubController(
                'headDisplayController',
                $this->headDisplayFactoryBehaviour->getDisplayController($this->templatePath)
            )
            ->addSubController(
                'mainDisplayController',
                $mainDisplayController
            );
    }
}
