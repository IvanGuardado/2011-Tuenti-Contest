<?php
require_once 'Combo.php';
require_once 'ComboList.php';

$lines = file('php://stdin');
$combosCount = intval(array_shift($lines));
$comboList = new ComboList();
//Load de combos
for($i=0; $i<$combosCount; $i++)
{
    $keys = trim(array_shift($lines));
    $desc = trim(array_shift($lines));
    $comboList->addCombo(new Combo($keys, $desc));
}

//Execute the tests
$tests = intval(array_shift($lines));
for($i=0; $i<$tests; $i++){
    $test = trim(array_shift($lines));
    $filteredComboList = $comboList;    
    foreach(explode(' ', $test) as $key){
        $filteredComboList = $filteredComboList->findByKey($key);
    }
    echo $filteredComboList->getFirst()->getDesc().PHP_EOL;
}
























