<?php
include "inc.php";
include "config/logincheck.php";
$thumborlist = $_REQUEST['thumborlist'];
$folderid = decode($_REQUEST['id']);
$subfolder = $_REQUEST['subfolder'];
if($_GET['dltid']!=''){
	$where=' id='.decode($_GET['dltid']).'';
	deleteRecord(_DOCUMENT_FILES_MASTER_,$where);

	$where2=' fileId='.decode($_GET['dltid']).'';
	deleteRecord(_IMAGE_GALLERY_MASTER_,$where2);


	$filename=$_REQUEST['filename'];
	unlink('dirfiles/'.$filename);
}
if($_GET['dlt']!=''){
	$where=' id='.decode($_GET['dlt']).'';
	deleteRecord(_DOCUMENT_SUBFOLDER_MASTER_,$where);
}
?>
<script type="text/javascript">
		function deletefile(fid,filename){
			$('#folderouter').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
			$('#folderouter').load('filelistinner.php?filename='+filename+'&dltid='+fid+'&id=<?php echo $_REQUEST['id']; ?>');
		}
		function deletealertfile(fid,filename){
			if(confirm("Do you want to delete this file?")){
				deletefile(fid,filename);
			}
		}
		function deletesubfolder(fid){
			$('#folderouter').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
			$('#folderouter').load('filelistinner.php?dlt='+fid+'&id=<?php echo $_REQUEST['id']; ?>');
		}
		function deletealertsubfolder(fid){
			if(confirm("Do you want to delete this file or folder?")){
				deletesubfolder(fid);
			}
		}
</script>
<?php 

