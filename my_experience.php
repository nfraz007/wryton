<?php require_once 'header.php'; ?>

<div class="container-fluid w3-black">
	<div class="row">
		<div class="col-sm-3 w3-padding-48">
			<div>
				<h4>My Experience</h4>
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
	</div>
	<div class="w3-padding-48"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>
var page=parseInt($("#page").val());

$("body").ready(function(){
	search_post(page);
});

function search_post(page=1){
	$.ajax({
        type: 'POST',
        url: 'userapi/user/user_post.php',
        data: {
        	page:page,
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

$("body").on("click","#load_more",function(){
	page=parseInt($("#page").val())+1;
	$("#load_more").prop("disabled",true);
	search_post(page);
	$("#page").val(page);
});

</script>