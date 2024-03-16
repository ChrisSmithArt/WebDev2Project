<?php
    require('connect.php');

    $valid = true;
    $npc = false;
    $ID = filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT);
    if(filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT)){
        if($_POST){
            if ($_POST['command'] == 'Update') {
                if(!empty($_POST['Name']) && !empty($_POST['Description'])){
                    $Name  = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $Description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
                    $SpeciesID = $_POST['species'];
                    $OccupationID = $_POST['occupation'];
                    $OrganizationID = $_POST['organization'];
                    $query = "UPDATE npcs SET Name = :Name, Description = :Description, SpeciesID = :SpeciesID, OccupationID = :OccupationID, OrganizationID = :OrganizationID  WHERE ID = :ID";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':Name', $Name);        
                    $statement->bindValue(':Description', $Description);
                    $statement->bindValue(':SpeciesID', $SpeciesID);
                    $statement->bindValue(':OccupationID', $OccupationID);
                    $statement->bindValue(':OrganizationID', $OrganizationID);
                    $statement->bindValue(':ID', $ID, PDO::PARAM_INT);
                    $statement->execute();
                    header("Location: index.php");
                } else if (empty($_POST['Name']) && empty($_POST['Description'])){
                    $valid = false;
                }
            }else if ($_POST['command'] == 'Delete'){
                $ID = filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT);
                $query = "DELETE FROM npcs WHERE ID = :ID";
                $statement = $db->prepare($query);
                $statement->bindValue(':ID', $ID, PDO::PARAM_INT);
                $statement->execute();
                header("Location: index.php");
            }
        } else if (isset($_GET['ID'])) { 
            $query = "SELECT * FROM npcs WHERE ID = :ID";
            $statement = $db->prepare($query);
            $statement->bindValue(':ID', $ID, PDO::PARAM_INT);
            $statement->execute();
            $npc = $statement->fetch();
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
    <title>Edit this NPC</title>
</head>
<body>
    <?php include("header.php");?>
        <div>
            <?php if ($npc): ?>
                <form method="post">
                    <fieldset>
                        <legend>Edit NPC</legend>
                        <div>
                            <label for="Name">Name</label>
                            <input type="text" name="Name" id="Name" value="<?=$npc['Name']?>">
                        </div>
                        <div>
                            <label for="Description">Description</label>
                            <textarea name="Description" id="Description"><?= $npc['Description'] ?></textarea>
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
                        <div>
                            <input type="hidden" name="ID" value="<?=$ID?>">
                            <input class="button" type="submit" name="command" value="Update">
                            <input class="button" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this NPC?')">
                        </div> 
                    </fieldset>
                </form>
            <?php else: ?>
                <div>
                    <?php if(!$valid):?>
                        Invalid: You cannot update an NPC to be empty!
                    <?php else: ?>
                        <?php header("Location: index.php")?>
                    <?php endif ?>
                </div>
                <?php endif ?>
        </div>
</body>
</html>