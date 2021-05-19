<?php
session_start();

  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);
  $user_name = $user_data['user_name'];
  $user_phone = $user_data['phone'];

  $answered_questions_query = "select * from questions where user_name = '$user_name' and answer != ''";
  $answered_questions = mysqli_query($con, $answered_questions_query);

  $error_msg = "";
  $image = "";

  if($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $admin_data_query = "select * from users where user_role = 'admin'";
    $admin_data = mysqli_query($con, $admin_data_query);

    if($admin_data) {
      if($admin_data && mysqli_num_rows($admin_data) > 0) {
        $admin_info = mysqli_fetch_assoc($admin_data);
        $updated_balance = $admin_info['balance'] + 50;

        $balance_query = "update users set balance = '$updated_balance' where user_role = 'admin'";
        $balance = mysqli_query($con, $balance_query);

        if($balance) {
          $question = $_POST['question'];
    
          $add_reclaim_query = "insert into questions (user_name,question,answer) values ('$user_name','$question','')";
          $add_reclaim = mysqli_query($con, $add_reclaim_query);
      
          if($add_reclaim) {
            $error_msg =  "Successfully added your question.";
          } else {
              $error_msg =  "error adding your question, try again later!";
          }
        }
      }
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
          <li><a href="sell-crops.php">Sell Crops</a></li>
          <li><a href="buy-lands.php">Buy Lands</a></li>
          <li><a href="sell-lands.php">Sell Lands</a></li>
          <li class="active"><a href="ask-question.php">Ask Question</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="reclaim-land.php" class="get-started-btn">Reclaim Your Land</a>

    </div>
  </header><!-- End Header -->


    <section style="margin-top: 100px;">
    <div class="container mt-3" style="max-width: 700px;"><br>
        <h3>Ask Your Question</h3>
        <p>(costs 50 L.E)</p>
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <textarea class="form-control my-3" rows="5" name="question" placeholder="write your question here.."></textarea>

            <button type="submit" class="btn btn-primary" style="background: #ed502e;">Ask Question</button>
            <?php echo $error_msg ?>
        </form>
    </div>
    </section>

    <section class="container mt-5" style="max-width: 700px;">
      <h2>My Answered Questions</h2>
      <div class="row">
        <?php
          while($row = mysqli_fetch_array($answered_questions)) {
        ?>
        
        <div class="card col-12" style="width: 18rem;">
          <div class="card-body">
            <p class="card-title">Question: <?php echo $row['question'] ?></p>
            <p class="card-text">Answer: <?php echo $row['answer'] ?></p>
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