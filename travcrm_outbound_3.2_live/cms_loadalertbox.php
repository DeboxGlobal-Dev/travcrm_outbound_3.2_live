	<?php
	include "inc.php"; 
	include "config/logincheck.php";  
	?>
	<!-- tinymce text editor -->
	<script src="js/jquery-1.11.3.min.js"></script>
 	<script src="tinymce/tinymce.min.js"></script>
	<!-- user tags with this script and css and html inpit line -->
	<script type="text/javascript">
		tinymce.init({
			selector: "#description",
			themes: "modern",
			plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
		</script>
 	<script type="text/javascript" src="js/bootstrap-tagsinput.js?d=<?php echo date();?>"></script>
 	<!-- <input type="text" value="samaydin" class="tagsinput form-control" data-role="tagsinput" data-color="rose"> -->
	<style type="text/css">
		.bootstrap-tagsinput .tag [data-role=remove] {
		    cursor: pointer;
		    position: absolute;
		    top: 3px;
		    right: 0;
		    opacity: 0;
		}
		.bootstrap-tagsinput .tag {
		    background-color: #e91e63;
		    color: #fff;
			cursor: pointer;
		    margin: 5px 3px 5px 0;
		    position: relative;
		    padding: 3px 8px;
		    border-radius: 12px;
		    color: #fff;
		    font-weight: 500;
		    font-size: .75em;
		    text-transform: uppercase;
		    display: inline-block;
		    line-height: 1.5em;
		    padding-left: .8em;
	        transition: all .15s ease 0s;
		}
		.bootstrap-tagsinput input, .bootstrap-tagsinput input:focus {
		    border: none;
		    box-shadow: none;
		    background-image: none;
		}

		.bootstrap-tagsinput input {
		    outline: none;
		    background-color: transparent;
		    margin: 0;
		    height: 25px;
		    width: 74px;
		    max-width: inherit;
		    display: inline-block;
		}
		.bootstrap-tagsinput .tag:hover {
		    padding-right: 18px;
		}
		.bootstrap-tagsinput .tag:hover [data-role=remove] {
		    opacity: 1;
		    padding-right: 6px;
		}
		.bootstrap-tagsinput .tag [data-role=remove]:after {
		    content: "x";
		    padding: 0 2px;
		}
	</style>
 	<?php
 	if($_GET['action']=='addedit_inclusion' && $_GET['sectiontype']=='inclusion'){
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';
			$where1='id='.$id.'';
			$rs1=GetPageRecord($select1,_PACKAGE_INCLUSION_MASTER_,$where1);
			$editresult=mysqli_fetch_array($rs1);
			$name=clean($editresult['name']);
		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Inclusion </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Name<span class="redmind"></span></div>
							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Photo</div>
							<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
						</label>
					</div>
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
					<input name="action" type="hidden" id="action" value="addedit_inclusion" />
					<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['image']; ?>" />
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
				</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	?>

	<?php
	if($_GET['action']=='addedit_amenities' ){ 
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';  
			$where1='id='.$id.''; 
			$rs1=GetPageRecord($select1,_AMENITIES_MASTER_,$where1); 
			$editresult=mysqli_fetch_array($rs1);
		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Amenities Master </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Name</div>
							<input name="name"  class="gridfield" id="name" value="<?php echo strip($editresult['name']); ?>" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Photo</div>
							<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="action" type="hidden" id="action" value="addedit_amenities" />
					<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['image']; ?>" />
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
				<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
				</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	?>
	
	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='gallery'){ 
 
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';  
			$where1='id='.$id.''; 
			$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
			$editresult=mysqli_fetch_array($rs1);
			$title=clean($editresult['title']);   
			$feature_img=clean($editresult['feature_img']);
		} ?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Photo Gallery </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Gallery Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Gallery Title" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Destination as(Tags)<span class="redmind"></span></div>
							<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 103px;overflow: auto;" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0">
									<?php
									$destQuery=mysqli_query (db(),"select * from "._DESTINATION_MASTER_." where status='1' order by name asc");
									while($destData=mysqli_fetch_array($destQuery)){
									$isSelected_destination = array_map('trim', explode(",", $editresult['subcategory']));
									?>
									<tr>
										<td colspan="2">
											<label>
												<input name="destination[]" type="checkbox" id="destination" style="display: block;" value="<?php echo $destData['id']; ?>" <?php if(in_array($destData['id'],$isSelected_destination)) { ?> checked="checked" <?php } ?> >
											</label>
										</td>
										<td width="96%"><?php echo $destData['name']; ?></td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Package Theme<span class="redmind"></span></div>
							<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 103px;overflow: auto;" >
								<table width="100%" border="0" cellpadding="5" cellspacing="0">
									<?php
									$package_themeSql=mysqli_query (db(),"select * from "._PACKAGE_THEME_MASTER_." where status='1' order by name asc");
									while($package_themeData=mysqli_fetch_array($package_themeSql)){
									$isSelected_theme = array_map('trim', explode(",", $editresult['category']));
									?>
									<tr>
										<td colspan="2">
											<label>
												<input name="package_theme[]" type="checkbox" id="package_theme" style="display: block;" value="<?php echo $package_themeData['id']; ?>" <?php if(in_array($package_themeData['id'],$isSelected_theme)) { ?> checked="checked" <?php } ?> >
											</label>
										</td>
										<td width="96%"><?php echo $package_themeData['name']; ?></td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Gallery Preview Image</div>
							<?php if($feature_img==''){?><input name="image1" type="file" class="gridfield validate"  displayname="Image"  id="image1"/><?php }
							else {?><input name="image1" type="file" class="gridfield" id="image1"/><?php }?>
							<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_gallery" />
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
				</tr>
			</table>
			</div>
		</div>
		<?php 
	}	
	?>
	
	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='add-images'){ 
		$cid=clean($_GET['cid']);
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';  
			$where1='id='.$id.''; 
			$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
			$editresult=mysqli_fetch_array($rs1);
			$title=clean($editresult['title']);   
			$feature_img=clean($editresult['feature_img']);
		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Photo Gallery </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Image Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Gallery Title" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Gallery Preview Image</div>
							<?php if($feature_img==''){?><input name="file1" type="file" class="gridfield validate"  displayname="Image"  id="file1"/><?php }
							else {?><input name="file1" type="file" class="gridfield" id="file1"/><?php }?>
							<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="cid" type="hidden" id="cid" value="<?php echo $cid; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_images" />
					<script type="text/javascript">
					$('#destination').select2();
					$('#package_theme').select2();
					</script>
				</form>
			</div>
		  	<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
			      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
			        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
			      </tr>
			   </table>
			</div>
		</div>
		<?php 
	}	
	?>

	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='blog'){ 
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';  
			$where1='id='.$id.''; 
			$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
			$editresult=mysqli_fetch_array($rs1);
			$title=clean($editresult['title']); 
			$description=$editresult['description'];  
			$detail1=$editresult['detail1'];  
			$detail2=$editresult['detail2'];  
			$image1=$editresult['image1'];
			$image3=$editresult['image3'];
			$home_text=clean($editresult['home_text']);
			$designation=clean($editresult['designation']);
			$meta_title=clean($editresult['meta_title']);
			$meta_description=clean($editresult['meta_description']);
			$meta_keyword=clean($editresult['meta_keyword']);
			$post_date=clean($editresult['post_date']);
		}
		?>
		<script type="text/javascript">
			tinymce.init({
				selector: "#description",
				themes: "modern",
				plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen"
				],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
			});
		</script>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Blog </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Post Date<span class="redmind"></span></div>
							<input name="post_date" type="text" class="gridfield calfieldicon" id="post_date" value="<?php if($post_date!=""){ echo date("d-m-Y", strtotime($post_date)); } else { echo date('d-m-Y'); ?><?php } ?>" maxlength="100" />
						</label>
					</div>
					
					<script>
						$(document).ready(function() {
							$('#post_date').Zebra_DatePicker({
							format: 'd-m-Y',
							});
						});
					</script>
					<style>
					.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
					width: 100% !important;
					}
					</style>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Title" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					
					<div class="griddiv">
						
						<div class="gridlable">Categories <span class="redmind"></span></div>
						<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 103px;overflow: auto;" >
							<table width="100%" border="0" cellpadding="5" cellspacing="0">
								<?php
								$detail1Sql=mysqli_query (db(),"select * from "._PACKAGE_THEME_MASTER_." where status='1' order by name asc");
								while($detail1Data=mysqli_fetch_array($detail1Sql)){
								$isSelected_cate = array_map('trim', explode(",", $detail1));
								?>
								<tr>
									<td colspan="2">
										<input name="detail1[]" type="checkbox" id="detail1<?php echo $detail1Data['id']; ?>" style="display: block;" value="<?php echo $detail1Data['id']; ?>" <?php if(in_array($detail1Data['id'],$isSelected_cate)) { ?> checked="checked" <?php } ?> >
									</td>
									<td width="96%"><label for="detail1<?php echo $detail1Data['id']; ?>" ><?php echo $detail1Data['name']; ?></label></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						
					</div>


					<div class="griddiv">
						<div class="gridlable">Select Tags<span class="redmind"></span></div>
						<?php 
						// $isSelected_tags = array_map('trim', explode(",", $detail2));

						?>
						<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height:auto;overflow: auto;" >
							<input type="text" value="<?php echo ($detail2 !='') ? $detail2 : 'Enter article tags'; ?>" class="tagsinput form-control" name="detail2" id="tagsBox" data-role="tagsinput" data-color="rose">
			              	<script type="text/javascript">
								<!-- //$(".form-control").keypress(function(e) {  -->
									// if(e.which == 13) { 
										// var val = $('#tagsBox').val();
										// alert(val);
									// } 
								// });
			              	</script>
						</div>
					</div>
					
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Description<span class="redmind"></span></div>
							<textarea name="description" id="description" style="width:98%;" class="gridfield" ><?php  echo stripslashes($description); ?></textarea>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Image</div>
							<input name="image1" type="file" class="gridfield" id="image1"/>
							<input name="image2" type="hidden" class="grybutton" id=image2" value="<?php echo $image1; ?>"/>
						</label>
					</div>
					<div class="griddiv"  >
						<label>
							<div class="gridlable">Author Name<span class="redmind"></span></div>
							<input name="home_text" type="text" class="gridfield" id="home_text" value="<?php echo $home_text; ?>" maxlength="100" />
						</label>
					</div>
					
					<div class="griddiv" style="display: none;">
						<label>
							<div class="gridlable">Author Designation<span class="redmind"></span></div>
							<input name="designation" type="text" class="gridfield" id="designation" value="<?php echo $designation; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv" >
						<label>
							<div class="gridlable">Author Photo</div>
							<input name="image3" type="file" class="gridfield" id="image3"/>
							<input name="image4" type="hidden" class="grybutton" id="image4" value="<?php echo $image3; ?>"/>
							
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable"><strong>SEO SETTINGS</strong></div>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Title<span class="redmind"></span></div>
							<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Description<span class="redmind"></span></div>
							<textarea name="meta_description" id="meta_description"  class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
							<textarea name="meta_keyword" id="meta_keyword" style="width:98%;" class="gridfield" ><?php  echo stripslashes($meta_keyword); ?></textarea>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_blog" />
					<script type="text/javascript">
					$('#destination').select2();
					$('#package_theme').select2();
					</script>
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
				</tr>
			</table>
			</div>
		</div>
		<?php 
	} 
	?>



