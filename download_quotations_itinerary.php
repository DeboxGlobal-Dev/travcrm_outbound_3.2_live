 <?php
include "inc.php";   

?>

<?php     
$hotelids='0';
$daydatae=1;  
$newn=0; 
 
if($newn==0){
$n=1; }else{
$n=$newn-1;
}

$no=1;

$daysfrom=1; 
$totalday=0;  
  
$rs2=GetPageRecord('*','quotationMaster','id="'.$_REQUEST['qid'].'"');  
$resultpage2=mysqli_fetch_array($rs2);

$_REQUEST['queryId']=$resultpage2['queryId'];

$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$resultpage2['queryId'].'"');  
$resultpage=mysqli_fetch_array($rs);

 $queryfromDate=$resultpage['fromDate'];  
$rsss=GetPageRecord('*',_PACKAGE_QUERY_DAYS_,' packageId="'.$_REQUEST['queryId'].'" order by id asc');   
while($daylisting=mysqli_fetch_array($rsss)){ 

$daylisting['id'];
$f=$n-1;  
?>  
<br />
<div style="margin-bottom:10px; border:1px solid #ccc;">

<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#3b4fb5">
  <tr>
    <td width="66%"  style="color:#fff;">Day <?php echo $n; ?>&nbsp;|&nbsp;<?php if($daydatae==1){ echo date('j M D',strtotime($queryfromDate));  $cdate=date('Y-m-d',strtotime($queryfromDate)); } else { echo date('j M D', strtotime($queryfromDate. ' + '.$f.' days')); $cdate=date('Y-m-d', strtotime($queryfromDate. ' + '.$f.' days')); } $no++; ?>&nbsp;&nbsp;(<?php echo getDestination($daylisting['cityId']); ?>)</td>
    <td width="34%" align="right" style="color:#fff;"><?php echo ($daylisting['title']); ?>&nbsp;&nbsp;<?php 
	
			   $selectid='*';     
               $whereid=' packageId="'.$queryId.'" order by id desc limit 1';  
               $rsid=GetPageRecord($selectid,_PACKAGE_QUERY_DAYS_,$whereid); 
			   $getexe = mysqli_fetch_array($rsid);
			   $getexe['id'];
			   
			    $counthotiti=0;
				$select22itir='*';     
				$where22itir=' packageId="'.$queryId.'" and dayId="'.$daylisting['id'].'" group by hotelId,roomType,mealPlan,dayId order by id desc';  
				$rs22itir=GetPageRecord($select22itir,_PACKAGE_QUERY_HOTEL_,$where22itir);  
				$counthotiti= mysqli_num_rows($rs22itir);
				
			   if($counthotiti==0 && $daylisting['id']==$getexe['id']){ echo '<span style="font-size:10px; font-weight:400;">STANDARD CHECK OUT TIME 1200 HRS MENTIONED</span>'; } ?></td>
  </tr>
</table>
<div style="padding:10px;">
<?php 
$gggkkk=GetPageRecord('*','b2bItinerarysr','  queryId="'.$_REQUEST['qid'].'" and dayid="'.$daylisting['id'].'" order by srdate asc');   
while($datelist=mysqli_fetch_array($gggkkk)){ 

    $id=$_REQUEST['qid']; 
?>
<?php if($datelist['sectionType']==1){ ?>
<div style="">
 
<?php



$id=$_REQUEST['qid']; 
$where16=''; 
$rs16='';  
$select16='*';    
$where16=' queryId='.$id.' and fromDate<="'.$cdate.'"  and toDate>="'.$cdate.'" and status=1 order by fromDate asc';  
$rs16=GetPageRecord($select16,_QUOTATION_HOTEL_MASTER_,$where16); 
$listSupplier=mysqli_fetch_array($rs16);

if($listSupplier['queryId']!=''){?>
<div style="padding:5px; background-color:#F3F3F3; font-size:12px; margin-bottom:5px;"><strong style="font-weight:400;">&nbsp;&nbsp;Hotel Details</strong></div>
<?php } ?>
<?php 
$where16=''; 
$rs16='';  
$select16='*';    
$where16=' queryId='.$id.'  and fromDate<="'.$cdate.'"  and toDate>="'.$cdate.'" and status=1 order by fromDate asc';  
$rs16=GetPageRecord($select16,_QUOTATION_HOTEL_MASTER_,$where16); 
while($listSupplier=mysqli_fetch_array($rs16)){ 
$wherein='';
?>
<div style="padding-left: 10px;"><table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td> 
    <div style="font-size:14px; font-weight:bold;"><?php 
	if($listSupplier['hotelQuotatoinType']=='0'){
	$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  id='.$listSupplier['supplierId'].'';  
$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 
	
	echo strip($resListing['hotelName']);
	$cityname=$resListing['hotelCity'];
	$hotelCategory=$resListing['hotelCategory'];
	}
	
	} else {
	echo strip($listSupplier['hotelName']);
	$cityname=$listSupplier['address'];
	$hotelCategory=$listSupplier['categoryId'];
	
	}
	
	 ?><img src="<?php echo $fullurl; ?>images/<?php echo showStarrating($hotelCategory); ?>" height="20" />  &nbsp; </div> </td>
    </tr>
 
  <tr>
   <?php if($hotelids!=$listSupplier['id']){ $hotelids=$listSupplier['id']; ?>
 <td style="">Room Type :  <?php 
	if($listSupplier['hotelQuotatoinType']=='0'){
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where='  id='.$listSupplier['roomType'].'';  
	$rs=GetPageRecord($select,_ROOM_TYPE_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){ 
	
	echo strip($resListing['name']);
	}
	
	}
	
	 ?>&nbsp;&nbsp; | &nbsp;&nbsp; Meal Plan :  <?php 
	if($listSupplier['hotelQuotatoinType']=='0'){
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where='  id='.$listSupplier['mealPlan'].'';  
	$rs=GetPageRecord($select,_MEAL_PLAN_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){ 
	
	echo strip($resListing['name']);
	}
	
	} 
	
	 ?> | Chek-in  Time: <?php echo $listSupplier['checkin']; ?> | Check-out Time: <?php echo $listSupplier['checkout']; ?> <div style="font-size:11px; text-transform:uppercase; padding-left:0px; margin-top:4px;"><?php echo stripslashes($listSupplier['remark']); ?></div>
      </td>
	  
	  <?php } ?>
    </tr>
</table>


</div>
<?php } ?>

</div>
<?php } ?>
<?php if($datelist['sectionType']==2){ ?>
<div>
<?php 
$where16=''; 
$rs16='';  
$select16='*';    
$where16=' queryId='.$id.' and fromDate<="'.$cdate.'"  and toDate>="'.$cdate.'" order by fromDate asc';  
$rs16=GetPageRecord($select16,_QUOTATION_SIGHTSEEING_MASTER_,$where16); 
$listSupplier=mysqli_fetch_array($rs16);
if($listSupplier['queryId']!=''){?> 
<div style="padding:5px; background-color:#F3F3F3; font-size:12px; margin-bottom:5px;"><strong style="font-weight:400;">&nbsp;&nbsp;Sightseeing</strong></div>
<?php } ?>
<?php 
$where16=''; 
$rs16='';  
$select16='*';    
$where16=' queryId='.$id.'  and fromDate<="'.$cdate.'"  and toDate>="'.$cdate.'" order by fromDate asc';  
$rs16=GetPageRecord($select16,_QUOTATION_SIGHTSEEING_MASTER_,$where16); 
while($listSupplier=mysqli_fetch_array($rs16)){  
 
$wherein='';
?>
<div style="padding-left: 10px;  position:relative; ">
 
<div style="height:80px;"><table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td><!--<div style="font-size:11px; text-transform:uppercase; margin-bottom:5px;">Name</div>--><div style="font-size:14px; font-weight:bold;"><?php 
 $select2='sightseeingName';  
$where2='id='.$listSupplier['sightseeingNameId'].''; 
$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['sightseeingName']);  
?></div></td>
    </tr>
  <tr>
    <td style=""><div style="font-size:11px; text-transform:uppercase; margin-bottom:5px;">Sightseeing&nbsp;Type : <?php if($listSupplier['sightseeingType']==1){ echo 'SIC'; } ?>
	  
	  <?php 
	 if($listSupplier['sightseeingType']==2){
	  echo 'Private - '; 
	  if($listSupplier['vehicleId']!='0'){
 $select2='name,maxpax';  
$where2='id='.$listSupplier['vehicleId'].''; 
$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2);  ?>

Vahicle: <?php echo clean($editresult2['name']); ?> - Pax: <?php echo clean($editresult2['maxpax']); ?>
<?php

}

}
?> | Pickup Time: <?php echo $listSupplier['pickupTime']; ?> | Duration: <?php echo stripslashes($listSupplier['duration']); ?></div>
<?php echo stripslashes($listSupplier['remark']); ?></td></tr></table>
</div> 
</div>
<?php } ?> 
</div> 
<?php } ?>

