<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Attendance;

class AttendancesModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAttendanceData(Attendance $attendance): array {
        $data = $attendance->toArray();
        $data['roleName'] = ROLES[$attendance->getRole()];
        $data['thursdayDinner'] = FALSE;
        $data['fridayLunch'] = FALSE;
        $data['fridayDinner'] = FALSE;
        $data['saturdayLunch'] = FALSE;
        $data['saturdayDinner'] = FALSE;
        $data['sundayLunch'] = FALSE;
        $meals = $attendance->getMeals();
        foreach ($meals as $meal) {
            $mealWeekDay = intval(date("w", $meal->getDate()->format('U')));
            $mealTurn = $meal->getTurn();
            if ($mealWeekDay == THURSDAY && $mealTurn == DINNER) {
                $data['thursdayDinner'] = TRUE;
            } elseif ($mealWeekDay == FRIDAY && $mealTurn == LUNCH) {
                $data['fridayLunch'] = TRUE;
            } elseif ($mealWeekDay == FRIDAY && $mealTurn == DINNER) {
                $data['fridayDinner'] = TRUE;
            } elseif ($mealWeekDay == SATURDAY && $mealTurn == LUNCH) {
                $data['saturdayLunch'] = TRUE;
            } elseif ($mealWeekDay == SATURDAY && $mealTurn == DINNER) {
                $data['saturdayDinner'] = TRUE;
            } elseif ($mealWeekDay == SUNDAY && $mealTurn == LUNCH) {
                $data['sundayLunch'] = TRUE;
            }
        }
        return $data;
    }
}