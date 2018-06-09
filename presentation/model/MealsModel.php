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
}