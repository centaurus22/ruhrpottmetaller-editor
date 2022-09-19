<?php

namespace ruhrpottmetaller\View;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject;
use ruhrpottmetaller\Data\LowLevel\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\RmString;

class View
{
    private AbstractRmString $TemplatePath;
    private AbstractRmString $Template;
    private array $_ = array();

    public function __construct(
        AbstractRmString $TemplatePath,
        AbstractRmString $StandardTemplate
    ) {
        $this->TemplatePath = $TemplatePath;
        $this->Template = $StandardTemplate;
        $this->_['imagePath'] = AbstractRmString::new('web/assets/images/');
    }

    public static function new(
        AbstractRmString $TemplatePath,
        AbstractRmString $StandardTemplate
    ): View {
        return new self($TemplatePath, $StandardTemplate);
    }

    public function setTemplate(AbstractRmString $Template): View
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

    public function getOutput(): AbstractRmString
    {
        $file = $this->TemplatePath->get() . $this->Template->get() . '.inc.php';

        if (!file_exists($file)) {
            throw new \Error("Template \"$file\" is not available");
        }

        ob_start();
        include($file);
        $output = ob_get_contents();
        ob_end_clean();
        return AbstractRmString::new($output);
    }

    /**
     * Just for unit testing
     */
    public function getAll(): array
    {
        return $this->_;
    }
}
