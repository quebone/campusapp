<?php
namespace Campusapp\Service;

use Campusapp\DAO;

class Service
{
    protected $dao;
    
    public function __construct() {
        $this->dao = DAO::getInstance();
    }
}