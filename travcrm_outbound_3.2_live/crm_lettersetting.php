<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
 
if(trim($_POST['editedityes'])=='1' && trim($_POST['companyname'])!='' && trim($_POST['editId'])!=''){ 
 
$companyname=addslashes($_POST['companyname']);
$readdress=addslashes($_POST['readdress']);
$repolicies=addslashes($_POST['repolicies']);
$recompanyname=addslashes($_POST['recompanyname']);
$phone=addslashes($_POST['phone']);
$email=addslashes($_POST['email']);
$website=addslashes($_POST['website']); 
$termscondition=addslashes($_POST['policies']); 
$oldlogo=addslashes($_POST['oldlogo']); 

if($_FILES['logo']['name']!=''){
$file_name=time().$_FILES['logo']['name'];  
copy($_FILES['logo']['tmp_name'],"dirfiles/".$file_name);
$oldlogo=$file_name;
}


$dateAdded=time();
 
$where='id=1'; 
$namevalue ='companyname="'.$companyname.'",phone="'.$phone.'",email="'.$email.'",website="'.$website.'",termscondition="'.$termscondition.'",logo="'.$oldlogo.'",recompanyname="'.$recompanyname.'",repolicies="'.$repolicies.'",readdress="'.$readdress.'"';
$update = updatelisting(lettersettings,$namevalue,$where); 
if($update=='yes'){
 
generateLogs(lettersettings,'update',$where);

  ?>
<script>
parent.window.location.href='showpage.crm?module=Lettersettings&alt=2';
</script> 
<?php
 exit();
}}


$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,lettersettings,$where1); 
$editresult=mysqli_fetch_array($rs1);

$repolicies=addslashes($editresult['repolicies']); 
$readdress=addslashes($editresult['readdress']); 
$recompanyname=addslashes($editresult['recompanyname']); 
$editcompanyname=addslashes($editresult['companyname']); 
$editphone=stripslashes($editresult['phone']); 
$editemail=stripslashes($editresult['email']);  
$editwebsite=stripslashes($editresult['website']); 
$editpolicies=stripslashes($editresult['termscondition']);   
$logo=stripslashes($editresult['logo']);   
?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#policies",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });


tinymce.init({

        selector: "#repolicies",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });



  tinymce.init({

        selector: "#pointsRememberText",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
         
        Update
        
          <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
            <td style="padding-right:20px;">&nbsp; </td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
<form action="" method="post" enctype="multipart/form-data" name="addeditfrm"  id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editvouchersetting" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Letter  Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	
	<div class="griddiv"> 
	<label>
	<div class="gridlable">Company Name <span class="redmind"></span></div>
	 
	 <input name="companyname" type="text" class="gridfield" id="companyname" displayname="Company Name" value="<?php echo $editcompanyname; ?>" maxlength="50" />
	 </label>
	</div>
	
	 
	
	<div class="griddiv"> 
	<label>
	<div class="gridlable">Email <span class="redmind"></span></div>
	 
	 <input name="email" type="email" class="gridfield" id="email" displayname="Email" value="<?php echo $editemail; ?>" maxlength="50" />
	 </label>
	</div>	
	
	<div class="griddiv"> 
	<label>
	<div class="gridlable">Change Company Logo   
	  <input name="oldlogo" type="hidden" id="oldlogo" value="<?php echo $logo; ?>" />
	</div>
	 
	 
	 <input name="logo" type="file" id="logo" style="margin-top:5px; width:100%;" />
	 </label>
	</div> <div class="griddiv"> 
	<label>
	 
	 <img src="download/<?php echo $logo; ?>" height="70" />	 </label>
	</div>  <div class="griddiv"> 
	<label>
	<div class="gridlable">Phone <span class="redmind"></span></div>
	 
	 <input name="phone" type="text" class="gridfield" id="phone" onkeyup="numericFilter(this);" displayname="Phone" value="<?php echo $editphone; ?>" maxlength="13" />
	 </label>
	</div>	  		</td>
    
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  >
	 
	  </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  >&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"  ></td>
    <td align="left" valign="top"  >&nbsp;</td>
  </tr>
  <tr>
    
  </tr>
  <tr>
    
    </tr>
  <tr>
    <td align="left" valign="top"  >&nbsp;</td>
    <td align="left" valign="top"  >&nbsp;</td>
  </tr>
</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="1" />
		 
		<input name="editedityes" type="hidden" id="editedityes" value="1" />		</td>
        <td><input name="addnewuserbtn" type="submit" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td style="padding-right:20px;">&nbsp; </td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<script>  

comtabopenclose('linkbox','op2');

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
}



function showDays(firstDate,secondDate){ 
                  var startDay = new Date(firstDate);
                  var endDay = new Date(secondDate);
                  var millisecondsPerDay = 1000 * 60 * 60 * 24;

                  var millisBetween = startDay.getTime() - endDay.getTime();
                  var days = millisBetween / millisecondsPerDay;

                  // Round down.
                  return ( Math.floor(days));

              }

 

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
   
  
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  } 
} 
</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
