<?php

require('connect.php');
session_start();




$query = "SELECT * FROM users ORDER BY ID";
$statement = $db->prepare($query);
$statement->execute(); 


if(!isset($_SESSION['loggedIn']) && !isset($_SESSION['Admin'])){
    $_SESSION['loggedIn'] = false;
    $_SESSION['Admin'] = false;
    $_SESSION['justLoggedIn'] = false;
  } else {
    if(!$_SESSION['loggedIn']){
      if(!empty( $_POST['userName']) && !empty($_POST['password'])){
        while ($row = $statement->fetch()) {
          if($_POST['userName'] === $row['Name'] && $_POST['password'] === $row['Password'] ){
            if($row['ID'] === 1){
                $_SESSION['Admin'] = true;
            }
            $_SESSION['loggedIn'] = true;
            $_SESSION['justLoggedIn'] = true;
            header("location: index.php");
          }
        }
        if(!$_SESSION['loggedIn']){
            echo '<script type="text/javascript">
            window.onload = function () { alert("Login Failure."); } 
         </script>'; 
        }
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("headInfo.php");?>
    <title>Your NPC Database</title>
</head>
<body>
    <?php include("header.php");?>
    <main>
        <div>
            <form  id="loginForm" action="login.php" method="post">
                <fieldset>
                    <legend>Login Form</legend>
                    <div>
                        <label for="userName">User Name</label>
                        <input name="userName" id="userName">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input name="password" id="password">
                    </div>
                    <div id="buttonContainer">
                        <input class="button" type="submit" name="command" value="login">
                    </div>
                </fieldset>
            </form>
        </div>
        
    </main>
</body>
</html>