<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Staff;

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
        return $data;
    }
}