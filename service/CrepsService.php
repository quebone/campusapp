<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\CrepShopper;
use Campusapp\Service\Entities\Order;

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
    
    public function createOrder(array $ingredientsArray, string $regToken): int {
        try {
            $shoppers = $this->dao->getByFilter("CrepShopper", ['regToken' => $regToken]);
            if (count($shoppers) == 0) {
                $shopper = new CrepShopper();
                $shopper->setRegToken($regToken);
                $this->dao->persist($shopper);
            } else $shopper = $shoppers[0];
            $users = $this->dao->getByFilter("User", ['regtoken' => $regToken]);
            if (count($users) > 0) $shopper->setuser($users[count($users) - 1]);
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
        $fbs->setToken($shopper->getRegToken());
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