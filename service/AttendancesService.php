<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Attendance;
use Campusapp\Service\Entities\User;
use Campusapp\Service\Entities\Meal;
use Campusapp\Exceptions\InstanceNotFoundException;
use Campusapp\Service\Entities\HasMeal;

class AttendancesService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getCurrentAttendants(): array {
        $data = [];
        try {
            $attendances = $this->getCurrentAttendancesWithRegistration();
            foreach ($attendances as $attendance)
                $data[] = $attendance->getUser();
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCurrentAttendancesWithRegistration(): array {
        try {
            $attendances = $this->dao->getByFilter("Attendance");
            foreach ($attendances as $key => $attendance) {
                if (!$this->isCurrent($attendance) || $attendance->getRegistration() != null) unset($attendances[$key]);
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
    
    public function userHasCurrentRegistration(string $email): bool {
        $us = new UserService();
        try {
            $user = $us->getUserByEmail($email);
            $attendance = $this->getCurrentAttendance($user);
            if ($attendance == NULL) return FALSE;
            return ($attendance->getRegistration() != NULL);
        } catch (\Exception $e) {
            return FALSE;
        }
    }
    
    public function isCurrent(Attendance $attendance): bool {
        return !strcmp($attendance->getDate()->format('Y'), date('Y'));
    }
    
    public function addAttendance(User $user, int $diet, int $accommodation, bool $thursdayDinner,
            bool $fridayLunch, bool $fridayDinner, bool $saturdayLunch, bool $saturdayDinner,
            bool $sundayLunch, int $role): Attendance {
        $attendance = $this->getCurrentAttendance($user);
        if ($attendance == NULL) {
            $attendance = new Attendance();
            $this->dao->persist($attendance);
            $user->addAttendance($attendance);
            $attendance->setuser($user);
        }
        $attendance->setDiet($diet);
        $attendance->setAccommodation($accommodation);
        $attendance->setRole($role);
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
            $this->addMeal($attendance, $meal);
        } else {
            $this->removeMeal($attendance, $meal);
        }
    }
    
    private function addMeal(Attendance $attendance, Meal $meal): bool {
        $hasMeals = $attendance->getHasMeals();
        foreach ($hasMeals as $hasMeal) {
            if ($meal == $hasMeal->getMeal()) {
                return FALSE;
            }
        }
        $hasMeal = new HasMeal();
        $hasMeal->setAttendance($attendance);
        $hasMeal->setMeal($meal);
        $this->dao->persist($hasMeal);
        $attendance->addHasMeal($hasMeal);
        return TRUE;
    }
    
    private function removeMeal(Attendance $attendance, Meal $meal): bool {
        $hasMeals = $attendance->getHasMeals();
        foreach ($hasMeals as $hasMeal) {
            if ($meal == $hasMeal->getMeal()) {
                $attendance->removeHasMeal($hasMeal);
                $this->dao->remove($hasMeal);
                return TRUE;
            }
        }
        return FALSE;
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
            $crepShoppers = $this->dao->getByFilter("CrepShopper", ['user'=>$user]);
            if (count($crepShoppers) > 0) $crepShoppers[0]->setUser(NULL);
            $this->dao->remove($user);
        }
        try {
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}