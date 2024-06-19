<?php
include "inc.php"; 
include "config/logincheck.php";

if($_REQUEST['dltid']!=''){
deleteRecord(_ADDRESS_MASTER_,' id = '.$_REQUEST['dltid'].' and addressType="'.$_REQUEST['addressType'].'" and addressParent='.$_REQUEST['addressParent'].''); 
}
 
 
 $n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' addressType="'.$_REQUEST['addressType'].'" and addressParent='.$_REQUEST['addressParent'].' order by primaryAddress desc';  
$rs=GetPageRecord($select,_ADDRESS_MASTER_,$where); 
while($resAddress=mysqli_fetch_array($rs)){  

?>
<div style="background-color: #f9f9f9; padding: 10px; border: 1px #ececec solid; margin-bottom:8px; position:relative; <?php if($resAddress['primaryAddress']==1){ ?>background-image:url(images/tick.png); background-position:right 10px bottom 10px; background-repeat:no-repeat;<?php } ?>">
<?php if($_REQUEST['view']!=1){ ?>
<a onclick="if(confirm('Are you sure you want delete this address?')) loadaddress('<?php echo $resAddress['id']; ?>');"  style="color:#FF0000 !important; font-size:12px; right:10px; top:10px; position:absolute;">Delete</a>

<a onclick="alertspopupopen('action=addsupaddress&supid=<?php echo $_REQUEST['addressParent']; ?>&id=<?php echo $resAddress['id']; ?>&addressType=<?php echo $_REQUEST['addressType']; ?>','700px','auto');"  style="color:#009900 !important; font-size:12px; right:70px; top:10px; position:absolute;">Edit</a>
<?php } ?>
	<table border="0" cellpadding="5" cellspacing="0" style="font-size:13px;">
  <tr>
    <td>Country</td>
    <td>:</td>
    <td><?php echo getCountryName($resAddress['countryId']); ?></td>
  </tr>
  <?php if($resAddress['stateId']!=0){ ?><tr>
    <td>State</td>
    <td>:</td>
    <td><?php echo getStateName($resAddress['stateId']); ?></td>
  </tr><?php } ?>
  <?php if($resAddress['cityId']!=0){ ?> <tr>
    <td>City</td>
    <td>:</td>
    <td><?php echo getCityName($resAddress['cityId']); ?></td>
  </tr><?php } ?>
  <?php if($resAddress['address']!=''){ ?><tr>
    <td>Address</td>
    <td>:</td>
    <td><?php echo $resAddress['address']; ?></td>
  </tr><?php } ?>
  <?php if($resAddress['pinCode']!=''){ ?><tr>
    <td>Pin Code</td>
    <td>:</td>
    <td><?php echo $resAddress['pinCode']; ?></td>
  </tr><?php } ?>
   <?php if($resAddress['gstn']!=''){ ?><tr>
    <td>GSTN</td>
    <td>:</td>
    <td><?php echo $resAddress['gstn']; ?></td>
  </tr><?php } ?>
</table>

 </div>
	
	<?php $n++; }  if($n==1){ ?>
	<div style="text-align:center;">No Address</div>
	<?php } ?>