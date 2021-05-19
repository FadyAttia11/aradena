<?php
session_start();

  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);

  $error_msg = "";
  $image = "";

  if($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $min_amount = $_POST['min_amount'];
    $crop_type = $_POST['crop_type'];
    $description = $_POST['description'];
    $farmer_name = $user_data['user_name'];
    $farmer_phone = $user_data['phone'];

    $target_dir = "uploads/";
    $target_file = $target_dir . time() . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $image = time() . basename($_FILES["fileToUpload"]["name"]);
      $error_msg = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        $error_msg = "Sorry, there was an error uploading your file.";
    }
    
    
    $add_reclaim_query = "insert into crops (farmer_name,farmer_phone,crop_type,amount,price,min_amount,description,image) values ('$farmer_name','$farmer_phone','$crop_type','$amount','$price','$min_amount','$description','$image')";
    $add_reclaim = mysqli_query($con, $add_reclaim_query);

    if($add_reclaim) {
      $error_msg =  "Successfully added your crops for selling.";
    } else {
        $error_msg =  "error adding your crops for selling, try again later!";
    }
  } 
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Aradena</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="index.php">Aradena</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="reclaim-requests.php">Reclamation Requests</a></li>
          <li class="active"><a href="sell-crops.php">Sell Crops</a></li>
          <li><a href="buy-lands.php">Buy Lands</a></li>
          <li><a href="sell-lands.php">Sell Lands</a></li>
          <li><a href="ask-question.php">Ask Question</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="reclaim-land.php" class="get-started-btn">Reclaim Your Land</a>

    </div>
  </header><!-- End Header -->


    <section style="margin-top: 100px;">
    <div class="container mt-3" style="max-width: 700px;"><br>
        <h3>Sell Non-Chemical Crops</h3>
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

          <div class="row mt-3">
            <div class="col">
              <input type="text" class="form-control" placeholder="Crop Type" name="crop_type" required>  
            </div>
            <div class="col">
              <input type="number" class="form-control" placeholder="Kilograms Available" name="amount" required>
            </div>
          </div>

        

          <div class="row mt-3 mb-4">
              <div class="col">
                <input type="number" step=any class="form-control" placeholder="Kilogram Price" name="price" required>
              </div>
              <div class="col">
                <input type="number" class="form-control" placeholder="Minimum Amount" name="min_amount" required>
              </div>
          </div>

          <label for="fileToUpload">Product Image (Required): </label>
          <input type="file" name="fileToUpload" class="mb-3" id="fileToUpload" required> 

          <textarea class="form-control my-3" rows="5" name="description" placeholder="write a description about your product.."></textarea>

          <button type="submit" class="btn btn-primary" style="background: #ed502e;">Sell Your Crops</button>
          Want to see how many have you sold previously? <a href="selling-history.php">See selling history</a><br>
          <?php echo $error_msg ?>
        </form>
    </div>
    </section>

    <script>
        // Disable form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
                }, false);
            });
            }, false);
        })();
    </script>
</body>
</html>