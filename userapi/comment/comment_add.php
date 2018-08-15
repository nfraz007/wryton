<?php
require_once '../../include/config.php';

logincheck();
$user_id=$_SESSION["user_id"];

if(isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]!=""){
	if(isset($_REQUEST["comment"]) && $_REQUEST["comment"]!=""){
		$post_id=numOnly($_REQUEST["post_id"]);
		$comment=nl2br($_REQUEST["comment"]);
		$datetime=date("Y-m-d H:i:s");
		$status=1;
		$query="insert into `wryton_comment` (`user_id`,`post_id`,`comment`,`datetime`,`status`) values ('{$user_id}', '{$post_id}', '{$comment}', '{$datetime}', '{$status}')";
		if(mysqli_query($con,$query)){
			$output='{"status":"success", "remark":"successfully added"}';
		}else{
			$output='{"status":"failure", "remark":"Something is wrong with query"}';
		}
	}else{
		$output='{"status":"failure", "remark":"Comment can not be empty"}';
	}
}else{
	$output='{"status":"failure", "remark":"Incomplete or Invalid data recieved"}';
}
echo $output;

mysqli_close($con);
?>