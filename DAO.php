<?php
namespace Campusapp;

use Doctrine\ORM\EntityManager;
use Campusapp\Service\Entities\IEntity;
use Campusapp\Exceptions\InstanceNotFoundException;

final class DAO
{
	private $em = null;
	
	private function __construct() {
		
	}
	
	private function __clone() {
		
	}
	
	private function __wakeup() {
		
	}
	
	public static function getInstance() {
		static $instance = null;
		if ($instance === null) {
			$instance = new DAO();
		}
		return $instance;
	}
	
	public function setEM(EntityManager $em) {
		$this->em = $em;
	}
	
	public function getEM(): EntityManager {
	    return $this->em;
	}
	
	public function getById($entity, $id): ?IEntity {
	    if (strpos($entity, ENTITIESNS) === false) $entity = ENTITIESNS . $entity;
		try {
		    $instance = $this->em->find($entity, $id);
		    if ($instance != null) return $instance;
		    throw new InstanceNotFoundException("$entity with id=$id not found");
		} catch (\Exception $e) {
			throw $e;
		}
	}
	
	public function getByFilter($entity, $filter = array(), $order = array(), bool $strict=TRUE): array {
	    if (strpos($entity, ENTITIESNS) === false) $entity = ENTITIESNS . $entity;
	    try {
	        $repository = $this->em->getRepository($entity);
	    } catch (\Exception $e) {
	        throw $e;
	    }
	    $strict = $strict || count($filter) == 0 || !is_string($filter[key($filter)]);
	    if ($strict) {
	        return $this->em->getRepository($entity)->findBy($filter, $order);
	    } else {
	        $query = "SELECT e FROM " . $entity . " e WHERE e." . key($filter) . " LIKE '%" . $filter[key($filter)] . "%'";
	        $dql_query = $this->em->createQuery($query);
	        return $dql_query->getResult();
	    }
	}
	
	public function persist($object) {
		$this->em->persist($object);
	}
	
	public function persistAndFlush($object) {
		$this->persist($object);
		$this->flush();
	}
	
	public function remove($object) {
		$this->em->remove($object);
	}
	
	public function flush() {
		try {
			$this->em->flush();
		} catch (\Exception $e) {
			throw $e;
		}
	}
	
	public function setVar($entity, $id, $var, $value) {
		$instance = $this->getById($entity, $id);
		$instance->{"set" . ucfirst($var)}($value);
		$this->flush();
	}
	
	public function setObj($entity, $id, $var, $value) {
		$instance = $this->getById($entity, $id);
		$obj = $this->getById(ucfirst($var), $value);
		$instance->{"set" . ucfirst($var)}($obj);
		$this->flush();
	}
	
	public function create($entity) {
	    if (strpos($entity, ENTITIESNS) === false) $entity = ENTITIESNS . $entity;
		$instance = new $entity();
		return $instance;
	}
}
