<?php
require_once '../../include/config.php';

$obj=(object)$_REQUEST;
$obj->status="1";
$obj->c_status="1";
$data=postList($obj);

echo $data;

mysqli_close($con);
?>