<?php
require_once '../../include/config.php';

logincheck();
$user_id=$_SESSION["user_id"];

if(isset($_REQUEST["category_id"]) && $_REQUEST["category_id"]!=""){
	if(isset($_REQUEST["title"]) && $_REQUEST["title"]!=""){
		if(isset($_REQUEST["post"]) && $_REQUEST["post"]!=""){
			if(isset($_REQUEST["anonymous"]) && $_REQUEST["anonymous"]!=""){
				$category_id=numOnly($_REQUEST["category_id"]);
				$title=$_REQUEST["title"];
				$post=nl2br($_REQUEST["post"]);
				$anonymous=$_REQUEST["anonymous"];
				$datetime=date("Y-m-d H:i:s");
				$status=1;

				$query="select count(*) as count from wryton_category where status='1' and category_id='{$category_id}'";
				$result=mysqli_query($con,$query);
				if(mysqli_num_rows($result)==1){
					if(strlen($title)<=100){
						if(strlen($post)<=1000){
							if($anonymous=="0" || $anonymous=="1"){
								$query="insert into `wryton_post` (`category_id`,`user_id`,`anonymous`,`title`,`post`,`datetime`,`status`) values ('{$category_id}', '{$user_id}', '{$anonymous}', '{$title}', '{$post}', '{$datetime}', '{$status}')";
								if(mysqli_query($con,$query)){
									$output='{"status":"success", "remark":"successfully added"}';
								}else{
									$output='{"status":"failure", "remark":"Something is wrong with query"}';
								}
							}else{
								$output='{"status":"failure", "remark":"Invalid data recieved"}';
							}
						}else{
							$output='{"status":"failure", "remark":"Post must be less than 1000 charactors"}';
						}
					}else{
						$output='{"status":"failure", "remark":"Title must be less than 100 charactors"}';
					}
				}else{
					$output='{"status":"failure", "remark":"Something is wrong with the category"}';
				}
			}else{
				$output='{"status":"failure", "remark":"Please choose a valid option"}';
			}
		}else{
			$output='{"status":"failure", "remark":"Post cannot be empty"}';
		}
	}else{
		$output='{"status":"failure", "remark":"Title cannot be empty"}';
	}
}else{
	$output='{"status":"failure", "remark":"Invalid or Incomplete category recieved"}';
}
echo $output;

mysqli_close($con);
?>