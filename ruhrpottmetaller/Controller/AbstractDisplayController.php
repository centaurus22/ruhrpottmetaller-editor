<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\View\View;

abstract class AbstractDisplayController implements IDisplayController
{
    protected array $subControllers = [];
    protected View $View;

    public function __construct(View $View) {
        $this->View = $View;
    }

    public static function new(View $View)
    {
        return new static($View);
    }

    public function render(): RmString
    {
        $this->prepareThisController();
        $this->renderSubControllers();
        return $this->View->getOutput();
    }

    public function addSubController(
        string $subControllerId,
        AbstractDisplayController $DisplayController
    ): AbstractDisplayController {
        $this->subControllers[$subControllerId] = $DisplayController;
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
        $this->View->set($subControllerId . 'Output', $subController->render());
    }
}