<html>
<?php
$col_one_headings = array();
$col_two_headings = array();
$col_three_headings = array();
$heading_to_remove_array = array();

$sql_query = "select first_name, last_name from user_details where username='$user'";

$result_of_query = mysqli_query($con, $sql_query);

$row_of_result_query = mysqli_fetch_assoc($result_of_query);

$first_name_of_user = $row_of_result_query["first_name"];
$last_name_of_user = $row_of_result_query["last_name"];

$full_name_of_user = ucfirst($first_name_of_user) . " " . ucfirst($last_name_of_user);

echo '<script>populateUsersCheckmateHeading("' . $full_name_of_user . '");</script>';

echo '<script>putNameAndUsername("' . $full_name_of_user . '", "' . $user . '");</script>';

function load_the_list() {
    GLOBAL $dir;

    GLOBAL $col_one_headings;
    GLOBAL $col_two_headings;
    GLOBAL $col_three_headings;

    $left = $dir . "/col1.txt"; 
    $middle = $dir . "/col2.txt"; 
    $right = $dir . "/col3.txt";

    //creating file pointer for each file
    $fptr_left = fopen($left, "r");
    $fptr_middle = fopen($middle, "r");
    $fptr_right = fopen($right, "r");

    $left_read_heading = $middle_read_heading = $right_read_heading = 0;

    //reading left_file line by line
    while ($line = fgets($fptr_left)) {
        $line = rtrim($line, "\n");

        //inserting the headings of column 1 to an array
        if (str_contains($line, "heading: ")) {
            array_push($col_one_headings, substr($line, 9));
            $left_read_heading += 1;
            echo '<script>inputHeadingToScreen("' . substr($line, 9, strlen($line)) . '", "column-one");</script>';
        } else {
            echo '<script>inputListItemsToScreen("' . substr($line, 6, strlen($line)) . '", "column-one");</script>';
        }
    }

    echo '<script>addHr("column-one");</script>';

    //reading middle_file line by line
    while ($line = fgets($fptr_middle)) {
        $line = rtrim($line, "\n");

        //inserting the headings of column 2 to an array
        if (str_contains($line, "heading: ")) {
            array_push($col_two_headings, substr($line, 9));
            $middle_read_heading += 1;
            echo '<script>inputHeadingToScreen("' . substr($line, 9, strlen($line)) . '", "column-two");</script>';
        } else {
            echo '<script>inputListItemsToScreen("' . substr($line, 6, strlen($line)) . '", "column-two");</script>';
        }
    }

    echo '<script>addHr("column-two");</script>';
    
    while ($line = fgets($fptr_right)) {
        // echo $line;
        $line = rtrim($line, "\n");

        //inserting the headings of column 3 to an array
        if (str_contains($line, "heading: ")) {
            array_push($col_three_headings, substr($line, 9));
            $right_read_heading += 1;
            echo '<script>inputHeadingToScreen("' . substr($line, 9, strlen($line)) . '", "column-three");</script>';
        } else {
            echo '<script>inputListItemsToScreen("' . substr($line, 6, strlen($line)) . '", "column-three");</script>';
        }
    }

    echo '<script>addHr("column-three");</script>';

    fclose($fptr_left);
    fclose($fptr_middle);
    fclose($fptr_right);

    echo "<script>removeFirstHr();</script>";
}

$taskOne = $taskTwo = $optionalHeading = $radio_checked = "";

if (isset($_POST["add_tasks"])) {
    $taskOne = $_POST["taskOne"];

    try {
        $taskTwo = $_POST["taskTwo"];
    } catch (Exception $e) {}
    
    try {
        $optionalHeading = $_POST["opHeading"];
    } catch (Exception $ex) {}

    $radio_checked = $_POST["cols"];

    insert_into_file($taskOne, $taskTwo, $optionalHeading, $radio_checked);

    //after doing writing task
    $taskOne = $taskTwo = $optionalHeading = $radio_checked = "";
}

function insert_into_file($taskOne, $taskTwo, $optionalHeading, $file_name) {
    GLOBAL $dir;

    $file = $dir . "/" . $file_name . ".txt";

    $file_prt = fopen($file, "r");

    $file_content = "";
    $flag = 0;

    $optionalHeading = strtoupper($optionalHeading);

    while ($line = fgets($file_prt)) {
        if (str_contains($line, "heading: ")) {
            $line = rtrim($line, "\n");
            $heading_of_matched_line = substr($line, 9);

            if ($heading_of_matched_line == $optionalHeading) {
                $file_content = $file_content . $line . "\n";

                $file_content = $file_content . "item: " . $taskOne . "\n";

                if ($taskTwo != "") {
                    $file_content = $file_content . "item: " . $taskTwo . "\n";
                }

                $flag = 1;
            } else {
                $file_content = $file_content . $line . "\n";
            }
        } else {
            $file_content = $file_content . $line;
        }
    }

    fclose($file_prt);

    if ($flag == 0) {
        $file_ptr = fopen($file, "a");

        fwrite($file_ptr, "heading: " . $optionalHeading . "\n");

        fwrite($file_ptr, "item: " . $taskOne . "\n");

        if ($taskTwo != "") {
            fwrite($file_ptr, "item: " . $taskTwo . "\n");
        }

        fclose($file_ptr);
    } else {
        $file_ptr = fopen($file, "w");

        fwrite($file_ptr, $file_content);

        fclose($file_ptr);
    }
}

?>
</html>