<?php
require('connect.php');
session_start();

$querySpecies = "SELECT * FROM species ORDER BY ID";
$statementSpecies = $db->prepare($querySpecies);
$statementSpecies->execute(); 

$queryOrganization = "SELECT * FROM organizations ORDER BY ID";
$statementOrganization = $db->prepare($queryOrganization);
$statementOrganization->execute(); 

$queryOccupation = "SELECT * FROM occupations ORDER BY ID";
$statementOccupation = $db->prepare($queryOccupation);
$statementOccupation->execute(); 


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




function checkPost(){
    if(!empty($_POST['species'])){
        return true;
    }
    if(!empty($_POST['occupation'])){
        return true;
    }
    if(!empty($_POST['organization'])){
        return true;
    }
    if(!empty($_POST['name'])){
        return true;
    }
    return false;
    
}

function whereClause(){
    $stringWhere = "";
    $countWhere = 0;

    if(!empty($_POST['species'])){
        $stringWhere = $stringWhere."SpeciesID = :Species";
        $countWhere ++;
    }
    if(!empty($_POST['organization'])){
        if($countWhere > 0){
            $stringWhere = $stringWhere." AND ";
        }
        $stringWhere = $stringWhere."OrganizationID = :Organization";
        $countWhere ++;
    }
    if(!empty($_POST['occupation'])){
        if($countWhere > 0){
            $stringWhere = $stringWhere." AND ";
        }
        $stringWhere = $stringWhere."OccupationID = :Occupation";
        $countWhere ++;
    }
    if(!empty($_POST['name'])){
        if($countWhere > 0){
            $stringWhere = $stringWhere." AND ";
        }
        $stringWhere = $stringWhere."Name LIKE :Name";
        $countWhere ++;
    }
    return $stringWhere;
}


if($_POST && checkPost()){
    $whereC = whereClause();
    $query = "SELECT * FROM NPCs WHERE $whereC ORDER BY ID";
    
    //echo $whereC;

    if(!empty($_POST['species'])){
        $SpeciesID = $_POST['species'];
    }
    if(!empty($_POST['organization'])){
        $OrganizationID = $_POST['organization'];
    }
    if(!empty($_POST['occupation'])){
        $OccupationID = $_POST['occupation'];
    }
    if(!empty($_POST['name'])){
        $npcName = $_POST['name']."%";
    }

    $statement = $db->prepare($query);

    if(!empty($_POST['species'])){
        $statement->bindValue(':Species', $SpeciesID, PDO::PARAM_INT);
    }
    if(!empty($_POST['organization'])){
        $statement->bindValue(':Organization', $OrganizationID, PDO::PARAM_INT);
    }
    if(!empty($_POST['occupation'])){
        $statement->bindValue(':Occupation', $OccupationID, PDO::PARAM_INT);
    }
    if(!empty($_POST['name'])){
        $statement->bindValue(':Name', $npcName);
    }

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
    <?php include("headInfo.php");?>
    <title>Your NPC Database</title>
</head>
<body>
    <?php include("header.php");?>
    <main>
        <div id="mainContainer">
            <div>
                <form  id="searchForm" action="index.php" method="post">
                    <fieldset>
                        <legend>Search Criteria</legend>
                        <div>
                            <label for="name">Name</label>
                            <input name="name" id="name">
                        </div>
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
                            <label for="occupation">Occupation</label>
                            <select name="occupation" id="occupation">
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