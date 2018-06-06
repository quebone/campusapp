<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Staff;
use Campusapp\Service\UserService;

class StaffModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAllStaffData(array $staffs): array {
        $data = [];
        foreach ($staffs as $staff) $data[] = $this->getStaffData($staff);
        return $data;
    }
    
    public function getStaffData(Staff $staff): array {
        $data = $staff->toArray();
        $data['roleName'] = ROLES[$data['role']];
        $us = new UserService();
        try {
            $joomId = $us->getJoomlaUserByEmail($member->getEmail())['id'];
            $data['joomId'] = $joomId;
        } catch (\Exception $e) {
            $data['joomId'] = 0;
        } finally {
            return $data;
        }
        return $data;
    }
}