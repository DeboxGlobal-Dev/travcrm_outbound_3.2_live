<?php  
include "inc.php"; 
include "config/logincheck.php";
 if($loginuserprofileId==1){ 
$wheresearchassign=' 1   ';
} else { 
$wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 
$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
} 
$searchsupplier = clean($_REQUEST['searchsupplier']);
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';  
$where='  '.$wheresearchassign.' and (name like "%'.$searchsupplier.'%") or (supplierNumber like "%'.$searchsupplier.'%") and name!="" and deletestatus=0 limit 0,20';

//order by firstName asc 
$rs=GetPageRecord($select,'suppliersMaster',$where); 
while($userInfopost=mysqli_fetch_array($rs)){ 
$n=1;
?> 
  <div class="selectParentList" style="padding-left:10px;" onclick="selectSupplier('<?php echo $userInfopost['name'] ?>','<?php echo encode($userInfopost['id']); ?>');" >
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  
  
</table>
  </div>
  
<?php  $n++; } ?>
