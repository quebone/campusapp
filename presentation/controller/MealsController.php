<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\MealsService;
use Campusapp\Exceptions\InstanceNotFoundException;
use Campusapp\Presentation\Model\MealsModel;

class MealsController extends Controller
{
    private $ms;
    private $mm;
    
    public function __construct() {
        parent::__construct();
        $this->ms = new MealsService();
        $this->mm = new MealsModel();
    }
    
    public function existsCurrentMeal(array $post): array {
        $data = [];
        try {
            $meal = $this->ms->existsCurrentMeal();
            $data = $this->mm->getMealData($meal);
        } catch (InstanceNotFoundException $e) {
            $data['error'] = "No hi ha cap àpat previst";
        } catch (\Exception $e) {
            $data['error'] = $e->getMessage();
        } finally {
            $data['function'] = $post['function'];
            return $data;
        }
    }
    
    public function register(array $post): array {
        $post = $this->decodeUrl($post);
        $data = [];
        $data = $this->ms->register($post['email']);
        $data['function'] = $post['function'];
        return $data;
    }
    
    public function getMealStatistics(): array {
        $data = [];
        try {
            $meals = $this->ms->getAllCurrentMeals();
            foreach ($meals as $meal) {
                $data[] = $this->ms->getMealStatistics($meal);
            }
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}