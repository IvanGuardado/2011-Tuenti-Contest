<?php
$bits = array();
$im=imagecreatefrompng('out3.png');


$bytes = array();
$c = 0;
for($i=0; $i<imagesx($im); $i++){

    for($j=0; $j<imagesy($im); $j++){
        $rgb = imagecolorat($im, $i, $j);
        if($rgb == 0x000000 || $rgb == 0xFF0000 || $rgb == 0x00FF00){
            continue;
        }
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        echo chr($r);
        echo chr($g);
        echo chr($b);
    }
}
echo $c;

