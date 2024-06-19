<?php  
include "inc.php"; 
include "config/logincheck.php";
$paymentid = clean($_REQUEST['paymentid']);
$searchcompanyname = clean($_REQUEST['searchcompanyname']);
$supplierMainType = clean($_REQUEST['supplierMainType']);

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

  if($userInfopost['supplierMainType']==2){ 
    $n=1;
    ?>


  <div class="selectParentList" style="padding-left:10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php if($userInfopost['supplierMainType']==1){ echo 'Individual'; } else { echo 'DMC'; } ?> - <?php echo getPrimaryPhone($userInfopost['id'],'suppliers'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'suppliers'); ?> - <?php echo getCityName($userInfopost['cityId']); ?>, <?php echo getStateName($userInfopost['stateId']); ?></td>
  </tr>
  
</table>
  </div>
  
 <?php }?>
 

  
<?php $n++; } }  ?> 