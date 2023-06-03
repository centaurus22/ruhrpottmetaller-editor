<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class AjaxDisplayFactory extends AbstractFactory
{
    private object $displayFactoryBehaviour;
    private RmString $templatePath;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
        $this->templatePath = RmString::new('../templates/');
    }

    public function setFactoryBehaviours(array $input): AjaxDisplayFactory
    {

        if (isset($input['content']) and $input['content'] == 'city_venue') {
            $behaviour = 'EditorAjaxCityVenue';
        } else {
            throw new \HttpInvalidParamException('Ajax call not understood');
        }

        $behaviourClass = __NAMESPACE__ . '\\' . $behaviour . 'DisplayFactoryBehaviour';
        $this->displayFactoryBehaviour = new $behaviourClass();

        return $this;
    }

    public function getDisplayController(array $input): AbstractDisplayController
    {
        return $this->displayFactoryBehaviour->getDisplayController(
            $this->templatePath,
            $this->connection,
            $input
        );
    }
}
