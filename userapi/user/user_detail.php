<?php
require_once '../../include/config.php';

logincheck();

$user = array();
$user_id=numOnly($_SESSION["user_id"]);

$query="select * from `wryton_user` where user_id='{$user_id}'";
$result=mysqli_query($con,$query);
$row_count=mysqli_num_rows($result);
if($row_count==0){
	$output='{"status":"failure", "remark":"No such user exist"}';
}elseif($row_count==1){
	$row=mysqli_fetch_assoc($result);
	$row["password"]="";
	$user[]=$row;
	$output='{"status":"success", "user":'.json_encode($user).'}';
}else{
	$output='{"status":"failure", "remark":"Something is wrong"}';
}

echo $output;
mysqli_close($con);
   
?>