<?php
include "inc.php"; 
include "config/logincheck.php"; 


if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].''; 
deleteRecord(_NOTES_MASTER_,$where);  
}
 
?>


<?php 
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='queryid='.$_GET['id'].' order by dateAdded desc'; 
$rs=GetPageRecord($select,_NOTES_MASTER_,$where); 
while($querylisting=mysqli_fetch_array($rs)){  
?>
	
<div class="querymaillisting" style="background-color:#fffbef; position:relative;"   onclick="showcontenttab(<?php echo $querylisting['id']; ?>);$('#titleid<?php echo $querylisting['id']; ?>').removeClass('strong');" id="maintab<?php echo $querylisting['id']; ?>"><img src="images/pin_orange.png" width="20" style="position: absolute; left: 13px; top: 10px;" />

<div class="maintitle" id="titleid<?php echo $querylisting['id']; ?>" style="padding-left: 30px;"><?php echo strip(substr(strip_tags($querylisting['notesDescription']),0,110)); ?>...</div>

<div class="datetimequ"><?php $originalDate = $querylisting['dateAdded']; echo date("g:iA - d-m-Y", $originalDate); ?></div> 

</div>

<div class="displaytab" id="displaymaintab<?php echo $querylisting['id']; ?>">
 <div class="datebox" style="position:relative;"><?php $originalDate = $querylisting['dateAdded']; echo date("g:iA - d-m-Y", strtotime($originalDate)); ?>
 
 <?php if($_SESSION['userid']==$querylisting['userId']){ ?>
 <a style="color:#FF0000 !important;  font-size:12px;position: absolute; right: 70px;" onclick="if(confirm('Are you sure you want delete this note?')) loadquerynotes('<?php echo $querylisting['id']; ?>');">Delete</a>
 <?php } ?>
 
 <input name="Close" type="button" class="whitembutton" id="Close" value="Close" style="    position: absolute;  padding: 5px 8px; right: 0px; font-size: 12px;top: -6px;" onclick="hidecontenttab(<?php echo $querylisting['id']; ?>);"></div>
 
 
 <?php echo nl2br(strip($querylisting['notesDescription'])); ?></div>

<?php $n++; } ?>

<?php if($n==1){ ?>
<div style="text-align:center; padding:20px; color:#999999;">No Notes</div>
<?php } ?>