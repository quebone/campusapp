<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Meal;
use Campusapp\Exceptions\InstanceNotFoundException;

class MealsService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAllCurrentMeals(): array {
        try {
            $meals = $this->dao->getByFilter("Meal");
            foreach ($meals as $key => $value) {
                if (strcmp(date('Y'), $value->getDate()->format('Y'))) {
                    unset($meals[$key]);
                }
            }
            return $meals;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function existsCurrentMeal(): Meal {
        try {
            return $this->getCurrentMeal();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function register(string $email): array {
        $data = [];
        try {
            $meal = $this->getCurrentMeal();
        } catch (\Exception $e) {
            $data['error'] = "Avui no hi ha previst cap àpat";
            return $data;
        }
        $us = new UserService();
        try {
            $user = $us->getUserByEmail($email);
        } catch (\Exception $e) {
            return['error' => 'Aquest usuari no està registrat'];
        }
        $data['name'] = $user->getName();
        $data['surnames'] = $user->getSurnames();
        $as = new AttendancesService();
        $attendance = $as->getCurrentAttendance($user);
        if ($attendance == NULL) {
            $data['error'] = "Aquest usuari no està registrat aquest any";
            return $data;
        }
        $meals = $attendance->getMeals();
        if (!in_array($meal, $meals)) {
            $data['error'] = "Aquest usuari no està registrat a aquest àpat";
            return $data;
        }
        $hasMeals = $attendance->getHasMeals();
        $i = 0;
        $found = FALSE;
        while (!$found && $i < count($hasMeals)) {
            if ($hasMeals[$i]->getMeal() != $meal) $i++;
            else $found = TRUE;
        }
        if ($hasMeals[$i]->getAssisted()) {
            $data['warning'] = "Aquest usuari ja ha assistit a aquest àpat";
            return $data;
        }
        $hasMeals[$i]->setAssisted(TRUE);
        try {
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
        $data['info'] = "Usuari correctament registrat";
        return $data;
    }
    
    public function getMealStatistics(Meal $meal): array {
        $data = [];
        $data['date'] = $meal->getDate()->format('d/m/Y');
        $data['turn'] = TURNS[$meal->getTurn()];
        try {
            $hasMeals = $this->dao->getByFilter("HasMeal", ['meal' => $meal]);
            //companions
            $data['companions'] = 0;
            foreach ($hasMeals as $hasMeal) {
                if ($hasMeal->getCompanions() > 0) $data['companions'] += $hasMeal->getCompanions();
            }
            $data['total'] = count($hasMeals) + $data['companions'];
            //assisted
            $data['assisted'] = 0;
            foreach ($hasMeals as $hasMeal) {
                if ($hasMeal->getAssisted()) {
                    $data['assisted'] ++;
                    if ($hasMeal->getCompanions() > 0) $data['assisted'] += $hasMeal->getCompanions();
                }
            }
            $data['left'] = $data['total'] - $data['assisted'];
            //roles && diets
            foreach ($hasMeals as $hasMeal) {
                $role = $hasMeal->getAttendance()->getRole();
                if (!isset($data[ROLES[$role]])) $data[ROLES[$role]] = 0;
                $data[ROLES[$role]] ++;
                $diet = $hasMeal->getAttendance()->getDiet();
                if (!isset($data[DIETS[$diet]])) $data[DIETS[$diet]] = 0;
                $data[DIETS[$diet]]++;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $data;
    }
    
    private function getCurrentMeal(): Meal {
//         $currentDate = '2018-07-05'; //FAKE!!!
        $currentDate = date('Y-m-d');
        $currentHour = intval(date('H'));
        $currentTurn = ($currentHour > 10 && $currentHour < 18) ? LUNCH : DINNER;
        try {
            $meals = $this->dao->getByFilter("Meal");
            foreach ($meals as $meal) {
                $mealDate = $meal->getDate()->format('Y-m-d');
                if (!strcmp($currentDate, $mealDate) && $currentTurn = $meal->getTurn()) {
                    return $meal;
                }
            }
            throw new InstanceNotFoundException();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}