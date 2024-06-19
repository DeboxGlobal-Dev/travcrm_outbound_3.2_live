<?php  
include "inc.php"; 
include "config/logincheck.php";
$companyTypeId = clean($_REQUEST['companyTypeId']);

$where='name!="" and deletestatus=0 and id='.$companyTypeId.' and status=1'; 
$rs=GetPageRecord('name,id',_SUPPLIERS_TYPE_MASTER_,$where); 
$suppTypeD=mysqli_fetch_array($rs);

if($suppTypeD['name']=='Hotel'){$seleservietitle='and companyTypeId=1';}
elseif($suppTypeD['name']=='Guide'){$seleservietitle='and (guideType=2 or guideType=1)';}
elseif($suppTypeD['name']=='Activity'){$seleservietitle='and (activityType=3 or activityType=1)';}
elseif($suppTypeD['name']=='Entrance'){$seleservietitle='and (entranceType=4 or entranceType=1)';}
elseif($suppTypeD['name']=='Transfer'){$seleservietitle='and (transferType=5 or transferType=1)';}
elseif($suppTypeD['name']=='Restaurant'){$seleservietitle='and (mealType=6 or mealType=1)';}
elseif($suppTypeD['name']=='Airlines'){$seleservietitle='and (airlinesType=7 or arlinesType=1)';}
elseif($suppTypeD['name']=='Train'){$seleservietitle='and (trainType=8 or trainType=1)';}
elseif($suppTypeD['name']=='Others'){$seleservietitle='and (otherType=13 or otherType=1)';}
else {$seleservietitle='';$companyTypeId==100;}

$select=''; 
$where=''; 
$rs='';  
$select='*';  
 ?>
  <option value="">Select Supplier</option>
 <?php 
 if($companyTypeId=='100'){
$where=' name!="" and deletestatus=0 order by name asc '; 
$rs=GetPageRecord($select,_SUPPLIERS_MASTER_,$where); 
 } else { 
$where='1 and name!="" and deletestatus=0 '.$seleservietitle.' and status=1 order by name asc '; 
$rs=GetPageRecord($select,_SUPPLIERS_MASTER_,$where); 
}

while($userInfopost=mysqli_fetch_array($rs)) { ?>

<option value="<?php echo ($userInfopost['id']); ?>"><?php echo strip($userInfopost['name']); ?> <?php // if($userInfopost['supplierMainType'] == 2){ echo '-(DMC)'; }?></option>

<?php } ?>



<script>
  $(document).ready(function() {
  $('.select2').select2();
   
  });
</script>
