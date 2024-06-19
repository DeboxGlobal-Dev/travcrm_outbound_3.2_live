<?php 
include "inc.php"; 
include "config/logincheck.php";

if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].' and sectionType="'.$_GET['sectionType'].'"'; 
deleteRecord(_BANK_DETAILS_MASTER_,$where);
}
 

$id=$_GET['id']; 
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
  <thead>
    <tr>
      <th align="left" class="header" >Bank Name</th>
     <th align="left" class="header ">Branch</th>
     <th align="left" class="header ">Beneficiary</th>
     <th align="left" class="header ">Account No.</th>
     <th align="left" class="header "> 	IFSC Code</th>
     <th align="left" class="header ">Address</th>
     <th align="left" class="header ">Phone No. </th>
     <th align="left" class="header ">Email Id</th>
     <th align="left" class="header ">Swift Code</th>
     <th align="center" class="header ">Primary</th>
     <th align="center" class="header ">Action</th>
    </tr>
   </thead>
   <tbody>
  <?php 
	  $nod=1;
$select='*';
$where='masterId='.$id.' and sectionType="'.$_GET['sectionType'].'" order by id desc'; 
$rs=GetPageRecord($select,_BANK_DETAILS_MASTER_,$where); 
while($usermasterdocument=mysqli_fetch_array($rs)){
?>	 
  <tr>
    <td align="left"><?php echo strip($usermasterdocument['bankName']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['branch']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['beneficiary']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['accountNumber']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['IFSCCode']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['address']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['phoneNumber']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['email']); ?></td>
    <td align="left"><?php echo strip($usermasterdocument['swiftCode']); ?></td>
    <td align="center"><?php if($usermasterdocument['primaryvalue']==1){ ?><img src="images/greencheck.png"   /><?php } ?></td>
    <td align="center"> <a onclick="alertspopupopen('action=addeditbankinfo&sectionType=<?php echo $_GET['sectionType']; ?>&masterId=<?php echo encode($_GET['id']); ?>&id=<?php echo $usermasterdocument['id']; ?>','700px','auto');" >Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/deleteicon.png"   style="cursor:pointer;" onClick="deleteconfirmbank(<?php echo $usermasterdocument['id']; ?>);" /></td>
    </tr> 
	
	<?php $nod++;} ?>
</tbody></table>
<?php if($nod==1){ ?>
<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Bank Detail</div>
 <?php } ?>