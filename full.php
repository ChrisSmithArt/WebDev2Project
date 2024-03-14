<?php

    require('connect.php');

if(filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT)){
    $ID = filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM npcs WHERE ID = $ID";
    $statement = $db->prepare($query);
    $statement->execute(); 
    $row = $statement->fetch();

    $species = $row['SpeciesID'];

    $querySpecies = "SELECT * FROM species WHERE ID = $species";
    $statementSpecies = $db->prepare($querySpecies);
    $statementSpecies->execute(); 
    $rowSpecies = $statementSpecies->fetch();

} else {
    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Full NPC Card</title>
</head>
<body>
    <main>
        <?php include("header.php");?>     
        <div>
            <?php if($row): ?>
                <h2>Name: <?= $row['Name']?></h2>
                <div>Description: <?= $row['Description'] ?></div>
                <div>Species: <?= $rowSpecies['Name'] ?></div>
                <a href="edit.php?ID=<?=$ID?>">edit</a>
            <?php else: ?>
                <?php header("Location: index.php")?>
            <?php endif ?>
        </div>
    </main>
</body>
</html>