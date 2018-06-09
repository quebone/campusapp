<?php
namespace Campusapp\Service;

use Campusapp\Exceptions\InstanceNotFoundException;
use Campusapp\Service\Entities\Registration;
use Campusapp\Service\Entities\Attendance;

class RegistrationService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getRegisteredUser(string $email, string $dni) {
        $us = new UserService();
        try {
            $user = $us->getUserByEmailAndDni($email, $dni);
        } catch (InstanceNotFoundException $e) {
            try {
                $user = $us->getUserByEmail($email);
            } catch (InstanceNotFoundException $e) {
                $user = $us->addUser(['email'=>$email, 'dni'=>$dni]);
            }
        }
        return $user;
    }
    
    public function getRegistration(string $email, string $dni) {
        
    }
    
    public function addRegistration(Attendance $attendance, bool $firstYearInCampus,
        int $arrivalDay, int $arrivalTime, int $registrationType, bool $emailSpread,
        bool $imageRights, bool $musicalKnowledge, string $observations): Registration {
            $registration = $attendance->getRegistration();
            if ($registration == NULL) {
                $registration = new Registration();
                $this->dao->persist($registration);
                $attendance->setRegistration($registration);
            }
            $registration->setFirstYearInCampus($firstYearInCampus);
            $registration->setArrivalDay($arrivalDay);
            $registration->setArrivalTime($arrivalTime);
            $registration->setRegistrationType($registrationType);
            $registration->setEmailSpread($emailSpread);
            $registration->setImageRights($imageRights);
            $registration->setMusicalKnowledge($musicalKnowledge);
            $registration->setObservations($observations);
            try {
                $this->dao->flush();
                return $registration;
            } catch (\Exception $e) {
                throw $e;
            }
    }
    
    public function deleteRegistration(string $email) {
        $us = new UserService();
        $user = $us->getUserByEmail($email);
        $as = new AttendancesService();
        $attendance = $as->getCurrentAttendance($user);
        $user->removeAttendance($attendance);
        $this->dao->remove($attendance);
        //si no té cap més assistència, podem eliminar l'usuari
        if (count($user->getAttendances()) == 0) {
            $this->dao->remove($user);
        }
        try {
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}