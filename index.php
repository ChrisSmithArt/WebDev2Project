<?php
require('connect.php');

if($_POST){
    
} else {
    
     $query = "SELECT * FROM NPCs ORDER BY ID";
     $statement = $db->prepare($query);
     $statement->execute(); 
}
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
    <?php include("header.php");?>
    <main>
        <div id="searchForm">

        </div>
        <div id="cardLibrary">
            <?php while($row = $statement->fetch()):?>
                <div class="characterCard">  
                    <h2>Name: <?=$row['Name']?></h2>
                    <a href="full.php?ID=<?=$row['ID']?>">Show Full Info</a> 
                </div>               
            <?php endwhile ?>
        </div>
    </main>
</body>
</html>