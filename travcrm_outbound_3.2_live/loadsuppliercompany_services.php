<?php  
include "inc.php"; 
include "config/logincheck.php";
$paymentid = clean($_REQUEST['paymentid']);
$userSupplierType = clean($_REQUEST['userSupplierType']);
$companyTypeId = clean($_REQUEST['companyTypeId']);
$voucherid = clean($_REQUEST['voucherid']);

if($companyTypeId==1){$seleservietitle='Hotel';}elseif($companyTypeId==2){$seleservietitle='Airlines';}elseif($companyTypeId==10){$seleservietitle='Transfer';}elseif($companyTypeId==11){$seleservietitle='Sightseeing';}
$n=1;
$Individual='';
$select=''; 
$where=''; 
$rs='';  
$select='*';  
 ?>
 <option value="">Select <?php echo $seleservietitle;?></option>
 <?php 
$where='name like "%'.$searchcompanyname.'%" or cityId in (select id from '._CITY_MASTER_.' where name like "%'.$searchcompanyname.'%" ) or stateId in (select id from '._STATE_MASTER_.' where name like "%'.$searchcompanyname.'%" ) and name!="" and deletestatus=0 '.$Individual.' order by name asc '; 
$rs=GetPageRecord($select,_SUPPLIERS_MASTER_,$where); 
while($userInfopost=mysqli_fetch_array($rs)){  
if($userInfopost['supplierMainType']==1){
$n=1;
if($userInfopost['companyTypeId']==$companyTypeId || $userInfopost['airlinesType']==$companyTypeId || $userInfopost['transferType']==$companyTypeId || $userInfopost['sightseeingType']==$companyTypeId){
?>
<option value="<?php echo ($userInfopost['id']); ?>"><?php echo strip($userInfopost['name']); ?></option>
<?php
}
}
}

?>




