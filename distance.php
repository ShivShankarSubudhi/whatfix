<?php
read_file();
//read_file
function read_file(){
    $file = fopen("distance_input.txt","r");

    while(! feof($file))
      {
          $line = trim(fgets($file));
          if(!empty($line))
            parse_input($line);
      }

    fclose($file);
}
function parse_input($line){
    $original_line = $line;
    $places_arr = explode(";",$line);
    array_pop($places_arr);
    $places_distance = [];
    foreach ($places_arr as $key => $place) {
        $location = explode(",",$place);
        array_push($places_distance,$location[1]);
    }
    sort($places_distance);

    get_output_distance($places_distance);
}

function get_output_distance($places_distance){
    $output_str = $places_distance[0] .",";
    $prev_value = $places_distance[0];
    foreach ($places_distance as $key => $distance) {
        if($key != 0) {
            $next_value = $distance - $prev_value;
            $output_str .= $next_value . ",";
            $prev_value = $distance;
        }
    }
    echo rtrim($output_str, ",");
    echo "<br />";
}
?>
