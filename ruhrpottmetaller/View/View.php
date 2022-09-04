<?php

namespace ruhrpottmetaller\View;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject;
use ruhrpottmetaller\Data\LowLevel\RmString;

class View
{
    private RmString $TemplatePath;
    private RmString $Template;
    private array $_ = array();

    public function __construct(
        RmString $TemplatePath,
        RmString $Template
    ) {
        $this->TemplatePath = $TemplatePath;
        $this->Template = $Template;
        $this->_['imagePath'] = RmString::new('web/assets/images/');
    }

    public static function new(
        RmString $TemplatePath,
        RmString $Template
    ): View {
        return new self($TemplatePath, $Template);
    }

    public function setTemplate(RmString $Template)
    {
        $this->Template = $Template;
        return $this;
    }

    public function set(string $key, IDataObject $value)
    {
        $this->_[$key] = $value;
    }

    private function get(string $key): AbstractLowLevelDataObject
    {
        return $this->_[$key];
    }

    public function getOutput(): RmString
    {
        $file = $this->TemplatePath->get() . $this->Template->get() . '.inc.php';

        if (!file_exists($file)) {
            throw new \Error("Template \"$file\" is not available");
        }

        ob_start();
        include($file);
        $output = ob_get_contents();
        ob_end_clean();
        return RmString::new($output);
    }

    /**
     * Just for unit testing
     */
    public function getAll(): array
    {
        return $this->_;
    }
}
