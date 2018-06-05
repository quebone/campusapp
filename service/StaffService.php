<?php
namespace Campusapp\Service;

class StaffService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getStaff(): array {
        try {
            return $this->dao->getByFilter("Staff");
        } catch (\Exception $e) {
            throw $e;
        }
    }
}