<?php

//All pages


require('connect.php');
session_start();

if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']){
    header("Location: login.php");
}




if($_POST){
    if(!empty($_POST['species'])){
        $sortValue = 'SpeciesID';
    } else if(!empty($_POST['occupation'])){
        $sortValue = 'OccupationID';
    } else if(!empty($_POST['organization'])){
        $sortValue = 'OrganizationID';
    } else if(!empty($_POST['name'])){
        $sortValue = 'Name';
    } else {
        $sortValue = 'ID';
    }
    
} else {
    $sortValue = 'ID';
}

echo $sortValue;
$query = "SELECT * FROM NPCs ORDER BY $sortValue";
$statement = $db->prepare($query);
$statement->execute(); 

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
        <div id="mainContainer">
            <div>
                <?php if($sortValue):?>
                    <h2>Sorting by: <?=$sortValue?></h2>
                <?php endif?>
                <form  id="sortForm" action="all.php" method="post">
                    <fieldset>
                        <legend>Sort Criteria</legend>
                        <div>
                            <label for="species">Species</label>
                            <input class="button" type="submit" name="species" id="species" value="Sort">
                        </div>
                        <div>
                            <label for="organization">Organization</label>
                            <input class="button" type="submit" name="organization" id="organization" value="Sort">
                        </div>
                        <div>
                            <label for="occupation">Occupation</label>
                            <input class="button" type="submit" name="occupation" id="occupation" value="Sort">
                        </div>
                        <div>
                            <label for="occupation">Name</label>
                            <input class="button" type="submit" name="name" id="name" value="Sort">
                        </div>
                    </fieldset>
                </form>
            </div>
            <div id="cardLibrary">
                <?php while($row = $statement->fetch()):?>
                    <div class="characterCard">
                        <a href="full.php?ID=<?=$row['ID']?>">    
                            <div class="portrait">
                                <?php if($row['imgsrc'] != "images/default.jpg"):  ?>
                                    <img src=<?=$row['imgsrc']?> alt="CharacterPortrait">
                                <?php else: ?>
                                    <h3>No Portrait Assigned.</h3>
                                <?php endif ?>
                            </div>  
                            <h2 class="charName"><?=$row['Name']?></h2>
                        </a>
                    </div>               
                <?php endwhile ?>
            </div>
        </div>
    </main>
</body>
</html>