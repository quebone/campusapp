<?php
namespace Campusapp\Service\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * Classe que modela una assistència
 *
 * @Entity @Table(name="attendances")
 */

class Attendance implements IEntity
{
	/** @Id @Column(type="integer") @GeneratedValue **/
	private $id;
	/** @Column(type="date") **/
	private $date;
	/** @Column(type="integer") **/
	private $diet;
	/** @Column(type="integer") **/
	private $accommodation;
	/** @Column(type="integer", nullable=true) **/
	private $role;
	/** @OneToOne(targetEntity="Registration") **/
	private $registration;
	/** @ManyToOne(targetEntity="User") **/
	private $user;
	/** @OneToMany(targetEntity="HasMeal", mappedBy="attendance", cascade={"all"}) **/
	private $hasMeals;
	
	public function __construct() {
	    $this->date = new \DateTime();
	    $this->diet = DIET_NORMAL;
	    $this->accommodation = ACCOMMODATION_SCHOOL;
	    $this->role = CAMPUSI;
	    $this->hasMeals = new ArrayCollection();
	}
	
	public function getId(): int {
		return $this->id;
	}
	
	public function getDate(): \DateTime {
	    return $this->date;
	}
	
	public function setDate(\DateTime $date) {
	    $this->date = $date;
	}
	
	public function getDiet(): int {
	    return $this->diet;
	}
	
	public function setDiet(int $diet) {
	    $this->diet = $diet;
	}
	
	public function getAccommodation(): int {
	    return $this->accommodation;
	}
	
	public function setAccommodation(int $accommodation) {
	    $this->accommodation = $accommodation;
	}
	
	public function getRole(): int {
	    return $this->role;
	}
	
	public function setRole(int $role) {
	    $this->role = $role;
	}
	
	public function getRegistration(): ?Registration {
	    return $this->registration;
	}
	
	public function setRegistration(Registration $registration) {
	    $this->registration = $registration;
	}
	
	public function getUser(): ?User {
	    return $this->user;
	}
	
	public function setuser(User $user) {
	    $this->user = $user;
	}
	
	public function getHasMeals(): ?Selectable {
	    return $this->hasMeals;
	}
	
	public function setHasMeals(Selectable $hasMeals) {
	    $this->hasMeals = $hasMeals;
	}
	
	public function addHasMeal(HasMeal $hasMeal) {
        $this->hasMeals->add($hasMeal);
	}
	
	public function removeHasMeal(HasMeal $hasMeal) {
        $this->hasMeals->removeElement($hasMeal);
	}
	
	public function getMeals(): array {
	    $meals = [];
	    foreach ($this->hasMeals as $hasMeal) {
	        $meals[] = $hasMeal->getMeal();
	    }
	    return $meals;
	}
	
	public function toArray(): array {
		return [
		    "id" => $this->id,
		    "date" => $this->date->format('Y-m-d'),
		    "diet" => $this->diet,
		    "accommodation" => $this->accommodation,
		    'role' => $this->role,
		];
	}
	
	public function __toString(): string {
	    return json_encode($this);
	}
}