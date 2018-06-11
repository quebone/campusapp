<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\UserService;
use Campusapp\Presentation\Model\UserModel;
use Campusapp\Service\StaffService;
use Campusapp\Presentation\Model\StaffModel;
use Campusapp\Exceptions\InstanceNotFoundException;

class UserController extends Controller
{
    private $us;
    private $um;
    
    public function __construct() {
        parent::__construct();
        $this->us = new UserService();
        $this->um = new UserModel();
    }
    
    public function getEgsMembers(): array {
        $egsMembers = $this->us->getJoomlaActiveUsers();
        $egsMembers = $this->us->removeAdministratorFromJoomlaActiveUsers($egsMembers);
        $egsData = $this->um->getAllEgsBasicData($egsMembers);
        return $this->um->addEgsNullMember($egsData);
    }

    public function getEgsData(array $post): array {
        try {
            $joomUser = $this->us->getJoomlaUserById(intval($post['id']));
            return $this->um->getEgsBasicData($joomUser);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getRegisteredUser(array $post): array {
        $post = $this->decodeUrl($post);
        $data = [];
        $ss = new StaffService();
        $sm = new StaffModel();
        //is staff?
        if (isset($post['password']) && strlen($post['password']) > 0) {
            try {
                $member = $ss->getMemberByEmailAndPassword($post['email'], $post['password']);
                $data = $sm->getStaffData($member);
            } catch (InstanceNotFoundException $e) {
                //is egs?
                try {
                    $egs = $this->us->getJoomlaUserByEmailAndPassword($post['email'], $post['password']);
                    $data = $this->um->getEgsBasicData($egs);
                    $data['role'] = EGS;
                } catch (InstanceNotFoundException $e) {
                    throw $e;
                }
            } catch (\Exception $e) {
                throw $e;
            }
        //is campusi?
        } elseif (isset($post['dni']) && strlen($post['dni']) > 0) {
            try {
                $campusi = $this->us->getUserByEmailAndDni($post['email'], $post['dni']);
                $data = $this->um->getUserData($campusi);
            } catch (\Exception $e) {
                throw $e;
            }
        //is attendant?
        } else {
            try {
                $user = $this->us->getUserByEmail($post['email']);
                $data = $this->um->getUserData($user);
                $data['role'] = OTHERS;
            } catch (\Exception $e) {
                throw $e;
            }
        }
        return $data;
    }
}