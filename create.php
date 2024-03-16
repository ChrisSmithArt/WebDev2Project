<?php

require('connect.php');

function checkFullFields(){
    if(empty($_POST['name'])){
        return false;
    }
    if(empty($_POST['description'])){
        return false;
    }
    if(empty($_POST['species'])){
        return false;
    }
    if(empty($_POST['organization'])){
        return false;
    }
    if(empty($_POST['occupation'])){
        return false;
    }
    return true;
}


$valid = true;
if($_POST && $_POST['command'] == 'Create'){
    if (checkFullFields()){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $SpeciesID = $_POST['species'];
        $OccupationID = $_POST['occupation'];
        $OrganizationID = $_POST['organization'];
        $query = "INSERT INTO npcs (name, description, SpeciesID, OccupationID, OrganizationID) VALUES (:name, :description, :SpeciesID, :OccupationID, :OrganizationID)";        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':SpeciesID', $SpeciesID);
        $statement->bindValue(':OccupationID', $OccupationID);
        $statement->bindValue(':OrganizationID', $OrganizationID);
        $statement->execute();
        header("Location: index.php");
        exit;
    } else {
        $valid = false;
    }
}

    $querySpecies = "SELECT * FROM species ORDER BY ID";
    $statementSpecies = $db->prepare($querySpecies);
    $statementSpecies->execute(); 

    $queryOrganization = "SELECT * FROM organizations ORDER BY ID";
    $statementOrganization = $db->prepare($queryOrganization);
    $statementOrganization->execute(); 

    $queryOccupation = "SELECT * FROM occupations ORDER BY ID";
    $statementOccupation = $db->prepare($queryOccupation);
    $statementOccupation->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Create an NPC</title>
</head>
<body>
<?php include("header.php");?>
    <main>
            <div>
                <div id="invalidated">
                    <?php if(!$valid):?>
                        You didn't enter all the information!
                    <?php endif ?>
                </div>
                <form action="create.php" method="post">
                    <fieldset>
                        <legend>New Blog Post</legend>
                        <div>
                            <label for="name">Name</label>
                            <input name="name" id="name">
                        </div>
                        <div>
                            <label for="description">Description</label>
                            <textarea name="description" id="description"></textarea>
                        </div>
                        <div>
                            <label for="species">Description</label>
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
                                <?php while($rowOccupation = $statementOccupation->fetch()):?>
                                    <option value="<?=$rowOccupation['ID']?>"><?=$rowOccupation['Name']?></option>
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
                            <input class="button" type="submit" name="command" value="Create">
                        </div>
                    </fieldset>
                </form>
            </div>
    </main>
</body>
</html>