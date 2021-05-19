<?php
session_start();

    include("connection.php");
    include("functions.php");

    $error_msg = "";
    $profile_pic = "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        //something was posted
        $user_name = $_POST['user_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_role = $_POST['user_role'];
        
        if(!empty($email) && !empty($password) && !empty($user_name) && !empty($phone) && !empty($user_role)) {
            //save to database
            $query = "insert into users (user_name,email,password,user_role,phone,balance) values ('$user_name','$email', '$password','$user_role','$phone',0)";
            $result = mysqli_query($con, $query);

            if($result) {
                $_SESSION['user_id'] = $user_name;
                header('Location: index.php');
            } else {
                $error_msg =  "username or email is already taken!";
            }
        } else {
                $error_msg =  "Please enter some valid information";
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
          <li><a href="guest-home.php#about">About</a></li>
          <li><a href="guest-home.php#why-us">Why Us?</a></li>
          <li><a href="guest-home.php#testimonials">Testimonials</a></li>
          <li><a href="guest-home.php#team">Team</a></li>
          <li><a href="guest-home.php#contact">Contact</a></li>
          <li class="active"><a href="signup.php">Sign up</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="login.php" class="get-started-btn">Login Now</a>

    </div>
  </header><!-- End Header -->

  <main id="main">


    <section style="margin-top: 100px;">
    <div class="container mt-3" style="max-width: 700px;">
        <h3>SIGN UP</h3>
        
        <form method="post" class="needs-validation" novalidate>
        <div class="row mb-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Username" name="user_name" required>
        </div>
        <div class="col">
            <input type="number" class="form-control" placeholder="Phone Number" name="phone" required>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
        </div>
        <div class="col">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
        </div>
        </div>

        <div class="form-check mb-1">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="user_role" value="farmer">Farmer
            </label>
        </div>
        <div class="form-check mb-3 mb-5">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="user_role" value="investor">Investor
            </label>
        </div>

        
        <div class="modal-body">
        <h3>YOUR PAYMENT CARD DATA</h3>
          <div class="form-group mt-2">
              <label>Card holder's name</label>
          <input type="text" placeholder="Card holder's name" class="form-control">
          </div>
          <div class="form-group">
          <label>Card number</label>
          <input type="number" placeholder="Card number" class="form-control">
          </div>
          <div class="form-group">
              <label>Expire Date</label>
              <input type="date" placeholder="dd/mm/yy" class="form-control">
          </div>
          <div class="form-group">
              <label>CVV</label>
              <input type="text" placeholder="CVV" class="form-control">
          </div>
        </div>


        <button type="submit" class="btn btn-primary" style="background: #ed502e;">Register</button>
        already have an account? <a href="login.php">login</a><br>
        <?php echo $error_msg ?>
        </form>
    </div>
    </section>

  </main><!-- End #main -->





  <a href="#" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>