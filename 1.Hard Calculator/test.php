<?php
$f = fopen("php://stdin", 'r');
$input = stream_get_contents($f);

$total = 0;

$lines = explode(PHP_EOL, $input);

foreach($lines as $line){
    if(mb_strlen($line) > 0){
        if(preg_match_all('/([+-]{0,1}[0-9]+)+/', $line, $matches)){
            foreach($matches[1] as $number){
                $number = (float)$number;
                $total = bcadd($total, $number);
            }
        }
        echo $total.PHP_EOL;
        $total = 0;
    }
}

