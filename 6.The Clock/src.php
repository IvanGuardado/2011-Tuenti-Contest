<?php
$numberSegments = array(
    0=>6, 
    1=>2,
    2=>5,
    3=>5,
    4=>4,
    5=>5,
    6=>6,
    7=>3,
    8=>7,
    9=>5
);
$resultCache = array();
$numberDigitsCache = array();
$resultCacheMaxKey = 0;

function main()
{
    global $resultCache, $resultCacheMaxKey;
    $resultList = array();
    $lines = file('php://stdin');
    foreach(explode(' ', $lines[0]) as $arg){
        $seconds = intval($arg);
        $startAt = 0;
        if( !($result = getFromCache($resultCache, $seconds)) ){
            if($seconds > $resultCacheMaxKey){
                $startAt = $resultCacheMaxKey;
                $base = getFromCache($resultCache, $resultCacheMaxKey);
                $result = $base + calculateLedTicks($seconds, $startAt);
            }else{
                $result = calculateLedTicks($seconds);
            }
        }
        $resultList[] = $result;
        
        addToCache($resultCache, $seconds, $result);
        $resultCacheMaxKey = max(array($resultCacheMaxKey, $seconds));
    }
    echo implode(" ", $resultList).PHP_EOL;
}
main();
//echo '--------------------'.PHP_EOL;
//echo xdebug_time_index().PHP_EOL;

function calculateLedTicks($seconds, $startAt=null)
{
    $startAt = $startAt !== null? $startAt+1 : 0;
    $time = new DateTime();
    $time->setTime(0,0,$startAt);
    $ticks = 0;
    for($i=$startAt; $i<=$seconds; $i++){
        $ticks += getLedsTurnedOn($time->format('H'));
        $ticks += getLedsTurnedOn($time->format('i'));
        $ticks += getLedsTurnedOn($time->format('s'));
        $time->modify('+1 second');
    }
    return $ticks;
}

function getLedsTurnedOn($number)
{
    global $numberDigitsCache;
    if( !( $total = getFromCache($numberDigitsCache,$number)) ){
        global $numberSegments;
        $total = 0;
        for($i=0; $i<strlen($number); $i++){
            $total += $numberSegments[$number[$i]];
        }
        addToCache($numberDigitsCache, $number, $total);
    }
    return $total;
}

function getFromCache($cache, $number)
{
    if(isset($cache[$number])){
        return $cache[$number];
    }else{
        return null;
    }
}
function addToCache(&$cache, $number, $total)
{
    $cache[$number] = $total;
}
