<?php

namespace ruhrpottmetaller\View;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject;
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

    public static function new(
        RmString $templatePath,
        RmString $templateFile
    ): View {
        return new self($templatePath, $templateFile);
    }

    public function set(string $key, IDataObject $value)
    {
        $this->_[$key] = $value;
    }

    private function getAsObject(string $key): AbstractLowLevelDataObject
    {
        return $this->_[$key];
    }

    private function getAsPrimitive(string $key)
    {
        return $this->_[$key]->get();
    }

    public function getOutput(): RmString
    {
        $file = $this->templatePath->get() . $this->templateFile->get() . '.inc.php';

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
