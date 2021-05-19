<?php
session_start();

  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);
  $user_name = $user_data['user_name'];

  $my_reclaimations_query = "select * from crops";
  $my_reclaimations = mysqli_query($con, $my_reclaimations_query);

  $purchased_crops_query = "select * from purchased_crops where investor_name = '$user_name'";
  $purchased_crops = mysqli_query($con, $purchased_crops_query);
  
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
          <li class="active"><a href="buy-crops.php">Buy Crops</a></li>
          <li><a href="buy-lands.php">Buy Lands</a></li>
          <li><a href="sell-lands.php">Sell Lands</a></li>
          <li><a href="ask-question.php">Ask Question</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="invest-reclaim.php" class="get-started-btn">Reclaim Farmer Land</a>

    </div>
  </header><!-- End Header -->


    <section class="container mt-5">
      <h2>All Available Crops</h2>
      <?php
        if($_SERVER['REQUEST_METHOD'] == "POST") {
          $price = $_POST['price'];
          $amount = $_POST['amount'];
          $total_price = $price * $amount;

          $admin_data_query = "select * from users where user_role = 'admin'";
          $admin_data = mysqli_query($con, $admin_data_query);
  
          if($admin_data) {
            if($admin_data && mysqli_num_rows($admin_data) > 0) {
              $admin_info = mysqli_fetch_assoc($admin_data);
              $updated_balance = $admin_info['balance'] + 50;
  
              $balance_query = "update users set balance = '$updated_balance' where user_role = 'admin'";
              $balance = mysqli_query($con, $balance_query);

              if($balance) {
                
                $farmer_name = $_POST['farmer_name'];
                $farmer_phone = $_POST['farmer_phone'];
                $crop_type = $_POST['crop_type'];
                $investor_name = $user_data['user_name'];
                $investor_phone = $user_data['phone'];
                $min_amount = $_POST['min_amount'];

                if($amount < $min_amount) {
                  echo "you request an amount lower than the minimum amount, try increase the quantity.";

                } else {
                  $query = "insert into purchased_crops (farmer_name,investor_name,investor_phone,crop_type,amount,price) values ('$farmer_name','$investor_name','$investor_phone','$crop_type','$amount','$price')";
                  $result = mysqli_query($con, $query);
  
                  if($result) {
                    echo "successfully purchased the crops, the farmer phone number is: 0". $farmer_phone; 
                  } else {
                    echo "error adding your invest";
                  }
                }

              }
            }
          }             
        }
      ?>
      <div class="row">

        <?php
          while($row = mysqli_fetch_array($my_reclaimations)) {
        ?>
        
        <div class="card col-5 ml-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Farmer: <?php echo $row['farmer_name'] ?></h5>
            <p class="card-text">Crop Type: <?php echo $row['crop_type'] ?></p>
            <p class="card-text">Amount: <?php echo $row['amount'] ?> kg</p>
            <p class="card-text">Price per Kg: <?php echo $row['price'] ?> L.E</p>
            <p class="card-text">Minimum Amount To Buy: <?php echo $row['min_amount'] ?> Kg</p>
            <p class="card-text">Description: <?php echo $row['description'] ?></p>
            <img class='card-img-top mb-3' src=<?php echo "uploads/". $row['image'] ?> alt='Profile Picture' style='width:100%'>
            <form method="post">
              <input type="number" class="form-control mb-3" placeholder="How Much do You Want?" name="amount">
              <input type="hidden" name="farmer_name" value='<?php echo $row["farmer_name"] ?>'>
              <input type="hidden" name="farmer_phone" value=<?php echo $row['farmer_phone'] ?>>
              <input type="hidden" name="crop_type" value=<?php echo $row['crop_type'] ?>>
              <input type="hidden" name="min_amount" value=<?php echo $row['min_amount'] ?>>
              <input type="hidden" name="price" value=<?php echo $row['price'] ?>>
              <input type="submit" class="btn btn-primary" style="background: #ed502e;" value="Buy This Amount">
            </form>
            
            
          </div>
        </div>

        <?php } ?>
      </div>
    </section>

    <section class="container mt-5">
      <h2>My Purchased Crops</h2>
      <div class="row">

        <?php
          while($row = mysqli_fetch_array($purchased_crops)) {
        ?>
        
        <div class="card col-5 ml-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Farmer: <?php echo $row['farmer_name'] ?></h5>
            <p class="card-text">Crop Type: <?php echo $row['crop_type'] ?></p>
            <p class="card-text">Amount: <?php echo $row['amount'] ?> kg</p>
            <p class="card-text">Price per Kg: <?php echo $row['price'] ?> L.E</p>
  
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