<!-- Destination banner Started -->
<?php
if($_GET['action']=='addedit_cms' && $_GET['page']=='Destbanner'){
	if($_GET['id']!=''){
		$id=clean($_GET['id']);
		$select1='*';
		$where1='id='.$id.'';
		$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1);
		$editresult=mysqli_fetch_array($rs1);
		$title=clean($editresult['title']);
		$description=clean($editresult['description']);
		$image1=clean($editresult['image1']);

		// meta title banner
		$meta_title=clean($editresult['meta_title']);
		$meta_description=clean($editresult['meta_description']);
		$meta_keyword=clean($editresult['meta_keyword']);
	}
	?>

	<div class="contentclass">
		<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Banner </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
			<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable"> Title <span class="redmind"></span></div>
						<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"> Description <span class="redmind"></span></div>
						<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"> Banner Image </div>
						<input name="image1" type="file" class="gridfield" id="file1"/>
						<input name="image12" type="hidden" class="grybutton" id="image12" value="<?php echo $image1; ?>"/>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"> Status </div>
						<select id="status" name="status" class="gridfield " autocomplete="off"   >
							<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
							<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
						</select>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"><strong>SEO SETTINGS</strong></div>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Meta Title<span class="redmind"></span></div>
						<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
						<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Meta Description<span class="redmind"></span></div>
						<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
					</label>
				</div>
				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
				<input name="action" type="hidden" id="action" value="cms_add_Destbanner" />
			</form>
		</div>
		<div id="buttonsbox"  style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td  >
						<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
					</td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
	<?php 
} 
?>

