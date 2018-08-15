<?php
require_once '../../include/config.php';

if(isset($_REQUEST["email"]) && $_REQUEST["email"]!=""){
  if(isset($_REQUEST["password"]) && $_REQUEST["password"]!="" && strlen($_REQUEST["password"])>=6){
    $email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
    $password=md5($_REQUEST["password"]);

    $query="select * from `wryton_user` where `email`='{$email}' and `password`='{$password}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
      //return a valid user
      $row=mysqli_fetch_assoc($result);
      $user_id=$row["user_id"];
      $verified=$row["verified"];
      $status=$row["status"];
      if($status==1){
        if($verified==1){
          $query="insert into `wryton_user_history` (`user_id`,`ip_address`,`datetime`) values ('{$user_id}', '".getIPAddress()."', '".date("Y-m-d H:i:s")."')";
          if(mysqli_query($con,$query)){
            $output = '{"status":"success","remark":"you are successfully login","user_id":"'.$row['user_id'].'","fname":"'.$row["fname"].'","lname":"'.$row["lname"].'","email":"'.$row["email"].'" }';
            $_SESSION["user_id"]=$row["user_id"];
            $_SESSION["fname"]=$row["fname"];
            $_SESSION["lname"]=$row["lname"];
            $_SESSION["email"]=$row["email"];
          }else{
            $output='{"status":"failure", "remark":"Something is wrong with query"}';
          }
        }else{
          $output='{"status":"failure", "remark":"Your account is not verified, please verify your account"}';
        }
      }else{
        $output='{"status":"failure", "remark":"Sorry you are blocked by wryton"}';
      }
    }else{
      $output='{"status":"failure", "remark":"Invalid email or password recieved"}';
    }
  }else{
    $output='{"status":"failure", "remark":"Invalid or Incomplete password recieved"}';
  }
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete email recieved"}';
}

echo $output;
mysqli_close($con);
?>