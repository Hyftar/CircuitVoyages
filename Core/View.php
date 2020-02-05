<?php

namespace Core;

use App\Helpers\TranslationHelpers;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

class View
{
    /**
     * Render a view file (.php or .html)
     */
    public static function render($view, $args = [], $contentType = 'text/html')
    {
        $translator = TranslationHelpers::getInstance();
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        header("Content-Type: $contentType");
        header("Content-Length: " . filesize($file));

        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            return;
        }

        if (!is_readable($file)) {
            throw new \Exception($translator->trans("Core.Not.core_file", ['core_file' => $file]));
        }

        require $file;
    }

    /**
     * Render a view template using Twig
     */
    public static function renderTemplate($template, $args = [], $contentType = 'text/html')
    {
        static $twig = null;
        static $loaded_translators = [];

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addExtension(new \Twig_Extensions_Extension_Date());
        }

        if (!in_array($_SESSION['locale'], $loaded_translators)) {
            $interface = new TranslationExtension(TranslationHelpers::getInstance());
            $twig->addExtension($interface);
            $loaded_translators[] = $_SESSION['locale'];
        }

        $output = $twig->render($template, $args);

        header("Content-Type: $contentType");
        header("Content-Length: " . strlen($output));

        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            return;
        }

        echo $output;
    }

    public static function outputTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addExtension(new \Twig_Extensions_Extension_Date());
        }

        return $twig->render($template, $args);
    }

    public static function renderJSON($json)
    {
        $output = json_encode($json, JSON_UNESCAPED_UNICODE);
        header("Content-Type: application/json");
        header("Content-Length: " . strlen($output));

        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            return;
        }

        echo $output;
    }
}