<!-- destination banner -->





<!--Hote Deals Staretd -->


<?php
if($_GET['action']=='addedit_cms' && $_GET['page']=='hotdeal'){
	if($_GET['id']!=''){
		$id=clean($_GET['id']);
		$select1='*';
		$where1='id='.$id.'';
		$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1);
		$editresult=mysqli_fetch_array($rs1);
		$title=clean($editresult['title']);
		$description=clean($editresult['description']);
		$image1=clean($editresult['image1']);

		// meta title banner
		$meta_title=clean($editresult['meta_title']);
		$meta_description=clean($editresult['meta_description']);
		$meta_keyword=clean($editresult['meta_keyword']);
	}
	?>

	<div class="contentclass">
		<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Hote Deals </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
			<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable"> Title <span class="redmind"></span></div>
						<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"> Description <span class="redmind"></span></div>
						<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"> Banner Image </div>
						<input name="image1" type="file" class="gridfield" id="file1"/>
						<input name="image12" type="hidden" class="grybutton" id="image12" value="<?php echo $image1; ?>"/>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"> Status </div>
						<select id="status" name="status" class="gridfield " autocomplete="off"   >
							<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
							<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
						</select>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable"><strong>SEO SETTINGS</strong></div>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Meta Title<span class="redmind"></span></div>
						<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
						<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Meta Description<span class="redmind"></span></div>
						<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
					</label>
				</div>
				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
				<input name="action" type="hidden" id="action" value="cms_add_hotdeal" />
			</form>
		</div>
		<div id="buttonsbox"  style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td  >
						<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
					</td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
	<?php 
} 
?>


