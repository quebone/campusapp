<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Campusapp\DAO;

if (!defined('BASEDIR')) define('BASEDIR', '');
if (!defined('ENTITIESDIR')) define('ENTITIESDIR', BASEDIR . 'service/entities/');

require_once BASEDIR.'vendor/autoload.php';
require_once BASEDIR.'DAO.php';

$paths = array(ENTITIESDIR);
$isDevMode = true;

// the connection configuration
define("LOCAL", true);
// local
if (defined("LOCAL")) {
	$dbParams = array(
	    'driver'   => 'pdo_mysql',
	    'user'     => 'carles',
	    'password' => 'litus',
	    'dbname'   => 'esclatgospelsingers_campus',
	    'charset' => 'utf8',
	);
} else {
	// remote
	$dbParams = array(
	    'driver'   => 'pdo_mysql',
	    'user'     => 'carles',
	    'password' => 'YT52qjf01w',
	    'dbname'   => 'esclatgo_campus',
	    'charset' => 'utf8',
	);
}

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$dao = DAO::getInstance();
$dao->setEM($entityManager);