if($thumborlist==2){
	$nod=1;


	// Folders
	$select='*';
	$where=' deletestatus=0 and folderId='.$folderid.' '.$subfolder.' order by id desc';
	$rs=GetPageRecord($select,_DOCUMENT_SUBFOLDER_MASTER_,$where);
	while($folderlist2=mysqli_fetch_array($rs)){
		?> 
		<div class="folderthumb" onclick="showsubfolderorfileviewmain('<?php echo encode($folderlist2['id']); ?>','<?php echo encode($folderlist2['folderId']); ?>');">
			<img src="images/blkfolder.png" alt="<?php echo showdatetime($folderlist2['dateAdded'],$loginusertimeFormat);?>" width="54" title="<?php echo showdatetime($folderlist2['dateAdded'],$loginusertimeFormat);?>"/>
			<div class="foldername"><?php echo $folderlist2['name']; ?></div>
		</div>
		<?php 
	}  

	// Files
	$select='*';
	$where=' deletestatus=0 and subfolderId=0 and folderId='.$folderid.' '.$subfolder.' order by id desc';
	$rs=GetPageRecord($select,_DOCUMENT_FILES_MASTER_,$where);
	while($folderlist3=mysqli_fetch_array($rs)){
		?>
		<div class="filethumb" onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($folderlist3['id']); ?>&folderid=<?php echo $_REQUEST['id']; ?>','400px','auto');">
			<img src="<?php echo getFileIcon($folderlist3['fileType']); ?>" alt="<?php echo showdatetime($folderlist3['dateAdded'],$loginusertimeFormat);?>" width="54" title="<?php echo showdatetime($folderlist3['dateAdded'],$loginusertimeFormat);?>"/>
			<div class="filename"><?php echo ucfirst($folderlist3['name']); ?></div>
		</div>
		<?php 
	} 
} else { ?>
	<?php 
	if($folderid!=1){	 ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
		<thead>
			<tr>
				<th width="2%" align="left" class="header">&nbsp;#</th>
				<th width="30%" align="left" class="header">Name</th>
				<th width="15%" align="left" class="header"  >Created Date </th>
				<th width="15%" align="left" class="header"  >Created By </th>
				<th width="15%" align="left" class="header"  ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>action </th>
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
			if($subfolder!=''){
				$subfolder = ' and name like "%'.$subfolder.'%"';
			}
			 $where='where deletestatus=0 and folderId='.$folderid.' '.$subfolder.' order by id desc';
			$targetpage=$fullurl.'';
			$rs=GetRecordList($select,_DOCUMENT_SUBFOLDER_MASTER_,$where,$limit,$page,$targetpage);
			$totalentry=$rs[1];
			$paging=$rs[2];
			while($subFolderData=mysqli_fetch_array($rs[0])){
				$countfolder = '';
  				$countfolder = mysqli_num_rows(GetPageRecord('*',_DOCUMENT_FILES_MASTER_,' folderId="'.$subFolderData['folderId'].'" and subfolderId="'.$subFolderData['id'].'"'));
			?>
			<tr>
				<td align="left"><img src="images/blkfolder.png" width="36"  title="<?php echo showdatetime($subFolderData['dateAdded'],$loginusertimeFormat);?>" onClick="showsubfolderorfileviewmain('<?php echo encode($subFolderData['id']); ?>','<?php echo encode($subFolderData['folderId']); ?>');"/></td>
				<td align="left"><a  onClick="showsubfolderorfileviewmain('<?php echo encode($subFolderData['id']); ?>','<?php echo encode($subFolderData['folderId']); ?>');"><?php echo  ucfirst($subFolderData['name']); ?></a></td>
				<td align="left" ><?php echo showdatetime($subFolderData['dateAdded'],$loginusertimeFormat);?></td>
				<td align="left" ><?php echo getUserName($subFolderData['addedBy']); ?></td>
				<td align="left" ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <a onclick="alertspopupopen('action=addDocumentSubFolder&id=<?php echo encode($subFolderData['id']); ?>&folderid=<?php echo encode($subFolderData['folderId']); ?>','400px','auto');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-pencil"></i></a>
				  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <a  onClick="showsubfolderorfileviewmain('<?php echo encode($subFolderData['id']); ?>','<?php echo encode($subFolderData['folderId']); ?>');"  style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i></a>
				  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <?php if($countfolder==0 && $subFolderData['id']!=1){ ?>
				  <a onclick="deletealertsubfolder('<?php echo encode($subFolderData['id']); ?>','<?php echo $subFolderData['uploadFile']; ?>');" style="color:#ff0000!important;font-size: 22px;"><i class="fa fa-trash-o"></i></a> 
				  <?php } ?>
				</td>

			</tr>
			
			<?php $no++; 
			} ?>


			<?php
			$no=1;
			$select='*';
			$where='';
			$rs='';
			$wheresearch='';
			$limit='500';
			
			$where='where deletestatus=0 and subfolderId=0 and folderId='.$folderid.' '.$subfolder.' order by id desc';
			$targetpage=$fullurl.'';
			$rs=GetRecordList($select,_DOCUMENT_FILES_MASTER_,$where,$limit,$page,$targetpage);
			$totalentry=$rs[1];
			$paging=$rs[2];
			while($docFileData=mysqli_fetch_array($rs[0])){
				?>
				<tr>
				<td align="left"><img src="<?php echo getFileIcon($docFileData['fileType']); ?>" width="30"  title="<?php echo showdatetime($docFileData['dateAdded'],$loginusertimeFormat);?>"  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($docFileData['id']); ?>&folderid=<?php echo $_REQUEST['id']; ?>','400px','auto');" style="cursor:pointer;"/></td>
				<td align="left"><a  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($docFileData['id']); ?>&folderid=<?php echo $_REQUEST['id']; ?>','400px','auto');"><?php echo  ucfirst($docFileData['name']); ?></a></td>
				<td align="left" ><?php echo showdatetime($docFileData['dateAdded'],$loginusertimeFormat);?></td>
				<td align="left" ><?php echo getUserName($docFileData['addedBy']); ?></td>
				<td align="left" ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <a onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($docFileData['id']); ?>&folderid=<?php echo $_REQUEST['id']; ?>','400px','auto');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i></a>
				  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  <?php if( $docFileData['id']!=1){ ?>
				  <a onclick="deletealertfile('<?php echo encode($docFileData['id']); ?>','<?php echo $docFileData['uploadFile']; ?>');" style="color:#ff0000!important;font-size: 22px;"><i class="fa fa-trash-o"></i></a> 
				  <?php } ?>
				</td>
			</tr>
			
			<?php $no++; } ?>
		</tbody>
		</table>
		<?php 
	} 
	else { ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
		<thead>
			<tr>
				<th colspan="2" width="16%" align="left" class="header"> Package Name</th>
				<th width="12%" align="left" class="header"  >Package Code </th>
				<th width="12%" align="left" class="header"  >Starting City</th>
				<th width="12%" align="left" class="header"  >End City</th>
				<th width="12%" align="left" class="header"  >Days</th>
				<th width="12%" align="left" class="header"  >Nights</th>
				<th width="12%" align="left" class="header"  >Package Type</th>
				<th width="12%" align="center" class="header">action </th>
			</tr>
		</thead>
		<tbody>
			<?php
			$dir = "tcpdf/examples/package/";
			if (is_dir($dir)){
			if ($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false){
				if(str_replace('.','',$file)!=''){
				
				$package=preg_replace("/[^0-9]/","",ltrim($file, '0'));
				$package=preg_replace("/[^0-9]/","",ltrim($package, '0'));
				$selectp='';
				$wherep='';
				$rsp='';
				$selectp='*';
				 $wherep=' id='.$package.' ';
				$rsp=GetPageRecord($selectp,_PACKAGE_DETAIL_MASTER_,$wherep);
				$packageresult=mysqli_fetch_array($rsp);
				
				$selectc='';
				$wherec='';
				$rsc='';
				$selectc='*';
				$wherec=' id="'.$packageresult['startCity'].'" ';
				$rsc=GetPageRecord($selectc,_DESTINATION_MASTER_,$wherec);
				$resListingc=mysqli_fetch_array($rsc);
				 
			?>
			<tr>
				<td align="left"><img src="<?php echo getFileIcon('pdf'); ?>" width="30"  title="<?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?>"  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($resultlists['id']); ?>&folderid=<?php echo $_REQUEST['id']; ?>','400px','auto');" style="cursor:pointer;"/></td>
				<td align="left"><a   href="tcpdf/examples/package/<?php echo $file; ?>" target="_blank"><?php echo $packageresult['pacakageName'];?></a></td>
				<td align="left" ><?php echo $packageresult['packageId'];?></td>
				<td align="left" ><?php echo ucfirst($resListingc['name']); ?></td>
				<td align="left" ><?php $selectc='';
						$wherec='';
						$rsc='';
						$selectc='*';
						$wherec=' id="'.$packageresult['endCity'].'" order by name asc';
						$rsc=GetPageRecord($selectc,_DESTINATION_MASTER_,$wherec);
				$resListingc=mysqli_fetch_array($rsc); echo ($resListingc['name']); ?></td>
				<td align="left" ><?php if($packageresult['newPackageType']==0){ echo countlisting('id',_PACKAGE_BUILDER_DAYS_MASTER_,' where packageId='.$packageresult['id'].' '); } else { echo $packageresult['days']; }?></td>
				<td align="left" ><?php  if($packageresult['newPackageType']==0){ $countNight = countlisting('id',_PACKAGE_BUILDER_DAYS_MASTER_,' where packageId='.$packageresult['id'].' ')-1; if($countNight<=0){echo '1';}else{echo $countNight;}  } else { echo $packageresult['nights']; } ?></td>
				<td align="left" ><?php if($packageresult['newPackageType']==0){echo 'B2B Package';}else{ echo 'B2C Package';} ?></td>
				
				<td align="center" ><a href="tcpdf/examples/package/<?php echo $file; ?>" target="_blank">Open</a>&nbsp;&nbsp;&nbsp;  </td>
			</tr>
			
			<?php  } }
			closedir($dh);
			}
			} ?>
		</tbody>
		</table>
		<?php 
	} 
}

