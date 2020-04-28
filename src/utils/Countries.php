<?php

namespace Website\utils;

/**
 * Allow easy manipulation of supported countries.
 *
 * @author Marien Fressinaud <dev@marienfressinaud.fr>
 * @license http://www.gnu.org/licenses/agpl-3.0.en.html AGPL
 */
class Countries
{
    public const COUNTRIES = [
        'AT' => 'Autriche',
        'BE' => 'Belgique',
        'BG' => 'Bulgarie',
        'CY' => 'Chypre',
        'CZ' => 'République tchèque',
        'DE' => 'Allemagne',
        'DK' => 'Danemark',
        'EE' => 'Estonie',
        'ES' => 'Espagne',
        'FI' => 'Finlande',
        'FR' => 'France',
        'GR' => 'Grèce',
        'HR' => 'Croatie',
        'HU' => 'Hongrie',
        'IE' => 'Irelande',
        'IT' => 'Italie',
        'LT' => 'Lituanie',
        'LU' => 'Luxembourg',
        'LV' => 'Lettonie',
        'MT' => 'Malte',
        'NL' => 'Pays-Bas',
        'PL' => 'Pologne',
        'PT' => 'Portugal',
        'RO' => 'Roumanie',
        'SE' => 'Suède',
        'SI' => 'Slovénie',
        'SK' => 'Slovaquie',
    ];

    public static function codes()
    {
        return array_keys(self::COUNTRIES);
    }

    public static function codeToLabel($country_code)
    {
        return self::COUNTRIES[$country_code];
    }

    public static function isSupported($country_code)
    {
        return isset(self::COUNTRIES[$country_code]);
    }
}
