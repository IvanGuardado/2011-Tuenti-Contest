<?php
$lines = file('php://stdin');
foreach(explode(' ', $lines[0]) as $arg){
    echo getTicks((int)trim($arg)).PHP_EOL;
}

function getTicks($seconds)
{
    $leds = array(
        0 => 2,
        1 => 0,
        2 => 4,
        3 => 1,
        4 => 1,
        5 => 3,
        6 => 1,
        7 => 2,
        8 => 4,
        9 => 0
    );
    $time = new DateTime();
    $time->setTime(0,0,0);
    $ticks = 36;
    $lastTime = str_split('00:00:00');
    for($i=0; $i<=$seconds; $i++){
        $timeArray = str_split($time->format('H:i:s'));
        $diffs = my_array_diff($lastTime, $timeArray);
        //echo implode('', $lastTime).' '.$time->format('H:i:s').' => ';
        foreach($diffs as $diff){
            $inc = $leds[$diff];
            //echo $inc .PHP_EOL;
            $ticks += $leds[$diff];
        }
        $lastTime = $timeArray;
        $time->modify('+1 second');
    }
    return $ticks;
}

function my_array_diff($arr1, $arr2)
{
    $diffs = array();
    for($i=0; $i<count($arr1); $i++){
        if($arr1[$i] != $arr2[$i]){
            $diffs[] = $arr2[$i];
        }
    }
    return $diffs;
}

