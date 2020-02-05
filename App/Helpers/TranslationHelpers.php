<?php


namespace App\Helpers;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader;

class TranslationHelpers
{
    public static function getInstance()
    {
        static $instances = [];
        if (empty($instances[$_SESSION['locale']])) {
            $translator = new Translator($_SESSION['locale']);
            $translator->addLoader('yaml', new Loader\YamlFileLoader());
            $translator->addResource(
                'yaml',
                __DIR__ . '/../../translations/messages.' . $_SESSION['locale'] . '.yaml',
                $_SESSION['locale']
            );

            $instances[$_SESSION['locale']] = $translator;
        }

        return $instances[$_SESSION['locale']];
    }
}
