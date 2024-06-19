<?php 
include "inc.php"; 
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];
$folderid = $_REQUEST['id'];


if($_GET['dltid']!=''){
$where=' id='.$_GET['dltid'].''; 
deleteRecord(_DOCUMENT_FILES_MASTER_,$where); 
$filename=$_REQUEST['filename']; 
unlink('dirfiles/'.$filename); 
}

?> 
<script>

function deletefile(fid,filename){
	   $('#folderouter').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#folderouter').load('filelistinner.php?filename='+filename+'&dltid='+fid+'&id=<?php echo $folderid; ?>');
	  }


 function deletealertfile(fid,filename){
	  if(confirm("Do you want to delete this file?")){
    deletefile(fid,filename);
}
	  }
</script>

<?php if($thumborlist==1){ 

 
$nod=1;
$select='*';
$where='folderId='.$folderid.' order by id asc'; 
$rs=GetPageRecord($select,_DOCUMENT_FILES_MASTER_,$where); 
while($folderlist=mysqli_fetch_array($rs)){
?>
 
<div class="filethumb" onclick="alertspopupopen('action=openDocumentfile&id=<?php echo $folderlist['id']; ?>&folderid=<?php echo $folderid; ?>','400px','auto');">
	<img src="<?php echo getFileIcon($folderlist['fileType']); ?>" alt="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>" width="54"    title="<?php echo showdatetime($folderlist['dateAdded'],$loginusertimeFormat);?>"/>
	<div class="filename"><?php echo $folderlist['name']; ?></div>
</div>
	
<?php } } else if($folderid==1){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
 

  <tbody>
  <?php
  $dir = "tcpdf/examples/package/";
  $pacId=1;
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
	if(str_replace('.','',$file)!=''){
?>
  <tr>
    <td align="left"><img src="<?php echo getFileIcon('pdf'); ?>" width="30"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>" style="cursor:pointer;"/></td>
    <td align="left"><?php echo $file; ?></td>
    <td align="left" ><?php  $packageId = substr($file,8,-4); 
		   
		$selectc='*';    
		$wherec='packageId="'.$packageId.'"';  
		$rsc=GetPageRecord($selectc,_PACKAGE_DETAIL_MASTER_,$wherec); 
		$resListingc=mysqli_fetch_array($rsc); 
		   
		$selectc1='*';    
		$wherec1=' id="'.$resListingc['startCity'].'" order by name asc';  
		$rsc1=GetPageRecord($selectc1,_DESTINATION_MASTER_,$wherec1); 
		$resListingc1=mysqli_fetch_array($rsc1);
		
		echo $resListingc1['name'];
	?></td>
    <td align="left" >&nbsp; </td> 
	<td align="center" ><input type="button" value="Select File" class="greendocumentmbtnadd" onclick="selecteddocumentfiles('<?php echo $pacId; ?>','<?php echo $file; ?>','<?php echo $fullurl.'tcpdf/examples/package/'.$file; ?>');"  ></td> 
    </tr> 
	
	<?php  } $pacId++; }
    closedir($dh);
  }
} ?>
</tbody></table>
<?php } else { ?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit='500';
   
$where='where deletestatus=0 and folderId='.$folderid.' order by id desc';   
$targetpage=$fullurl.''; 
$rs=GetRecordList($select,_DOCUMENT_FILES_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td width="2%" align="left"><img src="<?php echo getFileIcon($resultlists['fileType']); ?>" width="30"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>"  onclick="selecteddocumentfiles('<?php echo  ($resultlists['id']); ?>','<?php echo  ($resultlists['name']); ?>','<?php echo $fullurl.'download/'.$resultlists['uploadFile']; ?>');" style="cursor:pointer;"/></td>
    <td width="43%" align="left"><a  onclick="selecteddocumentfiles('<?php echo  ($resultlists['id']); ?>','<?php echo  ($resultlists['name']); ?>','<?php echo $fullurl.'download/'.$resultlists['uploadFile']; ?>');"><?php echo  ($resultlists['name']); ?></a></td>
    <td width="50%" align="left" ><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>
    <td width="5%" align="right" ><input type="button" value="Select File" class="greendocumentmbtnadd" onclick="selecteddocumentfiles('<?php echo  ($resultlists['id']); ?>','<?php echo  ($resultlists['name']); ?>','<?php echo $fullurl.'download/'.$resultlists['uploadFile']; ?>');"  ></td>
  </tr> 
	
	<?php $no++; } ?>
</tbody></table>


<?php  } 
 
$sql5="select id from "._DOCUMENT_FILES_MASTER_." where folderId=".$folderid."";
$res5 = mysqli_query(db(),$sql5);
$countfolder=mysqli_num_rows($res5);
 
 
$result = mysqli_query(db(),'SELECT SUM(fileSize) AS value_sum FROM '._DOCUMENT_FILES_MASTER_.' where folderId='.$folderid.''); 
$row = mysqli_fetch_assoc($result); 
$sum = $row['value_sum'];
 
  if($row['value_sum']!=''){
$sum = formatBytes($sum, $precision = 2);
} else { 
$sum=0;
}
?>
<script>
$('#totalfiles').text('<?php echo $countfolder; ?>');
$('#totalspace').text('<?php echo $sum; ?>');
  

</script>
 