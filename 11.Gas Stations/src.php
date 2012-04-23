<?php
$lines = file('php://stdin');
$totalTests = intval(array_shift($lines));

for($i=0; $i<$totalTests; $i++)
{
    $k = intval(trim(array_shift($lines)));
    $df = intval(trim(array_shift($lines)));
    $n = intval(trim(array_shift($lines)));
    $ds = trim(array_shift($lines));
    printStops($k, $df, $n, explode(' ', $ds));
}

function printStops($maxDistance, $totalDistance, $totalGasStations, array $distances)
{
    $nextDistance = $maxDistance;
    $stops = array();
    for($i=0; $i<count($distances) && $nextDistance < $totalDistance; $i++){
        if($distances[$i] > $nextDistance){
            $stops[] = $distances[$i-1].' ';
            $nextDistance = $distances[$i-1]+$maxDistance;
            --$i;
        }
    }
    if(count($stops)>0){
        echo implode('', $stops);
    }else{
        echo 'No stops';
    }
    echo PHP_EOL;
}



