<?php  
include "inc.php"; 
include "config/logincheck.php";  
$searchcompanyname = clean($_REQUEST['searchcompanyname']);
$n=1;
if($searchcompanyname!=''){
  if($_REQUEST['clientType']!=2){
    $tablename=_CORPORATE_MASTER_;
  } 
  if($_REQUEST['clientType']==2){
    $tablename=_CONTACT_MASTER_;
  } 

  $select=''; 
  $where=''; 
  $rs='';  
  $select='*';  
  if($_REQUEST['clientType']!=2){
 
    if($loginuserprofileId==1){
      $wheresearchassign=' 1   ';
    }elseif( ($loginUserType==1 || $loginUserType==2) && $loginUserScope==0){
       $wheresearchassign=' 1   ';
    } else {
      $wheresearchassign=' ( OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or OpsAssignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 
      $wheresearchassign='( '.$wheresearchassign.'  or OpsAssignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
    }

    $where=' '.$wheresearchassign.' and ( name like "%'.$searchcompanyname.'%" or  id in ( select corporateId from contactPersonMaster where 1 and phone like "%'.encode($searchcompanyname).'%" or  email like "%'.encode($searchcompanyname).'%" ) ) and name!="" and deletestatus=0 and status=1 limit 0,20';
  }
  

  // order by name asc 
  // Started select for B2C sec 
  if($_REQUEST['clientType']==2){
    if($loginuserprofileId==1){ 
      $wheresearchassign=' 1   ';
    }elseif( ($loginUserType==1 || $loginUserType==2) && $loginUserScope==0){
       $wheresearchassign=' 1   ';
    }else { 
      $wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 
      $wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
    } 

    $where=' '.$wheresearchassign.' and firstName!="" and deletestatus=0 and ( firstName like "%'.$searchcompanyname.'%" or lastName like "%'.$searchcompanyname.'%" or id in ( select masterId from '._PHONE_MASTER_.' where primaryvalue=1 and sectionType="contacts" and phoneNo like "%'.$searchcompanyname.'%")) limit 0,20';
  }

// Ended select for B2C sec 

// echo $where;
//order by firstName asc 
$rs=GetPageRecord($select,$tablename,$where); 
while($userInfopost=mysqli_fetch_array($rs)){ 

 if($userInfopost['language'] >0){ 
 	$languageId = $userInfopost['language'];
 }else{
 	$languageId = 1;
 }
$n=1;
?>
<?php if($_REQUEST['clientType']!=2){

$drs=GetPageRecord('id,name','nationalityMaster','1 and id="'.$userInfopost['nationality'].'"'); 
$nationName=mysqli_fetch_array($drs); 
$nationality = $nationName['name'];
$nationId = $nationName['id'];

$rrs=GetPageRecord('id,name','marketMaster','1 and id="'.$userInfopost['marketType'].'"'); 
$marketName=mysqli_fetch_array($rrs); 
$marketType = $marketName['name'];
$marketId = $marketName['id'];
?>
  <div class="selectParentList" style="padding-left:10px;" onclick="selectCorporateCompany('<?php echo strip($userInfopost['name']); ?>','<?php echo (getPrimaryEmailCompany($userInfopost['id'],'corporate')); ?>','<?php echo (getPrimaryPhoneCompany($userInfopost['id'],'corporate')); ?>','<?php echo encode(strip($userInfopost['id'])); ?>','<?php echo getUserName($userInfopost['OpsAssignTo']); ?>','<?php echo encode($userInfopost['OpsAssignTo']); ?>','<?php echo $nationality; ?>','<?php echo $languageId; ?>','<?php echo getUserName($userInfopost['assignTo']); ?>','<?php echo encode($userInfopost['assignTo']); ?>','<?php echo $marketType; ?>','<?php echo $nationId ?>','<?php echo $marketId ?>','<?php echo $userInfopost['tourType'] ?>');<?php if($userInfopost['companyCategory']=='1'){ ?>$('#queryPriority').val('3');<?php } ?>fillagentname('<?php echo getPrimaryNameCompany($userInfopost['id'],'corporate'); ?>');">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
    </tr>
    <tr>
    <td style="font-size:12px; color:#999999;">
      <?php echo (getPrimaryPhoneCompany($userInfopost['id'],'corporate')); ?> - 
      <?php echo (getPrimaryEmailCompany($userInfopost['id'],'corporate')); ?></td>
    </tr>
    </table>
  </div>
  
<?php } ?>
<?php if($_REQUEST['clientType']==2){

  $drs=GetPageRecord('id,name','nationalityMaster','1 and id="'.$userInfopost['nationality'].'"'); 
  $nationName=mysqli_fetch_array($drs); 
  $nationality = $nationName['name'];
  $nationId = $nationName['id'];

  $rrs=GetPageRecord('id,name','marketMaster','1 and id="'.$userInfopost['marketType'].'"'); 
  $marketName=mysqli_fetch_array($rrs); 
  $marketType = $marketName['name'];
  $marketId = $marketName['id'];

  $corpName = $gradeName = 'NULL';
  if($userInfopost['corporateId']>0){
    $corpQuery=GetPageRecord('id,name','corporateMaster','1 and id="'.$userInfopost['corporateId'].'"'); 
    $corpD=mysqli_fetch_array($corpQuery); 
    $corpName = strip($corpD['name']);
  }
  if($userInfopost['gradeId']>0){
    $gradeQuery=GetPageRecord('*','gradeMaster','1 and id="'.$userInfopost['gradeId'].'"'); 
    $gradeD=mysqli_fetch_array($gradeQuery); 
    $gradeName = strip($gradeD['name']);
  }

  ?>
	<!--  -->
  <div class="selectParentList" style="padding-left:10px;" onclick="selectCorporateCompany('<?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?>','<?php echo getPrimaryEmail($userInfopost['id'],'contacts'); ?>','<?php echo getPrimaryPhone($userInfopost['id'],'contacts'); ?>','<?php echo encode(strip($userInfopost['id'])); ?>','' ,'' ,'<?php echo $nationality; ?>','<?php echo $userInfopost['language']; ?>','<?php echo getUserName($userInfopost['assignTo']); ?>','<?php echo encode($userInfopost['assignTo']); ?>','<?php echo $marketType; ?>','<?php echo $nationId ?>','<?php echo $marketId ?>','<?php echo $userInfopost['tourType'] ?>');fillagentname('<?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?>');">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['firstName'].' '.$userInfopost['lastName']); ?></strong></div> </td>
      </tr>
      <tr>
        <td style="font-size:12px; color:#999999;">
          <?php echo getPrimaryPhone($userInfopost['id'],'contacts'); ?> - 
          <?php echo getPrimaryEmail($userInfopost['id'],'contacts'); ?></td>
      </tr>
      
    </table>
  </div>
  
  <?php 
} 
?> 
  
<?php $n++; }  } if($n==1){?> 
<div style="text-align:center; color:#CCCCCC; padding:30px 0px;">No <?php if($_REQUEST['clientType']!=2){ echo 'Agent'; } else { echo 'B2C'; } ?> Found</div>
<?php } ?>

<div style="margin:20px 0px;display:none;">
  <?php if($_REQUEST['clientType']!=2){ ?>
<a href="showpage.crm?module=corporate&add=yes" target="_blank">
<div class="addguestbutton" style="margin: 0px; padding: 10px; font-size: 16px;">+ Add New company </div>
</a>
<?php } else { ?>
<a href="showpage.crm?module=contacts&add=yes" target="_blank"><div class="addguestbutton" style="margin: 0px; padding: 10px; font-size: 16px;">+ Add New B2C Client</div></a>
<?php } ?></div>

<script>
function fillagentname(name){
$('#agentb2cname').val(name);
$('#guest1').val(name);
}

</script>

