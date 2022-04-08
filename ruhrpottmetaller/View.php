<?php

namespace ruhrpottmetaller;

class View
{
    private string $template_path = '../templates';
    private string $image_path = 'assets/images';
    private string $template = 'default';
    private array $_ = array();

    public function assign(string $key, $value)
    {
        $this->_[$key] = $value;
    }

    public function setTemplate(string $template = 'default')
    {
        $this->template = $template;
    }

    public function getOutput(): string
    {
        $tpl = $this->template;
        $file = $this->template_path . DIRECTORY_SEPARATOR . $tpl . '.inc.php';
        $exists = file_exists($file);

        if ($exists) {
            ob_start();
            include($file);
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        } else {
            return '<div class="inhalt_large">Could not found template "' . $tpl . '".</div>';
        }
    }

    public function takeOverRequestParameters(string $parameter)
    {
        if (isset($this->_['request'][$parameter])) {
            printf(
                "\t\t<input type=\"hidden\" name=\"%1\$s\" value=\"%2\$s\">\n",
                $parameter,
                $this->_['request'][$parameter]
            );
        }
    }
}
