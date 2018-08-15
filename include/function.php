<?php

function  upload_file($myfile,$dir,$max_file_size=102400)
{
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name']);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'];
    
    $file_size = $_FILES[$myfile]['size'];
    if ($_FILES[$myfile]['error'] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

     $info = getimagesize($_FILES[$myfile]['tmp_name']);
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }

    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}

function  upload_file_modified($myfile,$dir,$max_file_size=102400,$i)
{
    
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name'][$i]);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'][$i];
    
    $file_size = $_FILES[$myfile]['size'][$i];
    if ($_FILES[$myfile]['error'][$i] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

    $info = getimagesize($_FILES[$myfile]['tmp_name'][$i]);
    $mime   = $info['mime'];
  
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }
    
    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}


function deleteImage($path)
{
    global $hostname;
    $new_path=str_replace($hostname, "", $path);
    if(strlen($new_path)!=0)
    {
        return unlink("../../".$new_path);
        // return "inside";
    }
    return "0";
}
        
function redirect_to( $location = NULL ) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
}

function clean($input)
 {
  return preg_replace('/[^A-Za-z0-9 ]/', '', $input); // Removes special chars.
 }
function rinse($input)
{
    return preg_replace('/[^A-Za-z0-9\-,@.\ ]/', '', $input); // Removes special chars.
}

 function numOnly($input)
 {
  return preg_replace('/[^0-9 ]/', '', $input); // Removes special chars.
 }

function securityToken(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring.=$characters[rand(0, strlen($characters))];
        }
        return $randstring;
}

function userBlock(){
    $user=array('7');
    if(in_array($_SESSION["user_id"],$user) && PRODUCTION) die('{"status":"failure","remark":"Sorry, This function is disabled"}');
}

function logincheck()
{
    global $con;

    if(isset($_SESSION["user_id"]))
    {
        $output='{"status":"success"}';
    }
    elseif(isset($_REQUEST["user_id"]) && isset($_REQUEST["security_token"]))
    {    
        $query="select `security_token` from `wryton_user` where `id`='".$_REQUEST["user_id"]."'";
        $result=mysqli_query($con,$query);
        $row=mysqli_fetch_array($result);
        if($row["security_token"]==$_REQUEST["security_token"]){
            $output='{"status":"success"}';
        }
        else
            $output='{"status":"failure","remark":"Incorrect Security token. User id entered is '.$_REQUEST["user_id"].' and security token entere is '.$_REQUEST["security_token"].'"}';
    }
    else
    {
        $output='{"status":"failure","remark":"You are not login, Please login"}';
    }

    $obj=json_decode($output,true);

    if($obj['status']!="success")
        die($output);
}

function admincheck()
{
    if(!isset($_SESSION["user_type"])=="admin")
    {
        die("You are not authorized for this request");
    }
}

function userLoginCheck()
{
    $data=logincheck();
    $arr=json_decode($data);
    if($arr->status!="success"){
        header("Location: index.php");
        die();
    }
}

function getIPAddress()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    return $ip;
}

function postDetail($obj)
{
    global $con,$DATETIME_FORMAT;

    $post = array();
    if(isset($obj->post_id) && $obj->post_id!=""){
        $post_id=numOnly($obj->post_id);

        $query="select p.*,c.name as category_name, c.status as c_status from wryton_post p left join wryton_category c on p.category_id=c.category_id where p.post_id=".$post_id;
        if(isset($obj->status) && $obj->status!=""){
            $query.=" and p.status='".$obj->status."'";
        }
        if(isset($obj->c_status) && $obj->c_status!=""){
            $query.=" and c.status='".$obj->status."'";
        }
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1){
            $output='{"status":"success","post":';
            $row=mysqli_fetch_assoc($result);

            if($row["anonymous"]=="0"){
                //user is not annonemous
                $q="select fname,lname from wryton_user where user_id=".$row["user_id"];
                $res=mysqli_query($con,$q);
                $r=mysqli_fetch_assoc($res);
                $row["name"]=$r["fname"]." ".$r["lname"];
            }else{
                $row["name"]="Anonymous";
            }

            $row["date_time"]=date($DATETIME_FORMAT,strtotime($row["datetime"]));
            $post[]=$row;
            $output.=json_encode($post);
            $output.='}';
        }elseif(mysqli_num_rows($result)==0){
            $output='{"status":"failure","remark":"No such tour exist"}';
        }else{
            $output='{"status":"failure","remark":"Something is wrong with this post id"}';
        }
    }else{
        $output='{"status":"failure","remark":"Invalid or incomplete parameters received"}';
    }
    return $output;
}

