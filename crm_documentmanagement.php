<?php
if($addpermission!=1 && $_GET['id']==''){
	header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_GET['id']!=''){
	header('location:'.$fullurl.'');
}

if(!is_dir('docFiles')){
	createPath('docFiles');
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
		.gridtable .header {
		padding: 15px!important;
		}
</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="folderviewmain">
	<tr>
		<td width="9%" align="left" valign="top" id="documentfolderrightmain">
			<div style="padding:20px 0px; background-color: #003e46; margin-top:51px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center"><img src="images/000400-folder.png" width="126" id="mainfolder" /></td>
				</tr>
				<tr>
					<td align="center" style="color:#FFFFFF; font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;" id="foldername"><strong>Document&nbsp;Management </strong></td>
				</tr>
			</table></div>
			<div id="innbex"><table border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="left">Total Files </td>
					<td align="left">:</td>
					<td align="left" id="totalfiles">0</td>
				</tr>
				<tr>
					<td align="left">Used Space </td>
					<td align="left">:</td>
					<td align="left" id="totalspace">0</td>
				</tr>
				<tr id="foldercountmain">
					<td align="left">Total Folders</td>
					<td align="left">:</td>
					<td align="left" id="foldercount">&nbsp;</td>
				</tr>
			</table>
		</div>	</td>
		<td width="91%" align="left" valign="top">
			<div id="showfolderorfileview">
				<div id="documentmanagementheader">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="40%" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;">
								<?php if($_REQUEST['folderId']!=''){ 
										$backFoldeQuery='';
										$backFoldeQuery=GetPageRecord('*',_DOCUMENT_FOLDER_MASTER_,'id='.decode($_REQUEST['folderId']).'');
										$backFolderData=mysqli_fetch_array($backFoldeQuery);
										$parentFolder = 0;
										if($backFolderData['folderId']>0){
											$parentFolder = $backFolderData['folderId'];
										} 
										?>
									<a name="addnewuserbtn" href="showpage.crm?module=documentmanagement&folderId=<?php echo encode($parentFolder); ?>">
										<input type="button" name="Submit22" value="Back" class="whitembutton"> 
									</a>
								<?php } ?> 
								<?php 
								function getRootLocation($folderId){
									if($folderId>0){
										$rs='';
										$rs=GetPageRecord('*',_DOCUMENT_FOLDER_MASTER_,'id='.$folderId.'');
										$foldersData=mysqli_fetch_array($rs);
										$parentFolder = 0;
										if($foldersData['folderId']>0){
											getRootLocation($foldersData['folderId']);
											$parentFolder = $foldersData['folderId'];
										} 
										echo substr($foldersData['name'],0,12).' > ';
									}
								}

								if($_REQUEST['folderId']==''){
									$_REQUEST['folderId']=encode(0);
								}

								$searchKeyword = $_REQUEST['searchKeyword'];
								$folderId = decode($_REQUEST['folderId']);
								$folderIdQuery=$searchQuery='';
								if($searchKeyword!=''){
									$searchQuery = ' and name like "%'.$searchKeyword.'%"';
								}

								if($folderId>0){
									$folderIdQuery = ' and folderId='.$folderId.'';
								}else{
									$folderIdQuery = ' and folderId=0';
								}
 
 								?>
								<label style=" padding: 10px; ">
									<?php 
										$rs='';
										$rs=GetPageRecord('*',_DOCUMENT_FOLDER_MASTER_,'id='.$folderId.'');
										$foldersData=mysqli_fetch_array($rs);
										if($foldersData['id']!=''){
											echo ucfirst($foldersData['name']);
										}else{
											echo ucfirst('Document Management');
										}
										?>
								</label>
							</td>
							<td width="60%" align="right">
								<form method="get"action="" >
								<input type="hidden" name="module"  value="<?php echo $_REQUEST['module']; ?>" />
								<input type="hidden" name="folderId" value="<?php echo $_REQUEST['folderId']; ?>" />
								<input type="button" value="+ Upload File"  class="bluembutton"  onclick="alertspopupopen('action=addFolderFiles<?php if($_REQUEST['folderId']!=''){ echo "&folderId=".$_REQUEST['folderId']; } ?>','400px','auto');"  style="float:right;"/>
								<input type="button" value="+ Create Folder"  class="bluembutton"   onclick="alertspopupopen('action=addDocumentFolder<?php if($_REQUEST['folderId']!=''){ echo "&folderId=".$_REQUEST['folderId']; } ?>','400px','auto');"  style="float:right;"/>
								<input type="text" value="<?php echo $_REQUEST['searchKeyword']; ?>" name="searchKeyword" id="searchKeyword"  class="topsearchfiledmain"  placeholder="Enter Keyword..." />
								<input type="submit" class="bluembutton" value="Search.." />
								</form>
							</td>
						</tr>
					</table>
				</div>
				<div id="folderouter_old">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
						<thead>
							<tr>
								<td colspan="5" align="left" style="padding: 4px 15px;">File Manager > <?php  echo getRootLocation($folderId);  ?></td>
							</tr>
							<tr>
								<th width="2%" align="left" class="header">&nbsp;#</th>
								<th width="30%" align="left" class="header">Name</th>
								<th width="15%" align="left" class="header">Created Date </th>
								<th width="15%" align="left" class="header">Created By </th>
								<th width="15%" align="left" class="header">Files/Size</th>
								<th width="15%" align="left" class="header"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>action </th>
							</tr>
						</thead>
						<tbody>
						<?php
						$countfolder = 0;
						$no=1;
						$dfQuery=GetPageRecord('*',_DOCUMENT_FOLDER_MASTER_,' deletestatus=0 '.$folderIdQuery.' '.$searchQuery.' order by id desc');
						while($folderData=mysqli_fetch_array($dfQuery)){
								$countfolder = countFolderFiles($folderData['id']); 
								$countfiles = scan_dir($folderData['id'])['total_files'];
							?>
							<tr>
							<td align="left"><img src="images/blkfolder.png" width="36"  title="<?php echo showdatetime($folderData['dateAdded'],$loginusertimeFormat);?>" /></td>
							<td align="left"><a href="showpage.crm?module=documentmanagement&folderId=<?php echo encode($folderData['id']); ?>" ><?php echo  ucfirst(str_replace('-',' ',$folderData['name'])); ?></a></td>
							<td valign="middle" align="left" ><?php echo date('d-m-y h:i a',trim($folderData['dateAdded']));?></td> 
							<td align="left" ><?php echo getUserName($folderData['addedBy']); ?></td>
							<td align="left" ><?php echo $countfolder; ?> Folders, <?php echo $countfiles;  ?> Files</td>

							<td align="left" ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<a onclick="alertspopupopen('action=addDocumentFolder&id=<?php echo encode($folderData['id']); ?>&folderId=<?php echo encode($folderId); ?>','400px','auto');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-pencil"></i></a>
								<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<a href="showpage.crm?module=documentmanagement&folderId=<?php echo encode($folderData['id']); ?>" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i>
								</a>
								<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<?php if($countfolder==0 && $countfiles==0){ ?>
								<a onclick="alertspopupopen('action=deleteDocumentFolder&id=<?php echo encode($folderData['id']); ?>','400px','auto');"  style="color:#ff0000!important;font-size: 22px;"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							</td>
							</tr>
							<?php 
							$no++;
						} 
						$no=1;
						$fileQuery='';
						$fileQuery=GetPageRecord('*',_DOCUMENT_FILES_MASTER_,' deletestatus=0 '.$folderIdQuery.' '.$searchQuery.' order by id desc');
						while($docFileData=mysqli_fetch_array($fileQuery)){ ?>
							<tr>
								<td align="left"><img src="<?php echo getFileIcon($docFileData['fileType']); ?>" width="30"  title="<?php echo showdatetime($docFileData['dateAdded'],$loginusertimeFormat);?>"  onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($docFileData['id']); ?>&folderId=<?php echo $_REQUEST['folderId']; ?>','400px','auto');" style="cursor:pointer;"/></td>
								<td align="left"><a onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($docFileData['id']); ?>&folderId=<?php echo $_REQUEST['folderId']; ?>','400px','auto');"><?php echo  ucfirst($docFileData['name']); ?></a></td>
								<td valign="middle" align="left" ><?php echo date('d-m-y h:i a',trim($docFileData['dateAdded']));?></td>
								<td align="left" ><?php echo getUserName($docFileData['addedBy']); ?></td>
								<td align="left" ><?php echo $sum6 = formatBytes($docFileData['fileSize'], $precision = 2);?></td>
								<td align="left" ><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<a onclick="alertspopupopen('action=openDocumentfile&id=<?php echo encode($docFileData['id']); ?>&folderId=<?php echo $_REQUEST['folderId']; ?>','400px','auto');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i></a>
									<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<a onclick="alertspopupopen('action=deleteDocumentFile&id=<?php echo encode($docFileData['id']); ?>','400px','auto');"  style="color:#ff0000!important;font-size: 22px;"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
							<?php 
							$no++; 
						} ?>
					</tbody>
					</table>
				</div>
			</div>
		<script>
			function searchdata(){
				var data = $('#searchKeyword').val();
				$('#folderouter').load('folderlistinner.php?thumborlist='+folderView+'&data='+data);
			}
		</script>
		<script>
		$('#totalfiles').text('<?php echo scan_dir($folderId)['total_files']; ?>');
		$('#totalspace').text('<?php echo scan_dir($folderId)['total_size']; ?>');
		$('#foldercount').text('<?php echo countFolderFiles($folderId); ?> Folders');
		</script>
 
		</td>
	</tr>
</table>