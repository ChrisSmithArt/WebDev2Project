<?php

    require('connect.php');
    

if(filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT)){
    $ID = filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM npcs WHERE ID = $ID";
    $statement = $db->prepare($query);
    $statement->execute(); 
    $row = $statement->fetch();

    $species = $row['SpeciesID'];
    $organization = $row['OrganizationID'];
    $occupation = $row['OccupationID'];


    $querySpecies = "SELECT * FROM species WHERE ID = $species";
    $statementSpecies = $db->prepare($querySpecies);
    $statementSpecies->execute(); 
    $rowSpecies = $statementSpecies->fetch();

    $queryOrganization = "SELECT * FROM organizations WHERE ID = $organization";
    $statementOrganization = $db->prepare($queryOrganization);
    $statementOrganization->execute(); 
    $rowOrganization = $statementOrganization->fetch();


    $queryOccupation = "SELECT * FROM occupations WHERE ID = $occupation";
    $statementOccupation = $db->prepare($queryOccupation);
    $statementOccupation->execute(); 
    $rowOccupation = $statementOccupation->fetch();




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
                <div class="portrait">
                    <img src=<?=$row['imgsrc']?> alt="CharacterPortrait">
                </div>  
                <h2>Name: <?= $row['Name']?></h2>
                <div>Description: <?= $row['Description'] ?></div>
                <div>Species: <?= $rowSpecies['Name'] ?></div>
                <div>Occupation: <?= $rowOccupation['Name'] ?></div>
                <?php if($organization): ?>
                    <div>Organization: <?= $rowOrganization['Name'] ?></div>
                <?php endif ?>
                <a href="edit.php?ID=<?=$ID?>">edit</a>
            <?php else: ?>
                <?php header("Location: index.php")?>
            <?php endif ?>
        </div>
    </main>
</body>
</html>