<?php
$lines = file('php://stdin');
foreach($lines as $line)
{
    $args = explode(' ', $line);
    $cows = (int)$args[0];
    $maxTotalWeight = $args[1];
    $cowWeights = explode(',', $args[2]);
    $cowProductions = explode(',', $args[3]);
    if(count($cowWeights) != $cows || count($cowProductions) != $cows){
       // throw new InvalidArgumentException($line);
    }
    $results = array();
    for($i=0; $i<$cows; $i++){
        $truckWeight = 0;
        $truckProduction = 0;
        for($j=0; $j<$cows; $j++){
            if($i == $j){
                continue;
            }
            if($truckWeight + $cowWeights[$j] <= $maxTotalWeight){
                $truckWeight += $cowWeights[$j];
                $truckProduction += $cowProductions[$j];
            }
        }
        $results[] = $truckProduction;
    }
    echo max($results).PHP_EOL;
}
