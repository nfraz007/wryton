<?php
require_once '../../include/config.php';

$obj=(object)$_REQUEST;
$obj->status="1";
$data=commentList($obj);

echo $data;

mysqli_close($con);
?>