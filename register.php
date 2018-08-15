<?php require_once 'header.php'; ?>

<div class="container-fluid w3-container w3-padding-128" style="background-image: url(image/register_bg.jpg);">
	<div class="w3-row w3-center w3-text-white w3-animate-bottom">
		<h3><b>REGISTRATION</b></h3>
	</div>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4 w3-white w3-padding-32 w3-animate-bottom">
			<div class="row w3-tiny w3-center w3-text-red">
	          <p>Sorry, Registration is disabled in demo</p>
	        </div>
			<div class="w3-row w3-padding-16">
				<div class="w3-half w3-container-fluid">
					<input class="w3-input w3-text-teal w3-center" type="text" id="fname" placeholder="First Name">
				</div>
				<div class="w3-half w3-container-fluid">
					<input class="w3-input w3-text-teal w3-center" type="text" id="lname" placeholder="Last Name">
				</div>
			</div>
			<div class="w3-padding-16">
				<input class="w3-input w3-text-teal w3-center" type="text" id="email" placeholder="Email">
			</div>
			<div class="w3-padding-16">
				<input class="w3-input w3-text-teal w3-center" type="password" id="password" placeholder="Password">
			</div>
			<div class="w3-padding-16">
				<input class="w3-input w3-text-teal w3-center" type="password" id="c_password" placeholder="Confirm Password">
			</div>
			<div class="w3-padding-16 w3-center">
                <button class="w3-btn w3-round w3-ripple w3-teal w3-text-white" id="sign_up">SIGN UP</button>
			</div>
			<div class="w3-padding-16 w3-small w3-center">
                <p class="w3-text-gray">Already have an account ? <a href="login.php" class="w3-text-indigo">Log in</a></p> 
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

<?php require_once 'footer.php'; ?>

<script>
$('document').ready(function(){
    $('#sign_up').click(function(){
        if(validation()){
        	$.post("userapi/user/register.php",
        	{
        		fname:$("#fname").val(),
        		lname:$("#lname").val(),
        		email:$("#email").val(),
        		password:$("#password").val()
        	},function(data){
        		// console.log(data);
        		var arr=JSON.parse(data);
        		if(arr["status"]=="success"){
        			//successfully created the account
        			$("#fname").val("");
        			$("#lname").val("");
        			$("#email").val("");
        			$("#password").val("");
        			$("#c_password").val("");
        			swal("Success",arr["remark"],"success");
        		}else{
        			swal("Error",arr["remark"],"error");
        		}
        	});
        }
    });
    $('#fname').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#sign_up').click();//Trigger search button click event
        }
    });
    $('#lname').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#sign_up').click();//Trigger search button click event
        }
    });
    $('#email').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#sign_up').click();//Trigger search button click event
        }
    });
    $('#password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#sign_up').click();//Trigger search button click event
        }
    });
    $('#c_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#sign_up').click();//Trigger search button click event
        }
    });
});

function validation(){
	var msg="";
	var fname=$("#fname").val();
	var lname=$("#lname").val();
	var email=$("#email").val();
	var password=$("#password").val();
	var c_password=$("#c_password").val();
	var email_pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

	if(fname==""){
		msg="Please Enter your First Name";
	}else if(lname==""){
		msg="Please Enter your Last Name";
	}else if(email==""){
		msg="Please Enter your Email";
	}else if(!email_pattern.test(email)){
		msg="Please Enter a correct email address";
	}else if(password==""){
		msg="Please Enter your Password";
	}else if(c_password==""){
		msg="Please Enter your Comfirm Password";
	}else if(password!=c_password){
		msg="Password & Comfirm password is not same";
	}else if(password.length<6 && c_password.length<6){
		msg="Password must be atleast 6 characters";
	}else msg="";

	if(msg!=""){
		swal("Warning",msg,"warning");
		return false;
	}
	else return true;
}
</script>