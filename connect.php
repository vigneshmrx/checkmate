<?php

$con = null;

try {
    $con = mysqli_connect("localhost:3307//", "root", "");
} catch (Exception $e) {
    die("<script>callErr(3);</script>");
}

try {
    mysqli_select_db($con, "minor_project");
} catch (Exception $e2) {
    die("<script>callErr(3);</script>");
}

?>