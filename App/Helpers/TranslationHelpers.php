<?php

namespace App\Helpers;

use Symfony\Component\Translation\Translator;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class TranslationHelpers
{
    private static $instances = [];

    private static function createInstance($locale) {
        $translator = new Translator($locale);
		$translator->addLoader('yaml', new YamlFileLoader());
		$translator->addResource('yaml', 'translations\\messages.' . $locale . '.yaml', $locale);
	    return $translator;
    }

	public static function getCurrentLocale() {
		return empty($_SESSION['locale']) ? 'fr' : $_SESSION['locale']; 
	}
	
    public static function getInstance($locale) {
        if (empty($instances[$locale])) {
            $instances[$locale] = static::createInstance($locale);
        }

	    return $instances[$locale];
    }
}
