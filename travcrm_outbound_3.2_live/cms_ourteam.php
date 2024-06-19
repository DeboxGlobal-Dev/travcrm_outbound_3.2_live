<?php $pageName='Our Team';
//----Page Settings-----
$type= "our_team";
//----change status-----
	if($_REQUEST['status']!=""){
		$id=$_REQUEST['id'];
		$status=$_REQUEST['status'];
		$sql_ins="update "._POST_LIST_MASTER_." set status='$status' where id = ".$id."";
		mysqli_query(db(),$sql_ins) or die(mysqli_error(db()));
		header("location:?module=cms&page=ourteam&alt=2");
	}



	if(isset($_REQUEST['action']) && $_REQUEST['action']=="del"){
		$id=$_REQUEST['id'];
		$sql_del="delete from  "._POST_LIST_MASTER_."  where id='".$_REQUEST['id']."'";
		mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
			header("location:?module=cms&page=ourteam&alt=2");
	}
	?>
	<script>
		function cmd_del(){
			var x= confirm("Do you want to delete this record?.");
			if(x)
			return true;
			else
			return false;
		}
	</script>
	<link href="css/main.css" rel="stylesheet" type="text/css" />
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="91%" align="left" valign="top">
					<form id="listform" name="listform" method="get">
						<div class="rightsectionheader">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><a href="showpage.crm?module=cms"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a><?php echo $pageName; ?></span>
											<div id="deactivatebtn" style="display:none;">
												<?php if($deletepermission==1){ ?>
												<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="cms_alertspopupopen('action=mastersdelete&name=Destination','600px','auto');" />
												<?php } ?>
											</div>
										</div>
									</td>
									<td align="right">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td>        </td>
													<?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
													<?php if($addpermission==1){ ?>
													<td style="padding-right:20px;" >&nbsp;</td>
													<?php } ?>
													<td style="padding-right:20px;"><a href="showpage.crm?module=cms&page=our_team"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo $pageName; ?>"></a></td>
												</tr>
											</table>
									</td>
								</tr>
							</table>
						</div>
						<div id="pagelisterouter" style="padding-left:30px;">
							<input name="action" id="action" type="hidden" value="our_team" />
							<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
							<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
								<thead>
									<tr>
										<th  align="left" class="header" >sr. No</th>
										<th  align="left" class="header" >Member Name</th>
										<th  align="left" class="header" >Designation</th>
										<th  align="left" class="header" >Description</th>
										<th  align="left" class="header" >Photo</th>
										<th  align="left" class="header" >Status</th>
										<th  align="left" class="header" >Edit</th>
										<th  align="left" class="header" >Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no=1;
									$select='*';
									$where='';
									$rs='';
									$wheresearch='';
									$limit=clean($_GET['records']);
									
									$where='where type="our_team" order by srn asc';
									$page=$_GET['page'];
									
									$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';
									$rs=GetRecordList($select,_POST_LIST_MASTER_,$where,$limit,$page,$targetpage);
									$totalentry=$rs[1];
									$paging=$rs[2];
									while($resultlists=mysqli_fetch_array($rs[0])){
									?>
									<tr>
										<td width="10%" align="left"><span class="graylist"><?php echo $resultlists['srn'];?> </span></td>
										<td width="15%" align="left"><span class="graylist"><?php echo $resultlists['title'];?> </span></td>
										<td width="15%" align="left"><?php echo $resultlists['home_text'];?> </td>
										<td width="35%" align="left">
											<?php
											echo substr(strip_tags($resultlists['description']),0, 250); 
											if (strlen(strip_tags($resultlists['description']))>250) {
												echo "...";
											}
											?>
										</td>
										<td width="10%" align="left"><img src="<?php  echo $fullurl.stripslashes($resultlists['image1']); ?> " style="width:50px;height: auto;" ></td>

										<td width="5%" align="center">
											<?php if($resultlists['status']==1){ ?>
												<a href="showpage.crm?module=cms&page=ourteam&status=0&id=<?php echo $resultlists['id']; ?>">
												<img src="images/unlock.png" width="30" border="0" />		            
											</a>
											<?php } else { ?>
												<a href="showpage.crm?module=cms&page=ourteam&status=1&id=<?php echo $resultlists['id']; ?>">
												<img src="images/lock.png" />		            
											</a>
											<?php } ?>	
										</td>

										<td width="5%" align="center">
											<a href="showpage.crm?module=cms&page=our_team&id=<?php echo $resultlists['id']; ?>">
												<img src="images/edit_icon.png" alt="Edit" width="25" border="0" />
											</a>
										</td>
										
										<td width="5%" align="center">
											<a href="?module=cms&page=ourteam&amp;id=<?php echo $resultlists['id']; ?>&amp;action=del" onclick="return cmd_del()"> 
												<img src="images/dlt.png" alt="Edit" width="20"  border="0" /> 
											</a>
										</td>

									</tr>
										
									<?php 
									$no++; 
									}
									?>
									
								</tbody>
							</table>
							<?php if($no==1){ ?>
							<div class="norec">No <?php echo $pageName; ?></div>
							<?php } ?>
							<div class="pagingdiv">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td><table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
													<td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
														<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
														<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
														<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
														<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
														<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
													</select></td>
												</tr>
												
											</table></td>
											<td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</form>	
				</td>
			</tr>
		</table>
		<script>
		window.setInterval(function(){
		checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
				
		if(!checked) {
			$("#deactivatebtn").hide();
			$("#topheadingmain").show();
		} else {
			$("#deactivatebtn").show();
			$("#topheadingmain").hide();
			}
		}, 100);
		comtabopenclose('linkbox','op2');
		</script>