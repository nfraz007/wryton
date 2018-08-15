<?php require_once 'header.php'; ?>

<?php 
$obj=new stdClass();
$obj->status="1";
$category=json_decode(CategoryList($obj));
?>

<div class="container-fluid w3-black">
	<div class="row">
		<div class="col-sm-3 w3-teal w3-padding-128">
			<div>
				<h4>Search Filter</h4>
			</div>
			<div class="w3-small">
				<p>Search for your result using the field below</p>
			</div>
			<div class="w3-padding-24"></div>
			<div>
				<input type="text" id="search" class="w3-input w3-teal w3-border-white w3-text-white" placeholder="Search">
			</div>
			<div class="w3-padding-8"></div>
			<div>
				<h5>Category</h5>
				<select class="w3-select w3-teal w3-border-white w3-text-white" id="category">
					<option value="">All</option>
					<?php
						for($i=0;$i<sizeof($category->category);$i++){
							echo '<option value="'.$category->category[$i]->category_id.'">'.$category->category[$i]->name.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-6 w3-container">
			<div class="w3-padding-48"></div>
			<div id="mylist">
				<div id="content_1"><center><i class="fa fa-spinner w3-center w3-text-teal w3-jumbo"></i></center></div>
			</div>
			<div class="w3-padding-16"></div>
			<div class="w3-center"><input type="hidden" class="w3-input w3-black " id="page" value="1"></div>
			<div class="w3-center"><button class="w3-btn w3-teal w3-ripple" id="load_more">Load more</button></div>
			<div class="w3-padding-48"></div>
		</div>
		<div class="col-sm-3 w3-teal w3-padding-128">
			<div>
				<h4>Trend</h4>
			</div>
			<div class="w3-small">
				<p>Click below to see the trend post</p>
			</div>
			<div class="w3-padding-24"></div>
			<a href="#">
			<div class="w3-row w3-hover-text-black">
				<div class="w3-col pull-right w3-right-align" style="width: 40%">
					<span class="w3-badge w3-large w3-animate-zoom"><div id="count_today">0</div></span>
				</div>
				<div class="w3-rest">
					<h5 class="w3-rest w3-ripple" id="today_tab">Todays</h5>
				</div>
				<input type="hidden" class="w3-input w3-black w3-text-white" id="today" value=0>
			</div>
			</a>
			<a href="#">
			<div class="w3-row w3-hover-text-black">
				<div class="w3-col pull-right w3-right-align" style="width: 40%">
					<span class="w3-badge w3-large w3-animate-zoom"><div id="count_week">0</div></span>
				</div>
				<div class="w3-rest">
					<h5 class="w3-rest w3-ripple" id="week_tab">This week</h5>
				</div>
				<input type="hidden" class="w3-input w3-black w3-text-white" id="week" value=0>
			</div>
			</a>
			<a href="#">
			<div class="w3-row w3-hover-text-black">
				<div class="w3-col pull-right w3-right-align" style="width: 40%">
					<span class="w3-badge w3-large w3-animate-zoom"><div id="count_month">0</div></span>
				</div>
				<div class="w3-rest">
					<h5 class="w3-rest w3-ripple" id="month_tab">This month</h5>
				</div>
				<input type="hidden" class="w3-input w3-black w3-text-white" id="month" value=0>
			</div>
			</a>
			<div class="w3-padding-8"></div>
			<!-- <div class="w3-row w3-hover-text-black">
				<div class="w3-col pull-right w3-right-align" style="width: 40%">
					<span class="w3-badge w3-large w3-animate-zoom">0</span>
				</div>
				<div class="w3-rest">
					<h5 class="w3-rest">Most Viewed</h5>
				</div>
			</div> -->
		</div>
	</div>
</div>

<?php require_once 'footer.php'; ?>

<script>
var page=parseInt($("#page").val());
$(document).ready(function(){
	$('#search_post').keyup(function(e) {
        if(e.which==13){ 
        	search_post(page,$("#search").val(),$("#category").val(),0,0,0);
        	count_update();
        }
    });
});

$("body").ready(function(){
	search_post(page,$("#search").val(),$("#category").val(),0,0,0);
	count_update();
});

function search_post(page=1,search="",category_id="",today=0,week=0,month=0){
	// console.log("page"+page+"today"+today+"week"+week+"month"+month);
	$.ajax({
        type: 'POST',
        url: 'userapi/post/post_list.php',
        data: {
        	page:page,
        	search:search,
        	category_id:category_id,
        	today:today,
        	week:week,
        	month:month,
        	limit:20
            },
        success: function(data) {
          	// console.log(data);
          	var i,out="";
			var arr=JSON.parse(data);
			if(arr["status"]=="success"){
				for(i=0;i<arr["post"].length;i++){
					out+='<a href="post.php?id='+arr["post"][i]["post_id"]+'">';
						out+='<div class="w3-card-12 w3-row w3-teal w3-display-container w3-hover-opacity w3-animate-zoom">';
							out+='<div class="w3-quarter w3-gray w3-center w3-padding-4">';
								out+='<img src="image/image/default.png" style="width: 50%" class="w3-padding-4">';
								out+='<h5>'+arr["post"][i]["name"]+'</h5>';
							out+='</div>';
							out+='<div class="w3-threequarter w3-teal w3-padding-small w3-small">'
								out+='<h5><b>'+arr["post"][i]["title"]+'</b></h5>';
								out+='<p>'+arr["post"][i]["post"]+'</p>';
							out+='</div>';
							out+='<div class="w3-display-middle w3-display-hover">';
    							// out+='<button class="w3-btn w3-animate-opacity">Posted on '+arr["post"][i]["date_time"]+'</button>';
 							out+='</div>';
						out+='</div>';
					out+='</a>';
					out+='<div class="w3-padding-16"></div>';
					$("#load_more").prop("disabled",false);
				}
				out+='<div id="content_'+(page+1)+'"></div>';
			}else{
				out+='<h2 class="w3-center w3-text-teal">No Post Found</h2>';
			}
			$("#content_"+page).html(out);
        }
    });
}

$("#search").keyup(function(e){
	if(e.which==13){
		$("#mylist").html('<div id="content_1"><center><i class="fa fa-spinner w3-center w3-text-teal w3-jumbo"></i></center></div>');
		$("#page").val(1);
		search_post(1,$("#search").val(),$("#category").val(),0,0,0);
	}
});

$("#category").change(function(){
	$("#mylist").html('<div id="content_1"><center><i class="fa fa-spinner w3-center w3-text-teal w3-jumbo"></i></center></div>');
	$("#page").val(1);
	search_post(1,$("#search").val(),$("#category").val(),0,0,0);
});

$("body").on('click',"#today_tab",function(){
	$("#mylist").html('<div id="content_1"><center><i class="fa fa-spinner w3-center w3-text-teal w3-jumbo"></i></center></div>');
	$("#page").val(1);
	$("#today").val(1);
	$("#week").val(0);
	$("#month").val(0);
	search_post(1,$("#search").val(),$("#category").val(),1,0,0);
});

$("body").on('click',"#week_tab",function(){
	$("#mylist").html('<div id="content_1"><center><i class="fa fa-spinner w3-center w3-text-teal w3-jumbo"></i></center></div>');
	$("#page").val(1);
	$("#today").val(0);
	$("#week").val(1);
	$("#month").val(0);
	search_post(1,$("#search").val(),$("#category").val(),0,1,0);
});

$("body").on('click',"#month_tab",function(){
	$("#mylist").html('<div id="content_1"><center><i class="fa fa-spinner w3-center w3-text-teal w3-jumbo"></i></center></div>');
	$("#page").val(1);
	$("#today").val(0);
	$("#week").val(0);
	$("#month").val(1);
	search_post(1,$("#search").val(),$("#category").val(),0,0,1);
});

function count_update(){
	$.post("userapi/post/count_update.php","",
		function(data){
			// console.log(data);
			var arr=JSON.parse(data);
			$("#count_today").text(arr["today"]);
			$("#count_week").text(arr["week"]);
			$("#count_month").text(arr["month"]);
	})
}

$("body").on("click","#load_more",function(){
	page=parseInt($("#page").val())+1;
	today=parseInt($("#today").val());
	week=parseInt($("#week").val());
	month=parseInt($("#month").val());
	$("#load_more").prop("disabled",true);
	search_post(page,$("#search").val(),$("#category").val(),today,week,month);
	$("#page").val(page);
	// console.log({today,week,month});
});

</script>