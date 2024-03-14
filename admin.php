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
$speciesQuery = "SELECT * FROM species ORDER BY ID";
$speciesStatement = $db->prepare($speciesQuery);
$speciesStatement->execute(); 

$speciesValid = true;

if($_POST){
    if ($_POST['command'] == 'Update') {
        // echo "<h2>Name: " . $_POST['SpeciesName']. "</h2>";
        // echo "<h2>Description: " . $_POST['SpeciesDescription']. "</h2>";
        // echo "<h2>ID: " . $_POST['SpeciesID']. "</h2>";
        // echo empty($_POST['SpeciesName']);
        // echo empty($_POST['SpeciesDescription']);
            if(!empty($_POST['SpeciesName']) && !empty($_POST['SpeciesDescription'])){
                $speciesName  = filter_input(INPUT_POST, 'SpeciesName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $speciesDescription = filter_input(INPUT_POST, 'SpeciesDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $speciesID = filter_input(INPUT_POST, 'SpeciesID', FILTER_SANITIZE_NUMBER_INT);
                $speciesQuery = "UPDATE species SET Name = :Name, Description = :Description WHERE ID = :ID";
                $speciesStatement = $db->prepare($speciesQuery);
                $speciesStatement->bindValue(':Name', $speciesName);        
                $speciesStatement->bindValue(':Description', $speciesDescription);
                $speciesStatement->bindValue(':ID', $speciesID, PDO::PARAM_INT);
                $speciesStatement->execute();
                header("Location: Admin.php");
            } else if (empty($_POST['SpeciesName']) && empty($_POST['SpeciesDescription'])){
                $speciesValid = false;
            }
        }else if ($_POST['command'] == 'Delete'){
            // echo "<h2>ID: " . $_POST['SpeciesID']. "</h2>";
            $speciesID = filter_input(INPUT_POST, 'SpeciesID', FILTER_SANITIZE_NUMBER_INT);
            $speciesQuery = "DELETE FROM species WHERE ID = :ID";
            $speciesStatement = $db->prepare($speciesQuery);
            $speciesStatement->bindValue(':ID', $speciesID, PDO::PARAM_INT);
            $speciesStatement->execute();
            header("Location: Admin.php");
    }
}
$validSpecies = true;
if ($_POST && !empty($_POST['NewSpeciesName']) && !empty($_POST['NewSpeciesDescription']) && $_POST['command'] == 'Create') {
    $nameSpecies = filter_input(INPUT_POST, 'NewSpeciesName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descriptionSpecies = filter_input(INPUT_POST, 'NewSpeciesDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $querySpecies = "INSERT INTO species (Name, Description) VALUES (:Name, :Description)";        
    $statementSpecies = $db->prepare($querySpecies);
    $statementSpecies->bindValue(':Name', $nameSpecies);
    $statementSpecies->bindValue(':Description', $descriptionSpecies);
    $statementSpecies->execute();
    header("Location: Admin.php");
    exit;
} else if($_POST && empty($_POST['NewSpeciesName']) && empty($_POST['NewSpeciesDescription']) && $_POST['command'] == 'Create') {
    $validSpecies = false;
}

//ORGANIZATIONS
$organizationQuery = "SELECT * FROM organizations ORDER BY ID";
$organizationStatement = $db->prepare($organizationQuery);
$organizationStatement->execute();


$organizationValid = true;


if($_POST){
    if ($_POST['command'] == 'Update') {
        // echo "<h2>Name: " . $_POST['OrganizationName']. "</h2>";
        // echo "<h2>Description: " . $_POST['OrganizationDescription']. "</h2>";
        // echo "<h2>ID: " . $_POST['OrganizationID']. "</h2>";
        // echo empty($_POST['OrganizationName']);
        // echo empty($_POST['OrganizationDescription']);
            if(!empty($_POST['OrganizationName']) && !empty($_POST['OrganizationDescription'])){
                $organizationName  = filter_input(INPUT_POST, 'OrganizationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $organizationDescription = filter_input(INPUT_POST, 'OrganizationDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $organizationID = filter_input(INPUT_POST, 'OrganizationID', FILTER_SANITIZE_NUMBER_INT);
                $organizationQuery = "UPDATE organizations SET Name = :Name, Description = :Description WHERE ID = :ID";
                $organizationStatement = $db->prepare($organizationQuery);
                $organizationStatement->bindValue(':Name', $organizationName);        
                $organizationStatement->bindValue(':Description', $organizationDescription);
                $organizationStatement->bindValue(':ID', $organizationID, PDO::PARAM_INT);
                $organizationStatement->execute();
                header("Location: Admin.php");
            } else if (empty($_POST['OrganizationName']) && empty($_POST['OrganizationDescription'])){
                $organizationValid = false;
            }
        }else if ($_POST['command'] == 'Delete'){
            // echo "<h2>ID: " . $_POST['OrganizationID']. "</h2>";
            $organizationID = filter_input(INPUT_POST, 'OrganizationID', FILTER_SANITIZE_NUMBER_INT);
            $organizationQuery = "DELETE FROM organizations WHERE ID = :ID";
            $organizationStatement = $db->prepare($organizationQuery);
            $organizationStatement->bindValue(':ID', $organizationID, PDO::PARAM_INT);
            $organizationStatement->execute();
            header("Location: Admin.php");
    }
}
$validOrganization = true;
if ($_POST && !empty($_POST['NewOrganizationName']) && !empty($_POST['NewOrganizationDescription']) && $_POST['command'] == 'Create') {
    $nameOrganization = filter_input(INPUT_POST, 'NewOrganizationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descriptionOrganization = filter_input(INPUT_POST, 'NewOrganizationDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $queryOrganization = "INSERT INTO organizations (Name, Description) VALUES (:Name, :Description)";        
    $statementOrganization = $db->prepare($queryOrganization);
    $statementOrganization->bindValue(':Name', $nameOrganization);
    $statementOrganization->bindValue(':Description', $descriptionOrganization);
    $statementOrganization->execute();
    header("Location: Admin.php");
    exit;
} else if($_POST && empty($_POST['NewOrganizationName']) && empty($_POST['NewOrganizationDescription']) && $_POST['command'] == 'Create') {
    $validOrganization = false;
}


//OCCUPATIONS
$occupationQuery = "SELECT * FROM occupations ORDER BY ID";
$occupationStatement = $db->prepare($occupationQuery);
$occupationStatement->execute();


$occupationValid = true;


if($_POST){
    if ($_POST['command'] == 'Update') {
        // echo "<h2>Name: " . $_POST['OccupationName']. "</h2>";
        // echo "<h2>Description: " . $_POST['OccupationDescription']. "</h2>";
        // echo "<h2>ID: " . $_POST['OccupationID']. "</h2>";
        // echo empty($_POST['OccupationName']);
        // echo empty($_POST['OccupationDescription']);
            if(!empty($_POST['OccupationName']) && !empty($_POST['OccupationDescription'])){
                $occupationName  = filter_input(INPUT_POST, 'OccupationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $occupationDescription = filter_input(INPUT_POST, 'OccupationDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $occupationID = filter_input(INPUT_POST, 'OccupationID', FILTER_SANITIZE_NUMBER_INT);
                $occupationQuery = "UPDATE occupations SET Name = :Name, Description = :Description WHERE ID = :ID";
                $occupationStatement = $db->prepare($occupationQuery);
                $occupationStatement->bindValue(':Name', $occupationName);        
                $occupationStatement->bindValue(':Description', $occupationDescription);
                $occupationStatement->bindValue(':ID', $occupationID, PDO::PARAM_INT);
                $occupationStatement->execute();
                header("Location: Admin.php");
            } else if (empty($_POST['OccupationName']) && empty($_POST['OccupationDescription'])){
                $occupationValid = false;
            }
        }else if ($_POST['command'] == 'Delete'){
            // echo "<h2>ID: " . $_POST['OccupationID']. "</h2>";
            $occupationID = filter_input(INPUT_POST, 'OccupationID', FILTER_SANITIZE_NUMBER_INT);
            $occupationQuery = "DELETE FROM occupations WHERE ID = :ID";
            $occupationStatement = $db->prepare($occupationQuery);
            $occupationStatement->bindValue(':ID', $occupationID, PDO::PARAM_INT);
            $occupationStatement->execute();
            header("Location: Admin.php");
    }
}
$validOccupation = true;
if ($_POST && !empty($_POST['NewOccupationName']) && !empty($_POST['NewOccupationDescription']) && $_POST['command'] == 'Create') {
    $nameOccupation = filter_input(INPUT_POST, 'NewOccupationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descriptionOccupation = filter_input(INPUT_POST, 'NewOccupationDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $queryOccupation = "INSERT INTO occupations (Name, Description) VALUES (:Name, :Description)";        
    $statementOccupation = $db->prepare($queryOccupation);
    $statementOccupation->bindValue(':Name', $nameOccupation);
    $statementOccupation->bindValue(':Description', $descriptionOccupation);
    $statementOccupation->execute();
    header("Location: Admin.php");
    exit;
} else if($_POST && empty($_POST['NewOccupationName']) && empty($_POST['NewOccupationDescription']) && $_POST['command'] == 'Create') {
    $validOccupation = false;
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
        <div id="categoryLibrary">
        <div class="categoryContainer">    
                <div id="organizationAdd">
                    <div id="invalidated">
                        <?php if(!$validOrganization):?>
                            You didn't enter any information!
                        <?php endif ?>
                    </div>
                    <form action="Admin.php" method="post">
                        <fieldset>
                            <legend>New Organization</legend>
                            <div>
                                <label for="NewOrganizationName">Name</label>
                                <input name="NewOrganizationName" id="NewOrganizationName">
                            </div>
                            <div>
                                <label for="NewOrganizationDescription">Description</label>
                                <textarea name="NewOrganizationDescription" id="NewOrganizationDescription"></textarea>
                            </div>
                            <div id="buttonContainer">
                                <input class="button" type="submit" name="command" value="Create">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="divider"></div>
                <div class="organizationEdit">
                    <div>
                        <?php if(!$organizationValid):?>
                                You didn't change any information!
                            <?php endif ?>
                        <?php if(!$organizationStatement):?>
                            No query!
                        <?php endif ?>
                    </div>
                    <?php while($organizationRow = $organizationStatement->fetch()):?>
                        <form method="post">
                            <fieldset>
                                <legend>Edit Organization</legend>
                                <div>
                                    <label for="OrganizationName">Name</label>
                                    <input type="text" name="OrganizationName" id="OrganizationName" value="<?=$organizationRow['Name']?>">
                                </div>
                                <div>
                                    <label for="OrganizationDescription">Description</label>
                                    <textarea name="OrganizationDescription" id="OrganizationDescription"><?= $organizationRow['Description'] ?></textarea>
                                </div>
                                <div>
                                    <h3>Organization ID: <?=$organizationRow['ID']?></h3>
                                    <input type="hidden" name="OrganizationID" if="OrganizationID" value="<?=$organizationRow['ID']?>">
                                    <input class="button" type="submit" name="command" value="Update">
                                    <input class="button" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this Organization?')">
                                </div>
                            </fieldset>
                        </form>          
                    <?php endwhile ?>
                </div>
            </div>
            <div class="categoryContainer">    
                <div id="occupationAdd">
                    <div id="invalidated">
                        <?php if(!$validOccupation):?>
                            You didn't enter any information!
                        <?php endif ?>
                    </div>
                    <form action="Admin.php" method="post">
                        <fieldset>
                            <legend>New Occupation</legend>
                            <div>
                                <label for="NewOccupationName">Name</label>
                                <input name="NewOccupationName" id="NewOccupationName">
                            </div>
                            <div>
                                <label for="NewOccupationDescription">Description</label>
                                <textarea name="NewOccupationDescription" id="NewOccupationDescription"></textarea>
                            </div>
                            <div id="buttonContainer">
                                <input class="button" type="submit" name="command" value="Create">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="divider"></div>
                <div class="occupationEdit">
                    <div>
                        <?php if(!$occupationValid):?>
                                You didn't change any information!
                            <?php endif ?>
                        <?php if(!$occupationStatement):?>
                            No query!
                        <?php endif ?>
                    </div>
                    <?php while($occupationRow = $occupationStatement->fetch()):?>
                        <form method="post">
                            <fieldset>
                                <legend>Edit Occupation</legend>
                                <div>
                                    <label for="OccupationName">Name</label>
                                    <input type="text" name="OccupationName" id="OccupationName" value="<?=$occupationRow['Name']?>">
                                </div>
                                <div>
                                    <label for="OccupationDescription">Description</label>
                                    <textarea name="OccupationDescription" id="OccupationDescription"><?= $occupationRow['Description'] ?></textarea>
                                </div>
                                <div>
                                    <h3>Occupation ID: <?=$occupationRow['ID']?></h3>
                                    <input type="hidden" name="OccupationID" if="OccupationID" value="<?=$occupationRow['ID']?>">
                                    <input class="button" type="submit" name="command" value="Update">
                                    <input class="button" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this Occupation?')">
                                </div>
                            </fieldset>
                        </form>          
                    <?php endwhile ?>
                </div>
            </div>

            <div class="categoryContainer">    
                <div id="speciesAdd">
                    <div id="invalidated">
                        <?php if(!$validSpecies):?>
                            You didn't enter any information!
                        <?php endif ?>
                    </div>
                    <form action="Admin.php" method="post">
                        <fieldset>
                            <legend>New Species</legend>
                            <div>
                                <label for="NewSpeciesName">Name</label>
                                <input name="NewSpeciesName" id="NewSpeciesName">
                            </div>
                            <div>
                                <label for="NewSpeciesDescription">Description</label>
                                <textarea name="NewSpeciesDescription" id="NewSpeciesDescription"></textarea>
                            </div>
                            <div id="buttonContainer">
                                <input class="button" type="submit" name="command" value="Create">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="divider"></div>
                <div class="speciesEdit">
                    <div>
                        <?php if(!$speciesValid):?>
                                You didn't change any information!
                            <?php endif ?>
                        <?php if(!$speciesStatement):?>
                            No query!
                        <?php endif ?>
                    </div>
                    <?php while($speciesRow = $speciesStatement->fetch()):?>
                        <form method="post">
                            <fieldset>
                                <legend>Edit Species</legend>
                                <div>
                                    <label for="SpeciesName">Name</label>
                                    <input type="text" name="SpeciesName" id="SpeciesName" value="<?=$speciesRow['Name']?>">
                                </div>
                                <div>
                                    <label for="SpeciesDescription">Description</label>
                                    <textarea name="SpeciesDescription" id="SpeciesDescription"><?= $speciesRow['Description'] ?></textarea>
                                </div>
                                <div>
                                    <h3>Species ID: <?=$speciesRow['ID']?></h3>
                                    <input type="hidden" name="SpeciesID" if="SpeciesID" value="<?=$speciesRow['ID']?>">
                                    <input class="button" type="submit" name="command" value="Update">
                                    <input class="button" type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this Species?')">
                                </div>
                            </fieldset>
                        </form>          
                    <?php endwhile ?>
                </div>
            </div>
            <div class="categoryContainer">    
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
                <div class="divider"></div>
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
        </div>
    </main>
</body>
</html>