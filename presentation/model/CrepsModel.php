<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Ingredient;
use Campusapp\Service\Entities\Order;

class CrepsModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getIngredientsData(array $ingredients): array {
        $data = [];
        foreach ($ingredients as $ingredient) {
            $data[] = $this->getIngredientData($ingredient);
        }
        return $data;
    }
    
    public function getIngredientData(Ingredient $ingredient): array {
        return ['name' => $ingredient->getName()];
    }
    
    public function getOrdersData(array $orders): array {
        $data = [];
        foreach ($orders as $order) {
            $data[] = $this->getOrderData($order);
        }
        return $data;
    }
    
    public function getOrderData(Order $order): array {
        $orderArr = $order->toArray();
        $ingredients = $order->getIngredients();
        $ingredientsArr = [];
        foreach ($ingredients as $ingredient) {
            $ingredientsArr[] = $ingredient->getName();
        }
        $orderArr['ingredients'] = $ingredientsArr;
        return $orderArr;
    }
}