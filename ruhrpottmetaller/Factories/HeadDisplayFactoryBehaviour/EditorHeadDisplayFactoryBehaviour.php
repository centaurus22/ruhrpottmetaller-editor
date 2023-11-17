<?php

namespace ruhrpottmetaller\Factories\HeadDisplayFactoryBehaviour;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\GeneralHeadDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class EditorHeadDisplayFactoryBehaviour implements IHeadDisplayFactoryBehaviour
{
    private RmString $pageName;

    public function __construct($pageName)
    {
        $this->pageName = $pageName;
    }

    public function getDisplayController(
        RmString $templatePath
    ): AbstractDisplayController {
        return new GeneralHeadDisplayController(
            View::new(
                $templatePath,
                RmString::new('editor_head')
            ),
            $this->pageName
        );
    }
}
