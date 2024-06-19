<?php 
// this file should not be part of config folder pls check 
// should be in root folder
include "inc.php";
include "config/logincheck.php";
$activeleftmenuID=79;

 
 
$select='';
$where='';
$rs='';  
$select='*'; 
$where='userid='.$_SESSION['userid'].'';
$rs=GetPageRecord($select,_mailserver_master_,$where);
$resultpage=mysql_fetch_array($rs); 
 
  
 

if($resultpage['userid']!=$_SESSION['userid'] && $_POST['email']!='' && $_POST['password']!=''){
$namevalue='';

$from_name=clean($_POST['from_name']);
$email=clean($_POST['email']);
$password=clean($_POST['password']);
$smtp_server=clean($_POST['smtp_server']);
$port=clean($_POST['port']);
$security_type=clean($_POST['security_type']); 
$userid=$_SESSION['userid']; 
$adddate=date('Y-m-d H:i:s');

$namevalue ='userid="'.$userid.'",from_name="'.$from_name.'",email="'.$email.'",password="'.$password.'",smtp_server="'.$smtp_server.'",port="'.$port.'",security_type="'.$security_type.'",adddate="'.$adddate.'"'; 
$add = addlisting(_mailserver_master_,$namevalue); 

$errormsg='Successfully Saved!';
}



if($resultpage['userid']==$_SESSION['userid'] && $_POST['email']!='' && $_POST['password']!=''){
$namevalue='';
$where='userid='.$_SESSION['userid'].'';

$from_name=clean($_POST['from_name']);
$email=clean($_POST['email']);
$password=clean($_POST['password']);
$smtp_server=clean($_POST['smtp_server']);
$port=clean($_POST['port']);
$security_type=clean($_POST['security_type']); 
$userid=$_SESSION['userid']; 
$adddate=date('Y-m-d H:i:s');

$namevalue ='from_name="'.$from_name.'",email="'.$email.'",password="'.$password.'",smtp_server="'.$smtp_server.'",port="'.$port.'",security_type="'.$security_type.'",adddate="'.$adddate.'"';

 $add = updatelisting(_mailserver_master_,$namevalue,$where);
$errormsg='Successfully Saved!';

}

 
$select='';
$where='';
$rs='';  
$select='*'; 
$where='userid='.$_SESSION['userid'].'';
$rs=GetPageRecord($select,_mailserver_master_,$where);
$resultpage=mysql_fetch_array($rs); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mail Server Setting - <?php echo $systeminfo['systemname']; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script> 
<script type="text/javascript" src="js/system_function.js"></script> 
<script type="text/javascript" src="js/tablesortingjquery.js"></script>
<script src="js/jquery.searchableSelect.js"></script>
<script src="js/validation.js"></script> 
 

  

</head>

<body>


 <?php include("header_top.php"); ?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="4%" align="left" valign="top" id="leftouter">
    
    
    <?php include("left.php"); ?>
    
    
    
    </td>
    <td width="96%" align="left" valign="top">
	<div class="innertop">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="50%" align="left" valign="top"><h1>Mail Server Setting </h1>
              <div class="brdc"><span><a href="<?php echo $fullurl; ?>">Dashboard</a> - Mail Server Setting</span></div></td>
          <td width="50%" align="right" valign="bottom">  
    
            
			  
			  
			  
			   </td>
        </tr>
      </table>
	</div>
	
	<div class="row1"><div class="whitebox"> 
		  
		 
		 
		<div class="grayheader">Update Mail Server Setting </div>

		<form method="post" name="savefrm" id="savefrm" onsubmit="formValidation('savefrm');return false">
		<div class="formsection"><?php if($errormsg!=''){ ?><div class="truemsg"><?php echo $errormsg; ?></div><?php } ?>
		  
		    <div class="col3">
		 From Name<span class="mindatory">*</span>
		 <input type="text" name="from_name" id="from_name"  class="validate"  displayname="From Name" field_min_length='3' value="<?php echo strip($resultpage['from_name']); ?>"  />
		 </div>
		    <div class="col3">
		 Email<span class="mindatory">*</span>
		 <input name="email" type="text"  class="validate" id="email" value="<?php echo strip($resultpage['email']); ?>"  displayname="Email" field_min_length='3'  />
		 </div>
		 
		  
		 <div class="col3">
		 Password<span class="mindatory">*</span>
		   <input type="password" name="password" id="password"   class="validate"  displayname="Password" field_min_length='5' value="<?php echo strip($resultpage['password']); ?>" />
		 </div><div class="col3">
		 SMTP Srever<span class="mindatory">*</span>
		   <input type="text" name="smtp_server" id="smtp_server" class="validate" value="<?php echo strip($resultpage['smtp_server']); ?>"  displayname="SMTP Srever" field_min_length='6'  />
		 </div>
		 <div class="col5" style="width:100px;">
		 Port<span class="mindatory">*</span>
		   <input type="phone" maxlength="4" name="port" id="port" class="validate" value="<?php echo strip($resultpage['port']); ?>"  displayname="Port" field_min_length='1'  />
		 </div>
		 <div class="col5" style="width:100px;">
		 Security Type<span class="mindatory">*</span>
		   <select id="security_type" name="security_type" class="validate"  displayname="Security Type" autocomplete="off" >
<option value="0">Choose</option> 
 
<option value="false" <?php if('false'==$resultpage['security_type']){ ?>selected="selected"<?php } ?>>None</option>
<option value="true" <?php if('true'==$resultpage['security_type']){ ?>selected="selected"<?php } ?>>SSL</option>
 
</select>
		 </div>
		 <div class="col3" style="display:none;">
		 Discount Limit (%) 
		   <input type="text" name="discountlimit" id="discountlimit" value="<?php echo strip($resultpage['discountLimit']); ?>"  />
		 </div>
		 </div>
		 <div class="savebuttondiv"><a href="<?php echo decode($_GET['page']); ?>"><input type="submit"  name="Submit2" id="submitbtn" value="          Save          " class="darkbluebutton" />
          </a>
		  
		 </div>
		  </form>
		</div></div>
        
         <?php include("footer.php"); ?>
       
	</td>
  </tr>
</table>

</body>
</html>
