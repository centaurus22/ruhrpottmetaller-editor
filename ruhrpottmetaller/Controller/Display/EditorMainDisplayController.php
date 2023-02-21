<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\NullEvent;
use ruhrpottmetaller\View\View;

class EditorMainDisplayController extends AbstractDataMainDisplayController
{
    public function __construct(
        View $view
    ) {
        parent::__construct($view);
    }

    protected function prepareThisController(): void
    {
        $this->view->set('event', NullEvent::new());
    }
}
