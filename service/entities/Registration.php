<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que modela una inscripció
 *
 * @Entity @Table(name="registrations")
 */

class Registration implements IEntity
{
	/** @Id @Column(type="integer") @GeneratedValue **/
	private $id;
	/** @Column(type="boolean") **/
	private $firstYearInCampus;
	/** @Column(type="integer") **/
	private $arrivalDay;
	/** @Column(type="integer") **/
	private $arrivalTime;
	/** @Column(type="integer") **/
	private $registrationType;
	/** @Column(type="boolean") **/
	private $emailSpread;
	/** @Column(type="boolean") **/
	private $imageRights;
	/** @Column(type="boolean") **/
	private $musicalKnowledge;
	/** @Column(type="string", length=255, nullable=true) **/
	private $observations;
	
	public function __construct() {
	   $this->firstYearInCampus = FALSE;
	   $this->arrivalDay = THURSDAY;
	   $this->arrivalTime = MORNING;
	   $this->registrationType = FULL_REGISTRATION;
	   $this->emailSpread = FALSE;
	   $this->imageRights = FALSE;
	   $this->musicalKnowledge = FALSE;
	   $this->observations = "";
	}
	
	public function getId(): int {
		return $this->id;
	}
	
	public function getFirstYearInCampus(): bool {
	    return $this->firstYearInCampus;
	}
	
	public function setFirstYearInCampus(bool $firstYearInCampus) {
	    $this->firstYearInCampus = $firstYearInCampus;
	}
	
	public function getArrivalDay(): int {
	    return $this->arrivalDay;
	}
	
	public function setArrivalDay(int $arrivalDay) {
	    $this->arrivalDay = $arrivalDay;
	}
	
	public function getArrivalTime(): int {
	    return $this->arrivalTime;
	}
	
	public function setArrivalTime(int $arrivalTime) {
	    $this->arrivalTime = $arrivalTime;
	}
	
	public function getRegistrationType(): int {
	    return $this->registrationType;
	}
	
	public function setRegistrationType(int $registrationType) {
	    $this->registrationType = $registrationType;
	}

	public function getEmailSpread(): bool {
	    return $this->emailSpread;
	}
	
	public function setEmailSpread(bool $emailSpread) {
	    $this->emailSpread = $emailSpread;
	}
	
	public function getImageRights(): bool {
	    return $this->imageRights;
	}
	
	public function setImageRights(bool $imageRights) {
	    $this->imageRights = $imageRights;
	}
	
	public function getMusicalKnowledge(): bool {
	    return $this->musicalKnowledge;
	}
	
	public function setMusicalKnowledge(bool $musicalKnowledge) {
	    $this->musicalKnowledge = $musicalKnowledge;
	}
	
	public function getObservations(): ?string {
	    return $this->observations;
	}
	
	public function setObservations(?string $observations) {
	    $this->observations = $observations;
	}
	
	public function toArray(): array {
		return [
		    "id" => $this->id,
		    'firstYearInCampus' => $this->firstYearInCampus,
		    'arrivalDay' => $this->arrivalDay,
		    'arrivalTime' => $this->arrivalTime,
		    'registrationType' => $this->registrationType,
		    'emailSpread' => $this->emailSpread,
		    'imageRights' => $this->imageRights,
		    'musicalKnowledge' => $this->musicalKnowledge,
		    'observations' => $this->observations,
		];
	}
	
	public function __toString(): string {
	    return json_encode($this);
	}
}