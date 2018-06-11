<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\CrepsService;
use Campusapp\Presentation\Model\CrepsModel;

class CrepsController extends Controller
{
    private $cs;
    private $cm;
    
    public function __construct() {
        parent::__construct();
        $this->cs = new CrepsService();
        $this->cm = new CrepsModel();
    }
    
    public function getIngredients(): array {
        try {
            $ingredients = $this->cs->getVisibleIngredients();
            return $this->cm->getIngredientsData($ingredients);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function createOrder(array $post): int {
        $post = $this->decodeUrl($post);
        $ingredients = explode(',', $post['ingredients']);
        try {
            return $this->cs->createOrder($ingredients, $post['regToken']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getOrdersNotSent(array $post): array {
        $ids = explode(',', $post['ids']);
        try {
            $orders = $this->cs->getOrdersNotSent($ids);
            return $this->cm->getOrdersData($orders);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function done(array $post): array {
        $id = intval($post['id']);
        try {
            $order = $this->cs->done($id);
            return $this->cm->getOrderData($order);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function warn(array $post): array {
        $id = intval($post['id']);
        try {
            $order = $this->cs->warn($id);
            return $this->cm->getOrderData($order);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function serve(array $post): array {
        $id = intval($post['id']);
        try {
            $order = $this->cs->serve($id);
            return $this->cm->getOrderData($order);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}