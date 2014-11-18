<?php

function getInput($first_letter_only = true){
    $input = trim(strtoupper(fgets(STDIN)));
    if($first_letter_only){
        return substr($input, 0, 1);
    } else {
        return $input;
    }
}

function echoArray($array){
    echo PHP_EOL;
    if(sizeof($array) > 10){
        foreach($array as $key=>$value){
            if(($key + 1) % 5 != 0){
                echo "  {$value}  ";
            } else {
                echo "  {$value}  " . PHP_EOL;
            }
        }
    } else {
        foreach($array as $key=>$value) {
            echo $value . PHP_EOL;
        }
    }
}

?>
