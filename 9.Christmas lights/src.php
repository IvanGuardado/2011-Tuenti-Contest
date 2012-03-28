<?php
$lines = file('php://stdin');
$tests = intval(array_shift($lines));
if($tests > 100){
    throw InvalidArgumentException();
}
for($offset=0, $i=0; $i<$tests; $i++, $offset +=2){
    $args = array_slice($lines, $offset, 2);
    $lights = validateRange($args[0], 1, 100);
    $instant = validateRange($args[1], 1, pow(10,9));
    echo calculateLightsTurnedOn($lights, $instant).PHP_EOL;
}

function calculateLightsTurnedOn($lights, $instant)
{
    $lastLightOn = $instant -1;
    $result = array();
    for($i=$lastLightOn; $i>=0; $i-=2){
        if($i<$lights){
            $result[] = $i;
        }
    }
    if(count($result)){
        return implode(' ', array_reverse($result));
    }else{
        return 'All lights are off :(';
    }
}

function validateRange($value, $minValue, $maxValue)
{
    if($minValue <= $value && $value <= $maxValue){
        return $value;
    }else{
     throw new InvalidArgumentException();
    }
}
