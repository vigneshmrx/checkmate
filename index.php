<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style><?php include 'colors.css'; ?></style>
    <style><?php include 'styles.css'; ?></style>
    <script defer>
        window.history.forward(); 
        function noBack() { 
            window.history.forward(); 
        }

        const putNameAndUsername = (theName, theUsername) => {
            let nameBoxField = document.getElementById("name_of_user");
            let usernameBoxField = document.getElementById("username_of_user");

            nameBoxField.value = theName;
            usernameBoxField.value = theUsername;
        }

        //function to input heading to screen
        const inputHeadingToScreen = (theHeading, idOfColumn) => {
            let columnId = document.getElementById(idOfColumn);

            if (columnId.innerHTML != "") {
                columnId.innerHTML += "<hr>";
            }

            columnId.innerHTML += `<div class='heading-grp'><h4 class='to-do-list-heading'>` + theHeading + `</h4><div class='cross-div' id='` + idOfColumn.substring(7) + `'onclick='removeThisListGrp(this);'><span class='cross-bar-one'></span><span class='cross-bar-two'></span></div></div>`;
            columnId.innerHTML += "<span class='heading-underline'></span>";
        }

        const addHr = (idOfColumn) => {
            let columnId = document.getElementById(idOfColumn);

            columnId.innerHTML += "<hr>";
        }

        //function to input list items to the screen
        const inputListItemsToScreen = (theItem, idOfColumn) => {
            let columnId = document.getElementById(idOfColumn);

            columnId.innerHTML += "<input type='checkbox' onclick='strikeText(this);'><span>" + theItem + "</span><br>";
        }

        const strikeText = (currentObj) => {
            let curChBx = currentObj;
            let textOfNextSibling = curChBx.nextSibling.innerHTML;

            if (curChBx.checked) {
                curChBx.nextSibling.innerHTML = "<s>" + textOfNextSibling + "</s>";
            } else {
                curChBx.nextSibling.innerHTML = textOfNextSibling.slice(3, -4);
            }
        }

        const removeFirstHr = () => {
            let colOne = document.getElementById("column-one").firstElementChild;
            let colTwo = document.getElementById("column-two").firstElementChild;
            let colThree = document.getElementById("column-three").firstElementChild;

            if (colOne.tagName == "HR") {
                colOne.remove();
            }

            if (colTwo.tagName == "HR") {
                colTwo.remove();
            }

            if (colThree.tagName == "HR") {
                colThree.remove();
            }
        }

        const populateUsersCheckmateHeading = (userFullName) => {
            let usersCheckmateHeadingArea = document.getElementById("users-checkmate-heading");

            usersCheckmateHeadingArea.innerHTML = "<div>" + userFullName + "'s To Do List</div>"; //<span class='checkmate'>CheckMate</span>
        }

        const showPwdMismatchErr = () => {
            let pwdErrorFieldInProfile = document.getElementById("pwd-change-error-in-profile");
            
            pwdErrorFieldInProfile.innerHTML = "The two passwords do not match!";
        }

        const showPwdChangeBox = () => {
            let changePwdPage = document.getElementById("change-pwd-page");
            let profileDiv = document.getElementById("profile-page");
            let logoutBackPage = document.getElementById("logout-background-page");

            changePwdPage.style.visibility = logoutBackPage.style.visibility = "visible";
            changePwdPage.style.zIndex = 1500;
            logoutBackPage.style.zIndex = 1000;

            profileDiv.style.visibility = "hidden";
        }

        const showProfileBox = () => {
            let changePwdPage = document.getElementById("change-pwd-page");
            let profileDiv = document.getElementById("profile-page");

            changePwdPage.style.visibility = "hidden";
            changePwdPage.style.zIndex = -600;

            profileDiv.style.visibility = "visible";
        }

        const showProfile = () => {
            let profileDiv = document.getElementById("profile-page");
            let logoutBackPage = document.getElementById("logout-background-page");

            profileDiv.style.visibility = logoutBackPage.style.visibility = "visible";
            logoutBackPage.style.zIndex = 1000;
            profileDiv.style.zIndex = 1500
        }

        const showMainArea = () => {
            let profileDiv = document.getElementById("profile-page");
            let logoutBackPage = document.getElementById("logout-background-page");

            profileDiv.style.zIndex = -500;
            logoutBackPage.style.zIndex = -700;

            profileDiv.style.visibility = logoutBackPage.style.visibility = "hidden";
        }
    </script>
