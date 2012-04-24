<?php
$lines = file('php://stdin');
foreach($lines as $line){
    $parts = explode(' ', $line);
    $w = (int)array_shift($parts);
    $h = (int)array_shift($parts);
    $n = (int)array_shift($parts);
    $rects = array();
    $m = new Matrix($w, $h);
    for($i=0; $i<$n; $i++){
        $x1 = (int)array_shift($parts);
        $y1 = (int)array_shift($parts);
        $x2 = (int)array_shift($parts);
        $y2 = (int)array_shift($parts);
        $color = (int)array_shift($parts);
        $m->addRectangle($x1, $y1, $x2, $y2, $color);
    }
    foreach($m->calculateAreas() as $color=>$area){
        echo $color.' '.$area.' ';
    }
    echo PHP_EOL;
}


class Matrix
{
    protected $m;
    public function __construct($w, $h)
    {
        for($i=0; $i<$w; $i++){
            for($j=0; $j<$h; $j++){
                $this->m[$i][$j] = 1;
            }
        }
    }
    
    public function addRectangle($x1, $y1, $x2, $y2, $color)
    {
        for($i=$x1; $i<$x2; $i++){
            for($j=$y1; $j<$y2; $j++){
                $this->m[$i][$j] = $color;
            }
        }
    }
    
    public function calculateAreas()
    {
        $areas = array();
        for($i=0; $i<count($this->m); $i++){
            for($j=0; $j<count($this->m[$i]); $j++){
                $color = $this->m[$i][$j];
                if(!isset($areas[$color])){
                    $areas[$color] = 0;
                }
                $areas[$color]++;
            }
        }
        return $areas;
    }
    
    public function _print()
    {
        for($i=0; $i<count($this->m[0]); $i++){
            for($j=0; $j<count($this->m); $j++){
                echo $this->m[$j][$i];
            }
            echo PHP_EOL;
        }
    }
}
