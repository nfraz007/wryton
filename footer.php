<div class="w3-container w3-padding-12 w3-center w3-teal">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-3"><h5>Stay in touch</h5></div>
                <div class="col-sm-6"><input class="w3-input w3-border w3-text-teal" type="text" placeholder="Enter your Email address"></div>
                <div class="col-sm-3"><button class="w3-btn w3-ripple w3-hover-text-teal">SUBSCRIBE</button></div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
<!-- <div class="container-fluid w3-container w3-padding-24 w3-center" style="background: #111111">
    <div class="col-sm-3 col-xs-0"></div>
    <div class="col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-xs-1 w3-center"></div>
            <div class="col-xs-2 w3-center">
                <img  src="Icons/facebook.png" class="img-responsive">
            </div>
            <div class="col-xs-2 w3-center">
                <img  src="Icons/twitter.png" class="img-responsive">
            </div>
            <div class="col-xs-2 w3-center">
                <img  src="Icons/insta.png" class="img-responsive">
            </div>
            <div class="col-xs-2 w3-center">
                <img  src="Icons/g+.png" class="img-responsive">
            </div>
            <div class="col-xs-2 w3-center">
                <img  src="Icons/pin.png" class="img-responsive">
            </div>
            <div class="col-xs-1 w3-center"></div>
        </div>
    </div>
    <div class="col-sm-3 col-xs-0"></div>
</div> -->
<div class="w3-row">
    <div class="w3-third w3-black w3-padding-64 w3-center">
        <p class="w3-text-white w3-hover-text-teal">The Team</p>
    </div>
    <div class="w3-third w3-black w3-padding-64 w3-center">
        <p class="w3-text-white w3-hover-text-teal">Contact Us</p>
    </div>
    <div class="w3-third w3-black w3-padding-64 w3-center">
        <p class="w3-text-white w3-hover-text-teal">Blog</p>
    </div>
</div>
<div class="w3-row w3-teal">
    <p>Created by <a href="http://nfraz.co.nf" target="_blank">Nazish Fraz</a></p>
</div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
$('document').ready(function(){
    $('#login_sign_in').click(function(){
        if(login_validation()){
            $.post("userapi/user/login.php",
            {
                email:$("#login_email").val(),
                password:$("#login_password").val()
            },function(data){
                //console.log(data);
                var arr=JSON.parse(data);
                if(arr["status"]=="success"){
                    //successfully created the account
                    $("#login_email").val("");
                    $("#login_password").val("");
                    //swal("Success",arr["remark"],"success");
                    location.reload();
                }else{
                    swal("Error",arr["remark"],"error");
                }
            });
        }
    });
    $('#login_email').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login_sign_in').click();//Trigger search button click event
        }
    });
    $('#login_password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login_sign_in').click();//Trigger search button click event
        }
    });
});

function login_validation(){
    var msg="";
    var email=$("#login_email").val();
    var password=$("#login_password").val();
    var email_pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    if(email==""){
        msg="Please Enter your Email";
    }else if(!email_pattern.test(email)){
        msg="Please Enter a correct email address";
    }else if(password==""){
        msg="Please Enter your Password";
    }else if(password.length<6){
        msg="Password must be atleast 6 characters";
    }else msg="";

    if(msg!=""){
        swal("Warning",msg,"warning");
        return false;
    }
    else return true;
}
</script>