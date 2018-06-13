<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\CrepShopper;
use Campusapp\Service\Entities\Order;
use Campusapp\Service\Entities\Person;

class CrepsService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getVisibleIngredients(): array {
        try {
            $ingredients = $this->dao->getByFilter("Ingredient", ['visible'=>TRUE], ['name'=>"ASC"]);
            return $ingredients;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getCrepShopperPendingOrders(string $regtoken): array {
        $pending = [];
        try {
            $persons = $this->dao->getByFilter("Person", ['regtoken' => $regtoken]);
            if (count($persons) == 0) return [];
            $shopper = $this->dao->getByFilter("CrepShopper", ['person' => $persons[0]])[0];
            $orders = $shopper->getOrders();
            foreach ($orders as $order) {
                if (!$order->getServed()) $pending[] = $order->getId();
            }
            return $pending;
        } catch (\Exception $e) {
        }
    }
    
    public function createOrder(array $ingredientsArray, string $regtoken): int {
        try {
            $shoppers = $this->dao->getByFilter("CrepShopper");
            $found = FALSE;
            $i = 0;
            while (!$found && $i < count($shoppers)) {
                if (!strcmp($shoppers[$i]->getRegtoken(), $regtoken)) {
                    $shopper = $shoppers[$i];
                    $found = TRUE;
                } else $i++;
            }
            if (!$found) {
                $person = new Person();
                $this->dao->persist($person);
                $person->setRegtoken($regtoken);
                $shopper = new CrepShopper();
                $shopper->setPerson($person);
                $this->dao->persist($shopper);
            };
            $order = new Order();
            $this->dao->persist($order);
            $order->setCrepShopper($shopper);
            $ingredients = $this->dao->getByFilter("Ingredient");
            foreach ($ingredients as $ingredient) {
                if (in_array($ingredient->getName(), $ingredientsArray)) $order->addIngredient($ingredient);
            }
            $this->dao->flush();
            return $order->getId();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getOrdersNotSent(array $excluded): array {
        try {
            $orders = $this->dao->getByFilter("Order");
            foreach ($orders as $key => $order) {
                if (in_array($order->getId(), $excluded)) unset($orders[$key]);
            }
            return $orders;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function done(int $id): Order {
        try {
            $order = $this->dao->getById("Order", $id);
            if(!$order->getDone()) {
                $order->setDone(TRUE);
                $this->warn($id);
            } else {
                if (!$order->getWarned()) {
                    $order->setDone(FALSE);
                }
            }
            $this->dao->flush();
            return $order;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function warn(int $id): Order {
        try {
            $order = $this->dao->getById("Order", $id);
            $order->setWarned(TRUE);
            $this->sendNotification($order);
            $this->dao->flush();
            return $order;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function serve(int $id): Order {
        try {
            $order = $this->dao->getById("Order", $id);
            $order->setServed(TRUE);
            $this->dao->flush();
            return $order;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    private function sendNotification(Order $order) {
        $fbs = new FirebaseService();
        $shopper = $order->getCrepShopper();
        $fbs->setToken($shopper->getRegtoken());
        $ingredients = $order->getIngredients();
        $ingredientsList = "";
        for ($i = 0; $i < count($ingredients); $i++) {
            if ($i > 0) $ingredientsList .= ", ";
            $ingredientsList .= $ingredients[$i]->getName();
        }
        $fbs->setTitle("El teu crep ja està fet. Té el número " . $order->getId());
        $fbs->setBody("El pots recollir a la parada. Pensa a portar el tiquet");
        $fbs->setMessage("El crep de " . $ingredientsList . " ja està fet amb el número " . $order->getId() . " El pots recollir a la parada. Pensa a portar el tiquet");
        $fbs->send();
    }
}