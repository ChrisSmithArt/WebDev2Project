<?php
    require('connect.php');
    // require('authenticate.php');
    session_start();

    if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']){
        header("Location: login.php");
    } else if(!$_SESSION['Admin']){
        header("Location: index.php");
    }


    function checkFullFields(){
        if(empty($_POST['Name'])){
            return false;
        }
        if(empty($_POST['Description'])){
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
    $npc = false;
    $ID = filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT);
    if(filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_NUMBER_INT)){
        if($_POST){
            if ($_POST['command'] == 'Update') {
                if(checkFullFields()){
                    $Name  = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $Description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $ID = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
                    $SpeciesID = $_POST['species'];
                    $OccupationID = $_POST['occupation'];
                    $OrganizationID = $_POST['organization'];
                    $query = "UPDATE npcs SET Name = :Name, Description = :Description, SpeciesID = :SpeciesID, OccupationID = :OccupationID, OrganizationID = :OrganizationID, imgsrc = :imgsrc  WHERE ID = :ID";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':Name', $Name);        
                    $statement->bindValue(':Description', $Description);
                    $statement->bindValue(':SpeciesID', $SpeciesID);
                    $statement->bindValue(':OccupationID', $OccupationID);
                    $statement->bindValue(':OrganizationID', $OrganizationID);
                    $statement->bindValue(':imgsrc', checkImage() ? bindImage() : "images/default.jpg" );
                    $statement->bindValue(':ID', $ID, PDO::PARAM_INT);
                    $statement->execute();
                    header("Location: index.php");
                } else {
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
    <?php include("headInfo.php");?>
    <title>Edit this NPC</title>
</head>
<body>
    <?php include("header.php");?>
        <div>
            <?php if ($npc): ?>
                <form method="post" enctype='multipart/form-data'>
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
                                    <option value="<?=$rowSpecies['ID']?>"  <?=$rowSpecies['ID'] == $npc['SpeciesID'] ? ' selected="selected"' : ''?>><?=$rowSpecies['Name']?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div>
                            <label for="occupation">Occupation</label>
                            <select name="occupation" id="occupation">
                                <option value="">Select an Occupation</option>
                                <?php while($rowOccupation = $statementOccupation->fetch()):?>
                                    <option value="<?=$rowOccupation['ID']?>" <?=$rowOccupation['ID'] == $npc['OccupationID'] ? ' selected="selected"' : ''?>><?=$rowOccupation['Name']?> </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div>
                            <label for="organization">Organization</label>
                            <select name="organization" id="organization">
                                <option value="">Select an Organization</option>
                                <?php while($rowOrganization = $statementOrganization->fetch()):?>
                                    <option value="<?=$rowOrganization['ID']?>"  <?=$rowOrganization['ID'] == $npc['OrganizationID'] ? ' selected="selected"' : ''?>><?=$rowOrganization['Name']?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div>
                            <label for="image">Portrait:</label>
                            <input type="file" name="image" id="image">
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
                        Invalid: You cannot update an NPC with empty values!
                    <?php else: ?>
                        <?php header("Location: index.php")?>
                    <?php endif ?>
                </div>
                <?php endif ?>
        </div>
</body>
</html>