<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\CrepsService;
use Campusapp\Presentation\Model\CrepsModel;
use Campusapp\Service\SystemService;
use Campusapp\Exceptions\MaxCrepOrdersException;
use Campusapp\Exceptions\CrepShopIsClosedException;
use Campusapp\Service\Translator;

class CrepsController extends Controller
{
    private $cs;
    private $cm;
    
    public function __construct() {
        parent::__construct();
        $this->cs = new CrepsService();
        $this->cm = new CrepsModel();
    }
    
    public function getIngredients(array $post): array {
        try {
            $ingredients = $this->cs->getVisibleIngredients();
            if (file_exists(LANGUAGESDIR.$post['lang'])) {
                foreach ($ingredients as $ingredient) {
                    $translated = Translator::get($ingredient->getName(), $post['lang']);
                    if (strlen($translated) > 0) $ingredient->setName($translated);
                }
            }
            return $this->cm->getIngredientsData($ingredients);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function createOrder(array $post): int {
        $post = $this->decodeUrl($post);
        $pendingOrders = $this->cs->getCrepShopperPendingOrders($post['regtoken'], $post['lang']);
        $ss = new SystemService();
        if (!$ss->getCrepsEnabled()) throw new CrepShopIsClosedException();
        if (count($pendingOrders) >= $ss->getSystem()->getMaxPendingCreps()) {
            $e = new MaxCrepOrdersException();
            $e->setMessage(Translator::get($e->getMessage(), $post['lang']));
            throw $e;
        }
        $ingredients = $post['ingredients'];
        $ingredients = explode(",", substr($ingredients, 1, strlen($ingredients) - 2));
        foreach ($ingredients as $key => $value) $ingredients[$key] = trim($value);
        try {
            return $this->cs->createOrder($ingredients, $post['regtoken'], $post['lang']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getPendingOrders(array $post): array {
        $post = $this->decodeUrl($post);
        return $this->cs->getCrepShopperPendingOrders($post['regtoken'], $post['lang']);
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
    
    public function setCrepsEnabled(array $post): bool {
        $sc = new SystemController();
        return $sc->setCrepsEnabled($post);
    }

    public function getCrepsManagerEnabled(): bool {
        $ss = new SystemService();
        return $ss->getCrepsManagerEnabled();
    }
}