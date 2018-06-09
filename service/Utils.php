<?php
namespace Campusapp\Service;

class Utils
{
    /**
     * Converteix els caràcters UTF8 a CP1252
     */
    public static function decode($inputText)
    {
        setlocale(LC_ALL, 'es_CA');
        return $str = iconv('UTF-8', 'cp1252', $inputText);
    }
    
    public static function removeAccents(string $input): string {
        return str_replace(
            array('à','è','é','í','ò','ó','ú','À','È','É','Í','Ò','Ó','Ú'),
            array('a','e','e','i','o','o','u','A','E','E','I','O','O','U'),
            $input);
    }
}