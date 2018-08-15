<?php require_once 'header.php'; ?>

<div class="container">
	<div class="w3-padding-32"></div>
	<div class="w3-row">
		<div class="w3-col l6 m6 s12">
			<h5>Profile Settings</h5>
		</div>
		<div class="w3-col l6 m6 s12">
			<div class="w3-row">
				<label>Email</label>
				<input class="w3-input" id="email" type="text" disabled>
			</div>
			<div class="w3-row">
				<label>First Name</label>
				<input class="w3-input" id="fname" type="text">
			</div>
			<div class="w3-row">
				<label>Last Name</label>
				<input class="w3-input" id="lname" type="text">
			</div>
			<div class="w3-row w3-center w3-panel">
				<button class="w3-btn" id="profile_btn">Update</button>
			</div>
		</div>
	</div>
	<hr>
	<div class="w3-row">
		<div class="w3-col l6 m6 s12">
			<h5>Password Settings</h5>
		</div>
		<div class="w3-col l6 m6 s12">
			<div class="row w3-tiny w3-center w3-text-red">
	          <p>Sorry, This is disabled in demo</p>
	        </div>
			<div class="w3-row">
				<label>Old Password</label>
			  	<input class="w3-input" id="old_password" type="password">
			</div>
			<div class="w3-row">
				<label>New Password</label>
			  	<input class="w3-input" id="new_password" type="password">
			</div>
			<div class="w3-row">
				<label>Confirm New Password</label>
			  <input class="w3-input" id="new_c_password" type="password">
			</div>
			<div class="w3-row w3-center w3-panel">
				<button class="w3-btn" id="password_btn">Update</button>
			</div>
		</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>

$("document").ready(function(){
	get_data();
});

function get_data(){
	$.post("userapi/user/user_detail.php",
	{

	},function(data){
		// console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$("#email").val(arr["user"][0]["email"]);
			$("#fname").val(arr["user"][0]["fname"]);
			$("#lname").val(arr["user"][0]["lname"]);
		}else{
			swal("Error",arr["remark"],"error");
		}
	});
}

$("#profile_btn").click(function(){
	var fname = $("#fname").val();
	var lname = $("#lname").val();

	if(fname!=""){
		if(lname!=""){
			$.post("userapi/user/update_profile.php",
				{
					fname:fname,
					lname:lname
				},function(data){
					//console.log(data);
					var arr=JSON.parse(data);
					if(arr["status"]=="success"){
						get_data();
						swal("Success",arr["remark"],"success");
					}else{
						swal("Error",arr["remark"],"error");
					}
				});
		}else{
			swal("Error","Last Name is empty","error");
		}
	}else{
		swal("Error","First Name is empty","error");
	}
});

$("#password_btn").click(function(){
	var old_password = $("#old_password").val();
	var new_password = $("#new_password").val();
	var new_c_password = $("#new_c_password").val();

	if(old_password!=""){
		if(new_password!=""){
			if(new_c_password!=""){
				if(old_password.length>=6 && new_password.length>=6 && new_c_password.length>=6){
					if(new_password==new_c_password){
						$.post("userapi/user/update_password.php",
							{
								old_password:old_password,
								new_password:new_password,
								new_c_password:new_c_password
							},function(data){
								//console.log(data);
								var arr=JSON.parse(data);
								if(arr["status"]=="success"){
									$("#old_password").val("");
									$("#new_password").val("");
									$("#new_c_password").val("");
									swal("Success",arr["remark"],"success");
								}else{
									swal("Error",arr["remark"],"error");
								}
							});
					}else{
						swal("Error","Confirm new password is not same","error");
					}
				}else{
					swal("Error","Password must contain atleast 6 characters","error");
				}
			}else{
				swal("Error","Confirm New Password is empty","error");
			}
		}else{
			swal("Error","New Password is empty","error");
		}
	}else{
		swal("Error","Old Password is empty","error");
	}
});

</script>