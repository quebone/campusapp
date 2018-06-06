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
	/** @OneToOne(targetEntity="Registration") **/
	private $registration;
	/** @ManyToOne(targetEntity="User") **/
	private $user;
	/** @ManyToMany(targetEntity="Meal") **/
	private $meals;
	
	public function __construct() {
	    $this->date = new \DateTime();
	    $this->diet = DIET_NORMAL;
	    $this->accommodation = ACCOMMODATION_SCHOOL;
	    $this->meals = new ArrayCollection();
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
	
	public function getMeals(): ?Selectable {
	    return $this->meals;
	}
	
	public function setMeals(Selectable $meals) {
	    $this->meals = $meals;
	}
	
	public function addMeal(Meal $meal): bool {
	    if (!$this->meals->contains($meal)) {
	        $this->meals->add($meal);
	        return TRUE;
	    }
	    return FALSE;
	}
	
	public function removeMeal(Meal $meal): bool {
	    if ($this->meals->contains($meal)) {
	        $this->meals->removeElement($meal);
	        return TRUE;
	    }
	    return FALSE;
	}
	
	public function toArray(): array {
		return [
		    "id" => $this->id,
		    "date" => $this->date->format('Y-m-d'),
		    "diet" => $this->diet,
		    "accommodation" => $this->accommodation,
		];
	}
	
	public function __toString(): string {
	    return json_encode($this);
	}
}