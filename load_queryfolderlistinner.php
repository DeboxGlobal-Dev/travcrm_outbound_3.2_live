<?php 
include "inc.php"; 
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];


if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].''; 
deleteRecord(_DOCUMENT_FOLDER_MASTER_,$where);  
}
?>
<?php if($thumborlist==1){ 

 
$nod=1;
$select='*';
$where='1 order by id asc'; 
$rs=GetPageRecord($select,_DOCUMENT_FOLDER_MASTER_,$where); 
while($folderlist=mysqli_fetch_array($rs)){
?>

<script>

function deletefile(fid){
	   $('#folderouter').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#folderouter').load('folderlistinner.php?dltid='+fid+'&thumborlist=2');
	  }


 function deletealertfile(fid){
	  if(confirm("Do you want to delete this folder?")){
    deletefile(fid);
}
	  }
</script>
 
<div class="folderthumb" onClick="showfolderorfileviewmain('<?php echo encode($folderlist['id']); ?>');">
	<img src="images/blkfolder.png" alt="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>"  title="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>"/>
	<div class="foldername"><?php echo $folderlist['name']; ?></div>
</div>
	
<?php } } else { ?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="4%" align="left" class="header">&nbsp;</th>
     <th width="30%" align="left" class="header"> Folder Name </th>
     <th width="34%" align="left" class="header"  >Created Date </th>
     <th width="13%" align="center" class="header"  >Files</th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit='500';
   
$where='where deletestatus=0 order by id desc';   
$targetpage=$fullurl.''; 
$rs=GetRecordList($select,_DOCUMENT_FOLDER_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="left"><img src="images/blkfolder.png" width="36"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>" onClick="showfolderorfileviewmain('<?php echo encode($resultlists['id']); ?>','<?php echo  ($resultlists['name']); ?>');"/></td>
    <td align="left"><a  onClick="showfolderorfileviewmain('<?php echo encode($resultlists['id']); ?>','<?php echo  ($resultlists['name']); ?>');"><?php echo  ($resultlists['name']); ?></a></td>
    <td align="left" ><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>
    <td align="center" ><?php
	$sql5="select id from "._DOCUMENT_FILES_MASTER_." where folderId=".$resultlists['id']."";
$res5 = mysqli_query(db(),$sql5);
echo $countfolder=mysqli_num_rows($res5);
?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>


<?php  } 
 
$sql5="select id from "._DOCUMENT_FOLDER_MASTER_." ";
$res5 = mysqli_query(db(),$sql5);
$countfolder=mysqli_num_rows($res5);
 
$sql5="select id from "._DOCUMENT_FILES_MASTER_." ";
$res5 = mysqli_query(db(),$sql5);
$countFile=mysqli_num_rows($res5);
 
 
$result = mysqli_query(db(),'SELECT SUM(fileSize) AS value_sum FROM '._DOCUMENT_FILES_MASTER_.''); 
$row = mysqli_fetch_assoc($result); 
$sum = $row['value_sum'];
 
  if($row['value_sum']!=''){
$sum = formatBytes($sum, $precision = 2);
} else { 
$sum=0;
}
?>
<script>

	
$('#totalfiles').text('<?php echo $countFile; ?>');
$('#foldercount').text('<?php echo $countfolder; ?>');
$('#totalspace').text('<?php echo $sum; ?>');
</script>
 