<?php

namespace App\Helpers;

class ApplicationHelpers
{
    private static $date_pattern = '/^(?<year>\d{4})[- \/]?(?<month>[0-1]?\d)[- \/]?(?<day>[0-3]?\d)$/';

    public static function validateDate($date, $older_than = 0)
    {
        $translator = TranslationHelpers::getInstance();

        $errors = [];
        if (!preg_match(static::$date_pattern, $date)) {
            $errors[] = $translator->trans('Helpers.Date');
            return $errors;
        }

        $now = date_create();
        $date = date_create($date);
        $interval = $now->diff($date);
        if ($interval->format('%y') < $older_than) {
            $errors[] = $translator->trans("Helpers.older_than", ['older_than' => $older_than]);
        }

        return $errors;
    }
}
