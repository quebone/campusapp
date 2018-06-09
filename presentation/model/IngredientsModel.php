<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Ingredient;

class IngredientsModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAllIngredientsData(array $ingredients): array {
        $data = [];
        foreach ($ingredients as $ingredient) {
            $data[] = $this->getIngredientData($ingredient);
        }
        return $data;
    }
    
    public function getIngredientData(Ingredient $ingredient): array {
        return $ingredient->toArray();
    }
}