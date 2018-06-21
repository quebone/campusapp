<?php
namespace Campusapp\Service\Entities;

class WebSchedule implements IEntity
{
    private $xml;
    private $dir;
    private $relDir;
    private $lang;
    private $text;
    
    public function __construct(string $dir, string $lang) {
        $this->dir = $dir;
        $this->relDir = $this->getRelativeDir();
        $this->lang = $lang;
        $this->xml = $this->getXml($this->dir . $this->lang . '/text.txt');
    }
    
    private function getXml(string $xmlFile): array {
        if (file_exists($xmlFile)) {
            return json_decode(json_encode((array) simplexml_load_file($xmlFile)), 1);
        }
    }
    
    private function getRelativeDir(): string {
        $dirs = explode('/', $this->dir);
        return $dirs[count($dirs) - 2] . '/';
    }

    public function toArray(): array {
        return array_merge($this->xml, [
            'lang' => $this->lang,
            'dir' => $this->dir,
            'relDir' => $this->relDir,
        ]);
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}