<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\WebConcert;
use Campusapp\Service\Entities\WebWorkshop;
use Campusapp\Service\Entities\WebSchedule;

class WebInfoService
{
    private $rootDir;
    
    public function __construct(string $rootDir) {
        $this->rootDir = $rootDir;
    }
    
    private function purgeDirs(array $dirs): array {
        foreach ($dirs as $key => $dir) {
            if (!is_dir($dir) || !strcmp($dir, '.') || !strcmp($dir, '..')) {
                unset($dirs[$key]);
            }
        }
        return $dirs;
    }
    
    public function getCurrentConcerts(string $lang): array {
        $data = [];
        $year = date('Y');
        $concertsDir = $this->rootDir . WEBDIR . $year . '/concerts/';
        $dirs = scandir($concertsDir);
        $dirs = $this->purgeDirs($dirs);
        foreach ($dirs as $dir) {
            $languages = scandir($concertsDir . $dir);
            if (!in_array($lang, $languages)) $lang = DEFAULT_LANGUAGE;
            $webConcert = new WebConcert($concertsDir . $dir . '/', $lang);
            $data[] = $webConcert->toArray();
        }
        return $data;
    }
    
    public function getConcert(string $lang, string $dir): array {
        $webConcert = new WebConcert($dir, $lang);
        return $webConcert->toArray();
    }

    public function getCurrentWorkshops(string $lang): array {
        $data = [];
        $year = date('Y');
        $workshopsDir = $this->rootDir . WEBDIR . $year . '/workshops/';
        $dirs = scandir($workshopsDir);
        $dirs = $this->purgeDirs($dirs);
        foreach ($dirs as $dir) {
            $languages = scandir($workshopsDir . $dir);
            if (!in_array($lang, $languages)) $lang = DEFAULT_LANGUAGE;
            $webWorkshop = new WebWorkshop($workshopsDir . $dir . '/', $lang);
            $data[] = $webWorkshop->toArray();
        }
        return $data;
    }
    
    public function getWorkshop(string $lang, string $dir): array {
        $webWorkshop = new WebWorkshop($dir, $lang);
        return $webWorkshop->toArray();
    }
    
    public function getCurrentSchedules(string $lang): array {
        $data = [];
        $year = date('Y');
        $schedulesDir = $this->rootDir . WEBDIR . $year . '/schedules/';
        $dirs = scandir($schedulesDir);
        $dirs = $this->purgeDirs($dirs);
        foreach ($dirs as $dir) {
            $languages = scandir($schedulesDir . $dir);
            if (!in_array($lang, $languages)) $lang = DEFAULT_LANGUAGE;
            $schedules = new WebSchedule($schedulesDir . $dir . '/', $lang);
            $data[] = $schedules->toArray();
        }
        return $data;
    }
    
    public function getSchedule(string $lang, string $dir): array {
        $schedule = new WebSchedule($dir, $lang);
        return $schedule->toArray();
    }
}