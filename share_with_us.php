<?php require_once 'header.php'; ?>

<?php 
$obj=new stdClass();
$obj->status="1";
$category=json_decode(CategoryList($obj));
?>

<div class="container-fluid w3-teal">
	<div class="w3-padding-48"></div>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6 w3-container">
			<div class="w3-row w3-panel">
				<h5>Category</h5>
				<select class="w3-select w3-teal w3-border-white w3-text-white" id="category_id">
					<?php
						for($i=0;$i<sizeof($category->category);$i++){
							echo '<option value="'.$category->category[$i]->category_id.'">'.$category->category[$i]->name.'</option>';
						}
					?>
				</select>
			</div>
			<div class="w3-row w3-panel">
				<label>Title</label>
				<input class="w3-input w3-teal w3-border-white" id="title" type="text">
			</div>
			<div class="w3-row w3-panel">
				<label>Your Experience</label>
				<textarea id="post" class="w3-input w3-teal w3-border-white w3-text-white" rows="6"></textarea>
			</div>
			<div class="w3-row w3-panel">
				<label>Want to share your name ?</label>
				<input class="w3-radio" type="radio" name="anonymous" id="anonymous" value="0" checked>
				<label>Yes</label>

				<input class="w3-radio" type="radio" name="anonymous" id="anonymous" value="1">
				<label>No</label>
			</div>
			<div class="w3-row w3-center w3-panel">
				<button class="w3-btn" id="share_btn">Share This Post</button>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
	<div class="w3-padding-48"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>
$("document").ready(function(){

});

$("#share_btn").click(function(){
	var category_id=$("#category_id").val();
	var title=$("#title").val();
	var post=$("#post").val();
	var anonymous=$('input:radio[name=anonymous]:checked').val();
	$.post("userapi/post/post_add.php",
	{
		category_id:category_id,
		title:title,
		post:post,
		anonymous:anonymous
	},function(data){
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			swal("Success",arr["remark"],"success");
		}else{
			swal("Error",arr["remark"],"error");
		}
	});
});
</script>
