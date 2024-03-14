<?php
require('connect.php');

//AREAS
     $areaQuery = "SELECT * FROM areas ORDER BY ID";
     $areaStatement = $db->prepare($areaQuery);
     $areaStatement->execute(); 

    $areaValid = true;

    if($_POST){
        if ($_POST['command'] == 'Update') {
            // echo "<h2>Name: " . $_POST['AreaName']. "</h2>";
            // echo "<h2>Description: " . $_POST['AreaDescription']. "</h2>";
            // echo "<h2>ID: " . $_POST['AreaID']. "</h2>";
            // echo empty($_POST['AreaName']);
            // echo empty($_POST['AreaDescription']);
                if(!empty($_POST['AreaName']) && !empty($_POST['AreaDescription'])){
                    $areaName  = filter_input(INPUT_POST, 'AreaName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $areaDescription = filter_input(INPUT_POST, 'AreaDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $areaID = filter_input(INPUT_POST, 'AreaID', FILTER_SANITIZE_NUMBER_INT);
                    $areaQuery = "UPDATE areas SET Name = :Name, Description = :Description WHERE ID = :ID";
                    $areaStatement = $db->prepare($areaQuery);
                    $areaStatement->bindValue(':Name', $areaName);        
                    $areaStatement->bindValue(':Description', $areaDescription);
                    $areaStatement->bindValue(':ID', $areaID, PDO::PARAM_INT);
                    $areaStatement->execute();
                    header("Location: Admin.php");
                } else if (empty($_POST['AreaName']) && empty($_POST['AreaDescription'])){
                    $areaValid = false;
                }
            }else if ($_POST['command'] == 'Delete'){
                // echo "<h2>ID: " . $_POST['AreaID']. "</h2>";
                $areaID = filter_input(INPUT_POST, 'AreaID', FILTER_SANITIZE_NUMBER_INT);
                $areaQuery = "DELETE FROM areas WHERE ID = :ID";
                $areaStatement = $db->prepare($areaQuery);
                $areaStatement->bindValue(':ID', $areaID, PDO::PARAM_INT);
                $areaStatement->execute();
                header("Location: Admin.php");
        }
    }
    $validArea = true;
    if ($_POST && !empty($_POST['NewAreaName']) && !empty($_POST['NewAreaDescription']) && $_POST['command'] == 'Create') {
        $nameArea = filter_input(INPUT_POST, 'NewAreaName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descriptionArea = filter_input(INPUT_POST, 'NewAreaDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $queryArea = "INSERT INTO areas (Name, Description) VALUES (:Name, :Description)";        
        $statementArea = $db->prepare($queryArea);
        $statementArea->bindValue(':Name', $nameArea);
        $statementArea->bindValue(':Description', $descriptionArea);
        $statementArea->execute();
        header("Location: Admin.php");
        exit;
    } else if($_POST && empty($_POST['NewAreaName']) && empty($_POST['NewAreaDescription']) && $_POST['command'] == 'Create') {
        $validArea = false;
    }

//SPECIES


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
        <div id="categoryLibrary">
            <div id="areaAdd">
                <div id="invalidated">
                    <?php if(!$validArea):?>
                        You didn't enter any information!
                    <?php endif ?>
                </div>
                <form action="Admin.php" method="post">
                    <fieldset>
                        <legend>New Area</legend>
                        <div>
                            <label for="NewAreaName">Name</label>
                            <input name="NewAreaName" id="NewAreaName">
                        </div>
                        <div>
                            <label for="NewAreaDescription">Description</label>
                            <textarea name="NewAreaDescription" id="NewAreaDescription"></textarea>
                        </div>
                        <div id="buttonContainer">
                            <input class="button" type="submit" name="command" value="Create">
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="areaEdit">
                <div>
                    <?php if(!$areaValid):?>
                            You didn't change any information!
                        <?php endif ?>
                    <?php if(!$areaStatement):?>
                        No query!
                    <?php endif ?>
                </div>
                <?php while($areaRow = $areaStatement->fetch()):?>
                    <form method="post">
                        <fieldset>
                            <legend>Edit Area</legend>
                            <div>
                                <label for="AreaName">Name</label>
                                <input type="text" name="AreaName" id="AreaName" value="<?=$areaRow['Name']?>">
                            </div>
                            <div>
                                <label for="AreaDescription">Description</label>
                                <textarea name="AreaDescription" id="AreaDescription"><?= $areaRow['Description'] ?></textarea>
                            </div>
                            <div>
                                <h3>Area ID: <?=$areaRow['ID']?></h3>
                                <input type="hidden" name="AreaID" if="AreaID" value="<?=$areaRow['ID']?>">
                                <input class="button" type="submit" name="command" value="Update">
                                <input class="button" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this Area?')">
                            </div> 
                        </fieldset>
                    </form>          
                <?php endwhile ?>
            </div>
        </div>
    </main>
</body>
</html>