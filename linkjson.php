<?php
/**
 * UNT Grades JSON File Linker
 * @author Jeffrey Wang (@jeffw16)
*/

$files = array("static/fall2017spring2018.json", "static/fall2018.json", "static/spring2019.json");
$complete = "static/complete.json";
$combo = array();

for ($i = 0; $i < count($files); $i++)
{
	$file = fopen($files[$i], 'r');
	$current = json_decode(fread($file, filesize($files[$i])), true);
	$combo = array_merge($combo, $current);
}

$output = fopen($complete, 'w+');
$string = json_encode($combo);
fwrite($output ,$string);