$where4='';
$res4='';
$select4='*';
$where4=' folderId="'.$folderid.'" and deletestatus=0';
$res4=GetPageRecord($select4,_DOCUMENT_SUBFOLDER_MASTER_,$where4);
$countfolder4a=mysqli_num_rows($res4);
if($countfolder4a>0){
  $countfolder4 = $countfolder4a;
} else {
  $countfolder4=0;
}


$where5='';
$res5='';
$select5='*';
$where5=' folderId="'.$folderid.'" and deletestatus=0';
$res5=GetPageRecord($select5,_DOCUMENT_FILES_MASTER_,$where5);
$countfolder5a=mysqli_num_rows($res5);
if($countfolder5a>0){
	$countfolder5 = $countfolder5a;
} else {
	$countfolder5=0;
}


$where6='';
$res6='';
$select6=' SUM(fileSize) AS value_sum ';
$where6=' folderId="'.$folderid.'" and deletestatus=0';
$res6=GetPageRecord($select6,_DOCUMENT_FILES_MASTER_,$where6);
$row=mysqli_fetch_assoc($res6);
$sum6 = $row['value_sum'];
if($row['value_sum']!=''){
	$sum6 = formatBytes($sum6, $precision = 2);
} else {
	$sum6=0;
}
?>
<script>
$('#totalfiles').text('<?php echo $countfolder5; ?>');
$('#foldercount').text('<?php echo $countfolder4; ?>');
$('#totalspace').text('<?php echo $sum6; ?>');
</script>