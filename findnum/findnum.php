<?php
/* Write a function. What is the smallest positive number that is evenly divisible by all of the numbers from 1 to 20?*/


//This algorithm works well for small numbers but rapidly becomes untractable after 18.
function findNum($max){
	$i = 1;
	$n = 1;

	do{
		$check = $i % $n == 0 ? true : false;
		if ($check){
			$n++;
		} else {
			$n = 1;
			$i++;
		}
	}while($n <= $max);

	echo "\nThe smallest number evenly divisible by {$max} is {$i}." . PHP_EOL;
	return 0;
}

// This is a better way. Found soulution in C# online and transalted to PHP.
$num = $argv[1];

function gcd($a, $b)
{
    while ($b != 0)
    {
        $a %= $b;
        $a ^= $b;
        $b ^= $a;
        $a ^= $b;
    }
 
    return $a;
}
 
function lcm($a, $b)
{
    return $a / gcd($a, $b) * $b;
}
 

$res = 1;

for ($i = 2; $i <= 20; $i++) {
    $res = lcm($res, $i);
}
 
echo "\n{$res}";

return 0;

exit(0);
?>