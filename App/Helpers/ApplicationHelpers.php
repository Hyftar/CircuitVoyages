<?php


namespace App\Helpers;

use Symfony\Contracts\Translation\TranslatorInterface;

class ApplicationHelpers
{
    private static $date_pattern = '/^(?<year>\d{4})[- \/]?(?<month>[0-1]?\d)[- \/]?(?<day>[0-3]?\d)$/';

    public static function validateDate($date, $older_than = 0, TranslatorInterface $translator)
    {
        $errors = [];
        if (!preg_match(static::$date_pattern, $date)) {
            $errors[] = $translator->trans('Format de date invalide');
            return $errors;
        }

        $now = date_create();
        $date = date_create($date);
        $interval = $now->diff($date);
        if ($interval->format('%y') < $older_than) {
            $errors[] = "Vous devez avoir au moins $older_than ans pour vous enregistrer";
        }

        return $errors;
    }
}
