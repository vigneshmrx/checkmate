<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- <link rel="stylesheet" href="signup.css"> -->
    <style><?php include 'colors.css'; ?></style>
    <style><?php include 'signup.css'; ?></style>
    <script defer>
        function callErr(errorNo) {
            console.log("Call error has been called with " + errorNo);
            switch (errorNo) {
                case 1: usernameErr();
                        break;

                case 2: pwdErr();
                        break;

                case 3: techErr();
                        break;

                case 4: usernameMistake();
            }
        }

        function techErr() {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Some error occured. Please try again later"; 
        }   

        function usernameErr() {
            let usrnamArea = document.getElementsByClassName("username-error")[0];
            usrnamArea.innerHTML = "Username already taken";
        }

        function usernameMistake() {
            let usrnamArea = document.getElementsByClassName("username-error")[0];
            usrnamArea.innerHTML = "Use only letters and underscores for username";
        }

        function pwdErr() {
            let pwdArea = document.getElementsByClassName("repeat-pwd-error")[0];
            pwdArea.innerHTML = "The two passwords do not match";
        }

        function loginSuccess(userName) {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Registration Successful";
            
            setTimeout(() => {
                window.location.replace("index.php?id='" + userName + "'");
            }, 1500);
        }
    </script>
</head>
<body>
    <?php
        $fname = $lname = $username = $passone = $passtwo = "";

        if (isset($_POST["sign_up"])) {
            $fname = $_POST["f_name"]; 
            $lname = $_POST["l_name"];
            $username = $_POST["username"];
            $passone = $_POST["pass_one"];
            $passtwo = $_POST["pass_two"];
        }
        // $lname = $username = $passone = $passtwo = "";
    ?>

    <div class="container">
        <div class="left-area">
            <div class="greeting-area">
                Welcome to 
                <span class="checkmate">CheckMate</span>.<br>
                Your ultimate productivity assistant.
            </div>
        </div>
        <div class="right-area">
            <div class="form-area">
                <form action="" method="post" onsubmit="">
                    <div class="flex-line line" style="display: flex;">
                        <div class="fname">
                            FIRST NAME: <br>
                            <input type="text" name="f_name" id="" value = "<?php echo $fname; ?>" required>
                        </div>
                        <div class="lname">
                            LAST NAME: <br>
                            <input type="text" name="l_name" id=""  value = "<?php echo $lname; ?>" required>
                        </div>
                    </div>

                    <div class="line">
                        USERNAME: <br>
                        <input type="text" name="username" value = "<?php echo $username; ?>" required>
                    </div>

                    <div class="line username-error">
                        <!-- User-name-error -->
                    </div>

                    <div class="line">
                        PASSWORD: <br>
                        <input type="password" name="pass_one" value = "<?php echo $passone; ?>"  required>
                    </div>

                    <div class="line pwd-error">
                        <!-- Pwd error -->
                    </div>

                    <div class="line">
                        REPEAT PASSWORD: <br>
                        <input type="password" name="pass_two" value = "<?php echo $passtwo; ?>" required>
                    </div>

                    <div class="line repeat-pwd-error">
                        <!-- Password doesn't match -->
                    </div>
                    
                    <div class="flex-line line">
                        <!-- <input type="submit" value="Login" name="login"> -->
                        <input type="submit" value="SIGN UP" name="sign_up" id="signupBtn">
                    </div>

                    <div class="line" style="text-align: center;">
                        Already have an account? <a href="login.php">Login</a>
                    </div>

                    <div class="line common-error">
                        <!-- common error -->
                    </div>

                    
                </form>
            </div>
        </div>
    </div>

    <?php

        if(isset($_POST["sign_up"])) {
            include "connect.php";

            //usernmae mistake checking
            $contains_dollar = str_contains($username, "$");
            $contains_hiphen = str_contains($username, "-");
            $contains_dot = str_contains($username, ".");

            if ($contains_dollar || $contains_dot || $contains_hiphen) {
                echo "<script>console.log('It has reached here');</script>";
                die("<script>callErr(4);</script>");
            }


            //username checking
            $username_query = "select * from user_details where username='$username'";
            $username_res = mysqli_query($con, $username_query); //result is an associative array
            
            try {
                $row = mysqli_fetch_assoc($username_res);
                if ($row != NULL) {
                    if ($row["username"] != NULL) {
                        die("<script>callErr(1);</script>");
                    }
                }
                
            } catch (Exception $e) {}


            //password checking
            if ($passone != $passtwo) {
                die("<script>callErr(2);</script>");
            }


            //creating account for the user
            $adding_user_query = "insert into user_details values('$fname', '$lname', '$username', '$passone')";
            $adding_user_success = mysqli_query($con, $adding_user_query);

            if ($adding_user_success) {
                die("<script>loginSuccess('$username');</script>");
            } else {
                echo "<script>callErr(3)</script>";
            }
        }
    ?>
</body>
</html>