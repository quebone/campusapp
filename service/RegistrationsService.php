<?php
namespace Campusapp\Service;

class RegistrationsService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getCurrentRegistered(): array {
        $attendances = $this->getCurrentAttendances();
        $data = [];
        foreach ($attendances as $attendance) {
            $data[] = $attendance->getUser();
        }
        return $data;
    }
    
    public function getCurrentAttendances(): array {
        $as = new AttendancesService();
        try {
            $attendances = $this->dao->getByFilter("Attendance");
            foreach ($attendances as $key => $attendance) {
                if (!$as->isCurrent($attendance) || $attendance->getRegistration() == null) unset($attendances[$key]);
            }
            return $attendances;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}