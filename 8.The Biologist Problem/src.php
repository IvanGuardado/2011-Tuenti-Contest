<?php
$input = file('php://stdin');
foreach($input as $line){
    $args = explode(' ', $line);
    $dna1 = trim($args[0]);
    $dna2 = trim($args[1]);
    echo extractSequence($dna1, $dna2).PHP_EOL;
}

function extractSequence($dna1, $dna2){
    $dna1Length = mb_strlen($dna1);
    $dna2Length = mb_strlen($dna2);
    $length = min(array(mb_strlen($dna1),mb_strlen($dna2)));
    while($length > 0){
        for($i=0; $i+$length<=$dna1Length; $i++){
            $seq = substr($dna1, $i, $length);
            if(strpos($dna2, $seq) !== false){
                return $seq;
            }
        }
        $length--;
    }
}


