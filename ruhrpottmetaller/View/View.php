<?php

namespace ruhrpottmetaller\View;

use ruhrpottmetaller\DataType\AbstractDataTypeValue;
use ruhrpottmetaller\DataType\DataTypeString;

class View
{
    private DataTypeString $templatePath;
    private DataTypeString $templateFile;
    private array $_ = array();

    public function __construct(
        DataTypeString $templatePath,
        DataTypeString $templateFile
    ) {
        $this->templatePath = $templatePath;
        $this->templateFile = $templateFile;
        $this->_['imagePath'] = DataTypeString::new('web/assets/images/');
    }

    public function set(string $key, AbstractDataTypeValue $value)
    {
        $this->_[$key] = $value;
    }

    private function getAsObject(string $key): AbstractDataTypeValue
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
