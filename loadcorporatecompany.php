<?php  
include "inc.php"; 
include "config/logincheck.php";

$whereQuery=' and fromDate>"'.$startdate.'" and fromDate<"'.$enddate.'"';

 if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

$wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 



$searchcompanyname = clean($_REQUEST['searchcompanyname']);
$n=1;
if($searchcompanyname!=''){

if($_REQUEST['clientType']==1){
$tablename=_CORPORATE_MASTER_;
} 

if($_REQUEST['clientType']==2){
$tablename=_CONTACT_MASTER_;
} 

$select=''; 
$where=''; 
$rs='';  
$select='*';  
if($_REQUEST['clientType']==1){
  $where='  '.$wheresearchassign.' and (name like "%'.$searchcompanyname.'%") and name!="" and deletestatus=0  order by name asc limit 0,20';
} 
if($_REQUEST['clientType']==2){
  $where='  '.$wheresearchassign.' and firstName!="" and deletestatus=0 and (firstName like "%'.$searchcompanyname.'%" or lastName like "%'.$searchcompanyname.'%") order by firstName asc limit 0,20';
}

$rs=GetPageRecord($select,$tablename,$where); 
while($userInfopost=mysqli_fetch_array($rs)){  
 

$n=1;
?>

<?php if($_REQUEST['clientType']==1){
$where2='addressType="corporate" and addressParent="'.$userInfopost['id'].'" order by id asc limit 1';
$addressResult=GetPageRecord('address,countryId','addressMaster',$where2); 
$addressResultData=mysqli_fetch_array($addressResult); 

  ?>

  <div class="selectParentList" style="padding-left:10px;" onclick="selectCorporate('<?php echo strip($userInfopost['name']); ?>','<?php echo $addressResultData['countryId'] ?>','<?php echo getPrimaryEmailCompany($userInfopost['id'],'corporate'); ?>','<?php echo getPrimaryPhoneCompany($userInfopost['id'],'corporate'); ?>','<?php echo encode(strip($userInfopost['id'])); ?>','<?php echo getUserName($userInfopost['OpsAssignTo']); ?>','<?php echo encode($userInfopost['OpsAssignTo']); ?>','<?php echo $addressResultData['address'] ?>','<?php echo getUserName($userInfopost['assignTo']) ?>','<?php echo $userInfopost['assignTo'] ?>');<?php if($userInfopost['companyCategory']=='1'){ ?>$('#queryPriority').val('3');<?php } ?>fillagentname('<?php echo getPrimaryNameCompany($userInfopost['id'],'corporate'); ?>');"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;">
      <?php echo getPrimaryPhoneCompany($userInfopost['id'],'corporate'); ?> - 
      <?php echo getPrimaryEmailCompany($userInfopost['id'],'corporate'); ?></td>
    </tr>
  
</table>
  </div>
  
<?php } ?>

<?php if($_REQUEST['clientType']==2){ 

  ?>
	
  <div class="selectParentList" style="padding-left:10px;" onclick="selectCorporate('<?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?>',<?php echo $userInfopost['countryId'] ?>,'<?php echo getPrimaryEmail($userInfopost['id'],'contacts'); ?>','<?php echo getPrimaryPhone($userInfopost['id'],'contacts'); ?>','<?php echo encode(strip($userInfopost['id'])); ?>','<?php echo getUserName($userInfopost['OpsAssignTo']);  ?>','<?php echo encode($userInfopost['OpsAssignTo']); ?>','<?php echo $userInfopost['address1']; ?>','<?php echo getUserName($userInfopost['assignTo']) ?>','<?php echo $userInfopost['assignTo'] ?>');fillagentname('<?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?>');"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php echo getPrimaryPhone($userInfopost['id'],'contacts'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'contacts'); ?></td>
  </tr>
  
</table>
  </div>
  
<?php } ?>
  
  
<?php $n++; }  } if($n==1){?> 
<div style="text-align:center; color:#CCCCCC; padding:30px 0px;">No <?php if($_REQUEST['clientType']==1){ echo 'Agent'; } else { echo 'B2C'; } ?> Found</div>

<?php } ?>

<script>
function fillagentname(name){
$('#agentb2cname').val(name);
}
</script>