<!--Hote Deals Ended-->


	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='banner'){
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';
			$where1='id='.$id.'';
			$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1);
			$editresult=mysqli_fetch_array($rs1);
			$title=clean($editresult['title']);
			$description=clean($editresult['description']);
			$image1=clean($editresult['image1']);

			// meta title banner
			$meta_title=clean($editresult['meta_title']);
			$meta_description=clean($editresult['meta_description']);
			$meta_keyword=clean($editresult['meta_keyword']);
		}
		?>
	
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Banner </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable"> Title <span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable"> Description <span class="redmind"></span></div>
							<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable"> Banner Image </div>
							<input name="image1" type="file" class="gridfield" id="file1"/>
							<input name="image12" type="hidden" class="grybutton" id="image12" value="<?php echo $image1; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable"> Status </div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable"><strong>SEO SETTINGS</strong></div>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Title<span class="redmind"></span></div>
							<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
							<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Description<span class="redmind"></span></div>
							<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
						</label>
					</div>
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_banner" />
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td  >
							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
						</td>
						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	} 
	?>
	
	<?php	
	if($_GET['action']=='addedit_cms' && $_GET['page']=='ourvideo'){ 
		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';  
			$where1='id='.$id.''; 
			$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
			$editresult=mysqli_fetch_array($rs1);
			$title=clean($editresult['title']);  
			$description=$editresult['description'];  
			$feature_img=clean($editresult['feature_img']);
		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Banner </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Video Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv" style="width: 50%;float: left;">
						<label >
							<div class="gridlable" style="width: 100%;">Summer Video<span class="redmind"></span></div>
							<input name="summer_video" style="width: 20px; margin: 10px 0;" type="checkbox" class="gridfield" value="1"
							<?php if ($editresult['summer_video'] == 1) { echo "checked"; } ?> />
						</label>
					</div>
					<div class="griddiv" style="width: 50%;float: left;">
						<label >
							<div class="gridlable" style="width: 100%;">Winter Video<span class="redmind"></span></div>
							<input name="winter_video" style="width: 20px; margin: 10px 0;" type="checkbox" class="gridfield" value="1"
							<?php if ($editresult['winter_video'] == 1) { echo "checked"; } ?> />
						</label>
					</div>
					<div class="griddiv" style="width: 100%;">
						<label>
							<div class="gridlable">Video url<span class="redmind"></span></div>
							<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_ourvideo" />
					<script type="text/javascript">
						$('#destination').select2();
						$('#package_theme').select2();
					</script>
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td  >
							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
						</td>
						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}	
	?>

	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='user-reviews'){ 

		if($_GET['id']!=''){
			$id=clean($_GET['id']);
			$select1='*';  
			$where1='id='.$id.''; 
			$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
			$editresult=mysqli_fetch_array($rs1);
			$title=clean($editresult['title']);  
			$description=clean($editresult['title']);  
			$feature_img=clean($editresult['feature_img']);
		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Banner </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Banner Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Destination Worldwide<span class="redmind"></span></div>
							<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Banner Image</div>
							<input name="file1" type="file" class="gridfield" id="file1"/>
							<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_banner" />
					<script type="text/javascript">
					$('#destination').select2();
					$('#package_theme').select2();
					</script>
				</form>
				
				
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td  >
							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
						</td>
						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
					</tr>
				</table>
			</div>
		<?php 
	}	
	?>

	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='clients') { 
	    if($_GET['id']!=''){
	        $id=clean($_GET['id']);
	        $select1='*';  
	        $where1='id='.$id.''; 
	        $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
	        $editresult=mysqli_fetch_array($rs1);
	        $title=clean($editresult['title']);  
	        $srn=clean($editresult['srn']);  
	        $description=clean($editresult['description']);  
	        $image1=clean($editresult['image1']);

	        // meta title banner
			$meta_title=clean($editresult['meta_title']);
			$meta_description=clean($editresult['meta_description']);
			$meta_keyword=clean($editresult['meta_keyword']);
	    }
	    ?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Client </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Sr.No.<span class="redmind"></span></div>
							<input name="srn" type="text" class="gridfield validate" id="srn" displayname="Serial Number" value="<?php echo $srn; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Image</div>
							<input name="image1" type="file" class="gridfield" id="image1"/>
							<input name="image11" type="hidden" class="grybutton" id="image11" value="<?php echo $image1; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable"><strong>SEO SETTINGS</strong></div>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Title<span class="redmind"></span></div>
							<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
							<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Description<span class="redmind"></span></div>
							<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
						</label>
					</div>
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_client" />
					<script type="text/javascript">
						$('#destination').select2();
						$('#package_theme').select2();
					</script>
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
					<td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}	
	?>	

	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='awards') { 
	   // awards and recognition
	    if($_GET['id']!=''){
	        $id=clean($_GET['id']);
	        $select1='*';  
	        $where1='id='.$id.''; 
	        $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
	        $editresult=mysqli_fetch_array($rs1);
	        $title=clean($editresult['title']);  
	        $description=clean($editresult['description']);  
	        $image1=clean($editresult['image1']);
	        
	        // meta title banner
			$meta_title=clean($editresult['meta_title']);
			$meta_description=clean($editresult['meta_description']);
			$meta_keyword=clean($editresult['meta_keyword']);

	    }
	    ?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Awards </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Awards Title<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Select Heading</div>
							<select name="category" id="category"  class="gridfield " autocomplete="off" >
								<option value="1" <?php if($editresult['category']==1){ ?> selected="selected"<?php } ?>>AWARDS AND RECOGNITION</option>
								<option value="2" <?php if($editresult['category']==2){ ?> selected="selected"<?php } ?>>AFFILIATIONS</option>
							</select>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Awards Image</div>
							<input name="image1" type="file" class="gridfield" id="image1"/>
							<input name="image11" type="hidden" class="grybutton" id="image11" value="<?php echo $image1; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable"><strong>SEO SETTINGS</strong></div>
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Title<span class="redmind"></span></div>
							<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
							<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Description<span class="redmind"></span></div>
							<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
						</label>
					</div>
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_awards" />
					<script type="text/javascript">
						$('#destination').select2();
						$('#package_theme').select2();
					</script>
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
					<td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" /></td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}	
	?>	

	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='client_testimonials') { 
	   // awards and recognition
	    if($_GET['id']!=''){
	        $id=trim($_GET['id']);
	        $select1='*';  
	        $where1='id='.$id.''; 
	        $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
	        $editresult=mysqli_fetch_array($rs1);
	        $title=trim($editresult['title']);  
	        $home_text=trim($editresult['home_text']);  
	        $designation=trim($editresult['designation']);  
	        $city=trim($editresult['city']);  
	        $description=trim($editresult['description']);  
	        $image1=trim($editresult['image1']);
	        $image2=trim($editresult['image2']);
  

            // meta title banner
			$meta_title=clean($editresult['meta_title']);
			$meta_description=clean($editresult['meta_description']);
			$meta_keyword=clean($editresult['meta_keyword']);


	    }
	    ?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Awards </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Testimonial Subject<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Testimonial Subject" value="<?php echo $title; ?>" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">User Name<span class="redmind"></span></div>
							<input name="home_text" type="text" class="gridfield validate" id="home_text" displayname="User Name" value="<?php echo $home_text; ?>" />
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Designation <span class="redmind"></span></div>
							<input name="designation" type="text" class="gridfield validate" id="designation" displayname="Designation Name" value="<?php echo $designation; ?>" />
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">City Name <span class="redmind"></span></div>
							<input name="city" type="text" class="gridfield validate" id="city" displayname="City Name" value="<?php echo $city; ?>" />
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Review Descripton<span class="redmind"></span></div>
							<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Star Rating</div>
							<select name="category" id="category"  class="gridfield " autocomplete="off" >
								<option value="5" <?php if($editresult['category']==5){ ?> selected="selected"<?php } ?>>5 Star</option>
								<option value="4" <?php if($editresult['category']==4){ ?> selected="selected"<?php } ?>>4 Star</option>
								<option value="3" <?php if($editresult['category']==3){ ?> selected="selected"<?php } ?>>3 Star</option>
								<option value="2" <?php if($editresult['category']==2){ ?> selected="selected"<?php } ?>>2 Star</option>
								<option value="1" <?php if($editresult['category']==1){ ?> selected="selected"<?php } ?>>1 Star</option>
							</select>
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">User Photo</div>
							<input name="image1" type="file" class="gridfield" id="image1" required="required" />
							<input name="image11" type="hidden" class="grybutton" id="image11" value="<?php echo $image1; ?>"/>
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Review Images</div>
							<input name="image2" type="file" class="gridfield" id="image2" required="required" />
							<input name="image21" type="hidden" class="grybutton" id="image21" value="<?php echo $image2; ?>"/>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable"><strong>SEO SETTINGS</strong></div>
						</label>
					</div>
					
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Title<span class="redmind"></span></div>
							<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
							<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Description<span class="redmind"></span></div>
							<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
						</label>
					</div>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_client_testimonials" />
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" 
							value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
						</td>
						<td style="padding-right:20px;">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" />
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}	
	?>	

	<?php
	if($_GET['action']=='addedit_cms' && $_GET['page']=='core_values') { 
	   // awards and recognition
	    if($_GET['id']!=''){
	        $id=trim($_GET['id']);
	        $select1='*';  
	        $where1='id='.$id.''; 
	        $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
	        $editresult=mysqli_fetch_array($rs1);
	        $title=trim($editresult['title']);  
	        $srn=trim($editresult['srn']);  
	        $description=trim($editresult['description']);  
	        $image1=trim($editresult['image1']);

	        // meta title banner
			$meta_title=clean($editresult['meta_title']);
			$meta_description=clean($editresult['meta_description']);
			$meta_keyword=clean($editresult['meta_keyword']);

	    }
	    ?>
		<div class="contentclass">
			<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Awards </h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="cms_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv">
						<label>
							<div class="gridlable">Sr. No.<span class="redmind"></span></div>
							<input name="srn" type="text" class="gridfield validate" id="srn" displayname="Testimonial Subject" value="<?php echo $srn; ?>" />
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Testimonial Subject<span class="redmind"></span></div>
							<input name="title" type="text" class="gridfield validate" id="title" displayname="Testimonial Subject" value="<?php echo $title; ?>" />
						</label>
					</div>
				
					<div class="griddiv">
						<label>
							<div class="gridlable">Review Descripton<span class="redmind"></span></div>
							<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
						</label>
					</div>

					<div class="griddiv">
						<label>
							<div class="gridlable">Images</div>
							<input name="image1" type="file" class="gridfield" id="image1" required="required" />
							<input name="image11" type="hidden" class="grybutton" id="image11" value="<?php echo $image1; ?>"/>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Status</div>
							<select id="status" name="status" class="gridfield " autocomplete="off"   >
								<option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
								<option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable"><strong>SEO SETTINGS</strong></div>
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Title<span class="redmind"></span></div>
							<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
							<input name="meta_keyword" type="text"  id="meta_keyword" class="gridfield" value="<?php  echo stripslashes($meta_keyword); ?>" >
						</label>
					</div>
					<div class="griddiv">
						<label>
							<div class="gridlable">Meta Description<span class="redmind"></span></div>
							<textarea name="meta_description" id="meta_description" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
						</label>
					</div>
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
					<input name="action" type="hidden" id="action" value="cms_add_core_values" />
				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" 
							value="Save" onclick="formValidation('addmasters','submitbtn','0');" />
						</td>
						<td style="padding-right:20px;">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="cms_alertspopupopenClose();" />
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php 
	}	
	?>	