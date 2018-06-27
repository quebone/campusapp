<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Presentation\Model\IngredientsModel;
use Campusapp\Service\IngredientsService;
use Campusapp\Service\Translator;

class IngredientsController extends Controller
{
    private $im;
    private $is;
    
    public function __construct() {
        parent::__construct();
        $this->im = new IngredientsModel();
        $this->is = new IngredientsService();
    }
    
    public function setCrepsEnabled(array $post): bool {
        $sc = new SystemController();
        return $sc->setCrepsEnabled($post);
    }
    
    public function setCrepsManagerPassword(array $post): bool {
        try {
            $sc = new SystemController();
            return $sc->setCrepsManagerPassword($post);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function setCrepsManagerEnabled(array $post): bool {
        $sc = new SystemController();
        return $sc->setCrepsManagerEnabled($post);
    }
    
    public function setMaxPendingCreps(array $post): bool {
        $sc = new SystemController();
        return $sc->setMaxPendingCreps($post);
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
            $this->is->setIngredient($post['id'], $post['name'], $post['visible']);
            Translator::updateOriginal($post['oldname'], $post['name']);
            return TRUE;
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
    
    public function translateIngredient(array $post): bool {
        $post = $this->decodeUrl($post);
        Translator::set($post['original'], $post['translated'], $post['lang']);
        return TRUE;
    }
    
    public function translateIngredients(array $ingredients, string $lang): array {
        $data = [];
        foreach ($ingredients as $ingredient) {
            $ingredient[$lang] = Translator::get($ingredient['name'], $lang);
            $data[] = $ingredient;
        }
        return $data;
    }
    
    public function getMostOrderedIngredients(): array {
        return $this->is->getMostOrderedIngredients();
    }
}