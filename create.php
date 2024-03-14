<?php

require('connect.php');

$valid = true;
if ($_POST && !empty($_POST['name']) && !empty($_POST['description'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $SpeciesID = $_POST['species'];
    $query = "INSERT INTO npcs (name, description, SpeciesID) VALUES (:name, :description, :SpeciesID)";        
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':SpeciesID', $SpeciesID);
    $statement->execute();
    header("Location: index.php");
    exit;
} else if($_POST && empty($_POST['name']) && empty($_POST['description']) && $_POST['command'] == 'Create') {
    $valid = false;
}

    $querySpecies = "SELECT * FROM species ORDER BY ID";
    $statementSpecies = $db->prepare($querySpecies);
    $statementSpecies->execute(); 

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
                        You didn't enter any information!
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
                        <div id="buttonContainer">
                            <input class="button" type="submit" name="command" value="Create">
                        </div>
                    </fieldset>
                </form>
            </div>
    </main>
</body>
</html>