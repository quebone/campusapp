<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que modela una assistència
 *
 * @Entity @Table(name="have_meals")
 */

class HasMeal implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="integer") **/
    private $companions;
    /** @Column(type="boolean") **/
    private $assisted;
    /** @Column(type="datetime", nullable=true) **/
    private $date;
    /** @ManyToOne(targetEntity="Attendance") **/
    private $attendance;
    /** @ManyToOne(targetEntity="Meal") **/
    private $meal;
    
    public function __construct() {
        $this->companions = 0;
        $this->assisted = FALSE;
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getCompanions(): int {
        return $this->companions;
    }
    
    public function setCompanions(int $companions) {
        $this->companions = $companions;
    }
    
    public function getAssisted(): bool {
        return $this->assisted;
    }
    
    public function setAssisted(bool $assisted) {
        $this->assisted = $assisted;
    }
    
    public function getDate(): ?\DateTime {
        return $this->date;
    }
    
    public function setdate(\DateTime $date) {
        $this->date = $date;
    }
    
    public function getAttendance(): Attendance {
        return $this->attendance;
    }
    
    public function setAttendance(Attendance $attendance) {
        $this->attendance = $attendance;
    }
    
    public function getMeal(): Meal {
        return $this->meal;
    }
    
    public function setMeal(Meal $meal) {
        $this->meal = $meal;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'companions' => $this->companions,
            'assisted' => $this->assisted,
            'date' => $this->date->format('d-m-Y H:i:s'),
        ];
    }
    
    public function __toString(): string {
        return json_encode($this);
    }
}