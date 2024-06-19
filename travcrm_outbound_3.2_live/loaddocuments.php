<?php 
include "inc.php"; 
include "config/logincheck.php";




if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].' and sectionType="'.$_GET['sectionType'].'"'; 
deleteRecord(_DOCUMENT_DETAILS_MASTER_,$where);
}
 

$id=$_GET['id']; 
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >Document Type</th>

     <th align="left" class="header ">Document Number</th>

     <th align="left" class="header ">Issue Date</th>
     <th align="left" class="header "> Expiry Date</th>
     <th align="left" class="header ">Issue Country</th>
     <th align="left" class="header ">Attachment</th>
     <th align="center" class="header ">Action</th>
    </tr>
   </thead>


  <tbody>
  <?php 
    $nod=1;
$select='*';
$where='masterId='.$id.' and sectionType="'.$_GET['sectionType'].'" order by id desc'; 
$rs=GetPageRecord($select,_DOCUMENT_DETAILS_MASTER_,$where); 
while($usermasterdocument=mysqli_fetch_array($rs)){      
    
  $doctype = strip($usermasterdocument['docType']);
  $Country = strip($usermasterdocument['countryId']);
  if($doctype==1)
  {
    $doctypes="AADHAAR";
  }
  if($doctype==2)
  {
    $doctypes="PASSPORT";
  }
  if($doctype==3)
  {
    $doctypes="VISA";
  }
  if($doctype==5)
  {
    $doctypes="COVID V. CERT.";
  }
  if($doctype==6)
  {
    $doctypes="OTHER";
  } 
  $issueDate = strip($usermasterdocument['issueDate']);
  $issueDates = date('d-m-Y',strtotime($issueDate));
  $expiryDate = strip($usermasterdocument['expiryDate']);
  $expiryDates = date('d-m-Y',strtotime($expiryDate));
?>   
  <tr>
    <td align="left"><?php echo $doctypes; ?> </td>

    <td align="left"><?php echo strip($usermasterdocument['documentNo']); ?></td>

    <td align="left"><?php echo $issueDates; ?></td>
    <td align="left"><?php echo $expiryDates; ?></td>
    <?php 
      $cid=1;
      $select1=''; 
      $where1=''; 
      $rs1='';  
      $select1='*';    
      $where1=' id="'.$Country.'"';  
      $rs1=GetPageRecord($select1,_COUNTRY_MASTER_,$where1); 
      $resListing=mysqli_fetch_array($rs1);
      
      ?>
      <td align="left"><?php  echo strip($resListing['name']); ?></td>

      <td align="left"> <?php if($usermasterdocument['documentAttachment']!=''){ ?> <a href= 'dirfiles/<?php echo $usermasterdocument['documentAttachment']; ?> ' target="_blank"> <?php echo $usermasterdocument['documentAttachment']; ?> </a> <?php } ?> </td>
      
    <td align="left" style="display: none;">
      <!-- <a id="my-button<?php echo $usermasterdocument['id'];?>" style="text-decoration:underline; ">+ Attachment</a> -->
      
    <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm<?php echo $usermasterdocument['id'];?>" target="actoinfrmdoc" id="addeditfrm<?php echo $usermasterdocument['id'];?>" style="display:none;">
 <input name="uploaddocuments" type="file" id="uploaddocuments<?php echo $usermasterdocument['id'];?>" onchange="uploaddocumentfunc<?php echo $usermasterdocument['id'];?>();" />
 <input name="editId" type="hidden" id="editId<?php echo $usermasterdocument['id'];?>" value="<?php echo $_GET['id']; ?>" />
 <input name="action" type="hidden" id="action" value="attachdocument" />
 <input name="sectionType" type="hidden" id="sectionType<?php echo $usermasterdocument['id'];?>" value="contacts" />
 <input name="docId" type="hidden" id="docId" value="<?php echo $usermasterdocument['id'];?>" />
 </form>
 <script>
 function deletedoc(id){
  $('#loaddoc<?php echo $usermasterdocument['id'];?>').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
  
 $('#loaddoc<?php echo $usermasterdocument['id'];?>').load('loaddocumentfile.php?id=<?php echo $id; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
 }
 
 function deletecon(id){
 if (confirm("Do you want to delete this document?")){
    deletedoc(id);
}
 }
 
 function uploaddocumentfunc<?php echo $usermasterdocument['id'];?>(){
 $('#addeditfrm<?php echo $usermasterdocument['id'];?>').submit();
 $('#loaddoc<?php echo $usermasterdocument['id'];?>').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
 }
 
 $('#my-button<?php echo $usermasterdocument['id'];?>').click(function(){
    $('#uploaddocuments<?php echo $usermasterdocument['id'];?>').click();
});
 </script>
 </div>
 <table>
   <tr>
     <td><div id="loaddoc<?php echo $usermasterdocument['id'];?>" style="margin-left: -30px;">
 Loading...   </div></td>
   </tr>
 </table>
  <script>
  $('#loaddoc<?php echo $usermasterdocument['id'];?>').load('loaddocumentfile.php?id=<?php echo $id; ?>&sectionType='+$('#sectionType').val());
  </script></td>
    <td align="center"> <a onclick="alertspopupopen('action=addeditdocument&sectionType=<?php echo $_GET['sectionType']; ?>&masterId=<?php echo encode($_GET['id']); ?>&id=<?php echo $usermasterdocument['id']; ?>','700px','auto');" >Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/deleteicon.png"   style="cursor:pointer;" onClick="deleteconfirm(<?php echo $usermasterdocument['id']; ?>);" /></td>
    </tr> 
  
  <?php  $nod++;} ?>
</tbody></table>
<?php if($nod==1){ ?>
<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Document Detail</div>
 <?php } ?>
 <iframe style="display: none;" name="actoinfrmdoc" id="actoinfrmdoc"></iframe>