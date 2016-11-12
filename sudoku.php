<?php
read_file();
//read_file
function read_file()
{
    $file = fopen("sudoku_input.txt", "r");

    while (!feof($file)) {

        $line = trim(fgets($file));
        if (!empty($line))
            parse_input($line);
    }

    fclose($file);
}

// forms the required sudoku matrix
function parse_input($line)
{
    $original_line = $line;
    $line          = str_replace(",", "", $line);
    $line          = str_replace(";", "", $line);
    $mat_dimension = $line[0];

    // check whether the matrix dimension is square or not
    if (sqrt($mat_dimension) == ceil(sqrt($mat_dimension))) {
        $final_matrix = array();

        $temp_arr = array();
        for ($i = 1; $i < strlen($line); $i++) {
            array_push($temp_arr, $line[$i]);
            if (count($temp_arr) == $mat_dimension) {
                array_push($final_matrix, $temp_arr);
                $temp_arr = array();
            }
        }
        if (sudoku_validation($final_matrix, $mat_dimension))
            echo "TRUE" . "<br />";
        else
            echo "FALSE" . "<br />";

    } else {
        echo "TRUE" . "<br />";
    }

}

// Creata a Temporary Array for validation
function creat_temp_arr($mat_dimension)
{
    $temp_arr = array(
        -1
    );
    for ($i = 0; $i < $mat_dimension; $i++)
        array_push($temp_arr, 0);
    return $temp_arr;
}

// Checks the input array is valid or not
function check_arr_valid($check_arr)
{
    if (in_array(0, $check_arr))
        return false;
    else
        return true;
}

//sudoku validation algoirthm

function sudoku_validation($grid, $mat_dimension)
{
    $temp_arr         = $check_arr = creat_temp_arr($mat_dimension);
    $is_valid         = true;
    $small_arr_length = sqrt($mat_dimension);

    //for rows
    if ($is_valid) {
        for ($i = 0; $i < $mat_dimension; $i++) {
            if ($is_valid) {
                $check_arr = $temp_arr;
                for ($j = 0; $j < $mat_dimension; $j++) {
                    $check_arr[$grid[$i][$j]] = $grid[$i][$j];
                }
                check_arr_valid($check_arr) ? $is_valid = true : $is_valid = false;

            }
        }
    }

    //for columns
    if ($is_valid) {
        for ($i = 0; $i < $mat_dimension; $i++) {
            if ($is_valid) {
                $check_arr = $temp_arr;
                for ($j = 0; $j < $mat_dimension; $j++) {
                    $check_arr[$grid[$j][$i]] = $grid[$j][$i];
                }
                check_arr_valid($check_arr) ? $is_valid = true : $is_valid = false;

            }
        }
    }


    //for inner matrices
    if ($is_valid) {
        for ($i = 0; $i < $mat_dimension; $i += $small_arr_length) {
            for ($j = 0; $j < $mat_dimension; $j += $small_arr_length) {
                $check_arr = $temp_arr;
                if ($is_valid) {
                    for ($k = $i; $k < ($i + $small_arr_length); $k++) {
                        for ($l = $j; $l < ($j + $small_arr_length); $l++) {
                            $check_arr[$grid[$k][$l]] = $grid[$k][$l];
                        }
                    }
                    check_arr_valid($check_arr) ? $is_valid = true : $is_valid = false;
                }
            }
        }
    }
    return $is_valid;
}
?>
