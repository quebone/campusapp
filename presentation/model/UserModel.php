<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\User;
use Campusapp\Service\UserService;
use Campusapp\Service\AttendancesService;

class UserModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    private function parseEgsName(string $egsName): array {
        $parts = explode(" ", $egsName);
        $name = $parts[0];
        unset($parts[0]);
        $surnames = implode(" ", $parts);
        return ['name' => $name, 'surnames' => $surnames];
    }
    
    public function getAllEgsBasicData(array $members): array {
        $data = [];
        foreach ($members as $member) {
            $data[] = $this->getEgsBasicData($member);
        }
        return $data;
    }
    
    public function getEgsBasicData(array $member): array {
        $nameParsed = $this->parseEgsName($member['name']);
        return [
            'id' => $member['id'],
            'name' => $nameParsed['name'],
            'surnames' => $nameParsed['surnames'],
            'email' => $member['username'],
        ];
    }
    
    public function addEgsNullMember(array $members): array {
        $nullMember = ['id' => '0', 'name' => '--'];
        array_unshift($members, $nullMember);
        return $members;
    }
    
    public function getAllUsersData(array $users): array {
        $data = [];
        foreach ($users as $user) {
            $data[] = $this->getUserData($user);
        }
        return $data;
    }
    
    public function getUserData(User $user): array {
        $data = $user->toArray();
        $as = new AttendancesService();
        $currentAttendance = $as->getCurrentAttendance($user);
        if ($currentAttendance != NULL) {
            $data['role'] = $currentAttendance->getRole();
            $data['roleName'] = ROLES[$data['role']];
        }
        $us = new UserService();
        try {
            $data['joomId'] = $us->getJoomlaUserByEmail($user->getEmail())['id'];
        } catch (\Exception $e) {
            $data['joomId'] = 0;
        } finally {
            return $data;
        }
    }
}