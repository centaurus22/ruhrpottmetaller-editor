<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\View\View;

interface IDisplayController
{
    public static function new(View $View);
    public function render(): RmString;
    public function addSubController(
        string $subControllerId,
        AbstractDisplayController $DisplayController
    );
}