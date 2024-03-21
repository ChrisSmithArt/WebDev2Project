<?php
//main page
session_start();

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] && $_SESSION['justLoggedIn']){
    echo '<script type="text/javascript">
       window.onload = function () { alert("You logged in."); } 
    </script>'; 
    $_SESSION['justLoggedIn'] = false;
}

if(!isset($_SESSION['justLoggedOut'])){
    $_SESSION['justLoggedOut'] = false;
}

if($_SESSION['justLoggedOut'] && isset($_SESSION['justLoggedOut'])){
    echo '<script type="text/javascript">
    window.onload = function () { alert("You logged out."); } 
 </script>'; 
 $_SESSION['justLoggedOut'] = false;
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
        <h1>This is the main page</h1>
        <h2>welcome</h2>
        <div>
            This is an NPC database for Non-player Characters that would be used in a TTRPG.
        </div>
    </main>
</body>
</html>