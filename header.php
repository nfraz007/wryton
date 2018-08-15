<?php require_once 'include/config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>WRYTON</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Sweet Alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <!-- Compiled and minified CSS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css"> -->
  <!-- Compiled and minified JavaScript -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script> -->
   
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top w3-black">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand w3-text-white w3-hover-text-teal" href="index.php"><p>WRYTON</p></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a class="w3-text-gray w3-hover-text-teal">Share your experience</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
            $out='<li class="dropdown">';
              $out.='<a class="dropdown-toggle w3-hover-teal w3-text-white" data-toggle="dropdown" href="#">'.$_SESSION["fname"].' '.$_SESSION["lname"].'<span class="caret"></span></a>';
              $out.='<ul class="dropdown-menu">';
                $out.='<li><a href="settings.php">Account Settings</a></li>';
                $out.='<li><a href="my_experience.php">My Experience</a></li>';
                $out.='<li><a href="share_with_us.php">Share With Us</a></li>';
                $out.='<li><a href="logout.php">Logout</a></li>';
              $out.='</ul>';
            $out.='</li>';
            echo $out;
          }else{
            // $out='<li><a href="login" class="w3-text-white w3-hover-teal">Login</a></li>';
            $out='<li><a href="#" class="w3-text-white w3-hover-teal" data-toggle="modal" data-target="#login_modal">Login</a></li>';
            $out.='<li><a href="register.php" class="w3-text-white w3-hover-teal">Register</a></li>';
            echo $out;
          }
        ?>
      </ul>
    </div>
  </div>
</nav>

<!-- LOGIN Modal -->
<div id="login_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <!-- <h4 class="modal-title">Modal Header</h4> -->
      </div>
      <div class="modal-body w3-padding-xlarge">
        <div class="row w3-padding-16">
          <input type="text" class="w3-input w3-text-teal w3-center" id="login_email" placeholder="Email" value="test@gmail.com">
        </div>
        <div class="row w3-padding-16">
          <input type="password" class="w3-input w3-text-teal w3-center" id="login_password" placeholder="Password" value="123456">
        </div>
        <div class="row w3-padding-16 w3-center">
          <button class="w3-btn w3-round w3-ripple w3-teal w3-text-white" id="login_sign_in">SIGN IN</button>
        </div>
        <div class="row w3-padding-16 w3-center">
          <p>New to WRYTON <a href="register.php" class="w3-text-teal">Register Now</a></p>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div>
    </div>

  </div>
</div>
