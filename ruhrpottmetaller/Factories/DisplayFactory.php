<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, BaseDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\HeadDisplayFactoryBehaviour\EditorHeadDisplayFactoryBehaviour;
use ruhrpottmetaller\Factories\HeadDisplayFactoryBehaviour\GeneralHeadDisplayFactoryBehaviour;
use ruhrpottmetaller\Factories\HeadDisplayFactoryBehaviour\IHeadDisplayFactoryBehaviour;
use ruhrpottmetaller\View\View;

class DisplayFactory extends AbstractFactory
{
    private IGeneralDisplayFactoryBehaviour $mainDisplayFactoryBehaviour;
    private IHeadDisplayFactoryBehaviour $headDisplayFactoryBehaviour;
    private IGeneralDisplayFactoryBehaviour $navSecondaryDisplayFactoryBehaviour;
    private RmString $templatePath;
    private string $generalBehaviour;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
        $this->templatePath = RmString::new('../templates/');
    }

    public function setFactoryBehaviours(array $input): DisplayFactory
    {
        $allowedBehaviours = $this->getAllowedFactoryBehaviours();

        if (isset($input['action']) and $input['action'] == 'edit') {
            $this->generalBehaviour = $allowedBehaviours[$input['action']];
            $pageName = RmString::new($input['action']);
        } elseif (
            isset($input['show'])
            and array_key_exists($input['show'], $allowedBehaviours)
        ) {
            $this->generalBehaviour = $allowedBehaviours[$input['show']];
            $pageName = RmString::new($input['show']);
        } else {
            $this->generalBehaviour = 'Event';
            $pageName = RmString::new('events');
        }

        $mainBehaviourClass = __NAMESPACE__ . '\\' . $this->generalBehaviour . 'MainDisplayFactoryBehaviour';
        $this->mainDisplayFactoryBehaviour = new $mainBehaviourClass();


        if (isset($input['action']) and $input['action'] == 'edit') {
            $this->mainDisplayFactoryBehaviour->setInput($input);
        }

        if ($pageName->get() == 'edit') {
            $this->headDisplayFactoryBehaviour = new EditorHeadDisplayFactoryBehaviour($pageName);
        } else {
            $this->headDisplayFactoryBehaviour = new GeneralHeadDisplayFactoryBehaviour($pageName);
        }
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

        $mainDisplayController = $this->mainDisplayFactoryBehaviour->getDisplayController(
            $this->templatePath,
            $this->connection
        )->setGetParameters(
            RmString::new($input['filter_by'] ?? null),
            RmString::new($input['order_by'] ?? null)
        );

        $baseDisplayController->addSubController(
            'headDisplayController',
            $this->headDisplayFactoryBehaviour->getDisplayController($this->templatePath)
        )->addSubController(
            'mainDisplayController',
            $mainDisplayController
        );

        return $this->addNavSecondaryDisplayController(
            $baseDisplayController,
            $input
        );
    }

    private function addNavSecondaryDisplayController(
        BaseDisplayController $baseDisplayController,
        array $input
    ): BaseDisplayController {
        if (!in_array($this->generalBehaviour, ['Event', 'Band', 'Venue', 'City'])) {
            return $baseDisplayController;
        }

        $navSecondaryBehaviourClass = __NAMESPACE__
            . '\\' . $this->generalBehaviour . 'NavSecondaryDisplayFactoryBehaviour';
        $this->navSecondaryDisplayFactoryBehaviour = new $navSecondaryBehaviourClass();

        $navSecondaryDisplayController = $this->navSecondaryDisplayFactoryBehaviour->getDisplayController(
            $this->templatePath,
            $this->connection
        )->setGetParameters(
            RmString::new($input['filter_by'] ?? null),
            RmString::new($input['order_by'] ?? null)
        );


        return $baseDisplayController->addSubController(
            'navSecondaryDisplayController',
            $navSecondaryDisplayController
        );
    }

    private function getAllowedFactoryBehaviours(): array
    {
        return [
            'edit' => 'Editor',
            'events' => 'Event',
            'bands' => 'Band',
            'venues' => 'Venue',
            'cities' => 'City',
            'license' => 'License'
        ];
    }
}
