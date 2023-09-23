<?php

use MongoDB\Operation\Explain;

function getTimers(){
    return json_decode(file_get_contents(__DIR__ . '/../data/timers.json'));
}

function setTimers($data) {
    file_put_contents(__DIR__ . '/../data/timers.json', json_encode($data));
}

function getDataB(){
    $dados = getLastInsertedObject();

    if(!$dados){
        $dados = json_decode('[ {"IP":"0.0.0.0", "DATAB": [ ] } ]')[0];
    }

    return $dados;
}

function getUltimaAtualizacao() {
    $dados = getDataB();

    if($dados && count($dados->DATAB) > 0) {        
        return end($dados->DATAB);
    }

    return array();
}

function setDataB($dataB) {
    $_SESSION["dataB"] = $dataB;
}

function getTimersAndDataB(){ 
    $dados = (array) getDataB();
    $timers = (array) getTimers()[0];
    $data =(object) array_merge($dados, $timers);
    return array($data);
}

function salvaDataB($data) {
    insertDocument($data);
}

function loadDBInicial() {
    if(!hasDocuments()){
        return insertDocument(json_decode('[ {"IP":"0.0.0.0", "DATAB": [ ] } ]'));
    }
}

function getDataAtual() {
    return date('d-m-Y');
}

function getHoraAtual() {
    return date('H:00');
}

function isDataHoraAtualInTimer($datas) {

    $datas = mergeDiasHoras($datas);


    $dayTranslations = [
        'Mon' => 'Seg',
        'Tue' => 'Ter',
        'Wed' => 'Qua',
        'Thu' => 'Qui',
        'Fri' => 'Sex',
        'Sat' => 'Sab',
        'Sun' => 'Dom'
    ];

    $currentDate = date("D");
    $currentTime = date("H:i");

    $currentDatePortuguese = $dayTranslations[$currentDate] ?? null;
    if (!$currentDatePortuguese) {
        return false;
    }

    
    if (!isset($datas[$currentDatePortuguese])) {
        return false;
    }

    $dayTimers = $datas[$currentDatePortuguese];

    $smallerTime = $dayTimers[0];
    $biggerTime = isset($dayTimers[1]) ? $dayTimers[1] : $dayTimers[0];

    if ($currentTime < $smallerTime || $currentTime > $biggerTime) {
        return false;
    }

    return true;
}

function mergeDiasHoras($data) {
    $mergedArray = [];

    foreach ($data as $array) {
        $weekDays = array_unique($array[0]); 
        $dayTimers = array_unique($array[1]);
        sort($dayTimers);

        foreach ($weekDays as $weekDay) {
            if (!isset($mergedArray[$weekDay])) {
                $mergedArray[$weekDay] = [];
            }
            
            $mergedArray[$weekDay] = array_merge($mergedArray[$weekDay], $dayTimers);
            $mergedArray[$weekDay] = array_unique($mergedArray[$weekDay]);
            $mergedArray[$weekDay] = array_slice($mergedArray[$weekDay], 0, 2);
        }
    }

    return $mergedArray;
}


function isExisteTimer($json_data) {

    return isset($json_data->DATAS) && count($json_data->DATAS) > 0;
}