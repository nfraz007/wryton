<?php
require_once '../../include/config.php';

logincheck();

if(isset($_REQUEST["fname"]) && $_REQUEST["fname"]!=""){
	if(isset($_REQUEST["lname"]) && $_REQUEST["lname"]!=""){
		$user_id=numOnly($_SESSION["user_id"]);

		$fname=filter_var($_REQUEST["fname"],FILTER_SANITIZE_STRING);
    	$lname=filter_var($_REQUEST["lname"],FILTER_SANITIZE_STRING);
    	
    	$query="update `wryton_user` set `fname`='{$fname}', `lname`='{$lname}' where `user_id`=".$user_id;
    	$result=mysqli_query($con,$query);
    	if($result){
    		$_SESSION["fname"]=$fname;
        	$_SESSION["lname"]=$lname;
    		$output='{"status":"success", "remark":"Successfully updated"}';
    	}else{
    		$output='{"status":"failure", "remark":"Something is wrong"}';
    	}
	}else{
	  $output='{"status":"failure", "remark":"Invalid or Incomplete last name recieved"}';
	}
}else{
  $output='{"status":"failure", "remark":"Invalid or Incomplete first name recieved"}';
}

echo $output;
mysqli_close($con);
?>