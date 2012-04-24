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
    $edges = createEdges($values);
    if(getShortestPath($edges, $numberOfPlanets, $earthIndex, $distances) !== false){
        echo $startDate + $distances[$atlantisIndex].' ';
    }else{
        echo 'BAZINGA ';
    }
}
echo PHP_EOL;

function createEdges($values)
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

function getShortestPath($edges, $nodes, $start, array &$distances)
{
    for($i=0; $i<$nodes; $i++){
        $distances[$i] = INF;
    }
    $distances[$start] = 0;
    
    for($i=0; $i<$nodes; $i++){
        for($j=0; $j<count($edges); $j++){
            if ($distances[$edges[$j]->u] != INF) {
                $newDist = $distances[$edges[$j]->u] + $edges[$j]->w;
                if ($newDist < $distances[$edges[$j]->v]){
                    $distances[$edges[$j]->v] = $newDist;
                }
            }
        }
    }
    
    for ($i=0; $i < count($edges); $i++) {
         if ($distances[$edges[$i]->v] > $distances[$edges[$i]->u] + $edges[$i]->w) {
             return false;
         }
     }
     
     return true;   
}
