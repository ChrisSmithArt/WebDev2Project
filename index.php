<?php
require('connect.php');

$querySpecies = "SELECT * FROM species ORDER BY ID";
$statementSpecies = $db->prepare($querySpecies);
$statementSpecies->execute(); 

$queryOrganization = "SELECT * FROM organizations ORDER BY ID";
$statementOrganization = $db->prepare($queryOrganization);
$statementOrganization->execute(); 

$queryOccupation = "SELECT * FROM occupations ORDER BY ID";
$statementOccupation = $db->prepare($queryOccupation);
$statementOccupation->execute(); 


if($_POST && !empty($_POST['species'])){
    $query = "SELECT * FROM NPCs WHERE SpeciesID = :Species ORDER BY ID";
    $SpeciesID = $_POST['species'];
    $statement = $db->prepare($query);
    $statement->bindValue(':Species', $SpeciesID, PDO::PARAM_INT);
    $statement->execute(); 
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
        <div>
            <form  id="searchForm" action="index.php" method="post">
                <fieldset>
                    <legend>Search Criteria</legend>
                    <div>
                        <label for="species">Species</label>
                        <select name="species" id="species">
                            <option value="">Select a Species</option>
                            <?php while($rowSpecies = $statementSpecies->fetch()):?>
                                <option value="<?=$rowSpecies['ID']?>"><?=$rowSpecies['Name']?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div>
                        <label for="Occupation">Occupation</label>
                        <select name="Occupation" id="Occupation">
                            <option value="">Select an Occupation</option>
                            <?php while($rowOrganization = $statementOccupation->fetch()):?>
                                <option value="<?=$rowOrganization['ID']?>"><?=$rowOrganization['Name']?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div>
                        <label for="organization">Organization</label>
                        <select name="organization" id="organization">
                            <option value="">Select an Organization</option>
                            <?php while($rowOrganization = $statementOrganization->fetch()):?>
                                <option value="<?=$rowOrganization['ID']?>"><?=$rowOrganization['Name']?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div id="buttonContainer">
                        <input class="button" type="submit" name="command" value="Read">
                    </div>
                </fieldset>
            </form>
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