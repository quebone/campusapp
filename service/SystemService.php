<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\System;
use Campusapp\Exceptions\InvalidPasswordException;

class SystemService extends Service
{
    private $system;
    
    public function __construct() {
        parent::__construct();
        $this->system = $this->dao->getByFilter("System")[0];
    }
    
    public function getSystem(): System {
        return $this->system;
    }
    
    public function setCrepsEnabled(bool $enabled) {
        $this->system->setCrepsEnabled($enabled);
        $this->dao->flush();
    }
    
    public function setCrepsManagerEnabled(bool $enabled) {
        $this->system->setCrepsManagerEnabled($enabled);
        $this->dao->flush();
    }
    
    public function setMaxPendingCreps(int $maxPendingCreps) {
        $this->system->setMaxPendingCreps($maxPendingCreps);
        $this->dao->flush();
    }
    
    public function getCrepsManagerEnabled(): bool {
        return $this->system->getCrepsManagerEnabled();
    }
    
    public function getCrepsEnabled(): bool {
        return $this->system->getCrepsEnabled();
    }
    
    public function setCrepsManagerPassword(string $password) {
        if (strlen($password) >= MINCREPPASSWORDLENGTH && strlen($password) <= MAXCREPPASSWORDLENGTH) {
            $this->system->setCrepsManagerPassword($password);
            $this->dao->flush();
        } else throw new InvalidPasswordException();
    }
}