<?php 
if ($_REQUEST['subpage'] != '' || isset($_REQUEST['subpage'])) {
	if ($_REQUEST['subpage'] == 'destn') {
		$subpage = "Destination";
	}else{
		$subpage = $_REQUEST['subpage'];
	}
}else{
	$subpage = "package";
}
$page_name = ($subpage=='package' || $subpage=='hotel')? 'REVIEWS' : 'COMMENTS';
$pageName='   &nbsp;&nbsp;&nbsp;'.strtoupper($subpage).' '.$page_name.'';
//----Page Settings-----
//----change status-----
if($_REQUEST['status']!=""){
	$id=$_REQUEST['id'];
	$status=$_REQUEST['status'];
	$sql_ins="update blog_comment set status='".$status."' where id = ".$id."";
	mysqli_query($sql_ins) or die(mysqli_error(db()));
	header("location:?module=cms&page=review&subpage=".$subpage."&id=".$id."&alt=2");
}
//----SHOW ON HOME
if($_REQUEST['home']!=""){
	$id=$_REQUEST['id'];
	$home=$_REQUEST['home'];
	$sql_ins="update blog_comment set home='".$home."' where id = ".$id."";
	mysqli_query($sql_ins) or die(mysqli_error(db()));
	header("location:?module=cms&page=review&subpage=".$subpage."&id=".$id."&alt=2");
}
if(isset($_REQUEST['action']) && $_REQUEST['action']=="del"){
$id=$_REQUEST['id'];
	$sql_del="delete from  blog_comment  where id='".$_REQUEST['id']."'";
	mysqli_query($sql_del) or die(mysqli_error(db()));
		header("location:?module=cms&page=review&subpage=".$subpage."&id=".$id."&alt=2");
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
										<td style="padding-right:20px;">
											<a href="showpage.crm?module=cms&page=review&subpage=package">
												<input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Package Reveiw">
											</a>
										</td>
										<td style="padding-right:20px;">
											<a href="showpage.crm?module=cms&page=review&subpage=blog">
												<input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Blog Comments">
											</a>
										</td>
										<td style="padding-right:20px;">
											<a href="showpage.crm?module=cms&page=review&subpage=destn">
												<input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Destination Comments">
											</a>
										</td>
										<td style="padding-right:20px;">
											<a href="showpage.crm?module=cms&page=review&subpage=hotel">
												<input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Hotel Review">
											</a>
										</td>
									</tr>
									
								</table>
							</td>
							<td align="right">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td></td>
										<!-- <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
										<?php if($addpermission==1){ ?>
										<td style="padding-right:20px;" >&nbsp;</td>
										<?php } ?>
										<td style="padding-right:20px;"><a href="showpage.crm?module=cms&page=add-review"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo $pageName; ?>"></a></td> -->
									</tr>
									
								</table>
							</td>
						</tr>
					</table>
				</div>
				<div id="pagelisterouter" style="padding-left:30px;">
					<input name="action" id="action" type="hidden" value="banner" />
					<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
						<thead>
							<tr>
								<th  width="10%" align="left" class="header" >Sr. No.</th>
								<th  width="10%" align="left" class="header" >Date</th>
								<th  width="12%" align="left" class="header" >User</th>
								<?php if($subpage == 'package') { ?>
								<th  width="10%" align="left" class="header" >Rating</th>
								<th  width="25%" align="left" class="header" >Title</th>
								<?php } ?>
								<th  width="50%" align="left" class="header" >Comments</th>
								<!-- <th  width="8%" align="center" class="header" >Show Home</th> -->
								<!-- <th  width="8%" align="center" class="header" >Comments</th> -->
								<th  width="3%" align="center" class="header" >Status</th>
								<th  width="3%" align="center" class="header" >Edit</th>
								<th  width="3%" align="center" class="header" >Delete</th>
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
							$subpage=$subpage;
							$where='where type="'.$subpage.'" and comment_id=0 order by createdOn desc';
							$page=$_GET['page'];
							
							$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';
							$rs=GetRecordList($select,'blog_comment',$where,$limit,$page,$targetpage);
							$totalentry=$rs[1];
							$paging=$rs[2];
							while($resultlists=mysqli_fetch_array($rs[0])){
							?>
							<tr>
								<td  align="left"><span class="graylist"><?php echo $no; ?></span></td>
								<td  align="left"><span class="graylist"><?php echo date("j M Y", strtotime($resultlists['createdOn'])); ?></span></td>
								<td  align="left">
									<?php
										$createdBy =  $resultlists['createdBy'];
										if ($resultlists['userType'] == 2) {
											$reviewUserSql="select * from corporateMaster where id ='".$createdBy."'";
										}else{
											$reviewUserSql="select * from contactsMaster where id ='".$createdBy."'";
										}
										$reviewUserQuery = mysqli_query($reviewUserSql);
										$reviewUserData = mysqli_fetch_array($reviewUserQuery);?>
										<?php echo $reviewUserData['username'];?>
								</td>
								<?php if ($subpage == 'package') { ?>
								<td  align="left">
									<style>
									.star_rating {
									display: inline-block;
									position: relative;
									width: 100%;
									height: auto;
									}
									.star_rating img {
									width: 18px;
									float: left;
									display: inline-block;
									}
									</style>
									<div class="inline-block star_rating">
										<?php
										$star = $resultlists['review_star'];
										for ($i=1; $i <= 5; $i++) {
											?>
											<img src="images/<?php echo ($i<=$star)?'filled-star.png':'empty-star.png';?>"/>
											<?php
										}
										?>
									</div>
								</td>
								<td  align="left"><?php  echo stripslashes($resultlists['title']); ?></td>
								<?php } ?>
								<td  align="left"><?php  echo stripslashes($resultlists['blog_comment']); ?></td>
								<!-- <td  align="center">
									<?php if($resultlists['home']==1){ ?>
									<a href="showpage.crm?module=cms&page=review&subpage=<?php echo $subpage; ?>&home=0&id=<?php echo $resultlists['id']; ?>">
										<img src="images/unlock.png" width="30" border="0" />
									</a>
									<?php } else { ?>
									<a href="showpage.crm?module=cms&page=review&subpage=<?php echo $subpage; ?>&home=1&id=<?php echo $resultlists['id']; ?>">
										<img src="images/lock.png" />
									</a>
									<?php } ?>
								</td> -->
								<!-- <td  align="center"><a href="?module=cms&page=review_comment&review_id=<?php echo $resultlists['id']; ?>">View</a></td> -->
								<td  align="center">
									<?php if($resultlists['status']==1){ ?>
									<a href="showpage.crm?module=cms&page=review&subpage=<?php echo $subpage; ?>&status=0&id=<?php echo $resultlists['id']; ?>">
										<img src="images/unlock.png" width="30" border="0" />
									</a>
									<?php } else { ?>
									<a href="showpage.crm?module=cms&page=review&subpage=<?php echo $subpage; ?>&status=1&id=<?php echo $resultlists['id']; ?>">
										<img src="images/lock.png" />
									</a>
									<?php } ?>
								</td>
								<td  align="center">
									<a href="?module=cms&page=review&amp;id=<?php echo $resultlists['id']; ?>&amp;action=del" onclick="return cmd_del()"> <img src="images/dlt.png" alt="Edit" width="30" height="32" border="0" />
									</a>
								</td>
								<td  align="center">
									<a href="showpage.crm?module=cms&page=add-review&id=<?php echo $resultlists['id']; ?>">
										<img src="images/edit_icon.png" alt="Edit" width="30" height="30" border="0" />
									</a>
								</td>
							</tr>
							<?php $no++; } ?>
						</tbody>
					</table>
					<?php if($no==1){ ?>
					<div class="norec">No <?php echo $pageName; ?></div>
					<?php } ?>
					<div class="pagingdiv">
						
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tbody><tr>
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
						</tbody></table>
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