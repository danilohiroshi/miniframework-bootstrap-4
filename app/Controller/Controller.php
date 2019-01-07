<?php

namespace App\Controller;

use Twig_Environment;
use Twig_Loader_Filesystem;

class Controller
{
    public function render($path, $variables = array())
    {
        $loader = new Twig_Loader_Filesystem('../assets/views');
        $twig = new Twig_Environment($loader);
        $template_html = $twig->render(
            $path,
            $variables
        );
        return $template_html;
    }
}