<?php if($datelist['sectionType']==3){ ?>
<div>
<?php 
$where16=''; 
$rs16='';  
$select16='*';    
$where16=' queryId='.$id.'  and fromDate<="'.$cdate.'"  and toDate>="'.$cdate.'" order by fromDate asc';  
$rs16=GetPageRecord($select16,_QUOTATION_TRANSFER_MASTER_,$where16); 
$listSupplier=mysqli_fetch_array($rs16);
if($listSupplier['queryId']!=''){?>  
<div style="padding:5px; background-color:#F3F3F3; font-size:12px; margin-bottom:5px;"><strong style="font-weight:400;">&nbsp;&nbsp;Transfer </strong></div>
<?php } ?>
<?php 
$where16=''; 
$rs16='';  
$select16='*';    
$where16=' queryId='.$id.'  and fromDate<="'.$cdate.'"  and toDate>="'.$cdate.'" order by fromDate asc';  
$rs16=GetPageRecord($select16,_QUOTATION_TRANSFER_MASTER_,$where16); 
while($listSupplier=mysqli_fetch_array($rs16)){  
$wherein='';
?>
<div style="height:80px;">
<div style="padding-left: 10px;margin-bottom:20px; position:relative; ">
 

<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td><!--<div style="font-size:11px; text-transform:uppercase; margin-bottom:5px;">Name</div>--><div style="font-size:14px; font-weight:bold;"><?php 
 $select2='transferName';  
$where2='id='.$listSupplier['transferNameId'].''; 
$rs2=GetPageRecord($select2,_PACKAGE_BUILDER_TRANSFER_MASTER,$where2); 
$editresult2=mysqli_fetch_array($rs2); 
echo clean($editresult2['transferName']);  
?></div></td>
    </tr>
  <tr>
    <td style=""><div style="font-size:11px; text-transform:uppercase; margin-bottom:4px;">Transfer&nbsp;Type :  <?php if($listSupplier['transferType']==1){ echo 'SIC'; } ?>
	  
	  <?php 
	 if($listSupplier['transferType']==2){
	  echo 'Private - '; 
	  if($listSupplier['vehicleId']!='0'){
 $select2='name,maxpax';  
$where2='id='.$listSupplier['vehicleId'].''; 
$rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
$editresult2=mysqli_fetch_array($rs2);  ?>

Vahicle: <?php echo clean($editresult2['name']); ?> - Pax: <?php echo clean($editresult2['maxpax']); ?>
<?php

}

}
?> Pickup Time: <?php echo $listSupplier['pickupTime']; ?> | Duration: <?php echo stripslashes($listSupplier['duration']); ?></div><?php echo stripslashes($listSupplier['remark']); ?>
     </td>
    </tr>
</table>


</div>
</div>
<?php } ?>

</div>
<?php } }?>

</div>
</div>


<div style="display:none;" id="saveitinerarydatadata"></div>
<?php $n++; $daydatae++; $newn=$n;  } ?>

 