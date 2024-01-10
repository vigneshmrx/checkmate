<?php
$directoryName = "users/test";

if (!file_exists($directoryName)) {
    if (mkdir($directoryName, 0777, true)) {
        echo "Directory '$directoryName' created successfully";
    } else {
        echo "Error: Unable to create directory";
    }
} else {
    echo "Directory already exits";
}

?>