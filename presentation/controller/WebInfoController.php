<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\WebInfoService;

class WebInfoController extends Controller
{
    private $ws;
    private $rootDir;
    
    public function __construct(string $rootDir) {
        parent::__construct();
        $this->rootDir = $rootDir;
        $this->ws = new WebInfoService($rootDir);
    }
    
    public function getCurrentConcerts(array $get): array {
        $get = $this->decodeUrl($get);
        return $this->ws->getCurrentConcerts($get['lang']);
    }
    
    public function getConcert(array $get, string $dir): array {
        $get = $this->decodeUrl($get);
        return $this->ws->getConcert($get['lang'], $dir . '/');
    }

    public function getCurrentWorkshops(array $get): array {
        $get = $this->decodeUrl($get);
        return $this->ws->getCurrentWorkshops($get['lang']);
    }
    
    public function getWorkshop(array $get, string $dir): array {
        $get = $this->decodeUrl($get);
        return $this->ws->getWorkshop($get['lang'], $dir . '/');
    }
    
    public function getCurrentSchedules(array $get): array {
        $get = $this->decodeUrl($get);
        return $this->ws->getCurrentSchedules($get['lang']);
    }
    
    public function getSchedule(array $get, string $dir): array {
        $get = $this->decodeUrl($get);
        return $this->ws->getSchedule($get['lang'], $dir . '/');
    }
}