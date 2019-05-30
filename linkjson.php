<?php
/**
 * UNT Grades JSON File Linker
 * @author Jeffrey Wang (@jeffw16)
*/

$json_filename = 'fall2018';

$res_json = fopen( 'static/' . $json_filename . '.json', 'r' );
$res_comp_read = fopen( 'static/complete.json', 'r' );
#$res_comp_write = fopen( 'static/complete.json', 'w' );

$arr = json_decode(fread($res_comp_read, filesize('static/complete.json')), true);
echo json_last_error();
$narr = json_decode(fread($res_json, filesize('static/' . $json_filename . '.json')), true);
echo json_last_error();

$combo = array_merge($arr, $narr);

$res_comp_write = fopen( 'static/complete.json', 'w' );
$writestr = json_encode( $combo );
fwrite( $res_json, $writestr );
echo json_last_error();
