<?php
session_start();
include "db.php";
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Login </title>
        <style>
            @import url("css/style2.css");

        </style>
    </head>
    <body>
    <div class="container">
    <h1 class="welcome text-center"></h1>
        <div class="card card-container">
        <h2 class='login_title text-center'>Login</h2>
        <hr>

            <form class="form-signin" method="post">
                <span id="reauth-email" class="reauth-email"></span>
                <p class="input_title">Email</p>
                <input type="text" name="inputUsername" class="login_box" placeholder="user01@IceCode.com" required autofocus>
                <p class="input_title">Password</p>
                <input type="password" name="inputPassword" class="login_box" placeholder="******" required>
                <div id="remember" class="checkbox">
                    <label>
                        
                    </label>
                </div>
                <button class="btn btn-lg btn-primary" type="submit" name="onSubmit">Login</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
        <?php
        if(isset($_POST['onSubmit'])){
            $username = $_POST['inputUsername'];
            $password = sha1($_POST['inputPassword']);
            $record = getUserInfo($username, $password);
        if(empty($record)){
            echo "Wrong username or password";
            //header( "refresh:1.5; url=login.html" );

        }else{
            $_SESSION["adminName"] = $record['name'];
            $_SESSION["username"]  = $record['username'];
            header("Location: index.php"); //redirect to the main admin page
        }

      }

        
        
        ?>
    </div><!-- /container -->
    </body>
</html>