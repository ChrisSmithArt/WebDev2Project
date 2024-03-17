<?php

require('connect.php');
require('authenticate.php');


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
        $query = "INSERT INTO npcs (name, description, SpeciesID, OccupationID, OrganizationID, imgsrc) VALUES (:name, :description, :SpeciesID, :OccupationID, :OrganizationID, :imgsrc)";        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':SpeciesID', $SpeciesID);
        $statement->bindValue(':OccupationID', $OccupationID);
        $statement->bindValue(':OrganizationID', $OrganizationID);
        $statement->bindValue(':imgsrc', checkImage() ? bindImage() : "images/default.jpg" );
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
    


    function bindImage(){
        $image_upload_detected = (isset($_FILES['image']) && ($_FILES['image']['error'] === 0));
        $upload_error_detected = (isset($_FILES['image']) && ($_FILES['image']['error'] > 0));
            
         if ($image_upload_detected) { 
             $image_filename        = $_FILES['image']['name'];
             $temporary_image_path  = $_FILES['image']['tmp_name'];
             $new_image_path        = file_upload_path($image_filename);
             if (file_is_an_image($temporary_image_path, $new_image_path)) {
                move_uploaded_file($temporary_image_path, $new_image_path);
                return "images\\".basename($new_image_path);
            } else {
                return false;
            } 
         } else {
            return false;
         }

    }

    function checkImage(){
        if(!isset($_FILES['image'])){
            return false;
        }
        $image_upload_detected = (isset($_FILES['image']) && ($_FILES['image']['error'] === 0));
        $upload_error_detected = (isset($_FILES['image']) && ($_FILES['image']['error'] > 0));
            
         if ($image_upload_detected) { 
             $image_filename        = $_FILES['image']['name'];
             $temporary_image_path  = $_FILES['image']['tmp_name'];
             $new_image_path        = file_upload_path($image_filename);
             if (file_is_an_image($temporary_image_path, $new_image_path)) {
                return true;
            } else {
                //echo "file is not an image";
                return false;
            } 
         } else {
            //echo "image upload not detected";
            return false;
         }
    }

    if(isset($_FILES['image'])){
        //echo $_FILES['image'];
    }
    

    function file_upload_path($original_filename, $upload_subfolder_name = 'images') {
        $current_folder = dirname(__FILE__);
        
        // Build an array of paths segment names to be joins using OS specific slashes.
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        
        // The DIRECTORY_SEPARATOR constant is OS specific.
        return join(DIRECTORY_SEPARATOR, $path_segments);
     }
    
     // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
     function file_is_an_image($temporary_path, $new_path) {
         $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
         $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
         
         $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type = mime_content_type($temporary_path);
    
         
         $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
         $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
         
         return $file_extension_is_valid && $mime_type_is_valid;
     }

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
                <form action="create.php" method="post" enctype='multipart/form-data'>
                    <fieldset>
                        <legend>New NPC!</legend>
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
                        <div>
                            <label for="image">Portrait:</label>
                            <input type="file" name="image" id="image">
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