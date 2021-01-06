<?php

namespace rpmetaller;

/**
 * View class which is in charge of displaying the data.
 * Version 1.0.0
 */
class View
{
    // string Template path
    private $template_path = 'templates';
    //string folder in which images are stored.
    private $image_path = 'images';
    // string Template name
    private $template = 'default';
    /**
     * array Two dimensional array which contains the data which is passed to
     * the view.
     */
    private $_ = array();

    /**
     * Function which assigns the date to the two dimensional array.
     * @param string $key Key name
     * @param string|integer $value Related value
     */
    public function assign($key, $value)
    {
        $this->_[$key] = $value;
    }

    /**
     * Writes the template name into the corresponding class variable
     * @param string $template Name of the template
     */
    public function setTemplate($template = 'default')
    {
        $this->template = $template;
    }

    /**
     * Check if the template file exist, load the template  and return the output.
     *
     * @return string Output of the template or an error message.
     */
    public function getOutput()
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

        }
        else {
            return '<div class="inhalt_large">Could not found template "' . $tpl . '".</div>';
        }
    }

    public function takeOverRequestParameters($parameter)
    {
        if (isset($this->_['request'][$parameter])) {
            printf (
                "\t\t<input type=\"hidden\" name=\"%1\$s\" value=\"%2\$s\">\n",
                $parameter,
                $this->_['request'][$parameter]
            );
        }
    }
}
