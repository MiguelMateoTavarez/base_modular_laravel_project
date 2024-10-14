<?php

namespace App\Helper;

final class Pluralize
{
    private static array $pluralRules = [
        '/(quiz)$/i' => "$1zes",                  // Quiz -> Quizzes
        '/^(ox)$/i' => "$1en",                    // Ox -> Oxen
        '/([m|l])ouse$/i' => "$1ice",             // Mouse -> Mice, Louse -> Lice
        '/(matr|vert|ind)(ix|ex)$/i' => "$1ices", // Matrix -> Matrices
        '/(x|ch|ss|sh)$/i' => "$1es",             // Index -> Indices, Suffix -> Suffixes
        '/([^aeiouy]|qu)y$/i' => "$1ies",         // Query -> Queries
        '/(hive)$/i' => "$1s",                    // Hive -> Hives
        '/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",  // Knife -> Knives, Calf -> Calves
        '/sis$/i' => "ses",                       // Analysis -> Analyses
        '/([ti])um$/i' => "$1a",                  // Datum -> Data
        '/(buffal|tomat)o$/i' => "$1oes",         // Tomato -> Tomatoes
        '/(bu)s$/i' => "$1ses",                   // Bus -> Buses
        '/(alias|status)$/i' => "$1es",           // Alias -> Aliases
        '/(octop|vir)us$/i' => "$1i",             // Octopus -> Octopi
        '/(ax|test)is$/i' => "$1es",              // Testis -> Testes
        '/s$/i' => "s",                           // Words already in plural
        '/$/' => "s"                              // Default case: just add 's'
    ];

    public static function getPlural(string $word): string
    {
        foreach (self::$pluralRules as $rule => $replacement) {
            if(preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }

        return $word;
    }
}
