<?php
require('connect.php');

     $query = "SELECT * FROM NPCs ORDER BY id DESC";
     $statement = $db->prepare($query);
     $statement->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Your NPC Database</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <main>
    </main>
</body>
</html>