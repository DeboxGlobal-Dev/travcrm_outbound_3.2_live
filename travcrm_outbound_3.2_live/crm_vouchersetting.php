<?php

if($addpermission!=1 && $_GET['id']==''){
header('location:"'.$fullurl.'"');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:"'.$fullurl.'"');
}
 
if($_REQUEST['action']=='editvouchersetting' && trim($_POST['editedityes'])=='1' && trim($_POST['editId'])!=''){ 
  // echo "jhbddvcgdsvgvhgc";
  // exit();
// $sectionAction = $_REQUEST['action'];
$editId1=clean($_POST['editId']);
// $companyname=clean($_POST['companyname']);


$supplierdetail=clean($_POST['supplierdetail']);
$clientdetail=clean($_POST['clientdetail']);
$supccemail=clean($_POST['supccemail']);
$clientccemail=clean($_POST['clientccemail']);
$supgroupEmailId=clean($_POST['supgroupEmailId']);
$clientgroupEmailId=clean($_POST['clientgroupEmailId']);

// $policies=clean($_POST['policies']);
// $pointsRememberText=clean($_POST['pointsRememberText']);
// $paymentEmailid=clean($_POST['paymentEmailid']);
$supplierVoucherNoteText=clean($_POST['supplierVoucherNoteText']);
$supplierbillingInstructionText=clean($_POST['supplierbillingInstructionText']);
$clientVoucherNoteText=clean($_POST['clientVoucherNoteText']);
$clientbillingInstructionText=clean($_POST['clientbillingInstructionText']);


$dateAdded=time();
//  echo "testing";
$where='id="'.$editId1.'"'; 
echo $namevalue ='companyname="'.$companyname.'",clientccemail="'.$clientccemail.'",supccEmail="'.$supccemail.'",clientgroupEmailId="'.$clientgroupEmailId.'",supgroupEmailId="'.$supgroupEmailId.'",supplierVoucherNoteText="'.$supplierVoucherNoteText.'",clientVoucherNoteText="'.$clientVoucherNoteText.'",supplierbillingInstructionText="'.$supplierbillingInstructionText.'",clientbillingInstructionText="'.$clientbillingInstructionText.'",supplierStatus="'.$supplierdetail.'",clientStatus="'.$clientdetail.'"';
$update = updatelisting(_VOUCHER_SETTING_MASTER_,$namevalue,$where); 
echo "successfull  updated";
if($update=='yes'){
 
// generateLogs('vouchersetting','update',$where);

  ?>
<script>
    alert('Voucher Supplier Contact Details and Client Contact Details Updated...!');
    parent.window.location.href='showpage.crm?module=vouchersetting';
</script> 

<?php

//  exit();
}else{
  ?>
<script>
    alert('Voucher Supplier Contact Details and Client Contact Details Not Updated...!');
    parent.window.location.href='showpage.crm?module=vouchersetting';
</script> 

<?php
}

}


$select1='*';   
$where1='id= "1" '; 
$rs1=GetPageRecord($select1,_VOUCHER_SETTING_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);


$editId=clean($editresult['id']); 
$editcompanyname=clean($editresult['companyname']); 
$editclientccEmail=stripslashes($editresult['clientccemail']); 
$editsupccEmail=stripslashes($editresult['supccEmail']); 
$editsupgroupEmailId=stripslashes($editresult['supgroupEmailId']);
$editclientgroupEmailId=stripslashes($editresult['clientgroupEmailId']); 
$editpolicies=stripslashes($editresult['policies']); 
$supplierStatus=stripslashes($editresult['supplierStatus']); 
$clientStatus=stripslashes($editresult['clientStatus']); 
$paymentEmailid=stripslashes($editresult['paymentEmailid']); 
$editpointsRememberText=stripslashes($editresult['pointsRememberText']); 
$editSupplierVoucherNoteText=stripslashes($editresult['supplierVoucherNoteText']);
$editClientVoucherNoteText=stripslashes($editresult['clientVoucherNoteText']);
$editSupplierbillingInstructionText=stripslashes($editresult['supplierbillingInstructionText']);
$editClientbillingInstructionText=stripslashes($editresult['clientbillingInstructionText']);

?>


