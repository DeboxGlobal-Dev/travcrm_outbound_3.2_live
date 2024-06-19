<?php 
include "inc.php";
include "config/logincheck.php";
$activeleftmenuID=61;
 
$userid=$_SESSION['userid'];
 
if($_POST['addedit']=='add' && $_POST['subject']!=''){
$namevalue='';
$subject=clean($_POST['subject']);
$description=clean($_POST['description']);

$namevalue ='subject="'.$subject.'"';

$duplicate=checkduplicate(_email_templates_master_,'subject="'.$subject.'"');


$namevalue2 ='subject="'.$subject.'",description="'.$description.'", userid= "'.$userid.'", status=1';


if($duplicate=='no'){

 $add = addlisting(_email_templates_master_,$namevalue2);

if($add=='yes'){
 header("location:".decode($_POST['page'])."?action=add");
} 

} else {
$errormsg='Record already exist.';
}

}



if($_POST['addedit']=='edit' && $_POST['subject']!='' && $_POST['listid']!=''){
$namevalue='';
$subject=clean($_POST['subject']);
$description=clean($_POST['description']);

$listid=clean(decode($_POST['listid']));
$where='id='.$listid.'';
$namevalue ='subject="'.$subject.'"';

$namevalue2 ='subject="'.$subject.'",description="'.$description.'", userid= "'.$userid.'"';

$duplicate=checkduplicate(_email_templates_master_,'subject="'.$subject.'" and id!='.$listid.'');
if($duplicate=='no'){

$add = updatelisting(_email_templates_master_,$namevalue2,$where);
if($add=='yes'){
 header("location:".decode($_POST['page'])."?action=update");
} 

} else {
$errormsg='Record already exist.';
}

}




if($_GET['id']!='' && is_numeric(decode($_GET['id']))){ 
$select='';
$where='';
$rs='';  
$select='*';
$id=clean(decode($_GET['id']));
$where='id='.$id.'';
$rs=GetPageRecord($select,_email_templates_master_,$where);
$resultpage=mysqli_fetch_array($rs); 
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($_GET['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Email Templates - <?php echo $systeminfo['systemname']; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script> 
<script type="text/javascript" src="js/system_function.js"></script> 
<script type="text/javascript" src="js/tablesortingjquery.js"></script>
<script src="js/validation.js"></script> 

<script src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "#description",
        themes: "modern",   
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen" 
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
    });
    </script>

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
          <td width="50%" align="left" valign="top"><h1>Manage Email Templates </h1>
              <div class="brdc"><span><a href="<?php echo $fullurl; ?>">Dashboard</a> - <a href="<?php echo decode($_GET['page']); ?>">Manage Templates </a></span></div></td>
          <td width="50%" align="right" valign="bottom"><a href="<?php echo decode($_GET['page']); ?>"><input type="button" name="Submit2" value="Back" class="darkbluebutton" />
          </a>
            
			  
			  
			  
			   </td>
        </tr>
      </table>
	</div>
	
	<div class="row1"><div class="whitebox"> 
		  
		 
		 
		<div class="grayheader"><?php if($_GET['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Email Templates </div>

		<form method="post" name="savefrm" id="savefrm" onsubmit="formValidation('savefrm');return false">
		 <div class="formsection"><?php if($errormsg!=''){ ?><div class="errormsg"><?php echo $errormsg; ?></div><?php } ?>
		 <div class="col2">
		 Enter Subject Name<span class="mindatory">*</span>
		   <input type="text" name="subject" id="subject" class="validate"  displayname="Subject Name" field_min_length='3' value="<?php echo strip($resultpage['subject']); ?>"  />
		 </div>
		 
		 
		 	 <div class="col12">
		 Email Template (Description)<span class="mindatory">*</span>
		   <textarea name="description" rows="10"  class="validate" displayname="Email Description"   id="description"><?php echo strip($resultpage['description']); ?></textarea>
		    
		 </div>
		 
		 
		 </div>
		 <div class="savebuttondiv"><a href="<?php echo decode($_GET['page']); ?>"><input type="submit"  name="Submit2" id="submitbtn" value="          Save          " class="darkbluebutton" />
          </a>
		   <input name="addedit" type="hidden" id="addedit" value="<?php if($_GET['id']!=''){ echo 'edit'; } else { echo 'add'; }?>" />
		   <input name="listid" type="hidden" id="listid" value="<?php echo $_GET['id']; ?>" />
		   <input name="page" type="hidden" id="page" value="<?php echo $_GET['page']; ?>" />
		 </div>
		  </form>
		</div></div>
        
         <?php include("footer.php"); ?>
       
	</td>
  </tr>
</table>

</body>
</html>
