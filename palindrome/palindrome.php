<?php

function is_palindrome($string){
    $string = trim(strtolower($string));
    return $string == strrev($string) ? true : false;
}

echo ">";
$input = fgets(STDIN);

echo is_palindrome($input) ? "true" : "false";

echo PHP_EOL;
exit(0);

?>