<!-- <script src="tinymce/tinymce.min.js"></script>

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

        selector: "#pointsRememberText",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script> -->
	
	
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
<div id="pagelisterouter">
<form action="<?php $_SERVER['PHP_SELF']; ?> " method="post" enctype="multipart/form-data" name="addeditfrm"  id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editvouchersetting" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <input name="module" type="hidden" id="module" value="<?php echo $_REQUEST['module']; ?>" /> 

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <!-- Supplier Contact  Details started -->
    <td style="padding-bottom: 10px">
      <h2>Supplier Contact  Details</h2>
      <div class="form-check">
        <table>
        <tr>
          <td >
            <span>Will Show</span><input style="display: block;margin-left: 67px;margin-top: -13px; " class="form-check-input position-static" type="radio" name="supplierdetail" id="supplierdetail"  <?php echo ($supplierStatus=='1')?'checked':'' ?> value="1" aria-label="...">
          </td>
          <td style="position: absolute;margin-left: 20px;">
          <span>Will Not Show</span><input style="display: block;    margin-left:87px;margin-top: -13px;" class="form-check-input position-static" type="radio" name="supplierdetail" id="supplierdetail"  <?php echo ($supplierStatus=='0')?'checked':'' ?> value="0" aria-label="...">
          </td>
        </tr>
        </table>
      </div>
    </td>
    <!-- Supplier Contact  Details ended -->
     <!-- Client Voucher Setting started -->
  <td style="padding-bottom: 10px; padding-left: 20px;">
      <h2>Client Contact  Details</h2>
      <div class="form-check">
        <table>
        <tr>
          <td>
            <span>Will Show</span><input style="display: block;margin-left: 67px;margin-top: -13px; " class="form-check-input position-static" type="radio" name="clientdetail" id="clientdetail" <?php echo ($clientStatus=='1')?'checked':'' ?> value="1" aria-label="...">
          </td>
          <td style="position: absolute;margin-left: 20px;">
          <span>Will Not Show</span><input style="display: block;margin-left:87px;margin-top: -13px;" class="form-check-input position-static" type="radio" name="clientdetail" id="clientdetail" <?php echo ($clientStatus=='0')?'checked':'' ?> value="0" aria-label="...">
          </td>
        </tr>
        </table>
      </div>
    </td>
  <!-- Client Voucher Setting ended -->
  </tr>

    

  <tr>
    
    <td align="left" valign="top" ><div class="innerbox">
      <h2>Supplier Voucher Setting</h2>
    </div>
  </td>
  <td align="left" valign="top" style="padding-left: 20px;"><div class="innerbox">

 
      <h2>Client Voucher Setting</h2>
    </div>
  </td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv"> 
	<label>
	<div class="gridlable">CC Email <span class="redmind"></span></div>
	 
	 <input name="supccemail" type="email" class="gridfield" id="supccemail" displayname="CC Email" value="<?php echo $editsupccEmail; ?>"/>
	 </label>
	</div>	

  <div class="griddiv"> 
	<label>
	<div class="gridlable">Group Email Id  <span class="redmind"></span></div>
	 
	 <input name="supgroupEmailId" type="text" class="gridfield" id="supgroupEmailId" displayname="Group Email Id" value="<?php echo $editsupgroupEmailId; ?>" maxlength="60" />
	 </label>
	</div>  	  		

  <div class="griddiv"><label>
  <div class="gridlable">Supplier Voucher Notes </div>
  <textarea name="supplierVoucherNoteText" class="gridfield" id="supplierVoucherNoteText" style="height: 90px;"><?php echo $editSupplierVoucherNoteText; ?></textarea>
  </label>
  </div>
  <div class="griddiv"><label>
  <div class="gridlable">Supplier Billing Instruction </div>
  <textarea name="supplierbillingInstructionText" class="gridfield" id="supplierbillingInstructionText" style="height: 90px;"><?php echo $editSupplierbillingInstructionText; ?></textarea>
  </label>
  </div>


</td>

    <td width="50%" align="left" valign="top" style="padding-left:20px;">	 	
    <div class="griddiv"> 
	<label>
	<div class="gridlable">CC Email <span class="redmind"></span></div>
	 
	 <input name="clientccemail" type="email" class="gridfield" id="clientccemail" displayname="Email" value="<?php echo $editclientccEmail; ?>" />
	 </label>
	</div>	

  <div class="griddiv"> 
	<label>
	<div class="gridlable">Group Email Id  <span class="redmind"></span></div>
	 
	 <input name="clientgroupEmailId" type="email" class="gridfield" id="clientgroupEmailId" displayname="Group Email Id" value="<?php echo $editclientgroupEmailId; ?>" maxlength="60" />
	 </label>
	</div>    


    <div class="griddiv"><label>
  <div class="gridlable">Client Voucher Notes </div>
  <textarea name="clientVoucherNoteText" class="gridfield" id="clientVoucherNoteText" style="height: 90px;"><?php echo $editClientVoucherNoteText; ?></textarea>
  </label>
  </div>

  <div class="griddiv"><label>
  <div class="gridlable">Client Billing Instruction </div>
  <textarea name="clientbillingInstructionText" class="gridfield" id="clientbillingInstructionText" style="height: 90px;"><?php echo $editClientbillingInstructionText; ?></textarea>
  </label>
  </div>

   </td>
  </tr>

</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo $editId ; ?>" />
		 
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
