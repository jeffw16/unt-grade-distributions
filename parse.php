<?php
/**
 * UNT Grades Parser
 * @author Jeffrey Wang (@jeffw16)
*/

$csv_filename = 'UNT_Grade_Distributions-Fall2018';
$json_filename = 'fall2018';
$term = '2018 Fall';

$res_csv = fopen( 'static/' . $csv_filename . '.csv', 'r' );
$res_json = fopen( 'static/' . $json_filename . '.json', 'w' );

$arr = array();
$csv_line = array();
while ( ( $csv_line = fgetcsv( $res_csv ) ) !== false ) {
  $arr[] = $csv_line;
}
// print_r($arr);
$narr = array();

// start at 1st row because the first row contains introductory background info
for ( $i = 1; $i < count( $arr ); $i++ ) {
  $linearr = array();
  $linearr['term'] = $term;
  $linearr['prof'] = utf8_encode($arr[$i][0]); // primary professor
  $linearr['subj'] = utf8_encode($arr[$i][3]);
  $linearr['num'] = utf8_encode($arr[$i][4]);
  $linearr['sect'] = utf8_encode($arr[$i][5]);
  $linearr['desc'] = utf8_encode($arr[$i][6]);
  if ( $i > 0 && sizeof($narr) > 0 && $arr[$i - 1][3] == $linearr['subj'] && $arr[$i - 1][4] == $linearr['num'] && $arr[$i][5] == $linearr['sect'] ) {
    $narr[sizeof($narr) - 1]['grades'][utf8_encode($arr[$i][8])] = utf8_encode($arr[$i][9]);
  } else {
    $linearr['grades'] = array();
    $linearr['grades'][utf8_encode($arr[$i][8])] = utf8_encode($arr[$i][9]);
    $narr[] = $linearr;
  }
}

$jsonstr = json_encode( $narr, JSON_UNESCAPED_UNICODE );

if ( $jsonstr === false ) {
  echo "Error!";
  echo json_last_error();
} else {
  fwrite( $res_json,  $jsonstr);
}
