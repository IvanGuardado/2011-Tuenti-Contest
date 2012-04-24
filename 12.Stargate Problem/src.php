<?php
define('INFINITY', 99999999);

class Edge
{
    public  $u,
            $v,
            $w;
}


$lines = file('php://stdin');
$startDate = 25000;
foreach($lines as $line)
{
    $distances = array();
    $values = explode(' ', $line);
    $numberOfPlanets = array_shift($values);
    $earthIndex = array_shift($values);
    $atlantisIndex = array_shift($values);
    $graph = createGraph($values);
    if(getShortestPath($graph, $numberOfPlanets, $earthIndex, $distances) !== false){
        echo $startDate + $distances[$atlantisIndex].' ';
    }else{
        echo 'BAZINGA ';
    }
}
echo PHP_EOL;

function createGraph($values)
{
    $edges = array();
    foreach($values as $data){
        $data = explode(',', $data);
        $edge = new Edge;
        $edge->u = (int)array_shift($data);
        $edge->v = (int)array_shift($data);
        $edge->w = (int)array_shift($data);
        $edges[] = $edge;
    }
    return $edges;
}

function getShortestPath($g, $nodes, $start, array &$distances)
{
    for($i=0; $i<$nodes; $i++){
        $distances[$i] = INF;
    }
    $distances[$start] = 0;
    
    for($i=0; $i<$nodes; $i++){
        for($j=0; $j<count($g); $j++){
            if ($distances[$g[$j]->u] != INF) {
                $newDist = $distances[$g[$j]->u] + $g[$j]->w;
                if ($newDist < $distances[$g[$j]->v]){
                    $distances[$g[$j]->v] = $newDist;
                }
            }
        }
    }
    
    for ($i=0; $i < count($g); $i++) {
         if ($distances[$g[$i]->v] > $distances[$g[$i]->u] + $g[$i]->w) {
             return false;
         }
     }
     
     return true;   
}
