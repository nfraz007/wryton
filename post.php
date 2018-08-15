<?php require_once 'header.php'; ?>
<?php
if(!isset($_REQUEST["id"]) || $_REQUEST["id"]==""){
	header("Location: index");
}
$post_id=numOnly($_REQUEST["id"]);
?>

<div class="container-fluid">
	<div class="w3-padding-24"></div>
	<div class="row w3-black">
		<div class="col-sm-8 w3-teal w3-padding-jumbo">
			<div class="row w3-padding-16">
				<div class="col-sm-2">
					<img src="image/image/default.png" class="img-responsive" style="width: 100%">
				</div>
				<div class="col-sm-10">
					<h1 id="user_name"></h1>
				</div>
			</div>
			<div class="row w3-padding-4">
				<h3 id="post_title"></h3>
			</div>
			<div class="row w3-padding-4 w3-text-black w3-small">
				<p id="datetime"></p>
			</div>
			<div class="row w3-padding-4 w3-justify">
				<p id="post"></p>
			</div>
			<div class="w3-padding-64"></div>
		</div>
		<div class="col-sm-4 w3-black w3-padding-jumbo">
			<div><h3>Comments</h3></div>
			<div class="row">
				<div class="col-xs-8">
					<textarea id="comment_text" class="w3-input w3-black w3-border-white w3-text-white" rows="1"></textarea>
				</div>
				<div class="col-xs-2">
					<button id="comment_btn" class="w3-btn w3-teal w3-ripple w3-hover-gray" >comment</button>
				</div>
			</div>
			<div id="comment_list"></div>
		</div>
	</div>
</div>

<?php require_once 'footer.php'; ?>

<script>
var post_id='<?=$post_id?>';
$("document").ready(function(){
	print_post();
	print_comment();
});

function print_post(){
	$.post("userapi/post/post_detail.php",
	{
		post_id:post_id
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			//update the data
			$("#user_name").html(arr["post"][0]["name"]);
			$("#post_title").html(arr["post"][0]["title"]);
			$("#datetime").html(arr["post"][0]["date_time"]);
			$("#post").html(arr["post"][0]["post"]);
			// $("#user_name").html(arr["post"][0]["name"]);
		}else{
			swal("Error",arr["remark"],"error");
			window.location="index.php";
		}
	});
}

function print_comment(){
	$.post("userapi/comment/comment_list.php",
	{
		post_id:post_id
	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			//update the comment list
			var out="";
			for(i=0;i<arr["comment"].length;i++){
				out+='<hr><div class="row">';
					out+='<div class="col-xs-3">';
						out+='<img src="image/image/default.png" class="img-responsive">';
					out+='</div>';
					out+='<div class="col-xs-9">';
						out+='<p class="w3-hover-text-teal">'+arr["comment"][i]["fname"]+" "+arr["comment"][i]["lname"]+'</p>';
						out+='<p class="w3-small">'+arr["comment"][i]["comment"]+'</p>';
					out+='</div>';
				out+='</div>';
			}
			$("#comment_list").html(out);
		}else{
			$("#comment_list").html(arr["remark"]);
		}
	});
}

$("body").on("click","#comment_btn",function(){
	$("#comment_btn").prop("disabled",true);
	if($("#comment_text").val()!=""){
		$.post("userapi/comment/comment_add.php",
		{
			post_id:post_id,
			comment:$("#comment_text").val()
		},function(data){
			// console.log(data);
			var arr=JSON.parse(data);
			if(arr["status"]=="success"){
				$("#comment_text").val("");
				print_comment();
			}else{
				swal("Error",arr["remark"],"error");
			}
		});
	}else{
		swal("Warning","Comment box can not be empty","warning");
	}
	$("#comment_btn").prop("disabled",false);
});
</script>