<?php  
session_regenerate_id(); 
include "inc.php"; 

 

 

if($_POST['forgotemail']!=''){ 
include "config/mail.php";

$mail=$_POST['forgotemail'];
 

$select='*'; 
$where='email="'.$mail.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$LoginUserDetails=mysqli_fetch_array($rs); 

$remail=$LoginUserDetails['email']; 
$reuserid=$LoginUserDetails['id']; 

if($remail!=''){


$subject='Reset Password Request - travCRM';
$description='You recently made a request to reset your password. Please click the link below to complete the process.<br><br><a href="'.$fullurl.'/reset-password.crm?u='.encode($reuserid).'">Reset now &gt;</a><br><br>travCRM Support';


$fromemail=''; 
$mailto=$remail; 
$mailsubject=$subject; 
$maildescription=$description; 

 
send_template_mail($fromemail,$mailto,$mailsubject,$maildescription,$ccmail);


header("Location: forgot-password.crm?resetpassdiv=1"); 
$resetpassdiv=1;
exit();
} else {
$passwordnotavalible=1;

}
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Forgot Password - <?php echo $systemname; ?></title>
<?php  include "headerinclude.php"; ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style>#loginwindoworcolor {

background-color: #<?php echo $loginColortwo; ?>;
 
}

 
</style>
</head>

<body style="overflow:hidden;" id="loginwindoworcolor">


<div style="width:700px; background-color:#FFFFFF; border-radius:5px; padding:0px; margin:5% auto 0%; overflow:hidden;    box-shadow: 0px 18px 40px #012d6340; height:474px;">

<div style=" width:60%; float:left;">
<div style="padding:40px 40px;">
 
<form method="post" name="loginform" id="loginform" action="" onsubmit="formValidation('loginform');return false">
<div id="loginboxw" style="padding-top:10px;">

<div style="text-align:center; margin-bottom:30px;"><img src="<?php echo $fullurl;?>images/weCare.png" height="50"  /></div>
<div style="text-align:center; margin-bottom:30px; font-size:25px; font-weight:500;">Forgot Password? </div>

<?php if($passwordnotavalible==1){ ?><div style="margin:10px 0px; color:#FF0000;">This email not registered</div><?php } ?>

<?php if($_REQUEST['resetpassdiv']!=1){ ?>
<div id="fieldsouter" style="text-align:left; padding-bottom:0px;"> 
<div style="font-weight:500; margin-bottom:3px;">Email</div>
  <input name="forgotemail" type="email" class="fields validate" id="forgotemail" autocomplete="off" displayname="Email" placeholder="Enter Your Registered Email" field_min_length='3'/>
   
  <input type="submit" class="bbuttonlogin" value="Submit" />

  
  <div class="keepsign" style="text-align:center; margin-top:30px;">
      <label  ><a href="login.crm">Back to login</a>
      </label>
  </div>

<div style="text-align:center; display:none;" id="sendlink"> Wait Please</div>
 
 
</div>
<?php } else { ?>
<div style="text-align:center; font-size:15px;">
  <p><strong>We have sent a reset password link<br /> 
    to your email address.</strong> <strong></strong><br />
    <br />
  <a href="login.crm">Back to login</a></p>
  </div>
<?php } ?>
</div>
</form>
</div>

</div>
<div style=" width:39%; float:right;"><img src="images/loginbgright.png"  style="width:100%; height:100%;"/></div>

</div>




 
</body>
</html>
