<?php

session_start();


$mysqli = new mysqli('localhost', 'root2', 'mypass123', 'crud');

$id = 0;
$update = false;
$name = "";
$location = "";

$nameerr = $locationerr = $imgerr = "";
$uploadOk = 1;

if (isset($_POST['save-btn'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];

    $target_dir = "uploaded_img/";
    $fileName = $_FILES['file-image']['name'];


    $target_file = $target_dir . basename($fileName);


    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));



    $fileError = $_FILES['file-image']['error'];

    // Name Validation
    if (empty($name)) {
        $nameerr = "Name is Required";
        $uploadOk = 0;
    }

    // Image Validation
    if (empty($fileName)) {
        $imgerr = "Please select a file";
        $uploadOk = 0;
    } elseif ($fileError !== 0) {
        $imgerr = "An error occurred while uploading the file. Please try again.";
        $uploadOk = 0;
    } elseif (file_exists($target_file)) {
        $imgerr = "Sorry, file already exists.";
        $uploadOk = 0;
    } elseif ($_FILES["file-image"]["size"] > 500000) {
        $imgerr = "Sorry, your file is too large.";
        $uploadOk = 0;
    } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $imgerr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Location Validation
    if (empty($location)) {
        $locationerr = "Location is Required";
        $uploadOk = 0;
    }

    // If no errors, proceed to insert and upload
    if ($uploadOk === 1) {
        // Database Insert
        $mysqli->query("INSERT INTO data(name, location, image) VALUES('$name', '$location', '$fileName')") or die($mysqli->error);

        if ($mysqli) {
            // File Upload
            move_uploaded_file($_FILES["file-image"]["tmp_name"], $target_file);

            $_SESSION['message'] = "Registration successful";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Registration failed";
            $_SESSION['msg_type'] = "danger";
        }
    }
}










// delete button
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Get the file name associated with the record from the database
    $result = $mysqli->query("SELECT image FROM data WHERE id=$id") or die($mysqli->error);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fileName = $row['image'];

        // Specify the path to the file
        $target_dir = "uploaded_img/";
        $fileToDelete = $target_dir . $fileName;

        // Delete the file from the server
        if (file_exists($fileToDelete)) {
            unlink($fileToDelete);
        }

        // Delete the record from the database
        $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error);

        $_SESSION['message'] = "Record and file have been deleted successfully";
        $_SESSION['msg_type'] = "danger";
    } else {
        $_SESSION['message'] = "Record not found";
        $_SESSION['msg_type'] = "danger";
    }

    header("location: index.php");
}





// edit button


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_array();
        $name = $row['name'];
        $location = $row['location'];
    }
}



// $result = mysqli_query($mysqli,"SELECT * FROM data WHERE id=$id");
// if (mysqli_num_rows($result ) == 1) {
//     $row = $result->fetch_array();
//     $name = $row['name'];
//     $location = $row['location'];
// }




if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];

    $target_dir = "uploaded_img/";
    $fileName = $_FILES['file-image']['name'];
    $target_file = $target_dir . basename($fileName);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileError = $_FILES['file-image']['error'];
    $uploadOk = 1;

    // Initialize error messages
    $nameerr = $locationerr = $imgerr = "";

    // Name Validation
    if (empty($name)) {
        $nameerr = "Name is Required";
        $uploadOk = 0;
    }

    // Location Validation
    if (empty($location)) {
        $locationerr = "Location is Required";
        $uploadOk = 0;
    }

    // Check if a file was uploaded
    if (!empty($fileName)) {
        // Image Validation
        if ($fileError !== 0) {
            $imgerr = "An error occurred while uploading the file. Please try again.";
            $uploadOk = 0;
        } elseif (file_exists($target_file)) {
            $imgerr = "Sorry, file already exists.";
            $uploadOk = 0;
        } elseif ($_FILES["file-image"]["size"] > 500000) {
            $imgerr = "Sorry, your file is too large.";
            $uploadOk = 0;
        } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $imgerr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    }

    if ($uploadOk === 1) {
        // If a file was uploaded, replace the old image with the new one
        if (!empty($fileName)) {
            // Retrieve the old image name from the database
            $result = $mysqli->query("SELECT image FROM data WHERE id=$id") or die($mysqli->error);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $oldFileName = $row['image'];

                // Delete the old image from the server
                $oldFilePath = $target_dir . $oldFileName;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Update the record with the new file name
            $mysqli->query("UPDATE data SET name='$name', location='$location', image='$fileName' WHERE id=$id") or die($mysqli->error);

            // Move the uploaded file to the target directory
            move_uploaded_file($_FILES["file-image"]["tmp_name"], $target_file);

            $_SESSION['message'] = "Record and image have been updated successfully";
        } else {
            // Update the record without changing the image
            $mysqli->query("UPDATE data SET name='$name', location='$location' WHERE id=$id") or die($mysqli->error);

            $_SESSION['message'] = "Record has been updated successfully";
        }

        $_SESSION['msg_type'] = "success";
        header('location: index.php');
    } else {
        // Handle error messages
        $_SESSION['message'] = $nameerr . ' ' . $locationerr . ' ' . $imgerr;
        $_SESSION['msg_type'] = "danger";
        header('location: index.php');
    }
}

