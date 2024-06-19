<?php
include "inc.php"; 
include "config/logincheck.php";
if($_REQUEST['days']!=''){
$day=$_REQUEST['days'];
} else { 
$day=0;
}
 
if($_REQUEST['action']=='adddaywise'){
$sql_del="delete from newPackageDays  where packageId='".$_REQUEST['packageId']."'";   
mysqli_query(db(),$sql_del) or die(mysqli_error(db()));

for ($x = 1; $x <= $day; $x++) { 
$namevalue ='packageId="'.$_REQUEST['packageId'].'"';  
addlistinggetlastid('newPackageDays',$namevalue); 
}
}
?>



<?php 
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  packageId='.$_REQUEST['packageId'].' order by id asc';  
$rs=GetPageRecord($select,'newPackageDays',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
 <div  class="hotellistmain">
 <div style="margin-bottom:10px;">
 <div style="margin-bottom:5px;"><strong>Day <?php echo $n ?></strong>: Title</div>
 <input name="dayTitle<?php echo $resListing['id']; ?>" type="text" id="dayTitle<?php echo $resListing['id']; ?>" value="<?php echo stripslashes($resListing['title']); ?>" placeholder="Enter title of the day"   style="width:80%; padding:10px; box-sizing:border-box; border:1px #ccc solid;" onkeyup="savedaywisedetails('<?php echo $resListing['id']; ?>');"></div>
 
 
 <div >
 <div style="margin-bottom:5px;"><strong>Description</strong></div>
 <textarea name="daydescription<?php echo $resListing['id']; ?>" rows="4" id="daydescription<?php echo $resListing['id']; ?>" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;" placeholder="Write Description" onkeyup="savedaywisedetails('<?php echo $resListing['id']; ?>');"><?php echo stripslashes($resListing['remarks']); ?></textarea>
</div>
 </div>
 
 <?php $n++; } ?>
 
 
 <script>
 function savedaywisedetails(id){
 var dayTitle = encodeURIComponent($('#dayTitle'+id).val());
 var daydescription = encodeURIComponent($('#daydescription'+id).val());  
 $('#savedaywisedetailsdiv').load('savedaywisedetailsdiv.php?id='+id+'&dayTitle='+dayTitle+'&daydescription='+daydescription);
 }
 </script>
 <div style="display:none;" id="savedaywisedetailsdiv"></div>