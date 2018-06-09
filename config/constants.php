<?php
if (!defined('BASEDIR')) define('BASEDIR', __DIR__);
define('PRESENTATIONDIR', BASEDIR.'presentation/');
define('TPLDIR', PRESENTATIONDIR.'template/');
define('MODELDIR', BASEDIR.'service/');
define('ENTITIESDIR', MODELDIR.'entities/');
define('FILESDIR', BASEDIR.'files/');
define('LANGUAGESDIR', BASEDIR.'languages/');
define('TMPDIR', 'tmp/');
define('ACCREDITATIONSDIR', 'accreditations/');

define('ENTITIESNS', 'Campusapp\\Service\\Entities\\');

define("LOGIN_ERROR", "Hi hagut un error en l'entrada de dades. Torna-ho a provar");

define('LOCALE', 0);
define('REMOTE', 1);

define('ADMIN_EGS_EMAIL', 'admin@esclatgospelsingers.com');
define('DEFAULT_PASSWORD', 'campusgospel');

// user groups
define('CAMPUSI', 1);
define('EGS', 2);
define('STAFF', 3);
define('MUSICIAN', 4);
define('OTHERS', 5);
define('MANAGER', 6);
define('ADMINISTRATOR', 7);

const ROLES = [
    CAMPUSI => 'Campusí',
    EGS => 'Esclat',
    STAFF => 'Organització',
    MUSICIAN => 'Músic',
    OTHERS => 'Altres',
    MANAGER => 'Gestor',
    ADMINISTRATOR => 'Administrador',
];

// week days
define('SUNDAY', 0);
define('MONDAY', 0);
define('TUESDAY', 0);
define('WEDNESDAY', 0);
define('THURSDAY', 4);
define('FRIDAY', 5);
define('SATURDAY', 6);

// day parts
define('MORNING', 0);
define('AFTERNOON', 1);

// registration type
define('FULL_REGISTRATION', 0);
define('CUSTOM_REGISTRATION', 1);

// accommodation type
define('ACCOMMODATION_SCHOOL', 0);
define('ACCOMMODATION_CAMP', 1);
define('ACCOMMODATION_OTHER', 2);

// diets
define('DIET_NORMAL', 0);
define('DIET_VEGETARIAN', 1);
define('DIET_CELIAC', 2);

// turns
define('LUNCH', 0);
define('DINNER', 1);
