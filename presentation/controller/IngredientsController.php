<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Presentation\Model\IngredientsModel;
use Campusapp\Service\IngredientsService;

class IngredientsController extends Controller
{
    private $im;
    private $is;
    
    public function __construct() {
        parent::__construct();
        $this->im = new IngredientsModel();
        $this->is = new IngredientsService();
    }
    
    public function getIngredients(): array {
        try {
            $ingredients = $this->is->getIngredients();
            return $this->im->getAllIngredientsData($ingredients);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addIngredient(array $post): bool {
        $post = $this->decodeUrl($post);
        try {
            $ingredient = $this->is->addIngredient($post['name']);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function setIngredient(array $post): bool {
        $post = $this->normalize($post);
        try {
            return $this->is->setIngredient($post['id'], $post['name'], $post['visible']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getIngredient(array $post): array {
        try {
            $ingredient = $this->is->getIngredient(intval($post['id']));
            return $this->im->getIngredientData($ingredient);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteIngredient(array $post): bool {
        try {
            return $this->is->deleteIngredient(intval($post['id']));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}