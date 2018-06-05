<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que modela un àpat
 *
 * @Entity @Table(name="meals")
 */

class Meal implements IEntity
{
	/** @Id @Column(type="integer") @GeneratedValue **/
	private $id;
	/** @Column(type="date") **/
	private $date;
	/** @Column(type="integer") **/
	private $turn;
	
	public function __construct() {
	
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
	
	public function getTurn(): int {
	    return $this->turn;
	}
	
	public function setTurn(int $turn) {
	    $this->turn = $turn;
	}
	
	public function toArray(): array {
		return [
		    "id" => $this->id,
		    "date" => $this->date->format('Y-m-d'),
		    "turn" => $this->turn,
		];
	}
	
	public function __toString(): string {
	    return json_encode($this);
	}
}