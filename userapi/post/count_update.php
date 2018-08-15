<?php
require_once '../../include/config.php';

$out='{';
$count=0;
$query="select count(*) as count from `wryton_post` p left join `wryton_category` c on p.category_id=c.category_id where p.datetime> DATE_SUB(NOW(), INTERVAL 1 DAY) and p.`status`=1 and c.`status`=1";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$count=$row["count"];

$out.='"today":"'.$count.'", ';

$query="select count(*) as count from `wryton_post` p left join `wryton_category` c on p.category_id=c.category_id where p.datetime> DATE_SUB(NOW(), INTERVAL 1 WEEK) and p.`status`=1 and c.`status`=1";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$count=$row["count"];

$out.='"week":"'.$count.'", ';

$query="select count(*) as count from `wryton_post` p left join `wryton_category` c on p.category_id=c.category_id where p.datetime> DATE_SUB(NOW(), INTERVAL 1 MONTH) and p.`status`=1 and c.`status`=1";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$count=$row["count"];

$out.='"month":"'.$count.'"';

$out.='}';
echo $out;

mysqli_close($con);
?>