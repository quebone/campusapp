<?php
namespace Campusapp\Service\Entities;

class WebWorkshop extends WebInfo implements IEntity
{
    public function __construct(string $dir, string $lang) {
        parent::__construct($dir, $lang);
        $this->sections = [
            'date' => '/** DATE **/',
            'title' => '/** TITLE **/',
            'subtitle' => '/** SUBTITLE **/',
            'info' => '/** INFO **/',
        ];
    }
    
    public function getDate(): string {
        return $this->get('date');
    }
    
    public function getTitle(): string {
        return $this->get('title');
    }
    
    public function getSubitle(): string {
        return $this->get('subtitle');
    }
    
    public function getInfo(): array {
        $info = $this->get('info');
        return $this->getParagraphs($info);
    }
    
    public function getImage(): string {
        return $this->image;
    }
    
    public function setImage(string $image) {
        $this->image = $image;
    }
    
    public function toArray(): array {
        return [
            'date' => $this->getDate(),
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubitle(),
            'info' => $this->getInfo(),
            'image' => $this->image,
            'link' => $this->link,
            'relDir' => $this->relDir,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}