<?php

use Campusapp\Service\Entities\WebSchedule;

require_once 'init.php';

define('DEBUG', true);

function toArgs($input): array {
    $data = [];
    $fields = explode("&", $input);
    foreach ($fields as $field) {
        $arr = explode("=", $field);
        $data[$arr[0]] = $arr[1];
    }
    return $data;
}

function test01(string $post) {
    $_POST = toArgs($post);
    require_once 'AjaxController.php';
}

function test02() {
    $xmlFile = WEBDIR.'2018/schedules/01/ca/text.txt';
    $schedule = new WebSchedule(WEBDIR.'2018/schedules/01/', 'ca');
    print_r($schedule->toArray()['activities']);
}

$values = [
//     'cleclerc0744@orange.fr' => '110905200540',
//     'charlottemjn@gmail.com' => '150545202651',
//     'formenti.simone@neuf.fr' => '170166200944',
//     'michelegrospecaut@gmail.com' => '11CX851554',
//     'v.dufourg@lot.chambagri.fr' => '13CF608740',
//     'godwill.abiassi@gmail.com' => '150745202498',
//     'genevieve.graff05@gmail.com' => '150105200054',
//     'phil.maire05@gmail.com' => '100605200507',
//     'dominique.baumle@gmail.com' => '91034303627',
//     'vyvere1000@gmail.com' => '160505200509',
//     'mirunf@free.fr' => '110405200319',
//     'anny.moussier@orange.fr' => '130405200593',
//     'lamesure@wanadoo.fr' => '80105200280',
//     'g.dusserre-bresson@orange.fr' => '170105200473',
//     'irenegmondragon@gmail.com' => '53377231G',
//     'ingridbartesingrid@gmail.com' => '39686177E',
//     'stelisabelle@gmail.com' => '50805200403',
//     'sheyka2009@hotmail.com' => '26541275B',
//     'sophieloubignac@gmail.com' => '110905200400',
//     'majsm612@gmail.com' => '150483202203',
//     'rififi3@wanadoo.fr' => '130505200544',
//     'odile.aguesse@orange.fr' => '61105200507',
//     'mimi.celle@orange.fr' => '121205200114',
//     'jacqlaure05@gmail.com' => '60805200174',
//     'jackietichet@orange.fr' => '169805200653',
//     'albiachm@hotmail.com' => '12CA33915',
//     'bellue.yvonne@orange.fr' => '140705200115',
//     'francoise.steiner0756@orange.fr' => '170505250638',
//     'jdo.loubignac@gmail.com' => '110341101037',
//     'jolcozien@hotmail.fr' => '90892100623',
//     'lapeyre.jc1@free.fr' => '170405250453',
//     'mariejo.pasqualini@neuf.fr' => '140413308800',
//     'monadaura66@gmail.com' => 'francaise',
//     'xxjulioxx@hotmail.fr' => '120566201662',
//     'qu44tre@gmail.com' => '39957818X',
//     'juliagalbas@gmail.com' => '21753600Q',
//     'diana.odekova@gmail.com' => '6603054273',
//     'ceciliasegura59@gmail.com' => '36963783T',
//     'nuriventura@gmail.com' => '35104615Z',
//     'immaijoaquim@hotmail.com' => '46224728H',
//     'pilar.ventura14@gmail.com' => '37658008Q',
//     'mlktgh@gmail.com' => '45FG87654',
//     'ramon.calsina@gmail.com' => '43448406A',
//     'emails.betty@gmail.com' => 'X8525535X',
//     'patchiparloa@gmail.com' => 'X9003395E',
//     'maryse.ferrandez@orange.fr' => '50466201510',
//     'edithrey2120@gmail.com' => '43524296Q',
//     'charlotterebillot@gmail.com' => '81025100123',
//     'andree.chevignard@sfr.fr' => '140666200755',
//     'thierry.trefault@gmail.com' => '110166200568',
    'emabordier@yahoo.fr' => '70966201728',
//     'dianebeauchamps@gmail.com' => '15CR36414',
//     'lud.ricart@gmail.com' => '70366203142',
//     'aseventsone@gmail.com' => 'EN673813',
//     'frantz-martial@orange.fr' => '80966200032',
//     'phitruc@wanadoo.fr' => '171005251170',
];

foreach ($values as $key => $value) {
    test01("email=$key&dni=$value&regtoken=&function=getRegisteredUser&caller=User");
}


