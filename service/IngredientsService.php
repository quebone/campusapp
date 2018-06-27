<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Ingredient;
use Campusapp\Exceptions\DuplicatedInstanceException;

class IngredientsService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getIngredients(): array {
        try {
            return $this->dao->getByFilter("Ingredient", [], ['name'=>'ASC']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addIngredient(string $name): Ingredient {
        try {
            $ingredients = $this->dao->getByFilter("Ingredient", ['name'=>$name]);
            if (count($ingredients) == 0) {
                $ingredient = new Ingredient();
                $ingredient->setName($name);
                $this->dao->persistAndFlush($ingredient);
                return $ingredient;
            } else throw new DuplicatedInstanceException();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function setIngredient(int $id, string $name, bool $visible): bool {
        try {
            $ingredient = $this->dao->getById("Ingredient", $id);
            $ingredients = $this->dao->getByFilter("Ingredient", ['name'=>$name]);
            if (count($ingredients) > 0 && $ingredients[0] != $ingredient) {
                throw new DuplicatedInstanceException();
            }
            $ingredient->setName($name);
            $ingredient->setVisible($visible);
            $this->dao->flush();
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getIngredient(int $id): Ingredient {
        try {
            $ingredient = $this->dao->getById("Ingredient", $id);
            return $ingredient;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteIngredient(int $id): bool {
        try {
            $ingredient = $this->dao->getById("Ingredient", $id);
            $this->dao->remove($ingredient);
            $this->dao->flush();
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getMostOrderedIngredients(): array {
        $orders = $this->dao->getByFilter("Order");
        $data = [];
        foreach ($orders as $order) {
            $ingredients = $order->getIngredients();
            foreach ($ingredients as $ingredient) {
                $found = FALSE;
                $i = 0;
                while (!$found && $i < count($data)) {
                    if ($data[$i]['id'] == $ingredient->getId()) $found = TRUE;
                    else $i++;
                }
                if ($found) $data[$i]['number']++;
                else {
                    $data[$i]['number'] = 1;
                    $data[$i]['id'] = $ingredient->getId();
                    $data[$i]['name'] = $ingredient->getName();
                }
            }
        }
        usort($data, array($this, "cmp"));
        return $data;
    }
    
    private function cmp($a, $b) {
        if ($a['number'] == $b['number']) {
            return 0;
        }
        return ($a['number'] > $b['number']) ? -1 : 1;
    }
}