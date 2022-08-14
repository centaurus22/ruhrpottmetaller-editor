<?php

namespace ruhrpottmetaller\View;

use ruhrpottmetaller\Data\LowLevel\AbstractRmValue;
use ruhrpottmetaller\Data\LowLevel\RmString;

class View
{
    private RmString $templatePath;
    private RmString $templateFile;
    private array $_ = array();

    public function __construct(
        RmString $templatePath,
        RmString $templateFile
    ) {
        $this->templatePath = $templatePath;
        $this->templateFile = $templateFile;
        $this->_['imagePath'] = RmString::new('web/assets/images/');
    }

    public function set(string $key, AbstractRmValue $value)
    {
        $this->_[$key] = $value;
    }

    private function getAsObject(string $key): AbstractRmValue
    {
        return $this->_[$key];
    }

    private function getAsPrimitive(string $key)
    {
        return $this->_[$key]->get();
    }

    public function getOutput(): string
    {
        $file = $this->templatePath->get() . $this->templateFile->get() . '.inc.php';

        if (!file_exists($file)) {
            throw new \Error("Template \"$file\" is not available");
        }

        ob_start();
        include($file);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
