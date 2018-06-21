<?php
namespace Campusapp\Service\Entities;

abstract class WebInfo
{
    protected $dir;
    protected $relDir;
    protected $lang;
    protected $text;
    protected $image;
    protected $sections;
    protected $link;
    private $imageFormats = ['jpg', 'png'];
    
    protected function __construct(string $dir, string $lang) {
        $this->dir = $dir;
        $this->relDir = $this->getRelativeDir();
        $this->lang = $lang;
        $this->link = $this->relDir . 'index.php?lang=' . $lang;
        $this->text = $this->readTextFile();
        $this->image = $this->getImageFile();
    }
    
    protected function get(string $needle): string {
        $section = $this->sections[$needle];
        $start = strpos($this->text, $section) + strlen($section);
        $end = strpos($this->text, "/**", $start);
        if ($end === FALSE) $end = strlen($this->text);
        $data = substr($this->text, $start, $end - $start);
        $data = trim($data, "\n\r");
        return $data;
    }
    
    protected function getParagraphs(string $text): array {
        $arr = preg_split('/\r\n|\r|\n/', $text);
        return $arr;
    }
    
    private function readTextFile(): string {
        if (file_exists($this->dir . $this->lang . '/text.txt')) {
            return file_get_contents($this->dir . $this->lang . '/text.txt');
        } else {
            return "";
        }
    }
    
    private function getImageFile(): string {
        $images = scandir($this->dir . 'images/');
        foreach ($images as $image) {
            $arr = explode('.', $image);
            $extension = $arr[count($arr) - 1];
            if (in_array($extension, $this->imageFormats)) {
                $dirs = explode('/', $this->dir);
                return 'images/' . $image;
            }
        }
        return "";
    }
    
    private function getRelativeDir(): string {
        $dirs = explode('/', $this->dir);
        return $dirs[count($dirs) - 2] . '/';
    }
}