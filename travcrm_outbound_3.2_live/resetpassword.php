<?php  
session_regenerate_id(); 
include "inc.php"; 

 

 

if($_POST['uid']!='' && $_POST['resetpassword']!=''){ 

$namevalue ='password="'.md5(addslashes($_POST['resetpassword'])).'"';  
$where='id="'.decode($_POST['uid']).'"';  
$update = updatelisting(_USER_MASTER_,$namevalue,$where); 
header("Location: reset-password.crm?rp=1"); 
exit();
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reset Password - <?php echo $systemname; ?></title>
<?php  include "headerinclude.php"; ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style>
#loginwindoworcolor {
background-color: #ffc115;
width: 61%;
height: 100%;
position: absolute;
right: -153px;
top: 0px;
-webkit-transform: skew(20deg);
-moz-transform: skew(20deg);
-o-transform: skew(20deg);
border-left: 15px #fff solid;
}

 
</style>
</head>

<body style="background-color:#2c2c2c; overflow:hidden;" class="loginleftcolorbg">
<div id="loginwindoworcolor" class="loginrightcolorbg"></div>
<div style="text-align:center; position:absolute; z-index:99; width:100%;">

<script>
function formsubmitrese(){ 
var userpass = $('#resetpassword').val().length;
var userpass2 = $('#resetpassword2').val().length;



if(userpass<6){
alert('Password must be at least 6 characters');
} else {


if(userpass==userpass2){
$('#loginform').submit();

} else {
alert('Password does not match the confirm password');
}

}

}

</script>


<form method="post" name="loginform" id="loginform" action=""  >
<div id="loginboxw" style="padding-top:10px;">
<div style="text-align:center; margin-bottom:10px; font-size:18px;">Reset Password </div>

<?php if($_REQUEST['rp']!=1){ ?>
<div id="fieldsouter" style="text-align:left; padding-bottom:0px;"> 
  <input name="resetpassword" type="password" class="fields validate" id="resetpassword" autocomplete="off" displayname="Password" style="background-image:url(images/passwordicon.png);background-position: 11px center;" placeholder="New Password" field_min_length='6'/>
   
  <input name="resetpassword2" type="password" class="fields validate" id="resetpassword2" autocomplete="off" displayname="Password" style="background-image:url(images/passwordicon.png);background-position: 11px center;" placeholder="Confirm  Password" field_min_length='6'/> 
   
  <div class="keepsign"><label style="float:left;"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    
    <td style="padding-left:5px;"><a href="login.crm">Back to login</a></td>
  </tr>
  
</table></label>
<input name="uid" type="hidden" id="uid" value="<?php echo $_REQUEST['u']; ?>" />
<input type="button" class="bbuttonlogin" value="Reset Password" style="width:auto;" onclick="formsubmitrese();" />
</div>
<div style="text-align:center; display:none;" id="sendlink"> Wait Please</div>
 
 
</div>
<?php } else { ?>
<div style="text-align:center; font-size:15px;">
  <p><strong>Password Reset Successfully</strong><strong></strong><br />
    <br />
  <a href="login.crm">Back to login</a></p>
  </div>
<?php } ?>
</div>
</form>
</div>
</body>
</html>
