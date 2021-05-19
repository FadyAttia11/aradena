<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);

    if($user_data) {
      if($user_data['user_role'] == 'farmer') {
        return header('Location: ask-question-cli.php');
      } else if ($user_data['user_role'] == 'investor') {
        return header('Location: ask-question-invest.php');
      }
    }
?>