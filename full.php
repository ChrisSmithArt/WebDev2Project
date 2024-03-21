<?php
    require('connect.php');
    session_start();


if(filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT)){
    $ID = filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT `npcs`.*, `organizations`.*, `occupations`.*, `species`.* FROM `npcs` 
	LEFT JOIN `organizations` ON `npcs`.`OrganizationID` = `organizations`.`organizationID` 
	LEFT JOIN `occupations` ON `npcs`.`OccupationID` = `occupations`.`occupationID` 
	LEFT JOIN `species` ON `npcs`.`SpeciesID` = `species`.`speciesID`;
    WHERE n.npcID = $ID";
     $statement = $db->prepare($query);
     $statement->execute();  
    $row = $statement->fetch();

    // $species = $row['SpeciesID'];
    // $organization = $row['OrganizationID'];
    // $occupation = $row['OccupationID'];


    // $querySpecies = "SELECT * FROM species WHERE speciesID = $species";
    // $statementSpecies = $db->prepare($querySpecies);
    // $statementSpecies->execute(); 
    // $rowSpecies = $statementSpecies->fetch();

    // $queryOrganization = "SELECT * FROM organizations WHERE organizationID = $organization";
    // $statementOrganization = $db->prepare($queryOrganization);
    // $statementOrganization->execute(); 
    // $rowOrganization = $statementOrganization->fetch();


    // $queryOccupation = "SELECT * FROM occupations WHERE occupationID = $occupation";
    // $statementOccupation = $db->prepare($queryOccupation);
    // $statementOccupation->execute(); 
    // $rowOccupation = $statementOccupation->fetch();




} else {
    header("Location: content.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("headInfo.php");?>
    <title>Full NPC Card</title>
</head>
<body>
    <main>
        <?php include("header.php");?>     
        <div>
            <?php if($row): ?>
                <div class="characterCard">
                    <div class="portrait">
                        <?php if($row['imgsrc'] != "images/default.jpg"):  ?>
                            <img src=<?=$row['imgsrc']?> alt="CharacterPortrait">
                        <?php else: ?>
                            <h3>No Portrait Assigned.</h3>
                        <?php endif ?>
                    </div> 
                    <div class="charInfo"> 
                        <h2 class="charName"><?=$row['Name']?></h2>
                            
                            <div><?=$row['Name']?>, <?= $row['Description']?> is a/an <?= $row['SpeciesName'] ?> <?= $row['OccupationName'] ?> who is <?=($row['OrganizationName']!="Independent") ? "associated with " : ""; ?> <?= $row['OrganizationName']?>. Name is currently living in [Location].</div>
                            <?php if(isset($_SESSION['Admin'])): ?>
                        <a href="edit.php?ID=<?=$ID?>">Edit</a>
                    <?php endif ?>
                        </div>
                </div>       
            <?php else: ?>
                <?php header("Location: content.php")?>
            <?php endif ?>
        </div>
    </main>
</body>
</html>