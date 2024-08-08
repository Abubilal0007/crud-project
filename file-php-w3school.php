<?php

if (isset($_POST['save-btn'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];


    if (empty($name)) {
        $nameerr = "Name is Required";
    }








    // Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== true) {

        $imgerr = "File is not an image";
        $uploadOk = 0;
    }
    // Check if file already exists

    if (file_exists($target_file)) {
        $imgerr =  "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $imgerr = "Sorry, your file is too large.";
        $uploadOk = 0;
    }




    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $imgerr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }





    //if insert finaly into database it should move to folder

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>
if (isset($_POST['update'])) {
$id = $_POST['id'];
$name = $_POST['name'];
$location = $_POST['location'];

if (empty($name)) {
$nameerr = "Name is Required";
} elseif (empty($location)) {
$locationerr = "Location is Required";
} else {


$mysqli->query("UPDATE data SET name='$name', location='$location' WHERE id=$id") or die($mysqli->error);

$_SESSION['message'] = "Record Has Been Updated Successfully";

$_SESSION['msg_type'] = "warning";

header('location: index.php');
}
}