function postList($obj)
{
    global $con,$DATETIME_FORMAT;
    $post=array();

    $query="select p.*, c.name as category_name, c.status as c_status from `wryton_post` p left join wryton_category c on p.category_id=c.category_id where ";

    if(isset($obj->user_id) && $obj->user_id!=""){
        $query.=" p.user_id=".$obj->user_id." and ";
    }

    if(isset($obj->status) && $obj->status!=""){
        $query.=" p.status=".$obj->status." and ";
    }

    if(isset($obj->c_status) && $obj->c_status!=""){
        $query.=" c.status=".$obj->c_status." and ";
    }

    if(isset($obj->category_id) && $obj->category_id!=""){
        $query.=" p.category_id=".$obj->category_id." and ";
    }

    if(isset($obj->today) && $obj->today==1){
        $query.=" p.datetime> DATE_SUB(NOW(), INTERVAL 1 DAY) and ";
    }

    if(isset($obj->week) && $obj->week==1){
        $query.=" p.datetime> DATE_SUB(NOW(), INTERVAL 1 WEEK) and ";
    }

    if(isset($obj->month) && $obj->month==1){
        $query.=" p.datetime> DATE_SUB(NOW(), INTERVAL 1 MONTH) and ";
    }

    if(isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.=" ( p.`title` like '%".$search."%' or p.`post` like '%".$search."%' ) and ";
    }

    $query.="1 order by p.`post_id` desc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    $title_len=50;
    $post_len=300;
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            if($row["anonymous"]=="0"){
                //user is not annonemous
                $q="select fname,lname from wryton_user where user_id=".$row["user_id"];
                $res=mysqli_query($con,$q);
                $r=mysqli_fetch_assoc($res);
                $row["name"]=$r["fname"]." ".$r["lname"];
            }else{
                $row["name"]="Anonymous";
            }

            if(strlen($row["title"])>$title_len) 
                $row["title"]=substr($row["title"],0,$title_len)." ...";

            if(strlen($row["post"])>$post_len) 
                $row["post"]=substr($row["post"],0,$post_len)." ...";
            $row["date_time"]=date($DATETIME_FORMAT,strtotime($row["datetime"]));
            $post[] = $row;
        }
        $output='{"status":"success","post":';
        $output.=json_encode($post);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No post found"}';
    }
    return $output;
}

function categoryList($obj)
{
    global $con;
    $category=array();

    $query="select c.* from `wryton_category` c where ";

    if(isset($obj->status) && $obj->status!=""){
     $query.= "c.`status` = ".$obj->status." and ";
    }
     
    if (isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="c.`name` like '%".$search."%' and ";
    }

    $query.="1 order by c.`name` asc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $category[] = $row;
        }
        $output='{"status":"success","category":';
        $output.=json_encode($category);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No Category found"}';
    }
    return $output;
}

function categoryDetail($obj)
{
    global $con;
    $category_list=array();

    if(isset($obj->category_id) && $obj->category_id!=""){
        $category_id=numOnly($obj->category_id);

        $query="select * from `wryton_category` where `category_id`=".$category_id;
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1){
            while ($row = mysqli_fetch_assoc($result)){
                $category_list[] = $row;
            }
            $output='{"status":"success","category":';
            $output.=json_encode($category_list);
            $output.="}";
        }elseif(mysqli_num_rows($result)==0){
            $output='{"status":"failure","remark":"Sorry, no such category exist"}';
        }else{
            $output='{"status":"failure","remark":"Something is wrong with the category id"}';
        }
    }else{
        $output='{"status":"failure","remark":"Invalid or incomplete category id recieved"}';
    }
    return $output;
}

function commentList($obj){
    global $con,$DATETIME_FORMAT;
    $comment=array();

    $query= "select c.*,u.fname,u.lname from `wryton_comment` c left join `wryton_user` u on c.user_id=u.user_id where ";

    if(isset($obj->user_id) && $obj->user_id!=""){
     $query.= "c.user_id=".$obj->user_id." and ";
    }

    if(isset($obj->status) && $obj->status!=""){
     $query.= "c.`status` = ".$obj->status." and ";
    }

    if(isset($obj->post_id) && $obj->post_id!=""){
     $query.= "c.`post_id` = ".$obj->post_id." and ";
    }
     
    if (isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="c.`title` like '%".$search."%' and ";
    }

    $query.="1 order by c.`datetime` desc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["date_time"]=date($DATETIME_FORMAT,strtotime($row["datetime"]));
            $comment[] = $row;
        }
        $output='{"status":"success","comment":';
        $output.=json_encode($comment);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No Comment found"}';
    }
    return $output;
}

function userList($obj){
    global $con,$DATETIME_FORMAT;
    $user=array();

    $query="select * from `wryton_user` where ";

    if(isset($obj->status) && $obj->status!=""){
     $query.= "`status` = ".$obj->status." and ";
    }

    if(isset($obj->verified) && $obj->verified!=""){
     $query.= "`verified` = ".$obj->verified." and ";
    }
     
    if (isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="`fname` like '%".$search."%' and ";
    }

    $query.="1 order by `id` desc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $user[] = $row;
        }
        $output='{"status":"success","user":';
        $output.=json_encode($user);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No User found"}';
    }
    return $output;
}

function userDetail($obj)
{
    global $con,$DATETIME_FORMAT;

    $user = array();
    if(isset($obj->user_id) && $obj->user_id!=""){
        $user_id=numOnly($obj->user_id);

        $query="select * from wryton_user where user_id=".$user_id;
        if(isset($obj->status) && $obj->status!=""){
            $query.=" and status='".$obj->status."'";
        }
        if(isset($obj->verified) && $obj->verified!=""){
            $query.=" and verified='".$obj->verified."'";
        }
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1){
            $output='{"status":"success","user":';
            $row=mysqli_fetch_assoc($result);

            $user[]=$row;
            $output.=json_encode($user);
            $output.='}';
        }elseif(mysqli_num_rows($result)==0){
            $output='{"status":"failure","remark":"No such User exist"}';
        }else{
            $output='{"status":"failure","remark":"Something is wrong with this user id"}';
        }
    }else{
        $output='{"status":"failure","remark":"Invalid or incomplete parameters received"}';
    }
    return $output;
}

function crypto($action, $string) {
    //for encrypt e, for decrypt d
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'askjhSVSanckanSVSja353aRG5aSGSSasdSaSGSGSGsS3Sf5adS';
    $secret_iv = '3S5S53sgsgssdJgs5gs3gHs6sg5shfg3fJfdJhdh3Hdfgfh2hds';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' || $action=="e" ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' || $action=="d" ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

?>