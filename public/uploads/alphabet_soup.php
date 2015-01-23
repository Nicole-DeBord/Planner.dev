<?php

// Create a function alphabet_soup($str) that accepts a
// string and will return the string in alphabetical order. 
// E.g. "hello world" becomes "ehllo dlorw". So make sure 
// your function separates and alphabetizes each word separately.

function alphabetSoup($string) {
	$array = explode(' ', $string);
		foreach ($array as $value) {
			str_split($value);
			asort($array);		
		}
	// $array = str_split($string);
	// asort($array);
	$arrayString = implode('', $array);
	return $arrayString;
}

$alphabetString = 'Meow meow';

echo alphabetSoup($alphabetString) . PHP_EOL;

?>