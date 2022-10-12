<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\View\View;

abstract class AbstractDisplayController implements IDisplayController
{
    protected array $subControllers = [];
    protected View $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public static function new(View $view)
    {
        return new static($view);
    }

    public function render(): AbstractRmString
    {
        $this->prepareThisController();
        $this->renderSubControllers();
        return $this->view->getOutput();
    }

    public function addSubController(
        string $subControllerId,
        AbstractDisplayController $displayController
    ): AbstractDisplayController {
        $this->subControllers[$subControllerId] = $displayController;
        return $this;
    }

    protected function renderSubControllers(): void
    {
        array_map(
            [$this, 'renderSubController'],
            array_keys($this->subControllers),
            $this->subControllers
        );
    }

    protected function renderSubController(
        string $subControllerId,
        AbstractDisplayController $subController
    ) {
        $this->view->set($subControllerId . 'Output', $subController->render());
    }

    /**
     * Just for unit testing
     */
    public function getViewData(): array
    {
        return $this->view->getAll();
    }
}
