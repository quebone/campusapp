<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\StaffService;
use Campusapp\Presentation\Model\StaffModel;
use Campusapp\Service\UserService;

class StaffController extends Controller
{
    private $ss;
    private $sm;
    
    public function __construct() {
        parent::__construct();
        $this->ss = new StaffService();
        $this->sm = new StaffModel();
    }
    
    public function getEgsMembers(): array {
        $uc = new UserController();
        return $uc->getEgsMembers();
    }
    
    public function getStaff(): array {
        try {
            $staff = $this->ss->getStaff();
            return $this->sm->getAllStaffData($staff);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getMember(array $post): array {
        try {
            $us = new UserService();
            $member = $this->ss->getMember(intval($post['id']));
            $data = $this->sm->getStaffData($member);
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getEgsData(array $post): array {
        $uc = new UserController();
        try {
            return $uc->getEgsData($post);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addStaff(array $post): bool {
        $post = $this->decodeUrl($post);
        try {
            $this->ss->addStaff($post['name'], $post['surnames'], $post['email'], $post['password']);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteStaff(array $post): bool {
        try {
            $this->ss->deleteStaff(intval($post['id']));
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}