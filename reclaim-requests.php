<?php
session_start();

  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);
  $user_name = $user_data['user_name'];

  $my_reclaimations_query = "select * from reclaimations where farmer_name = '$user_name'";
  $my_reclaimations = mysqli_query($con, $my_reclaimations_query);
  
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
          <li class="active"><a href="reclaim-requests.php">Reclamation Requests</a></li>
          <li><a href="sell-crops.php">Sell Crops</a></li>
          <li><a href="buy-lands.php">Buy Lands</a></li>
          <li><a href="sell-lands.php">Sell Lands</a></li>
          <li><a href="ask-question.php">Ask Question</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="reclaim-land.php" class="get-started-btn">Reclaim Your Land</a>

    </div>
  </header><!-- End Header -->


    <section class="container mt-5">
      <h2>My Reclaimation Requests</h2>
      <div class="row">

        <?php
          while($row = mysqli_fetch_array($my_reclaimations)) {
        ?>
        
        <div class="card col-5 ml-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Crop Type: <?php echo $row['crop_type'] ?></h5>
            <p class="card-text">Money: <?php echo $row['money'] ?> L.E</p>
            <p class="card-text">Address: <?php echo $row['address'] ?></p>
            <?php 
              if($row['investor_name'] !== "") {
            ?>
            <p class="card-text">Investor name: <?php echo $row['investor_name'] ?></p>
            <p class="card-text">Investor phone: 0<?php echo $row['investor_phone'] ?></p>
            <?php  } else { ?>
            <p class="card-text">No Investor Assigned Yet!</p>
            <?php } ?>
            
          </div>
        </div>

        <?php } ?>
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