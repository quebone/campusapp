<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Presentation\Model\AttendancesModel;
use Campusapp\Service\AttendancesService;
use Campusapp\Presentation\Model\UserModel;
use Campusapp\Service\UserService;

class AttendancesController extends Controller
{
    private $as;
    private $am;
    
    public function __construct() {
        parent::__construct();
        $this->as = new AttendancesService();
        $this->am = new AttendancesModel();
    }
    
    public function getAttendants(): array {
        try {
            $attendants = $this->as->getCurrentAttendants();
            $um = new UserModel();
            return $um->getAllUsersData($attendants);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getEgsMembers(): array {
        $uc = new UserController();
        return $uc->getEgsMembers();
    }
    
    public function getEgsData(array $post): array {
        $uc = new UserController();
        try {
            return $uc->getEgsData($post);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getAttendance($post): array {
        $us = new UserService();
        $um = new UserModel();
        try {
            $user = $us->getUserById(intval($post['id']));
            $data['user'] = $um->getUserData($user);
            $attendance = $this->as->getCurrentAttendance($user);
            $data['attendance'] = $this->am->getAttendanceData($attendance);
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addAttendance($post): bool {
        $post = $this->normalize($post);
        $us = new UserService();
        try {
            $user = $us->getUserByEmail($post['email']);
            $this->as->addAttendance($user, $post['diet'], $post['accommodation'], $post['thursdayDinner'],
                $post['fridayLunch'], $post['fridayDinner'], $post['saturdayLunch'], $post['saturdayDinner'],
                $post['sundayLunch']);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteAttendance(array $post): bool {
        $us = new UserService();
        try {
            $user = $us->getUserById(intval($post['id']));
            $this->as->deleteUserAttendance($user);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}