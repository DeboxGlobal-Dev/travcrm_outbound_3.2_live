<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
  
if($_GET['id']!=''){
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(decode($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_COMPLAINT_MASTER_,$where); 
$resultpaymentpage=mysqli_fetch_array($rs);  


$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultpaymentpage['queryId']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  
 
$select=''; 
$where=''; 
$rs='';   
$select='email';  
$where='id='.$resultpage['assignTo'].''; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$resultpageassignemail=mysqli_fetch_array($rs);



$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_QUERY_MAILS_SECTION_MASTER_,$where); 
$resultpageemail=mysqli_fetch_array($rs);  



$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultpage['companyId']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_CORPORATE_MASTER_,$where); 
$resultcompany=mysqli_fetch_array($rs);  
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
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

<style>
body{background-color:#eae9ee !IMPORTANT;}
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" valign="top"><div style="margin-top:67px;">
      <div class="complaintquyerbox">
	  <h1>Query</h1>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="33%" class="lightgraytextm">Query Id </td>
        <td width="3%" class="lightgraytextm">:</td>
        <td width="64%"><?php echo makeQueryId($resultpage['id']); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Query Date </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo showdate($resultpage['queryDate']); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Check In </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo showdate($resultpage['fromDate']); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Check Out </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo showdate($resultpage['toDate']); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Destination</td>
        <td class="lightgraytextm">:</td>
        <td><?php echo getDestination($resultpage['destinationId']); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Status</td>
        <td class="lightgraytextm">:</td>
        <td><?php if($resultpage['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; } if($resultpage['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultpage['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultpage['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultpage['queryStatus']==5){ echo '<div class="closequery">Deffered</div>'; }  if($resultpage['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; } ?></td>
      </tr>
      
    </table></td>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="33%" class="lightgraytextm">Adult </td>
        <td width="3%" class="lightgraytextm">:</td>
        <td width="64%"><?php echo $resultpage['adult']; ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Child </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo $resultpage['child']; ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Night</td>
        <td class="lightgraytextm">:</td>
        <td><?php echo $resultpage['night']; ?></td>
      </tr>
     <?php if($resultpage['guest1']!=''){ ?> <tr>
        <td class="lightgraytextm">Guest 1  </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo ($resultpage['guest1']); ?></td>
      </tr><?php } ?>
      <?php if($resultpage['guest2']!=''){ ?><tr>
        <td class="lightgraytextm">Guest 2 </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo ($resultpage['guest2']); ?></td>
      </tr><?php } ?>
      <tr>
        <td class="lightgraytextm">Priority</td>
        <td class="lightgraytextm">:</td>
        <td><?php if($resultpage['queryPriority']==1 || $resultpage['queryPriority']==0){ ?><div class="lowpire">Low</div><?php } ?><?php if($resultpage['queryPriority']==2){ ?><div class="mediampire">Medium</div><?php } ?><?php if($resultpage['queryPriority']==3){ ?><div class="highpire">High</div><?php } ?>
	</td>
      </tr>
      
      
    </table></td>
  </tr>
</table>

	  </div>
      <div class="complaintquyerbox">
	  <h1>Company</h1>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="33%" class="lightgraytextm">Company Name </td>
        <td width="3%" class="lightgraytextm">:</td>
        <td width="64%"><?php echo strip($resultcompany['name']); ?></td>
      </tr>
      <?php if($resultcompany['contactPerson']!=''){ ?><tr>
        <td class="lightgraytextm">Contact Person </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo $resultcompany['contactPerson']; ?></td>
      </tr><?php  }?>
      <tr>
        <td class="lightgraytextm">Located</td>
        <td class="lightgraytextm">:</td>
        <td><?php echo getCityName($resultcompany['cityId']); ?>, <?php echo getStateName($resultcompany['stateId']); ?>, <?php echo getCountryName($resultcompany['countryId']); ?></td>
      </tr>
      
    </table></td>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="33%" class="lightgraytextm">Contact No.  </td>
        <td width="3%" class="lightgraytextm">:</td>
        <td width="64%"><?php echo getPrimaryPhone($resultcompany['id'],'corporate'); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Email </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo getPrimaryEmail($resultcompany['id'],'corporate'); ?></td>
      </tr>
     <?php if($resultpage['guest1']!=''){ ?><?php } ?>
      <?php if($resultpage['guest2']!=''){ ?><?php } ?>
      
      
    </table></td>
  </tr>
</table>
	  </div>
      <div class="complaintquyerbox">
	  <h1>Supplier</h1>
	  <?php
	   if($resultpaymentpage['supplierId']!=''){
$id=$resultpaymentpage['supplierId'];

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);


$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']); 
$editcontactPerson=clean($editresult['contactPerson']);
$editcompanyTypeId=clean($editresult['companyTypeId']);
$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']); 
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$editid=clean($editresult['id']);
}
?>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="33%" class="lightgraytextm">Supplier Type </td>
        <td width="3%" class="lightgraytextm">:</td>
        <td width="64%"><?php echo getsuppliersType($editcompanyTypeId); ?></td>
      </tr>
    
      <tr>
        <td class="lightgraytextm">Supplier</td>
        <td class="lightgraytextm">:</td>
        <td><?php echo strip($editname); ?></td>
      </tr>
      <?php if($editcontactPerson!=''){ ?>  <tr>
        <td class="lightgraytextm">Contact Person </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo $editcontactPerson; ?></td>
      </tr><?php  }?>
      <tr>
        <td class="lightgraytextm">Located</td>
        <td class="lightgraytextm">:</td>
        <td><?php echo getCityName($editcountryId); ?>, <?php echo getStateName($editstateId); ?>, <?php echo $editpinCode; ?> <?php echo getCountryName($editcountryId); ?></td>
      </tr>
      
    </table></td>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="0">
      <tr>
        <td width="33%" class="lightgraytextm">Contact No.  </td>
        <td width="3%" class="lightgraytextm">:</td>
        <td width="64%"><?php echo getPrimaryPhone($editid,'suppliers'); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Email </td>
        <td class="lightgraytextm">:</td>
        <td><?php echo getPrimaryEmail($editid,'suppliers'); ?></td>
      </tr>
      <tr>
        <td class="lightgraytextm">Address</td>
        <td class="lightgraytextm">:</td>
        <td><?php echo $editaddress1; ?></td>
      </tr>
     <?php if($resultpage['guest1']!=''){ ?><?php } ?>
      <?php if($resultpage['guest2']!=''){ ?><?php } ?>
      
      
    </table></td>
  </tr>
</table>
	  </div>
    </div></td>
    <td width="50%" valign="top"><div style="margin-top:67px;">
	 <div class="complaintquyerbox">
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="    font-size: 22px;">Complaint ID: <?php echo makeQueryId($resultpaymentpage['id']); ?></td>
    <td align="right"><a href="showpage.crm?module=complaintmanagement"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Back" >
    </a></td>
  </tr>
</table>

	 </div>
	 <?php
	 $n=1;
	 $select2='*';
$where2='complaintId='.$resultpaymentpage['id'].' order by id desc'; 
$rs2=GetPageRecord($select2,_COMPLAINT_REMARK_MASTER_,$where2); 
while($listcomnew=mysqli_fetch_array($rs2)){

?>
	 <div class="<?php if($resultpaymentpage['status']==2 && $n==1 ){?>RescomplaintContentbox<?php } else { ?>complaintContentbox<?php } ?>"> 
	<div style="margin-bottom:10px;"><?php echo nl2br(strip($listcomnew['description'])); ?></div>
	<div style="    font-size: 12px; position: relative; margin-bottom: 10px;  margin-top: 23px;">Complaint Date: <strong><?php echo showdate($listcomnew['complaintDate']); ?></strong><div style="position:absolute; right:0px; top:-2px;"><?php
	if($n==1){
	if($resultpaymentpage['status']==1){ echo '<div class="lossquery">Open</div>'; } if($resultpaymentpage['status']==2){ echo '<div class="wonquery">Resolved</div>'; }  } else { echo '<div class="lossquery">Open</div>'; }  ?></div>
	  <br />
	Submit By: <strong><?php echo getUserName($listcomnew['addedBy']); ?></strong></div>
	
	</div>
	<?php $n++; } ?> 
	 
	 
	<div class="complaintContentbox"> <h1><?php echo ($resultpaymentpage['subject']); ?></h1>
	<div style="margin-bottom:10px;"><?php echo nl2br(strip($resultpaymentpage['description'])); ?></div>
	<div style="    font-size: 12px; position: relative; margin-bottom: 10px;  margin-top: 23px;">Complaint Date: <strong><?php echo showdate($resultpaymentpage['complaintDate']); ?></strong><div style="position:absolute; right:0px; top:-2px;"><div class="lossquery">Open</div></div>
	  <br />
	Submit By: <strong><?php echo getUserName($resultpaymentpage['addedBy']); ?></strong></div>
	
	</div>
	
	
	
	
	<div class="complaintContentbox"> <h1>Remark </h1>
	   
	 
	
	  <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="compsubmit" target="actoinfrm"  id="compsubmit">  
	  <textarea name="compremarkdetails" rows="4" class="validate" id="compremarkdetails" placeholder="Enter Remark" style="border: 1px solid #ffb100; width:100%; padding:10px; outline:0px;box-sizing:border-box;" displayname="Remark Details"></textarea>
	  <div style="margin-top:10px; overflow:hidden;"><table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td><select id="status" name="status" class="textfieldsup"   autocomplete="off"  style="    padding: 10px;
    border: 1px #FFFFFF solid;
    outline: 0px;
    border-radius: 140px;"  >  
<option value="1">Open</option> 
<option value="2">Closed</option> 
</select></td>
    <td align="right"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Submit" onclick="formValidation('compsubmit','submitbtn','0');" ></td>
  </tr>
  
</table>
<input name="compId" type="hidden" id="compId" value="<?php echo $resultpaymentpage['id']; ?>" />
</div></form>
	   
	</div>
	</div>
	</td>
  </tr>
</table>

 
<?php } ?>