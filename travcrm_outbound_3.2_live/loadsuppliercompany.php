<?php  
include "inc.php"; 
include "config/logincheck.php";
$paymentid = clean($_REQUEST['paymentid']);
$searchcompanyname = clean($_REQUEST['searchcompanyname']);
$companyTypeId = clean($_REQUEST['companyTypeId']);
if($companyTypeId==12){
$where2='';
}
else
{
$where2='';
if($companyTypeId==1){
$where2='1';
}

if($companyTypeId==2){
$where2='2';
}

if($companyTypeId==10){
$where2='10';
}

if($companyTypeId==11){
$where2='11';
}

}



$n=1;
if($searchcompanyname!=''){
$Individual='';
$select=''; 
$where=''; 
$rs='';  
$select='*';  
  
$where='name like "%'.$searchcompanyname.'%" or cityId in (select id from '._CITY_MASTER_.' where name like "%'.$searchcompanyname.'%" ) or stateId in (select id from '._STATE_MASTER_.' where name like "%'.$searchcompanyname.'%" ) and name!="" and deletestatus=0 '.$Individual.' order by name asc limit 0,20'; 
$rs=GetPageRecord($select,_SUPPLIERS_MASTER_,$where); 
while($userInfopost=mysqli_fetch_array($rs)){  
 
if($companyTypeId==12)
{


$n=1;
?>
<!--onclick="alertspopupopen('action=addsupplierinpaymentrequest&supplierid=<?php echo ($userInfopost['id']); ?>&paymentid=<?php echo clean($paymentid); ?>&night=<?php echo $_GET['night']; ?>','900px','auto');"-->
<?php if($_REQUEST['suppliermainhotel']==1){ 

if($userInfopost['supplierMainType']==2){?>


  <div class="selectParentList" style="padding-left:10px;"  <?php if($_REQUEST['suppliermainhotel']==1){ ?>onclick="$('#dmchotel<?php echo $_REQUEST['paymentid']; ?>').load('loaddmchotel.php?supsectionid=<?php echo $_REQUEST['paymentid']; ?>&supplierId=<?php echo ($userInfopost['id']); ?>');"<?php } else { ?>onclick="alertspopupopen('action=selectsupplierstate&supplierid=<?php echo ($userInfopost['id']); ?>&paymentid=<?php echo clean($paymentid); ?>&night=<?php echo $_GET['night']; ?>&companyTypeId=<?php echo $companyTypeId; ?>','400px','auto');"<?php } ?>><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php if($userInfopost['supplierMainType']==1){ echo 'Individual'; } else { echo 'DMC'; } ?> - <?php echo getPrimaryPhone($userInfopost['id'],'suppliers'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'suppliers'); ?> - <?php echo getCityName($userInfopost['cityId']); ?>, <?php echo getStateName($userInfopost['stateId']); ?></td>
  </tr>
  
</table>
  </div>
  
 <?php } } else { 
 
 
 if($userInfopost['supplierMainType']==2){?>
 
 <div class="selectParentList" style="padding-left:10px;"  <?php if($_REQUEST['suppliermainhotel']==1){ ?>onclick="$('#dmchotel<?php echo $_REQUEST['paymentid']; ?>').load('loaddmchotel.php?supsectionid=<?php echo $_REQUEST['paymentid']; ?>&supplierId=<?php echo ($userInfopost['id']); ?>');"<?php } else { ?>onclick="alertspopupopen('action=selectsupplierstate&supplierid=<?php echo ($userInfopost['id']); ?>&paymentid=<?php echo clean($paymentid); ?>&night=<?php echo $_GET['night']; ?>&companyTypeId=<?php echo $companyTypeId; ?>','400px','auto');"<?php } ?>><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php if($userInfopost['supplierMainType']==1){ echo 'Individual'; } else { echo 'DMC'; } ?> - <?php echo getPrimaryPhone($userInfopost['id'],'suppliers'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'suppliers'); ?> - <?php echo getCityName($userInfopost['cityId']); ?>, <?php echo getStateName($userInfopost['stateId']); ?></td>
  </tr>
  
</table>
  </div>
 <?php } } ?>
  
<?php $n++; 


}
else
{
if($userInfopost['companyTypeId']==$companyTypeId || $userInfopost['airlinesType']==$companyTypeId || $userInfopost['transferType']==$companyTypeId || $userInfopost['sightseeingType']==$companyTypeId){

$n=1;
?>
<!--onclick="alertspopupopen('action=addsupplierinpaymentrequest&supplierid=<?php echo ($userInfopost['id']); ?>&paymentid=<?php echo clean($paymentid); ?>&night=<?php echo $_GET['night']; ?>','900px','auto');"-->
<?php if($_REQUEST['suppliermainhotel']==1){ if($userInfopost['supplierMainType']==1){?>


  <div class="selectParentList" style="padding-left:10px;"  <?php if($_REQUEST['suppliermainhotel']==1){ ?>onclick="$('#dmchotel<?php echo $_REQUEST['paymentid']; ?>').load('loaddmchotel.php?supsectionid=<?php echo $_REQUEST['paymentid']; ?>&supplierId=<?php echo ($userInfopost['id']); ?>');"<?php } else { ?>onclick="alertspopupopen('action=selectsupplierstate&supplierid=<?php echo ($userInfopost['id']); ?>&paymentid=<?php echo clean($paymentid); ?>&night=<?php echo $_GET['night']; ?>&companyTypeId=<?php echo $companyTypeId; ?>','400px','auto');"<?php } ?>><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php if($userInfopost['supplierMainType']==1){ echo 'Individual'; } else { echo 'DMC'; } ?> - <?php echo getPrimaryPhone($userInfopost['id'],'suppliers'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'suppliers'); ?> - <?php echo getCityName($userInfopost['cityId']); ?>, <?php echo getStateName($userInfopost['stateId']); ?></td>
  </tr>
  
</table>
  </div>
  
 <?php } } else { ?>
 
 <div class="selectParentList" style="padding-left:10px;"  <?php if($_REQUEST['suppliermainhotel']==1){ ?>onclick="$('#dmchotel<?php echo $_REQUEST['paymentid']; ?>').load('loaddmchotel.php?supsectionid=<?php echo $_REQUEST['paymentid']; ?>&supplierId=<?php echo ($userInfopost['id']); ?>');"<?php } else { ?>onclick="alertspopupopen('action=selectsupplierstate&supplierid=<?php echo ($userInfopost['id']); ?>&paymentid=<?php echo clean($paymentid); ?>&night=<?php echo $_GET['night']; ?>&companyTypeId=<?php echo $companyTypeId; ?>','400px','auto');"<?php } ?>><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php if($userInfopost['supplierMainType']==1){ echo 'Individual'; } else { echo 'DMC'; } ?> - <?php echo getPrimaryPhone($userInfopost['id'],'suppliers'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'suppliers'); ?> - <?php echo getCityName($userInfopost['cityId']); ?>, <?php echo getStateName($userInfopost['stateId']); ?></td>
  </tr>
  
</table>
  </div>
 <?php } ?>
  
<?php $n++; }} }  } if($n==1){?> 
<div style="text-align:center; color:#CCCCCC; padding:30px 0px;">No Supplier Found</div>

<?php } ?>