</head>

<body>
    <div id="logout-background-page"></div>
    <div id="logout-page">
        <div id="logout-box">
            <p>Log out from Checkmate?</p> <br>
            <div class="flex-line">
                <input type="button" value="LOGOUT" onclick="logOutConfirmation(true);">
                <input type="button" value="CANCEL" onclick="logOutConfirmation(false);">
            </div>
        </div>
    </div>

    <?php
    include_once("connect.php");

    $the_password = $the_repeat_password = "";

    if (isset($_POST["change-pwd-btn"])) {
        $the_password = $_POST["change-password-field"];
        $the_repeat_password = $_POST["change-password-repeat-field"];
    }

    ?>

    <div id="profile-page">
        <div id="profile-box">

            <div id="close-profile-box" onclick="showMainArea();">
                <span id="profile-box-bar-one"></span>
                <span id="profile-box-bar-two"></span>
            </div>

            <p id="profile-heading">PROFILE</p>
            <p>Name:</p>
            <input type="text" id="name_of_user" disabled><br><br>
            <p>Username:</p>
            <input type="text" id="username_of_user" disabled><br><br>

            <div class="extra-options" onclick="showPwdChangeBox();">
                <P>CHANGE PASSWORD</P>
            </div>
        </div>
    </div>

    <div id="change-pwd-page">
        <div id="change-pwd-area">

            <div id="close-ch-pwd-box" onclick="showProfileBox();">
                <span id="ch-pwd-box-bar-one"></span>
                <span id="ch-pwd-box-bar-two"></span>
            </div>

            <p id="cg-pwd-heading" style="width: 80%;">CHANGE PASSWORD</p>
            <form action="" method="post">
                <p>New Password:</p>
                <input type="password" name="change-password-field" value="<?php echo $the_password; ?>" required><br><br>
                <p>Repeat New Password:</p>
                <input type="password" name="change-password-repeat-field" value="<?php echo $the_repeat_password; ?>" required>
                
                <div class="change-pwd-btn-div" style="width: 70%; margin: 20px auto;">
                    <input type="submit" value="UPDATE" name="change-pwd-btn" style="width: 100%; cursor: pointer;">
                </div>

                <div id="pwd-change-error-in-profile"></div>
            </form>
        </div>
    </div>

    <?php 
    ?>

    <section id="main-content-area">
        <div id="left-area">
            <div id="users-checkmate-heading"></div>
            <div id="left-content-area">
            <div id="column-one">
                <!-- Nothing added yet -->
            </div>
            <div id="column-two">
                <!-- Nothing added yet -->
            </div>
            <div id="column-three">
                <!-- Nothing added yet -->
            </div>
            </div>
        </div>
        <div id="right-area">
            <div id="add-task-heading">
                ADD TASK
            </div>
            <?php
            // include_once("connect.php");

            $user = $_REQUEST["id"];
            $user = trim($user, "'");
            $dir = "users/" . $user;

            if (isset($_POST["change-pwd-btn"])) {
                 if ($the_password != $the_repeat_password) {
                    echo "<script>showPwdChangeBox();</script>";
                    echo "<script>showPwdMismatchErr();</script>";
                } else {
                    $change_pwd_operation = mysqli_query($con, "update user_details set password='$the_password' where username='$user'");
                    echo "<script>showProfile();</script>";
                    echo "<script>alert('Password Changed Successfully');</script>";
                }
            }

            include_once("insert_into_file.php");

            //creating a folder for the user if it doesn't exits
            if (!file_exists("users/" . $user)) {
                mkdir($dir);
                file_put_contents($dir . "/col1.txt", "");
                file_put_contents($dir . "/col2.txt", "");
                file_put_contents($dir . "/col3.txt", "");
                load_the_list();
            } else {
                load_the_list();
            }

            ?>
            <div id="adding-list">
                <form action="" method="post" id="right-side-form">
                    Heading ~ <br>
                    <input type="text" name="opHeading" id="heading" placeholder="Ex: Business" value="<?php echo $optionalHeading; ?>" required> <br><br>
                    Task ~ <br>
                    <input type="text" name="taskOne" id="taskOne" placeholder="Ex: Team meeting at 20:00" style="margin-bottom: 15px;" value="<?php echo $taskOne; ?>" required> <br>

                    <input type="text" name="taskTwo" id="taskTwo" placeholder="Ex: Meet boss for dinner" value="<?php echo $taskTwo; ?>">
                    <!-- <input type="button" value="Add Task" onclick="addItem();" id="task1" style="margin-top: 10px;"> -->
                    <br><br>

                    Add To Column ~ <br>

                    <div class="radio-btn-grp">
                    <label for="col1">
                        <input type="radio" name="cols" id="col1" value="col1"> Left
                    </label>

                    <label for="col2">
                        <input type="radio" name="cols" id="col2" value="col2" checked> Middle
                    </label>

                    <label for="col3">
                        <input type="radio" name="cols" id="col3" value="col3"> Right
                    </label> 
                    </div>

                    <br>

                    <input type="submit" value="ADD" name="add_tasks" id="add-task-submit-btn" > <!-- onclick="addItem();" -->
                </form>
            </div>
        </div>
    </section>

    <div id="nav-section">
        <div style="margin-right: 50px;"><p onclick="showProfile();">PROFILE</p></div>
        <div><span class='checkmate'>CheckMate</span></div>
        <div style="margin-left: 50px;"><p onclick="logOutPopUpBox();">LOGOUT</p></div>
    </div>

    <script>

        let logoutPage = document.getElementById("logout-page");
        let logoutBackPage = document.getElementById("logout-background-page");

        //checking for logout confirmation and doing things accordingly
        const logOutConfirmation = (boolVal) => {
            if (boolVal) {
                window.location.replace("login.php");
            } else {
                logoutPage.style.visibility = logoutBackPage.style.visibility = "hidden";
                logoutPage.style.zIndex = -1000;
                logoutBackPage.style.zIndex = -500;
            }
        }

        //showing logout confirmation box
        const logOutPopUpBox = () => {
            logoutPage.style.visibility = logoutBackPage.style.visibility = "visible";
            logoutPage.style.zIndex = 1000;
            logoutBackPage.style.zIndex = 500;
        }

        function checkingInArray(theHeading, columnId) {

            let count = 0;

            console.log(theArrayOfH4);

            for (let i = 0; i < theArrayOfH4.length; i++) {
                if (theArrayOfH4[i].innerHTML == theHeading && theArrayOfH4[i].nextElementSibling.id == columnId) {
                    return i;
                } 
                count++;
            }

            // return count;
        }

        //this function is for removing a list group (heading + items under it) from the screen
        const removeThisListGrp = (curElementReference) => {
            let theHeading = curElementReference.previousElementSibling.innerHTML;

            let theMainEle = curElementReference.parentElement;

            if (theMainEle.previousElementSibling != null && theMainEle.previousElementSibling.tagName == "HR") {
                
                if (theMainEle.previousElementSibling.previousElementSibling == null) {
                    theMainEle.previousElementSibling.remove();
                }

            }

            while (true) {
                let prevEle = theMainEle;
                
                try {
                    theMainEle = theMainEle.nextElementSibling;
                } catch (err) {
                    console.log("Exception encountered");
                }

                prevEle.remove();

                if (theMainEle == null || theMainEle.tagName == "DIV") {
                    break;
                }
            }

            let currentElementId = curElementReference.id;

            theArrayOfH4 = Array.from(document.getElementsByClassName("to-do-list-heading"));
        }
    </script>
</body>
</html>