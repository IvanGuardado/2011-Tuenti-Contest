<?php
function isPrime($number)
{
    foreach(range(2,$number-1) as $n){
        if ($number % $n == 0){
            return false;
        }
    }
    return true;
}

function isEmirp($number)
{
    return isPrime($number) && isPrime((int)strrev($number));
}

function getEmirpsSum($number)
{
    $total = 0;
    foreach(range(13, $number, 2) as $n){
        if(isEmirp($n)){
            $total += $n;
        }
    }
    return $total;
}

$inputLines = file('php://stdin');
foreach($inputLines as $line){
    $number = intval(trim($line));
    echo getEmirpsSum($number).PHP_EOL;
}
