<?php
session_start();

  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);
  $user_name = $user_data['user_name'];

  $my_reclaimations_query = "select * from questions where answer = ''";
  $questions = mysqli_query($con, $my_reclaimations_query);
  
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
          <li><a href="admin-crops.php">Purchased Crops</a></li>
          <li><a href="admin-lands.php">Purchased Lands</a></li>
          <li><a href="admin-reclaim.php">Reclaimations</a></li>
          <li class="active"><a href="answer-questions.php">Answer Questions</a></li>
          <li><a href="logout.php">logout</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="#" class="get-started-btn">Balance: <?php echo $user_data['balance'] ?> L.E</a>

    </div>
  </header><!-- End Header -->


    <section class="container mt-5">
      <h2>All Questions</h2>
      <?php
        if($_SERVER['REQUEST_METHOD'] == "POST") {
          $question_id = $_POST['question_id'];
          $answer = $_POST['answer'];

          $admin_data_query = "update questions set answer = '$answer' where id = '$question_id'";
          $answer = mysqli_query($con, $admin_data_query);

          if($answer) {
            header('Location: answer-questions.php');
          } else {
              echo "error submitting your answer!";
          }
           
        }
      ?>
      <div class="row">

        <?php
          while($row = mysqli_fetch_array($questions)) {
        ?>
        
        <div class="card col-5 ml-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">User Name: <?php echo $row['user_name'] ?></h5>
            <p class="card-text">Question: <?php echo $row['question'] ?></p>
            <form method="post">
              <input type="hidden" name="question_id" value=<?php echo $row['id'] ?>>
              <textarea class="form-control my-3" rows="5" name="answer" placeholder="write the answer here.."></textarea>
              <input type="submit" class="btn btn-primary" style="background: #ed502e;" value="Submit Answer">
            </form>
            
            
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