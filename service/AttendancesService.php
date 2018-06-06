<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Attendance;
use Campusapp\Service\Entities\User;
use Campusapp\Service\Entities\Meal;
use Campusapp\Exceptions\InstanceNotFoundException;

class AttendancesService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getCurrentAttendants(): array {
        $data = [];
        try {
            $attendances = $this->getCurrentAttendances();
            foreach ($attendances as $attendance)
                $data[] = $attendance->getUser();
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCurrentAttendances(): array {
        try {
            $attendances = $this->dao->getByFilter("Attendance");
            foreach ($attendances as $key => $attendance) {
                if (!$this->isCurrent($attendance)) unset($attendances[$key]);
            }
            return $attendances;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getCurrentAttendance(User $user): ?Attendance {
        foreach ($user->getAttendances() as $attendance) {
            if ($this->isCurrent($attendance)) {
                return $attendance;
            }
        }
        return NULL;
    }
    
    private function isCurrent(Attendance $attendance): bool {
        return !strcmp($attendance->getDate()->format('Y'), date('Y'));
    }
    
    public function addAttendance(User $user, int $diet, int $accommodation, bool $thursdayDinner,
            bool $fridayLunch, bool $fridayDinner, bool $saturdayLunch, bool $saturdayDinner,
            bool $sundayLunch): Attendance {
        $attendance = $this->getCurrentAttendance($user);
        if ($attendance == NULL) {
            $attendance = new Attendance();
            $this->dao->persist($attendance);
            $user->addAttendance($attendance);
            $attendance->setuser($user);
        }
        $attendance->setDiet($diet);
        $attendance->setAccommodation($accommodation);
        $this->setThursdayDinner($attendance, $thursdayDinner);
        $this->setFridayLunch($attendance, $fridayLunch);
        $this->setFridayDinner($attendance, $fridayDinner);
        $this->setSaturdayLunch($attendance, $saturdayLunch);
        $this->setSaturdayDinner($attendance, $saturdayDinner);
        $this->setSundayLunch($attendance, $sundayLunch);
        try {
            $this->dao->flush();
            return $attendance;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    private function getMeal(int $weekDay, int $turn): Meal {
        try {
            $meals = $this->dao->getByFilter("Meal");
        } catch (\Exception $e) {
            throw $e;
        }
        foreach ($meals as $meal) {
            $mealWeekDay = intval(date("w", $meal->getDate()->format('U')));
            $mealYear = $meal->getDate()->format('Y');
            if (!strcmp($mealYear, date('Y')) && $weekDay == $mealWeekDay && $meal->getTurn() == $turn) {
                return $meal;
            }
        }
        throw new InstanceNotFoundException();
    }
    
    private function setMeal(Attendance $attendance, Meal $meal, bool $value) {
        if ($value) {
            $attendance->addMeal($meal);
        } else {
            $attendance->removeMeal($meal);
        }
    }
    
    private function setThursdayDinner(Attendance $attendance, bool $value) {
        try {
            $this->setMeal($attendance, $this->getMeal(THURSDAY, DINNER), $value);
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    private function setFridayLunch(Attendance $attendance, bool $value) {
        try {
            $this->setMeal($attendance, $this->getMeal(FRIDAY, LUNCH), $value);
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    private function setFridayDinner(Attendance $attendance, bool $value) {
        try {
            $this->setMeal($attendance, $this->getMeal(FRIDAY, DINNER), $value);
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    private function setSaturdayLunch(Attendance $attendance, bool $value) {
        try {
            $this->setMeal($attendance, $this->getMeal(SATURDAY, LUNCH), $value);
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    private function setSaturdayDinner(Attendance $attendance, bool $value) {
        try {
            $this->setMeal($attendance, $this->getMeal(SATURDAY, DINNER), $value);
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    private function setSundayLunch(Attendance $attendance, bool $value) {
        try {
            $this->setMeal($attendance, $this->getMeal(SUNDAY, LUNCH), $value);
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    public function deleteUserAttendance(User $user) {
        $attendance = $this->getCurrentAttendance($user);
        $user->removeAttendance($attendance);
        $this->dao->remove($attendance);
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