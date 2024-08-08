<!-- NOTE -->

<!-- * IT IS USED TO LINK ONE PHP FILE TO ANOTHER -->

 <?php require_once '' ; ?>

<!-- END -->

 


<!-- * CREATE A MYSQL DATABASE "ANYNAME" AND TABLE "ANYNAME" WITH ID, AND THE CONTENT YOU HAVE ON YOUR FORM LIKE NAMES,PASSWORD,EMAIL,LOCATION ETC {START}-->


<!-- GO TO LOCALHOST/PHPMYADMIN {ON YOUR BROWSER} -->

<!-- CLICK DATABASE -->
<!-- CREATE A DATABASE NAME{THEN CLICK CREATE} -->
 <!-- CREATE A TABLE NAME AND ADD NUMBER OF COLUMNS ON YOUR FORM {CLICK GO}  -->

<!-- WHAT YOU HAVE ON YOUR FORM{ADD ID, NAME,LOCATION DEPENDING WHAT YOU HAVE ON YOUR FORM BUT U WILL ALWAYS HAVE AN ID ON YOUR DATABASE} -->

<!-- ID(INT) NAME(VARCHAR) LOCATION(VARCHAR)-->
 <!-- LENTH / VALUES WILL BE (255) U CAN ADD NUMBER OF YOUR CHOICE BUT I PREFERE (255) FOR ALL -->
  <!-- CLICK A.I (AUTO INCREMENT (PRIMARY)) CLICK (SAVE)-->


<!-- END -->




<!-- * CONNECT TO THE DATABASE AND INSERT THE (WHAT YOU HAVE ON YOUR FORM) RECORDS INTO THE (TABLE NAME) IF THE SAVE BUTTON IS CLICK(THE NAME YOU USED INSIDE THE FORM (BUTTON) HAS BEEN CLICK -->


<!-- * CONNECT TO THE MYSQL DATABASE (WITH THE INFORMATION U HAVE ON YOUR DATABASE CREATED) -->

 $msqli = new mysqli('localhost', 'root2', 'mypass123', 'crud') or die (mysqli_error($mysqli));
 



 <!-- * CHECK IF THE BUTTON HAVE BEEN CLICK AND STORE THE INFORMATION ON YOUR FORM-->

  if (isset($_POST['save-btn'])) {
    $name = $_POST['name'];
    $location = $_POST['location']; (I HAVE NAME AND LOCATION ON MY FORM THATS WHY AM USING BOTH AS MY VARIABLE) 
  }


    <!-- * INSERT RECORDS INTO DATABASE (DATA IS TABLE NAME DEPENDING ON THE NAME OF UR TABLE) VALUES ARE NAMES ON UR FORM-->

      $mysqli->query("INSERT INTO data(name, location) VALUES('$name', '$location')") or die($mysqli->error); 


    <!-- * CONNECT TO THE DATABASE AND SELECT THE EXISTING RECORDS AND CREATE THE LOOPE TO DISPLAY THEM ABOVE THE FORM IN AN HTML TABLE.  (OPEN IT ABOVE THE FORM) CONNECT TO DATABASE-->

 $msqli = new mysqli('localhost', 'root2', 'mypass123', 'crud') or die (mysqli_error($mysqli));
 

  <!-- * STORE INSIDE MYSQL AND ADD THE TABLE NAME -->
<?php
  $result = $msqli->query("SELECT * FROM data") or die($mysqli->error); 

  ?>
  <!-- * BOOSTRAP 5 TABLE(DEPENDING ON WHT U HV ON UR FORM) -->


<div class="container mt-5">           
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>NAME</th>
        <th>LOCATION</th>
        <th>ACTION</th> THIS WILL HOLD UR EDIT AND DELETE BUTTON
      </tr>
    </thead>


   <?php


while ($row = $result->fetch_assoc()): ?>  {FETCH_ASSOC IS FOR PULLING RECORDS FRM DATABASE}


 <!-- TO PRINT THE ACTUAL VALUE -->
    <tr>
      <td><?php echo $row['name'] ?></td>
    
      <td><?php echo $row['location'] ?></td>
    
      <td>

      <!-- EDIT AND DELETE BUTTON -->

      <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info btn-sm fw-bold d-inline-block">Edit</a>
      
              <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm fw-bold d-inline-block">Delete</a>
            </td>
    
      </td>
    </tr>
    
    <?php endwhile; ?>
    
    </table>
    </div> 



<!--  * IF THE DELETE BUTTON HAVE BEEN CLICKED DELETE THE RECORD FROM THE (TABLE NAME WHICH IS (DATA)) USING THE PASSED ID FROM THE $_GET['DELETE'] VARIABLE VALUE -->


<?php

if (isset($_GET['delete'])){

$id = $_GET['delete'];

$mysqli->query("DELETE FROM data WHERE `id`=$id") or die($mysqli->error);

}

?>



<!-- *  CREATE A SESSION MESSAGE AND MESSAGE TYPES FOR SAVED AND DELETE BUTTONS REDIRECT THE USER BACK TO THE MAIN PAGE WHICH IS INDEX.PHP FOR BOTH -->


<!-- * IT WILL BE AT THE TOP OF THE PAGE AHEAD OF THE SAVE BUTTON-->
session_start(); 

<?php

if (isset($_POST['save-btn'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];



    $mysqli->query("INSERT INTO data(name, location) VALUES('$name', '$location')") or die($mysqli->error);



$_SESSION['message'] = "Record has been saved";
$_SESSION['msg_type'] = "success";

// TO REDIRECT THE USER BACK TO THE MAIN PAGE
header("location: index.php");
}
?>

<?php

if (isset($_GET['delete'])){

    $id = $_GET['delete'];

   $mysqli->query("DELETE FROM data WHERE `id`=$id") or die($mysqli->error);



   $_SESSION['message'] = "Record has been deleted";
   $_SESSION['msg_type'] = "danger";


   header("location: index.php");


}
?>


<!-- * PRINT THEM OUT AT THE TOP FO THE FORM -->


<?php

if (isset($_SESSION['message'])): ?>
 <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">


<?php

echo $_SESSION['message'];

unset($_SESSION['message'])

?>
</div>

<?php endif ?>




<!--  *  IF THE EDIDT BUTTON HAVE BEEN CLICKED SELECT THE EXISTING RECORD FROM DATABASE , SET $NAME AND $LOCANTION VARIABLES AND {DEPENDING THE NAMES ON THE FORM} DISPLAY THEM IN THE FORM INPUT FIELDS  -->


<?php

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error);
    if ($result->num_rows == 1){
        $row = $result->fetch_array();
        $name = $row['name'];
        $location = $row['location'];
    }
}

?>



<!--  * CHANGE THE BUTTON TO UPDATE WHEN THE EDIT BUTTON HAVE BEEN CLICKED -->



<div class="container mb-3 justify-content-center">
      <?php
if ($update == true):
      ?>
      <button type="submit" class="btn btn-info" name="update">Update</button>

      <?php else: ?>

      <button type="submit" name="save-btn" class="btn btn-primary">SAVE</button>

      <?php endif; ?>
