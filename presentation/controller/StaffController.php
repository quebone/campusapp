<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\StaffService;
use Campusapp\Presentation\Model\StaffModel;
use Campusapp\Service\UserService;
use Campusapp\Presentation\Model\UserModel;

class StaffController extends Controller
{
    private $sc;
    private $sm;
    
    public function __construct() {
        parent::__construct();
        $this->sc = new StaffService();
        $this->sm = new StaffModel();
    }
    
    public function getEgsMembers(): array {
        $us = new UserService();
        $egsMembers = $us->getJoomlaActiveUsers();
        $um = new UserModel();
        $egsData = $um->getAllEgsBasicData($egsMembers);
        return $um->addEgsNullMember($egsData);
    }
    
    public function getStaff(): array {
        try {
            $staff = $this->sc->getStaff();
            return $this->sm->getAllStaffData($staff);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}