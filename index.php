<?php


include_once 'process.php'; ?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <?php

  $msqli = new mysqli('localhost', 'root2', 'mypass123', 'crud') or die(mysqli_error($mysqli));


  $result = $msqli->query("SELECT * FROM data") or die($mysqli->error);


  // pre_r($result);
  ?>
  <?php

  if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">


      <!-- if (isset($_SESSION['message'])): ?>
  <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Success!</strong> <?= $_SESSION['message'] ?>
  </div> -->



      <?php

      echo $_SESSION['message'];

      unset($_SESSION['message'])

      ?>
    </div>

  <?php endif ?>



  <div class="container mt-5">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>IMAGE</th>
          <th>NAME</th>
          <th>LOCATION</th>
          <th>ACTION</th>
        </tr>
      </thead>



      <?php

      while ($row = $result->fetch_assoc()) : ?>

        <tr>
          <td><img src="uploaded_img/<?php echo $row['image'] ?>" alt="" style="width: 50px;"></td>

          <td><?php echo $row['name'] ?></td>

          <td><?php echo $row['location'] ?></td>

          <td>
            <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info btn-sm fw-bold d-inline-block">Edit</a>

            <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm fw-bold d-inline-block">Delete</a>
          </td>

          </td>
        </tr>

      <?php endwhile; ?>

    </table>
  </div>





  <?php

  // pre_r($result->fetch_assoc()); 
  // pre_r($result->fetch_assoc()); 
  // pre_r($result->fetch_assoc()); 

  // function pre_r( $array ) {
  //   echo '<pre>';
  //   print_r($array);
  //   echo '<pre>';

  // }

  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="container mb-3 mt-5 w-50">
      <label for="name" class="form-label">NAME:</label>
      <input type="text" class="form-control" value="<?php echo $name; ?>" placeholder="Enter Name" name="name">
      <span class="text-danger"><?php echo $nameerr; ?></span>
    </div>

    <div class="container mb-4 w-50">
      <label for="pwd" class="form-label">LOCATION</label>
      <input type="text" class="form-control" value="<?php echo $location; ?>" placeholder="Enter Location" name="location">
      <span class="text-danger"><?php echo $locationerr; ?></span>
    </div>


    <div class="container mb-4 w-50">
      <label for="pwd" class="form-label">FILE</label>
      <input type="file" class="form-control" value="" placeholder="" name="file-image" id="fileToUpload">
      <span class="text-danger"><?php echo   $imgerr; ?></span>
    </div>

    <div class="container mb-3 justify-content-center">
      <?php
      if ($update == true) :
      ?>
        <button type="submit" class="btn btn-info" name="update">Update</button>

      <?php else : ?>

        <button type="submit" name="save-btn" class="btn btn-primary">SAVE</button>

      <?php endif; ?>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>