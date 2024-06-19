<?php  
include "inc.php"; 
include "config/logincheck.php";

$searchcompanyname = clean($_REQUEST['searchcompanyname']);
$n=1;
if($searchcompanyname!=''){

if($_REQUEST['supplier']==1){
$tablename=_SUPPLIERS_MASTER_;
} 



$select=''; 
$where=''; 
$rs='';  
$select='*';  
if($_REQUEST['supplier']==1){
$where=' (name like "%'.$searchcompanyname.'%") and name!="" and deletestatus=0  order by name asc limit 0,20';
} 


$rs=GetPageRecord($select,$tablename,$where); 
while($userInfopost=mysqli_fetch_array($rs)){  
 

$n=1;
?>

<?php if($_REQUEST['supplier']==1){ ?>

  <div class="selectParentList" style="padding-left:10px;" onclick="selectCorporate('<?php echo strip($userInfopost['name']); ?>','<?php echo getPrimaryEmail($userInfopost['id'],'corporate'); ?>','<?php echo getPrimaryPhone($userInfopost['id'],'corporate'); ?>','<?php echo encode(strip($userInfopost['id'])); ?>');<?php if($userInfopost['companyCategory']=='1'){ ?>$('#queryPriority').val('3');<?php } ?>"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93%"><div class="name" style="font-size:14px;"><strong><?php echo strip($userInfopost['name']); ?></strong></div> </td>
  </tr>
  <tr>
    <td style="font-size:12px; color:#999999;"><?php echo getPrimaryPhone($userInfopost['id'],'corporate'); ?> - <?php echo getPrimaryEmail($userInfopost['id'],'corporate'); ?></td>
  </tr>
  
</table>
  </div>
  
<?php } ?>


  
  
<?php $n++; }  } if($n==1){?> 
<div style="text-align:center; color:#CCCCCC; padding:30px 0px;">No <?php if($_REQUEST['supplier']==1){ echo 'Supplier'; } ?> Found</div>

<?php } ?>


