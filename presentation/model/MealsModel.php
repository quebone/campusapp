<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Meal;
use Campusapp\Service\MealsService;

class MealsModel extends Model
{
    public function __construct() {
        
    }
    
    public function getMealData(Meal $meal): array {
        $ms = new MealsService();
        $data = [];
        try {
            $data['statistics'] = $ms->getMealStatistics($meal);
        } catch (\Exception $e) {
        } finally {
            return $data;
        }
    }
    
    public function getDinersData(array $diners): array {
        $data = [];
        foreach ($diners as $diner) {
            $date = $diner['meal']->getDate();
            $data[] = [
                'name' => $diner['user']->getName(),
                'surnames' => $diner['user']->getSurnames(),
                'assisted' => $diner['meal']->getAssisted(),
                'date' => $date ? $date->format('d-m-Y H:i:s') : "",
            ];
        }
        return $data;
    }
}