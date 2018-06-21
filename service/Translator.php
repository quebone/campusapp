<?php
namespace Campusapp\Service;

class Translator
{
    private static $language = DEFAULT_LANGUAGE;
    
    private function __construct() {
    }
    
    public static function get(string $original, string $lang): ?string {
        $file = @fopen(LANGUAGESDIR.$lang, 'r');
        if ($file === FALSE) return NULL;
        $found = FALSE;
        $translated = NULL;
        while (($line = fgets($file)) != FALSE && !$found) {
            if (!strcasecmp(json_decode($line)[0], $original)) {
                $translated = json_decode($line)[1];
                $found = TRUE;
            }
        }
        fclose($file);
        return $translated;
    }
    
    public static function getKey(string $translated, string $lang): ?string {
        $file = @fopen(LANGUAGESDIR.$lang, 'r');
        if ($file === FALSE) return NULL;
        $found = FALSE;
        $key = NULL;
        while (($line = fgets($file)) != FALSE && !$found) {
            if (!strcasecmp(json_decode($line)[1], $translated)) {
                $key = json_decode($line)[0];
                $found = TRUE;
            }
        }
        fclose($file);
        return $key;
    }
    
    public static function set(string $original, string $translated, string $lang) {
        if (self::get($original, $lang) != NULL) {
            self::remove($original, $lang);
        }
        $data = [$original, $translated];
        file_put_contents(LANGUAGESDIR.$lang, json_encode($data) . "\n", FILE_APPEND);
    }
    
    public static function remove(string $original, string $lang) {
        $file = @fopen(LANGUAGESDIR.$lang, 'r+');
        if ($file != FALSE) {
            $lines = [];
            while (($line = fgets($file)) != FALSE) {
                $data = json_decode($line);
                if (strcasecmp(json_decode($line)[0], $original)) $lines[] = $line;
            }
            fclose($file);
            $file = fopen(LANGUAGESDIR.$lang, 'w');
            foreach ($lines as $line) {
                fputs($file, $line);
            }
            fclose($file);
        }
    }
    
    public static function updateOriginal(string $old, string $new) {
        $dir = opendir(LANGUAGESDIR);
        $files = scandir(LANGUAGESDIR);
        foreach ($files as $file) {
            if (!is_dir($file)) {
                $translated = self::get($old, $file);
                if ($translated != NULL) {
                    self::remove($old, $file);
                    self::set($new, $translated, $file);
                }
            }
        }
    }
}