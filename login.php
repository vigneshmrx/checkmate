<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style><?php include 'colors.css'; ?></style>
    <style><?php include 'signup.css'; ?></style>


    <script defer>
        window.history.forward(); 
        function noBack() { 
            window.history.forward(); 
        }
        
        function callErr(errorNo) {
            switch (errorNo) {
                case 1: userNotExist();
                        break;

                case 2: pwdErr();
                        break;

                case 3: techErr();
                        break;
            }
        }

        function techErr() {
            let errorMsgArea = document.getElementsByClassName("common-error")[0];
            errorMsgArea.innerHTML = "Some error occured. Please try again later."; 
        }   

        function userNotExist() {
            let commonMsgArea = document.getElementsByClassName("common-error")[0];
            commonMsgArea.innerHTML = "User doesn't exist";
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
            let commonMsgArea = document.getElementsByClassName("common-error")[0];
            commonMsgArea.innerHTML = "Login Successful!!";

            setTimeout(() => {
                window.location.replace("index.php?id='" + userName + "'");
            }, 1400);
        }

        function checkPwdFun(thePwd, userName) {
            let enteredPwd = document.getElementsByName("pass_one")[0].value;

            if (enteredPwd == thePwd) {
                loginSuccess(userName);
            } else {
                let pwdArea = document.getElementsByClassName("pwd-error")[0];
                pwdArea.innerHTML = "Entered password is wrong";
            }
        }
    </script>
</head>
<body>
    <?php
        $username = $passone = "";
        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $passone = $_POST["pass_one"];
        }
    ?>

    <div class="container">
        <div class="left-area">
            <div class="greeting-area">
                Welcome back to <br>
                <span class="checkmate">CheckMate</span>!
            </div>
        </div>
        <div class="right-area">
            <div class="form-area">
                <form action="" method="post" onsubmit="">
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
                    
                    <div class="flex-line line">
                        <!-- <input type="submit" value="Login" name="login"> -->
                        <input type="submit" value="LOG IN" name="login" id="loginBtn">
                    </div>

                    <div class="line" style="text-align: center;">
                        Don't have an account? <a href="signup.php">Sign up</a>
                    </div>

                    <div class="line common-error">
                        <!-- common error -->
                    </div>

                    
                </form>
            </div>
        </div>
    </div>

    <?php

        if(isset($_POST["login"])) {
            include "connect.php";

            //username checking
            $username_query = "select * from user_details where username='$username'";
            $username_res = mysqli_query($con, $username_query); //result is an associative array

            try {
                $row = mysqli_fetch_assoc($username_res);
                if ($row == NULL) {
                    die("<script>callErr(1);</script>");
                } else {
                    $original_pwd = $row["password"];

                    echo "<script>checkPwdFun('$original_pwd', '$username');</script>";
                }
                
            } catch (Exception $e) {}
        }
    ?>
</body>
</html>