<?php

include "inc.php";

include "config/logincheck.php";

if ($_GET['action'] == 'duplicate_roomtype' && $_GET['sectiontype'] == 'roomtype') { ?>

	<div class="delbg"><img src="images/Remove-64.png" /></div>

	<div class="contentclass">

		<h1 style="padding:15px 0px !important;"><?php echo $_REQUEST['sectiontype']; ?> is Already Exists!</h1>

		<div id="buttonsbox">

			<table border="0" align="center" cellpadding="0" cellspacing="0">

				<tr>

					<td align="center"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>

<?php }



if ($_GET['action'] == 'duplicate_hotelcategorytype' && $_GET['sectiontype'] == 'hotelcategorytype') { ?>

	<div class="delbg"><img src="images/Remove-64.png" /></div>

	<div class="contentclass">

		<h1 style="padding:15px 0px !important;"><?php echo $_REQUEST['sectiontype']; ?> is Already Exists!</h1>

		<div id="buttonsbox">

			<table border="0" align="center" cellpadding="0" cellspacing="0">

				<tr>

					<td align="center"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>

<?php }







if ($_GET['action'] == 'addedit_countrymaster' && $_GET['sectiontype'] == 'countrymaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1, _COUNTRY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$sortname = clean($editresult['sortname']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Country </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Sort Name<span class="redmind"></span></div>

						<input name="sortname" type="text" class="gridfield validate" id="sortname" displayname="Sort Name" value="<?php echo $sortname; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>
						<div class="gridlable">Set Default</div>
						<input name="setDefault" type="checkbox" value="1" class="gridfield" style="width: auto; float: left; margin: 2px; margin-right: 10px;" <?php if ($editresult['setDefault'] == 1) { ?> checked="checked" <?php } ?>>
					</label>
				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_countrymaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }







if ($_GET['action'] == 'addedit_leadsource' && $_GET['sectiontype'] == 'leadsource') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1, 'leadssourceMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Lead Source </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Lead&nbsp;Source&nbsp;Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Lead Source Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>



				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select name="status" id="status" type="text" class="gridfield" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<div class="griddiv">
				<div class="gridlable">
					<input type="checkbox" <?php if($editresult['setDefault']==1){ echo "checked"; } ?> name="setDefault" id="setDefault" value="1" style="display:inline-block;">&nbsp;Set Default</div>
					
					
				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_leadsource" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_statemaster' && $_GET['sectiontype'] == 'statemaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _STATE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);


		$status = clean($editresult['status']);

		$editcountryId = clean($editresult['countryId']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> State </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Country<span class="redmind"></span></div>

						<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selectstate();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, _COUNTRY_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editcountryId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>





				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select name="status" id="status" type="text" class="gridfield" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_statemaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_citymaster' && $_GET['sectiontype'] == 'citymaster') {


	if ($_GET['id'] != '') {



		$id = clean($_GET['id']);



		$select1 = '*';



		$where1 = 'id=' . $id . '';



		$rs1 = GetPageRecord($select1, _CITY_MASTER_, $where1);



		$editresult = mysqli_fetch_array($rs1);



		$name = clean($editresult['name']);

		$status = clean($editresult['status']);



		$editstateId = clean($editresult['stateId']);

		if ($editresult['countryId'] == 0) {

			$rs1 = GetPageRecord('countryId', _STATE_MASTER_, 'id=' . $editstateId . '');

			$statData = mysqli_fetch_array($rs1);

			$editcountryId = clean($statData['countryId']);
		} else {

			$editcountryId = clean($editresult['countryId']);
		}
	}



?>



	<div class="contentclass">



		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> City </h1>



		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">



			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>



						<div class="gridlable">Country<span class="redmind"></span></div>



						<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selectstate(this.value);">
							<option value="">Select</option>
							<?php

							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' deletestatus=0 and status=1 order by name asc';
							$rs = GetPageRecord($select, _COUNTRY_MASTER_, $where);
							while ($resListing = mysqli_fetch_array($rs)) {
							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editcountryId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>



							<?php } ?>



						</select>



					</label>

					<script type="text/javascript">
						function selectstate() {
							var countryId = $("#countryId").val();
						
								$('#stateIdCityMaster').load('loadstate.php?action=loadAllstatescitymaster&countryId='+countryId+'&selectId=<?php echo $editstateId; ?>');

							}

						<?php if ($editcountryId != '') { ?>

							selectstate(<?php echo $editcountryId; ?>);

						<?php } ?>
					</script>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">State<span class=""></span></div>



						<select id="stateIdCityMaster" name="stateId" class="gridfield " displayname="State" autocomplete="off" onchange="selectcity();">



							<option value="">Select</option>



							<?php



							$select = '';



							$where = '';



						$rs = '';



						$select = '*';



						$where = ' deletestatus=0 and status=1 order by name asc';



						$rs = GetPageRecord($select, _STATE_MASTER_, $where);



						while ($resListing = mysqli_fetch_array($rs)) {



						?>



							<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editstateId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>



						<?php } ?>



					</select>



					</label>



				</div>



				<div class="griddiv"><label>



						<div class="gridlable">Name<span class="redmind"></span></div>



						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo stripslashes($name); ?>" maxlength="100" />



					</label>



				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />



				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />



				<input name="action" type="hidden" id="action" value="addedit_citymaster" />



			</form>











		</div>



		<div id="buttonsbox" style="text-align:center;">



			<table border="0" align="right" cellpadding="0" cellspacing="0">



				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>



					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>



				</tr>



			</table>



		</div>
	</div>











<?php }



if ($_GET['action'] == 'addedit_phonetype' && $_GET['sectiontype'] == 'phonetype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PHONE_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Phone Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_phonetype" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_emailtype' && $_GET['sectiontype'] == 'emailtype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _EMAIL_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Email Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_emailtype" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_attachmenttype' && $_GET['sectiontype'] == 'attachmenttype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ATTACHMENT_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Attachment Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_attachmenttype" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_suppliertype' && $_GET['sectiontype'] == 'suppliertype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _SUPPLIERS_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Supplier Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_suppliertype" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_querydestination' && $_GET['sectiontype'] == 'querydestination') {
	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id=' . $id . '';
		$rs1 = GetPageRecord($select1, _DESTINATION_MASTER_, $where1);
		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']);
		$description = clean(preg_replace('|\\\\|', '', $editresult['description']));
	}
?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Destination</h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv"><label>
						<div class="gridlable">Country&nbsp;<span class="redmind"></span></div>
						<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off" onchange="getStateName();" onclick="getStateNameselected();">
							<option value="">Select</option>
							<?php
							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' deletestatus=0 and status=1 order by name asc';
							$rs = GetPageRecord($select, _COUNTRY_MASTER_, $where);
							while ($resListing = mysqli_fetch_array($rs)) {
							?>
								<option value="<?php echo ($resListing['id']); ?>" <?php if ($resListing['id'] == $defaultCountryId && $editresult['countryId'] == '') { echo 'selected="selected"'; } elseif ($resListing['id'] == $editresult['countryId']) { ?>selected="selected" <?php } else { echo ''; } ?>><?php echo ($resListing['name']); ?></option>
							<?php } ?>
						</select>
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">State&nbsp;<span class=""></span></div>
				<select id="stateIddest" name="stateIddest" class="gridfield " displayname="State" autocomplete="off">
					<option value="">Select</option>
					<?php
									$rs = "";

									$rs = GetPageRecord('*', _STATE_MASTER_, ' id="' .$editresult['stateId']. '" and status=1 and deletestatus=0 order by name asc');

									while ($stateData = mysqli_fetch_array($rs)) {

									?>

										<option value="<?php echo strip($stateData['id']); ?>" <?php if($stateData['id'] == $editresult['stateId']){?> selected="selected" <?php } ?> ><?php echo strip($stateData['name']); ?></option>

									<?php } ?>
				</select>
					</label>
				</div>
				<script>
					function getStateName() {

					var countryId = $('#countryId').val();

					$('#stateIddest').load('loadstate.php?action=destinationMasterstate&countryId=' +countryId+ '&selectedId=<?php echo $editresult['stateId']; ?>');

					}
					getStateName();

					function getStateNameselected() {

					var countryId = $('#countryId').val();

					$('#stateId').load('loadstate.php?action=destinationMasterstate&countryId=' +countryId+ '&selectedId=<?php echo $editresult['stateId']; ?>');

					}
				</script>

				<!-- removed by mohd islam tickat id 1646 rizwan -->
				
				<!-- <div class="griddiv"><label>
						<div class="gridlable">Tier<span class="redmind"></span></div>
						<select id="gradeId" name="gradeId" class="gridfield validate" displayname="Tier Name" autocomplete="off">
							<option value="tier1">Tier 1</option>
							<option value="tier2">Tier 2</option>
							<option value="tier3">Tier 3</option>
						</select>
					</label>
				</div> -->
					<div class="griddiv"><label>
							<div class="gridlable w100">Destination&nbsp;Name<span class="redmind"></span></div>
							<input name="name" type="text" class="gridfield validate" id="name" displayname="Destination Name" value="<?php echo $name; ?>" maxlength="100" />
						</label>
					</div>
					<div class="griddiv"><label>
							<div class="gridlable">Description</div>
							<textarea name="description22" rows="3" class="gridfield " displayname="Name" id="description22"><?php echo $description; ?></textarea>
						</label>
					</div>


					<div class="griddiv"><label>
							<div class="gridlable" style="width: 170px;">Weather Information</div>
							<textarea name="weatherinfo" rows="3" class="gridfield " displayname="Weather Information" id="weatherinfo"><?php echo stripslashes($editresult['weatherinfo']); ?></textarea>
						</label>
					</div>
					<div class="griddiv"><label>
							<div class="gridlable" style="width: 170px;">Additional Information</div>
							<textarea name="additionalInfo" rows="3" class="gridfield " displayname="Additional Information" id="additionalInfo"><?php echo stripslashes($editresult['additionalInfo']); ?></textarea>
						</label>
					</div>
					

					<div class="griddiv"><label>
							<div class="gridlable" >Set Default</div>
							<input name="setDefault" type="checkbox" value="1" class="gridfield" style="width: auto; float: left; margin: 2px; margin-right: 10px;" <?php if ($editresult['setDefault'] == 1) { ?> checked="checked" <?php } ?>>
						</label>
					</div>
					<div class="griddiv"><label>
							<div class="gridlable">status</div>
							<select name='status' class="gridfield">
								<option value=1 <?php if ($editresult['status'] == 1 || $id == '') {
													echo "selected";
												} ?>>Active</option>
								<option value=0 <?php if ($editresult['status'] == '0') {
													echo "selected";
												} ?>>InActive</option>
							</select>
						</label>
					</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_querydestination" />
				<input name="queryDashboard" type="hidden" id="queryDashboard" value="<?php echo $_REQUEST['queryDashboard']; ?>" />

				<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['destinationImage']; ?>" />
			</form>

<script src="tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "#description22"
		});   
	</script>

		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
<?php
}



// started new destination add for query form sec

if($_GET['action']=='addedit_querydestinationFromQuery' && $_GET['sectiontype']=='querydestination'){
	 
	if($_GET['id']!=''){
	$id=clean($_GET['id']);
	$select1='*';
	$where1='id='.$id.'';
	$rs1=GetPageRecord($select1,_DESTINATION_MASTER_,$where1);
	$editresult=mysqli_fetch_array($rs1);
	$name=clean($editresult['name']);
	$description=clean($editresult['description']);
	}

	?>


	<div class="contentclass">
		<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Destination</h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
			<!-- <form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters"> -->

				<div class="griddiv"><label>
					<div class="gridlable">Country&nbsp;<span class="redmind"></span></div>
					<select id="adfq_countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off"   >
						<option value="">Select</option>
						<?php
						$select='';
						$where='';
						$rs='';
						$select='*';
						$where=' deletestatus=0 and status=1 order by name asc';
						$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where);
						while($resListing=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo ($resListing['id']); ?>" <?php if($resListing['id']==$defaultCountryId && $editresult['countryId']==''){ echo 'selected="selected"'; }elseif($resListing['id']==$editresult['countryId']){ ?>selected="selected"<?php }else{ echo ''; } ?>><?php echo ($resListing['name']); ?></option>
						<?php } ?>
					</select>
				</label>
			</div>
			<div class="griddiv"><label>
				<div class="gridlable">Destination Name<span class="redmind"></span></div>
				<input name="name" type="text" class="gridfield validate" id="adfq_name" displayname="Destination Name" value="<?php echo $name; ?>" maxlength="100" />
			</label>
		</div>
		 




	</div>
	<div id="buttonsbox"  style="text-align:center;">
	<table border="0" align="right" cellpadding="0" cellspacing="0">
	<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="addDestFromQuery();" /></td>
	<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="masters_alertspopupopenClose();" /></td>
	</tr>
	</table>
	</div></div>
	<div id="loadBox" style="display:none;"></div>

	<script type="text/javascript">
		function addDestFromQuery(){ 
			var countryId = document.getElementById('adfq_countryId').value;
			var name = document.getElementById('adfq_name').value;
			
			$('#loadBox').load('masters_frmaction.php?action=addedit_querydestinationFromQuery&countryId='+countryId+'&name='+encodeURI(name));	 
		
		} 
	</script>

	<?php 

}

// ended new destination add for query form sec





// Destination languages starts

if($_GET['action']=='addedit_querydestinationLanguage222' && $_GET['sectiontype']=='querydestination'){ 

	if($_GET['id']!=''){
		$id=clean($_GET['id']);
		$select1='*';  
		$where1='id='.$id.''; 
		$rs1=GetPageRecord($select1,_DESTINATION_MASTER_,$where1); 
		$editresult=mysqli_fetch_array($rs1);
		$name=clean($editresult['name']);   
		$description=clean($editresult['description']);  
	}
?>
	<style type="text/css">
	.saveBtn{ font-size: 20px!important;
	color: #006699;
	cursor: pointer;
	/* float: right; */
	display: flex;
	padding: 5px 7px;
	border: 0px solid #ddd;
	border-radius: 1px;
	}
	</style>
	<div class="contentclass">
	<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> &nbsp;<?php echo $editresult['name']; ?></h1>
	<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
		<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">
				<tbody>
					<tr>
						<td>S.No</td>
						<td>Language</td>
						<td>Language Description</td>
						<td>Action</td>
					</tr>
					<?php
					$destinationIdForAdd=$_GET['id'];
					$rs1=GetPageRecord('*','destinationLanguageMaster','1 and destinationId="'.$_GET['id'].'"');
					$editresult=mysqli_fetch_array($rs1);
					$addStatus='';
					$editId='';
					if(mysqli_num_rows($rs1) < 1){
						$addStatus='yes';
						$editId=$_GET['id'];
					}else{
						$addStatus='no';
						$editId=$editresult['id'];
						}
					?>
	<?php if($addStatus=='yes' || $editresult['lang_01']!='' || $editresult['lang_01']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,' 1 and id=1 and status=1 and deletestatus=0');
	$languageDetails=mysqli_fetch_array($rs);
	?>
	<tr>
		<td bgcolor="#FFFFFF">1</td>
		<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
		<td bgcolor="#FFFFFF"><div id="textlang1">
			<?php echo html_entity_decode($editresult['lang_01']); ?>
		</div><div id="languageinput1" style="display:none;">
		<textarea rows="5" id="langInput1" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"  placeholder="Remark"><?php echo stripslashes(html_entity_decode($editresult['lang_01'])); ?></textarea>
	</div> </td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn1" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','1');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php if ($addStatus=='yes') {  ?>

	<div style="display: none;" class="saveBtn" id="saveBtn1" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','1','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn1" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','1','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}  ?>
	</td>
	</tr>
	<?php  } ?>
	<?php if($addStatus=='yes' || $editresult['lang_02']!='' || $editresult['lang_02']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=2');
	$languageDetails=mysqli_fetch_array($rs);
	?>
	<tr>
	<td bgcolor="#FFFFFF">2</td>
	<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
	<td bgcolor="#FFFFFF"><div id="textlang2">
	<?php echo html_entity_decode($editresult['lang_02']); ?>
	</div><div id="languageinput2" style="display:none;">
	<textarea rows="5" id="langInput2" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_02'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn2" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','2');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php if ($addStatus=='yes') {  ?>

	<div style="display: none;" class="saveBtn" id="saveBtn2" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','2','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn2" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','2','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php } ?>
	</tr>
	<?php } ?>
	<?php if($addStatus=='yes' || $editresult['lang_03']!='' || $editresult['lang_03']==''){
			$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=3');
		$languageDetails=mysqli_fetch_array($rs);?>
		<tr>
			<td bgcolor="#FFFFFF">3</td>
			<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
			<td bgcolor="#FFFFFF"><div id="textlang3">
				<?php echo html_entity_decode($editresult['lang_03']); ?>
			</div><div id="languageinput3" style="display:none;">
			<textarea rows="5" id="langInput3" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_03'])); ?></textarea>
		</div></td>
		
		<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn3" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','3');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
		<?php if ($addStatus=='yes') {  ?>
		
		<div style="display: none;" class="saveBtn" id="saveBtn3" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','3','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
		<?php	}else{  ?>
		<div style="display: none;" class="saveBtn" id="saveBtn3" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','3','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
		<?php } ?>
	</tr>
	<?php

	} ?>
	<?php if($addStatus=='yes' || $editresult['lang_04']!='' || $editresult['lang_04']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=4');
	$languageDetails=mysqli_fetch_array($rs); ?>
	<tr>
		<td bgcolor="#FFFFFF">4</td>
		<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
		<td bgcolor="#FFFFFF"><div id="textlang4">
			<?php echo ($editresult['lang_04']); ?>
		</div><div id="languageinput4" style="display:none;">
		<textarea rows="5" id="langInput4" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(($editresult['lang_04'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn4" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','4');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php if ($addStatus=='yes') {  ?>

	<div style="display: none;" class="saveBtn" id="saveBtn4" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','4','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn4" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','4','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php } ?>
	</tr>
	<?php } ?>
	<?php if($addStatus=='yes' || $editresult['lang_05']!='' || $editresult['lang_05']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=5');
	$languageDetails=mysqli_fetch_array($rs);?>
	<tr>
	<td bgcolor="#FFFFFF">5</td>
	<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
	<td bgcolor="#FFFFFF"><div id="textlang5">
		<?php echo html_entity_decode($editresult['lang_05']); ?>
	</div><div id="languageinput5" style="display:none;">
	<?php echo strip($editresult['lang_05']); ?>
	<textarea rows="5" id="langInput5" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_05'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn5" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','5');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php	if($addStatus=='yes'){  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn5" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','5','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn5" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','5','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php } ?>
	</tr>
	<?php  }?>
	<?php if($addStatus=='yes' || $editresult['lang_06']!='' || $editresult['lang_06']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=6');
	$languageDetails=mysqli_fetch_array($rs); ?>
	<tr>
	<td bgcolor="#FFFFFF">6</td>
	<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
	<td bgcolor="#FFFFFF"><div id="textlang6">
	<?php echo html_entity_decode($editresult['lang_06']); ?>
	</div><div id="languageinput6" style="display:none;">

	<textarea rows="5" id="langInput6" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_06'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn6" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','6');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php	if($addStatus=='yes'){  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn6" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','6','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn6" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','6','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php }  ?>
	</tr>
	<?php } ?>
	<?php if($addStatus=='yes' || $editresult['lang_07']!='' || $editresult['lang_07']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=7');
	$languageDetails=mysqli_fetch_array($rs); ?>
	<tr>
	<td bgcolor="#FFFFFF">7</td>
	<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
	<td bgcolor="#FFFFFF"><div id="textlang7">
	<?php echo html_entity_decode($editresult['lang_07']); ?>
	</div><div id="languageinput7" style="display:none;">
	<textarea rows="5" id="langInput7" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_07'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn7" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','7');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php	if($addStatus=='yes'){  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn7" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','7','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn7" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','7','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php } ?>
	</tr>
	<?php } ?>
	<?php if($addStatus=='yes' || $editresult['lang_08']!='' || $editresult['lang_08']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=8');
	$languageDetails=mysqli_fetch_array($rs); ?>
	<tr>
	<td bgcolor="#FFFFFF">8</td>
	<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
	<td bgcolor="#FFFFFF"><div id="textlang8">
	<?php echo html_entity_decode($editresult['lang_08']); ?>
	</div><div id="languageinput8" style="display:none;">

	<textarea rows="5" id="langInput8" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_08'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn8" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','8');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php	if($addStatus=='yes'){  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn8" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','8','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn8" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','8','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php } ?>
	</tr>
	<?php } ?>
	<?php if($addStatus=='yes' || $editresult['lang_09']!='' || $editresult['lang_09']==''){
	$rs=GetPageRecord('*',_LANGUAGE_MASTER_,'1 and id=9');
	$languageDetails=mysqli_fetch_array($rs); ?>
	<tr>
	<td bgcolor="#FFFFFF">9</td>
	<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
	<td bgcolor="#FFFFFF"><div id="textlang9">
	<?php echo html_entity_decode($editresult['lang_09']); ?>
	</div><div id="languageinput9" style="display:none;">
	<textarea rows="5" id="langInput9" style="font-size: 12px; padding: 6px; width: 516px; margin: 0px; height: 162px;"><?php echo stripslashes(html_entity_decode($editresult['lang_09'])); ?></textarea>
	</div></td>

	<td bgcolor="#FFFFFF"><div class="editBtn" id="editBtn9" style="display: inline-flex; color: #006699;padding: 5px;border: 1px solid;" onclick="editDestinationLanguage('<?php echo $editId; ?>','9');"><i class="fa fa-pencil" aria-hidden="true"></i></div>
	<?php	if($addStatus=='yes'){  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn9" style="" onclick="saveDestinationLanguage('<?php echo $destinationIdForAdd; ?>','9','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div>
	<?php	}else{  ?>
	<div style="display: none;" class="saveBtn" id="saveBtn9" style="" onclick="saveDestinationLanguage('<?php echo $editresult['id']; ?>','9','<?php echo $addStatus; ?>');"><i class="fa fa-save" aria-hidden="true"></i></div></td>
	<?php } ?>
	</tr>
	<?php } ?>

	<?php if(empty($editresult['id']) && $addStatus!='yes'){?>
	<tr>
	<td bgcolor="#FFFFFF" colspan="4" align="center" >No Record Found....</td>
	</tr>
	<?php } ?>

	</tbody>
	<style>
	.tbl td{
	padding: 4px 10px!important;
	}
	</style>
	</table>
	<div id="updateLanguage"></div>
	<script type="text/javascript">
	function editDestinationLanguage(id,sno) {
		$('#languageinput'+sno).show();
		$('#textlang'+sno).hide();
		$('#saveBtn'+sno).show();
		$('#editBtn'+sno).hide();
	}
	function saveDestinationLanguage(id,sno,addStatus) {
		var lang_01Input = $('#langInput'+sno).val();
		$('#updateLanguage').load('serviceLanguageUpdate.php?action=saveDestinationLanguage&id='+encodeURI(id)+'&lanName='+encodeURI(lang_01Input)+'&sno='+sno+'&addStatus='+addStatus);

		$('#textlang'+sno).text(lang_01Input);
		$('#saveBtn'+sno).hide();
		$('#editBtn'+sno).show();

		$('#languageinput'+sno).hide();
		$('#textlang'+sno).show();
		
	}
	</script>
	</form>


	</div>
	<div id="buttonsbox"  style="text-align:center;">
	<table border="0" align="right" cellpadding="0" cellspacing="0">
	<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
	</tr>
	</table>
	</div>
</div>

<?php 
}

// Destination languages ends

if ($_GET['action'] == 'addedit_querydestinationLanguage' && $_REQUEST['sectiontype']=="querydestination") {

	if($_GET['id']!=''){
		$id=clean($_GET['id']);
		$select1='*';  
		$where1='id='.$id.''; 
		$rs1=GetPageRecord($select1,_DESTINATION_MASTER_,$where1); 
		$editresult=mysqli_fetch_array($rs1);
		$name=clean($editresult['name']);   
		$description=clean($editresult['description']);  
	} 
	?>
	<style type="text/css">
		.saveBtn {
			font-size: 20px !important;
			color: #006699;
			cursor: pointer;
			/* float: right; */
			display: flex;
			padding: 5px 7px;
			border: 0px solid #ddd;
			border-radius: 1px;
		}
	</style>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> &nbsp;<?php echo $name; ?> Details</h1>
		<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">
					<tbody>
						<tr>
							<td>S.No</td>
							<td>Language</td>
							<td>Description</td>
						</tr>
						<?php
						// $count = 1;
						$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
						$totalrow = mysqli_num_rows($rs);
						while ($languageDetails = mysqli_fetch_array($rs)) {
							$count = $languageDetails['id'];

							$rs11 = GetPageRecord('*', 'destinationLanguageMaster', '1 and destinationId="' .$id. '"');
							$editresult = mysqli_fetch_array($rs11);
							?>
							<tr>
								<td bgcolor="#FFFFFF"><?php echo $languageDetails['id']; ?></td>
								<td bgcolor="#FFFFFF"><?php echo $languageDetails['name'] ?></td>
								<td bgcolor="#FFFFFF">
									<textarea rows="4" style="width: 100%;border-color: #e0e0e0;outline: none;" name="description<?php echo $count; ?>" class="gridfield" id="description<?php echo $count ?>"><?php echo $editresult['lang_0' . $count]; ?></textarea>
								</td>
							</tr>
							<?php 
							//$count++;
						} ?>
					</tbody>
					<style>
						.tbl td {
							padding: 4px 10px !important;
						}
					</style>
				</table>
				<input type="hidden" name="action" value="saveDestinationLanguage">
				<input type="hidden" name="destinationId" value="<?php echo encode($_REQUEST['id'])  ?>">
				<input type="hidden" name="moduleName" value="<?php echo $_REQUEST['sectiontype']  ?>">

				<div style="float: right;">
				<input type="submit" name="saveDestination" value="Save" class="bluembutton submitbtn">
				<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
				</div>
			</form>
		</div>
	</div>

	<?php 
}

if ($_GET['action'] == 'addedit_queryActivityLanguage' && $_REQUEST['sectiontype']=="queryActivity") {

	$id = clean($_GET['id']);

	$select1 = '*';

	$where1 = 'id="'.$id.'"';

	$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_, $where1);


	$editresult = mysqli_fetch_array($rs1);


	$name = clean($editresult['otherActivityName']);


	$rsdes = GetPageRecord('*', _DESTINATION_MASTER_, 'name="' . $_REQUEST['destinationName'] . '"');



	$destinationresult = mysqli_fetch_array($rsdes);



	$destinationId = $destinationresult['id'];



	?>



	<style type="text/css">
		.saveBtn {
			font-size: 20px !important;

			color: #006699;

			cursor: pointer;

			/* float: right; */

			display: flex;

			padding: 5px 7px;

			border: 0px solid #ddd;

			border-radius: 1px;

		}
	</style>


	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> &nbsp;<?php echo $name; ?></h1>

		<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">
					<tbody>
						<tr>
							<td>S.No</td>
							<td>Language</td>
							<td>SightSeeing Description</td>
						</tr>
						<?php
						// $count = 1;
						$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
						$totalrow = mysqli_num_rows($rs);
						while ($languageDetails = mysqli_fetch_array($rs)) {
							$count = $languageDetails['id'];

							$rs11 = GetPageRecord('*', 'activityLanguageMaster', '1 and ActivityId="' .$id. '"');
							$editresult = mysqli_fetch_array($rs11);
							?>
							<tr>
							
								<td bgcolor="#FFFFFF"><?php echo $languageDetails['id']; ?></td>
								<td bgcolor="#FFFFFF"><?php echo $languageDetails['name'] ?></td>
								<td bgcolor="#FFFFFF">
									<textarea rows="4" style="width: 100%;border-color: #e0e0e0;outline: none;" name="description<?php echo $count; ?>" class="gridfield" id="description<?php echo $count ?>"><?php echo strip_tags($editresult['lang_0' . $count]); ?></textarea>
								</td>
								
								<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
							</tr>
							
							<?php 
							// $count++;
						} ?>
					</tbody>
				
					<style>
						.tbl td {
							padding: 4px 10px !important;
						}
					</style>
				</table>
				<input type="hidden" name="action" value="saveActivityLanguage">
				<input type="hidden" name="destinationId" value="<?php echo $destinationId  ?>">
				<input type="hidden" name="moduleName" value="<?php echo $_REQUEST['moduleName']  ?>">
				<input type="hidden" name="ActivityId" value="<?php echo encode($id); ?>">

				<div style="float: right;">

				<input type="submit" name="saveActivity" value="Save" class="bluembutton submitbtn">

				<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
				</div>
				
			</form>
			
			
		</div>
	</div>

<?php }


if ($_GET['action'] == 'addedit_queryEntranceLanguage' && $_GET['sectiontype'] == 'queryEntrance') {

	$id = clean($_GET['id']);

	$select1 = '*';

	$where1 = 'id=' . $id . '';

	$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_ENTRANCE_MASTER_, $where1);


	$editresult = mysqli_fetch_array($rs1);


	$name = clean($editresult['entranceName']);


	$rsdes = GetPageRecord('*', _DESTINATION_MASTER_, 'name="' . $_REQUEST['destinationName'] . '"');



	$destinationresult = mysqli_fetch_array($rsdes);



	$destinationId = $destinationresult['id'];



?>



	<style type="text/css">
		.saveBtn {
			font-size: 20px !important;

			color: #006699;

			cursor: pointer;

			/* float: right; */

			display: flex;

			padding: 5px 7px;

			border: 0px solid #ddd;

			border-radius: 1px;

		}
	</style>



	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> &nbsp;<?php echo $name; ?></h1>


		<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">


				<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">
					<tbody>
						<tr>

							<td>S.No</td>

							<td>Language</td>

							<td>Monument Description</td>

						</tr>

						<?php
						// $count = 1;
						$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
						$totalrow = mysqli_num_rows($rs);
						while ($languageDetails = mysqli_fetch_array($rs)) {
							$count = $languageDetails['id'];

							$rs1 = GetPageRecord('*', 'entranceLanguageMaster', '1 and entranceId="' . $id . '"');
							$editresult = mysqli_fetch_array($rs1);
						?>
							<tr>
								<td bgcolor="#FFFFFF"><?php echo $count; ?></td>
								<td bgcolor="#FFFFFF"><?php echo $languageDetails['name'] ?></td>
								<td bgcolor="#FFFFFF">
									<textarea rows="4" style="width: 100%;border-color: #e0e0e0;outline: none;" name="description<?php echo $count; ?>" class="gridfield" id="description<?php echo $count ?>"><?php echo $editresult['lang_0' . $count]; ?></textarea>
								</td>
								<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
							</tr>
						<?php 
						//$count++;
						} ?>
					</tbody>
					<style>
						.tbl td {
							padding: 4px 10px !important;
						}
					</style>
				</table>
				<input type="hidden" name="action" value="saveEntranceLanguage">
				<input type="hidden" name="destinationId" value="<?php echo $destinationId  ?>">
				<input type="hidden" name="moduleName" value="<?php echo $_REQUEST['moduleName']  ?>">
				<input type="hidden" name="entranceId" value="<?php echo encode($id); ?>">

				<div style="float: right;">

					<input type="submit" name="saveentrance" value="Save" class="bluembutton submitbtn">

					<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

			</form>

		</div>

	</div>


<?php }




if ($_GET['action'] == 'addedit_hotelType' && $_GET['sectiontype'] == 'hotelType') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HOTEL_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$uploadKeyword = clean($editresult['uploadKeyword']);
		$proposalPriority = clean($editresult['proposalPriority']);
		$status = clean($editresult['status']);
	}

?>
	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Hotel Type</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv">

					<label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Upload&nbsp;Keyword<span class="redmind"></span></div>
						<input name="uploadKeyword" type="text" class="gridfield validate" id="uploadKeyword" displayname="Upload Keyword" value="<?php echo $uploadKeyword; ?>" maxlength="100" />
					</label>
				</div>

				<div class="griddiv"><label>
						<div class="gridlable">Proposal Priority<span class="redmind"></span></div>
						<input name="proposalPriority" type="text" class="gridfield validate" id="proposalPriority" displayname="Proposal Priority" value="<?php echo $proposalPriority; ?>" maxlength="100" />
					</label>
				</div>
				
				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_<?php echo $_GET['sectiontype']; ?>" />

			</form>

		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>

<?php
}

if ($_GET['action'] == 'addedit_hotelCategory' && $_GET['sectiontype'] == 'hotelCategory') {

	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id=' . $id . '';
		$rs1 = GetPageRecord($select1, _HOTEL_CATEGORY_MASTER_, $where1);
		$editresult = mysqli_fetch_array($rs1);

		$hotelCategory = clean($editresult['hotelCategory']);
		$uploadKeyword = clean($editresult['uploadKeyword']);
		$proposalCategory = clean($editresult['proposalCategory']);
		$status = clean($editresult['status']);
	}
?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Hotel Category</h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv"><label>
						<div class="gridlable">Hotel&nbsp;Category<span class="redmind"></span></div>
						<input name="hotelCategory" type="number" class="gridfield validate" id="hotelCategory" displayname="Hotel Category" value="<?php echo $hotelCategory; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Upload&nbsp;Keyword<span class="redmind"></span></div>
						<input name="uploadKeyword" type="text" class="gridfield validate" id="uploadKeyword" displayname="Upload Keyword" value="<?php echo $uploadKeyword; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Proposal&nbsp;Category&nbsp;Name<span class="redmind"></span></div>
						<input name="proposalCategory" type="text" class="gridfield validate" id="proposalCategory" displayname="Proposal Category Name" value="<?php echo $proposalCategory; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">
							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>
							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>
						</select>
					</label>
				</div>
				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_<?php echo $_GET['sectiontype']; ?>" />
			</form>

		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>
<?php
}


if ($_GET['action'] == 'addedit_grademaster' && $_GET['sectiontype'] == 'grademaster') {

	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id=' . $id . '';
		$rs1 = GetPageRecord($select1, 'gradeMaster', $where1);
		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$designation = clean($editresult['designation']);
		$tier1 = clean($editresult['tier1']);
		$tier2 = clean($editresult['tier2']);
		$tier3 = clean($editresult['tier3']);
		$status = clean($editresult['status']);
	}

?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Grade Master</h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable">Name<span class="redmind"></span></div>
						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
					</label>
				</div>
				<!-- <div class="griddiv"><label>
					<div class="gridlable">Designation<span class="redmind"></span></div>
					<input name="designation" type="text" class="gridfield validate" id="designation" displayname="Designation" value="<?php echo $designation; ?>" maxlength="100" />
					</label>
				</div> -->
				<div class="griddiv"><label>
						<div class="gridlable">Tier&nbsp;1&nbsp;Eligibility<span class="redmind"></span></div>
						<input name="tier1" type="text" class="gridfield validate" id="tier1" displayname="Tier 1 Eligibility" value="<?php echo $tier1; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Tier&nbsp;2&nbsp;Eligibility<span class="redmind"></span></div>
						<input name="tier2" type="text" class="gridfield validate" id="tier2" displayname="Tier 2 Eligibility" value="<?php echo $tier2; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Tier&nbsp;3&nbsp;Eligibility<span class="redmind"></span></div>
						<input name="tier3" type="text" class="gridfield validate" id="tier3" displayname="Tier 3 Eligibility" value="<?php echo $tier3; ?>" maxlength="100" />
					</label>
				</div>


				<div class="griddiv">
					<label>
						<div class="gridlable">status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">
							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>
							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>
						</select>
					</label>
				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_<?php echo $_GET['sectiontype']; ?>" />
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
<?php
}

if ($_GET['action'] == 'addedit_tourtype' && $_GET['sectiontype'] == 'tourtype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _TOUR_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Tour Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>


				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>




				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_tourtype" />

			</form>
		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if($_GET['action']=='addedit_amenities' && $_GET['sectiontype']=='amenities'){ 

 

	if($_GET['id']!=''){
	
	$id=clean($_GET['id']);
	
	$select1='*';  
	
	$where1='id='.$id.' order by id desc'; 
	
	$rs1=GetPageRecord($select1,_AMENITIES_MASTER_,$where1); 
	
	$editresult=mysqli_fetch_array($rs1);
	
	$name=clean($editresult['name']);   
	$amenityImage=$editresult['image'];   
	$status=clean($editresult['status']);   
	$DefaultAmenity=clean($editresult['defaultAmenity']);   
	
	}
	
	?>
	
	<div class="contentclass">
	
	<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Amenities <?php echo $editresult['id']?> </h1>
	
	  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
	
	<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
	
	 <div class="griddiv"><label>
	
		<div class="gridlable">Name<span class="redmind"></span></div>
	
		<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	
		</label>
	
		</div>
	
		<div class="griddiv">
	
	<label> 
	
	<div class="gridlable">status</div>
	
	<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>"  style="width: 100%;"> 	
	
	<option value="1" <?php if($status=='1'){ ?>selected="selected"<?php } ?>>Active</option>
	
	<option value="0" <?php if($status=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
	
	</select></label>
	
	</div>
	
	<div class="griddiv">
	<label>
	<div style="display: grid;"><?php if($_REQUEST['id']==''){  }else{ ?> <img align="left" style="display: inline-block;" src="packageimages/<?php echo $amenityImage; ?>" alt="" width="85px" height="70px">  <?php } ?></div>
		<div class="gridlable">Amenity Image<span class="redmind"></span></div>
		<input name="amenityImage" type="file" class="gridfield" id="amenityImage" value="<?php echo $amenityImage; ?>" displayname="Upload Amenity Image"/>
	
		<input type="hidden" name="oldamenityImage" id="oldamenityImage" value="<?php if($editresult['image']!=''){echo $editresult['image'];} ?>" />
	
		</label>
	
		</div>
	
	<input type="checkbox" name="DefaultAmenity" id="DefaultAmenity" value="1" <?php if($DefaultAmenity == 1) { ?> checked <?php } ?>  style="display: inline-block;"> Set Default
	
	
	
	 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
	
	 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
	
	 <input name="action" type="hidden" id="action" value="addedit_amenities" /> 
	
	</form>

	  </div>
	
	  <div id="buttonsbox"  style="text-align:center;">
	
	 <table border="0" align="right" cellpadding="0" cellspacing="0">
	
		  <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
	
			<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
	
		  </tr>
	
	   </table>
	
	</div></div>
	
		<?php }


// add expense head master code started
if($_GET['action']=='addedit_expenseHead' && $_GET['sectiontype']=='expenseHead'){ 

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'expenseHeadMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Expense Head </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Expense Head<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>


				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>




				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_expenseHead" />

			</form>
		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>
	
		<?php }
// add expense head master code ende



// add expense type masteer code started
if ($_GET['action'] == 'addedit_expenseType' && $_GET['sectiontype'] == 'expenseType') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'expenseTypeMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);


		$status = clean($editresult['status']);
		$editcountryId = clean($editresult['expenseHeadId']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Expense Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Expense Head<span class="redmind"></span></div>

						<select id="expenseHeadId" name="expenseHeadId" class="gridfield validate" displayname="Expense Head" autocomplete="off" onchange="selectstate();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, 'expenseHeadMaster', $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editcountryId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Expense Type<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>





				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select name="status" id="status" type="text" class="gridfield" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_expenseType" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

// add expense type master code ended

if ($_GET['action'] == 'addedit_roomtype' && $_GET['sectiontype'] == 'roomtype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ROOM_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$maxoccupancy = clean($editresult['maxoccupancy']);
		$bedding = clean($editresult['bedding']);
		$size = clean($editresult['size']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Room Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Room&nbsp;Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Room&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>
				<!-- adding two fields in room type master Maximum Occupancy and Bedding -->
				<div class="griddiv"><label>

						<div class="gridlable">Maximum&nbsp;Occupancy</div>

						<textarea name="maxoccupancy" rows="2" class="gridfield" id="maxoccupancy"><?php echo $maxoccupancy; ?></textarea>

						<!-- <input name="maxoccupancy" type="text" class="gridfield " id="maxoccupancy" displayname="Maximum&nbsp;Occupancy" value="<?php echo $maxoccupancy; ?>" maxlength="100" /> -->

					</label>

				</div>
				<div class="griddiv"><label>

						<div class="gridlable">Bedding</div>

						<input name="bedding" type="text" class="gridfield" id="bedding" displayname="Bedding" value="<?php echo $bedding; ?>" maxlength="100" />

					</label>
				</div>
				<div class="griddiv"><label>

						<div class="gridlable">Size</div>

						<input name="size" type="text" class="gridfield" id="size" displayname="size" value="<?php echo $size; ?>" maxlength="100" />

				</label>

				</div>


				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo clean($editresult['id']); ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_roomtype" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_transferType' && $_GET['sectiontype'] == 'transferType') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'transferTypeMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Transfer Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Transfer&nbsp;Type<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Room&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo clean($editresult['id']); ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_transferType" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }




// start payment type master add sec.
if ($_GET['action'] == 'addedit_PaymentType' && $_GET['sectiontype'] == 'PaymentType') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'paymentTypeMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Payment Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div style="width: 44%;" class="gridlable">Payment&nbsp;Type&nbsp; Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Payment&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo clean($editresult['id']); ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_PaymentType" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }
// ended payment type master add sec.



if ($_GET['action'] == 'duplicate_roomtype' && $_GET['sectiontype'] == 'roomtype') {



?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										}
										echo ucfirst($_GET['sectiontype']); ?> </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">



		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }





if ($_GET['action'] == 'addedit_currencymaster' && $_GET['sectiontype'] == 'currencymaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _QUERY_CURRENCY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$currencyCode = clean($editresult['currencyCode']);

		$status = clean($editresult['status']);

		$currencyValue = clean($editresult['currencyValue']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;padding: 5px;"><?php if ($_REQUEST['id'] != '') {
														echo 'Edit';
													} else {
														echo 'Add';
													} ?> Currency </h1>

		<div id="contentbox" class="addeditpagebox" style="padding: 5px;overflow:auto;text-align:left;margin-bottom:0px;">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellspacing="0" cellpadding="5">

					<tr>

						<td>
							<div class="griddiv"><label>

									<div class="gridlable">Country&nbsp;<span class="redmind"></span></div>

									<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off"  >
										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										$where = ' deletestatus=0 and status=1 order by name asc';

										$rs = GetPageRecord($select, _COUNTRY_MASTER_, $where);

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo ($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['country']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

										<?php } ?>

									</select>

								</label>

							</div>
						</td>

					</tr>

					<tr>

						<td>
							<div class="griddiv"><label>

									<div class="gridlable">Currency&nbsp;Code<span class="redmind"></span></div>

									<input name="currencyCode" type="text" class="gridfield validate" id="currencyCode" displayname="Currency Code" value="<?php echo $name; ?>" maxlength="100" <?php if($name != ''){ echo 'readonly'; } ?> />

								</label>

							</div>
						</td>

					</tr>

					<tr>

						<td>
							<div class="griddiv"><label>

									<div class="gridlable">Currency&nbsp;Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Currency Name" value="<?php echo $currencyCode; ?>" maxlength="100" />

								</label>

							</div>
						</td>

					</tr>


					<?php if ($editresult['setDefault'] != 1) { ?>

						<tr>

							<td>

								<div class="griddiv">

									<label>

										<div class="gridlable">status</div>

										<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

											<option value="1" <?php if ($status == 1) { ?>selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($status == 0) { ?>selected="selected" <?php } ?>>In Active</option>

										</select>
									</label>

								</div>

							</td>

						</tr>

					<?php } ?>

				</table>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_currencymaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_ratelist' && $_GET['sectiontype'] == 'ratelist' && $_REQUEST['currencyId'] != '') {

	$editresult['status'] = 1;

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'queryCurrencyRateMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$currencyValue = clean($editresult['currencyValue']);
	}





	$rs2 = GetPageRecord('name', _QUERY_CURRENCY_MASTER_, 'id="' . $_REQUEST['currencyId'] . '"');

	$editresult2 = mysqli_fetch_array($rs2);

	$name = clean($editresult2['name']);

?>

	<div class="contentclass">

		<h1 style="text-align:left;padding: 5px;">Exchange&nbsp;Rate&nbsp;(<?php echo strip($name); ?>)</h1>

		<div id="contentbox" class="addeditpagebox" style="padding: 5px;overflow:auto;text-align:left;margin-bottom:0px;">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellspacing="0" cellpadding="5">

					<?php if ($_GET['id'] != '') { ?>

						<tr>

							<td width="20%" colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Date&nbsp;<span class="redmind"></span></div>

										<input type="date" class="gridfield validate" name="date2" value="<?php if ($editresult['date'] < 1) {
																												echo date('Y-m-d');
																											} else {
																												echo date('Y-m-d', strtotime($editresult['date']));
																											} ?>" disabled>

									</label>

								</div>
							</td>

						<?php } else { ?>

							<td width="15%">
								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date&nbsp;<span class="redmind"></span></div>

										<input type="date" class="gridfield validate" name="fromDate" value="<?php echo date('Y-m-d'); ?>">

									</label>

								</div>
							</td>

							<td width="15%">
								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date&nbsp;<span class="redmind"></span></div>

										<input type="date" class="gridfield validate" name="toDate" value="<?php echo date('Y-m-d'); ?>">

									</label>

								</div>
							</td>

						<?php } ?>

						<td width="20%">
							<div class="griddiv"><label>

									<div class="gridlable">Exchange&nbsp;Rate<span class="redmind"></span></div>

									<input name="currencyValue" type="text" class="gridfield validate" id="currencyValue" displayname="Name" value="<?php echo number_format($currencyValue, 4); ?>" maxlength="100" />

								</label>

							</div>
						</td>

						<td width="20%">
							<div class="griddiv"><label>

									<div class="gridlable">Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="redmind"></span></div>

									<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off">

										<option value="1" <?php if (1 == $editresult['status']) { ?>selected="selected" <?php } ?>>Active</option>

										<option value="0" <?php if (0 == $editresult['status']) { ?>selected="selected" <?php } ?>>Inactive</option>

									</select>

								</label>

							</div>

						</td>

						<td width="10%">
							<div class="griddiv"><label>

									<div class="">&nbsp;</div>

									<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" />

								</label>

							</div>

						</td>

						<td width="10%">
							<div class="griddiv"><label>

									<div class="">&nbsp;</div>

									<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />



									<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

									<input name="currencyId" type="hidden" id="currencyId" value="<?php echo $_REQUEST['currencyId']; ?>" />

									<input name="module" type="hidden" id="module" value="currencymaster" />

									<input name="submodule" type="hidden" id="submodule" value="ratelist" />

									<input name="action" type="hidden" id="action" value="addedit_ratelist" />

								</label>

							</div>

						</td>

						</tr>

				</table>



			</form>

		</div>



	</div>





<?php }







if ($_GET['action'] == 'addedit_mealplan' && $_GET['sectiontype'] == 'mealplan') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _MEAL_PLAN_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Meal Plan </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Meal Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Meal Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<div class="griddiv">

					<input type="checkbox" name="defaultMealplan" id="defaultMealplan" value="1" <?php if($editresult['setDefault']==1){ ?> checked="checked" <?php } ?> style="display: inline-block;"> Set Default

					</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_mealplan" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_HotelChainMaster' && $_GET['sectiontype'] == 'HotelChainMaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'chainhotelmaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']);
		$location = clean($editresult['location']);
		$hotelwebsite = clean($editresult['hotelwebsite']);
		$selfsupplier = clean($editresult['selfsupplier']);

		$contactperson = clean($editresult['contactperson']);
		$phone = clean($editresult['phone']);
		$countryCode1 = clean($editresult['countryCode']);
		$division = clean($editresult['division']);
		$designation = clean($editresult['designation']);
		$email = clean($editresult['email']);
		$status = clean($editresult['status']);
	}

?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Hotel Chain Master </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv"><label>

						<div class="gridlable">Hotel Chain Name<span class="redmind"></span></div>
						<input name="name" type="text" class="gridfield validate" id="name" displayname="Hotel Chain Name" value="<?php echo $name; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Location<span class="redmind"></span></div>

						<input name="location" type="text" class="gridfield validate" id="location" displayname="Location" value="<?php echo $location; ?>" maxlength="100" />

					</label>

				</div>
				<div class="griddiv"><label>

						<div class="gridlable">Hotel Website<span class="redmind"></span></div>

						<input name="hotelwebsite" type="text" class="gridfield validate" id="hotelwebsite" displayname="Hotel Website" value="<?php echo $hotelwebsite; ?>" maxlength="100" />
					</label>
				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">Self Supplier</div>

						<select id="selfsupplier" type="text" class="gridfield" name="selfsupplier" displayname="Self Supplier" autocomplete="off" value="<?php echo $selfsupplier; ?>" style="width: 100%;">

							<option value="1" <?php if ($editresult['selfsupplier'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>
							<option value="0" <?php if ($editresult['selfsupplier'] == '0' || $editresult['selfsupplier'] == '') { ?>selected="selected" <?php } ?>>No</option>



						</select>
					</label>



				</div>

				<div class="griddiv"><label>

						<table width="100%" border="0" cellspacing="2" cellpadding="0">

							<tr>

								<td width="70">
									<div class="griddiv">

										<label>

											<div class="">Contact Person<span class="redmind"></span></div>

											<select id="division" name="division" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
												<option value="">Select Division</option>
												<?php  
												$selectd='*';    
												$whered=' deletestatus=0 and status=1 order by name asc';  
												$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
												while($resListingd=mysqli_fetch_array($rsd)){  
												?>
												<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($division == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
												<?php } ?>
  
											</select>
										</label>

									</div>
								</td>

								<td width="70">
									<div class="griddiv"><label>

											<input name="contactperson" type="text" class="gridfield validate" id="contactperson" value="<?php echo $contactperson; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" style="margin-top: 20px;">

										</label>

									</div>
								</td>

								<td width="70">
									<div class="griddiv"><label>

											<input name="designation" type="text" class="gridfield validate" id="designation" value="<?php echo $designation; ?>" displayname="Designation" placeholder="Designation" style="margin-top: 20px;">



										</label>



									</div>
								</td>

								<td width="40">
									<div class="griddiv"><label>
											<input name="countryCode1" type="text" class="gridfield validate" id="countryCode1" value="<?php echo $countryCode1;?>" displayname="Country Code" placeholder="+91" style="margin-top: 20px;">

										</label>

									</div>
								</td>

								<td width="80">
									<div class="griddiv"><label>

											<input name="phone" type="text" class="gridfield validate" id="phone" value="<?php echo $phone; ?>" displayname="Phone" placeholder="Phone" style="margin-top: 20px;">



										</label>



									</div>
								</td>



								<td width="120">
									<div class="griddiv"><label>







											<input name="email" type="email" class="gridfield validate" id="email" value="<?php echo $email; ?>" displayname="Email" placeholder="Email" style="margin-top: 20px;" required />

										</label>

									</div>
								</td>

							</tr>

						</table>
					</label>
				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">



							<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>



							<option value="0" <?php if ($editresult['status'] == '0' || $editresult['status'] == '') { ?>selected="selected" <?php } ?>>In Active</option>



						</select>
					</label>



				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_HotelChainMaster" />

			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>
			</table>

		</div>
	</div>
<?php }

if ($_GET['action'] == 'addedit_fleetmaster' && $_GET['sectiontype'] == 'fleetmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'vehicleFleetMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$image = clean($editresult['image']);

		$name = clean($editresult['name']);

		$maxpax = clean($editresult['maxpax']);
	}

?>



	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Fleet</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="0" cellspacing="0">

					<tr>

						<td width="50%" align="left" valign="top" style="padding-right:20px;">

							<div class="griddiv"><label>

									<div class="gridlable">Vehicle Type </div>

									<select id="vehicleType" name="vehicleType" class="gridfield " displayname="Title" autocomplete="off">

										<?php

										$rs = GetPageRecord('name,id', 'vehicleTypeMaster', ' 1 order by name asc');

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo strip($resListing['id']); ?>" <?php if ($vehicleType == strip($editresult['carType'])) { ?> selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

										<?php } ?>

									</select>

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Brand Name<span class="redmind"></span></div>



									<select id="brand" name="brand" class="gridfield " displayname="Title" autocomplete="off">



										<option value="">None</option>

										<?php

										$rs = GetPageRecord('name,id', _VEHICLE_BRAND_MASTER_, ' name!="" and deletestatus=0 and status=1 order by id asc');

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['brand']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

										<?php } ?>

									</select>
								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Vehicle<span class="redmind"></span></div>

									<select name="model" id="model" class="gridfield">

										<option>Select&nbsp;Vehicle</option>

										<?php

										$rssss1 = GetPageRecord('*', _VEHICLE_MASTER_MASTER_, '1 order by id asc');

										while ($brandData = mysqli_fetch_array($rssss1)) {

										?>

											<option value="<?php echo $brandData['id']; ?>" <?php if (trim($editresult['model']) == $brandData['id']) { ?> selected="selected" <?php } ?>><?php echo $brandData['model']; ?></option>



										<?php } ?>

									</select>

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Colour </div>

									<input name="colourType" type="text" class="gridfield " id="colourType" value="<?php echo $editresult['colourType']; ?>" displayname="Last Name" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Fuel Type </div>

									<select id="fuelType" name="fuelType" class="gridfield " displayname="Title" autocomplete="off">

										<option value="">None</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										$where = ' deletestatus=0 and status=1 order by id asc';

										$rs = GetPageRecord($select, _VEHICLE_FUEL_TYPE_MASTER_, $where);

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['fuelType']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

										<?php } ?>

									</select>

								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Seating Capacity (including driver) </div>

									<input name="capacity" type="text" class="gridfield " id="capacity" value="<?php echo $editresult['capacity']; ?>" displayname="Last Name" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Assigned Driver </div>

									<select id="assignedDriver" name="assignedDriver" class="gridfield " autocomplete="off">

										<option value="">None</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										$where = ' deletestatus=0 and status=0 and name!="" order by id asc';

										$rs = GetPageRecord($select, _DRIVER_MASTER_MASTER_, $where);

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['assignedDriver']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

										<?php } ?>

									</select>

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Category - Vehicle Group </div>

									<input name="vehicleGroup" type="text" class="gridfield " id="vehicleGroup" value="<?php echo $editresult['vehicleGroup']; ?>" maxlength="100" />

								</label>

							</div>



							<script src="js/jquery.inputmask.bundle.js"></script>

							<div class="griddiv"><label>

									<div class="gridlable">Registration&nbsp;Number </div>

									<input name="registrationNo" data-inputmask-regex="[A-Z]{2}-[\w]{2}-[A-Z]{2}-\d{4}" class="gridfield" id="registrationNo" value="<?php echo $editresult['registrationNo']; ?>" displayname="Registration Number" />

								</label>

							</div>

							<script type="text/javascript">
								$('#registrationNo').inputmask({
									mask: 'AA-**-AA-9999'
								});
							</script>

							<div class="griddiv"><label>

									<div class="gridlable">Registered&nbsp;Owner&nbsp;Name </div>

									<input name="ownerName" type="text" class="gridfield " id="ownerName" value="<?php echo $editresult['ownerName']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Pollution&nbsp;Permits&nbsp;Expiry</div>

									<input name="polutionPermitExpiry" type="text" class="gridfield " id="polutionPermitExpiry" value="<?php if ($editresult['polutionPermitExpiry'] != '') {
																																			echo date("d-m-Y", strtotime($editresult['polutionPermitExpiry']));
																																		} ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Registration&nbsp;Date </div>

									<input type="text" class="gridfield" name="registrationDate" id="registrationDate" value="<?php if ($editresult['registrationDate'] != '') {
																																	echo date("d-m-Y", strtotime($editresult['registrationDate']));
																																} ?>" style="text-align:left;width:100%;padding: 3px;border-radius: 2px;" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Car Photo</div>

									<input name="vehicleImage" type="file" class="gridfield" id="vehicleImage" />

									<input type="hidden" name="vehicleImage2" id="vehicleImage2" value="<?php echo $editresult['image']; ?>" />

								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Show&nbsp;On&nbsp;CostSheet</div>

									<input name="showCostsheet" type="checkbox" class="gridfield" style="width: auto; float: left; margin: 2px; margin-right: 10px;" id="showCostsheet" <?php if ($editresult['showCostsheet'] == 1) { ?> checked="checked" <?php } ?> />

								</label>

							</div>

						</td>

						<td width="50%" align="left" valign="top" style="padding-left:20px;">

							<h3>Parts </h3>

							<div class="griddiv"><label>

									<div class="gridlable">Chassis Number </div>

									<input name="chassisNo" type="text" class="gridfield " id="chassisNo" value="<?php echo $editresult['chassisNo']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Engine Number </div>

									<input name="engineNo" type="text" class="gridfield " id="engineNo" value="<?php echo $editresult['engineNo']; ?>" maxlength="100" />

								</label>

							</div>

							<h3>Insurance</h3>



							<div class="griddiv"><label>

									<div class="gridlable">Company Name </div>

									<input name="CompanyName" type="text" class="gridfield " id="CompanyName" value="<?php echo $editresult['CompanyName']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Policy Number </div>

									<input name="policyNo" type="text" class="gridfield " id="policyNo" value="<?php echo $editresult['policyNo']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Issue&nbsp;Date </div>

									<input type="text" class="gridfield" name="issueDate" id="issueDate" value="<?php if ($editresult['issueDate'] != '') {
																													echo date("d-m-Y", strtotime($editresult['issueDate']));
																												} ?>" style="text-align:left;width:100%;padding: 3px;border-radius: 2px;" />



								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Due&nbsp;Date </div>



									<input type="text" class="gridfield" name="dueDate" id="dueDate" value="<?php if ($editresult['dueDate'] != '') {
																												echo date("d-m-Y", strtotime($editresult['dueDate']));
																											} ?>" style="text-align:left;width:100%;padding: 3px;border-radius: 2px;" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Premium&nbsp;Amount </div>

									<input name="premiumAmount" type="text" class="gridfield " id="premiumAmount" value="<?php echo $editresult['premiumAmount']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Cover&nbsp;Amount </div>

									<input name="coverAmount" type="text" class="gridfield " id="coverAmount" value="<?php echo $editresult['coverAmount']; ?>" maxlength="100" />

								</label>

							</div>

							<h3>RTO</h3>

							<div class="griddiv"><label>

									<div class="gridlable">Address</div>

									<input name="address" type="text" class="gridfield " id="address" value="<?php echo $editresult['address']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Tax&nbsp;Efficiency</div>

									<input name="taxEfficiency" type="text" class="gridfield " id="taxEfficiency" value="<?php echo $editresult['taxEfficiency']; ?>" displayname="Last Name" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Expiry&nbsp;Date </div>



									<input type="text" class="gridfield" name="rtoExpiryDate" id="rtoExpiryDate" value="<?php if ($editresult['rtoExpiryDate'] != '') {
																															echo date("d-m-Y", strtotime($editresult['rtoExpiryDate']));
																														} ?>" style="text-align:left;width:100%;padding: 3px;border-radius: 2px;" />



								</label>

							</div>



							<h3>Permits</h3>

							<div class="griddiv"><label>

									<div class="gridlable">Type</div>

									<input name="permitType" type="text" class="gridfield " id="permitType" value="<?php echo $editresult['permitType']; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Expiry&nbsp;Date</div>

									<input type="text" class="gridfield" name="permitExpiryDate" id="permitExpiryDate" value="<?php if ($editresult['permitExpiryDate'] != '') {
																																	echo date("d-m-Y", strtotime($editresult['permitExpiryDate']));
																																} ?>" style="text-align:left;width:100%;padding: 3px;border-radius: 2px;" />



								</label>

							</div>





							<div class="griddiv"><label>

									<div class="gridlable">status</div>

									<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

										<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

										<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

									</select>
								</label>

							</div>

						</td>

					</tr>

				</table>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_fleetmaster" />

			</form>

			<script src="js/jquery-1.11.3.min.js"></script>

			<script src="js/zebra_datepicker.js"></script>

			<script type="text/javascript">
				$('#polutionPermitExpiry').Zebra_DatePicker({

					format: 'd-m-Y',

				});

				$('#registrationDate').Zebra_DatePicker({

					format: 'd-m-Y',

				});

				$('#issueDate').Zebra_DatePicker({

					format: 'd-m-Y',

				})

				$('#dueDate').Zebra_DatePicker({

					format: 'd-m-Y',

				})

				$('#rtoExpiryDate').Zebra_DatePicker({

					format: 'd-m-Y',

				})

				$('#permitExpiryDate').Zebra_DatePicker({

					format: 'd-m-Y',

				})
			</script>

		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>

	<style>
		.Zebra_DatePicker_Icon_Wrapper {

			display: contents !important;

		}
	</style>

<?php }







if ($_GET['action'] == 'addedit_sightseeingmaster' && $_GET['sectiontype'] == 'sightseeingmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _SIGHTSEEING_MASTER_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Sightseeing Name</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">



				<div class="griddiv">

					<label>







						<div class="gridlable">Destination <span class="redmind"></span></div>

						<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off" onchange="selectOpsPersonfunction();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $destinationId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>
					</label>

					<label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>





				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_sightseeingmaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_transfermaster' && $_GET['sectiontype'] == 'transfermaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _TRANSFER_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Transfer Name</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv">

					<label>







						<div class="gridlable">Destination <span class="redmind"></span></div>

						<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off" onchange="selectOpsPersonfunction();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $destinationId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>
					</label>

					<label>

						<label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

						</label>

				</div>





				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_transfermaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_transfercategory' && $_GET['sectiontype'] == 'transfercategory') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _TRANSFER_CATEGORY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Transfer Category</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv">

					<label>

						<div class="gridlable">Destination <span class="redmind"></span></div>

						<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off" onchange="selectOpsPersonfunction();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $destinationId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>
					</label>

					<label>

						<label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

						</label>

				</div>





				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_transfercategory" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

?>


<?php if ($_GET['action'] == 'mastersdelete') { 
$name='';
if($_REQUEST['name']=='gstmaster'){
	$name='tax';
}else{
	$name=$_REQUEST['name'];
}


	?>

	<div class="delbg"><img src="images/Remove-64.png" /></div>

	<div class="contentclass">

		<h1 style="padding:15px 0px !important;">Are you sure you want to deactivate <?php echo $name; ?>?</h1>

		<div id="buttonsbox">

			<table border="0" align="center" cellpadding="0" cellspacing="0">

				<tr>

					<!-- <td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Deactivate" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td> -->
						 <td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Deactivate" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>
<?php }

if ($_GET['action'] == 'deleteGalleryPhoto') { ?>
	<div class="delbg"><img src="images/Remove-64.png" /></div>
	<div class="contentclass">
		<h1 style="padding:15px 0px !important;">Are you sure you want to delete <?php echo $_REQUEST['name']; ?> Image?</h1>
		<div id="buttonsbox">
			<table border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="   Delete   " onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
<?php
}


if ($_GET['action'] == 'voucherCancellation') { ?>

	<div class="delbg"><img src="images/Remove-64.png" /></div>

	<div class="contentclass">

		<h1 style="padding:15px 0px !important;">Are you sure you want to Cancel Voucher ?</h1>

		<div id="buttonsbox">

			<table border="0" align="center" cellpadding="0" cellspacing="0">

				<tr>

					<td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Cancel" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>



<?php }

if ($_GET['action'] == 'deleteleadsource') { ?>

	<div class="delbg"><img src="images/Remove-64.png" /></div>

	<div class="contentclass">

		<h1 style="padding:15px 0px !important;">Are you sure you want to Deactivate selected <?php echo $_REQUEST['name']; ?>?</h1>

		<div id="buttonsbox">

			<table border="0" align="center" cellpadding="0" cellspacing="0">

				<tr>

					<td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Deactivate" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>

	</div>



<?php }






// Add Additional Requirements
if ($_GET['action'] == 'addedit_extraquotation' && $_GET['sectiontype'] == 'extraquotation') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _EXTRA_QUOTATION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$currencyId = clean($editresult['currencyId']);

		$adultCost = clean($editresult['adultCost']);

		$childCost = clean($editresult['childCost']);
		$infantCost = clean($editresult['infantCost']);

		$groupCost = clean($editresult['groupCost']);
		$editdestinationId = clean($editresult['destinationId']);
	}
	

?>
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>
	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Additional Requirements</h1>

		<div id="contentbox" class="addeditpagebox" style=" padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Additional Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Additional Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>
				<!-- new added for destination fields by islam -->
				
				<div class="griddiv"><label>
					<!-- destination code -->
							<div class="gridlable">Destination<span class="redmind"></span></div>
							<select id="destinationIda" multiple="multiple" name="destinationId[]" class="gridfield js-example-basic-multiple" displayname="Destination" autocomplete="off">
							<option value="All" <?php if($editdestinationId=='All') { echo 'selected="selected"';} ?> >All</option>
								<?php
								$select = '';
								$where = '';
								$rs = '';
								$select = '*';
								$where = ' 1 and deletestatus = 0 order by name asc';
								$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
								$alldest=explode(',',$editdestinationId);  
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
								<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> <?php } ?> 
							</select>
						</label>
				</div>

				<div class="grid-container">	

					<div class="griddiv grid-box" ><label>
						<div class="">Tax&nbsp;SLAB(%)<span class="redmind"></span></div>
						<select id="gstTax" name="gstTax" class="gridfield" displayname="Tax SLAB" autocomplete="off" style="width: 100%;" >
							<?php 
							$rs2="";
							$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Other" and status=1 order by gstValue asc'); 
							while($gstSlabData=mysqli_fetch_array($rs2)){ ?>
								<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
							<?php
							}	
							?>
						</select>
						</label>
					</div>

					<div class="griddiv grid-box" >
						<label>
							<div class="gridlable">Markup&nbsp;Apply</div>
							<select id="isMarkupApply" type="text" class="gridfield" name="isMarkupApply" autocomplete="off" style="width: 100%;" onchange="markupApplyStatus(this.value)">
								<option value="0" <?php if ($editresult['isMarkupApply'] == '0') { ?>selected="selected" <?php } ?>>YES</option>
								<option value="1" <?php if ($editresult['isMarkupApply'] == '1') { ?>selected="selected" <?php } ?>>NO</option>
							</select>
						</label> 
					</div>

				</div>

				<div class="grid-container">	
					<div class="griddiv grid-box" ><label>
							<div class="gridlable">Currency<span class="redmind"></span></div>
							<select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off">
								<option value="">Select</option>
								<?php
								$rs = '';
								$rs = GetPageRecord('*', _QUERY_CURRENCY_MASTER_, ' deletestatus=0 and status=1 order by name asc');
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $currencyId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
								<?php } ?>
							</select>
						</label>
					</div>
					<div class="griddiv grid-box" >
						<label>
							<div class="gridlable">Cost&nbsp;Type</div>
							<select id="costType" type="text" class="gridfield" name="costType" autocomplete="off" style="width: 100%;" onchange="selectcost(this.value);">
								<option value="1" <?php if ($editresult['costType'] == '1') { ?>selected="selected" <?php } ?>>Per Person</option>
								<option value="2" <?php if ($editresult['costType'] == '2') { ?>selected="selected" <?php } ?>>Group Cost</option>
							</select>
						</label>
					</div>
				</div>

				<div class="griddiv pp" style="display:none;"><label>

						<div class="gridlable" style="width:100%">Adult&nbsp;Cost</div>

						<input name="adultCost" type="number" class="gridfield" id="adultCost" displayname="Adult Cost" value="<?php echo $adultCost; ?>" maxlength="6" />

					</label>

				</div>

				<div class="griddiv pp" style="display:none;"><label>

				<div class="gridlable" style="width:100%">Child&nbsp;Cost</div>

				<input name="childCost" type="number" class="gridfield" id="childCost" displayname="Child Cost" value="<?php echo $childCost; ?>" maxlength="6" />

				</label>

				</div>

				<div class="griddiv pp" style="display:none;"><label>

				<div class="gridlable" style="width:100%">Infant&nbsp;Cost</div>

				<input name="infantCost" type="number" class="gridfield" id="infantCost" displayname="Infant Cost" value="<?php echo $infantCost; ?>" maxlength="6" />

				</label>

				</div>


				<div class="griddiv tot" style="display:none;"><label>

						<div class="gridlable">Group/Total&nbsp;Cost</div>

						<input name="groupCost" type="number" class="gridfield" id="groupCost" displayname="Group Cost" value="<?php echo $groupCost; ?>" maxlength="6" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Show in Proposal</div>

						<select id="proposalService" type="text" class="gridfield" name="proposalService" displayname="Status" autocomplete="off" style="width: 100%;">

							<option value="1" <?php if ($editresult['proposalService'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>

							<option value="0" <?php if ($editresult['proposalService'] == '0') { ?>selected="selected" <?php } ?>>No</option>

						</select>
					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

							<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Add Image</div>

						<input name="AdditionalImage" type="file" class="gridfield" id="trainImage" />
						<input name="AdditionalImageold" type="hidden" class="gridfield" id="AdditionalImageold" value="<?php echo $editresult['file_extra']; ?>" />

					</label>

				</div>
				<div class="griddiv"><label>

					<div class="gridlable">Description</div>

					<!-- description code -->

						<textarea name="additionalDetail" rows="5" class="gridfield" id="additionalDetail"><?php echo strip($editresult['otherInfo']); ?></textarea>

							</label>

				</div>



				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_extraquotation" />

			</form>

			<style>
				.select2-container {
					width: 100% !important;
				}
				.select2-container--open {
					z-index: 9999999999 !important;
				} 
				.grid-container{
					display: grid;
					grid-template-columns:49% 49%;	
					grid-gap:10px; 
				} 
				.grid-box{
					width: 165px;
				}
			</style>
			<script>
				$('.js-example-basic-multiple').select2();  
		 		// $('.js-example-basic-multiple').on("select2:select", function (e) { 
		        //    var data = e.params.data.text;
		        //    if(data=='All'){
		        //     $(".js-example-basic-multiple > option").prop("selected","selected");
		        //     $(".js-example-basic-multiple").trigger("change");
		        //    }
		    	//   }); 
			 	
			 	function selectcost(costType) {
					if (costType == 1 || costType == 0) {
						$('.pp').show();
						$('.tot').hide(); 
						$('#groupCost').val('');
					}
					if (costType == 2) {
						$('.pp').hide();
						$('.tot').show(); 
						$('#adultCost').val('');
						$('#childCost').val('');
						$('#infantCost').val('');
					}
				} 
				selectcost(<?php echo ($editresult['costType']>0) ? $editresult['costType'] : 1; ?>);

				function markupApplyStatus(selectedValue) {
				    if (selectedValue == 1) {
				        console.log("The selected value is "+selectedValue+". Passing value 2 to the function.");
				        selectcost(2);
				        $('#costType').val(2)
				    } else {
				        console.log("The selected value is "+selectedValue+". Passing the original value to the function.");
				    }
				}

			</script>


		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addeditnewextraquotation' && $_GET['sectiontype'] == 'extraquotation' && $_GET['queryId'] != '') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _EXTRA_QUOTATION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$adultCost = clean($editresult['adultCost']);

		$childCost = clean($editresult['childCost']);
		$infantCost = clean($editresult['infantCost']);

		$packageCost = clean($editresult['childCost']);
	}

?>

	<style>
		.addeditpagebox .griddiv .gridlable {

			width: 100%;

		}

		.newtowrobox .griddiv {
			width: 23% !important;

			display: inline-block;

			margin: 8px;
		}
	</style>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Extra Quotation</h1>

		<div id="contentbox" class="addeditpagebox newtowrobox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Per Pax Cost</div>

						<input name="adultCost" type="number" class="gridfield" id="adultCost" displayname="Per Pax Cost" value="<?php echo $adultCost; ?>" maxlength="6" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Package Cost</div>

						<input name="packageCost" type="number" class="gridfield" id="packageCost" displayname="Package Cost" value="<?php echo $packageCost; ?>" maxlength="6" />

					</label>

				</div>



				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_extraquotation" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }









if ($_GET['action'] == 'currencyconversion' && $_GET['sectiontype'] == 'currencyconversion') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _CURRENCY_CONVERSION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);



		$currencyFrom = clean($editresult['currencyFrom']);

		$currencyTo = clean($editresult['currencyTo']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Currency Conversion</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Currency From<span class="redmind"></span></div>

						<select id="currencyFrom" name="currencyFrom" class="gridfield validate" displayname="Currency From" autocomplete="off" onchange="selectOpsPersonfunction();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, _QUERY_CURRENCY_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $currencyFrom) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Currency To<span class="redmind"></span></div>

						<select id="currencyTo" name="currencyTo" class="gridfield validate" displayname="Currency To" autocomplete="off" onchange="selectOpsPersonfunction();">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$rs = GetPageRecord($select, _QUERY_CURRENCY_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $currencyTo) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Conversion Value<span class="redmind"></span></div>

						<input name="currencyValue" type="number" class="gridfield" id="currencyValue" displayname="Conversion Value" value="<?php echo $editresult['currencyValue']; ?>" maxlength="6" />

					</label>

				</div>





				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="currencyconversion" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }























if ($_GET['action'] == 'addedit_packagetheme' && $_GET['sectiontype'] == 'packagetheme') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_THEME_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Pacakege Theme </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_packagetheme" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }


if($_REQUEST['action']=="addedit_VISAtype" && $_REQUEST['sectiontype']=='VISAtype'){
	
	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1,'visaTypeMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> VISA Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">




			

				<div class="griddiv"><label>

						<div class="gridlable">VISA Type<span class="redmind"></span></div>

						<input name="VISAtype" type="text" class="gridfield validate" id="VISAtype" displayname="VISA Type" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

				<div class="gridlable" style="width: 100%;">Status<span class="redmind"></span></div>

				<label>
					<!--for status-->
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

						<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>

					</select>

				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_VISAtype" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php
}




if($_REQUEST['action']=="addedit_visacostmaster" && $_REQUEST['sectiontype']=='visacostmaster'){
	
	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1,'visaCostMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$validity = clean($editresult['validity']);
		$visaType = clean($editresult['visaType']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> VISA Cost Master </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			<div class="griddiv"><label>
						<div class="gridlable">Country&nbsp;<span class="redmind"></span></div>
						<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off"  onclick="getStateNameselected();">
							<option value="">Select</option>
							<?php
							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' deletestatus=0 and status=1 order by name asc';
							$rs = GetPageRecord($select, _COUNTRY_MASTER_, $where);
							while ($resListing = mysqli_fetch_array($rs)) {
							?>
								<option value="<?php echo ($resListing['id']); ?>" <?php if ($resListing['id'] == $defaultCountryId && $editresult['countryId'] == '') { echo 'selected="selected"'; } elseif ($resListing['id'] == $editresult['countryId']) { ?>selected="selected" <?php } else { echo ''; } ?>><?php echo ($resListing['name']); ?></option>
							<?php } ?>
						</select>
					</label>
				</div>

				<div class="griddiv" style='display:none;'><label>

						<div class="gridlable">VISA Name<span class=""></span></div>

						<input name="VISAtcost" type="text" class="gridfield " id="VISAtcost" displayname="VISA Cost" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">VISA Type<span class="redmind"></span></div>

						<select name="VISATypeId" id="VISATypeId" class="gridfield validate" displayname="VISA Type">

						<option value="0">Select</option>
						<?php

						$rs=GetPageRecord('name,id','visaTypeMaster','status=1 and deletestatus=0'); 
						
						while($resultlists=mysqli_fetch_array($rs)){ 
						?>
						<option value="<?php echo $resultlists['id']; ?>" <?php if($visaType==$resultlists['id']){ ?> selected="selected" <?php } ?> ><?php echo $resultlists['name']; ?></option>
						<?php
						}
						?>
						
						</select>

					</label>

				</div>
				<div class="griddiv" style="display:none;">
					<label>

						<div class="gridlable">Entry Type<span class=""></span></div>

						<select name="entryType" id="entryType" class="gridfield " displayname="Entry Type">

						<option value="1" <?php if($resultlists['entryType']==1){ ?> selected="selected" <?php } ?>>Single Entry</option>
						
						<option value="2" <?php if($resultlists['entryType']==2){ ?> selected="selected" <?php } ?> >Multiple Entry</option>

						</select>
					</label>

				</div>

				<div class="griddiv" style="display:none;">
				<div class="gridlable" style="width: 100%;">Validity<span class=""></span></div>	
					<label>

						<input name="validity" type="text" class="gridfield " id="validity" displayname="validity" value="<?php echo $validity; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

				<div class="gridlable" style="width: 100%;">Status<span class="redmind"></span></div>

				<label>
					<!--for status-->
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

						<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>

					</select>

				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_visacostmaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php
}

if($_REQUEST['action']=="addedit_insuranceType" && $_REQUEST['sectiontype']=='insuranceType'){
	
	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1,'InsuranceTypeMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Insurance Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Insurance Type<span class="redmind"></span></div>

						<input name="insuranceType" type="text" class="gridfield validate" id="insuranceType" displayname="Insurance Type" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

				<div class="gridlable" style="width: 100%;">Status<span class="redmind"></span></div>

				<label>
					<!--for status-->
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

						<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>

					</select>

				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_insuranceType" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php
}



if($_REQUEST['action']=="addedit_insurancecostmaster" && $_REQUEST['sectiontype']=='insurancecostmaster'){
	
	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1,'insuranceCostMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$insuranceType = clean($editresult['insuranceType']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Insurance Cost Master </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Insurance Name<span class="redmind"></span></div>

						<input name="insuranceCost" type="text" class="gridfield validate" id="insuranceCost" displayname="Insurance Cost" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Insurance Type<span class="redmind"></span></div>

						<select name="insuranceTypeId" id="insuranceTypeId" class="gridfield validate" displayname="Insurance Type">

						<option value="0">Select</option>
						<?php

						$rs=GetPageRecord('name,id','InsuranceTypeMaster','status=1 and deletestatus=0'); 
						
						while($resultlists=mysqli_fetch_array($rs)){ 
						?>
						<option value="<?php echo $resultlists['id']; ?>" <?php if($insuranceType==$resultlists['id']){ ?> selected="selected" <?php } ?> ><?php echo $resultlists['name']; ?></option>
						<?php
						}
						?>
						
						</select>

					</label>

				</div>

				<div class="griddiv">

				<div class="gridlable" style="width: 100%;">Status<span class="redmind"></span></div>

				<label>
					<!--for status-->
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

						<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>

					</select>

				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_insurancecostmaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php
}


if($_REQUEST['action']=="addedit_passportTypeMaster" && $_REQUEST['sectiontype']=='passportTypeMaster'){
	
	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1,'passportTypeMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Passport Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Passport Type<span class="redmind"></span></div>

						<input name="passportType" type="text" class="gridfield validate" id="passportType" displayname="Passport Type" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

				<div class="gridlable" style="width: 100%;">Status<span class="redmind"></span></div>

				<label>
					<!--for status-->
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

						<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>

					</select>

				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_passportTypeMaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php
}



if($_REQUEST['action']=="addedit_passportCostMaster" && $_REQUEST['sectiontype']=='passportCostMaster'){
	
	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1,'passportCostMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$passportType = clean($editresult['passportType']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Passport Cost Master </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Passport Name<span class="redmind"></span></div>

						<input name="passportName" type="text" class="gridfield validate" id="passportName" displayname="Passport Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Passport Type<span class="redmind"></span></div>

						<select name="passportTypeId" id="passportTypeId" class="gridfield validate" displayname="Passport Type">

						<option value="0">Select</option>
						<?php

						$rs=GetPageRecord('name,id','passportTypeMaster','status=1 and deletestatus=0'); 
						
						while($resultlists=mysqli_fetch_array($rs)){ 
						?>
						<option value="<?php echo $resultlists['id']; ?>" <?php if($passportType==$resultlists['id']){ ?> selected="selected" <?php } ?> ><?php echo $resultlists['name']; ?></option>
						<?php
						}
						?>
						
						</select>

					</label>

				</div>

				<div class="griddiv">

				<div class="gridlable" style="width: 100%;">Status<span class="redmind"></span></div>

				<label>
					<!--for status-->
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

						<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>

					</select>

				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_passportCostMaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php
}


if ($_GET['action'] == 'addedit_inclusion' && $_GET['sectiontype'] == 'inclusion') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_INCLUSION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Inclusion </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_inclusion" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>
<?php }

if ($_GET['action'] == 'addedit_packagehotelmaster'){

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_HOTEL_MASTER_, $where1);
		$editresult = mysqli_fetch_array($rs1);


		$rs1 = '';

		$rs1 = GetPageRecord('*', _ADDRESS_MASTER_, ' addressParent="' . $editresult['id'] . '" and addressType="hotel"');

		$addressData = mysqli_fetch_array($rs1);
	}

	?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
			echo 'Edit';
		} else {
			echo 'Add';
		} ?> Hotel</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">



		
			<div style="display: grid;">
				<div style="display: inline-block;width: 100%;">

				<div class="hotelchainsec" style="display:flex;width: 100%;"> 
					<div class="griddiv" style="width: 10%;padding-right: 10px;"><label>

						<div class="gridlable">Hotel&nbsp;Chain</div>
						<select id="hotelChain" name="hotelChain" class="gridfield " displayname="Hotel Chain">
							<option value="">Select</option>
							<?php
							$rs = GetPageRecord('*', 'chainhotelmaster', ' 1 and status=1 order by name asc');
							while ($resListing = mysqli_fetch_array($rs)) {
							?>
								<option value="<?php echo ($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['hotelChain']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>
							<?php } ?>
						</select>

					</label>

				</div>

					<div class="griddiv" style="width: 30%;padding-right: 10px;"><label>

							<div class="gridlable" style="width: 100px;"> Hotel &nbsp;Name<span class="redmind"></span></div>

							<input name="hotelName" type="text" class="gridfield validate" id="hotelName1" displayname="Hotel Name" value="<?php echo stripslashes($editresult['hotelName']); ?>" />

						</label>

					</div>

					<div class="griddiv" style="width:15%;padding-right: 10px;"><label>
							<div class="gridlable">Hotel&nbsp;Category</div>
							<select id="hotelCategoryId" name="hotelCategoryId" class="gridfield " autocomplete="off" displayname="Hotel Category">
								<?php
								$rs3 = '';
								$rs3 = GetPageRecord('*', 'hotelCategoryMaster', ' 1 and deletestatus=0 and status=1 order by hotelCategory asc');
								while ($hotelCategoryData = mysqli_fetch_array($rs3)) {
								?>
									<option value="<?php echo $hotelCategoryData['id']; ?>" <?php if ($hotelCategoryData['id'] == $editresult['hotelCategoryId']) { ?>selected="selected" <?php } ?>><?php echo $hotelCategoryData['hotelCategory'] . " Star"; ?></option>
								<?php
								}
								?>
							</select>
						</label>
					</div>



					<div class="griddiv" style="width: 15%;padding-right: 10px;"><label>
							<div class="gridlable">Hotel&nbsp;Type</div>
							<select id="hotelTypeId" name="hotelTypeId" class="gridfield " autocomplete="off" displayname="Hotel Category">
								<?php
								$rs3 = '';
								$rs3 = GetPageRecord('*', 'hotelTypeMaster', ' 1 and deletestatus=0 and status=1 order by name asc');
								while ($hotelTypeData = mysqli_fetch_array($rs3)) {
								?>
									<option value="<?php echo $hotelTypeData['id']; ?>" <?php if ($hotelTypeData['id'] == $editresult['hotelTypeId']) { ?>selected="selected" <?php } ?>><?php echo $hotelTypeData['name']; ?></option>
								<?php
								}
								?>
							</select>



						</label>

					</div>


					<div class="griddiv" style="width: 10%;padding-right: 10px;"><label>
						<div class="gridlable">Destination<span class="redmind"></span></div>
						<select id="hotelCity" name="hotelCity" class="gridfield validate" displayname="Destination" autocomplete="off">
							<option value="">Select</option>
							<?php
							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' 1 and deletestatus = 0 order by name asc';
							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
							while ($resListing = mysqli_fetch_array($rs)) {
							?>
								<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['name'] == $editresult['hotelCity']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

								<?php } ?>
							</select>
						</label>
					</div>

					<div class="griddiv" style="width: 15%;padding-right: 10px;"><label>

							<div class="gridlable" style="width: 100px;"> Locality<span class=""></span></div>

							<input name="locality" type="text" class="gridfield" id="locality" displayname="Locality" value="<?php echo stripslashes($editresult['locality']); ?>" />

						</label>

					</div>

					
					</div>




					<div class="griddiv" style="display:none;"><label>

							<div class="gridlable">Photo Upload</div>

							<input name="hotelImage" type="file" class="gridfield" id="hotelImage" />

							<input type="hidden" name="oldhotleImage" id="oldhotleImage" value="<?php echo $editresult['hotelImage']; ?>" />

						</label>

					</div>

					<!--Ended  First row form  -->
					<!--Started  Secend row form  -->
					<div class="roomTypeSec" style="display:flex;width: 100%;">
					<div >
						<div class="griddiv" >
							<label>
								
								<div class="gridlable">Room Type<span class="redmind"></span></div>

									<select name="roomType[]" multiple="multiple" class="gridfield validate js-example-basic-multiple" id="roomtypeId" displayname="Room Type" autocomplete="off">
										<option value="">Select</option>
										<?php
										$select = '';
										$where = '';
										$rs = '';
										$select = '*';
										$where = ' name!="" and deletestatus=0 and status=1 order by name asc';
										$rs = GetPageRecord($select, _ROOM_TYPE_MASTER_, $where);
										while ($resListing = mysqli_fetch_array($rs)) {
											$roomTypeArrya = array_map('trim', explode(",", $editresult['roomType']));
											?>
											<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($roomTypeArrya as $key => $value) {
												if ($resListing['id'] == $value) {
													echo 'selected="selected"';
												}
											} ?>><?php echo strip($resListing['name']); ?></option>
										<?php } ?>
									</select>
							</label>
						</div>
						</div>

						<div style="width:50%;">
							<table>
							<tr>
									
							<td width="60%"> 
								<div class="griddiv"> <label> 
										<div class="gridlable" style="width: 65%;">Self Supplier</div> 
										<select id="supplier" name="supplier" class="gridfield " autocomplete="off">
											<!--only use for supplier status-->
											<option value="1" <?php if ($editresult['supplier'] == 1) { ?> selected="selected" <?php } ?>>Yes</option> 
											<option value="0" <?php if ($editresult['supplier'] == 0) { ?> selected="selected" <?php } ?>>No</option>

										</select>

									</label>

								</div>
							</td>	
							<td width="50%">
								<div class="griddiv">

								<div class="gridlable" style="width: 50%;">Status<span class="redmind"></span></div>

								<label>
									<!--for status-->
									<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

										<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

										<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

									</select>

								</label>

							</div>
						</td>	
						</tr>
							</table>
						</div>



					</div>

					<!--Ended  Secend row form  -->

<!-- Additional Hotel Started -->
					<div>
					
					<div style="display: inline-block; margin-left: 0px; width: 30%;display:none1;">
					<table width="100%" border="0" cellspacing="0" cellpadding="1">
						<tr>
							<td width="100%" colspan="2">
								<div class="griddiv"><label>
										<div class="gridlable">Hotel Additionals</div>
										<select name="hotelAdditional[]" multiple="multiple" class="gridfield  js-example-basic-multiple"  displayname="Hotel Additional" autocomplete="off">
											<option value="">Select</option>
											<?php
											$select = '';
											$where = '';
											$rs = '';
											$select = '*';
											$where = ' name!="" and deletestatus=0 and status=1 order by name asc';
											$rs = GetPageRecord($select, 'additionalHotelMaster', $where);
											while ($resListing = mysqli_fetch_array($rs)) {
												$hotelAddArray = array_map('trim', explode(",", $editresult['hotelAdditional']));
												?>
												<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($hotelAddArray as $key => $value) {
													if ($resListing['id'] == $value) {
														echo 'selected="selected"';
													}
												} ?>><?php echo strip($resListing['name']); ?></option>
											<?php } ?>
										</select>
									</label>
								</div>
							</td>		
						</tr>	
					</table>
				</div>
				
				
			</div>

			<!-- Additional Hotel Ended -->

					<!--Started   Third row form  -->

					<div class="contactPersonSec">
						
					<div class="griddiv" style="border-bottom: 1px;">

						<table width="100%" border="0" cellspacing="2" cellpadding="0" id="contactpersonIdTable">
						<tr><td colspan="6">Contact Person<span class="redmind"></span>&nbsp;&nbsp;&nbsp;<span onclick="addMoreContactPerson()" class="ppbtn"> + Add More</span> </td></tr>
						<?php 
						$countCP = 1;
						$rs1 = '';
						$rs1 = GetPageRecord('*', 'hotelContactPersonMaster', ' corporateId="'.$editresult['id'].'" and corporateId>0 order by primaryvalue desc');
						if(mysqli_num_rows($rs1)>0){
							while($suppCPData = mysqli_fetch_array($rs1)){ 
								?>
								<input type="hidden" name="contactPId<?php echo $countCP; ?>" id="contactPId<?php echo $countCP; ?>" value="<?php echo $suppCPData['id']; ?>">
								
									<tr id="contactPersonId<?php echo $countCP; ?>" style="width:100%">
										<td width="70" style="width: 10%;">
											<div class="griddiv">
												<label>
													<div class=""></div>
													<select id="division<?php echo $countCP; ?>" name="division<?php echo $countCP; ?>" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
														<?php  
														$selectd='*';    
														$whered=' deletestatus=0 and status=1 order by name asc';  
														$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
														while($resListingd=mysqli_fetch_array($rsd)){  
														?>
														<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($suppCPData['division'] == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
														<?php } ?>
													</select>
												</label>
											</div>
										</td>
										

										<td width="70" style="width: 15%;">
											<div class="griddiv"><label>
													<input name="contactPerson<?php echo $countCP; ?>" type="text" class="gridfield validate" id="contactPerson<?php echo $countCP; ?>" value="<?php echo $suppCPData['contactPerson']; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" >
												</label>
											</div>
										</td>
										<td width="70" style="width: 10%;">
											<div class="griddiv"><label>
													<input name="designation<?php echo $countCP; ?>" type="text" class="gridfield " id="designation<?php echo $countCP; ?>" value="<?php echo $suppCPData['designation']; ?>" displayname="Designation" placeholder="Designation" >
												</label>
											</div>
										</td>
										<td width="40" style="width: 5%;">
											<div class="griddiv"><label>

													<input name="countryCode<?php echo $countCP; ?>" type="text" class="gridfield validate" id="countryCode<?php echo $countCP; ?>" value="<?php echo $suppCPData['countryCode']; ?>" displayname="Country Code" placeholder="+91" autocomplete="false">
												</label>
											</div>
										</td>
										<td width="80" style="width: 12%;">
											<div class="griddiv"><label>
													<input name="phone<?php echo $countCP; ?>" type="text" class="gridfield validate" id="phone<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone']; ?>" displayname="Phone " placeholder="Phone 1" maxlength="14">
												</label>
											</div>
										</td>
										<td width="80" style="width: 12%;">
											<div class="griddiv"><label>
													<input name="phone2<?php echo $countCP; ?>" type="text" class="gridfield " id="phone2<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone2']; ?>" displayname="Phone" placeholder="Phone 2" maxlength="14">
												</label>
											</div>
										</td>
										<td width="80" style="width: 12%;">
											<div class="griddiv"><label>
													<input name="phone3<?php echo $countCP; ?>" type="text" class="gridfield " id="phone3<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone3']; ?>" displayname="Phone" placeholder="Phone 3" maxlength="14">
												</label>
											</div>
										</td>
										<!-- <tr>	 -->
											<td width="120" style="width: 12%;">
												<div class="griddiv"><label>
														<input name="email<?php echo $countCP; ?>" type="email" class="gridfield validate " id="email<?php echo $countCP; ?>" value="<?php echo $suppCPData['email']; ?>" displayname="Email" placeholder="Email"  required />
													</label>
												</div>
											</td>
											<td width="25" align="center">
												<img src="images/deleteicon.png" onclick="removeContactPerson(<?php echo $countCP; ?>);" style="cursor:pointer;">'
											</td>
										<!-- </tr> -->
									</tr>
								<?php 
								$countCP++;
							} 
						}else{ ?>
							<tr id="contactPersonId<?php echo $countCP; ?>" style="width: 100s%;">
								<td width="70" style="width: 10%;">
									<div class="griddiv">
										<label>
											<select id="division<?php echo $countCP; ?>" name="division<?php echo $countCP; ?>" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
												<?php  
												$selectd='*';    
												$whered=' deletestatus=0 and status=1 order by name asc';  
												$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
												while($resListingd=mysqli_fetch_array($rsd)){  
												?>
												<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($suppCPData['division'] == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
												<?php } ?>
											</select>
										</label>
									</div>
								</td>
								<td width="70" style="width: 15%;">
									<div class="griddiv"><label>
											<input name="contactPerson<?php echo $countCP; ?>" type="text" class="gridfield validate" id="contactPerson<?php echo $countCP; ?>" value="<?php echo $suppCPData['contactPerson']; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" >
										</label>
									</div>
								</td>
								<td width="70" style="width: 12%;">
									<div class="griddiv"><label>
											<input name="designation<?php echo $countCP; ?>" type="text" class="gridfield " id="designation<?php echo $countCP; ?>" value="<?php echo $suppCPData['designation']; ?>" displayname="Designation" placeholder="Designation" >
										</label>
									</div>
								</td>
								<td width="40" style="width: 5%;">
									<div class="griddiv"><label>
									<?php 
									$rsn="";
									$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
									$cmpcountryData=mysqli_fetch_array($rs1cmp);
									$compcountryCode = $cmpcountryData['compcountryCode'];
									?>

											<input name="countryCode<?php echo $countCP; ?>" type="text" class="gridfield validate" id="countryCode<?php echo $countCP; ?>" value="<?php echo '+'. $compcountryCode; ?>" displayname="Country Code" placeholder="+91" autocomplete="false" >
										</label>
									</div>
								</td>
								<td width="80" style="width: 12%;">
									<div class="griddiv"><label>
											<input name="phone<?php echo $countCP; ?>" type="text" class="gridfield validate" id="phone<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone']; ?>" displayname="Phone" placeholder="Phone 1" maxlength="14">
										</label>
									</div>
								</td>
								<td width="80" style="width: 12%;">
									<div class="griddiv"><label>
											<input name="phone2<?php echo $countCP; ?>" type="text" class="gridfield " id="phone2<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone2']; ?>" displayname="Phone" placeholder="Phone 2" maxlength="14">
										</label>
									</div>
								</td>
								<td width="80" style="width: 12%;">
									<div class="griddiv"><label>
											<input name="phone3<?php echo $countCP; ?>" type="text" class="gridfield " id="phone3<?php echo $countCP; ?>" value="<?php echo $suppCPData['phone3']; ?>" displayname="Phone" placeholder="Phone 3" maxlength="14">
										</label>
									</div>
								</td>
								<!-- <tr> -->
									<td width="120" style="width: 10%;">
										<div class="griddiv"><label>
												<input name="email<?php echo $countCP; ?>" type="email" class="gridfield validate " id="email<?php echo $countCP; ?>" value="<?php echo $suppCPData['email']; ?>" displayname="Email" placeholder="Email"  required />
											</label>
										</div>
									</td>
								<!-- </tr> -->
							</tr>
						<?php $countCP++;
						} ?>
						</table>
						<input type="hidden" name="countCP" id="countCP" value="<?php echo $countCP; ?>">
						<script>
						function removeContactPerson(countCP) {
							$('#contactPersonId'+countCP).remove();
						}	
						function addMoreContactPerson() {
							var countCP = $('#countCP').val();
							$('#countCP').val(parseInt(countCP, 10)+1);
							$("#contactpersonIdTable").append('<tr id="contactPersonId'+countCP+'">'
									+'<td width="70">'
										+'<div class="griddiv mb2">'
											+'<label>'
												+'<select id="division'+countCP+'" name="division'+countCP+'" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">' 
													<?php  
													$selectd='*';    
													$whered=' deletestatus=0 and status=1 order by name asc';  
													$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
													while($resListingd=mysqli_fetch_array($rsd)){  
													?>
													+'<option value="<?php echo strip($resListingd['id']); ?>"><?php echo strip($resListingd['name']); ?></option>'
													<?php } ?> 
												+'</select>'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="70">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="contactPerson'+countCP+'" type="text" class="gridfield validate" id="contactPerson'+countCP+'" value="" displayname="Contact Person" maxlength="100" placeholder="Contact Person">'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="70">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="designation'+countCP+'" type="text" class="gridfield " id="designation'+countCP+'" value="" displayname="Designation" placeholder="Designation">'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="40">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="countryCode'+countCP+'" type="text" class="gridfield validate" id="countryCode'+countCP+'" value="" displayname="Country Code" placeholder="+91" autocomplete="false">'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="80">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="phone'+countCP+'" type="text" class="gridfield validate" id="phone'+countCP+'" value="" displayname="Phone" placeholder="Phone 1" maxlength="14">'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="80">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="phone2'+countCP+'" type="text" class="gridfield " id="phone2'+countCP+'" value="" displayname="Phone" placeholder="Phone 2" maxlength="14">'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="80">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="phone3'+countCP+'" type="text" class="gridfield " id="phone3'+countCP+'" value="" displayname="Phone" placeholder="Phone 3" maxlength="14">'
											+'</label>'
										+'</div>'
									+'</td>'
									
									+'<td width="120">'
										+'<div class="griddiv mb2"><label>'
												+'<input name="email'+countCP+'" type="email" class="gridfield validate " id="email'+countCP+'" value="" displayname="Email" placeholder="Email" required />'
											+'</label>'
										+'</div>'
									+'</td>'
									+'<td width="25" align="center">'
										+'<img src="images/deleteicon.png" onclick="removeContactPerson('+countCP+');" style="cursor:pointer;">'
									+'</td>'
									
								+'</tr>');
						}
						</script>
						<style type="text/css">
							.ppbtn {
								background-color: #7a96ff;
								padding: 1px 6px !important;
								margin-left: 10px;
								color: #FFFFFF!important;
								font-size: 10px;
								border: 1px #7a96ff solid;
								cursor: pointer;
							}
							.mb2 {
								margin-bottom: 2px!important;
							}
						</style>
					</div>
					</div>


					<!--Ended  Third row form  -->

					<!--Started Fourth row form  -->

					<div class="addAddressSec">

						<div class="addnewaddSecBtn"><h1 style="color: green;font-weight: bold;margin-bottom: 20px;cursor: pointer;" onclick="myAddressFunShow()">+ Add Addess</h1></div>

						<div class="addAddressSecInner" id="addAddressShowHide" style="display:none;">

						<table>
						<tr style="width: 100%">
							<td style="width: 15%">
								<div class="griddiv">
									<label>
										<div class="gridlable">Country<span class=""></span></div>
										<select id="countryId2" name="countryId2" class="gridfield " displayname="Country" autocomplete="off" onchange="selectstate();">
											<option value="0">Select Country</option>
											<?php

											$rs = "";
											$DefaultCountry = 'India';
											$rs = GetPageRecord('*', _COUNTRY_MASTER_, ' deletestatus=0 and status=1 order by name asc');
											while ($countryData = mysqli_fetch_array($rs)) {
												if ($addressData['countryId'] != '') {
													$isDefaultCountry = $countryData['id'] == $addressData['countryId'];
												} else {
													$isDefaultCountry = $countryData['name'] === $DefaultCountry;
												}
											?>
												<option value="<?php echo strip($countryData['id']); ?>" <?php if ($countryData['id'] == $isDefaultCountry) { ?>selected="selected" <?php } ?>><?php echo strip($countryData['name']); ?></option>

											<?php } ?>

										</select>
									</label>
								</div>
							</td>
							<td style="width: 15%">
								<div class="griddiv">
									<label>
										<div class="gridlable">State </div>
										<select id="stateId2" name="stateId2" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();">
											<?php
											$rs = "";
											$rs = GetPageRecord('*', _STATE_MASTER_, ' id="' . $addressData['stateId'] . '" order by name asc');
											while ($stateData = mysqli_fetch_array($rs)) {
											?>
												<option value="<?php echo strip($stateData['id']); ?>"><?php echo strip($stateData['name']); ?></option>

											<?php } ?>
										</select>
									</label>
								</div>
							</td>
							<td style="width: 15%">
								<div class="griddiv">
									<label>
										<div class="gridlable">City </div>
										<select id="cityId2" name="cityId2" class="gridfield" displayname="City" autocomplete="off">
											<?php
											$rs = "";
											$rs = GetPageRecord('*', _STATE_MASTER_, ' id="' . $addressData['cityId'] . '" order by name asc');
											while ($cityData = mysqli_fetch_array($rs)) {
											?>
												<option value="<?php echo strip($cityData['id']); ?>"><?php echo strip($cityData['name']); ?></option>
											<?php } ?>
										</select>
									</label>
								</div>
							</td>
							<td style="width: 8%">
								<div class="griddiv"><label>
										<div class="gridlable">Pin&nbsp;Code </div>
										<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $addressData['pinCode']; ?>" maxlength="15" />
									</label>
								</div>
							</td>
							<td style="width: 23%">
								<div class="griddiv"><label>
								<div class="gridlable">Address</div>
								<input name="hotelAddress" type="text" class="gridfield" id="hotelAddress" value="<?php echo $editresult['hotelAddress']; ?>" />
								</label>
								</div>
							</td>
							<td style="width: 15%">
								<div class="griddiv"><label>
								<div class="gridlable">GSTN</div>
								<input name="gstn" type="text" class="gridfield" id="gstn" value="<?php echo $editresult['gstn']; ?>" />
								</label>
								</div>		
							</td>
						</tr>
						</table>
						</div>

					</div>

					<!-- address show hide sec Started Js -->
					<script>
					function myAddressFunShow() {
					var x = document.getElementById("addAddressShowHide");
					if (x.style.display === "none") {
						x.style.display = "block";
					} else {
						x.style.display = "none";
					}
					}
					</script>
					<!-- address show hide sec Ended Js -->

					<!--Ended  Fourth row form  -->




<!--Started Fifth row form  -->

<div class="addMoreInfoSec">
	<div class="addMoreInfoSecBtn">
		<h1 style="color: black;font-weight: bold;margin-bottom: 20px;cursor: pointer;" onclick="myMoreInfoFunShow()">More Information <img class="BussinesSecDown errow-drop" style="height: 25px;position: relative;top: 9px;" src="images/down-arrow-30.png" >
		</h1>
	</div>

	<div class="myMoreInfo_hideSec" id="myMoreInfo_hide" style="width:100%;display:none;">
		

		<table>
			<tr>
				<td style="">

				<div class="griddiv" style="width: 95%;border-bottom: 0px;"><label>
							<div class="gridlable" style="width: 100px;">Weekend Days<span class=""></span></div>
							<select id="weekend" name="weekend" class="gridfield " autocomplete="off" displayname="Weekend Days" onchange="allweekend(this)" onclick="allweekend(this)">

								<?php
								$select1 = '*';
								$where1 = ' 1 and deletestatus=0 and status=1';
								$rs1 = GetPageRecord($select1, _WEEKEND_MASTER_, $where1);
								while ($resListing11 = mysqli_fetch_array($rs1)) {
								?>
								<option value="<?php echo ($resListing11['id']); ?>" <?php if ($resListing11['id'] == $editresult['weekendDays']) { ?>selected="selected" <?php } ?>><?php echo ($resListing11['name']); ?></option>
								<?php } ?>
							</select>
						</label>

					</div>
					
				</td>

				<td style="position: relative;left: 9%;">

					<div class="griddiv" style="width:50%;border-bottom: 0;"><label>
						<div class="gridlable" style="width: 100%;">Check-In&nbsp;Time  <span class=""></span></div>
						<input type="text" id="checkInTime" name="checkInTime" value="<?php if ($editresult['checkInTime'] != '') {
							echo  date('H:i', strtotime($editresult['checkInTime']));
						} else {
							echo "12:00";
						}  ?>" class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59" data-show-2400="true" />
						</label>

					</div>
				</td>

				<td>
				<div class="griddiv" style="width: 50%;">
						<div class="gridlable" style="width: 100%;">Check-Out&nbsp;Time <span class=""></span></div>

						<label>
							<!--for checkout time-->
							<input type="text" id="checkOutTime" name="checkOutTime" value="<?php if ($editresult['checkOutTime'] != '') {
								echo  date('H:i', strtotime($editresult['checkOutTime']));
							} else {
								echo "11:00";
							} ?>" class="gridfield  timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="11:00" data-max-time="10:59" data-show-2400="true" />

						</label>

						</div>
				</td>

				<td>
				<div class="griddiv" style="padding-right:10px;"><label>
					<div class="gridlable">Hotel Link</div>
					<input name="url" type="text" class="gridfield" id="url" value="<?php echo $editresult['url']; ?>" />
					</label>
					</div>
				</td>

				<td>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width: 100px;">Hotel Amenities</div>
						<select name="hotel_amenities[]" multiple="multiple" class="gridfield js-example-basic-multiple" id="hotel_amenitiesId" displayname="Hotel Amenities" autocomplete="off">
							<option value="">Select</option>
							<?php
							$select = '';
							$where = '';
							$rs = '';
							$select = '*';
							$where = ' 1 order by name asc';
							$rs = GetPageRecord($select, _AMENITIES_MASTER_, $where);
							while ($resListing = mysqli_fetch_array($rs)) {
								$hotelamenities = array_map('trim', explode(",", $editresult['amenities']));
							?>
								<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($hotelamenities as $key => $value) { if ($resListing['id'] == $value) {
								echo 'selected="selected"'; } } ?>><?php echo strip($resListing['name']); ?></option>
							<?php } ?>
						</select>
					</label>
					</div>	
				</td>
			</tr>
			<tr>
				<td>
				<div id="loadweekend" style="margin-top: -30px"><br>

					<div class="gridlable">
						<!-- Days -->
						<span class=""></span></div>

					<div style="border:0px #e0e0e0 solid;margin-top:5px;background-color:#FFFFFF;padding:2px;overflow: auto;height: 29px;">

						<?php

						if ($editresult['weekendDays'] != '') { ?>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' name!="" and deletestatus=0 and id="' . $editresult['weekendDays'] . '" order by id desc';

							$rs = GetPageRecord($select, _WEEKEND_MASTER_, $where);

							$resListing = mysqli_fetch_array($rs);

							$weekendDays = explode(",", $resListing['weekendDays']);

							foreach ($weekendDays as $key => $value) {

								if ($value == 1) {

									$days = 'Monday';
								}

								if ($value == 2) {

									$days = 'Tuesday';
								}

								if ($value == 3) {

									$days = 'Wednesday';
								}

								if ($value == 4) {

									$days = 'Thursday';
								}

								if ($value == 5) {

									$days = 'Friday';
								}

								if ($value == 6) {

									$days = 'Saturday';
								}

								if ($value == 7) {

									$days = 'Sunday';
								}
							?><div style="padding:3px 10px; float:left; color:#FFFFFF; background-color:#2C8CB1; width:fit-content; margin:3px; border-radius:3px;"><?php echo  $days; ?></div>

							<?php } ?>

						<?php } ?>

					</div>
					<script type="text/javascript" src="js/jquery.timepicker.js"></script>
					<script type="text/javascript">
						$(document).ready(function() {
							$('.timepicker2').timepicker();
							$('.select2').select2();
						});
					</script>

</div>
				</td>
			</tr>
		</table>
		
		
			
	


	<table id="Hinfo" style="width:100%; margin-top:20px;">
			<tr>
				<td>
				<div class="griddiv"><label>
					<div class="gridlable">Hotel Information</div>
					<textarea name="hoteldetail" rows="2" class="gridfield" id="hoteldetail"><?php echo stripslashes(stripslashes($editresult['hoteldetail'])); ?></textarea>
					</label>
				</div>		
				</td>
			</tr>

			<tr>
				<td>
				<div class="griddiv"><label>
					<div class="gridlable">Policy</div>
					<textarea name="hotelpolicy" rows="2" class="gridfield" id="hotelpolicy"><?php echo $editresult['policy']; ?></textarea>
					</label>
				</div>
				</td>
			</tr>

			<tr>
				<td>
				<div class="griddiv"><label>
				<div class="griddiv"><label>
					<div class="gridlable">T&C</div>
					<!-- <input name="hoteltcImage" type="file" class="gridfield" id="hoteltcImage" style="width: 250px;margin-left: -122px;" />
					<input type="hidden" name="oldhotleImage" id="oldhotleImage" value="<?php echo $editresult['hotelImage']; ?>" /> -->
					</label>

				</div>

					<textarea style="margin-top: -10px;" name="hoteltermandcondition" rows="2" class="gridfield" id="hoteltermandcondition"><?php echo stripslashes($editresult['termAndCondition']); ?></textarea>
					</label>
				</div>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td width="10%">
					<div class="griddiv">
						<div class="gridlable" style="width: 50%;">Verified<span class="redmind"></span></div>
						<label>
							<!--for verified-->
							<select id="verified" type="text" class="gridfield" name="verified" displayname="Verified" autocomplete="off" style="width: 100%;">

								<option value="1" <?php if ($editresult['verified'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>

								<option value="0" <?php if ($editresult['verified'] == '0') { ?>selected="selected" <?php } ?>>No</option>
							</select>
						</label>
					</div>
				</td>
				
				<td width="90%">
					<div class="griddiv"><label>
					<div class="griddiv"><label>
						<div class="gridlable">Internal Note</div></label>
					</div>
						<textarea style="margin-top: -10px;" name="hotelInternalNote" rows="1" class="gridfield" id="hotelInternalNote"><?php echo stripslashes($editresult['hotelInternalNote']); ?></textarea>
						</label>
					</div>
				</td>	
			</tr>
		</table>
	</div>

</div>


<!-- address show hide sec Started Js -->
<script>
function myMoreInfoFunShow() {
var x = document.getElementById("myMoreInfo_hide");

if (x.style.display === "none") {
	x.style.display = "block";
} else {
	x.style.display = "none";
}
}
</script>
<!-- address show hide sec Ended Js -->
<!--Ended Fifth row form  -->
					
</div>






				
		</div>

				<script>
					function selectcity() {

						var stateId = $('#stateId2').val();

						$('#cityId2').load('loadcity.php?id=' + stateId + '&selectId=<?php echo $addressData['cityId']; ?>');

					}

					function selectstate() {

						var countryId = $('#countryId2').val();

						$('#stateId2').load('loadstate.php?action=hotelstateselection&id=' + countryId + '&selecteId=<?php echo $addressData['stateId']; ?>');

					}
					selectstate();
					<?php

					if ($_GET['id'] != '') {

					?>

						selectstate();

						selectcity();

					<?php } ?>
				</script>

<!-- 				
<div style="display: block;width: 100%;">
</div> -->
<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
<input name="action" type="hidden" id="action" value="addedit_packagehotelmaster" />
</form>
</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>



	<!--<link href="css/main.css" rel="stylesheet" type="text/css" />

-->

	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.js-example-basic-multiple').select2();

			$('.js-example-basic-single').select2();

		});

		$(document).ready(function() {


			$("#checkallroomType").click(function() {

				if (this.checked) {

					$('.Checkedrmtype').each(function() {

						this.checked = true;

					})

				} else {

					$('.Checkedrmtype').each(function() {

						this.checked = false;

					})

				}

			});

			$("#checkallamnties").click(function() {

				if (this.checked) {

					$('.Checkedamen').each(function() {

						this.checked = true;

					})

				} else {

					$('.Checkedamen').each(function() {

						this.checked = false;

					})

				}

			});



		});

		function allweekend(e) {

			var weekendid = e.value;

			$("#loadweekend").load('loadWeekendDays.php?id=' + weekendid);

			$("#editweekend").hide();

		}
	</script>


	<style>
		.select2-container {

			width: 100% !important;
			;

		}

		.select2-container--open {

			z-index: 9999999999 !important;

		}
	</style>

	<?php 
}


if ($_GET['action'] == 'addedit_packagesightseeingmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_SIGHTSEEING_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Sightseeing </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="sightseeingName" type="text" class="gridfield validate" id="sightseeingName" displayname="Name" value="<?php echo strip($editresult['sightseeingName']); ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Destination<span class="redmind"></span></div>

						<select id="sightseeingCity" name="sightseeingCity" class="gridfield validate" displayname="city" autocomplete="off">

							<option value="">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' 1 and name!="" and deletestatus="0" order by name asc';

							$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['name'] == $editresult['sightseeingCity']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>





				<div class="griddiv"><label>

						<div class="gridlable">Detail</div>

						<textarea name="sightseeingDetail" rows="5" class="gridfield" id="sightseeingDetail"><?php echo strip($editresult['sightseeingDetail']); ?></textarea>

					</label>

				</div>





				<div class="griddiv"><label>

						<div class="gridlable">Photo</div>

						<input name="hotelImage" type="file" class="gridfield" id="hotelImage" />

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

						</select>

					</label>

				</div>





				<div class="griddiv"><label>

						<div class="gridlable">Type</div>

						<select name="sightseeingType" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['sightseeingType'] == 1) { ?> selected="selected" <?php } ?>>SIC</option>

							<option value="2" <?php if ($editresult['sightseeingType'] == 2) { ?> selected="selected" <?php } ?>>PRIVATE</option>

						</select>

					</label>

				</div>





				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_packagesightseeingmaster" />

				<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['sightseeingImage']; ?>" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }









if ($_GET['action'] == 'addedit_packagetransfermaster') {

	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id=' . $id . '';
		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_TRANSFER_MASTER, $where1);
		$editresult = mysqli_fetch_array($rs1);
	}
	?>
	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	<script type="text/javascript" >
		$(document).ready(function() {
		    $('#destinationSelect').select2({
		        placeholder: 'Search Destination',
		        minimumInputLength: 3,  // Set the minimum number of characters before a search is performed
		        ajax: {
		            url: 'loaddestinations.php',  // URL to fetch data from the server
		            dataType: 'json',  // The data type you expect from the server
		            delay: 250,  // Delay in milliseconds before sending the AJAX request
		            data: function(params) {
		                return {
		                    q: params.term  // The search term entered by the user
		                };
		            },
		            processResults: function(data) {
		                return {
		                    results: data  // Processed results to be shown in the dropdown
		                };
		            },
		            cache: true  // Enable caching to reduce redundant requests
		        }
		    });
		});
	</script>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Transfer/Transportation </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td width="50%" colspan="2">
							<div class="griddiv"><label>
									<div class="gridlable">Transfer/Transportation&nbsp;Name<span class="redmind"></span></div>

									<input name="transferName" type="text" class="gridfield validate" id="transferName" displayname="Transfer Name" value="<?php echo strip($editresult['transferName']); ?>" />

									<input name="trnsType" type="hidden" class="gridfield" id="trnsType" value="<?php echo $_REQUEST['trnsType']; ?>" readonly="" />

								</label>
							</div>
						</td>

						<td width="50%" colspan="2">
							<div class="griddiv">

								<label>
									<div class="gridlable">Destinations</div>
									<select id="destinationSelect" name="destinationId[]" multiple="multiple" class="gridfield validate" style=" width:160px;">
									    <option value="">Search for a city...</option>
									    <?php
									    $destIdArray = explode(',', $editresult['destinationId']);
										if(in_array('0', $destIdArray)){
											echo '<option value="all_dest" selected="selected" >All</option>';
										}else{
											$rs='';   
											$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc');  
											while($destinationData=mysqli_fetch_array($rs)){  ?>  
												<option value="<?php echo strip($destinationData['id']); ?>" <?php foreach($destIdArray as $val){ if($val==strip($destinationData['id'])){ ?> selected="selected" <?php } } ?> ><?php echo strip($destinationData['name']); ?></option> 
												<?php 
											} 
										}
										?> 
									</select>


								</label>
							</div>
						</td>
					</tr>

					<tr style="display:none;" >

						<td width="50%" style="display:none;" colspan="2">
							<div class="griddiv"><label>

									<div class="gridlable">Transfer/Transportation<span class="redmind"></span></div>

									<select id="transferCategory" name="transferCategory" class="gridfield validate" displayname="city" autocomplete="off">

										<?php if ($editresult['transferCategory'] == 'transportation' || $_REQUEST['trnsType'] == 'transportation') { ?>

											<option value="transportation" <?php if ($editresult['transferCategory'] == 'transportation') { ?> selected="selected" <?php } ?>>Transportation Package</option>

										<?php } ?>

										<?php if ($editresult['transferCategory'] == 'transfer' || $_REQUEST['trnsType'] == 'transfer') { ?>

											<option value="transfer" <?php if ($editresult['transferCategory'] == 'transfer') { ?> selected="selected" <?php } ?>>Transfer </option>

										<?php } ?>

									</select>

								</label>

							</div>
						</td>

						<td width="33%" colspan="2">
							<div class="griddiv"><label>

									<div class="gridlable">Photo</div>

									<input name="hotelImage" type="file" class="gridfield" id="hotelImage" />

								</label>

							</div>
						</td>

					</tr>
					<tr>
				
						<td colspan="2">
							<div class="griddiv"><label>

									<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">
						<option value="1" <?php if ($editresult['status'] == 1 || $editresult['status'] == '')
						 { ?> selected="selected" <?php } echo $editresult['status']; ?>>Active</option>
						<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
						</select>

								</label>

							</div>
						</td>
						<td width="50%" colspan="2">
							<div class="griddiv">

								<label>
									<div class="gridlable">Transfer&nbsp;Type</div>

									<select name="transferType" class="gridfield" id="transferType">
									<option value="0" <?php if($editresult['transferType']==0){ ?> selected="selected"<?php } ?> >All</option>
										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										$where = ' deletestatus=0 and status=1 order by id asc';

										$rs = GetPageRecord($select, 'transferTypeMaster', $where);

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo strip($resListing['id']); ?>" <?php if ($editresult['transferType'] == $resListing['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

										<?php } ?>

									</select>



								</label>

							</div>
						</td>

					</tr>
					<tr>
					<td >
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Default For Proposal</div>

									<select id="isOptTours" name="isOptTours" class="gridfield" onchange="isOptionalTours();" autocomplete="off">

										<option value="0" <?php if ($editresult['isOptTours'] == '0') { ?> selected="selected" <?php } ?>>No</option>

										<option value="1" <?php if ($editresult['isOptTours'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

									</select>

								</label>

							</div>
						</td> 

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?>>
							<div class="griddiv"><label>

									<div class="gridlable isOptMandatory" style="width:100%;">Currency</div>

									<select id="isOptCurrencyId" name="isOptCurrencyId" class="gridfield " autocomplete="off">
										<?php 
										$rscc = GetPageRecord('*','queryCurrencyMaster','status=1 and deletestatus=0 and name!="" order by name asc');
										while( $currecyData = mysqli_fetch_assoc($rscc)){
											if($editresult['currencyId']=='0' || $editresult['currencyId']==''){
												$currencyId = $baseCurrencyId;
											}else{
												$currencyId = $editresult['currencyId'];
											}
										?>
										<option value="<?php echo $currecyData['id']; ?>" <?php if ($currecyData['id'] == $currencyId) { ?> selected="selected" <?php } ?>><?php echo $currecyData['name']; ?></option>
										<?php } ?>

									</select>

								</label>

							</div>
						</td> 			

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?> >
							<div class="griddiv"><label>

									<div class="gridlable isOptMandatory" style="width:100%;">Adult Cost</div>

									<input type="text" id="adultCostOpt" name="adultCost" class="gridfield " autocomplete="off" value="<?php echo $editresult['adultCost']; ?>" displayname="Adult Cost">

								</label>

							</div>
						</td>

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?> >
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Child Cost </div>

									<input type="text" id="childCost" name="childCost" class="gridfield " autocomplete="off" value="<?php echo $editresult['childCost']; ?>" displayname="Child Cost">

								</label>

							</div>
						</td>
					</tr>

					
					
							


							
					<script>

						function isOptionalTours(){
						
								var isOptTours = $("#isOptTours").val();
								if(isOptTours=='1'){
									$(".isTourOptCost").show();
									$("#adultCostOpt").addClass('validate');
									$("#childCostOpt").addClass('validate');
									$(".isOptMandatory").append(`<span class="redmind"></span>`);
								}else{

									$(".isTourOptCost").hide();
									$("#adultCostOpt").removeClass('validate');
									$("#childCostOpt").removeClass('validate');
								}
						
						}

						isOptionalTours();
					</script>

					<tr>

						<td colspan="4">
							<div class="griddiv"><label>

									<div class="gridlable">Detail</div>

									<textarea name="transferDetail" rows="5" class="gridfield" id="transferDetail"><?php echo strip($editresult['transferDetail']); ?></textarea>

								</label>

							</div>
						</td>

					</tr>


				</table>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_packagetransfermaster" />

				<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['transferImage']; ?>" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

			<script>
				$(document).ready(function() {

					$('.js-example-basic-multiple').select2();
				
					$('.js-example-basic-multiple').on("select2:select", function (e) { 
					var data = e.params.data.text;
					if(data=='Select All'){
						
						$(".js-example-basic-multiple > option" ).prop("selected","selected");
						$('.js-example-basic-multiple').val()
						$(".js-example-basic-multiple").trigger("change");
						
						$(".select2-selection__rendered").css("overflow-y","scroll");
						$(".select2-selection__rendered").css("max-height","90px");
						
					}
					if(data=='Unselect All'){
						$('.js-example-basic-multiple').select2('destroy').find('option').prop('selected', false).end().select2();
					}
						
      				}); 
					  $(".select2-selection__rendered").css("overflow-y","scroll");
						$(".select2-selection__rendered").css("max-height","90px");

				});
			</script>

			<style>
				.select2-container {

					width: 100% !important;
				}



				#alertnotificationsmainbox .select2-container .select2-search--inline {

					display: block;

					width: 100% !important;

				}



				.select2-container--open {

					z-index: 9999999
				}

				.select2-container .select2-selection--single {

					height: 35px;

				}

				.addeditpagebox .griddiv .gridlable {

					display: block;

				}

				.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

					width: 100% !important;

				}

				#alertnotificationsmainbox .select2-search__field {

					padding: 6px !important;

					width: 100% !important;

					border: 1px solid #ccc;
				}
			</style>

		</div>
	</div>





<?php }





if ($_GET['action'] == 'addedit_packageairlinemaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_AIRLINES_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Airline </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Airline Name<span class="redmind"></span></div>

						<input name="flightName" type="text" class="gridfield validate" id="flightName" displayname="Airline Name" value="<?php echo strip($editresult['flightName']); ?>" />

					</label>

				</div>





				<div class="griddiv"><label>

						<div class="gridlable">Photo</div>

						<input name="hotelImage" type="file" class="gridfield" id="hotelImage" />

					</label>

				</div>
				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

							<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>






				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_packageairlinemaster" />

				<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['flightImage']; ?>" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>
<?php 
}

if ($_GET['action'] == 'addedit_'.$_REQUEST['sectiontype'].'' && ( $_REQUEST['sectiontype'] == 'luxurytrain' || $_REQUEST['sectiontype'] == 'trainmaster' )) {
	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id=' . $id . '';
		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_TRAINS_MASTER_, $where1);
		$editresult = mysqli_fetch_array($rs1);
	}
	?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') { echo 'Edit'; } else { echo 'Add'; } ?> Train </h1>
		<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv"><label>
						<div class="gridlable">Train Name<span class="redmind"></span></div>
						<input name="trainName" type="text" class="gridfield validate" id="trainName" displayname="Train Name" value="<?php echo strip($editresult['trainName']); ?>" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Image</div>
						<input name="trainImage" type="file" class="gridfield" id="trainImage" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Status</div>
						<select id="status" name="status" class="gridfield " autocomplete="off">
							<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>
							<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
						</select>
					</label>
				</div>
				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="sectiontype" type="hidden" id="sectiontype" value="<?php echo $_REQUEST['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_<?php echo $_REQUEST['sectiontype']; ?>" />
				<input name="trainImage2" type="hidden" id="trainImage2" value="<?php echo $editresult['trainImage']; ?>" />
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
	<?php 
}


if ($_GET['action'] == 'addedit_traincabintype' && $_GET['sectiontype'] == 'traincabintype') {
	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id="'.$id.'"';
		$rs1 = GetPageRecord($select1, _TRAIN_CABIN_TYPE_, $where1);
		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']);
		$roomoccupancy = clean($editresult['roomoccupancy']);
		$status = clean($editresult['status']);
	}
	?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Train Cabin Type </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable">Train Cabin Name<span class="redmind"></span></div>
						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Room Occupancy<span class="redmind"></span></div>
						<input name="roomoccupancy" type="text" class="gridfield validate" id="roomoccupancy" displayname="Name" value="<?php echo $roomoccupancy; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">
							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>
							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>
						</select>
					</label>
				</div>
				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_traincabintype" />
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
	<?php 
}
//entrance box

if ($_GET['action'] == 'addedit_entrancemaster'){

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_ENTRANCE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$finalweekendDays = explode(',', $editresult['closeDaysname']);
	}

	?>

	<div class="contentclass">

		<h1 style="text-align:left;">
			<?php if ($_REQUEST['id'] != '') {
			echo 'Edit';
			} else {
			echo 'Add';
			} ?> Monument </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellspacing="0" cellpadding="5">

					<tr>

						<td width="100%" colspan="4">
							<div class="griddiv"><label>

									<div class="gridlable">Monument&nbsp;Name<span class="redmind"></span></div>

									<input name="entranceName" type="text" class="gridfield validate" id="entranceName" displayname="Monument Name" value="<?php echo strip($editresult['entranceName']); ?>" />

								</label>

							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" width="50%">
							<div class="griddiv"><label>

									<div class="gridlable">Destination<span class="redmind"></span></div>

									<select id="entranceCity" name="entranceCity" class="gridfield validate" displayname="city" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										$where = ' 1 and name!="" and deletestatus="0" order by name asc';

										$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

										while ($resListing = mysqli_fetch_array($rs)) {

										?>

											<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['name'] == $editresult['entranceCity']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

										<?php } ?>

									</select>

								</label>

							</div>
						</td>

						<td width="23%">
							<div class="griddiv"><label>
								<div class="gridlable">Transfer&nbsp;Type</div>
								<select id="tptType" name="tptType" class="gridfield " autocomplete="off">
									<option value="0" <?php if ($editresult['tptType'] == '0') { ?> selected="selected" <?php } ?>>ALL</option>
									<option value="1" <?php if ($editresult['tptType'] == '1') { ?> selected="selected" <?php } ?>>SIC</option>
									<option value="2" <?php if ($editresult['tptType'] == '2') { ?> selected="selected" <?php } ?>>PVT</option>
									<option value="3" <?php if ($editresult['tptType'] == '3' || !isset($editresult['tptType'])) { ?> selected="selected" <?php } ?>>Ticket Only</option>
								</select>
								</label>
							</div>
						</td>
						<td width="20%">
							<div class="griddiv"><label>

									<div class="gridlable">Status</div>

									<select id="status" name="status" class="gridfield " autocomplete="off">

										<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

										<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

									</select>

								</label>

							</div>
						</td>

					</tr>

					<tr>

						<td colspan="2">
							<div class="griddiv"><label> 
									<div class="gridlable">Closed&nbsp;On&nbsp;Days</div> 
									<select name="daysname[]" size="1" multiple="multiple" class="gridfield select2" id="daysname" displayname="Weekent Name" autocomplete="off"> 
										<?php 
										$rs = GetPageRecord('*', 'weekendDaysMaster', ' deleteStatus=0 order by sr asc'); 
										while ($resListing = mysqli_fetch_array($rs)) {  ?> 
											<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($finalweekendDays as $key => $value) { if ($value == $resListing['name']) { echo 'selected="selected"'; } } ?>><?php echo strip($resListing['name']); ?></option> 
										<?php } ?> 
									</select> 
								</label> 
							</div> 
							<script src="plugins/select2/select2.full.min.js"></script>

							<script>
								$(document).ready(function() {

									$('.select2').select2();



								});
							</script>

							<style>
								.select2-container--open {

									z-index: 9999999999 !important;

									width: 100%;

								}

								.select2-container {

									box-sizing: border-box;

									display: inline-block;

									margin: 0;

									position: relative;

									vertical-align: middle;

									width: 100% !important;

								}
							</style>
						</td>
						

						<td colspan="2">
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Default For Quotation</div>

									<select id="isDefault" name="isDefault" class="gridfield " autocomplete="off">

										<option value="0" <?php if ($editresult['isDefault'] == '0') { ?> selected="selected" <?php } ?>>No</option>

										<option value="1" <?php if ($editresult['isDefault'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

									</select>

								</label>

							</div>
						</td> 
					</tr>

					<tr>
					<td >
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Default For Proposal</div>

									<select id="isOptTours" name="isOptTours" class="gridfield " autocomplete="off" onchange="isOptionalTours();">

										<option value="0" <?php if ($editresult['isOptTours'] == '0') { ?> selected="selected" <?php } ?>>No</option>

										<option value="1" <?php if ($editresult['isOptTours'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

									</select>

								</label>

							</div>
						</td> 

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?>>
							<div class="griddiv"><label>

									<div class="gridlable isOptMandatory" style="width:100%;">Currency</div>

									<select id="isOptCurrency" name="isOptCurrency" class="gridfield " autocomplete="off">
										<?php 
										$rscc = GetPageRecord('*','queryCurrencyMaster','status=1 and deletestatus=0 and name!="" order by name asc');
										while( $currecyData = mysqli_fetch_assoc($rscc)){
											if($editresult['currencyId']=='0' || $editresult['currencyId']==''){
												$currencyId = $baseCurrencyId;
											}else{
												$currencyId = $editresult['currencyId'];
											}
										?>
										<option value="<?php echo $currecyData['id']; ?>" <?php if ($currecyData['id'] == $currencyId) { ?> selected="selected" <?php } ?>><?php echo $currecyData['name']; ?></option>
										<?php } ?>

									</select>

								</label>

							</div>
						</td> 

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?> >
							<div class="griddiv"><label>

									<div class="gridlable isOptMandatory" style="width:100%;">Adult Cost</div>

									<input type="text" id="adultCostOpt" name="adultCost" class="gridfield " autocomplete="off" value="<?php echo $editresult['adultCost']; ?>" displayname="Adult Cost">

								</label>

							</div>
						</td>

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?> >
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Child Cost </div>

									<input type="text" id="childCost" name="childCost" class="gridfield " autocomplete="off" value="<?php echo $editresult['childCost']; ?>" displayname="Child Cost">

								</label>

							</div>
						</td>
					</tr>

					<script>

						function isOptionalTours(){
						
								var isOptTours = $("#isOptTours").val();
								if(isOptTours=='1'){
									$(".isTourOptCost").show();
									$("#adultCostOpt").addClass('validate');
									$("#childCostOpt").addClass('validate');
									$(".isOptMandatory").append(`<span class="redmind"></span>`);
								}else{

									$(".isTourOptCost").hide();
									$("#adultCostOpt").removeClass('validate');
									$("#childCostOpt").removeClass('validate');
								}
						
						}

						isOptionalTours();
					</script>

					<tr>
						<td colspan="2">
							<div class="griddiv"><label>
								<div class="gridlable w100">Weekend&nbsp;Days<span class="redmind"></span></div>
								<select id="weekendId" name="weekendId" class="gridfield " autocomplete="off" displayname="Weekend Name" onchange="allweekend(this)" onclick="allweekend(this)">
									<?php
									$select1 = '*';
									$where1 = ' 1 and deletestatus=0 and status=1';
									$rs1 = GetPageRecord($select1, _WEEKEND_MASTER_, $where1);
									while ($resListing11 = mysqli_fetch_array($rs1)) {
									?>
									<option value="<?php echo ($resListing11['id']); ?>" <?php if ($resListing11['id'] == $editresult['weekendId']) { ?>selected="selected" <?php } ?>><?php echo ($resListing11['name']); ?></option>
									<?php } ?>
								</select>
								</label>
							</div>
						</td>
						<td colspan="2">
							<div class="griddiv"  id="loadweekend"><label>
								<div class="gridlable w100">
									<!-- Days -->
									<span class="redmind"></span></div>
								<div style="border:1px #e0e0e0 solid;margin-top:5px;background-color:#FFFFFF;padding:2px;overflow: auto;height: 29px;">
									<?php
									if ($editresult['weekendId'] != '') {
										$rs = '';
										$rs = GetPageRecord('*', _WEEKEND_MASTER_, ' name!="" and deletestatus=0 and id="' . $editresult['weekendId'] . '"');
										$resListing = mysqli_fetch_array($rs);

										$daysName = explode(",", $resListing['daysName']);
										foreach($daysName as $key => $value) {
											?><div style="padding:3px 10px; float:left; color:#FFFFFF; background-color:#2C8CB1; width:fit-content; margin:3px; border-radius:3px;"><?php echo  $value; ?></div>
											<?php 
										}  
									} ?>
								</div>
							</label>
							</div>
						<script type="text/javascript">
							function allweekend(e) {
								var weekendid = e.value;
								$("#loadweekend").load('loadWeekendDays.php?id=' + weekendid);
							}
						</script>
						</td> 
					</tr>

					<tr>

						<td colspan="4">
							<div class="griddiv"><label>

									<div class="gridlable">Description</div>

									<textarea name="entranceDetail" id="description22" rows="5" class="gridfield" id="entranceDetail"><?php echo stripslashes($editresult['entranceDetail']); ?></textarea>

								</label>

							</div>
						</td>

					</tr>

				</table>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="dmcId" type="hidden" id="editId" value="<?php echo $editresult2['id']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_entrancemaster" />

				<input name="entranceImage2" type="hidden" id="entranceImage2" value="<?php echo $editresult['entranceImage']; ?>" />

			</form>

			
		<script src="tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
				selector: "#description22"
			});   
		</script>
		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php

}

//entrance supplier adding

if ($_GET['action'] == 'addeditpackagesupplier_entrancemaster') {

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Monument Suppliers </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Supplier Name<span class="redmind"></span></div>

						<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Monument Suppliers" autocomplete="off">

							<option value="">Select</option>

							<?php

							if ($_GET['entranceid'] != '') {

								$entranceid = clean($_GET['entranceid']);
							}

							$no = 1;

							$select = '*';

							$where = '';

							$rs = '';

							$wheresearch = '';

							$limit = clean($_GET['records']);

							$mainwhere = '';

							$assignto = '';

							if ($_GET['assignto'] != '') {

								$assignto = ' and	assignTo=' . $_GET['assignto'] . '';
							}



							if ($loginuserprofileId == 1) {

								$wheresearch = ' 1 ' . $mainwhere . '';
							} else {

								$wheresearch = ' 1 ' . $mainwhere . '';
							}



							$where = 'where ' . $wheresearch . ' and name!="" ' . $assignto . ' and entranceType=4 and deletestatus=0 order by dateAdded desc';

							$page = $_GET['page'];



							$targetpage = $fullurl . 'showpage.crm?module=suppliers&records=' . $limit . '&searchField=' . $searchField . '&assignto=' . $_GET['assignto'] . '&suppliertype=' . $_GET['suppliertype'] . '&';

							$rs = GetRecordList($select, _SUPPLIERS_MASTER_, $where, $limit, $page, $targetpage);

							$totalentry = $rs[1];

							$paging = $rs[2];

							while ($resultlists = mysqli_fetch_array($rs[0])) {

								$supplr_id = $resultlists['id'];

							?>

								<option value="<?php echo strip($resultlists['id']); ?>"><?php echo strip($resultlists['name']); ?></option>

							<?php

							} ?>

						</select>

					</label>

				</div>



				<input name="entranceid" type="hidden" id="entranceid" value="<?php echo $entranceid; ?>" />

				<input name="action" type="hidden" id="action" value="addeditpackagesupplier_entrancemaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php

}







if ($_GET['action'] == 'addeditpackagesupplier_packagehotelmaster') {

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Hotel Suppliers </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Supplier Name<span class="redmind"></span></div>

						<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Hotel Supplier" autocomplete="off">

							<option value="">Select</option>

							<?php

							if ($_GET['hotelid'] != '') {

								$hotelid = clean($_GET['hotelid']);
							}

							$no = 1;

							$select = '*';

							$where = '';

							$rs = '';

							$wheresearch = '';

							$limit = 1000;

							$mainwhere = '';

							$assignto = '';

							if ($_GET['assignto'] != '') {

								$assignto = ' and	assignTo=' . $_GET['assignto'] . '';
							}



							$assignto = ' and	companyTypeId=1';









							if ($loginuserprofileId == 1) {

								$wheresearch = ' 1 ' . $mainwhere . '';
							} else {

								$wheresearch = ' 1 ' . $mainwhere . '';

								//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 

							}







							$where = 'where ' . $wheresearch . ' and name!="" ' . $assignto . ' and deletestatus=0 order by dateAdded desc';

							$page = $_GET['page'];



							$targetpage = $fullurl . 'showpage.crm?module=suppliers&records=' . $limit . '&searchField=' . $searchField . '&assignto=' . $_GET['assignto'] . '&suppliertype=' . $_GET['suppliertype'] . '&';

							$rs = GetRecordList($select, _SUPPLIERS_MASTER_, $where, $limit, $page, $targetpage);

							$totalentry = $rs[1];

							$paging = $rs[2];

							while ($resultlists = mysqli_fetch_array($rs[0])) {

								$supplr_id = $resultlists['id'];

								/*$sql5="select * from ad_courses ";

$res5 = mysqli_query (db(),db(),$sql5);

$countRoom = $num5=mysqli_num_rows($res5); */

							?>

								<option value="<?php echo strip($resultlists['id']); ?>"><?php echo strip($resultlists['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>



				<input name="hotelId" type="hidden" id="hotelId" value="<?php echo $hotelid; ?>" />

				<input name="action" type="hidden" id="action" value="addeditpackagesupplier_packagehotelmaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addeditpackagesupplier_packagesightseeingmaster') {

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Sightseeing Suppliers </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Supplier Name<span class="redmind"></span></div>

						<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Sightseeing Suppliers" autocomplete="off">

							<option value="">Select</option>

							<?php

							if ($_GET['sightseeingid'] != '') {

								$sightseeingid = clean($_GET['sightseeingid']);
							}

							$no = 1;

							$select = '*';

							$where = '';

							$rs = '';

							$wheresearch = '';

							$limit = clean($_GET['records']);

							$mainwhere = '';

							$assignto = '';

							if ($_GET['assignto'] != '') {

								$assignto = ' and	assignTo=' . $_GET['assignto'] . '';
							}



							//$assignto=' and	companyTypeId=1';









							if ($loginuserprofileId == 1) {

								$wheresearch = ' 1 ' . $mainwhere . '';
							} else {

								$wheresearch = ' 1 ' . $mainwhere . '';

								//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 

							}







							$where = 'where ' . $wheresearch . ' and name!="" ' . $assignto . ' and sightseeingType=4 and deletestatus=0 order by dateAdded desc';

							$page = $_GET['page'];



							$targetpage = $fullurl . 'showpage.crm?module=suppliers&records=' . $limit . '&searchField=' . $searchField . '&assignto=' . $_GET['assignto'] . '&suppliertype=' . $_GET['suppliertype'] . '&';

							$rs = GetRecordList($select, _SUPPLIERS_MASTER_, $where, $limit, $page, $targetpage);

							$totalentry = $rs[1];

							$paging = $rs[2];

							while ($resultlists = mysqli_fetch_array($rs[0])) {

								$supplr_id = $resultlists['id'];

								/*$sql5="select * from ad_courses ";

$res5 = mysqli_query (db(),db(),$sql5);

$countRoom = $num5=mysqli_num_rows($res5); */

							?>

								<option value="<?php echo strip($resultlists['id']); ?>"><?php echo strip($resultlists['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>



				<input name="sightseeingid" type="hidden" id="sightseeingid" value="<?php echo $sightseeingid; ?>" />

				<input name="action" type="hidden" id="action" value="addeditpackagesupplier_packagesightseeingmaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addeditpackagesupplier_packagetransfermaster') {

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Transfer Suppliers </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Supplier Name<span class="redmind"></span></div>

						<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Sightseeing Suppliers" autocomplete="off">

							<option value="">Select</option>

							<?php

							if ($_GET['transferid'] != '') {

								$transferid = clean($_GET['transferid']);
							}

							$no = 1;

							$select = '*';

							$where = '';

							$rs = '';

							$wheresearch = '';

							$limit = clean($_GET['records']);

							$mainwhere = '';

							$assignto = '';

							if ($_GET['assignto'] != '') {

								$assignto = ' and	assignTo=' . $_GET['assignto'] . '';
							}



							//$assignto=' and	companyTypeId=1';









							if ($loginuserprofileId == 1) {

								$wheresearch = ' 1 ' . $mainwhere . '';
							} else {

								$wheresearch = ' 1 ' . $mainwhere . '';

								//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 

							}







							$where = 'where ' . $wheresearch . ' and name!="" ' . $assignto . ' and transferType=5 and deletestatus=0 order by dateAdded desc';

							$page = $_GET['page'];



							$targetpage = $fullurl . 'showpage.crm?module=suppliers&records=' . $limit . '&searchField=' . $searchField . '&assignto=' . $_GET['assignto'] . '&suppliertype=' . $_GET['suppliertype'] . '&';

							$rs = GetRecordList($select, _SUPPLIERS_MASTER_, $where, $limit, $page, $targetpage);

							$totalentry = $rs[1];

							$paging = $rs[2];

							while ($resultlists = mysqli_fetch_array($rs[0])) {

								$supplr_id = $resultlists['id'];

								/*$sql5="select * from ad_courses ";

$res5 = mysqli_query (db(),db(),$sql5);

$countRoom = $num5=mysqli_num_rows($res5); */

							?>

								<option value="<?php echo strip($resultlists['id']); ?>"><?php echo strip($resultlists['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>



				<input name="transferid" type="hidden" id="transferid" value="<?php echo $transferid; ?>" />

				<input name="action" type="hidden" id="action" value="addeditpackagesupplier_packagetransfermaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_certificatelogomaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _CERTIFICATE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Certificate Logo </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">





				<div class="griddiv"><label>

						<div class="gridlable">Name</div>

						<input name="name" class="gridfield" id="name" value="<?php echo strip($editresult['name']); ?>" />

					</label>

				</div>







				<div class="griddiv"><label>

						<div class="gridlable">Photo</div>

						<input name="hotelImage" type="file" class="gridfield" id="hotelImage" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="0" <?php if ($editresult['status'] == 0) { ?> selected="selected" <?php } ?>>Active</option>

							<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Inactive</option>

						</select>

					</label>

				</div>





				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_certificatelogomaster" />

				<input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['logo']; ?>" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }


// =============================== Cruise Company Master start =============================

if ($_GET['action'] == 'addedit_cruisecompanymaster' && $_GET['sectiontype'] == 'cruisecompanymaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1,_CRUISE_COMPANY_, $where1);

		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']); 
		$location = clean($editresult['location']);
		$cruisewebsite = clean($editresult['website']);
		$selfSupplier = clean($editresult['selfSupplier']);
		$contactperson = clean($editresult['contactPerson']);
		$phone = clean(decode($editresult['phone']));
		$countryCode1 = clean($editresult['countryCode1']);
		$division = clean($editresult['division']);
		$designation = clean($editresult['designation']);
		$email = clean(decode($editresult['email']));
		$status = clean($editresult['status']);
	}

?>
	<div class="contentclass">
		<h1 style="text-align:left;">
		<?php if ($_REQUEST['id'] != '') { echo 'Edit';
										} else {
											echo 'Add';
										} ?> Cruise Company Master </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
		<div class="grid-container">
				<div class="griddiv grid-box" style="width: 320px;"><label>

						<div class="gridlable" style="width:70%; position:relative;">Cruise Company Name<span class="redmind" style="bottom:-39px;"></span></div>
						<input name="cruiseName" type="text" class="gridfield validate" id="cruiseName" displayname="Cruise Company" value="<?php echo $name; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv grid-box" style="width: 320px;"><label>
						<div class="gridlable" style="display: inline-block;">Destination<span class="redmind"></span></div>

						<select name="location[]" id="location" multiple="multiple" class="validate gridfield js-example-basic-multiple" displayname="Destination" autocomplete="off" >
						<option value="">Select Destination</option>
						<?php
					
						$where='';  
						$rs='';   
						$select='*';    
						$where=' deletestatus=0 and status=1 order by name asc';   
						$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
						$alldest=explode(',',$location);  
						while($resListing=mysqli_fetch_array($rs)){  
						
						?> 
						<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> 
						<?php } ?> 
						</select>
					</label>

				</div>
				</div>

				<div><h3 style="padding-bottom: 10px;">Address Info.</h3></div>
				<div class="grid-container2">

						<div class="griddiv">

							<label>

								<div class="gridlable">Country<span class="redmind"></span></div>

								<select id="countryIdC" name="countryIdC" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selectstate();">

									<option value="">Select</option>

									<?php

									$wherec = ' deletestatus=0 and status=1 order by name asc';

									$rsc = GetPageRecord('*', _COUNTRY_MASTER_, $wherec);

									while ($resListing = mysqli_fetch_array($rsc)) {

									?>

										<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['countryId']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

									<?php } ?>

								</select>
							</label>

						</div>
					
						<div class="griddiv">

							<label>

								<div class="gridlable">State </div>

								<select id="stateIdC" name="stateIdC" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();">
									<?php 
								 
									if($stateId!=''){
									$stateId=' and stateId="'.$stateId.'" ';
									}   
									$wherest=' deletestatus=0 and status=1 '.$stateId.' order by name asc';  
									$rss=GetPageRecord('*','cityMaster',$wherest); 
									while($resListing=mysqli_fetch_array($rss)){  
									
									?>
									<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['stateId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
									
									
							
								</select>
							</label>

						</div>
				
						<div class="griddiv">

							<label>

								<div class="gridlable">City </div>

								<select id="cityIdC" name="cityIdC" class="gridfield" displayname="City" autocomplete="off">

								</select>
							</label>

						</div>
					
						<div class="griddiv"><label>

								<div class="gridlable">Pin&nbsp;Code </div>

								<input name="pinCodeC" type="text" class="gridfield" id="pinCodeC" value="<?php echo $editresult['pinCode']; ?>" maxlength="15" />

							</label>

						</div>
					

					<script>


					function selectcity() {

						var stateId = $('#stateIdC').val();

						$('#cityIdC').load('loadcity.php?id=' +stateId+ '&selectId=<?php echo $editresult['cityId']; ?>');

					}


					function selectstate() {

						var countryId = $('#countryIdC').val();

						$('#stateIdC').load('loadstate.php?action=loadescortstate&id=' + countryId + '&selectId=<?php echo $editresult['stateId']; ?>');

					}

					selectcity();
						selectstate();
					</script>


				</div>

				<div class="griddiv"><label>

				<div class="gridlable">Address</div>
				<textarea name="fullAddress" id="fullAddress" class="gridfield" style="height:40px; width:100%;"><?php echo $editresult['address']; ?></textarea>

				</label>
				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Website</div>

						<input name="cruisewebsite" type="text" class="gridfield" id="cruisewebsite" displayname="Cruise Website" value="<?php echo $cruisewebsite; ?>" maxlength="100" />
					</label>
				</div>
				<div class="grid-container3">
				<div class="griddiv">

							<label>

								<div class="gridlable">GST </div>

								<input type="text" name="gstNumber" class="gridfield" id="gstNumber" value="<?php echo $editresult['gst']; ?>" displayname="GST Number">
							</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">Self Supplier</div>

						<select id="selfsupplier" type="text" class="gridfield" name="selfsupplier" displayname="Self Supplier" autocomplete="off" value="<?php echo $selfSupplier; ?>" style="width: 100%;">

							<option value="1" <?php if($selfSupplier == '1' || $selfSupplier == '') { ?> selected="selected" <?php } ?>>Yes</option>

							<option value="0" <?php if($selfSupplier == '0') { ?> selected="selected" <?php } ?>>No</option>



						</select>
					</label>
				</div>
				</div>

				<div class="griddiv"><label>

						<table width="100%" border="0" cellspacing="2" cellpadding="0">

							<tr>
							<div class="">Contact Person Information</div>
								<td width="70">
								
									<div class="griddiv">
										
										<label>

											<select id="division" name="division" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division" style="margin-top: 2px;">

												<option value="">Select Division</option>
												<?php  
												$selectd='*';    
												$whered=' deletestatus=0 and status=1 order by name asc';  
												$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
												while($resListingd=mysqli_fetch_array($rsd)){  
												?>
												<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($division == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
												<?php } ?> 

											</select>
										</label>

									</div>
								</td>

								<td width="70">
									<div class="griddiv"><label>

											<input name="contactperson" type="text" class="gridfield validate" id="contactperson" value="<?php echo $contactperson; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="70">
									<div class="griddiv"><label>

											<input name="designation" type="text" class="gridfield" id="designation" value="<?php echo $designation; ?>" displayname="Designation" placeholder="Designation" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="40">
									<div class="griddiv"><label>
											<input name="countryCode1" type="text" class="gridfield validate" id="countryCode1" value="+91" displayname="Country Code" placeholder="+91" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="80">
									<div class="griddiv"><label>

											<input name="phone" type="text" class="gridfield validate" id="phone" value="<?php echo $phone; ?>" displayname="Phone" placeholder="Phone" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="120">
									<div class="griddiv"><label>

											<input name="email" type="email" class="gridfield validate" id="email" value="<?php echo $email; ?>" displayname="Email" placeholder="Email" style="margin-top: 4px;" required />

										</label>

									</div>
								</td>

							</tr>

						</table>
					</label>
				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($editresult['status'] == '1'|| $editresult['status'] == '') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($editresult['status'] == '0' ) { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_cruisecompanymaster" />

			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Save " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>
			</table>

		</div>

	</div>

	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	
	<script>
			$(document).ready(function() {

				$('.js-example-basic-multiple').select2();

			});
		</script>

		<style>
			.grid-container{
				display: grid;
				grid-template-columns:49% 49%;	
				grid-gap:10px;

			}
		
			.grid-container2{
				display: grid;
				grid-template-columns:24% 24% 24% 24% ;	
				grid-gap:10px;
			}
			.grid-container3{
				display: grid;
				grid-template-columns:49% 49%;	
				grid-gap:10px;
			}


			.select2-container {

				width: 100% !important;
			}

			#alertnotificationsmainbox .select2-container .select2-search--inline {

				display: block;

				width: 100% !important;

			}

			.select2-container--open {

				z-index: 9999999
			}

			.select2-container .select2-selection--single {

				height: 34px;

			}

			.addeditpagebox .griddiv .gridlable {

				display: block;

			}

			.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

				width: 100% !important;

			}

			#alertnotificationsmainbox .select2-search__field {

				padding: 6px !important;

				width: 100% !important;

				border: 1px solid #ccc;
			}
			.addeditpagebox .griddiv{
				border:none;
			}
		</style>


<?php }

// ================= Cruise Company Master End and Ferry Class Master Start ===================


// ========================= Cruise Name Master start==========================
if ($_GET['action'] == 'addedit_cruiseNameMaster' && $_GET['sectiontype'] == 'cruiseNameMaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'cruiseNameMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$cruiseImage=$editresult['image'];
		$cruiseCompanyName = clean($editresult['cruiseCompanyId']);
		$capacity = clean($editresult['capacity']);
		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') { echo 'Edit'; } else { echo 'Add'; } ?> Ferry Name </h1> 
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">  
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			<div class="griddiv"><label> 
				<div class="gridlable">Cruise&nbsp;Company<span class="redmind"></span></div> 
				<select name="cruisecompany" id="cruisecompany" class="gridfield validate" displayname="Cruise&nbsp;Company">
				<option value="">Select Cruise  Company</option>
				<?php  
				$getfercomp = GetPageRecord('*',_CRUISE_COMPANY_,' deletestatus=0 and status=1 ');
				while($ferrycompname = mysqli_fetch_assoc($getfercomp)){
					?>
					<option value="<?php echo $ferrycompname['id'] ?>" <?php if($cruiseCompanyName == $ferrycompname['id']){ ?> selected="selected" <?php } ?> ><?php echo $ferrycompname['name']; ?></option>
					<?php
				} 
				?> 
				</select> 
				</label> 
			</div>
				<div class="griddiv"><label>

						<div class="gridlable">Cruise&nbsp;Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Cruise&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<!-- <div class="griddiv"><label>

						<div class="gridlable">Capacity</span></div>

						<input name="capacity" type="text" class="gridfield" id="capacity" displayname="Cruise&nbsp;Capacity" value="<?php echo $capacity; ?>" maxlength="100" />

					</label>

				</div> -->

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

		<div class="griddiv">
			<label>
				<div style="display: grid;"><?php if($_REQUEST['id']==''){  }else{ ?> <img align="left" style="display: inline-block;" src="packageimages/<?php echo $cruiseImage; ?>" alt="" width="85px" height="70px">  <?php } ?></div>
				<div class="gridlable">Cruise Image<span class="redmind"></span></div>
				<input name="cruiseImage" type="file" class="gridfield" id="cruiseImage" value="<?php echo $amenityImage; ?>" displayname="Upload Cruise Image"/>
		
				<input type="hidden" name="oldCruiseImage" id="oldCruiseImage" value="<?php if($cruiseImage!=''){echo $cruiseImage;} ?>" />
		
			</label>
		
		</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo clean($editresult['id']); ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_cruiseNameMaster" />

			</form>

		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>
<?php }
// ============== Cruise Name Master End ==================


if ($_GET['action'] == 'addedit_cruisetypemaster' && $_GET['sectiontype'] == 'cruisetypemaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _CRUISE_TYPE_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$companyId = clean($editresult['companyId']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Cruise Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<select id="companyId" name="companyId" class="gridfield validate" displayname="Company Name" autocomplete="off">

							<option value="0">Select</option>

							<?php

							$select = '';

							$where = '';

							$rs = '';

							$select = '*';

							$where = ' 1 order by name asc';

							$rs = GetPageRecord($select, _CRUISE_COMPANY_, $where);

							while ($resListing = mysqli_fetch_array($rs)) {

							?>

								<option value="<?php echo ($resListing['id']); ?>" <?php if ($resListing['name'] == $companyId) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_cruisetypemaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php }



// additional Hotel Master start ================

if($_GET['action']=='addedit_additionalHotelMaster' && $_GET['sectiontype']=='additionalHotelMaster'){ 

 

	if($_GET['id']!=''){
	
	$id=clean($_GET['id']);
	
	$select1='*';  
	
	$where1='id='.$id.''; 
	
	$rs1=GetPageRecord($select1,'additionalHotelMaster',$where1); 
	
	$editresult=mysqli_fetch_array($rs1);
	
	$name=clean($editresult['name']); 
	$detail=clean($editresult['detail']); 
	$image=clean($editresult['image']); 
	
	  $status=clean($editresult['status']); 
	}
	
	?>
	
	<div class="contentclass">
	
	<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Additional </h1>
	
	  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
	
	<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
	
	 <div class="griddiv"><label>
	
		<div class="gridlable">Additional&nbsp;Name<span class="redmind"></span></div>
	
		<input name="name" type="text" class="gridfield validate" id="name" displayname="Additional&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />
	
		</label>
	
		</div>

		<div class="griddiv"><label>
	
		<div class="gridlable">Detail</div>
		<textarea name="otherdetail" id="otherdetail" class="gridfield" cols="30" rows="5"><?php echo $detail; ?></textarea>

		</label>

		</div>
	
		<div class="griddiv"><label>
	<div class="gridlable">Image</div>
	<img src="packageimages/<?php echo $editresult['image'] ?>" alt="" style="width:80px;display:block;">
	<input name="imageadd" type="file" class="gridfield" id="imageadd" displayname="Photo" value="<?php echo $image; ?>" maxlength="100" />
	<input type="hidden" name="imageaddold" id="imageaddold" value="<?php echo $editresult['image'] ?>">

	</label>

	</div>


		<div class="griddiv">
	
		<label> 
	
		<div class="gridlable">status</div>
	
		<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>"  style="width: 100%;"> 	
	
		<option value="1" <?php if($status=='1'){ ?>selected="selected"<?php } ?>>Active</option>
	
		<option value="0" <?php if($status=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
	
		</select></label>
	
	</div>
	
	 <input name="editId" type="hidden" id="editId" value="<?php echo clean($editresult['id']); ?>" />
	
	 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
	
	 <input name="action" type="hidden" id="action" value="addedit_additionalHotelMaster" /> 
	
	</form>
	
	  
	
	  
	
	  </div>
	
	  <div id="buttonsbox"  style="text-align:center;">
	
	 <table border="0" align="right" cellpadding="0" cellspacing="0">
	
		  <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
	
			<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
	
		  </tr>
	
	   </table>
	
	</div></div>
	
		<?php }
	

// additional Hotel Master End ================


// =============================== Ferry Company Master start =============================

if ($_GET['action'] == 'addedit_ferryCompanymaster' && $_GET['sectiontype'] == 'ferryCompanymaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'ferryCompanyMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']); 
		$location = clean($editresult['location']);
		$ferrywebsite = clean($editresult['website']);
		$selfSupplier = clean($editresult['selfSupplier']);
		$contactperson = clean($editresult['contactPerson']);
		$phone = clean(decode($editresult['phone']));
		$countryCode1 = clean($editresult['countryCode1']);
		$division = clean($editresult['division']);
		$designation = clean($editresult['designation']);
		$email = clean(decode($editresult['email']));
		$status = clean($editresult['status']);
	}

?>
	<div class="contentclass">
		<h1 style="text-align:left;">
		<?php if ($_REQUEST['id'] != '') { echo 'Edit';
										} else {
											echo 'Add';
										} ?> Ferry Company Master </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Ferry Company Name<span class="redmind"></span></div>
						<input name="ferryName" type="text" class="gridfield validate" id="ferryName" displayname="Ferry Company" value="<?php echo $name; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable" style="display: inline-block;margin-top: 4px;">Destination<span class="redmind"></span></div>

						<select name="location[]" id="location" multiple="multiple" class="gridfield js-example-basic-multiple validate" displayname="Destination" autocomplete="off" >
						<option value="">Select Destination</option>
						<?php
						$select='';  
						$where='';  
						$rs='';   
						$select='*';    
						$where=' deletestatus=0 and status=1 order by name asc';   
						$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
						$alldest=explode(',',$location);  
						while($resListing=mysqli_fetch_array($rs)){  
						
						?> 
	<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> 
	<?php } ?> 
						</select>
					</label>

				</div>
				<div class="griddiv"><label>

						<div class="gridlable">Website</span></div>

						<input name="ferrywebsite" type="text" class="gridfield" id="ferrywebsite" displayname="Ferry Website" value="<?php echo $ferrywebsite; ?>" maxlength="100" />
					</label>
				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">Self Supplier</div>

						<select id="selfsupplier" type="text" class="gridfield" name="selfsupplier" displayname="Self Supplier" autocomplete="off" value="<?php echo $selfSupplier; ?>" style="width: 100%;">

							<option value="1" <?php if($selfSupplier == '1' || $selfSupplier == '') { ?> selected="selected" <?php } ?>>Yes</option>

							<option value="0" <?php if($selfSupplier == '0') { ?> selected="selected" <?php } ?>>No</option>



						</select>
					</label>



				</div>

				<div class="griddiv"><label>

						<table width="100%" border="0" cellspacing="2" cellpadding="0">

							<tr>
							<div class="">Contact Person Information</div>
								<td width="70">
								
									<div class="griddiv">
										
										<label>

											<select id="division" name="division" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division" style="margin-top: 2px;">

												<option value="">Select Division</option>
												<?php  
												$selectd='*';    
												$whered=' deletestatus=0 and status=1 order by name asc';  
												$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
												while($resListingd=mysqli_fetch_array($rsd)){  
												?>
												<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($division == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
												<?php } ?> 

											</select>
										</label>

									</div>
								</td>

								<td width="70">
									<div class="griddiv"><label>

											<input name="contactperson" type="text" class="gridfield validate" id="contactperson" value="<?php echo $contactperson; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="70">
									<div class="griddiv"><label>

											<input name="designation" type="text" class="gridfield" id="designation" value="<?php echo $designation; ?>" displayname="Designation" placeholder="Designation" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="40">
									<div class="griddiv"><label>
											<input name="countryCode1" type="text" class="gridfield validate" id="countryCode1" value="+91" displayname="Country Code" placeholder="+91" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="80">
									<div class="griddiv"><label>

											<input name="phone" type="text" class="gridfield validate" id="phone" value="<?php echo $phone; ?>" displayname="Phone" placeholder="Phone" style="margin-top: 4px;">

										</label>

									</div>
								</td>

								<td width="120">
									<div class="griddiv"><label>

											<input name="email" type="email" class="gridfield validate" id="email" value="<?php echo $email; ?>" displayname="Email" placeholder="Email" style="margin-top: 4px;" required />

										</label>

									</div>
								</td>

							</tr>

						</table>
					</label>
				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>
						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($editresult['status'] == '1'|| $editresult['status'] == '') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($editresult['status'] == '0' ) { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_ferryCompanymaster" />

			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Save " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>
			</table>

		</div>

	</div>

	<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	
	<script>
			$(document).ready(function() {

				$('.js-example-basic-multiple').select2();

			});
		</script>

		<style>
			.select2-container {

				width: 100% !important;
			}



			#alertnotificationsmainbox .select2-container .select2-search--inline {

				display: block;

				width: 100% !important;

			}



			.select2-container--open {

				z-index: 9999999
			}

			.select2-container .select2-selection--single {

				height: 35px;

			}

			.addeditpagebox .griddiv .gridlable {

				display: block;

			}

			.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

				width: 100% !important;

			}

			#alertnotificationsmainbox .select2-search__field {

				padding: 6px !important;

				width: 100% !important;

				border: 1px solid #ccc;
			}
		</style>


<?php }

// ================= Ferry Company Master End and Ferry Class Master Start ===================

if ($_GET['action'] == 'addedit_ferryClassmaster' && $_GET['sectiontype'] == 'ferryClassmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'ferryClassMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$status = clean($editresult['status']);
	}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Ferry Seat </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			<?php if($_GET['id'] == ''){ ?>
				<div class="griddiv"><label>

						<div class="gridlable">Ferry Seat<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Ferry Seat" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>
				<?php }else{ 
					?>
					<div class="griddiv" style="display: none;"><label>

					<div class="gridlable">Ferry Seat<span class="redmind"></span></div>

					<input name="name" type="text" class="gridfield" id="name" displayname="Ferry Seat" value="<?php echo $name; ?>" maxlength="100" />

				</label>

			</div>
			<?php
					}
					?>
				<div class="griddiv"><label>

						<div class="gridlable">Status<span class="redmind"></span></div>
							<select name="ferryStatus" id="ferryStatus" class="gridfield" displayname="Ferry Status">
								<option value="1" <?php if($status== '1' || $status == ''){ ?> selected="selected" <?php  } ?>>Active</option>

								<option value="0" <?php if($status== '0' ){ ?> selected="selected" <?php  } ?>>Inactive</option>
							</select>

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_ferryClassmaster" />

			</form>
		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>
<?php }

// ======================== Ferry Class Master End and Ferry Price Master ========================

if ($_GET['action'] == 'addedit_ferryPricemaster' && $_GET['sectiontype'] == 'ferryPricemaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id='.$id.'';

		$rs1 = GetPageRecord($select1, 'ferryPriceMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
		$ferryCompany = clean($editresult['ferryCompany']);
		$ferryName = clean($editresult['name']);
		$destinationId = clean($editresult['destinationId']);
		$todestinationId = clean($editresult['todestinationId']);
		$ferryClass = clean($editresult['ferryClass']);
		$duration = clean($editresult['duration']);
		$ferryimage = clean($editresult['image']);
		$information = clean($editresult['information']);
		$status = clean($editresult['status']);
	
	}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<style>
	.faplus {
		color: #006699;
		font-size: 20px;
	}
	.buttonicon {
		border: none;
		cursor: pointer;
	}
	.faredi{
		color: #d70606;
    font-size: 18px;
	}
</style>
<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	<div class="contentclass">
		<h1 style="text-align:left;">
		<?php if ($_REQUEST['id'] != '') { echo 'Edit';
										} else {
											echo 'Add';
										} ?> Ferry Transfer Name </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

	<table width="100%" border="0" cellspacing="0" cellpadding="5">

		<tr>
			<td width="50%" colspan="2">
					<div class="griddiv"><label>

							<div class="gridlable">Ferry&nbsp;Transfer&nbsp;Name<span class="redmind"></span></div>
							
								<input type="text" name="ferryName" id="ferryName" value="<?php echo clean($editresult['name']) ?>" displayname="Ferry Transfer Name" class="gridfield validate" displayname="Ferry Transfer Name" >

						</label>

					</div>
				</td>
			

				<td colspan="1" width="25%">
					<div class="griddiv"><label>

							<div class="gridlable" style="display: inline-block;margin-top: 4px;width: 100px;">From Destination<span class="redmind"></span></div>

							<select name="destinationId[]" multiple="multiple" class="gridfield js-example-basic-multiple validate" id="destinationId" value displayname="From Destination" autocomplete="off" style=" width:160px;">

								<option value="all">All</option>

								<?php

								$select = '';

								$where = '';

								$restult = '';

								$select = '*';

								$where = ' deletestatus=0 and status=1 order by name asc';

								$restult = GetPageRecord($select, _DESTINATION_MASTER_, $where);

								while ($resListing = mysqli_fetch_array($restult)) {

									$destId = explode(',', $destinationId);
								?>

									<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($destId as $val) { if ($val == strip($resListing['id'])) { ?> selected="selected" <?php }} ?>><?php echo strip($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>
				</td>

			<!-- to destination  -->
			<td colspan="1" width="25%">
				<div class="griddiv"><label>

						<div class="gridlable" style="display: inline-block;margin-top: 4px;width: 100px;">To Destination<span class="redmind"></span></div>

						<select name="todestinationId[]" multiple="multiple" class="gridfield js-example-basic-multiple validate" id="todestinationId" value displayname="To Destination" autocomplete="off" style=" width:160px;">

							<option value="all">All</option>

							<?php

							$select = '';

							$where = '';

							$restult = '';

							$select = '*';

							$where = ' deletestatus=0 and status=1 order by name asc';

							$restult = GetPageRecord($select, _DESTINATION_MASTER_, $where);

							while ($resListing = mysqli_fetch_array($restult)) {

								$destId = explode(',', $todestinationId);
							?>

								<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($destId as $val) { if ($val == strip($resListing['id'])) { ?> selected="selected" <?php }} ?>><?php echo strip($resListing['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>
			</td>
		</tr>

		<tr>
		<!-- ferry time -->
		<table style="width: 50%; display:inline-block;"><tr>
		<div id="ferryFields">
			<td colspan="" width="20%">
				<div class="griddiv"><label>

						<div class="gridlable">Arrival&nbsp;Time</span></div>

						<input type="text" id="arrivalTime" name="arrivalTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $startTime;?>"/>

					</label>

				</div>
			</td>

			<td colspan="" width="20%">	
				<div class="griddiv"><label>
				<div class="gridlable">Departure&nbsp;Time</span></div>
				<input type="text" id="departureTime" name="departureTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $endTime;?>"/>

					</label>

				</div>
			</td>
			
			<td width="5%" align="left" valign="middle">
			<button id="addMoreFields" class="buttonicon"><i class="fa-solid fa-plus faplus"></i></button>
			</td>
			</div>
			
			</tr></table>
			<?php 
			$ferryTimeCount= 1;
			if($_GET['id']!=''){
			$where2 = 'ferrypriceId="'.$_GET['id'].'" && ferrypriceId!="" and pickupTime!="" and dropTime!=""';

			$rs2 = GetPageRecord('*', 'ferryServiceTiming', $where2);
			while($editresult2 = mysqli_fetch_assoc($rs2)){
				// echo $editresult2['id'];
			?>

			<table style="width: 50%; display:inline-block;"><tr>
		<div id="ferryFields">
		<input type="hidden" name="ferrytimeId<?php echo $ferryTimeCount; ?>" id="hiddenId<?php echo $ferryTimeCount; ?>" value="<?php echo $editresult2['id']; ?>">
			<td width="20%">
				<div class="griddiv"><label>

						<div class="gridlable">Arrival&nbsp;Time</span></div>
						<input type="text" name="pickupTime<?php echo $ferryTimeCount; ?>" id="pickupTime<?php echo $ferryTimeCount; ?>" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo clean($editresult2['pickupTime']); ?>"/>
					</label>

				</div>
			</td>

			<td width="20%">	
				<div class="griddiv"><label>

						<div class="gridlable">Departure&nbsp;Time</span></div>
						<input type="text" name="dropTime<?php echo $ferryTimeCount; ?>" id="dropTime<?php echo $ferryTimeCount; ?>" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo clean($editresult2['dropTime']); ?>"/>

					</label>

				</div>
			</td>
			
			<td width="10%" align="center" valign="middle">

			<!-- <button id="removeFields" class="buttonicon "><i class="fa-solid fa-trash faredi"></i></button> -->
			</td>
			</div>
			
			</tr></table>
			<?php
			$ferryTimeCount++;
			}

				} ?>

<input name="ferryTimeCount" type="hidden" id="ferryTimeCount" value="<?php if ($ferryTimeCount == 1) { echo '1'; } else { echo $ferryTimeCount; } ?>" />

			<td colspan="2" >
			<div class="griddiv" style="display: inline-block; width:48%;"><label>

				<div class="gridlable">Status</div>
					<select name="status" id="status" class="gridfield">
						<option value="1" <?php if($editresult['status']=='1' || $editresult['status']==''){ ?> selected="selected" <?php } ?> >Active</option>
						<option value="0" <?php if($editresult['status']=='0'){ ?> selected="selected" <?php } ?>>Inactive</option>
					</select>
				</label>

				</div>
			</td>

		</tr>
		<div id="multipleferryTimes"></div>
		<tr>

			<td colspan="4" width="100%">
				<div class="griddiv"><label>

						<div class="gridlable">Detail</div>

						<textarea name="ferryInformation" rows="5" class="gridfield" id="ferryInformation"><?php echo strip($editresult['information']); ?></textarea>

					</label>

				</div>
			</td>
			
		</tr>
		
	</table>
	


				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="editName" type="hidden" id="editName" value="<?php echo $_GET['name']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_ferryPricemaster" />

			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Save " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>
			</table>

		</div>
	</div>
	
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>   
	<script type="text/javascript"> 
	$(document).ready(function(){
				 	$('.timepicker2').timepicker();	
					
				}); 
			
				
		
	$(document).ready(function(){
		$("#addMoreFields").click(function(e){
			e.preventDefault();
			$("#multipleferryTimes").append(`<table style="width: 50%;"><tr><div id="ferryFields">
			<td colspan="" width="20%">
				<div class="griddiv"><label>
					<div class="gridlable">Arrival&nbsp;Time</span></div>
						<input type="text" id="arrivalTime" name="arrivalTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value=""/>
					</label>
				</div>
			</td>

			<td colspan="" width="20%">
				<div class="griddiv"><label>
						<div class="gridlable">Departure&nbsp;Time</span></div>
						<input type="text" id="departureTime" name="departureTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value=""/>
					</label>

				</div>
			</td>
			<td width="10%" align="center" valign="middle">
			<button id="removeFields" class="buttonicon "><i class="fa-solid fa-trash faredi"></i></button>
			</td>
			</div><tr></table>`);

			$('.timepicker2').timepicker();	
		});

		$(document).on('click','#removeFields', function(e) {
			e.preventDefault();
			let removefields = $(this).parent().parent();
			$(removefields).remove();
		});

		
	});


	
			$(document).ready(function() {

				$('.js-example-basic-multiple').select2();

			});
		</script>

		<style>
			.select2-container {

				width: 100% !important;
			}



			#alertnotificationsmainbox .select2-container .select2-search--inline {

				display: block;

				width: 100% !important;

			}



			.select2-container--open {

				z-index: 9999999
			}

			.select2-container .select2-selection--single {

				height: 35px;

			}

			.addeditpagebox .griddiv .gridlable {

				display: block;

			}

			.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

				width: 100% !important;

			}

			#alertnotificationsmainbox .select2-search__field {

				padding: 6px !important;

				width: 100% !important;

				border: 1px solid #ccc;
			}
		</style>


<?php }
// ========================= Ferry Price Master End and Ferry Name Master start==========================
if ($_GET['action'] == 'addedit_ferryMaster' && $_GET['sectiontype'] == 'ferryMaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'ferryNameMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$ferryImage=$editresult['image'];
		$ferryCompanyName = clean($editresult['ferryCompanyId']);
		$capacity = clean($editresult['capacity']);

		$status = clean($editresult['status']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') { echo 'Edit'; } else { echo 'Add'; } ?> Ferry Name </h1> 
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">  
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			<div class="griddiv"><label> 
				<div class="gridlable">Ferry&nbsp;Company<span class="redmind"></span></div> 
				<select name="ferrycompany" id="ferrycompany" class="gridfield validate" displayname="Ferry&nbsp;Company">
				<option value="">Select Ferry  Company</option>
				<?php  
				$getfercomp = GetPageRecord('*','ferryCompanyMaster',' deletestatus=0 and status=1 ');
				while($ferrycompname = mysqli_fetch_assoc($getfercomp)){
					?>
					<option value="<?php echo $ferrycompname['id'] ?>" <?php if($ferryCompanyName == $ferrycompname['id']){ ?> selected="selected" <?php } ?> ><?php echo $ferrycompname['name']; ?></option>
					<?php
				} 
				?> 
				</select> 
				</label> 
			</div>
				<div class="griddiv"><label>

						<div class="gridlable">Ferry&nbsp;Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Ferry&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Capacity</span></div>

						<input name="capacity" type="text" class="gridfield" id="capacity" displayname="Ferry&nbsp;Capacity" value="<?php echo $capacity; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

		<div class="griddiv">
			<label>
				<div style="display: grid;"><?php if($_REQUEST['id']==''){  }else{ ?> <img align="left" style="display: inline-block;" src="packageimages/<?php echo $ferryImage; ?>" alt="" width="85px" height="70px">  <?php } ?></div>
				<div class="gridlable">Ferry Image<span class="redmind"></span></div>
				<input name="ferryImage" type="file" class="gridfield" id="ferryImage" value="<?php echo $amenityImage; ?>" displayname="Upload Ferry Image"/>
		
				<input type="hidden" name="oldferryImage" id="oldferryImage" value="<?php if($ferryImage!=''){echo $ferryImage;} ?>" />
		
			</label>
		
		</div>



				<input name="editId" type="hidden" id="editId" value="<?php echo clean($editresult['id']); ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_ferryMaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>
<?php }
// ============== Ferry Name Master End ==================
if ($_GET['action'] == 'addedit_cabintypemaster' && $_GET['sectiontype'] == 'cabintypemaster') {

	if ($_GET['id']!= '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1,_CABIN_TYPE_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
		$status = clean($editresult['status']);
		$cruiseNameId = clean($editresult['cruiseNameId']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Cabin Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			<div class="griddiv"><label>

			<div class="gridlable">Cruise Name<span class="redmind"></span></div>
			<select name="cruiseNameId" type="text" class="gridfield validate" id="cruiseNameId" displayname="Cruise Name">
				
			<option value="">Select Cruise Name</option>
			<?php 
				$crs = GetPageRecord('*','cruiseNameMaster','status=1 and deletestatus=0');
				while($cNameData = mysqli_fetch_assoc($crs)){
			?>
			<option value="<?php echo $cNameData['id']; ?>" <?php if($cNameData['id']==$cruiseNameId){ echo 'selected="selected" '; } ?> ><?php echo $cNameData['name']; ?></option>

			<?php } ?>

			</select>
		

			</label>

			</div>

				<div class="griddiv"><label>

						<div class="gridlable">Cabin Type<span class="redmind"></span></div>

						<input name="cabinType" type="text" class="gridfield validate" id="cabinType" displayname="Cabin Type" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv">

				<label>

					<div class="gridlable">status</div>

					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

						<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

						<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

					</select>
				</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_cabintypemaster" />

			</form>
		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php }



if ($_GET['action'] == 'addedit_cabincategorymaster' && $_GET['sectiontype'] == 'cabincategorymaster') {
	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id="'.$id.'"';
		$rs1 = GetPageRecord($select1, _CABIN_CATEGORY_, $where1);
		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']);
		$status = clean($editresult['status']);
	}
	?>
	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Cabin Category </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv"><label>
						<div class="gridlable">Name<span class="redmind"></span></div>
						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv">
				<label>
					<div class="gridlable">status</div>
					<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">
						<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>
						<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>
					</select>
				</label>
				</div>
				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_cabincategorymaster" />
			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
				</tr>
			</table>
		</div>
	</div>
	<?php 
}



// ======================== Cruise Price Master Start ========================


if ($_GET['action']=='addedit_cruisemaster' && $_GET['sectiontype']=='cruisemaster'){

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1,_CRUISE_MASTER_,$where1);

		$editresult = mysqli_fetch_array($rs1);
	
		$cruiseName = clean($editresult['cruiseName']);
		$destinationId = clean($editresult['destination']);
		$finalweekendDays = explode(',',$editresult['runningDays']);
		if($editresult['departureDate']==NULL || $editresult['departureDate']=="1970-01-01"){
			$departureDate = '';
		}else{
			$departureDate = date('d-m-Y',strtotime($editresult['departureDate']));
		}
		if($editresult['toDate']==NULL || $editresult['toDate']=="1970-01-01"){
			$toDate = '';
		}else{
			$toDate = date('d-m-Y',strtotime($editresult['toDate']));
		}
		
		$duration = clean($editresult['duration']);
		$status = clean($editresult['status']);
	
	}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<style>
	.faplus {
		color: #006699;
		font-size: 20px;
	}
	.buttonicon {
		border: none;
		cursor: pointer;
	}
	.faredi{
		color: #d70606;
    font-size: 18px;
	}
</style>
<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
	<div class="contentclass">
		<h1 style="text-align:left;">
		<?php if ($_REQUEST['id'] != '') { echo 'Edit'; }else{ echo 'Add'; } ?> Cruise Package Name </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

	<table width="100%" border="0" cellspacing="0" cellpadding="5">

		<tr>
		<td width="50%" colspan="2">
				<div class="griddiv"><label>

						<div class="gridlable">Cruise&nbsp;Package&nbsp;Name<span class="redmind"></span></div>
						
							<input type="text" name="cruiseName" id="cruiseName" value="<?php echo $cruiseName; ?>" displayname="Cruise Package Name" class="gridfield validate" >

					</label>

				</div>
			</td>
		

			<td colspan="2" width="50%">
				<div class="griddiv"><label>

				<div class="gridlable" >Destination<span class="redmind"></span></div>

										<select name="destinationId" class="gridfield validate" id="destinationId" value displayname="Destination" autocomplete="off" >

											<option value="">Select Destination</option>

											<?php

											$select = '';

											$where = '';

											$restult = '';

											$select = '*';

											$where = ' deletestatus=0 and status=1 order by name asc';

											$restult = GetPageRecord($select, _DESTINATION_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($restult)) {

												// $destId = explode(',', $destinationId);
											?>

												<option value="<?php echo strip($resListing['id']); ?>" <?php if ($destinationId == strip($resListing['id'])) { ?> selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

											<?php } ?>

										</select>

									</label>

								</div>
							</td>
		</tr>
		
							<tr style="display:none;">
							
							<td colspan="3">
							<div class="griddiv"><label> 
									<div class="gridlable">Running&nbsp;Days</div> 
									<select name="weekdaysname[]" size="1" multiple="multiple" class="gridfield select2" id="weekdaysname" displayname="Week Name" autocomplete="off"> 
										<?php 
										$rs = GetPageRecord('*', 'weekendDaysMaster', ' deleteStatus=0 order by sr asc'); 
										while ($resListing = mysqli_fetch_array($rs)) {  ?> 
											<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($finalweekendDays as $key => $value) { if ($value == $resListing['name']) { echo 'selected="selected"'; } } ?>><?php echo strip($resListing['name']); ?></option> 
										<?php } ?> 
									</select> 
								</label> 
							</div> 
							<script src="plugins/select2/select2.full.min.js"></script>

							<script>
								$(document).ready(function() {

									$('.select2').select2();

								});
							</script>

							<style>
								.select2-container--open {

									z-index: 9999999999 !important;

									width: 100%;

								}
								.select2-container {

									box-sizing: border-box;

									display: inline-block;

									margin: 0;

									position: relative;

									vertical-align: middle;

									width: 100% !important;

								}
							</style>
						</td></tr>

		<tr>
		<table width="100%" cellpadding="5" cellspacing="0">
		<tr>
		<td width="24%">
				<div class="griddiv"><label>

						<div class="gridlable" style="width:100%;">Departure Date<span class="redmind"></span></div>
						
							<input type="text" name="departureDateC" id="departureDateC" value="<?php echo $departureDate; ?>" displayname="Cruise Departure Date" class="gridfield validate calfieldicon" >

					</label>

				</div>
			</td>
			
			<td width="24%">
				<div class="griddiv"><label>

						<div class="gridlable">To Date<span class="redmind"></span></div>
						
							<input type="text" name="reachDateC" id="reachDateC" value="<?php echo $toDate; ?>" displayname="Cruise To Date" class="gridfield validate calfieldicon" >

					</label>

				</div>
			</td>
		

			<td width="24%">
				<div class="griddiv">
					<label>

						<div class="gridlable" style="display: inline-block;margin-top: 4px;">Duration<span class="redmind"></span></div>

						<input type="text" name="cruiseDuration" id="cruiseDuration" value="<?php echo $duration; ?>" displayname="Duration" class="gridfield validate" >

					</label>

				</div>
			</td>
			<td width="24%">
			<div class="griddiv" ><label>

				<div class="gridlable">Status</div>
					<select name="status" id="status" class="gridfield">
						<option value="1" <?php if($editresult['status']=='1' || $editresult['status']==''){ ?> selected="selected" <?php } ?> >Active</option>
						<option value="0" <?php if($editresult['status']=='0'){ ?> selected="selected" <?php } ?>>Inactive</option>
					</select>
				</label>

				</div>
			</td>
		</tr>
		</table>
		<!-- ferry time -->
		<table style="width: 50%; display:inline-block;display:none;"><tr>
		<div id="ferryFields">
			<td colspan="" width="20%">
				<div class="griddiv"><label>

						<div class="gridlable">Arrival&nbsp;Time</span></div>

						<input type="text" id="arrivalTime" name="arrivalTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $startTime;?>"/>

					</label>

				</div>
			</td>

			<td colspan="" width="20%">	
				<div class="griddiv"><label>
				<div class="gridlable">Departure&nbsp;Time</span></div>
				<input type="text" id="departureTime" name="departureTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo $endTime;?>"/>

					</label>

				</div>
			</td>
			
			<td width="5%" align="left" valign="middle">
			<button id="addCruiseMoreFields" class="buttonicon"><i class="fa-solid fa-plus faplus"></i></button>
			</td>
			</div>
			
			</tr></table>
			<?php 
			// $cruiseTimeCount= 1;
			// if($_GET['id']!=''){
			// $where2 = 'cruiseMasterId="'.$_GET['id'].'" && cruiseMasterId!="" and arrivalTime!="" and departureTime!=""';

			// $rs2 = GetPageRecord('*', 'cruiseServiceTiming', $where2);
			// while($editresult2 = mysqli_fetch_assoc($rs2)){
				// echo $editresult2['id'];
			?>

			<!-- <table style="width: 50%; display:inline-block;"><tr>
		<div id="cruiseFields">
		<input type="hidden" name="cruisetimeId<?php echo $cruiseTimeCount; ?>" id="hiddenId<?php echo $cruiseTimeCount; ?>" value="<?php echo $editresult2['id']; ?>">
			<td width="20%">
				<div class="griddiv"><label>

						<div class="gridlable">Arrival&nbsp;Time</span></div>
						<input type="text" name="pickupTime<?php echo $cruiseTimeCount; ?>" id="pickupTime<?php echo $cruiseTimeCount; ?>" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo clean($editresult2['arrivalTime']); ?>"/>
					</label>

				</div>
			</td>

			<td width="20%">	
				<div class="griddiv"><label>

						<div class="gridlable">Departure&nbsp;Time</span></div>
						<input type="text" name="dropTime<?php echo $cruiseTimeCount; ?>" id="dropTime<?php echo $cruiseTimeCount; ?>" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value="<?php echo clean($editresult2['departureTime']); ?>"/>

					</label>

				</div>
			</td>
			
			<td width="10%" align="center" valign="middle">

			<button id="removeFields" class="buttonicon "><i class="fa-solid fa-trash faredi"></i></button>
			</td>
			</div>
			
			</tr></table> -->
			<?php
			// $cruiseTimeCount++;
			// }

			// 	}
				 ?>

		<input name="cruiseTimeCount" type="hidden" id="cruiseTimeCount" value="<?php if ($cruiseTimeCount == 1) { echo '1'; } else { echo $cruiseTimeCount; } ?>" />

			

		<!-- </tr> -->
		<div id="multipleCruiseTimes"></div>
		<tr>

			<td colspan="4" width="100%">
				<div class="griddiv"><label>

						<div class="gridlable">Detail</div>

						<textarea name="cruiseInformation" rows="5" class="gridfield" id="cruiseInformation"><?php echo strip($editresult['otherDetail']); ?></textarea>

					</label>

				</div>
			</td>
			
		</tr>
		
	</table>
	


			<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

			<input name="action" type="hidden" id="action" value="addedit_cruisemaster" />

			<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
			<input name="editName" type="hidden" id="editName" value="<?php echo $_GET['name']; ?>" />

			</form>
		</div>
		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Save " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>
			</table>

		</div>
	</div>
	
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>   
	<script type="text/javascript"> 
	$(document).ready(function(){
				 	$('.timepicker2').timepicker();	

					 $("#reachDateC").Zebra_DatePicker({
						format: 'd-m-Y',
						onSelect: function (date) {
							var temptddate = date.split("-").reverse().join("-");
							var todate = new Date(temptddate).getTime();
							var fd = $('#departureDateC').val();
							var tempfddate = fd.split("-").reverse().join("-");
							var fromdate = new Date(tempfddate).getTime();
							var nightscount = Math.round((todate-fromdate)/(1000*60*60*24));
							$('#cruiseDuration').val(nightscount);
						}
						
					});

					$("#departureDateC").Zebra_DatePicker({
						format: 'd-m-Y',
						pair: $('#reachDateC')
					});
					
				
					
				}); 
			
				
		
	$(document).ready(function(){
		$("#addCruiseMoreFields").click(function(e){
			e.preventDefault();
			$("#multipleCruiseTimes").append(`<table style="width: 50%;"><tr><div id="cruiseFields">
			<td colspan="" width="20%">
				<div class="griddiv"><label>

						<div class="gridlable">Arrival&nbsp;Time</span></div>
						<input type="text" id="arrivalTime" name="arrivalTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value=""/>

					</label>

				</div>
			</td>

			<td colspan="" width="20%">
				<div class="griddiv"><label>

						<div class="gridlable">Departure&nbsp;Time</span></div>
						<input type="text" id="departureTime" name="departureTime[]" style="text-align:left;width:90%;padding: 4px;border: 1px solid #ccc;border-radius: 2px;" class="gridfield timepicker2" data-time-format="H:i" placeholder="00:00" data-step="5" data-min-time="12:00" data-max-time="11:59"  data-show-2400="true" value=""/>
					</label>

				</div>
			</td>
			<td width="10%" align="center" valign="middle">
			<button id="removeFields" class="buttonicon "><i class="fa-solid fa-trash faredi"></i></button>
			</td>
			</div><tr></table>`);

			$('.timepicker2').timepicker();	
		});

		$(document).on('click','#removeFields', function(e) {
			e.preventDefault();
			let removefields = $(this).parent().parent();
			$(removefields).remove();
		});

		
	});


	
			$(document).ready(function() {

				$('.js-example-basic-multiple').select2();

			});
		</script>

		<style>
			.select2-container {

				width: 100% !important;
			}



			#alertnotificationsmainbox .select2-container .select2-search--inline {

				display: block;

				width: 100% !important;

			}



			.select2-container--open {

				z-index: 9999999
			}

			.select2-container .select2-selection--single {

				height: 35px;

			}

			.addeditpagebox .griddiv .gridlable {

				display: block;

			}

			.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

				width: 100% !important;

			}

			#alertnotificationsmainbox .select2-search__field {

				padding: 6px !important;

				width: 100% !important;

				border: 1px solid #ccc;
			}
		</style>


<?php }
// ========================= Cruise Price Master End ==========================



if ($_GET['action'] == 'addeditpackageCruisesupplier_cruisemaster') {

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Cruise Suppliers </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Supplier Name<span class="redmind"></span></div>

						<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Sightseeing Suppliers" autocomplete="off">

							<option value="">Select</option>

							<?php

							if ($_GET['cruiseid'] != '') {

								$cruiseid = clean($_GET['cruiseid']);
							}

							$no = 1;

							$select = '*';

							$where = '';

							$rs = '';

							$wheresearch = '';

							$limit = clean($_GET['records']);

							$mainwhere = '';

							$assignto = '';

							if ($_GET['assignto'] != '') {

								$assignto = ' and	assignTo=' . $_GET['assignto'] . '';
							}



							if ($loginuserprofileId == 1) {

								$wheresearch = ' 1 ' . $mainwhere . '';
							} else {

								$wheresearch = ' 1 ' . $mainwhere . '';

								//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 

							}



							$where = 'where ' . $wheresearch . ' and name!="" ' . $assignto . ' and cruiseType=12 and deletestatus=0 order by dateAdded desc';

							$page = $_GET['page'];



							$targetpage = $fullurl . 'showpage.crm?module=suppliers&records=' . $limit . '&searchField=' . $searchField . '&assignto=' . $_GET['assignto'] . '&suppliertype=' . $_GET['suppliertype'] . '&';

							$rs = GetRecordList($select, _SUPPLIERS_MASTER_, $where, $limit, $page, $targetpage);

							$totalentry = $rs[1];

							$paging = $rs[2];

							while ($resultlists = mysqli_fetch_array($rs[0])) {

								$supplr_id = $resultlists['id'];

								/*$sql5="select * from ad_courses ";

$res5 = mysqli_query (db(),$sql5);

$countRoom = $num5=mysqli_num_rows($res5); */

							?>

								<option value="<?php echo strip($resultlists['id']); ?>"><?php echo strip($resultlists['name']); ?></option>

							<?php } ?>

						</select>

					</label>

				</div>



				<input name="cruiseid" type="hidden" id="cruiseid" value="<?php echo $cruiseid; ?>" />

				<input name="action" type="hidden" id="action" value="addeditpackageCruisesupplier_cruisemaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }


if ($_GET['action'] == 'addCruiseSupplierRate') {



	$cruiseid = decode($_REQUEST['cruiseid']);

	$supplierId = decode($_REQUEST['supplierId']);

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = ' cruiseid="' . $cruiseid . '" and supplierId="' . $supplierId . '" order by id asc';

	$rs = GetPageRecord($select, _PACKAGE_CRUISE_RATE_, $where);

	$count = mysqli_num_rows($rs);

	$editresult = mysqli_fetch_array($rs);

?>

	<style>
		.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

			width: 100% !important;

		}
	</style>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($count > 0) {
											echo 'Edit Price';
										} else {
											echo 'Add Price';
										} ?> Cruise Suppliers </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv">

					<label>

						<div class="gridlable">From Date<span class="redmind"></span></div>

						<input name="fromDate" type="text" class="gridfield validate" id="fromDate" displayname="From Date" value="<?php if ($editresult['fromDate'] != '01-01-1970' && $editresult['fromDate'] != '' && $editresult['fromDate'] != '0') {
																																		echo date('d-m-Y', strtotime($editresult['fromDate']));
																																	} ?>" />

					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">To Date<span class="redmind"></span></div>

						<input name="toDate" type="text" class="gridfield validate" id="toDate" displayname="To Date" value="<?php if ($editresult['toDate'] != '01-01-1970' && $editresult['toDate'] != '' && $editresult['toDate'] != '0') {
																																	echo date('d-m-Y', strtotime($editresult['toDate']));
																																} ?>" />

					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">Price<span class="redmind"></span></div>

						<input name="price" type="text" class="gridfield validate" id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />

					</label>

				</div>



				<input name="cruiseid" type="hidden" id="cruiseid" value="<?php echo $cruiseid; ?>" />

				<input name="supplierId" type="hidden" id="supplierId" value="<?php echo $supplierId; ?>" />

				<input name="action" type="hidden" id="action" value="addCruiseSupplierRate" />

			</form>

			<script>
				$(document).ready(function() {

					$('#toDate').Zebra_DatePicker({

						format: 'd-m-Y',

					});

					$('#fromDate').Zebra_DatePicker({

						format: 'd-m-Y',

					});

				});
			</script>

		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php }



/*if($_GET['action']=='cms_gallery' ){ 

	

 $cruiseid = decode($_REQUEST['cruiseid']);

 $supplierId = decode($_REQUEST['supplierId']);

$select='';

$where='';

$rs='';  

$select='*'; 

$where=' cruiseid="'.$cruiseid.'" and supplierId="'.$supplierId.'" order by id asc'; 

$rs=GetPageRecord($select,_PACKAGE_CRUISE_RATE_,$where); 

 $count = mysqli_num_rows($rs);



$editresult=mysqli_fetch_array($rs);

?>

<style>

.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

    width: 100% !important;

}

</style>

<div class="contentclass">

<h1 style="text-align:left;"><?php if($count > 0){ echo 'Edit Price'; }else{ echo 'Add Price'; } ?> Cruise Suppliers </h1>

  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >

<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

	<div class="griddiv">

		<label>

		<div class="gridlable">From Date<span class="redmind"></span></div>

		<input name="fromDate" type="text" class="gridfield validate" id="fromDate" displayname="From Date" value="<?php if($editresult['fromDate']!='01-01-1970' && $editresult['fromDate']!='' && $editresult['fromDate']!='0'){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } ?>" />

		</label>

	</div>

	<div class="griddiv">

		<label>

		<div class="gridlable">To Date<span class="redmind"></span></div>

		<input name="toDate" type="text" class="gridfield validate" id="toDate" displayname="To Date" value="<?php if($editresult['toDate']!='01-01-1970' && $editresult['toDate']!='' && $editresult['toDate']!='0'){ echo date('d-m-Y',strtotime($editresult['toDate'])); } ?>" />

		</label>

	</div>

	<div class="griddiv">

		<label>

		<div class="gridlable">Price<span class="redmind"></span></div>

		<input name="price" type="text" class="gridfield validate" id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />

		</label>

	</div>

	

 <input name="cruiseid" type="hidden" id="cruiseid" value="<?php echo $cruiseid; ?>" />

 <input name="supplierId" type="hidden" id="supplierId" value="<?php echo $supplierId; ?>" />

 <input name="action" type="hidden" id="action" value="addCruiseSupplierRate" />

</form>

<script>

 $(document).ready(function() {   

$('#toDate').Zebra_DatePicker({ 

  format: 'd-m-Y',  

}); 

$('#fromDate').Zebra_DatePicker({

  format: 'd-m-Y',  

}); 

  });

</script>

  </div>

  <div id="buttonsbox"  style="text-align:center;">

 <table border="0" align="right" cellpadding="0" cellspacing="0">

      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

      </tr>

   </table>

</div></div>

	<?php }*/



if ($_GET['action'] == 'addedit_cms' && $_GET['page'] == 'gallery') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _POST_LIST_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$title = clean($editresult['title']);

		$feature_img = clean($editresult['feature_img']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Photo Gallery </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv"><label>
						<div class="gridlable">Gallery Title<span class="redmind"></span></div>
						<input name="title" type="text" class="gridfield validate" id="title" displayname="Gallery Title" value="<?php echo $title; ?>" maxlength="100" />
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Destination as(Tags)<span class="redmind"></span></div>
						<select id="destination" name="destination[]" class="gridfield" data-placeholder="Select Gallery Tags" multiple>
							<option value="">--Choose Option--</option>
							<?php
							$tagsQuery = mysqli_query(db(), "select * from " . _DESTINATION_MASTER_ . " where status='1' order by name asc");
							while ($tagsData = mysqli_fetch_array($tagsQuery)) {
								$isSelected_destination = array_map('trim', explode(",", $editresult['subcategory']));
							?>
								<option value="<?php echo $tagsData['id']; ?>" <?php if (in_array($tagsData['id'], $isSelected_destination)) { ?> selected="selected" <?php } ?>>
									<?php echo $tagsData['name']; ?></option>
							<?php } ?>
						</select>
					</label>
				</div>
				<div class="griddiv"><label>
						<div class="gridlable">Package Theme<span class="redmind"></span></div>
						<select id="package_theme" name="package_theme[]" class="gridfield" data-placeholder="Select Gallery Tags" multiple>
							<option value="0">Select Themes</option>
							<?php
							$package_themeSql = mysqli_query(db(), "select * from " . _PACKAGE_THEME_MASTER_ . " where status='1' order by name asc");
							while ($package_themeData = mysqli_fetch_array($package_themeSql)) {
								$isSelected_theme = array_map('trim', explode(",", $editresult['category']));
							?>
								<option value="<?php echo $package_themeData['id']; ?>" <?php if (in_array($package_themeData['id'], $isSelected_theme)) { ?> selected="selected" <?php } ?>>
									<?php echo $package_themeData['name']; ?></option>
							<?php } ?>
						</select>

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Gallery Preview Image</div>

						<?php if ($feature_img == '') { ?><input name="file1" type="file" class="gridfield validate" displayname="Image" id="file1" /><?php } else { ?><input name="file1" type="file" class="gridfield" id="file1" /><?php } ?>

						<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>

							<option value="2" <?php if ($editresult['status'] == 2) { ?> selected="selected" <?php } ?>>Inactive</option>

						</select>

					</label>

				</div>



				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />

				<input name="action" type="hidden" id="action" value="cms_add_gallery" />

				<script type="text/javascript">
					$('#destination').select2();

					$('#package_theme').select2();
				</script>

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_cms' && $_GET['page'] == 'add-images') {

	$cid = clean($_GET['cid']);

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _POST_LIST_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$title = clean($editresult['title']);

		$feature_img = clean($editresult['feature_img']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Photo Gallery </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Image Title<span class="redmind"></span></div>

						<input name="title" type="text" class="gridfield validate" id="title" displayname="Gallery Title" value="<?php echo $title; ?>" maxlength="100" />

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Gallery Preview Image</div>

						<?php if ($feature_img == '') { ?><input name="file1" type="file" class="gridfield validate" displayname="Image" id="file1" /><?php } else { ?><input name="file1" type="file" class="gridfield" id="file1" /><?php } ?>

						<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>

							<option value="2" <?php if ($editresult['status'] == 2) { ?> selected="selected" <?php } ?>>Inactive</option>

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

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_cms' && $_GET['page'] == 'blog') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _POST_LIST_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$title = clean($editresult['title']);

		$description = clean($editresult['description']);

		$feature_img = clean($editresult['feature_img']);

		$feature_img2 = clean($editresult['image2']);

		$home_text = clean($editresult['home_text']);

		$designation = clean($editresult['designation']);

		$meta_title = clean($editresult['meta_title']);

		$meta_description = clean($editresult['meta_description']);

		$meta_keyword = clean($editresult['meta_keyword']);

		$post_date = clean($editresult['post_date']);
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

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Blog </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Post Date<span class="redmind"></span></div>

						<input name="post_date" type="text" class="gridfield calfieldicon" id="post_date" value="<?php if ($post_date != "") {
																														echo date("d-m-Y", strtotime($post_date));
																													} else {
																														echo date('d-m-Y'); ?><?php } ?>" maxlength="100" />

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



				<div class="griddiv"><label>

						<div class="gridlable">Title<span class="redmind"></span></div>

						<input name="title" type="text" class="gridfield validate" id="title" displayname="Title" value="<?php echo $title; ?>" maxlength="100" />

					</label>

				</div>





				<div class="griddiv"><label>

						<div class="gridlable">Description<span class="redmind"></span></div>

						<textarea name="description" id="description" style="width:98%;" class="gridfield"><?php echo stripslashes($description); ?></textarea>

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Image</div>

						<input name="file1" type="file" class="gridfield" id="file1" />

						<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Author Name<span class="redmind"></span></div>

						<input name="home_text" type="text" class="gridfield" id="home_text" value="<?php echo $home_text; ?>" maxlength="100" />

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Author Designation<span class="redmind"></span></div>

						<input name="designation" type="text" class="gridfield" id="designation" value="<?php echo $designation; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Author Photo</div>

						<input name="file2" type="file" class="gridfield" id="file2" />

						<input name="feature_img2" type="hidden" class="grybutton" id="feature_img2" value="<?php echo $feature_img2; ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Meta Title<span class="redmind"></span></div>

						<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Meta Description<span class="redmind"></span></div>

						<textarea name="meta_description" id="meta_description" style="width:98%;" class="gridfield"><?php echo stripslashes($meta_description); ?></textarea>

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Meta Keywords<span class="redmind"></span></div>

						<textarea name="meta_keyword" id="meta_keyword" style="width:98%;" class="gridfield"><?php echo stripslashes($meta_keyword); ?></textarea>

					</label>

				</div>



				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>

							<option value="2" <?php if ($editresult['status'] == 2) { ?> selected="selected" <?php } ?>>Inactive</option>

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

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php

}

if ($_GET['action'] == 'addedit_cms' && $_GET['page'] == 'banner') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _POST_LIST_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$title = clean($editresult['title']);

		$description = clean($editresult['description']);

		$feature_img = clean($editresult['feature_img']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Banner </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Banner Title<span class="redmind"></span></div>

						<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Destination Worldwide<span class="redmind"></span></div>

						<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Banner Image</div>

						<input name="file1" type="file" class="gridfield" id="file1" />

						<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>

							<option value="2" <?php if ($editresult['status'] == 2) { ?> selected="selected" <?php } ?>>Inactive</option>

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

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_cms' && $_GET['page'] == 'user-reviews') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _POST_LIST_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$title = clean($editresult['title']);

		$description = clean($editresult['title']);

		$feature_img = clean($editresult['feature_img']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Banner </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Banner Title<span class="redmind"></span></div>

						<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Destination Worldwide<span class="redmind"></span></div>

						<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Banner Image</div>

						<input name="file1" type="file" class="gridfield" id="file1" />

						<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable">Status</div>

						<select id="status" name="status" class="gridfield " autocomplete="off">

							<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>

							<option value="2" <?php if ($editresult['status'] == 2) { ?> selected="selected" <?php } ?>>Inactive</option>

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

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_leaveconfiguration' && $_GET['sectiontype'] == 'leaveconfiguration') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _LEAVE_CONFIGURATION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$leaveSelected = clean($editresult['leaveSelected']);

		$city = clean($editresult['city']);

		$departmentId = clean($editresult['departmentId']);

		$designation = clean($editresult['designation']);

		$paybale = clean($editresult['paybale']);

		$emailNotify = clean($editresult['emailNotify']);

		$type = clean($editresult['type']);

		$maxTime = clean($editresult['maxTime']);

		$minTime = clean($editresult['minTime']);

		$count = clean($editresult['count']);

		$carryForword = clean($editresult['carryForword']);

		$carryUpto = clean($editresult['carryUpto']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Leave Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">Leave Type<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Leave Type" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>





							<div class="griddiv"><label>

									<div class="gridlable">Location<span class="redmind"></span></div>

									<select id="city" name="city" class="gridfield">

										<option value="">Select</option>

										<!--

 <?php

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = 'deletestatus=0 order by name';

	$rs = GetPageRecord($select, _CITY_MASTER_, $where);

	while ($city = mysqli_fetch_array($rs)) {

	?>

<option value="<?php echo strip($city['id']); ?>" <?php if ($city == $city['id']) { ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>

<?php } ?>-->

									</select>
								</label>

							</div>







							<div class="griddiv">

								<label>

									<div class="gridlable">Designation<span class="redmind"></span></div>

									<select id="designation" name="designation" class="gridfield" displayname="Designation" autocomplete="off">

										<option value="">Select Designation</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'id="1" or userId="' . $loginusersuperParentId . '" order by id asc';
										} else {

											$where = 'userId="' . $loginusersuperParentId . '" order by id asc';
										}

										$rs = GetPageRecord($select, _ROLE_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $designation) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Type<span class="redmind"></span></div>

									<select id="type" name="type" class="gridfield " displayname="Type" autocomplete="off">

										<option value="">Select</option>

										<option value="0" <?php if (0 == $type) { ?>selected="selected" <?php } ?>>Monthly</option>

										<option value="1" <?php if (1 == $type) { ?>selected="selected" <?php } ?>>Yearly</option>

									</select>

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Count<span class="redmind"></span></div>

									<input name="count" type="number" id="count" class="gridfield" value="<?php echo $count; ?>" displayname="Count" />

								</label>

							</div>



							<div class="griddiv" style="border-bottom:0px;">



								<div class="gridlable">Carry Forword</div>

								<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

									<tr>

										<td style="padding:0px 0px;">

											<input name="carryForword" type="radio" style="display:block;" onclick="$('#carryForwordDiv').hide();" value="0" <?php if ($carryForword == '') { ?>checked="checked" <?php } ?> />

										</td>

										<td style="padding:0px 0px;">No</td>

										<td style="padding:0px 0px;">&nbsp;&nbsp;</td>

										<td style="padding:0px 0px;"><label><input name="carryForword" type="radio" style="display:block;" onclick="$('#carryForwordDiv').show();$('#addeditfrm').append('');" value="1" <?php if ($carryForword == '1') { ?>checked="checked" <?php } ?> />

											</label></td>

										<td>Yes</td>

									</tr>

								</table>

								<!--<input name="carryForword" type="checkbox" id="carryForword" style="display: block;" value="1"  <?php if ($carryForword == 1) { ?>checked="checked" <?php } ?> />-->



							</div>



							<div class="griddiv" id="carryForwordDiv" <?php if ($carryForword == '') { ?>style="display:none;" <?php } ?>>

								<label>

									<div class="gridlable">Carry Upto</div>

									<input name="carryUpto" type="number" id="carryUpto" class="gridfield" value="<?php echo $carryUpto; ?>" />

								</label>

							</div>



						</td>

						<td width="50%" valign="top">



							<div class="griddiv" style="border-bottom:0px;"><label>

									<div class="gridlable">Selected</div>

									<input name="leaveSelected" type="checkbox" id="leaveSelected" style="display: block;" value="1" <?php if ($leaveSelected == 1) { ?>checked="checked" <?php } ?>>

								</label>

							</div>





							<div class="griddiv">

								<label>

									<div class="gridlable">Department<span class="redmind"></span></div>

									<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select Department</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DEPARTMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $departmentId) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>





							<div class="griddiv" style="border-bottom:0px;"><label>

									<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

										<tr>

											<td style="padding:0px 0px;"><label><input name="paybale" type="checkbox" id="paybale" style="display: block;" value="1" <?php if ($paybale == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Paybale</td>

											<td style="padding:0px 0px;">&nbsp;&nbsp;</td>

											<td style="padding:0px 0px;"><label><input name="emailNotify" type="checkbox" id="emailNotify" style="display: block;" value="1" <?php if ($emailNotify == 1) { ?>checked="checked" <?php } ?> /></label></td>

											<td>Email Notify</td>

										</tr>

									</table>



								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Max Time<span class="redmind"></span></div>

									<input name="minTime" type="number" id="minTime" class="gridfield" value="<?php echo $maxTime; ?>" displayname="Max Time" />

								</label>

							</div>

							<div class="griddiv">

								<label>

									<div class="gridlable">Min Time<span class="redmind"></span></div>

									<input name="maxTime" type="number" id="maxTime" class="gridfield" value="<?php echo $minTime; ?>" displayname="Min Time" />

								</label>

							</div>





						</td>



					</tr>

				</table>

				<div class="griddiv"><label>





						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_leaveconfiguration" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }

if ($_GET['action'] == 'addedit_holidayconfiguration' && $_GET['sectiontype'] == 'holidayconfiguration') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HOLIDAY_CONFIGURATION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$holidaySelected = clean($editresult['holidaySelected']);

		$city = clean($editresult['city']);

		$departmentId = clean($editresult['departmentId']);

		$designation = clean($editresult['designation']);

		$emailNotify = clean($editresult['emailNotify']);

		$holidayType = clean($editresult['holidayType']);

		$holidayDate = clean($editresult['holidayDate']);

		$holidayYear = clean($editresult['holidayYear']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Holiday Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">



							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Holiday Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Type<span class="redmind"></span></div>

									<select id="holidayType" name="holidayType" class="gridfield" displayname="Holiday Type" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _HOLIDAY_TYPE_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $holidayType) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Department<span class="redmind"></span></div>

									<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DEPARTMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $departmentId) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>

							<style>
								.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

									width: 100% !important;

								}
							</style>

							<script>
								$(document).ready(function() {



									$('#holidayDate').Zebra_DatePicker({

										format: 'd-m-Y',

									});

									$('#holidayYear').Zebra_DatePicker({

										format: 'Y',

									});

								});
							</script>



							<div class="griddiv"><label>

									<div class="gridlable">Date</div>

									<input name="holidayDate" type="text" id="holidayDate" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($holidayDate != '') {
																																						echo date("d-m-Y", strtotime($holidayDate));
																																					} ?>" />



								</label>

							</div>







							<div class="griddiv"><label>

									<div class="gridlable">Notify</div>

									<input name="emailNotify" type="checkbox" id="emailNotify" style="display: block;" value="1" <?php if ($emailNotify == 1) { ?>checked="emailNotify" <?php } ?>>

								</label>

							</div>



						</td>



						<td width="50%" valign="top">



							<div class="griddiv"><label>

									<div class="gridlable">Selected</div>

									<input name="holidaySelected" type="checkbox" id="holidaySelected" style="display: block;" value="1" <?php if ($holidaySelected == 1) { ?>checked="checked" <?php } ?>>

								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Location<span class="redmind"></span></div>

									<select id="city" name="city" class="gridfield">

										<option value="">Select</option>

										<!--

 <?php

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = 'deletestatus=0 order by name';

	$rs = GetPageRecord($select, _CITY_MASTER_, $where);

	while ($city = mysqli_fetch_array($rs)) {

	?>

<option value="<?php echo strip($city['id']); ?>" <?php if ($city == $city['id']) { ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>

<?php } ?>-->

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Designation<span class="redmind"></span></div>

									<select id="designation" name="designation" class="gridfield" displayname="Designation" autocomplete="off">

										<option value="">Select Designation</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'id="1" or userId="' . $loginusersuperParentId . '" order by id asc';
										} else {

											$where = 'userId="' . $loginusersuperParentId . '" order by id asc';
										}

										$rs = GetPageRecord($select, _ROLE_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $designation) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Year</div>

									<input name="holidayYear" type="text" id="holidayYear" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($holidayYear != '') {
																																						echo $holidayYear;
																																					} ?>" />



								</label>

							</div>



						</td>



					</tr>

				</table>

				<div class="griddiv"><label>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_holidayconfiguration" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_assetcategorymaster' && $_GET['sectiontype'] == 'assetcategorymaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ASSET_CATEGORY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Asset Category </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_assetcategorymaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_assettypemaster' && $_GET['sectiontype'] == 'assettypemaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ASSET_TYPE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Asset Type </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_assettypemaster" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_assetmanagement' && $_GET['sectiontype'] == 'assetmanagement') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ASSET_MANAGEMENT_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$assetId = clean($editresult['assetId']);

		$assetCategory = clean($editresult['assetCategory']);

		$assetType = clean($editresult['assetType']);

		$city = clean($editresult['city']);

		$departmentId = clean($editresult['departmentId']);

		$assetStatus = clean($editresult['assetStatus']);

		$discription = clean($editresult['discription']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Asset</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv">

								<label>

									<div class="gridlable">Category <span class="redmind"></span></div>

									<select id="assetCategory" name="assetCategory" class="gridfield" displayname="Category" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _ASSET_CATEGORY_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $assetCategory) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Type <span class="redmind"></span></div>

									<select id="assetType" name="assetType" class="gridfield" displayname="Type" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _ASSET_TYPE_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $assetType) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Location <span class="redmind"></span></div>

									<select id="city" name="city" class="gridfield">

										<option value="">Select</option>

										<!--

 <?php

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = 'deletestatus=0 order by name';

	$rs = GetPageRecord($select, _CITY_MASTER_, $where);

	while ($city = mysqli_fetch_array($rs)) {

	?>

<option value="<?php echo strip($city['id']); ?>" <?php if ($city == $city['id']) { ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>

<?php } ?>-->

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Department <span class="redmind"></span></div>

									<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select Department</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DEPARTMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $departmentId) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>

						</td>

						<td width="50%" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">Asset ID<span class="redmind"></span></div>

									<input name="assetId" type="text" class="gridfield" id="assetId" displayname="Asset Id" value="<?php echo $assetId; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>

							<div class="griddiv">

								<label>

									<div class="gridlable">Status <span class="redmind"></span></div>

									<select id="assetStatus" name="assetStatus" class="gridfield" displayname="Status" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _ASSET_STATUS_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $assetStatus) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>

							<div class="griddiv"><label>

									<div class="gridlable">Discription</div>

									<textarea name="discription" id="discription" style="width:98%;" class="gridfield"><?php echo stripslashes($discription); ?></textarea>

								</label>

							</div>

						</td>

					</tr>

				</table>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_assetmanagement" />

			</form>



		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_assetreport' && $_GET['sectiontype'] == 'assetreport') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ASSET_CONFIGURE_REPORT_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$departmentId = clean($editresult['departmentId']);

		$designation = clean($editresult['designation']);

		$city = clean($editresult['city']);

		$assetCategory = clean($editresult['assetCategory']);

		$assetStatus = clean($editresult['assetStatus']);

		$dateFrom = clean($editresult['dateFrom']);

		$dateTo = clean($editresult['dateTo']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Configure Report</h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">Report Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Report Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Department <span class="redmind"></span></div>

									<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select Department</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DEPARTMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $departmentId) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Designation<span class="redmind"></span></div>

									<select id="designation" name="designation" class="gridfield" displayname="Designation" autocomplete="off">

										<option value="">Select Designation</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'id="1" or userId="' . $loginusersuperParentId . '" order by id asc';
										} else {

											$where = 'userId="' . $loginusersuperParentId . '" order by id asc';
										}

										$rs = GetPageRecord($select, _ROLE_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $designation) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Location <span class="redmind"></span></div>

									<select id="city" name="city" class="gridfield">

										<option value="">Select</option>

										<!--

 <?php

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = 'deletestatus=0 order by name';

	$rs = GetPageRecord($select, _CITY_MASTER_, $where);

	while ($city = mysqli_fetch_array($rs)) {

	?>

<option value="<?php echo strip($city['id']); ?>" <?php if ($city == $city['id']) { ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>

<?php } ?>-->

									</select>
								</label>

							</div>



						</td>

						<td width="50%" valign="top">

							<div class="griddiv">

								<label>

									<div class="gridlable">Category <span class="redmind"></span></div>

									<select id="assetCategory" name="assetCategory" class="gridfield" displayname="Category" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _ASSET_CATEGORY_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $assetCategory) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Status <span class="redmind"></span></div>

									<select id="assetStatus" name="assetStatus" class="gridfield" displayname="Status" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _ASSET_STATUS_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $assetStatus) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>

							<style>
								.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

									width: 100% !important;

								}
							</style>

							<script>
								$(document).ready(function() {



									$('#dateFrom').Zebra_DatePicker({

										format: 'd-m-Y',

									});

									$('#dateTo').Zebra_DatePicker({

										format: 'd-m-Y',

									});

								});
							</script>



							<div class="griddiv"><label>

									<div class="gridlable">From</div>

									<input name="dateFrom" type="text" id="dateFrom" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($dateFrom != '') {
																																					echo date("d-m-Y", strtotime($dateFrom));
																																				} ?>" />



								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">To</div>

									<input name="dateTo" type="text" id="dateTo" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($dateTo != '') {
																																				echo date("d-m-Y", strtotime($dateTo));
																																			} ?>" />



								</label>

							</div>



						</td>

					</tr>

				</table>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_assetreport" />

			</form>



		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_hrmsdocumentcategory' && $_GET['sectiontype'] == 'hrmsdocumentcategory') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _DOCUMENT_CATEGORY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Asset Category </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Name<span class="redmind"></span></div>

						<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_hrmsdocumentcategory" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }





if ($_GET['action'] == 'addedit_hrmscompanyfile' && $_GET['sectiontype'] == 'hrmscompanyfile') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HRMS_FILE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$documentCategory = clean($editresult['documentCategory']);

		$city = clean($editresult['city']);

		$departmentId = clean($editresult['departmentId']);

		$validUntill = clean($editresult['validUntill']);

		$discription = clean($editresult['discription']);

		$fileType = clean($editresult['fileType']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Company File </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>





							<div class="griddiv">

								<label>

									<div class="gridlable">Category<span class="redmind"></span></div>

									<select id="documentCategory" name="documentCategory" class="gridfield" displayname="Category" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DOCUMENT_CATEGORY_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $documentCategory) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Type</div>

									<select id="fileType" name="fileType" class="gridfield " autocomplete="off">

										<option value="">Select </option>

										<option value="1" <?php if ($fileType == 1) { ?> selected="selected" <?php } ?>>Company File</option>

										<option value="2" <?php if ($fileType == 2) { ?> selected="selected" <?php } ?>>HR File</option>

										<option value="3" <?php if ($fileType == 3) { ?> selected="selected" <?php } ?>>Employee File</option>

									</select>

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Department<span class="redmind"></span></div>

									<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DEPARTMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $departmentId) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>











						</td>



						<td width="50%" valign="top">



							<div class="griddiv"><label>

									<div class="gridlable">Location<span class="redmind"></span></div>

									<select id="city" name="city" class="gridfield">

										<option value="">Select</option>

										<!--

 <?php

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = 'deletestatus=0 order by name';

	$rs = GetPageRecord($select, _CITY_MASTER_, $where);

	while ($city = mysqli_fetch_array($rs)) {

	?>

<option value="<?php echo strip($city['id']); ?>" <?php if ($city == $city['id']) { ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>

<?php } ?>-->

									</select>
								</label>

							</div>





							<style>
								.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

									width: 100% !important;

								}
							</style>

							<script>
								$(document).ready(function() {



									$('#validUntill').Zebra_DatePicker({

										format: 'd-m-Y',

									});

								});
							</script>



							<div class="griddiv"><label>

									<div class="gridlable">Valid Untill</div>

									<input name="validUntill" type="text" id="validUntill" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($validUntill != '') {
																																						echo date("d-m-Y", strtotime($validUntill));
																																					} ?>" />



								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Discription</div>

									<textarea name="discription" id="discription" style="width:98%;" class="gridfield"><?php echo stripslashes($discription); ?></textarea>

								</label>

							</div>

						</td>



					</tr>



				</table>

				<div class="griddiv"><label>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_hrmscompanyfile" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }





if ($_GET['action'] == 'addedit_hrmsemployeefile' && $_GET['sectiontype'] == 'hrmsemployeefile') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HRMS_FILE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$empName = clean($editresult['empName']);

		$documentCategory = clean($editresult['documentCategory']);

		$discription = clean($editresult['discription']);

		$fileType = clean($editresult['fileType']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Employee File </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">File Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Employee Name<span class="redmind"></span></div>

									<input name="empName" type="text" class="gridfield validate" id="empName" displayname="Employee Name" value="<?php echo $empName; ?>" maxlength="100" />

								</label>

							</div>





							<div class="griddiv">

								<label>

									<div class="gridlable">Category<span class="redmind"></span></div>

									<select id="documentCategory" name="documentCategory" class="gridfield" displayname="Category" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DOCUMENT_CATEGORY_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $documentCategory) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Type</div>

									<select id="fileType" name="fileType" class="gridfield " autocomplete="off">

										<option value="">Select </option>

										<option value="1" <?php if ($fileType == 1) { ?> selected="selected" <?php } ?>>Company File</option>

										<option value="2" <?php if ($fileType == 2) { ?> selected="selected" <?php } ?>>HR File</option>

										<option value="3" <?php if ($fileType == 3) { ?> selected="selected" <?php } ?>>Employee File</option>

									</select>

								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Discription</div>

									<textarea name="discription" id="discription" style="width:98%;" class="gridfield"><?php echo stripslashes($discription); ?></textarea>

								</label>

							</div>

						</td>



						</td>

					</tr>



				</table>

				<div class="griddiv"><label>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_hrmsemployeefile" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_hrmsfilereport' && $_GET['sectiontype'] == 'hrmsfilereport') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HRMS_FILE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$departmentId = clean($editresult['departmentId']);

		$city = clean($editresult['city']);

		$documentCategory = clean($editresult['documentCategory']);

		$fileType = clean($editresult['fileType']);

		$dateFrom = clean($editresult['dateFrom']);

		$validUntill = clean($editresult['validUntill']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Company File </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>





							<div class="griddiv">

								<label>

									<div class="gridlable">Category<span class="redmind"></span></div>

									<select id="documentCategory" name="documentCategory" class="gridfield" displayname="Category" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DOCUMENT_CATEGORY_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $documentCategory) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Type</div>

									<select id="fileType" name="fileType" class="gridfield " autocomplete="off">

										<option value="">Select </option>

										<option value="1" <?php if ($fileType == 1) { ?> selected="selected" <?php } ?>>Company File</option>

										<option value="2" <?php if ($fileType == 2) { ?> selected="selected" <?php } ?>>HR File</option>

										<option value="3" <?php if ($fileType == 3) { ?> selected="selected" <?php } ?>>Employee File</option>

										<option value="4" <?php if ($fileType == 4) { ?> selected="selected" <?php } ?>>File Report</option>

									</select>

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Department<span class="redmind"></span></div>

									<select id="departmentId" name="departmentId" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DEPARTMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $departmentId) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>

						</td>



						<td width="50%" valign="top">



							<div class="griddiv"><label>

									<div class="gridlable">Location<span class="redmind"></span></div>

									<select id="city" name="city" class="gridfield">

										<option value="">Select</option>

										<!--

 <?php

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = 'deletestatus=0 order by name';

	$rs = GetPageRecord($select, _CITY_MASTER_, $where);

	while ($city = mysqli_fetch_array($rs)) {

	?>

<option value="<?php echo strip($city['id']); ?>" <?php if ($city == $city['id']) { ?>selected="selected"<?php } ?>><?php echo strip($city['name']); ?></option>

<?php } ?>-->

									</select>
								</label>

							</div>





							<style>
								.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

									width: 100% !important;

								}
							</style>

							<script>
								$(document).ready(function() {



									$('#dateFrom').Zebra_DatePicker({

										format: 'd-m-Y',

									});

									$('#validUntill').Zebra_DatePicker({

										format: 'd-m-Y',

									});

								});
							</script>



							<div class="griddiv"><label>

									<div class="gridlable">From</div>

									<input name="dateFrom" type="text" id="dateFrom" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($dateFrom != '') {
																																					echo date("d-m-Y", strtotime($dateFrom));
																																				} ?>" />



								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">To</div>

									<input name="validUntill" type="text" id="validUntill" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($validUntill != '') {
																																						echo date("d-m-Y", strtotime($validUntill));
																																					} ?>" />



								</label>

							</div>

						</td>



					</tr>



				</table>

				<div class="griddiv"><label>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_hrmsfilereport" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php }



if ($_GET['action'] == 'addedit_hrmshrfile' && $_GET['sectiontype'] == 'hrmshrfile') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HRMS_FILE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$documentCategory = clean($editresult['documentCategory']);

		$fileType = clean($editresult['fileType']);

		$permissionView = clean($editresult['permissionView']);

		$employee = clean($editresult['employee']);

		$designation = clean($editresult['designation']);

		$discription = clean($editresult['discription']);

		$shareManager = clean($editresult['shareManager']);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Employee File </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

								</label>

							</div>



							<div class="griddiv">

								<label>

									<div class="gridlable">Category<span class="redmind"></span></div>

									<select id="documentCategory" name="documentCategory" class="gridfield" displayname="Category" autocomplete="off">

										<option value="">Select</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'status="1" order by id asc';
										} else {

											$where = 'status="1" order by id asc';
										}

										$rs = GetPageRecord($select, _DOCUMENT_CATEGORY_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['status'] != 0) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $documentCategory) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>
								</label>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Type</div>

									<select id="fileType" name="fileType" class="gridfield " autocomplete="off">

										<option value="">Select </option>

										<option value="1" <?php if ($fileType == 1) { ?> selected="selected" <?php } ?>>Company File</option>

										<option value="2" <?php if ($fileType == 2) { ?> selected="selected" <?php } ?>>HR File</option>

										<option value="3" <?php if ($fileType == 3) { ?> selected="selected" <?php } ?>>Employee File</option>

									</select>

								</label>

							</div>



							<div class="griddiv" style="border-bottom:0px;">

								<div class="gridlable">File Permission View </div>

								<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

									<tr>

										<td style="padding:0px 0px;"><input name="permissionView" type="radio" style="display:block;" onclick="$('#permissionViewDiv').show();$('#addeditfrm').append(''); $('#permissionViewDiv1').hide();" value="0" <?php if ($permissionView == '') { ?>checked="checked" <?php } ?> /> </td>

										<td style="padding:0px 0px;">Role Based</td>

										<td style="padding:0px 0px;">&nbsp;&nbsp;</td>

										<td style="padding:0px 0px;"><label><input name="permissionView" type="radio" style="display:block;" onclick="$('#permissionViewDiv').hide();$('#permissionViewDiv1').show();$('#addeditfrm').append('');" value="1" <?php if ($permissionView != '') { ?>checked="checked" <?php } ?> />

											</label></td>

										<td>Employee Based</td>

									</tr>

								</table>

							</div>



							<div class="griddiv" id="permissionViewDiv" <?php if ($permissionView == '0') { ?>style="display:none;" <?php } ?>><label>

									<div class="gridlable">Designation<span class="redmind"></span></div>

									<select id="designation" name="designation" class="gridfield" displayname="Designation" autocomplete="off">

										<option value="">Select Designation</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'id="1" or userId="' . $loginusersuperParentId . '" order by id asc';
										} else {

											$where = 'userId="' . $loginusersuperParentId . '" order by id asc';
										}

										$rs = GetPageRecord($select, _ROLE_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $designation) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

										<?php }
										} ?>

									</select>

								</label>

							</div>



							<div class="griddiv" id="permissionViewDiv1" <?php if ($permissionView == '') { ?>style="display:none;" <?php } ?>><label>

									<div class="gridlable">Employee</div>

									<select id="employee" name="employee" class="gridfield" displayname="Department" autocomplete="off">

										<option value="">Select Employee</option>

										<?php

										$select = '';

										$where = '';

										$rs = '';

										$select = '*';

										if ($loginuseradmin == 1) {

											$where = 'deletestatus="0" order by id asc';
										} else {

											$where = 'deletestatus="0" order by id asc';
										}

										$rs = GetPageRecord($select, _EMPLOYEE_MANAGEMENT_MASTER_, $where);

										while ($timeformat = mysqli_fetch_array($rs)) {

											if ($timeformat['deletestatus'] != 1) {

										?>

												<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $employee) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?>

												</option>

										<?php }
										} ?>

									</select>

								</label>

							</div>



							<div class="griddiv" style="border-bottom:0px;">

								<!--<div class="gridlable">Share to Reporting</div>-->

								<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

									<tr>

										<td style="padding:0px 0px;"><input name="shareManager" type="checkbox" id="shareManager" style="display: block;" value="1" <?php if ($shareManager == 1) { ?>checked="checked" <?php } ?>> </td>

										<td style="padding:0px 0px;">Share to Reporting</td>

									</tr>

								</table>

							</div>



							<div class="griddiv"><label>

									<div class="gridlable">Discription</div>

									<textarea name="discription" id="discription" style="width:98%;" class="gridfield"><?php echo stripslashes($discription); ?></textarea>

								</label>

							</div>

						</td>





					</tr>



				</table>

				<div class="griddiv"><label>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_hrmshrfile" />

			</form>





		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>





<?php

}



if ($_GET['action'] == 'addedit_attendanceregularize' && $_GET['sectiontype'] == 'attendanceregularize') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _ATTANDANCE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?> Bulk Attendance </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">





			<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm" target="actoinfrm" style="">

				<table width="100%" border="0" cellpadding="5" cellspacing="0">

					<tr>

						<td colspan="2" valign="top">

							<div class="griddiv" style="border-bottom:0px;"><label>

									<div class="gridlable">Upload File</div>

									<input name="importsupplierexcel" id="importsupplierexcel" type="hidden" value="Y" />

									<div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>

								</label>

							</div>







						</td>

					</tr>



				</table>

				<div class="griddiv"><label>

			</form>

			<script>
				function submitimportfrom() {

					startloading();

					$('#importfrm').submit();

					var filesizes = $("#importfield")[0].files[0].size;

					filesizes = Number(filesizes / 1024);

					if (filesizes > 11) {

					}

				}

				function reloadpagemain() {

					location.reload();

				}
			</script>





		</div>

		<!--<div id="buttonsbox"  style="text-align:center;">

 <table border="0" align="right" cellpadding="0" cellspacing="0">

      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

      </tr>

   </table>

</div></div>-->





	<?php



}



if ($_GET['action'] == 'addedit_salarycomponent' && $_GET['sectiontype'] == 'salarycomponent') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _SALARY_COMPONENT_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$abbreviation = clean($editresult['abbreviation']);

		$effectiveDate = clean($editresult['effectiveDate']);

		$paidComponent = clean($editresult['paidComponent']);

		$payType = clean($editresult['payType']);

		$taxStatus = clean($editresult['taxStatus']);

		$chkTaxable = clean($editresult['chkTaxable']);

		$calculationType = clean($editresult['calculationType']);

		$jvCode = clean($editresult['jvCode']);

		$mapTo = clean($editresult['mapTo']);

		$chkFbp = clean($editresult['chkFbp']);

		$chkAttandance = clean($editresult['chkAttandance']);

		$chkCtc = clean($editresult['chkCtc']);

		$chkComponenet = clean($editresult['chkComponenet']);

		$chkActive = clean($editresult['chkActive']);

		$chkFfs = clean($editresult['chkFfs']);

		$valueFormula = clean($editresult['valueFormula']);

		$chkFfs = clean($editresult['chkFfs']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Salary Component </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>



								<div class="griddiv"><label>

										<div class="gridlable">Abbreviation</div>

										<input name="abbreviation" type="text" class="gridfield" id="abbreviation" displayname="Abbreviation" value="<?php echo $abbreviation; ?>" maxlength="100" />

									</label>

								</div>



								<style>
									.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

										width: 100% !important;

									}
								</style>

								<script>
									$(document).ready(function() {

										$('#effectiveDate').Zebra_DatePicker({

											format: 'd-m-Y',

										});

									});
								</script>

								<div class="griddiv">

									<label>

										<div class="gridlable">Effective Date</div>

										<input name="effectiveDate" type="text" id="effectiveDate" class="gridfield calfieldicon" autocomplete="off" value="<?php echo $effectiveDate; ?>" maxlength="500" />
									</label>

								</div>



								<div class="griddiv" style="border-bottom:0px;">

									<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="paidComponent" type="checkbox" id="paidComponent" style="display: block;" value="1" <?php if ($paidComponent == 1) { ?>checked="checked" <?php } ?>> </td>

											<td style="padding:0px 0px;">Paid Component</td>

										</tr>

									</table>

								</div>



								<div class="griddiv">

									<label>

										<div class="gridlable">Pay Type </div>

										<select id="payType" name="payType" class="gridfield" displayname="Pay Type" autocomplete="off">

											<option value="">Select</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											if ($loginuseradmin == 1) {

												$where = 'status="1" order by id asc';
											} else {

												$where = 'status="1" order by id asc';
											}

											$rs = GetPageRecord($select, _PAY_TYPE_MASTER_, $where);

											while ($timeformat = mysqli_fetch_array($rs)) {

												if ($timeformat['deletestatus'] != 1) {

											?>

													<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $payType) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

											<?php }
											} ?>

										</select>
									</label>

								</div>



								<div class="griddiv" style="border-bottom:0px;">

									<div class="gridlable">Tax Status </div>

									<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

										<tr>

											<td style="padding:0px 0px;"><input name="taxStatus" type="radio" style="display: block;" value="0" <?php if ($taxStatus == 0) { ?>checked="checked" <?php } ?>> </td>

											<td style="padding:0px 0px;">Non Taxable</td>

											<td style="padding:0px 0px;">&nbsp;&nbsp;</td>

											<td style="padding:0px 0px;"><input name="taxStatus" type="radio" style="display: block;" value="1" <?php if ($taxStatus == 1) { ?>checked="checked" <?php } ?> /></td>

											<td>Taxable</td>

										</tr>

									</table>





								</div>



								<div class="griddiv" style="border-bottom:0px;">

									<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkTaxable" type="checkbox" id="chkTaxable" style="display: block;" value="1" <?php if ($chkTaxable == 1) { ?>checked="checked" <?php } ?>> </td>

											<td style="padding:0px 0px;">Tax across the year</td>

										</tr>

									</table>

								</div>







							</td>

							<td width="50%" valign="top">



								<div class="griddiv">

									<label>

										<div class="gridlable">Calculation Type </div>

										<select id="calculationType" name="calculationType" class="gridfield" displayname="Calculation Type" autocomplete="off">

											<option value="">Select</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											if ($loginuseradmin == 1) {

												$where = 'status="1" order by id asc';
											} else {

												$where = 'status="1" order by id asc';
											}

											$rs = GetPageRecord($select, _SALARY_CALCULATION_MASTER_, $where);

											while ($timeformat = mysqli_fetch_array($rs)) {

												if ($timeformat['deletestatus'] != 1) {

											?>

													<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $calculationType) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

											<?php }
											} ?>

										</select>
									</label>

								</div>





								<div class="griddiv"><label>

										<div class="gridlable">Value/Formula</div>

										<textarea name="valueFormula" id="valueFormula" style="width:98%;" class="gridfield"><?php echo $valueFormula; ?></textarea>

									</label>

								</div>



								<div class="griddiv"><label>

										<div class="gridlable">JV Code</div>

										<input name="jvCode" type="text" class="gridfield" id="jvCode" displayname="JV Code" value="<?php echo $jvCode; ?>" maxlength="100" />

									</label>

								</div>



								<div class="griddiv">

									<label>

										<div class="gridlable">Map To </div>

										<select id="mapTo" name="mapTo" class="gridfield" displayname="Map To" autocomplete="off">

											<option value="">Select</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											if ($loginuseradmin == 1) {

												$where = 'status="1" order by id asc';
											} else {

												$where = 'status="1" order by id asc';
											}

											$rs = GetPageRecord($select, _SALARY_MAP_TO_MASTER_, $where);

											while ($timeformat = mysqli_fetch_array($rs)) {

												if ($timeformat['deletestatus'] != 1) {

											?>

													<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $mapTo) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

											<?php }
											} ?>

										</select>
									</label>

								</div>



								<div class="griddiv" style="border-bottom:0px;">

									<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">

										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkFbp" type="checkbox" id="chkFbp" style="display: block;" value="1" <?php if ($chkFbp == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Is an FBP component</td>

										</tr>



										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkAttandance" type="checkbox" id="chkAttandance" style="display: block;" value="1" <?php if ($chkAttandance == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Attendance dependent</td>

										</tr>



										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkCtc" type="checkbox" id="chkCtc" style="display: block;" value="1" <?php if ($chkCtc == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Part of CTC</td>

										</tr>



										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkComponenet" type="checkbox" id="chkComponenet" style="display: block;" value="1" <?php if ($chkComponenet == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Create dependent component</td>

										</tr>



										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkActive" type="checkbox" id="chkActive" style="display: block;" value="1" <?php if ($chkActive == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Active</td>

										</tr>



										<tr>

											<td style="padding:0px 0px;"><label>

													<input name="chkFfs" type="checkbox" id="chkFfs" style="display: block;" value="1" <?php if ($chkFfs == 1) { ?>checked="checked" <?php } ?>> </label></td>

											<td style="padding:0px 0px;">Is an FFS component</td>

										</tr>

									</table>





								</div>



							</td>



						</tr>

					</table>

					<div class="griddiv"><label>





							<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

							<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

							<input name="action" type="hidden" id="action" value="addedit_salarycomponent" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }

if ($_GET['action'] == 'addedit_mainhallmaster' && $_GET['sectiontype'] == 'mainhallmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _MAIN_HALL_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Main Hall </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>







							</td>





						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_mainhallmaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>

	<?php }

if ($_GET['action'] == 'addedit_diningareamaster' && $_GET['sectiontype'] == 'diningareamaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';
		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _DINING_AREA_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	} ?>



		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Dining Area </h1>



			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">



				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">



					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">



								<div class="griddiv"><label>



										<div class="gridlable">Name<span class="redmind"></span></div> <input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>





							</td>

						</tr>



					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_diningareamaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">



				<table border="0" align="right" cellpadding="0" cellspacing="0">



					<tr>



						<td>



							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" />



						</td>

						<td style="padding-right:20px;">



							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>

		</div>



	<?php }



if ($_GET['action'] == 'addedit_divisionmaster' && $_GET['sectiontype'] == 'divisionmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _DIVISION_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Division </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>





						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_divisionmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php }

if ($_GET['action'] == 'addedit_audiovisualmaster' && $_GET['sectiontype'] == 'audiovisualmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _AUDIO_VISUAL_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Audio Visual </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>





							</td>





						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_audiovisualmaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php }

if ($_GET['action'] == 'addedit_vviploungemaster' && $_GET['sectiontype'] == 'vviploungemaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _VVIP_LAUNGE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> VVIP Launge </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_vviploungemaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php }



if ($_GET['action'] == 'addedit_photographymaster' && $_GET['sectiontype'] == 'photographymaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PHOTOGRAPHY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Photography </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_photographymaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}





if ($_GET['action'] == 'addedit_powersupplymaster' && $_GET['sectiontype'] == 'powersupplymaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _POWER_SUPPLY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Power Supply </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_powersupplymaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_utilitiesmaster' && $_GET['sectiontype'] == 'utilitiesmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _UTILITIES_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Utilities </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_utilitiesmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_signagemaster' && $_GET['sectiontype'] == 'signagemaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _SIGNAGE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Signage </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_signagemaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_venuemaster' && $_GET['sectiontype'] == 'venuemaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _VENUE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Venue </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_venuemaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_housekeepingmaster' && $_GET['sectiontype'] == 'housekeepingmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _HOUSE_KEEPING_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Housekeeping </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_housekeepingmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_securitymaster' && $_GET['sectiontype'] == 'securitymaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _SECURITY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Security </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_securitymaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_licencesmaster' && $_GET['sectiontype'] == 'licencesmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _LICENCES_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Licence </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_licencesmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_decormaster' && $_GET['sectiontype'] == 'decormaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _DECOR_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Decor </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_decormaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_emergencyservicesmaster' && $_GET['sectiontype'] == 'emergencyservicesmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _EMERGENCY_SERVICES_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Emergency Service </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellpadding="5" cellspacing="0">

						<tr>

							<td colspan="2" valign="top">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

									</label>

								</div>

							</td>



						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_emergencyservicesmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_hotelgallery') {

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Add Image </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<?php $hotelid = $_GET['hotelid']; ?>

					<div class="griddiv"><label>

							<div class="gridlable">Title<span class="redmind"></span></div>

							<input name="title" type="text" class="gridfield validate" id="title" displayname="Title" value="<?php echo $name; ?>" maxlength="100" />

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Photo</div>

							<input name="galleryImage" type="file" class="gridfield" id="galleryImage" />

						</label>

					</div>



					<input name="hotelId" type="hidden" id="hotelId" value="<?php echo $hotelid; ?>" />

					<input name="action" type="hidden" id="action" value="addedithotelGallery" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }

















































if ($_GET['action'] == 'view_bookingdetails') {

	$companyId = decode($_GET['companyId']);

	$rsb = GetPageRecord('*', _QUERY_MASTER_, 'companyId="' . $companyId . '" and companyId!="" order by id desc');

	$totalBooking = mysqli_num_rows($rsb);

	?>

		<style>
			.totalquery {

				background-color: #8BC34A;

				padding: 5px;

				border-radius: 5px;

				color: #ffff;

				font-size: 14px;
			}
		</style>

		<div class="contentclass">

			<div class="totalquery"><span style="float:left;"><?php if ($_REQUEST['id'] != '') {
																	echo 'Edit';
																} else {
																	echo 'View';
																} ?> History </span> Total Bookings - <?php echo $totalBooking; ?></div>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

					<thead>

						<tr>

							<th align="center" class="header" style="padding-left:0px;padding-tight:0px;">&nbsp;</th>

							<th align="left" class="header">Query ID</th>

							<th align="left" class="header">Invoice No</th>

							<th align="left" class="header">Invoice Amount</th>

							<th align="left" class="header">Receive Amount</th>

							<th align="left" class="header">Pending Amount</th>

							<th align="left" class="header">Status</th>



						</tr>

					</thead>





					<tbody>

						<?php

						$nod = 1;

						$rsb = GetPageRecord('*', _QUERY_MASTER_, 'companyId="' . $companyId . '" and companyId!="" order by id desc');

						while ($bookingdetails = mysqli_fetch_array($rsb)) {

							$queryid = $bookingdetails['id'];



							$rsim = GetPageRecord('*', _INVOICE_MASTER_, 'queryid=' . $bookingdetails['id'] . ' and deletestatus=0');

							$resulinvoice = mysqli_fetch_array($rsim);



							$rs1 = GetPageRecord('*', _PAYMENT_REQUEST_MASTER_, 'queryid=' . $queryid . '');

							$resultpaymentpage1 = mysqli_fetch_array($rs1);



							$rs = GetPageRecord('*', _AGENT_PAYMENT_REQUEST_, 'paymentId="' . $resultpaymentpage1['id'] . '"');

							$requesetdata = mysqli_fetch_array($rs);



							$reqclientGst = $requesetdata['reqclientGst'];

							$reqmarginGst = $requesetdata['reqmarginGst'];

							$pendingCost = $requesetdata['pendingCost'];

							$finalCost = $requesetdata['finalCost'];

							if ($reqclientGst != 0) {

								$GST = $requesetdata['reqclientGst'];

								$Cgst = $requesetdata['reqclientCGst'];

								$Sgst = $requesetdata['reqclientSGst'];

								$Igst = $requesetdata['reqclientIGst'];

								$finalReqCost = $reqclientCost;
							}

							if ($reqmarginGst != 0) {

								$GST = $requesetdata['reqmarginGst'];

								$Cgst = $requesetdata['reqmarginCGst'];

								$Sgst = $requesetdata['reqmarginSGst'];

								$Igst = $requesetdata['reqmarginIGst'];

								$finalReqCost = $reqmarginCost;
							}

							$igstval = round($finalReqCost * $Igst / 100);

							$totalpendingamount = 0;

							$s = 1;



							$rs2 = GetPageRecord('*', _DMC_PAYMENT_LIST_MASTER_, 'queryId=' . $queryid . '');

							while ($listofpayment = mysqli_fetch_array($rs2)) {

								$totalpendingamount = $totalpendingamount + $listofpayment['amount'];
							}

						?>

							<tr>

								<td align="center" style="padding-left:0px;padding-right:0px; width:40px;"></td>



								<td align="left"><a href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($bookingdetails['id']); ?>" target="_blank" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; "><?php echo makeQueryId($bookingdetails['id']); ?></a></td>

								<td align="left"><?php if ($resulinvoice['id'] != '') {
														if ($resulinvoice['invoiceType'] == '1') {
															echo 'INV';
														} else {
															echo 'PER';
														} ?><?php echo makeInvoiceId($resulinvoice['id']);
																																							} else {
																																								echo "-";
																																							} ?></td>

								<td align="left"><?php if ($finalCost > 0) {
														echo $finalCost;
													} else {
														echo "-";
													} ?></td>

								<td align="left"><?php if ($totalpendingamount > 0) {
														echo $totalpendingamount;
													} else {
														echo "-";
													} ?></td>

								<td align="left"><?php if ($pendingCost > 0) {
														echo $pendingCost;
													} else {
														echo "-";
													} ?></td>

								<td align="center" style="width:50px;">

									<?php if ($bookingdetails['queryStatus'] == 20) { ?>

										<div class="lossquery">Cancelled</div>

									<?php } else { ?>

										<?php

										$result = mysqli_query(db(), "select * from " . _PAYMENT_REQUEST_MASTER_ . " where queryid='" . $bookingdetails['id'] . "' and deletestatus!=1")  or die(mysqli_error(db()));

										$number = mysqli_num_rows($result);

										$getpaymentid = mysqli_fetch_array($result);

										if ($number > 0) {

										?>

											<?php /*?><div class="wonquery" <?php if($getpaymentid['status']==0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['status']==0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div><?php */ ?>

											<div class="wonquery" <?php if ($getpaymentid['supplierPendingamount'] > 0) { ?>style="background-color:#CC3300;" <?php } ?>><?php if ($getpaymentid['supplierPendingamount'] > 0) {
																																											echo 'Unpaid';
																																										} else {
																																											echo 'Paid';
																																										} ?></div>



										<?php } else { ?>

											<?php

											$id = $bookingdetails['id'];



											$rsrs = GetPageRecord('*', _SUPPLIER_COMMUNICATION_MAIL_, 'queryId=' . $id . ' and fromMail!="" order by dateAdded desc');

											$countGetMail = mysqli_num_rows($rsrs);



											if ($bookingdetails['queryStatus'] == 1) {
												echo '<div class="assignquery">Assigned</div>';
											}

											if ($bookingdetails['queryStatus'] == 6) {
												echo '<div class="assignquery">Enquiry&nbsp;Sent</div>';
											}

											if ($bookingdetails['queryStatus'] == 12) {
												echo '<div class="wonquery">Quote&nbsp;Pending</div>';
											}

											if ($bookingdetails['queryStatus'] == 5) {
												echo '<div class="closequery">Quoted to Sales</div>';
											}

											if ($bookingdetails['queryStatus'] == 13) {
												echo '<div class="wonquery" style="background-color: #0099ff !important;">Quoted&nbsp;to&nbsp;Client</div>';
											}

											if ($bookingdetails['queryStatus'] == 7) {
												echo '<div class="assignquery">Follow-up</div>';
											}

											if ($bookingdetails['queryStatus'] == 8) {
												echo '<div class="quotationquery" style="margin-bottom:2px;">Re-Quoted&nbsp;to&nbsp;Sales</div>';
											}

											if ($bookingdetails['queryStatus'] == 14) {
												echo '<div class="wonquery" style="background-color: #ff99cc !important;">Re-Quoted&nbsp;to&nbsp;Clients</div>';
											}

											if ($bookingdetails['queryStatus'] == 3) {
												echo '<div class="wonquery">Confirmed</div>';
											}

											if ($bookingdetails['queryStatus'] == 4) {
												echo '<div class="lossquery">Lost</div>';
											}

											if ($bookingdetails['queryStatus'] == 15) {
												echo '<div class="wonquery" style="background-color: #00b300 !important;">Payment&nbsp;recived</div>';
											}

											if ($bookingdetails['queryStatus'] == 10) {
												echo '<div class="assignquery">Created</div>';
											}

											if ($bookingdetails['queryStatus'] == 2) {
												echo '<div class="revertquery">Reverted</div>';
											}

											if ($bookingdetails['queryStatus'] == 0) {
												echo '<div class="assignquery">Assigned</div>';
											}



											?>

										<?php } ?>

									<?php } ?>
								</td>



							</tr>

						<?php $nod++;
						} ?>



					</tbody>
				</table>

				<?php if ($nod == 1) { ?>

					<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Booking Details</div>

				<?php } ?>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>



	<?php

}









//add visa type /////////////////////////////////////////

if ($_GET['action'] == 'addedit_visatype' && $_GET['sectiontype'] == 'visatype') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'visaType', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> VISA Type </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

						</label>

					</div>



					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_visatype" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }





if ($_GET['action'] == 'addedit_visacountry' && $_GET['sectiontype'] == 'visacountry' && $_GET['id'] != '') {





	$select1 = '*';

	$where1 = '1';

	$rs1 = GetPageRecord($select1, _VISA_DOCUMENT_MASTER_, $where1);

	$editresult = mysqli_fetch_array($rs1);



	?>

		<div class="contentclass">

			<h1 style="text-align:left;">VISA Country Documents</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Select Visa Type<span class="redmind"></span></div>

							<select id="visaType" name="visaType" class="gridfield" displayname="Visa Type" autocomplete="off">

								<option value="">Select</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';



								$where = '1 order by id asc';



								$rs = GetPageRecord($select, 'visaType', $where);

								while ($timeformat = mysqli_fetch_array($rs)) {



								?>

									<option value="<?php echo strip($timeformat['id']); ?>" <?php if ($timeformat['id'] == $payType) { ?>selected="selected" <?php } ?>><?php echo strip($timeformat['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Document Type</div>

							<select name="documents[]" class="gridfield select2" displayname="Documents" autocomplete="off" multiple="multiple">

								<option value="">Select</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' name!="" and docId=0 and deletestatus=0 order by id desc';

								$rs = GetPageRecord($select, _VISA_DOCUMENT_MASTER_, $where);

								while ($resListing = mysqli_fetch_array($rs)) {

									$documents = array_map('trim', explode(",", $editresult['documents']));

								?>

									<option value="<?php echo ($resListing['id']); ?>" <?php if (in_array($resListing['id'], $documents)) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<script src="plugins/select2/select2.full.min.js"></script>

					<script>
						$(document).ready(function() {

							$('.select2').select2();



						});
					</script>

					<style>
						.select2-container--open {

							z-index: 9999999999 !important;

							width: 100%;

						}

						.select2-container {

							box-sizing: border-box;

							display: inline-block;

							margin: 0;

							position: relative;

							vertical-align: middle;

							width: 100% !important;

						}
					</style>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_visacountry" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>



	<?php }



//add country visa description //

if ($_GET['action'] == 'addedit_visacountrydescription' && $_GET['sectiontype'] == 'visacountrydescription') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'visaCountryDescription', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$description = clean($editresult['description']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Country VISA Description</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

						</label>

					</div>



					<div class="griddiv"><label>

							<div class="gridlable">Description<span class="redmind"></span></div>

							<textarea name="description" id="description" class="gridfield validate" displayname="Description"><?php echo stripslashes($description); ?></textarea>



						</label>

					</div>



					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_visatype" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }





if ($_GET['action'] == 'addedit_visadocument' && $_GET['sectiontype'] == 'visadocument') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _VISA_DOCUMENT_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> VISA Document </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

						</label>

					</div>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_visadocument" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }

if ($_GET['action'] == 'addedit_documentvisacountry' && $_GET['sectiontype'] == 'documentvisacountry') {



	if ($_GET['id'] != '') {

		$dcid == '';

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _VISA_COUNTRY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);

		$select12 = '';

		$where12 = '';

		$select12 = '*';

		$rs12 = '';

		$where12 = 'countryId="' . $editresult['id'] . '" and docId="' . $_GET['docid'] . '"';

		$rs12 = GetPageRecord($select12, 'visaDocumentCountry', $where12);

		$result = mysqli_fetch_array($rs12);

		$dcid = clean($result['id']);
	}

	$select = '';

	$where = '';

	$rs = '';

	$select = '*';

	$where = ' id="' . $_GET['docid'] . '" order by id desc';

	$rs = GetPageRecord($select, _VISA_DOCUMENT_MASTER_, $where);

	$resListing = mysqli_fetch_array($rs);

	$names = $resListing['name'];

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($dcid != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> VISA Country Document</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $names; ?>" maxlength="100" readonly="readonly" />



						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Document Type</div>

							<select name="documentsub[]" class="gridfield select2" id="documentsub" displayname="Documents" autocomplete="off" multiple="multiple">

								<option value="">Select</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' docId="' . $_GET['docid'] . '" and deletestatus=0 order by id desc';

								$rs = GetPageRecord($select, _VISA_DOCUMENT_MASTER_, $where);

								while ($resListing = mysqli_fetch_array($rs)) {

									$documents = array_map('trim', explode(",", $result['subId']));

								?>

									<option value="<?php echo ($resListing['id']); ?>" <?php if (in_array($resListing['id'], $documents)) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<script src="plugins/select2/select2.full.min.js"></script>

					<script>
						$(document).ready(function() {

							$('.select2').select2();



						});
					</script>

					<style>
						.select2-container--open {

							z-index: 9999999999 !important;

							width: 100%;

						}

						.select2-container {

							box-sizing: border-box;

							display: inline-block;

							margin: 0;

							position: relative;

							vertical-align: middle;

							width: 100% !important;

						}
					</style>

					<input name="docId" type="hidden" id="docId" value="<?php echo $_GET['docid']; ?>" />

					<input name="countryId" type="hidden" id="countryId" value="<?php echo $_GET['id']; ?>" />

					<input name="editId" type="hidden" id="editId" value="<?php echo $dcid; ?>" />

					<input name="module" type="hidden" id="module" value="documentvisacountry" />

					<input name="action" type="hidden" id="action" value="addedit_documentvisacountry" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }



if ($_GET['action'] == 'addedit_visasubdocument' && $_GET['sectiontype'] == 'visasubdocument') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _VISA_DOCUMENT_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> VISA Document </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Document Type<span class="redmind"></span></div>

							<select name="documentsubId" class="gridfield validate" id="documentsubId" displayname="Documents" autocomplete="off">

								<option value="">Select</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' docId=0 and deletestatus=0 order by id desc';

								$rs = GetPageRecord($select, _VISA_DOCUMENT_MASTER_, $where);

								while ($resListing = mysqli_fetch_array($rs)) {

									$documents = array_map('trim', explode(",", $editresult['documents']));

								?>

									<option value="<?php echo ($resListing['id']); ?>" <?php if (($resListing['id'] == $editresult['docId'])) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_visasubdocument" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }











if ($_GET['action'] == 'addedit_groupDiscountmaster' && $_GET['sectiontype'] == 'groupDiscountmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = 'name,discount';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'groupDiscountmaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$discount = clean($editresult['discount']);

		$pax = clean($editresult['pax']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> State </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Pax<span class="redmind"></span></div>

							<select id="pax" name="pax" class="gridfield validate" displayname="Pax" autocomplete="off">

								<option value="1" <?php if ($pax = 1) { ?> selected="selected" <?php } ?>>15-19</option>

								<option value="2" <?php if ($pax = 2) { ?> selected="selected" <?php } ?>>20-24</option>

								<option value="3" <?php if ($pax = 3) { ?> selected="selected" <?php } ?>>25-29</option>

								<option value="4" <?php if ($pax = 4) { ?> selected="selected" <?php } ?>>30-34</option>



							</select>

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Discount<span class="redmind"></span></div>

							<input name="discount" type="text" class="gridfield validate" id="discount" displayname="Discount" value="<?php echo $discount; ?>" maxlength="100" />

						</label>

					</div>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_groupDiscountmaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }


if ($_GET['action'] == 'addedit_otherActivityMaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Sightseeing </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td width="50%" colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Sightseeing&nbsp;Name<span class="redmind"></span></div>

										<input name="otherActivityName" type="text" class="gridfield validate" id="otherActivityName" displayname="Sightseeing Name" value="<?php echo strip($editresult['otherActivityName']); ?>" />

									</label>

								</div>
							</td>

							<td width="50%" colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Destination<span class="redmind"></span></div>

										<select id="otherActivityCity" name="otherActivityCity" class="gridfield validate" displayname="city" autocomplete="off">

											<option value="">Select</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' 1 and name!="" and deletestatus="0" order by name asc';

											$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

											?>

												<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['name'] == $editresult['otherActivityCity']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

											<?php } ?>

										</select>

									</label>

								</div>
							</td>

						</tr>



						<script>
							$('.number_only').bind('keyup paste', function() {

								this.value = this.value.replace(/[^0-9]/g, '');

							});
						</script>

						<tr>
							<!-- 
				<td width="50%" colspan="2"><div class="griddiv"><label>

				<div class="gridlable">Photo</div>

				<input name="otherActivityImage" type="file" class="gridfield" id="otherActivityImage"/>

				</label>

				</div></td> -->

							<td width="50%" colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Transfer&nbsp;Type</div>

										<select id="transferType" name="transferType" class="gridfield " autocomplete="off">
											<option value="0" <?php if ($editresult['transferType'] == '0') { ?> selected="selected" <?php } ?>>All</option>

											<option value="1" <?php if ($editresult['transferType'] == '1') { ?> selected="selected" <?php } ?>>SIC</option>

											<option value="2" <?php if ($editresult['transferType'] == '2') { ?> selected="selected" <?php } ?>>PVT</option>

											<option value="3" <?php if ($editresult['transferType'] == '3') { ?> selected="selected" <?php } ?>>VIP</option>
											
											<option value="4" <?php if ($editresult['transferType'] == '4' || !isset($editresult['transferType'])) { ?> selected="selected" <?php } ?>>Ticket Only</option>

										</select>

									</label>

								</div>
							</td>
						
							<td colspan="">
								<div class="griddiv"><label>

										<div class="gridlable" style="width:100%;">Default For Quotation</div>

										<select id="isDefault" name="isDefault" class="gridfield " autocomplete="off">

											<option value="0" <?php if ($editresult['isDefault'] == '0') { ?> selected="selected" <?php } ?>>No</option>

											<option value="1" <?php if ($editresult['isDefault'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

										</select>

									</label>

								</div>
							</td>
							<td colspan="">
								<div class="griddiv"><label>

										<div class="gridlable">Status</div>

										<select id="status" name="status" class="gridfield " autocomplete="off">

											<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

										</select>

									</label>

								</div>
							</td>

						</tr>
							<tr>
							

							<td >
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Default For Proposal</div>

									<select id="isOptTours" name="isOptTours" class="gridfield " onchange="isOptionalTours();" autocomplete="off">

										<option value="0" <?php if ($editresult['isOptTours'] == '0') { ?> selected="selected" <?php } ?>>No</option>

										<option value="1" <?php if ($editresult['isOptTours'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

									</select>

								</label>

							</div>
						</td> 

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?>>
							<div class="griddiv"><label>

									<div class="gridlable isOptMandatory" style="width:100%;">Currency</div>

									<select id="isOptCurrencyId" name="isOptCurrencyId" class="gridfield " autocomplete="off">
										<?php 
										$rscc = GetPageRecord('*','queryCurrencyMaster','status=1 and deletestatus=0 and name!="" order by name asc');
										while( $currecyData = mysqli_fetch_assoc($rscc)){
											if($editresult['currencyId']=='0' || $editresult['currencyId']==''){
												$currencyId = $baseCurrencyId;
											}else{
												$currencyId = $editresult['currencyId'];
											}
										?>
										<option value="<?php echo $currecyData['id']; ?>" <?php if ($currecyData['id'] == $currencyId) { ?> selected="selected" <?php } ?>><?php echo $currecyData['name']; ?></option>
										<?php } ?>

									</select>

								</label>

							</div>
						</td> 

							<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?> >
							<div class="griddiv"><label>

									<div class="gridlable isOptMandatory" style="width:100%;">Adult Cost</div>

									<input type="text" id="adultCostOpt" name="adultCost" class="gridfield " autocomplete="off" value="<?php echo $editresult['adultCost']; ?>" displayname="Adult Cost">

								</label>

							</div>
						</td>

						<td class="isTourOptCost" <?php if($editresult['isOptTours']!=1){ ?> style="display:none;" <?php } ?> >
							<div class="griddiv"><label>

									<div class="gridlable" style="width:100%;">Child Cost </div>

									<input type="text" id="childCost" name="childCost" class="gridfield " autocomplete="off" value="<?php echo $editresult['childCost']; ?>" displayname="Child Cost">

								</label>

							</div>
						</td>
							</tr>


							
					<script>

						function isOptionalTours(){
						
								var isOptTours = $("#isOptTours").val();
								if(isOptTours=='1'){
									$(".isTourOptCost").show();
									$("#adultCostOpt").addClass('validate');
									$("#childCostOpt").addClass('validate');
									$(".isOptMandatory").append(`<span class="redmind"></span>`);
								}else{

									$(".isTourOptCost").hide();
									$("#adultCostOpt").removeClass('validate');
									$("#childCostOpt").removeClass('validate');
								}
						
						}

						isOptionalTours();
					</script>

						<tr>

							<td colspan="4">
								<div class="griddiv"><label>

										<div class="gridlable">Description</div>

										<textarea name="otherActivityDetail" rows="5" class="gridfield" id="otherActivityDetail"><?php echo stripslashes($editresult['otherActivityDetail']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td colspan="4">
								<div class="griddiv"><label>

										<div class="gridlable" style="width: 44%;">Inclusions / Exclusions & Timing</div>

										<textarea name="inclExclTim" rows="5" class="gridfield" id="inclExclTim"><?php echo stripslashes($editresult['inclExclTim']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>
						<tr>

							<td colspan="4">
								<div class="griddiv"><label>

										<div class="gridlable">Important Note</div>

										<textarea name="impNote" rows="5" class="gridfield" id="impNote"><?php echo stripslashes($editresult['impNote']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_otherActivityMaster" />

					<input name="otherActivityImage2" type="hidden" id="otherActivityImage2" value="<?php echo $editresult['otherActivityImage']; ?>" />

				</form>
				
		<script src="tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
				selector: "#otherActivityDetail"
			});   
		</script>
		
		<script type="text/javascript">
			tinymce.init({
				selector: "#inclExclTim"
			});   
		</script>
		
		<script type="text/javascript">
			tinymce.init({
				selector: "#impNote"
			});   
		</script>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }







if ($_GET['action'] == 'addedit_enroutemaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_ENROUTE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Enroute </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td width="100%" colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Enroute&nbsp;Name<span class="redmind"></span></div>

										<input name="enrouteName" type="text" class="gridfield validate" id="enrouteName" displayname="Enroute Name" value="<?php echo strip($editresult['enrouteName']); ?>" />

									</label>

								</div>
							</td>



						</tr>

						<tr>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Currency<span class="redmind"></span></div>

										<select id="currencyId" name="currencyId" class="gridfield " displayname="Currency" autocomplete="off" style="width: 100%;">

											<option value="">Select</option>

											<?php



											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' deletestatus=0 and status=1 order by name asc';

											$rs = GetPageRecord($select, _QUERY_CURRENCY_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {



											?>

												<?php if ($editresult['currencyId'] != '') { ?>

													<option value="<?php echo strip($resListing['id']); ?>" <?php if ($editresult['currencyId'] == $resListing['id']) {
																												echo "selected='selected'";
																											} ?>><?php echo strip($resListing['name']); ?></option>

												<?php } else { ?>

													<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['setDefault'] == 1) {
																												echo "selected='selected'";
																											} ?>><?php echo strip($resListing['name']); ?></option>

												<?php } ?>

											<?php } ?>

										</select>
							</td>



							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Per Pax Cost<span class="redmind"></span></div>

										<input name="adultCost" type="text" class="gridfield number_only " id="adultCost" displayname="Per Pax Cost" value="<?php echo strip($editresult['adultCost']); ?>" />

									</label>

								</div>
							</td>

						</tr>

						<script>
							$('.number_only').bind('keyup paste', function() {

								this.value = this.value.replace(/[^0-9]/g, '');

							});
						</script>

						<tr>

							<!-- <td width="50%" ><div class="griddiv"><label>

				<div class="gridlable">Photo</div>

				<input name="enrouteImage" type="file" class="gridfield" id="enrouteImage"/>

				</label>

				</div></td> -->
							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Destination<span class="redmind"></span></div>

										<select id="enrouteCity" name="enrouteCity" class="gridfield validate" displayname="Destination" autocomplete="off">

											<option value="">Select</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' 1 and deletestatus=0 order by name asc';

											$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

											?>

												<option value="<?php echo ($resListing['name']); ?>" <?php if ($resListing['name'] == $editresult['enrouteCity']) { ?>selected="selected" <?php } ?>><?php echo ($resListing['name']); ?></option>

											<?php } ?>

										</select>

									</label>

								</div>
							</td>
							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Default</div>

										<select id="isDefault" name="isDefault" class="gridfield " autocomplete="off">

											<option value="0" <?php if ($editresult['isDefault'] == '0') { ?> selected="selected" <?php } ?>>No</option>

											<option value="1" <?php if ($editresult['isDefault'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

										</select>

									</label>

								</div>
							</td>



						</tr>

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Description</div>

										<textarea name="enrouteDetail" rows="5" class="gridfield" id="enrouteDetail"><?php echo strip($editresult['enrouteDetail']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Status</div>

										<select id="status" name="status" class="gridfield " autocomplete="off">

											<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

										</select>

									</label>

								</div>
							</td>

						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_enrouteMaster" />

					<input name="enrouteImage2" type="hidden" id="enrouteImage2" value="<?php echo $editresult['enrouteImage']; ?>" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }







if ($_GET['action'] == 'addedit_tourmanager') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="' . $id . '"';

		$rs1 = GetPageRecord($select1, 'tourmanager', $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Tour Escort </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">



						<td colspan="2">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />

								</label>

							</div>

						</td>

						<tr />

						<tr>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">Mobile&nbsp;Number<span class="redmind"></span></div>

										<input name="phone" type="text" class="gridfield validate" id="phone" displayname="Phone" value="<?php echo strip($editresult['phone']); ?>" />

									</label>

								</div>

							</td>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">WhatsApp&nbsp;Number<span class="redmind"></span></div>

										<input name="whatsappphone" type="text" class="gridfield validate" id="whatsappphone" displayname="Whatsapp Phone" value="<?php echo strip($editresult['whatsappphone']); ?>" />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">Alternate&nbsp;Number<span class="redmind"></span></div>

										<input name="alternatephone" type="text" class="gridfield validate" id="alternatephone" displayname="Alternate Phone" value="<?php echo strip($editresult['alternatephone']); ?>" />

									</label>

								</div>

							</td>



							<td width="50%">

								<div class="griddiv"><label>

										<div class="gridlable">Email<span class="redmind"></span></div>

										<input name="email" type="email" class="gridfield validate" id="email" displayname="Email" value="<?php echo strip($editresult['email']); ?>" required />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Address<span class="redmind"></span></div>

										<input name="address" type="text" class="gridfield validate" id="address" displayname="Address" value="<?php echo strip($editresult['address']); ?>" />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td width="50%">

								<div class="griddiv">

									<div class="gridlable">Select&nbsp;Destination<span class="redmind"></span></div>

									<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 85px;overflow: auto;">

										<table width="100%" border="0" cellpadding="5" cellspacing="0">



											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' name!="" and deletestatus=0 order by id asc';

											$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

												$destinationListArray = array_map('trim', explode(",", $editresult['destinationList']));



											?>

												<tr>

													<td colspan="2"><label><input name="destinationList[]" type="checkbox" class="Checkedrmtype" style="display: block;" value="<?php echo $resListing['id']; ?>" <?php if (in_array($resListing['id'], $destinationListArray)) { ?> checked="checked" <?php } ?> />

														</label></td>

													<td width="96%"><?php echo $resListing['name']; ?></td>

												</tr>

											<?php } ?>



										</table>

									</div>

								</div>



							</td>

							<td width="50%">



								<div class="griddiv">

									<div class="gridlable">Select&nbsp;Language<span class="redmind"></span></div>

									<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 85px;overflow: auto;">

										<table width="100%" border="0" cellpadding="5" cellspacing="0">

											<tr>

												<td colspan="2"><label>

														<input type="checkbox" id="checkallLang" style="display: block;">

													</label>

												</td>

												<td width="96%"><label for="checkallLang">Select All</label></td>

											</tr>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' name!="" and deletestatus=0 order by id asc';

											$rs = GetPageRecord($select, _LANGUAGE_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

												$languageListArray = array_map('trim', explode(",", $editresult['languageList']));



											?>

												<tr>

													<td colspan="2"><label><input name="languageList[]" type="checkbox" class="Checkedrmtype" style="display: block;" value="<?php echo $resListing['id']; ?>" <?php if (in_array($resListing['id'], $languageListArray)) { ?> checked="checked" <?php } ?> />

														</label></td>

													<td width="96%"><?php echo $resListing['name']; ?></td>

												</tr>

											<?php } ?>



										</table>

									</div>

								</div>



							</td>

						</tr>

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Detail</div>

										<textarea name="description" rows="5" class="gridfield" id="description"><?php echo strip($editresult['description']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Photo</div>

										<input name="image" type="file" class="gridfield" id="image" />

									</label>

								</div>
							</td>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Status</div>

										<select id="status" name="status" class="gridfield " autocomplete="off">

											<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

										</select>

									</label>

								</div>

							</td>

						</tr>



					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_tourmanager" />

					<input name="image2" type="hidden" id="image2" value="<?php echo $editresult['image']; ?>" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_guidemaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="' . $id . '"';

		$rs1 = GetPageRecord($select1, _GUIDE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<script type="text/javascript" src="plugins/select2/select2.min.js"></script>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Tour Escort/TOUR MANAGER</h1>
			<script>
				// $('#serviceType').change(function()
				// {
				if ($('#serviceType').val() == 2) {
					$('.forHide').hide();
				} else {
					$('.forHide').show();
				}
				// });
				$('#serviceType').on('change', function() {
					// alert($('#serviceType').val());
					if ($('#serviceType').val() == 2) {
						$('.forHide').hide();
					} else {
						$('.forHide').show();
					}
				})
			</script>
			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<td width="50%">

							<div class="griddiv">

								<label>

									<div class="gridlable">Service Type</div>

									<select id="serviceType" name="serviceType" class="gridfield " autocomplete="off">

										<option value="0" <?php if ($editresult['serviceType'] == '0') { ?> selected="selected" <?php } ?>>Tour Escort</option>

										<!-- <option value="1" <?php if ($editresult['serviceType'] == '1') { ?> selected="selected"<?php } ?>>Porter</option>  -->

										<option value="2" <?php if ($editresult['serviceType'] == '2') { ?> selected="selected" <?php } ?>>Tour Manager</option>

									</select>

								</label>

							</div>

						</td>

						<td width="50%">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />

								</label>

							</div>

						</td>

						<tr>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">Mobile&nbsp;Number<span class="redmind"></span></div>

										<input name="phone" type="text" class="gridfield validate" id="phone" displayname="Phone" value="<?php echo strip($editresult['phone']); ?>" />

									</label>

								</div>

							</td>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">WhatsApp&nbsp;Number</div>

										<input name="whatsappphone" type="text" class="gridfield  " id="whatsappphone" displayname="Whatsapp Phone" value="<?php echo strip($editresult['whatsappphone']); ?>" />

									</label>

								</div>

							</td>

						<tr>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">Alternate&nbsp;Number</div>

										<input name="alternatephone" type="text" class="gridfield  " id="alternatephone" displayname="Alternate Phone" value="<?php echo strip($editresult['alternatephone']); ?>" />

									</label>

								</div>

							</td>
							<td width="50%">

								<div class="griddiv"><label>

										<div class="gridlable">Email<span class="redmind"></span></div>

										<input name="email" type="email" class="gridfield validate" id="email" displayname="Email" value="<?php echo strip($editresult['email']); ?>" required />

									</label>

								</div>

							</td>

						<tr class='forHide'>

							<td width="50%">

								<div class="griddiv"><label>

										<div class="gridlable">Tour Escort&nbsp;License</div>

										<input name="guideLicence" type="text" class="gridfield " id="guideLicence" displayname="guideLicence" value="<?php echo strip($editresult['guideLicence']); ?>" />

									</label>

								</div>

							</td>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">License&nbsp;Expiry</div>

										<input name="licenceExpiry" type="text" class="gridfield " id="licenceExpiry" displayname="guideLicence" value="<?php if ($editresult['licenceExpiry'] != '01-01-1970' && $editresult['licenceExpiry'] != '' && $editresult['licenceExpiry'] != '0') {
																																							echo date('d-m-Y', strtotime($editresult['licenceExpiry']));
																																						} ?>" />

									</label>

									<script src="js/zebra_datepicker.js"></script>

									<script type="text/javascript">
										$('#licenceExpiry').Zebra_DatePicker({

											format: 'd-m-Y',

										});
									</script>

								</div>
							</td>
						</tr>

						<tr>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Destination<span class="redmind"></span></div>

										<select name="destinationId[]" multiple="multiple" class="gridfield js-example-basic-multiple validate" id="destinationId" displayname="Destination" autocomplete="off" style=" width:160px;">

											<option value="all" <?php if ($editresult['destinationType'] == 1) { ?> selected="selected" <?php } ?>>All</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' deletestatus=0 and status=1 order by name asc';

											$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

												$destId = explode(',', $editresult['destinationList']);
												//print_r($destId);
											?>

												<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($destId as $val) { if ($val == strip($resListing['id'])) { ?> selected="selected" <?php }} ?>><?php echo strip($resListing['name']); ?></option>

											<?php } ?>

										</select>

									</label>

								</div>
							</td>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Language</div>

										<select id="languageList" name="languageList[]" multiple="multiple" class="gridfield js-example-basic-multiple" autocomplete="off">

											<?php

											$rs = GetPageRecord('*', _LANGUAGE_MASTER_, ' name!="" and deletestatus=0 order by id asc');

											while ($resListing = mysqli_fetch_array($rs)) {

												$languageListArray = explode(",", $editresult['languageList']);

											?>

												<option value="<?php echo $resListing['id']; ?>" <?php foreach ($languageListArray as $val) {
																										if ($resListing['id'] == $val) { ?> selected="selected" <?php }
																																														} ?>><?php echo $resListing['name']; ?></option>

											<?php } ?>

										</select>

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td>
								<div class="griddiv"><label>

										<div class="gridlable">Tour Escort/Tour Manager&nbsp;Image</div>

										<input name="guideImage" type="file" class="gridfield" id="guideImage" />

									</label>

								</div>

							</td>

							<td class='forHide'>
								<div class="griddiv"><label>

										<div class="gridlable">supplier</div>

										<select id="supplier" name="supplier" class="gridfield " autocomplete="off">

											<option value="1" <?php if ($editresult['supplier'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>

											<option value="0" <?php if ($editresult['supplier'] == '0') { ?> selected="selected" <?php } ?>>No</option>

										</select>

									</label>

								</div>
							</td>

						</tr>

						<tr class='forHide'>

							<td>
								<div class="griddiv"><label>

										<div class="gridlable">Tour Escort&nbsp;Licence</div>

										<input name="gstn" type="text" class="gridfield" id="gstn" />

									</label>

								</div>

							</td>

							<td>
								<div class="griddiv"><label>

										<div class="gridlable">Contact&nbsp;Person</div>

										<input name="contactPerson" type="text" class="gridfield" id="contactPerson" />

									</label>

								</div>

							</td>

						</tr>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Designation</div>

										<input name="designation" type="text" class="gridfield" id="designation" />

									</label>

								</div>

							</td>

						</tr>

						<tr>

							<td width="50%">
								<div class="griddiv">

									<label>

										<div class="gridlable">Country<span class="redmind"></span></div>

										<select id="countryId2" name="countryId2" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selectstate();">

											<option value="">Select</option>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' deletestatus=0 and status=1 order by name asc';

											$rs = GetPageRecord($select, _COUNTRY_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

											?>

												<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['countryId']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

											<?php } ?>

										</select>
									</label>

								</div>
							</td>

							<td>
								<div class="griddiv">

									<label>

										<div class="gridlable">State </div>

										<select id="stateId2" name="stateId2" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();">
											<?php 
											$select=''; 
											$where=''; 
											$rs='';  
											$select='*'; 
											if($stateId!=''){
											$stateId=' and stateId="'.$stateId.'" ';
											}   
											$where=' deletestatus=0 and status=1 '.$stateId.' order by name asc';  
											$rs=GetPageRecord($select,'cityMaster',$where); 
											while($resListing=mysqli_fetch_array($rs)){  
											
											?>
											<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['stateId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
											<?php } ?>
											
											
									
										</select>
									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td width="50%">
								<div class="griddiv">

									<label>

										<div class="gridlable">City </div>

										<select id="cityId2" name="cityId2" class="gridfield" displayname="City" autocomplete="off">

										</select>
									</label>

								</div>
							</td>

							<td>
								<div class="griddiv"><label>

										<div class="gridlable">Pin&nbsp;Code </div>

										<input name="pinCode2" type="text" class="gridfield" id="pinCode" value="<?php echo $editpinCode; ?>" maxlength="15" />

									</label>

								</div>
							</td>

						</tr>

						<script>
						

							function selectcity() {

								var stateId = $('#stateId2').val();

								$('#cityId2').load('loadcity.php?id=' +stateId+ '&selectId=<?php echo $editresult['cityId']; ?>');

							}
							

							function selectstate() {

								var countryId = $('#countryId2').val();

								$('#stateId2').load('loadstate.php?action=loadescortstate&id=' + countryId + '&selectId=<?php echo $editresult['stateId']; ?>');

							}

							

							selectcity();
								selectstate();
						</script>

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Detail</div>

										<textarea name="description" rows="5" class="gridfield" id="description" style="max-height: 50px;"><?php echo strip($editresult['description']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Address<span class="redmind"></span></div>

										<input name="address" type="text" class="gridfield validate" id="address" displayname="Address" value="<?php echo strip($editresult['address']); ?>" />

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td colspan="2">

								<div class="griddiv">

									<label>

										<div class="gridlable">status<span class="redmind"></span></div>

										<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

											<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

										</select>
									</label>

								</div>











							</td>

							<td width="50%">&nbsp; </td>

						</tr>



					</table>



					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_guidemaster" />

					<input name="guideImage2" type="hidden" id="guideImage2" value="<?php echo $editresult['image']; ?>" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

		<script>
			$(document).ready(function() {

				$('.js-example-basic-multiple').select2();

			});
		</script>

		<style>
			.select2-container {

				width: 100% !important;
			}



			#alertnotificationsmainbox .select2-container .select2-search--inline {

				display: block;

				width: 100% !important;

			}



			.select2-container--open {

				z-index: 9999999
			}

			.select2-container .select2-selection--single {

				height: 35px;

			}

			.addeditpagebox .griddiv .gridlable {

				display: block;

			}

			.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

				width: 100% !important;

			}

			#alertnotificationsmainbox .select2-search__field {

				padding: 6px !important;

				width: 100% !important;

				border: 1px solid #ccc;
			}
		</style>

	<?php

}



if ($_GET['action'] == 'addedit_guidecatmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="' . $id . '"';

		$rs1 = GetPageRecord($select1, _GUIDE_CAT_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Tour Escort CATEGORY</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">



						<td colspan="2">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />

								</label>

							</div>

						</td>

						<tr />

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Price<span class="redmind"></span></div>

										<input name="price" type="text" class="gridfield " id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />

									</label>

								</div>

							</td>

						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_guidecatmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_guidesubcatmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="' . $id . '"';

		$rs1 = GetPageRecord($select1, _GUIDE_SUB_CAT_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> TOUR ESCORT SERVICE</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>
					 	<td width="50%">
							<div class="griddiv">
								<label>
								<div class="gridlable">Service&nbsp;Type<span class="redmind"></span></div>
								<select id="serviceType" name="serviceType" class="gridfield " autocomplete="off"  onchange="getServiceType(this.value);" >
    								<option value="0" <?php if($guideData['id']==$editresult['serviceType']){ ?> selected="selected"<?php } ?> >Guide</option>
										<option value="1" <?php if($guideData['id']==$editresult['serviceType']){ ?> selected="selected"<?php } ?> >Porter</option> 
   								</select> 
								</label>
							</div>
				  	  	</td>
				  	  	<td width="50%">
							<div class="griddiv">
								<label>
								<div class="gridlable">Destination<span class="redmind"></span></div>
								<select id="destinationId" name="destinationId" class="gridfield">
    								<option value="0" <?php if($editresult['destinationId']==0){ ?> selected="selected"<?php } ?> >All</option>
    								<?php 
    								$desSql = '';
    								$desSql = GetPageRecord('*',_DESTINATION_MASTER_,' 1 and deletestatus=0 and status=1 order by name asc');
    								while($destData = mysqli_fetch_array($desSql)){ ?>
											<option value="<?php echo $destData['id']; ?>" <?php if($destData['id']==$editresult['destinationId']){ ?> selected="selected"<?php } ?> ><?php echo $destData['name']; ?></option> 
    								<?php } ?>
   								</select> 
								</label>
							</div>
					  	  </td>
						</tr>

						<tr>



							<td colspan="2">



								<div class="griddiv"><label>



										<div class="gridlable">Tour Escort&nbsp;Service<span class="redmind"></span></div>



										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />



									</label>



								</div>



							</td>



						</tr>

						<tr colspan="2">

							<td>

								<div class="griddiv"><label>

										<div class="gridlable">status</div>

										<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

											<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

										</select>
									</label>

								</div>

							</td>
							<td>
								<div class="griddiv"><label>

										<div class="gridlable">Default</div>

										<select id="isDefault" type="text" class="gridfield" name="isDefault" displayname="Default" autocomplete="off" style="width: 100%;">

											<option value="0" <?php if ($editresult['isDefault'] == '0') { ?>selected="selected" <?php } ?>>No</option>

											<option value="1" <?php if ($editresult['isDefault'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>

										</select>
									</label>

								</div>

							</td>

						</tr>


					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_guidesubcatmaster" />

				</form>



			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_guideservicepricemaster') {



	if ($_GET['editId'] != '') {

		$editId = clean($_GET['editId']);

		$select1 = '*';

		$where1 = 'id="' . $editId . '"';

		$rs1 = GetPageRecord($select1, _GUIDE_SER_PRICE_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>



		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> TOUR ESCORT CATEGORY</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Name<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />

									</label>

								</div>

							</td>

						</tr>

						<tr>

							<td colspan="2">

								<div class="griddiv">

									<label>

										<div class="gridlable">Category</div>

										<select id="guidecategory" name="guidecategory" class="gridfield " autocomplete="off">

											<?php

											$select1 = '*';

											$where1 = ' 1 order by id desc';

											$rs1 = GetPageRecord($select1,_GUIDE_CAT_MASTER_, $where1);

											while ($editresult1 = mysqli_fetch_array($rs1)) { ?>

												<option value="<?php echo $editresult1['id']; ?>" <?php if ($editresult1['id'] == $editresult['category']) { ?> selected="selected" <?php } ?>><?php echo $editresult1['name']; ?></option>

											<?php } ?>

										</select>

									</label>

								</div>

							</td>

						</tr>

						<tr>

							<td colspan="2">

								<div class="griddiv">

									<label>

										<div class="gridlable">Sub Category</div>

										<select id="guidesubcategory" name="guidesubcategory" class="gridfield " autocomplete="off">

											<?php

											$select2 = '*';

											$where2 = ' 1 order by id desc';

											$rs2 = GetPageRecord($select2, _GUIDE_SUB_CAT_MASTER_, $where2);

											while ($editresult2 = mysqli_fetch_array($rs2)) { ?>

												<option value="<?php echo $editresult2['id']; ?>" <?php if ($editresult2['id'] == $editresult['subcategory']) { ?> selected="selected" <?php } ?>><?php echo $editresult2['name']; ?></option>

											<?php } ?>

										</select>

									</label>

								</div>

							</td>

						</tr>

						<tr>


							<td colspan="2">

								<div class="griddiv">

									<label>

										<div class="gridlable">Price<span class="redmind"></span></div>

										<input name="price" type="text" class="gridfield " id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Status</div>

										<select id="status" name="status" class="gridfield " autocomplete="off">

											<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

										</select>

									</label>

								</div>

							</td>

						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $editId; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_guideservicepricemaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}



if ($_GET['action'] == 'addedit_inboundmealplanmaster' && $_GET['sectiontype'] == 'quotations' && $_GET['queryId'] != '') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _INBOUND_MEALPLAN_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$mealPlanName = clean($editresult['mealPlanName']);





		$adultCost = clean($editresult['adultCost']);

		$childCost = clean($editresult['childCost']);
	}

	$where2 = '';

	$rs2 = '';

	$select2 = '*';

	$where2 = 'id="' . $_GET['queryId'] . '" ';

	$rs2 = GetPageRecord($select2, _QUOTATION_MASTER_, $where2);

	$resultpage2 = mysqli_fetch_array($rs2);

	$fromDate2 = date("d-m-Y", strtotime($resultpage2['fromDate']));

	$toDate2 = date("d-m-Y", strtotime($resultpage2['toDate']));



	?>

		<style>
			.addeditpagebox .griddiv .gridlable {

				width: 100%;

			}

			.newtowrobox .griddiv {
				width: 23% !important;

				display: inline-block;

				margin: 8px;
			}
		</style>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Restaurant Quotation</h1>

			<div id="contentbox" class="addeditpagebox newtowrobox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">



					<div class="griddiv">

						<label>

							<div class="">Meal Type<span class="redmind"></span></div>

							<select id="mealPlanType" name="mealPlanType" class="gridfield validate" displayname="city" autocomplete="off">

								<option value="">Select Meal Type</option>

								<option value="1" <?php if ($editresult['mealPlanType'] == '1') { ?> selected="selected" <?php } ?>>Lunch</option>

								<option value="2" <?php if ($editresult['mealPlanType'] == '2') { ?> selected="selected" <?php } ?>>Dinner</option>

							</select>

						</label>

					</div>



					<div class="griddiv">

						<label>

							<div class="gridlable">Meal Name<span class="redmind"></span></div>

							<input name="mealPlanName" type="text" class="gridfield validate" id="mealPlanName22" displayname="Name" value="<?php echo $mealPlanName; ?>" maxlength="100" />

						</label>

					</div>



					<div class="griddiv"><label>

							<div class="gridlable">Per Pax Cost</div>

							<input name="adultCost" type="number" class="gridfield" id="adultCost22" displayname="Per Pax Cost" value="<?php echo $adultCost; ?>" />

						</label>

					</div>





					<div class="griddiv"><label>

							<div class="gridlable">Date of Meal</div>

							<input name="dateMealPlan" type="text" id="dateMealPlan22" class="gridfield" displayname="dd-mm-yyyy" value="" />

						</label>

					</div>

					<script src="js/jquery-1.11.3.min.js"></script>

					<script src="js/zebra_datepicker.js"></script>

					<script type="text/javascript">
						$('#dateMealPlan22').Zebra_DatePicker({

							direction: ['<?php echo $fromDate2; ?>', '<?php echo $toDate2; ?>'],

							format: 'd-m-Y',

						});
					</script>

					<style>
						.newtowrobox .griddiv {

							width: 18% !important;

							display: inline-block;

							margin: 8px;

						}
					</style>

					<input name="status" type="hidden" id="status" value="1" />

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="queryId" type="hidden" id="queryId" value="<?php echo $_GET['queryId']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_inboundmealplanmaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>





	<?php

}

if ($_GET['action'] == 'addedit_subjectmaster' && $_GET['sectiontype'] == 'subjectmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'iti_subjectmaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Subject Master</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">From Destination</div>

							<select id="fromDestinationId" name="fromDestinationId" class="gridfield validates" displayname="From Destination" autocomplete="off">

								<option value="first_day">None</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' deletestatus=0 and status=1 order by name asc';

								$rs = GetPageRecord($select, 'destinationMaster', $where);

								while ($resListing = mysqli_fetch_array($rs)) {

								?>

									<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['fromDestinationId']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>



					<div class="griddiv"><label>

							<div class="gridlable">To Destination<span class="redmind"></span></div>

							<select id="toDestinationId" name="toDestinationId" class="gridfield validate" displayname="To Destination" autocomplete="off">

								<option value="">Select</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' deletestatus=0 and status=1 order by name asc';

								$rs = GetPageRecord($select, 'destinationMaster', $where);

								while ($resListing = mysqli_fetch_array($rs)) {

								?>

									<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['toDestinationId']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<div class="griddiv">

						<label>

							<div class="gridlable">Transfer Mode<span class="redmind"></span></div>

							<select id="transferMode" name="transferMode" class="gridfield validate" displayname="Transfer Mode" autocomplete="off">

								<option value="Surface" <?php if ($editresult['transferMode'] == "Surface") { ?> selected="selected" <?php } ?>>Surface</option>

								<option value="Train" <?php if ($editresult['transferMode'] == "Train") { ?> selected="selected" <?php } ?>>Train</option>

								<option value="Flight" <?php if ($editresult['transferMode'] == "Flight") { ?> selected="selected" <?php } ?>>Flight</option>

							</select>

						</label>

					</div>

					<div class="griddiv">

						<label>

							<div class="gridlable" style="width: 100%;">Title&nbsp;(<strong style="color: #000;">Note</strong>:- Title and Description should be in english)<span class="redmind"></span></div>

							<input name="otherTitle" type="text" class="gridfield validate" id="otherTitle" displayname="Other Title" value="<?php echo $editresult['otherTitle']; ?>" maxlength="100" />

						</label>

					</div>

					<!-- distance add new field sec started  -->
					<div class="griddiv">

						<label>

							<div class="gridlable" style="width: 100%;">Driving Distance&nbsp;<span class=""></span></div>

							<input name="drivingDistance" type="text" class="gridfield " id="drivingDistance" displayname="Driving Distance" value="<?php echo $editresult['drivingDistance']; ?>" maxlength="100" />

						</label>

					</div>
					<!-- distance add new field sec Ended  -->


					<div class="griddiv">

						<label>

							<div class="gridlable">Description<span class="redmind"></span></div>

							<textarea name="description" rows="3" id="description21" class="" displayname="Itinerary&nbsp;Description" style="width:98%;"><?php echo stripslashes($editresult['description']); ?></textarea>

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">status</div>

							<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">

								<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>

								<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>

							</select>
						</label>

					</div>



					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_subjectmaster" />

				</form>

		<script src="tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
				selector: "#description21"
			});   
		</script>



			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php

}



if ($_GET['action'] == 'addedit_company_type' && $_GET['sectiontype'] == 'company_type') {







	if ($_GET['id'] != '') {



		$id = clean($_GET['id']);



		$select1 = '*';



		$where1 = 'id=' . $id . '';



		$rs1 = GetPageRecord($select1, 'businessTypeMaster', $where1);



		$editresult = mysqli_fetch_array($rs1);



		$name = clean($editresult['name']);
	}



	?>



		<div class="contentclass">



			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Business Type</h1>



			<div id="contentbox" class="addeditpagebox" style="  padding:0px; overflow:auto; text-align:left; margin-bottom:0px; margin-top:10px; ">



				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">



					<?php
						$editid = $_REQUEST['id'];
						if($editid!=2 && $editid!=1){ 
						$class='';
						?>
							<div class="griddiv"><label>
								<div class="gridlable">Business&nbsp;Type&nbsp;Name<span class="redmind"></span></div>
								<input name="name" type="text" <?php echo $class; ?> class="gridfield validate" id="name" displayname="Business&nbsp;Type&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />
							</label>
							</div>
					<?php }else{?>
							<div class="griddiv" style="display:none;"><label>
								<div class="gridlable">Business&nbsp;Type&nbsp;Name<span class="redmind"></span></div>
								<input name="name" type="text"  class="gridfield validate" id="name" displayname="Business&nbsp;Type&nbsp;Name" value="<?php echo $name; ?>" maxlength="100" />
								</label>
							</div>
						<?php }	?>


					<!-- select by default option in  started-->
					<div class="griddiv" style="padding-bottom: 4px;">
						<label>
							<div class="gridlable">Set Default<span class=""></span></div>
							<select name="setDefault" id="setDefault"  class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;"> 	
								<option value="0" <?php if($editresult['setDefault']==0 || $editresult['id']==0){ ?> selected="selected" <?php } ?>>No</option>
								<option value="1" <?php if($editresult['setDefault']==1 && isset($editresult['setDefault'])){ ?> selected="selected" <?php } ?>>Yes</option>

							</select></label>

						</label>
					</div>
					<!-- select by default option in  ended-->


					<div class="griddiv">



						<label>



							<div class="gridlable">status</div>



							<select name="status" type="text" class="gridfield " displayname="deletestatus" autocomplete="off" style="width: 100%;">



								<option value="1" <?php if ($editresult['status'] == 1 || $id == '') { ?> selected="selected" <?php } ?>>Active</option>



								<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>In Active</option>



							</select>
						</label>



					</div>



					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />



					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />



					<input name="action" type="hidden" id="action" value="addedit_company_type" />



				</form>











			</div>



			<div id="buttonsbox" style="text-align:center;">



				<table border="0" align="right" cellpadding="0" cellspacing="0">



					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>



						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>



					</tr>



				</table>



			</div>



		</div>



	<?php



}



if ($_GET['action'] == 'addedit_itinerarydescription' && $_GET['sectiontype'] == 'itinerarydescription') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'itineraryDescriptionMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?>Itinerary Description</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">From Destination<span class="redmind"></span></div>

							<select id="fromDestinationId" name="fromDestinationId" class="gridfield" displayname="From Destination" autocomplete="off">

								<option value="first_day">First&nbsp;Day</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' deletestatus=0 and status=1 order by name asc';

								$rs = GetPageRecord($select, 'destinationMaster', $where);

								while ($resListing = mysqli_fetch_array($rs)) {

								?>

									<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['fromDestinationId']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>



					<div class="griddiv"><label>

							<div class="gridlable">To Destination<span class="redmind"></span></div>

							<select id="toDestinationId" name="toDestinationId" class="gridfield validate" displayname="To Destination" autocomplete="off">

								<option value="">Select</option>

								<?php

								$select = '';

								$where = '';

								$rs = '';

								$select = '*';

								$where = ' deletestatus=0 and status=1 order by name asc';

								$rs = GetPageRecord($select, 'destinationMaster', $where);

								while ($resListing = mysqli_fetch_array($rs)) {

								?>

									<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['toDestinationId']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<div class="griddiv">

						<label>

							<div class="gridlable">Description<span class="redmind"></span></div>

							<textarea name="description" rows="3" id="description" class="validate" displayname="Itinerary&nbsp;Description" style="width:98%;"><?php echo stripslashes($editresult['description']); ?></textarea>

						</label>

					</div>

					<div class="griddiv">

						<label>

							<div class="gridlable">Photo</div>

							<input name="image" type="file" class="gridfield <?php if (editresult['image'] == '') { ?> validate<?php } ?>" displayname="Description Image" id="image" value="<?php echo $editresult['image']; ?>" />

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Status</div>

							<select id="status" name="status" class="gridfield " autocomplete="off">

								<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

								<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

							</select>

						</label>

					</div>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_itinerarydescription" />

					<input name="image2" type="hidden" id="image2" value="<?php echo $editresult['image']; ?>" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>





	<?php }

if ($_GET['action'] == 'addedit_languagemaster' && $_GET['sectiontype'] == 'languagemaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'tbl_languagemaster', $where1);

		$editresult = mysqli_fetch_array($rs1);

		$name = clean($editresult['name']);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Language</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv"><label>

							<div class="gridlable">Name<span class="redmind"></span></div>

							<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" <?php if ($_REQUEST['id'] != '') {
																																									echo "readonly";
																																								} ?> />

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Status</div>

							<select id="status" name="status" class="gridfield " autocomplete="off">

								<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

								<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

							</select>

						</label>

					</div>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_languagemaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }

if ($_GET['action'] == 'addedit_weekendmaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, _WEEKEND_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);

		$weekendDays = $editresult['weekendDays'];

		$finalweekendDays = explode(',', $weekendDays);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Weekend </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv">

						<label>

							<div class="gridlable">Weekend Name</div>

							<input name="named" type="text" class="gridfield" id="named" value="<?php echo $editresult['name']; ?>" />

						</label>

					</div>



					<div class="griddiv"><label>

							<div class="gridlable">Weekend Days</div>

							<select name="daysname[]" size="1" multiple="multiple" class="gridfield select2" id="daysname" displayname="Weekent Name" autocomplete="off">

								<?php

								$rs = GetPageRecord('*', 'weekendDaysMaster', ' deleteStatus=0 order by name asc');

								while ($resListing = mysqli_fetch_array($rs)) {  ?>

									<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($finalweekendDays as $key => $value) {
																								if ($value == $resListing['id']) {
																									echo 'selected="selected"';
																								}
																							} ?>><?php echo strip($resListing['name']); ?></option>

								<?php } ?>

							</select>

						</label>

					</div>

					<script src="plugins/select2/select2.full.min.js"></script>

					<script>
						$(document).ready(function() {

							$('.select2').select2();



						});
					</script>

					<style>
						.select2-container--open {

							z-index: 9999999999 !important;

							width: 100%;

						}

						.select2-container {

							box-sizing: border-box;

							display: inline-block;

							margin: 0;

							position: relative;

							vertical-align: middle;

							width: 100% !important;

						}
					</style>



					<div class="griddiv"><label>

							<div class="gridlable">Status</div>

							<select id="status" name="status" class="gridfield " autocomplete="off">

								<option value="1" <?php if ($editresult['status'] == 1 && isset($editresult['status'])) { ?> selected="selected" <?php } ?>>Active</option>
								<option value="0" <?php if ($editresult['status'] == 0 && isset($editresult['status'])) { ?> selected="selected" <?php } ?>>Inactive</option>



							</select>

						</label>

					</div>





					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_weekendmaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }

if ($_GET['action'] == 'addedit_portermaster') {



	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="' . $id . '"';

		$rs1 = GetPageRecord($select1, _PORTER_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Porter </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">



						<td colspan="2">

							<div class="griddiv"><label>

									<div class="gridlable">Name<span class="redmind"></span></div>

									<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />

								</label>

							</div>

						</td>

						<tr />

						<tr>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">Mobile&nbsp;Number<span class="redmind"></span></div>

										<input name="phone" type="text" class="gridfield validate" id="phone" displayname="Phone" value="<?php echo strip($editresult['phone']); ?>" />

									</label>

								</div>

							</td>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">WhatsApp&nbsp;Number<span class="redmind"></span></div>

										<input name="whatsappphone" type="text" class="gridfield validate" id="whatsappphone" displayname="Whatsapp Phone" value="<?php echo strip($editresult['whatsappphone']); ?>" />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td width="50%">

								<div class="griddiv">

									<label>

										<div class="gridlable">Alternate&nbsp;Number<span class="redmind"></span></div>

										<input name="alternatephone" type="text" class="gridfield validate" id="alternatephone" displayname="Alternate Phone" value="<?php echo strip($editresult['alternatephone']); ?>" />

									</label>

								</div>

							</td>



							<td width="50%">

								<div class="griddiv"><label>

										<div class="gridlable">Email<span class="redmind"></span></div>

										<input name="email" type="email" class="gridfield validate" id="email" displayname="Email" value="<?php echo strip($editresult['email']); ?>" required />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Address<span class="redmind"></span></div>

										<input name="address" type="text" class="gridfield validate" id="address" displayname="Address" value="<?php echo strip($editresult['address']); ?>" />

									</label>

								</div>

							</td>

							<tr />

						<tr>

							<td width="50%">

								<div class="griddiv">

									<div class="gridlable">Select&nbsp;Destination<span class="redmind"></span></div>

									<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 85px;overflow: auto;">

										<table width="100%" border="0" cellpadding="5" cellspacing="0">



											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' name!="" and deletestatus=0 order by id asc';

											$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

												$destinationListArray = array_map('trim', explode(",", $editresult['destinationList']));



											?>

												<tr>

													<td colspan="2"><label><input name="destinationList[]" type="checkbox" class="Checkedrmtype" style="display: block;" value="<?php echo $resListing['id']; ?>" <?php if (in_array($resListing['id'], $destinationListArray)) { ?> checked="checked" <?php } ?> />

														</label></td>

													<td width="96%"><?php echo $resListing['name']; ?></td>

												</tr>

											<?php } ?>



										</table>

									</div>

								</div>



							</td>

							<td width="50%">



								<div class="griddiv">

									<div class="gridlable">Select&nbsp;Language<span class="redmind"></span></div>

									<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;height: 85px;overflow: auto;">

										<table width="100%" border="0" cellpadding="5" cellspacing="0">

											<tr>

												<td colspan="2"><label>

														<input type="checkbox" id="checkallLang" style="display: block;">

													</label>

												</td>

												<td width="96%"><label for="checkallLang">Select All</label></td>

											</tr>

											<?php

											$select = '';

											$where = '';

											$rs = '';

											$select = '*';

											$where = ' name!="" and deletestatus=0 order by id asc';

											$rs = GetPageRecord($select, _LANGUAGE_MASTER_, $where);

											while ($resListing = mysqli_fetch_array($rs)) {

												$languageListArray = array_map('trim', explode(",", $editresult['languageList']));



											?>

												<tr>

													<td colspan="2"><label><input name="languageList[]" type="checkbox" class="Checkedrmtype" style="display: block;" value="<?php echo $resListing['id']; ?>" <?php if (in_array($resListing['id'], $languageListArray)) { ?> checked="checked" <?php } ?> />

														</label></td>

													<td width="96%"><?php echo $resListing['name']; ?></td>

												</tr>

											<?php } ?>



										</table>

									</div>

								</div>



							</td>

						</tr>

						<tr>

							<td colspan="2">
								<div class="griddiv"><label>

										<div class="gridlable">Detail</div>

										<textarea name="description" rows="5" class="gridfield" id="description"><?php echo strip($editresult['description']); ?></textarea>

									</label>

								</div>
							</td>

						</tr>

						<tr>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Photo</div>

										<input name="image" type="file" class="gridfield" id="image" />

									</label>

								</div>
							</td>

							<td width="50%">
								<div class="griddiv"><label>

										<div class="gridlable">Status</div>

										<select id="status" name="status" class="gridfield " autocomplete="off">

											<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

										</select>

									</label>

								</div>

							</td>

						</tr>



					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_portermaster" />

					<input name="image2" type="hidden" id="image2" value="<?php echo $editresult['image']; ?>" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_portersubcatmaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="' . $id . '"';

		$rs1 = GetPageRecord($select1, _PORTER_SUB_CAT_MASTER_, $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Porter Price</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Porter&nbsp;Service<span class="redmind"></span></div>

										<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" />

									</label>

								</div>

							</td>

						</tr>

						<tr>

							<td colspan="2">

								<div class="griddiv">

									<label>

										<div class="gridlable">Day Type</div>

										<select id="dayType" name="dayType" class="gridfield " autocomplete="off">

											<option value="">Select None</option>

											<option value="halfday" <?php if ($editresult['dayType'] == 'halfday') { ?> selected="selected" <?php } ?>>Half Day</option>

											<option value="fullday" <?php if ($editresult['dayType'] == 'fullday') { ?> selected="selected" <?php } ?>>Full Day</option>

										</select>

									</label>

								</div>

							</td>

						</tr>



						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Price<span class="redmind"></span></div>

										<input name="price" type="text" class="gridfield " id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />

									</label>

								</div>

							</td>

						</tr>

						<tr>



							<td colspan="2">

								<div class="griddiv">

									<label>

										<div class="gridlable">Select&nbsp;Tour Escort</div>

										<select id="guideId" name="guideId" class="gridfield " autocomplete="off">

											<option value="">Select&nbsp;Tour Escort</option>

											<?php



											$rs2 = GetPageRecord('*', _PORTER_MASTER_, ' 1 ');

											while ($guideData = mysqli_fetch_array($rs2)) {

											?>

												<option value="<?php echo $guideData['id']; ?>" <?php if ($$guideData['id'] == $editresult['guideId']) { ?> selected="selected" <?php } ?>><?php echo $guideData['name']; ?></option>

											<?php } ?>

										</select>

									</label>

								</div>

							</td>

						</tr>

					</table>

					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_portersubcatmaster" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>

		</div>

	<?php

}

if ($_GET['action'] == 'addedit_nationalitymaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id=' . $id . '';

		$rs1 = GetPageRecord($select1, 'nationalityMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
	}

	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Nationality</h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<div class="griddiv">

						<label>

							<div class="gridlable">Country</div>

							<select id="countryName" name="countryName" class="gridfield" autocomplete="off" onchange="sortNamefun()">

								<option value="">Select&nbsp;Country</option>

								<?php

								$rs2 = GetPageRecord('*', 'countryMaster', '1');

								while ($guideData = mysqli_fetch_array($rs2)) {

								?>

									<option value="<?php echo $guideData['id']; ?>" <?php if ($guideData['id'] == $editresult['countryId']) { ?> selected="selected" <?php } ?>><?php echo $guideData['name']; ?></option>

								<?php } ?>

							</select>

						</label>

					</div>



					<div class="griddiv">

						<label>

							<div class="gridlable">Sort Name</div>

							<input id="sortName" name="sortName" type="text" class="gridfield" value="<?php echo $editresult['sortName']; ?>" readonly="" />



						</label>

					</div>



					<div class="griddiv">

						<label>

							<div class="gridlable">Type</div>

							<select id="type" name="type" class="gridfield" autocomplete="off" onchange="sortNamefun()">

								<option value="">Select&nbsp;Type</option>

								<option value="1" <?php if (1 == $editresult['type']) { ?> selected="selected" <?php } ?>>Indian</option>

								<option value="2" <?php if (2 == $editresult['type']) { ?> selected="selected" <?php } ?>>Foreign</option>

							</select>

						</label>

					</div>

					<script>
						function sortNamefun() {

							var countryName = $("#countryName").val();

							$("#sortName").load('getDataFromTable.php?action="getAllSortNameOfCountry"&countryId=' + countryName);

						}
					</script>

					<div class="griddiv">

						<label>

							<div class="gridlable">Name</div>

							<input name="name" type="text" class="gridfield" id="name" value="<?php echo $editresult['name']; ?>" />

						</label>

					</div>

					<div class="griddiv"><label>

							<div class="gridlable">Status</div>

							<select id="deleteStatus" name="deleteStatus" class="gridfield " autocomplete="off">

								<option value="0" <?php if ($editresult['deleteStatus'] == 0) { ?> selected="selected" <?php } ?>>Active</option>

								<option value="1" <?php if ($editresult['deleteStatus'] == 1) { ?> selected="selected" <?php } ?>>Inactive</option>

							</select>

						</label>

					</div>



					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

					<input name="action" type="hidden" id="action" value="addedit_nationalitymaster" />

				</form>





			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

						<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

					</tr>

				</table>

			</div>
		</div>





	<?php }

	?>

	<?php

	if ($_REQUEST['action'] == 'operationrestrictionType') {
	?>

		<div class="contentclass">

			<!--	<h1 style="text-align:left;">Operation Restriction</h1>-->

			<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="#" method="post" enctype="multipart/form-data" name="addrestrictiontype" target="addrestrictiontype" id="addmasters">



					<div class="griddiv"><label>

							<div class="gridlable">Service&nbsp;Type<span class="redmind"></span></div>

							<select id="operationrestrictiontype" name="" class="gridfield validate" autocomplete="off" displayname="Operation Restriction" onchange="javascript:location.href = this.value;">

								<option value="">Select&nbsp;Service</option>

								<option value="showpage.crm?module=hoteloperationrestrictionmaster">Hotel</option>

								<option value="showpage.crm?module=activityoperationrestrictionmaster">Sightseeing</option>

								<option value="showpage.crm?module=entranceoperationrestrictionmaster">Monument</option>

							</select>

						</label>

					</div>

					<script type="text/javascript">
						window.onload = function() {

							location.href = document.getElementById("operationrestrictiontype").value;

						}
					</script>

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<!--<td>

						<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addrestrictiontype','submitbtn','0');" />

					</td>-->

						<td style="padding-right:20px;">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>

		</div>

	<?php

	}

	?>

	<?php

	if ($_REQUEST['action'] == 'hotelrestriction' && $_REQUEST['id'] != '') {

	?>

		<div class="contentclass">

			<h1 style="text-align:left;">Add Operation Restriction </h1>

			<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="restriction" target="actoinfrm" id="restriction">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

										<input name="startDate" type="text" id="startDate_h" class="gridfield validate" displayname="From Date" autocomplete="off" />

									</label>

								</div>

							</td>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

										<input name="endDate" type="text" id="endDate_h" class="gridfield validate" displayname="End Date" autocomplete="off" />

									</label>

								</div>

							</td>

						</tr>

						<style>
							.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {



								width: 100% !important;



							}
						</style>

						<script>
							$('#startDate_h').Zebra_DatePicker({



								format: 'd-m-Y',



							});



							$('#endDate_h').Zebra_DatePicker({



								format: 'd-m-Y',



							});
						</script>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Reason<span class="redmind"></span></div>

										<textarea name="reason" rows="2" class="gridfield validate" id="reason"></textarea>

									</label>

								</div>

							</td>

						</tr>

						<input name="hotelId" type="hidden" value="<?php echo $_REQUEST['id'] ?>" />

						<input name="action" type="hidden" id="action" value="hotelrestriction" />

					</table>

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<td>

							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('restriction','submitbtn','0');" />

						</td>

						<td style="padding-right:20px;">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>
		</div>

	<?php

	}

	?>

	<?php

	if ($_REQUEST['action'] == 'edit_restrictions' && $_REQUEST['editId'] != '' && $_REQUEST['hotelId'] != '') {

		if ($_REQUEST['editId'] != '') {

			$editId = clean($_REQUEST['editId']);

			$select1 = '*';

			$where1 = 'id=' . $editId . '';

			$rs1 = GetPageRecord($select1, 'hoteloperationRestriction', $where1);

			$editresult = mysqli_fetch_array($rs1);
		}



	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['editId'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Operation Restriction </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

										<input name="startDate" type="text" class="gridfield validate" id="startDate" displayname="From Date" value="<?php if ($editresult['startDate'] != '01-01-1970' && $editresult['startDate'] != '' && $editresult['startDate'] != '0') {
																																							echo date('d-m-Y', strtotime($editresult['startDate']));
																																						} ?>" autocomplete="off" />

									</label>

								</div>

							</td>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

										<input name="endDate" type="text" class="gridfield validate" id="endDate" displayname="To Date" value="<?php if ($editresult['endDate'] != '01-01-1970' && $editresult['endDate'] != '' && $editresult['endDate'] != '0') {
																																					echo date('d-m-Y', strtotime($editresult['endDate']));
																																				} ?>" autocomplete="off" />

									</label>

								</div>

							</td>

						</tr>

						<style>
							.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {



								width: 100% !important;



							}
						</style>

						<script>
							$(document).ready(function() {



								$('#startDate').Zebra_DatePicker({



									format: 'd-m-Y',



								});



								$('#endDate').Zebra_DatePicker({



									format: 'd-m-Y',



								});



							});
						</script>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Reason<span class="redmind"></span></div>

										<textarea name="reason" rows="2" class="gridfield validate" id="reason"><?php echo $editresult['reason']; ?></textarea>

									</label>

								</div>

							</td>

						</tr>



						<input name="editId" type="hidden" value="<?php echo $_REQUEST['editId'] ?>" />

						<input name="hotelId" type="hidden" value="<?php echo $_REQUEST['hotelId'] ?>" />

						<input name="action" type="hidden" id="action" value="edit_restrictions" />

					</table>

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<td>

							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" />

						</td>

						<td style="padding-right:20px;">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>

		</div>

	<?php

	}

	?>

	<?php

	if ($_REQUEST['action'] == 'activityrestriction' && $_REQUEST['id'] != '') {

	?>

		<div class="contentclass">

			<h1 style="text-align:left;">Add Sightseeing Restriction </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="activity" target="actoinfrm" id="activity">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

										<input name="startDate" type="text" id="startDate_a" class="gridfield validate" displayname="From Date" autocomplete="off" />

									</label>

								</div>

							</td>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

										<input name="endDate" type="text" id="endDate_a" class="gridfield validate" displayname="End Date" autocomplete="off" />

									</label>

								</div>

							</td>

						</tr>

						<style>
							.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {



								width: 100% !important;



							}
						</style>

						<script>
							$('#startDate_a').Zebra_DatePicker({



								format: 'd-m-Y',



							});



							$('#endDate_a').Zebra_DatePicker({



								format: 'd-m-Y',



							});
						</script>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Reason<span class="redmind"></span></div>

										<textarea name="reason" rows="2" class="gridfield validate" id="reason"></textarea>

									</label>

								</div>

							</td>

						</tr>



						<input name="otheractivityId" type="hidden" value="<?php echo $_REQUEST['id'] ?>" />

						<input name="action" type="hidden" id="action" value="activityoperationrestriction" />

					</table>



			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<td>

							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('activity','submitbtn','0');" />

						</td>

						<td style="padding-right:20px;">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>

			</form>

		</div>

	<?php

	}

	?>

	<?php

	if ($_REQUEST['action'] == 'edit_activityrestrictions' && $_REQUEST['editId'] != '' && $_REQUEST['otheractivityId'] != '') {

		if ($_REQUEST['editId'] != '') {

			$editId = clean($_REQUEST['editId']);

			$select1 = '*';

			$where1 = 'id=' . $editId . '';

			$rs1 = GetPageRecord($select1, 'hoteloperationRestriction', $where1);

			$editresult = mysqli_fetch_array($rs1);
		}



	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['editId'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Sightseeing Restriction </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="editactivity" target="actoinfrm" id="editactivity">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

										<input name="startDate" type="text" class="gridfield validate" id="startDate" displayname="From Date" value="<?php if ($editresult['startDate'] != '01-01-1970' && $editresult['startDate'] != '' && $editresult['startDate'] != '0') {
																																							echo date('d-m-Y', strtotime($editresult['startDate']));
																																						} ?>" autocomplete="off" />

									</label>

								</div>

							</td>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

										<input name="endDate" type="text" class="gridfield validate" id="endDate" displayname="To Date" value="<?php if ($editresult['endDate'] != '01-01-1970' && $editresult['endDate'] != '' && $editresult['endDate'] != '0') {
																																					echo date('d-m-Y', strtotime($editresult['endDate']));
																																				} ?>" autocomplete="off" />

									</label>

								</div>

							</td>

						</tr>

						<style>
							.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {



								width: 100% !important;



							}
						</style>

						<script>
							$(document).ready(function() {



								$('#startDate').Zebra_DatePicker({



									format: 'd-m-Y',



								});



								$('#endDate').Zebra_DatePicker({



									format: 'd-m-Y',



								});



							});
						</script>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Reason<span class="redmind"></span></div>

										<textarea name="reason" rows="2" class="gridfield validate" id="reason"><?php echo $editresult['reason']; ?></textarea>

									</label>

								</div>

							</td>

						</tr>



						<input name="editId" type="hidden" value="<?php echo $_REQUEST['editId'] ?>" />

						<input name="otheractivityId" type="hidden" value="<?php echo $_REQUEST['otheractivityId'] ?>" />

						<input name="action" type="hidden" id="action" value="edit_activityrestrictions" />

						<input name="serviceType" type="hidden" value="Sightseeing" />

					</table>

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<td>

							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('editactivity','submitbtn','0');" />

						</td>

						<td style="padding-right:20px;">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>



		</div>

	<?php

	}

	?>

	<?php

	if ($_REQUEST['action'] == 'entrancerestriction' && $_REQUEST['id'] != '') {

	?>

		<div class="contentclass">

			<h1 style="text-align:left;">Add Monument Restriction </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="entrance" target="actoinfrm" id="entrance">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

										<input name="startDate" type="text" id="startDate_a" class="gridfield" displayname="From Date" autocomplete="off" />

									</label>

								</div>

							</td>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

										<input name="endDate" type="text" id="endDate_a" class="gridfield" displayname="End Date" autocomplete="off" />

									</label>

								</div>

							</td>

						</tr>

						<style>
							.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {



								width: 100% !important;



							}
						</style>

						<script>
							$('#startDate_a').Zebra_DatePicker({



								format: 'd-m-Y',



							});



							$('#endDate_a').Zebra_DatePicker({



								format: 'd-m-Y',



							});
						</script>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Reason<span class="redmind"></span></div>

										<textarea name="reason" rows="2" class="gridfield" id="reason"></textarea>

									</label>

								</div>

							</td>

						</tr>



					</table>

					<input name="entranceId" type="hidden" value="<?php echo $_REQUEST['id'] ?>" />

					<input name="action" type="hidden" id="action" value="entranceoperationrestriction" />

				</form>

			</div>

			<div id="buttonsbox" style="text-align:center;">

				<table border="0" align="right" cellpadding="0" cellspacing="0">

					<tr>

						<td>

							<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('entrance','submitbtn','0');" />

						</td>

						<td style="padding-right:20px;">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

						</td>

					</tr>

				</table>

			</div>

		</div>

	<?php

	}

	?>

	<?php

	if ($_REQUEST['action'] == 'edit_entrancerestrictions' && $_REQUEST['editId'] != '' && $_REQUEST['entranceId'] != '') {

		if ($_REQUEST['editId'] != '') {

			$editId = clean($_REQUEST['editId']);

			$select1 = '*';

			$where1 = 'id=' . $editId . '';

			$rs1 = GetPageRecord($select1, 'hoteloperationRestriction', $where1);

			$editresult = mysqli_fetch_array($rs1);
		}



	?>

		<div class="contentclass">

			<h1 style="text-align:left;"><?php if ($_REQUEST['editId'] != '') {
												echo 'Edit';
											} else {
												echo 'Add';
											} ?> Monument Restriction </h1>

			<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="editentrance" target="actoinfrm" id="editentrance">

					<table width="100%" border="0" cellspacing="0" cellpadding="5">

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">From&nbsp;Date<span class="redmind"></span></div>

										<input name="startDate" type="text" class="gridfield validate" id="startDate" displayname="From Date" value="<?php if ($editresult['startDate'] != '01-01-1970' && $editresult['startDate'] != '' && $editresult['startDate'] != '0') {
																																							echo date('d-m-Y', strtotime($editresult['startDate']));
																																						} ?>" autocomplete="off" />

									</label>

								</div>

							</td>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">To&nbsp;Date<span class="redmind"></span></div>

										<input name="endDate" type="text" class="gridfield validate" id="endDate" displayname="To Date" value="<?php if ($editresult['endDate'] != '01-01-1970' && $editresult['endDate'] != '' && $editresult['endDate'] != '0') {
																																					echo date('d-m-Y', strtotime($editresult['endDate']));
																																				} ?>" autocomplete="off" />

									</label>

								</div>

							</td>

						</tr>

						<style>
							.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {



								width: 100% !important;



							}
						</style>

						<script>
							$(document).ready(function() {



								$('#startDate').Zebra_DatePicker({



									format: 'd-m-Y',



								});



								$('#endDate').Zebra_DatePicker({



									format: 'd-m-Y',



								});



							});
						</script>

						<tr>

							<td colspan="2">

								<div class="griddiv"><label>

										<div class="gridlable">Reason<span class="redmind"></span></div>

										<textarea name="reason" rows="2" class="gridfield validate" id="reason"><?php echo $editresult['reason']; ?></textarea>

									</label>

								</div>

							</td>

						</tr>



						<input name="editId" type="hidden" value="<?php echo $_REQUEST['editId'] ?>" />

						<input name="entranceId" type="hidden" value="<?php echo $_REQUEST['entranceId'] ?>" />

						<input name="action" type="hidden" id="action" value="edit_entrancerestrictions" />

					</table>

				</form>



				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>

							<td>

								<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('editentrance','submitbtn','0');" />

							</td>

							<td style="padding-right:20px;">

								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

							</td>

						</tr>

					</table>

				</div>

			</div>

		<?php

	}

		?>

		<?php

		if ($_GET['action'] == 'addedit_gstmaster' && $_GET['sectiontype'] == 'gstmaster') {

			$fromDate = date('Y-m-d');

			$toDate = date('Y-m-d');

			if ($_GET['editId'] != '') {

				$editId = clean($_GET['editId']);

				$select1 = '*';

				$where1 = 'id=' . $editId . '';

				$rs1 = GetPageRecord($select1, 'gstMaster', $where1);

				$editresult = mysqli_fetch_array($rs1);

				$gstValue = clean($editresult['gstValue']);

				$gstSlabName = clean($editresult['gstSlabName']);

				$serviceType = clean($editresult['serviceType']);
			}

		?>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($editresult['id']!= '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> TAX Master</h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="5">
										
							<tr >

								<td <?php if($editresult['id']!=''){ ?> style="display:none;" <?php } ?> >
									<div class="griddiv"><label>

											<div class="gridlable">Service&nbsp;Type<span class="redmind"></span></div>

											<select id="serviceType" name="serviceType" class="gridfield validate" displayname="serviceType" autocomplete="off">

												<option value="">Service Type</option>

												<?php
												$rs2 = "";
												$rs2 = GetPageRecord('*', 'suppliersTypeMaster', ' status=1 and deletestatus=0 order by id asc');

												while ($editresult2 = mysqli_fetch_array($rs2)) {

													$name = ucfirst($editresult2['name']);
													$subName = "";
													if ($editresult2['name'] == 'Restaurant') {
														$subName = " /Meal Plan";
													}
												?>

													<option value="<?php echo $name; ?>" <?php if ($serviceType == $editresult2['name']) { ?>selected="selected" <?php } ?>><?php echo $name . $subName; ?></option>

												<?php } ?>

											</select>

										</label>

									</div>
								</td>



								<td <?php if($editresult['id']!=''){ ?> style="display:none;" <?php } ?> >
									<div class="griddiv"><label>

											<div class="gridlable">TAX&nbsp;Slab&nbsp;Name<span class="redmind"></span></div>

											<input name="gstSlabName" type="text" class="gridfield validate" id="gstSlabName" displayname="TAX Slab Name" value="<?php echo $gstSlabName; ?>" maxlength="100" />

										</label>

									</div>
								</td>

							</tr>

							<tr>

								<td <?php if($editresult['id']!=''){ ?> style="display:none;" <?php } ?> >

									<div class="griddiv"><label>

											<div class="gridlable">TAX&nbsp;Value(&nbsp;In&nbsp;%)<span class="redmind"></span></div>

											<input name="gstValue" type="number" class="gridfield " id="gstValue" displayname="TAX Value" value="<?php echo $gstValue; ?>" maxlength="100" />

										</label>

									</div>

								</td>

								<td>

									<div class="griddiv"><label>

											<div class="gridlable">Status</div>

											<select class="gridfield" name="status" id="status">

												<option value="1" <?php if ($editresult['status'] == 1 || $editresult['id'] == '') { ?>selected="selected" <?php } ?>>Active</option>

												<option value="0" <?php if ($editresult['status'] == 0 && $editresult['id'] != '') { ?>selected="selected" <?php } ?>>Inactive</option>

											</select>

										</label>

									</div>

								</td>

							</tr>
							<tr>
							<!-- select by default option in  started-->
							<td>
								<div class="griddiv" style="padding-bottom: 0px;">
								<label>
									<div class="gridlable">Set Default<span class=""></span></div>
										<select name="setDefault" id="setDefault"  class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;"> 	
											<option value="0" <?php if($editresult['setDefault']==0 || $editresult['id']==0){ ?> selected="selected" <?php } ?>>No</option>
											<option value="1" <?php if($editresult['setDefault']==1 && isset($editresult['setDefault'])){ ?> selected="selected" <?php } ?>>Yes</option>

										</select></label>

								</label>
								</div>
							</td>
							<!-- select by default option in  ended-->
							</tr>
						
							<style>
								.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

									width: 100% !important;

								}
							</style>

						</table>

						<input name="editId" type="hidden" value="<?php echo $_GET['editId']; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_gstmaster" />

					</form>





				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>





		<?php }

		if ($_GET['action'] == 'addedit_vehiclemaster' && $_GET['sectiontype'] == 'vehiclemaster') {


			$status = 1;
			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

				$select1 = '*';

				$where1 = 'id=' . $id . '';

				$rs1 = GetPageRecord($select1, _VEHICLE_MASTER_MASTER_, $where1);

				$editresult = mysqli_fetch_array($rs1);

				$image = clean($editresult['image']);

				$name = clean($editresult['name']);
				$status = clean($editresult['status']);
				$maxpax = clean($editresult['maxpax']);
				$capacity = clean($editresult['capacity']);
			}

		?>



			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Vehicle</h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellpadding="0" cellspacing="0">

							<tr>

								<td width="50%" align="left" valign="top" style="padding-right:20px;">

									<div class="griddiv"><label>

											<div class="gridlable">Vehicle Type </div>

											<select id="vehicleType" name="vehicleType" class="gridfield " displayname="Title" autocomplete="off">

												<?php

												$rs = GetPageRecord('name,id', 'vehicleTypeMaster', ' 1 order by name asc');

												while ($resListing = mysqli_fetch_array($rs)) {

												?>

													<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == strip($editresult['carType'])) { ?> selected="selected" <?php } ?>>
														<?php echo strip($resListing['name']); ?></option>

												<?php } ?>

											</select>

										</label>

									</div>

									<div class="griddiv"><label>
											<div class="gridlable">Capacity<span class="redmind"></span></div>
											<input name="capacity" type="text" class="gridfield validate" id="capacity" displayname="Brand Name" value="<?php echo $capacity; ?>" maxlength="100" />
										</label>
									</div>

									<div class="griddiv">

										<label>

											<div class="gridlable">Brand Name<span class="redmind"></span></div>



											<select id="brand" name="brand" class="gridfield " displayname="Title" autocomplete="off">



												<option value="">None</option>



												<?php



												$select = '';

												$where = '';

												$rs = '';

												$select = '*';

												$where = ' name!="" and deletestatus=0 and status=1 order by id asc';

												$rs = GetPageRecord($select, _VEHICLE_BRAND_MASTER_, $where);

												while ($resListing = mysqli_fetch_array($rs)) {

												?>

													<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editresult['brand']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>

												<?php } ?>

											</select>
										</label>

									</div>



									<div class="griddiv"><label>

											<div class="gridlable">Vehicle Name</div>

											<input name="model" type="text" class="gridfield validate" id="model" value="<?php echo $editresult['model']; ?>" displayname="Vehicle Name" maxlength="100" />

										</label>

									</div>



									<div class="griddiv"><label>

											<div class="gridlable">Vehicle Image</div>

											<input name="vehicleImage" type="file" class="gridfield" id="vehicleImage" />

											<input type="hidden" name="vehicleImage2" id="vehicleImage2" value="<?php echo $editresult['image']; ?>" />

										</label>

									</div>

									<div class="griddiv">

										<label>

											<div class="gridlable">status</div>

											<select id="status" name="status" type="text" class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;">

												<option value="1" <?php if ($status == 1) {
																		echo 'selected="selected"';
																	} ?>>Active</option>

												<option value="0" <?php if ($status == 0) {
																		echo 'selected="selected"';
																	} ?>>In Active</option>

											</select>
										</label>

									</div>


								</td>

							</tr>

						</table>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_vehiclemaster" />

					</form>





				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>

			</div>

		<?php }






//  Vehicle Type Master Start ==============
if($_GET['action']=='addedit_vehicleTypeMaster' && $_GET['sectiontype']=='vehicleTypeMaster'){ 

 
	$status = 1;
	if($_GET['id']!=''){
	
	$id=clean($_GET['id']);
	
	$select1='*';  
	
	$where1='id='.$id.''; 
	
	$ress1=GetPageRecord($select1,'vehicleTypeMaster',$where1); 
	
	$editresult=mysqli_fetch_array($ress1);
	
	$name=clean($editresult['name']);   
	$status=clean($editresult['status']);   
	 $capacity=clean($editresult['capacity']);
	
	}
	
	?>
	
	<div class="contentclass">
	
	<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Vehicle Type</h1>
	
	  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
	
	<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	
			  <tr>
	
		<td width="50%" align="left" valign="top" style="padding-right:20px;"> 
		<?php if($_GET['id']==''){ ?>
		<div class="griddiv"><label>
	
		<div class="gridlable">Vehicle Type<span class="redmind"></span></div>
	
		<input type="text" id="name" name="name" class="gridfield validate" value="<?php echo $name; ?>" displayname="Vehicle Type">
	
		</label>
	
		</div>
		<?php }else{ ?>	
			<div class="griddiv" style="display: none;"><label>
	
			<div class="gridlable">Vehicle Type</div>
	
			<input type="text" id="vehicleType" name="vehicleType" class="gridfield" value="<?php echo $name; ?>" displayname="Vehicle Type">
	
			</label>
	
			</div>
	 <?php } ?>
	
		<div class="griddiv"><label>
		<div class="gridlable">Capacity</div>
		<input name="capacity" type="text" class="gridfield" id="capacity" displayname="Brand Name" value="<?php echo $capacity; ?>" maxlength="100" />
		</label>
		</div> 
	
		<div class="griddiv">
	
		<label> 
	
		<div class="gridlable">status</div>
	
		<select id="status"  name="status" type="text" class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;"> 	
	
		<option value="1" <?php if($status == 1){ echo 'selected="selected"'; } ?>>Active</option>
	
		<option value="0" <?php if($status == 0){ echo 'selected="selected"'; } ?>>In Active</option>
	
		</select></label>
	
		</div>


		<div class="griddiv"><label>

		<div class="gridlable">Vehicle Image</div>

		<input name="vehicleImage" type="file" class="gridfield" id="vehicleImage"/>

		<input type="hidden" name="vehicleImage2" id="vehicleImage2" value="<?php echo $editresult['image']; ?>" />

		</label>

		</div>
		
	
			 </td>
	
		</tr>
	
		</table>
	
	 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
	
	 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
	
	 <input name="action" type="hidden" id="action" value="addedit_vehicleTypeMaster" /> 
	
	</form>
	
	  </div>
	
	  <div id="buttonsbox"  style="text-align:center;">
	
	 <table border="0" align="right" cellpadding="0" cellspacing="0">
	
		  <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
	
			<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
	
		  </tr>
	
	   </table>
	
	
		</div>
	</div>
	
	 <?php }
	
	//  Vehicle Type Master End ==============

	

		if ($_GET['action'] == 'addedit_countrymaster222' && $_GET['sectiontype'] == 'countrymaster') {


			$status = 1;
			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

				$select1 = '*';

				$where1 = 'id=' . $id . '';

				$rs1 = GetPageRecord($select1, _COUNTRY_MASTER_, $where1);

				$editresult = mysqli_fetch_array($rs1);

				$name = clean($editresult['name']);

				$sortname = clean($editresult['sortname']);

				$status = clean($editresult['status']);
			}

		?>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Country </h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<div class="griddiv"><label>

								<div class="gridlable">Name<span class="redmind"></span></div>

								<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />

							</label>

						</div>

						<div class="griddiv"><label>

								<div class="gridlable">Sort Name<span class="redmind"></span></div>

								<input name="sortname" type="text" class="gridfield validate" id="sortname" displayname="Name" value="<?php echo $sortname; ?>" maxlength="100" />

							</label>

						</div>



						<div class="griddiv">

							<label>

								<div class="gridlable">status</div>

								<select id="status" name="status" type="text" class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;">

									<option value="1" <?php if ($status == 1) {
															echo 'selected="selected"';
														} ?>>Active</option>

									<option value="0" <?php if ($status == 0) {
															echo 'selected="selected"';
														} ?>>In Active</option>

								</select>
							</label>

						</div>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_countrymaster222" />

					</form>





				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>





		<?php }







		if ($_GET['action'] == 'addedit_marketTypeMaster') {



			$id = decode($_REQUEST['id']);

			$select = '*';

			$where = ' id="' . $id . '" order by id asc';

			$rs = GetPageRecord($select, 'marketMaster', $where);

			$editresult = mysqli_fetch_array($rs);



		?>

			<style>
				.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

					width: 100% !important;

				}
			</style>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Market Type </h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<div class="griddiv">

							<label>

								<div class="gridlable">Market Name<span class="redmind"></span></div>

								<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo strip($editresult['name']); ?>" <?php if ($editresult['name'] != "") { ?> readonly="" <?php } ?> />

							</label>

						</div>

						<div class="griddiv">

							<label>

								<div class="gridlable">Select Color: </div>

								<input type="color" id="marketColor" name="marketColor" value="#e66465" style="margin: .4rem; width: 200px; border: 1px solid #ccc;">

							</label>

						</div>

				<!-- select by default option in  started-->
				<div class="griddiv" style="padding-bottom: 4px;">
					<label>
						<div class="gridlable">Set Default<span class=""></span></div>
							<select name="setDefault" id="setDefault"  class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;"> 	
								<option value="0" <?php if($editresult['setDefault']==0 || $editresult['id']==0){ ?> selected="selected" <?php } ?>>No</option>
								<option value="1" <?php if($editresult['setDefault']==1 && isset($editresult['setDefault'])){ ?> selected="selected" <?php } ?>>Yes</option>

							</select></label>

					</label>
					</div>
					<!-- select by default option in  ended-->


						<div class="griddiv">

							<label>

								<div class="gridlable">Status</div>

								<select name="status" class="gridfield " displayname="Status" autocomplete="off" style="width: 100%;">

									<option value="1" <?php if ($editresult['status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>

									<option value="0" <?php if ($editresult['status'] == 0) { ?> selected="selected" <?php } ?>>In Active</option>

								</select>
							</label>

						</div>

						<input name="editId" type="hidden" id="editId" value="<?php echo $_REQUEST['id']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_marketTypeMaster" />

					</form>



				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>

		<?php }









		if ($_GET['action'] == 'addedit_seasonTypeMaster' && $_GET['sectiontype'] == 'seasonTypeMaster') {
			if ($_GET['id'] != '') {
				$id = decode($_GET['id']);
				$select1 = '*';
				$where1 = 'id=' . $id . '';
				$rs1 = GetPageRecord($select1, 'seasonMaster', $where1);
				$editresult = mysqli_fetch_array($rs1);
			}

			$starting_year  = 2020;
			$ending_year    = 2040;
			for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
				if (date('Y', strtotime($editresult['fromDate'])) == $starting_year) {
					$seleted = "selected";
				} else {
					$seleted = "";
				}
				$years[] = '<option value="' . $starting_year . '" ' . $seleted . ' >' . $starting_year . '</option>';
			}


		?>
			<script type="text/javascript">
				$('#fromDate').Zebra_DatePicker({
					format: 'd-m-Y',
				});
				$('#toDate').Zebra_DatePicker({
					format: 'd-m-Y',
				});
			</script>
			<style type="text/css">
				.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
					width: 100% !important;
				}
			</style>
			<div class="contentclass">
				<h1 style="text-align:left;padding: 5px;">Season Type </h1>
				<div id="contentbox" class="addeditpagebox" style="padding: 5px;overflow:auto;text-align:left;margin-bottom:0px;">
					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
						<table width="100%" border="0" cellspacing="0" cellpadding="5">
							<tr>
								<td width="50%">
									<div class="griddiv"><label>
											<div class="gridlable" style="width:100%">Season Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="redmind"></span></div>
											<select id="seasonName" name="seasonName" class="gridfield" displayname="Season Name" autocomplete="off">
												<option value="1" <?php if (1 == $editresult['seasonNameId']) { ?>selected="selected" <?php } ?>>Summer</option>
												<option value="2" <?php if (2 == $editresult['seasonNameId']) { ?>selected="selected" <?php } ?>>Winter</option>
												<option value="3" <?php if (3 == $editresult['seasonNameId']) { ?>selected="selected" <?php } ?>>All</option>
											</select>
										</label>
									</div>
								</td>
								<td width="50%" style="display: none;">
									<div class="griddiv"><label>
											<div class="gridlable" style="width:100%">Select Year&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="redmind"></span></div>
											<select id="seasonYear" name="seasonYear" class="gridfield" displayname="Season Year" autocomplete="off">
												<?php echo implode("\n\r", $years);  ?>
											</select>
										</label>
									</div>
								</td>
							</tr>
							<tr>
								<td width="50%">
									<div class="griddiv"><label>
											<div class="gridlable">From&nbsp;Date </div>
											<input type="text" class="gridfield calfieldicon" name="fromDate" id="fromDate" value="<?php if (!empty($editresult['fromDate'])) {
																																		echo date('d-m-Y', strtotime($editresult['fromDate']));
																																	} ?>" />
										</label>
									</div>
								</td>
								<td width="50%">
									<div class="griddiv"><label>
											<div class="gridlable">To&nbsp;Date </div>
											<input type="text" class="gridfield calfieldicon" name="toDate" id="toDate" value="<?php if (!empty($editresult['toDate'])) {
																																	echo date('d-m-Y', strtotime($editresult['toDate']));
																																} ?>" />
										</label>
									</div>
								</td>
							</tr>
							<tr>
								<td width="50%">
									<div class="griddiv"><label>
											<div class="gridlable" style="width:100%">Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="redmind"></span></div>
											<select id="status" name="status" class="gridfield" displayname="Status" autocomplete="off">
												<option value="1" <?php if (1 == $editresult['status']) { ?>selected="selected" <?php } ?>>Active</option>
												<option value="0" <?php if (0 == $editresult['status'] && $editresult['id'] != '') { ?>selected="selected" <?php } ?>>Inactive</option>
											</select>
										</label>
									</div>
								</td>
								<td width="100%">
									<div class=""><label>
											<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" />
											<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
											<input name="editId" type="hidden" id="editId" value="<?php echo $_GET['id']; ?>" />
											<input name="sectiontype" type="hidden" id="sectiontype" value="<?php echo $_REQUEST['sectiontype']; ?>" />
											<input name="action" type="hidden" id="action" value="addedit_<?php echo $_REQUEST['sectiontype']; ?>" />
										</label>
									</div>
								</td>
							</tr>
						</table>

					</form>
				</div>

			</div>


		<?php }









		if ($_GET['action'] == 'addedit_restaurantsmealplan' && $_GET['sectiontype'] == 'restaurantsmealplan') {



			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

				$select1 = '*';

				$where1 = 'id=' . $id . '';

				$rs1 = GetPageRecord($select1, 'restaurantsMealPlanMaster', $where1);

				$editresult = mysqli_fetch_array($rs1);

				$name = clean($editresult['name']);

				$status = clean($editresult['status']);
			}

		?>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Restaurant Meal Name </h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<div class="griddiv"><label>

								<div class="gridlable">Meal Name<span class="redmind"></span></div>

								<input name="name" type="text" class="gridfield validate" id="name" displayname="Meal Name" value="<?php echo $name; ?>" maxlength="100" />

							</label>

						</div>

						<div class="griddiv">

							<label>

								<div class="gridlable">status</div>

								<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

									<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

									<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

								</select>
							</label>

						</div>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_restaurantsmealplan" />

					</form>





				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>





		<?php }




	// add restaurantsmealplan current sec
if($_GET['action']=='addedit_inboundmealplanmaster' && $_GET['sectiontype']=='inboundmealplanmaster' ){ 

	if($_GET['id']==''){
		$namevalue ='deleteStatus="1"'; 
		$id = addlistinggetlastid(_INBOUND_MEALPLAN_MASTER_,$namevalue);
	}
	if($_GET['id']!=''){
		$id=clean($_GET['id']);
		$select1='*';  
		$where1='id='.$id.''; 
		$rs1=GetPageRecord($select1,_INBOUND_MEALPLAN_MASTER_,$where1); 
		$editresult=mysqli_fetch_array($rs1);

		if($editresult['supplier'] == 0){

			$selects='*';  
		$wheres='id="'.$editresult['supplierNameId'].'"'; 
		$rss=GetPageRecord($selects,_SUPPLIERS_MASTER_,$wheres); 
		$suplierresult=mysqli_fetch_array($rss);

	} 
 
	// restaurant self address 
	  $selecta='*';  
		$wherea='addressParent="'.$editresult['id'].'"'; 
		$rsa=GetPageRecord($selecta,_ADDRESS_MASTER_,$wherea); 
		$addressresult=mysqli_fetch_array($rsa);


		// restaurant self contact person 
		$selectsc='*';  
		$wheresc='restaurantId="'.$editresult['id'].'"'; 
		$rssc=GetPageRecord($selectsc,'restaurantContactPersonMaster',$wheresc); 
		$scontactresult=mysqli_fetch_array($rssc);}
?>
<div class="contentclass">
		<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Restaurant </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
		<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
			<table width="100%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
				<td width="49%" ><div class="griddiv"><label>
				<div class="">Restaurant&nbsp;Name<span class="redmind"></span></div>
				<input name="mealPlanName" type="text" class="gridfield validate" id="mealPlanName" displayname="Restaurant" value="<?php echo strip($editresult['mealPlanName']); ?>" />
				 </label>
				</div></td>
				<td width="2%" >&nbsp;</td>
				<td width="49%">
					<div class="griddiv">
						<label>
						<div class="">Destination <span class="redmind"></span></div>
						<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination&nbsp;Name" autocomplete="off"   >
						<option value="">Select Destination</option>
						<?php 
						
						$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
						while($resListing=mysqli_fetch_array($rs)){ 
						
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['destinationId']){ ?> selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
						<?php }   ?>
						</select>
						</label>
					</div>					</td>
			  </tr>
			  <tr>
				<td width="49%" ><div class="griddiv"><label><div class="gridlable">Address</div>
				  <input name="hotelAddress" type="text" class="gridfield" id="hotelAddress" value="<?php echo $addressresult['address']; ?>">
				  </label>
				</div></td>
				<td width="2%" >&nbsp;</td>
				<td width="49%">
					

				 <div class="griddiv">
						<label>
						<div class="">Country <span class="redmind"></span></div>
						<select id="countryId2" name="countryId2" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selectstate();" >
						<option value="">Select</option>
						<?php 
						$select=''; 
						$where=''; 
						$rs='';  
						$select='*';    
						$where=' deletestatus=0 and status=1 order by name asc';  
						$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
						while($resListing=mysqli_fetch_array($rs)){  
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$addressresult['countryId']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
						</select>
						</label>
					</div>	

			 </td>
			  </tr>

			  <tr>
				  <td width="49%"><div class="griddiv">
					<label>
					<div class="gridlable">State </div>
					<select id="stateId2" name="stateId2" class="gridfield validate" displayname="State" autocomplete="off" onchange="selectcity();" >
					</select></label>
					</div></td>
					<td width="2%">&nbsp;</td>
					<td width="49%"><div class="griddiv">
					<label>
					<div class="gridlable">City  </div>
					<!-- select Hotel city name code -->
					<select id="cityId2" name="cityId2" class="gridfield validate" displayname="City" autocomplete="off" >
					</select></label>
					</div></td>
			  </tr>
			  <tr>
			   <td width="49%"><div class="griddiv">
			<label>
			<div class="gridlable">Supplier</div>
				<select id="supplier"   name="supplier" class="gridfield " autocomplete="off" onchange="getSupplier('<?php echo $editresult['supplier']; ?>');">
				<option value="1" <?php if($editresult['supplier']=='1'){ ?>selected="selected" <?php } ?>>Yes</option>
				<option value="0" <?php if($editresult['supplier']=='0'){ ?>selected="selected" <?php } ?> >No</option>
			</select>
			</label>
			</div></td>
				   <td width="2%">&nbsp;</td>
				   <td width="49%"><div id="showResSupplier"></div></td>
			  </tr>
				<script type="text/javascript">
					function getSupplier(supplierId) {
						var supplierType= $('#supplier').val();
						$('#showResSupplier').load('loadrestaurantsSpplier.php?supplierType='+supplierType+'&supplierId='+supplierId);
					   
					}
					getSupplier('<?php echo $editresult['supplierNameId']; ?>');
				</script>				  		
					   <tr>
						   <td width="49%"><div class="griddiv"><label>
				<div class="gridlable">Pin&nbsp;Code </div>
				<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $addressresult['pinCode']; ?>" maxlength="15" />
				</label>
				</div></td>
				<td width="2%"></td>
						<td width="49%"><div class="griddiv"><label>
				<div class="gridlable">GSTN</div>
				<input name="gstn" type="text" class="gridfield" id="gstn" value="<?php echo $addressresult['gstn']; ?>">
				</label>
				</div></td>
					</tr>

				<script>
				function selectcity(){
					var stateId = $('#stateId2').val();
					$('#cityId2').load('loadcity.php?id='+stateId+'&selectId=<?php echo $addressresult['cityId']; ?>&stateId=<?php echo $addressresult['stateId']; ?>');
				}

				function selectstate(){
					var countryId = $('#countryId2').val();
					$('#stateId2').load('loadstate.php?action=loadrestaurantstates&id='+countryId+'&selectId=<?php echo $addressresult['stateId']; ?>'); 
				}
				<?php
				if($_GET['id']!=''){ 
				?>
				selectstate();
				selectcity(); 
				<?php } ?> 
			function fileValidation() { 
			var fileInput =  
				document.getElementById('mealPlanImage'); 
			
			var filePath = fileInput.value; 
		
			// Allowing file type 
			var allowedExtensions =  
					/(\.jpg|\.jpeg|\.png|\.gif)$/i; 
			
			if (!allowedExtensions.exec(filePath)) { 
				alert('Please Upload Image JPG , JPEG , PNG , GIF'); 
				fileInput.value = ''; 
				return false; 
			}  }
			 </script>
			  </tr>
			   <tr>
				<td width="49%" >	<div class="griddiv" ><label>
		<div class="gridlable">Image Upload</div>
		<input name="mealPlanImage" type="file" class="gridfield" id="mealPlanImage" onchange="return fileValidation()"/>
		<input type="hidden" name="oldmealPlanImage" id="oldmealPlanImage" value="<?php echo $editresult['mealPlanImage']; ?>" />
		</label>
		  </div></td>
					<td width="2%" >&nbsp;</td>
					<td width="49%">
					<div class="griddiv"><label>
					<div class="gridlable">Status</div>
					<select id="status" name="status" class="gridfield " autocomplete="off"   >
					<option value="1" <?php if($editresult['status']=='1'){ ?> selected="selected"<?php } ?>>Active</option>
					<option value="0" <?php if($editresult['status']=='0'){ ?> selected="selected"<?php } ?>>Inactive</option>
					</select>
					</label>
					</div>					
					</td>
					</tr>
				  
					<tr>
				<td colspan="3" style="border: 1px solid #80808045;padding: 5px;background-color: #8080800d;"><table width="100%" border="0" cellspacing="2" cellpadding="0">
	  <tr>
	  <td width="70"><div class="griddiv">
				<label>
				<div class="">Contact Person<span class="redmind"></span></div>
				<select id="division1" name="division1" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
				<option value="">Select</option>
				<?php  
				$selectd='*';    
				$whered=' deletestatus=0 and status=1 order by name asc';  
				$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
				while($resListingd=mysqli_fetch_array($rsd)){  
				?>
				<option value="<?php echo strip($resListingd['id']); ?>" <?php if ($scontactresult['division'] == $resListingd['id']) { ?> selected="selected" <?php } ?>><?php echo strip($resListingd['name']); ?></option>
				<?php } ?>	 
			</select>
				</label>
				</div>
				</td>
	  <td width="70"><div class="griddiv"><label>
				<input name="contactPerson" type="text" class="gridfield validate" id="contactPerson" value="<?php echo $scontactresult['contactPerson']; ?>" displayname="Contact Person" maxlength="100" placeholder="Contact Person" style="margin-top: 20px;">
				</label>
				</div></td>
	  <td width="70"><div class="griddiv"><label>
				<input name="designation1" type="text" class="gridfield validate" id="designation1" value="<?php echo $scontactresult['designation']; ?>" displayname="Designation" placeholder="Designation" style="margin-top: 20px;">
				</label>
				</div></td>
	  <td width="40"><div class="griddiv"><label>
				<?php 
				$rsn="";
				$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
				$cmpcountryData=mysqli_fetch_array($rs1cmp);
				$compcountryCode = $cmpcountryData['compcountryCode'];
				?>



				<input name="countryCode1" type="text" class="gridfield validate" id="countryCode1"  displayname="Country Code" placeholder="+91" value="<?php if($scontactresult['countryCode'] !=''){ echo $scontactresult['countryCode']; }else{ echo '+'. $compcountryCode;}  ?>" style="margin-top: 20px;">
				</label>
				</div></td>
				 <td width="80"><div class="griddiv"><label>
				
				<input name="phone1" type="text" class="gridfield validate" id="phone1" value="<?php echo $scontactresult['phone']; ?>" displayname="Phone" placeholder="Phone 1" style="margin-top: 20px;">
				</label>
				</div></td>
				<td width="80"><div class="griddiv"><label>
				
				<input name="phone2" type="text" class="gridfield " id="phone2" value="<?php echo $scontactresult['phone2']; ?>" displayname="Phone" placeholder="Phone 2" style="margin-top: 20px;">
				</label>
				</div></td>
				<td width="80"><div class="griddiv"><label>
				
				<input name="phone3" type="text" class="gridfield " id="phone3" value="<?php echo $scontactresult['phone3']; ?>" displayname="Phone" placeholder="Phone 3" style="margin-top: 20px;">
				</label>
				</div></td>

				<tr>
					<td width="120"><div class="griddiv"><label>
					
					<input name="email1" type="email" class="gridfield validate" id="email" value="<?php echo $scontactresult['email']; ?>" displayname="Email" placeholder="Email"  style="margin-top: 20px;" required />
					</label>
					</div></td>
				</tr>
		  </tr>
		  
		</table></td>
			  </tr>
			  <!-- <tr>
				<td colspan="3"><table width="100%" border="0" cellspacing="2" cellpadding="0">
				   <tr><td colspan="5"><div style="display: none;background-color: #00800021;padding: 10px;
text-align: center;
border: 1px solid #00800040;" id="alertsumessage"><strong>Please Select another Meal Type</strong></div></td></tr>		
				  <tr>
					<td width="150"><div class="griddiv" style="margin-top: 13px;">
				<label>
				<div class="">Meal Type<span class="redmind"></span></div>
				<select id="mealPlanType" class="gridfield validate" displayname="city" autocomplete="off"   >
					<?php   
						$rs2=GetPageRecord('*','restaurantsMealPlanMaster','1 and deletestatus=0'); 
						while($userss=mysqli_fetch_array($rs2)){
					 ?>
					<option value="<?Php echo $userss['id']; ?>"><?Php echo $userss['name']; ?></option>
					<?php } ?>
				</select>
				</label>
				</div></td>
				  <td width="100"><div class="griddiv" style="margin-top: 13px;">
				<label>
				<div class="">Currency<span class="redmind"></span></div>
				<select id="currencyId" name="currencyId" class="gridfield validate" displayname="city" autocomplete="off"   >
					 <?php 
					  
					  $select=''; 
					  $where=''; 
					  $rs='';  
					  $select='*';    
					  $where=' deletestatus=0 and status=1 order by name asc';  
					  $rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
					  while($resListing=mysqli_fetch_array($rs)){  
					  ?>
					   <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']==1){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>
					<?php } ?>
				</select>
				</label>
				</div></td>
					<td width="100"><div class="griddiv" style="margin-top: 13px;"><label>
				<div class="">Per Pax Cost<span class="redmind"></span></div>
				<input name="adultCostLunch" type="text" class="gridfield number_only " id="adultCostLunch" displayname="Lunch&nbsp;Cost" value="<?php echo strip($editresult['adultCostLunch']); ?>" />
				</label>
				</div></td>
					 <td width="150"><div class="griddiv" style="margin-top: 13px;"><label>
				 
		  
		<div class="">GST&nbsp;SLAB(%)<span class="redmind"></span></div>
		<select id="RestaurantGST" name="RestaurantGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;" >
			<?php 
			$rs2="";
			$rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Restaurant" and status=1'); 
			while($gstSlabData=mysqli_fetch_array($rs2)){
			?>
			<option value="<?php echo $gstSlabData['id'];?>"><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
			<?php
			}	
			?>
		 </select>
		 </label>
		 </div>
		</td>
					
					<td width="40"><div style="border:1px solid #ccc; border-radius:3px;margin-top: 13px; padding:10px 20px; background-color:#009966; color:#FFFFFF; cursor:pointer;" onclick="restaurantsmealplan();">+Add</div>
					<script>
					function restaurantsmealplan(){
						var mealPlanId = $('#mealPlanType').val();
						var adultCost = $('#adultCostLunch').val();
						var childCost = $('#childCostLunch').val();
						var currencyId = $('#currencyId').val();
						var RestaurantGST = $('#RestaurantGST').val();
						$('#loadmeal').load('loadsaverestaurantsmealplan.php?action=saverestaurantsmealplan&restaurantId=<?php echo $id; ?>&mealPlanId='+mealPlanId+'&adultCost='+adultCost+'&currencyId='+currencyId+'&childCost='+childCost+'&RestaurantGST='+RestaurantGST);
						$('#adultCostLunch').val('');
						$('#childCostLunch').val('');
					}
					
					function loadrestaurantsmealplan(){ 
						$('#loadmeal').load('loadsaverestaurantsmealplan.php?restaurantId=<?php echo $id; ?>');
					}
					loadrestaurantsmealplan();
					
					function deleterate(id){
						if(confirm('Are you sure want to confirm?')){
							$('#loadmeal').load('loadsaverestaurantsmealplan.php?action=deleterestaurantsmealplan&restaurantId=<?php echo $id; ?>&id='+id);
						}
					}
					
					</script>						
				</td>
				  </tr>
				  <tr>
					<td colspan="5"><div id="loadmeal"></div></td>
				  </tr>
				</table>
			  </td>
			  </tr>
			  <tr>
				<td>					
				</td>
				
				<td></td>
				<td></td>
			  </tr>

			  <tr>
				<td>
								</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr> -->
			  <script>
				  $('.number_only').bind('keyup paste', function(){
						this.value = this.value.replace(/[^0-9]/g, '');
				  });
			  </script> 
			</table>   
			 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
			 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
			 <input name="action" type="hidden" id="action" value="addedit_inboundmealplanmaster" />
			 <input name="mealPlanImage2" type="hidden" id="mealPlanImage2" value="<?php echo $editresult['mealPlanImage']; ?>" />
		</form> 
	</div>
	<div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
	  <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onClick="formValidation('addmasters','submitbtn','0');" /></td>
		<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onClick="masters_alertspopupopenClose();" /></td>
	  </tr>
   </table>
</div>
</div>
<?php 
} 



		if ($_GET['action'] == 'addedit_overview' && $_GET['sectiontype'] == 'overview') {

			if ($_GET['id'] != '') {
				$id = clean($_GET['id']);
				$select1 = '*';
				$where1 = 'id="' .$id. '"';
				$rs1 = GetPageRecord($select1, _OVERVIEW_MASTER_, $where1);
				$editresult = mysqli_fetch_array($rs1);
				$finalweekendDays = explode(",", $editresult['destinationId']);
			}
		?>
			<div class="contentclass">
				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?>&nbsp;&nbsp;Overview</h1>
				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
						<div class="griddiv">
							<label>
								<div class="gridlable">Overview&nbsp;Name<span class="redmind"></span></div>
								<input type="text" name="overviewName" id="overviewName" class="gridfield" value="<?php echo $editresult['overviewName']; ?>">
							</label>
						</div>

						<div class="griddiv">
							<label>
								<div class="gridlable" style="width: 100%;">
								<span id="clickableBox_1" class="fa fa-pencil overview_cls" onclick="editOverviewTitle('1');"></span>

								 <input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['overviewTitle_1']==''){ echo "Overview Information"; }else{ echo $editresult['overviewTitle_1']; } ?>" name="overViewTextBox_1" id="overViewTextBox_1" style="width:70%; display:none; margin-bottom:5px;">
								 <?php if($editresult['id']>0){ ?>
								 <div id="saveTitle_1" class="actionbtn" style="background:#233a49;" onclick="saveTitleText('1');">Save</div>
								 <?php } ?>
								 <div  id="cancelTitle_1" class="actionbtn" style="background:red;" onclick="cancelTitleText('1');">Cancel</div>
								
								 <div style="display:inline-block;" id="displayTitle_1"><?php if($editresult['overviewTitle_1']==''){ echo "Overview Information"; }else{ echo ucwords($editresult['overviewTitle_1']); } ?></div>

								 <span class="redmind"></span>
								
								</div>
								
								<textarea name="overview" rows="3" class="gridfield" id="overview" displayname="Overview"><?php echo $editresult['overview']; ?></textarea>
							</label>
						</div>

						<div class="griddiv">
							<label>
								<div class="gridlable" style="width:100%;">
								<span id="clickableBox_2" class="fa fa-pencil overview_cls" onclick="editOverviewTitle('2');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['overviewTitle_2']==''){ echo "Highlight&nbsp;Information"; }else{ echo $editresult['overviewTitle_2']; } ?>" name="overViewTextBox_2" id="overViewTextBox_2" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveTitle_2" class="actionbtn" style="background:#233a49;" onclick="saveTitleText('2');">Save</div>
								<?php } ?>
								<div  id="cancelTitle_2" class="actionbtn" style="background:red;" onclick="cancelTitleText('2');">Cancel</div>
								
								<div style="display:inline-block;" id="displayTitle_2"><?php if($editresult['overviewTitle_2']==''){ echo "Highlight&nbsp;Information"; }else{ echo ucwords($editresult['overviewTitle_2']); } ?></div>
							</div>
								<textarea name="highlight" rows="3" class="gridfield " id="highlight"><?php echo $editresult['highlight']; ?></textarea>
							</label>
						</div>



						<!-- started ---- Itinerary introduction and itinerary Summary sec   -->
						<div class="griddiv">
							<label>
								<div class="gridlable" style="width:100%;">
								
								<span id="clickableBox_3" class="fa fa-pencil overview_cls" onclick="editOverviewTitle('3');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['overviewTitle_3']==''){ echo "Itinerary&nbsp;introduction"; }else{ echo $editresult['overviewTitle_3']; } ?>" name="overViewTextBox_3" id="overViewTextBox_3" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveTitle_3" class="actionbtn" style="background:#233a49;" onclick="saveTitleText('3');">Save</div>
								<?php } ?>
								<div  id="cancelTitle_3" class="actionbtn" style="background:red;" onclick="cancelTitleText('3');">Cancel</div>
								
								<div style="display:inline-block;" id="displayTitle_3"><?php if($editresult['overviewTitle_3']==''){ echo "Itinerary&nbsp;introduction"; }else{ echo ucwords($editresult['overviewTitle_3']); } ?></div>

								<span class="redmind"></span></div>
								<textarea name="itineraryintr" rows="3" class="gridfield" id="itineraryintr" displayname="Itinerary introduction"><?php echo $editresult['itineraryintr']; ?></textarea>
							</label>
						</div>
						<div class="griddiv">
							<label>
								<div class="gridlable" style="width:100%;">
								
								<span id="clickableBox_4" class="fa fa-pencil overview_cls" onclick="editOverviewTitle('4');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['overviewTitle_4']==''){ echo "Itinerary&nbsp;Summary"; }else{ echo $editresult['overviewTitle_4']; } ?>" name="overViewTextBox_4" id="overViewTextBox_4" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveTitle_4" class="actionbtn" style="background:#233a49;" onclick="saveTitleText('4');">Save</div>
								<?php } ?>
								<div  id="cancelTitle_4" class="actionbtn" style="background:red;" onclick="cancelTitleText('4');">Cancel</div>
								
								<div style="display:inline-block;" id="displayTitle_4"><?php if($editresult['overviewTitle_4']==''){ echo "Itinerary&nbsp;Summary"; }else{ echo ucwords($editresult['overviewTitle_4']); } ?></div>
								
								</div>
								<textarea name="itinerarysumm" rows="3" class="gridfield " id="itinerarysumm" displayname="Itinerary Summary"> <?php echo $editresult['itinerarysumm']; ?></textarea>
							</label>
						</div>
						<!-- Ended ---- Itinerary introduction and itinerary Summary sec   -->



						<div class="griddiv">
							<label>
								<div class="gridlable">status</div>
								<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">
									<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>
									<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>
								</select>
							</label>
						</div>
						<input name="editId" type="hidden" id="editId" value="<?php echo $id ; ?>" />
						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
						<input name="action" type="hidden" id="action" value="addedit_overview" />
					</form>

					<script>
						function editOverviewTitle(param){
							// if(param=='1'){
								$("#clickableBox_"+param).hide();
								$("#displayTitle_"+param).hide();
								$("#overViewTextBox_"+param).show();
								$("#saveTitle_"+param).css('display','inline-block');
								$("#cancelTitle_"+param).css('display','inline-block');
							// }

						
						}

						

						function saveTitleText(param){
							// if(param=='1'){
								
								var title = $("#overViewTextBox_"+param).val();

								$("#displayTitle_"+param).load(`final_frmaction.php?action=updateOverviewTitleText&id=<?php echo $editresult['id']; ?>&titleText=${encodeURI(title)}&param=${param}`);

								$("#clickableBox_"+param).show();
								$("#displayTitle_"+param).css('display','inline-block');
								$("#overViewTextBox_"+param).hide();
								$("#saveTitle_"+param).css('display','none');
								$("#cancelTitle_"+param).css('display','none');
							// }

						
						}

						function cancelTitleText(param){
							// if(param=='1'){
								$("#clickableBox_"+param).show();
								$("#displayTitle_"+param).show();
								$("#overViewTextBox_"+param).hide();
								$("#saveTitle_"+param).css('display','none');
								$("#cancelTitle_"+param).css('display','none');
							// }
						}

					</script>

	<style>
	.overview_cls{
		border: 1px solid #5b9d50;
		padding: 4px 6px;
		font-size: 20px;
		color: #5b9d50;
		background: #efefef;
		cursor:pointer;
		border-radius: 4px;
		margin-bottom: 5px;
		
				}
	.actionbtn{
		display: none;
		cursor: pointer;
		width: 50px;
		padding: 5px 10px;
		color: #fff;
		font-weight: 500;
		font-size: 15px;
		text-align: center;
		border-radius: 5px;
		}
			
			</style>

					<script src="tinymce/tinymce.min.js"></script>
					<script type="text/javascript">
						tinymce.init({
							selector: "#overview",
							themes: "modern",
							plugins: [
								"advlist autolink lists link image charmap print preview anchor",
								"searchreplace visualblocks code fullscreen"
							],
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
						});
					</script>
					<script type="text/javascript">
						tinymce.init({
							selector: "#highlight",
							themes: "modern",
							plugins: [
								"advlist autolink lists link image charmap print preview anchor",
								"searchreplace visualblocks code fullscreen"
							],
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
						});



						// Started js ---- Itinerary introduction and itinerary Summary sec 
						tinymce.init({
							selector: "#itinerarysumm",
							themes: "modern",
							plugins: [
								"advlist autolink lists link image charmap print preview anchor",
								"searchreplace visualblocks code fullscreen"
							],
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
						});

						tinymce.init({
							selector: "#itineraryintr",
							themes: "modern",
							plugins: [
								"advlist autolink lists link image charmap print preview anchor",
								"searchreplace visualblocks code fullscreen"
							],
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
						});
						// Ended js ---- Itinerary introduction and itinerary Summary sec

					</script>
				</div>
				<div id="buttonsbox" style="text-align:center;">
					<table border="0" align="right" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="  Save  " onclick="formValidation('addmasters','submitbtn','0');" />
							</td>
							<td style="padding-right:20px;">
								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
							</td>
						</tr>
					</table>
				</div>
			</div>

			

		<?php }


// started fit inclusion and exclusion 

if ($_GET['action'] == 'addedit_FITInculsionsIExculsionsITCICancellationPolicy' && $_GET['sectiontype'] == 'FITInculsionsIExculsionsITCICancellationPolicy') {

	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id="' .$id. '"';
		$rs1 = GetPageRecord($select1, 'fitIncExcMaster', $where1);
		$editresult = mysqli_fetch_array($rs1);
		$editdestinationId = clean($editresult['destinationId']);

		// $finalweekendDays = explode(",", $editresult['destinationId']);
	}
?>
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>

	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?>&nbsp;&nbsp;FIT Inculsions I Exculsions</h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable">Name<span class="redmind"></span></div>
						<input type="text" name="fitName" id="fitName" class="gridfield" value="<?php echo $editresult['fitName']; ?>">
					</label>
				</div>
				<!-- <div class="griddiv">
					<label>
						<div class="gridlable">Destination<span class="redmind"></span></div>
						<input type="text" name="destinationId" id="destinationId" class="gridfield" value="<?php echo $editresult['destination']; ?>">
					</label>
				</div> -->


				<!-- new added for destination fields by islam -->
				
				<div class="griddiv"><label>
					<!-- destination code -->
							<div class="gridlable">Destination<span class="redmind"></span></div>
							<select id="destinationIda" multiple="multiple" name="destinationId[]" class="gridfield js-example-basic-multiple" displayname="Destination" autocomplete="off">
							<option value="All" <?php if($editdestinationId=='All') { echo 'selected="selected"';} ?> >All</option>
								<?php
								$select = '';
								$where = '';
								$rs = '';
								$select = '*';
								$where = ' 1 and deletestatus = 0 order by name asc';
								$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
								$alldest=explode(',',$editdestinationId);  
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
								<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> <?php } ?> 
							</select>
						</label>
				</div>
				
				<script>
			$('.js-example-basic-multiple').select2();  
	 		// $('.js-example-basic-multiple').on("select2:select", function (e) { 
        //    var data = e.params.data.text;
        //    if(data=='All'){
        //     $(".js-example-basic-multiple > option").prop("selected","selected");
        //     $(".js-example-basic-multiple").trigger("change");
        //    }
    //   }); 
				</script>
					<style>
		.select2-container {

			width: 100% !important;
			;

		}

		.select2-container--open {

			z-index: 9999999999 !important;

		}
	</style>




				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
							
							<span id="clickableFITBox_1" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('1');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_1']==''){ echo "Inclusion"; }else{ echo $editresult['title_1']; } ?>" name="IncFITTextBox_1" id="IncFITTextBox_1" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_1" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('1');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_1" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('1');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_1"><?php if($editresult['title_1']==''){ echo "Inclusion"; }else{ echo ucwords($editresult['title_1']); } ?></div>

						
						
						<span class="redmind"></span></div>
						<textarea name="inclusion" rows="3" class="gridfield" id="inclusion" displayname="Inclusion"><?php echo stripslashes($editresult['inclusion']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableFITBox_2" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('2');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_2']==''){ echo "Exclusion"; }else{ echo $editresult['title_2']; } ?>" name="IncFITTextBox_2" id="IncFITTextBox_2" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_2" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('2');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_2" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('2');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_2"><?php if($editresult['title_2']==''){ echo "Exclusion"; }else{ echo ucwords($editresult['title_2']); } ?></div>
						
						</div>
						<textarea name="exclusion" rows="3" class="gridfield " id="exclusion"><?php echo stripslashes($editresult['exclusion']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableFITBox_3" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('3');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_3']==''){ echo "Terms Condition"; }else{ echo $editresult['title_3']; } ?>" name="IncFITTextBox_3" id="IncFITTextBox_3" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_3" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('3');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_3" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('3');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_3"><?php if($editresult['title_3']==''){ echo "Terms Condition"; }else{ echo ucwords($editresult['title_3']); } ?></div>
						
						</div>
						<textarea name="termscondition" rows="3" class="gridfield " id="termscondition"><?php echo stripslashes($editresult['termscondition']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableFITBox_4" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('4');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_4']==''){ echo "Cancelation"; }else{ echo $editresult['title_4']; } ?>" name="IncFITTextBox_4" id="IncFITTextBox_4" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_4" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('4');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_4" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('4');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_4"><?php if($editresult['title_4']==''){ echo "Cancelation"; }else{ echo ucwords($editresult['title_4']); } ?></div>
						
						</div>
						<textarea name="cancelation" rows="3" class="gridfield " id="cancelation"><?php echo stripslashes($editresult['cancelation']); ?></textarea>
					</label>
				</div>


				<!-- Started ---- Service upgradation and OptionalTour sec -->
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableFITBox_5" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('5');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_5']==''){ echo "Service Upgradation"; }else{ echo $editresult['title_5']; } ?>" name="IncFITTextBox_5" id="IncFITTextBox_5" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_5" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('5');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_5" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('5');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_5"><?php if($editresult['title_5']==''){ echo "Service Upgradation"; }else{ echo ucwords($editresult['title_5']); } ?></div>
						
						</div>
						<textarea name="serviceupgradation" rows="3" class="gridfield " id="serviceupgradation"><?php echo stripslashes($editresult['serviceupgradation']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableFITBox_6" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('6');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_6']==''){ echo "Optional Tour"; }else{ echo $editresult['title_6']; } ?>" name="IncFITTextBox_6" id="IncFITTextBox_6" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_6" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('6');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_6" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('6');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_6"><?php if($editresult['title_6']==''){ echo "Optional Tour"; }else{ echo ucwords($editresult['title_6']); } ?></div>
						
						</div>
						<textarea name="optionaltour" rows="3" class="gridfield " id="optionaltour"><?php echo stripslashes($editresult['optionaltour']); ?></textarea>
					</label>
				</div>
				<!-- Started ---- Service upgradation and OptionalTour sec -->


				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableFITBox_7" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('7');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_7']==''){ echo "Payment Policy"; }else{ echo $editresult['title_7']; } ?>" name="IncFITTextBox_7" id="IncFITTextBox_7" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_7" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('7');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_7" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('7');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_7"><?php if($editresult['title_7']==''){ echo "Payment Policy"; }else{ echo ucwords($editresult['title_7']); } ?></div>
						
						</div>
						<textarea name="paymentpolicy" rows="3" class="gridfield " id="paymentpolicy"><?php echo stripslashes($editresult['paymentpolicy']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
							
						<span id="clickableFITBox_8" class="fa fa-pencil overview_cls" onclick="editFITOverviewTitle('8');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_8']==''){ echo "Remarks"; }else{ echo $editresult['title_8']; } ?>" name="IncFITTextBox_8" id="IncFITTextBox_8" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveFITTitle_8" class="actionbtn" style="background:#233a49;" onclick="saveFITTitleText('8');">Save</div>
								<?php } ?>
								<div  id="cancelFITTitle_8" class="actionbtn" style="background:red;" onclick="cancelFITTitleText('8');">Cancel</div>
								
								<div style="display:inline-block;" id="displayFITTitle_8"><?php if($editresult['title_8']==''){ echo "Remarks"; }else{ echo ucwords($editresult['title_8']); } ?></div>

						</div>
						<textarea name="remarks" rows="3" class="gridfield " id="remarks"><?php echo stripslashes($editresult['remarks']); ?></textarea>
					</label>
				</div>

				<div class="" style="display: flex;width: 100%;">
					<div class="griddiv" style="width: 50%;">
						<label>
							<div class="gridlable">status</div>
							<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">
								<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>
								<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>
							</select>
						</label>
					</div>
						<!-- by default yes and no option added -->
						<div class="griddiv" style="width: 50%;">
							<label>
								<div class="gridlable">Default</div>
								<select id="byDefault" type="text" class="gridfield" name="byDefault" displayname="Default" autocomplete="off" style="width: 100%;">
									
									<option value="0" <?php if ($editresult['byDefault'] == '0') { ?>selected="selected" <?php } ?>>No</option>
									<option value="1" <?php if ($editresult['byDefault'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>
								</select>
							</label>
						</div>
				</div>



				<input name="editId" type="hidden" id="editId" value="<?php echo $id ; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_FITInculsionsIExculsionsITCICancellationPolicy" />
			</form>

					<script>
						function editFITOverviewTitle(param){
							// if(param=='1'){
								$("#clickableFITBox_"+param).hide();
								$("#displayFITTitle_"+param).hide();
								$("#IncFITTextBox_"+param).show();
								$("#saveFITTitle_"+param).css('display','inline-block');
								$("#cancelFITTitle_"+param).css('display','inline-block');
							// }

						
						}

						

						function saveFITTitleText(param){
							// if(param=='1'){
								
								var title = $("#IncFITTextBox_"+param).val();

								$("#displayFITTitle_"+param).load(`final_frmaction.php?action=updateFITINCTitleText&id=<?php echo $editresult['id']; ?>&titleText=${encodeURI(title)}&param=${param}`);

								$("#clickableFITBox_"+param).show();
								$("#displayFITTitle_"+param).css('display','inline-block');
								$("#IncFITTextBox_"+param).hide();
								$("#saveFITTitle_"+param).css('display','none');
								$("#cancelFITTitle_"+param).css('display','none');
							// }

						
						}

						function cancelFITTitleText(param){
							// if(param=='1'){
								$("#clickableFITBox_"+param).show();
								$("#displayFITTitle_"+param).show();
								$("#IncFITTextBox_"+param).hide();
								$("#saveFITTitle_"+param).css('display','none');
								$("#cancelFITTitle_"+param).css('display','none');
							// }
						}

					</script>

	<style>
	.overview_cls{
		border: 1px solid #5b9d50;
		padding: 4px 6px;
		font-size: 20px;
		color: #5b9d50;
		background: #efefef;
		cursor:pointer;
		border-radius: 4px;
		margin-bottom: 5px;
		
				}
	.actionbtn{
		display: none;
		cursor: pointer;
		width: 50px;
		padding: 5px 10px;
		color: #fff;
		font-weight: 500;
		font-size: 15px;
		text-align: center;
		border-radius: 5px;
		}
</style>

			<script src="tinymce/tinymce.min.js"></script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#inclusion",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#exclusion",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#termscondition",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#cancelation",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#paymentpolicy",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#remarks",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});


				
				// Started ----js Service upgradation and Optional Tour sec  
				tinymce.init({
					selector: "#serviceupgradation",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
				tinymce.init({
					selector: "#optionaltour",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
				// Ended ----js Service upgradation and Optional Tour sec 
			</script>
			
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="  Save  " onclick="formValidation('addmasters','submitbtn','0');" />
					</td>
					<td style="padding-right:20px;">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
					</td>
				</tr>
			</table>
		</div>
	</div>

<?php }
// ended fit inclusion and exclusion



// started Git inclusion and exclusion 

if ($_GET['action'] == 'addedit_GITInculsionsIExculsionsITCICancellationPolicy' && $_GET['sectiontype'] == 'GITInculsionsIExculsionsITCICancellationPolicy') {

	if ($_GET['id'] != '') {
		$id = clean($_GET['id']);
		$select1 = '*';
		$where1 = 'id="' .$id. '"';
		$rs1 = GetPageRecord($select1, 'gitIncExcMaster', $where1);
		$editresult = mysqli_fetch_array($rs1);
		$editdestinationId = clean($editresult['destinationId']);

		// $finalweekendDays = explode(",", $editresult['destinationId']);
	}
?>
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>

	<div class="contentclass">
		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
											echo 'Edit';
										} else {
											echo 'Add';
										} ?>&nbsp;&nbsp;GIT Inculsions I Exculsions</h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
				<div class="griddiv">
					<label>
						<div class="gridlable">Name<span class="redmind"></span></div>
						<input type="text" name="gitName" id="gitName" class="gridfield" value="<?php echo $editresult['gitName']; ?>">
					</label>
				</div>
				<!-- <div class="griddiv">
					<label>
						<div class="gridlable">Destination<span class="redmind"></span></div>
						<input type="text" name="destinationId" id="destinationId" class="gridfield" value="<?php echo $editresult['destination']; ?>">
					</label>
				</div> -->


				<!-- new added for destination fields by islam -->
				
				<div class="griddiv"><label>
					<!-- destination code -->
							<div class="gridlable">Destination<span class="redmind"></span></div>
							<select id="destinationIda" multiple="multiple" name="destinationId[]" class="gridfield js-example-basic-multiple" displayname="Destination" autocomplete="off">
							<option value="All" <?php if($editdestinationId=='All') { echo 'selected="selected"';} ?> >All</option>
								<?php
								$select = '';
								$where = '';
								$rs = '';
								$select = '*';
								$where = ' 1 and deletestatus = 0 order by name asc';
								$rs = GetPageRecord($select, _DESTINATION_MASTER_, $where);
								$alldest=explode(',',$editdestinationId);  
								while ($resListing = mysqli_fetch_array($rs)) {
								?>
								<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> <?php } ?> 
							</select>
						</label>
				</div>
				
				<script>
			$('.js-example-basic-multiple').select2();  
	 		// $('.js-example-basic-multiple').on("select2:select", function (e) { 
        //    var data = e.params.data.text;
        //    if(data=='All'){
        //     $(".js-example-basic-multiple > option").prop("selected","selected");
        //     $(".js-example-basic-multiple").trigger("change");
        //    }
    //   }); 
				</script>
					<style>
		.select2-container {

			width: 100% !important;
			;

		}

		.select2-container--open {

			z-index: 9999999999 !important;

		}
	</style>




				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_1" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('1');"></span>

								<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_1']==''){ echo "Inclusion"; }else{ echo $editresult['title_1']; } ?>" name="IncGITTextBox_1" id="IncGITTextBox_1" style="width:70%; display:none; margin-bottom:5px;">
								<?php if($editresult['id']>0){ ?>
								<div id="saveGITTitle_1" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('1');">Save</div>
								<?php } ?>
								<div  id="cancelGITTitle_1" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('1');">Cancel</div>
								
								<div style="display:inline-block;" id="displayGITTitle_1"><?php if($editresult['title_1']==''){ echo "Inclusion"; }else{ echo ucwords($editresult['title_1']); } ?></div>
						
						<span class="redmind"></span></div>
						<textarea name="inclusion" rows="3" class="gridfield" id="inclusion" displayname="Inclusion"><?php echo stripslashes($editresult['inclusion']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_2" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('2');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_2']==''){ echo "Exclusion"; }else{ echo $editresult['title_2']; } ?>" name="IncGITTextBox_2" id="IncGITTextBox_2" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_2" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('2');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_2" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('2');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_2"><?php if($editresult['title_2']==''){ echo "Exclusion"; }else{ echo ucwords($editresult['title_2']); } ?></div>

						</div>
						<textarea name="exclusion" rows="3" class="gridfield " id="exclusion"><?php echo stripslashes($editresult['exclusion']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
							
						<span id="clickableGITBox_3" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('3');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_3']==''){ echo "Terms Condition"; }else{ echo $editresult['title_3']; } ?>" name="IncGITTextBox_3" id="IncGITTextBox_3" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_3" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('3');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_3" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('3');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_3"><?php if($editresult['title_3']==''){ echo "Terms Condition"; }else{ echo ucwords($editresult['title_3']); } ?></div>

						</div>
						<textarea name="termscondition" rows="3" class="gridfield " id="termscondition"><?php echo stripslashes($editresult['termscondition']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_4" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('4');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_4']==''){ echo "Cancelation"; }else{ echo $editresult['title_4']; } ?>" name="IncGITTextBox_4" id="IncGITTextBox_4" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_4" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('4');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_4" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('4');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_4"><?php if($editresult['title_4']==''){ echo "Cancelation"; }else{ echo ucwords($editresult['title_4']); } ?></div>
						
						</div>
						<textarea name="cancelation" rows="3" class="gridfield " id="cancelation"><?php echo stripslashes($editresult['cancelation']); ?></textarea>
					</label>
				</div>

				<!-- Started ---- Service upgradation and OptionalTour sec -->
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_5" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('5');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_5']==''){ echo "Service Upgradation"; }else{ echo $editresult['title_5']; } ?>" name="IncGITTextBox_5" id="IncGITTextBox_5" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_5" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('5');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_5" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('5');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_5"><?php if($editresult['title_5']==''){ echo "Service Upgradation"; }else{ echo ucwords($editresult['title_5']); } ?></div>

						</div>
						<textarea name="serviceupgradation" rows="3" class="gridfield " id="serviceupgradation"><?php echo stripslashes($editresult['serviceupgradation']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_6" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('6');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_6']==''){ echo "Optional Tour"; }else{ echo $editresult['title_6']; } ?>" name="IncGITTextBox_6" id="IncGITTextBox_6" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_6" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('6');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_6" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('6');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_6"><?php if($editresult['title_6']==''){ echo "Optional Tour"; }else{ echo ucwords($editresult['title_6']); } ?></div>

						
						</div>
						<textarea name="optionaltour" rows="3" class="gridfield " id="optionaltour"><?php echo stripslashes($editresult['optionaltour']); ?></textarea>
					</label>
				</div>
				<!-- Started ---- Service upgradation and OptionalTour sec -->
				

				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_7" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('7');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_7']==''){ echo "Payment Policy"; }else{ echo $editresult['title_7']; } ?>" name="IncGITTextBox_7" id="IncGITTextBox_7" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_7" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('7');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_7" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('7');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_7"><?php if($editresult['title_7']==''){ echo "Payment Policy"; }else{ echo ucwords($editresult['title_7']); } ?></div>
						
						</div>
						<textarea name="paymentpolicy" rows="3" class="gridfield " id="paymentpolicy"><?php echo stripslashes($editresult['paymentpolicy']); ?></textarea>
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable" style="width:100%;">
						
						<span id="clickableGITBox_8" class="fa fa-pencil overview_cls" onclick="editGITOverviewTitle('8');"></span>

						<input type="text" class="gridfield inputBoxcls" value="<?php if($editresult['title_8']==''){ echo "Remarks"; }else{ echo $editresult['title_8']; } ?>" name="IncGITTextBox_8" id="IncGITTextBox_8" style="width:70%; display:none; margin-bottom:5px;">
						<?php if($editresult['id']>0){ ?>
						<div id="saveGITTitle_8" class="actionbtn" style="background:#233a49;" onclick="saveGITTitleText('8');">Save</div>
						<?php } ?>
						<div  id="cancelGITTitle_8" class="actionbtn" style="background:red;" onclick="cancelGITTitleText('8');">Cancel</div>

						<div style="display:inline-block;" id="displayGITTitle_8"><?php if($editresult['title_8']==''){ echo "Remarks"; }else{ echo ucwords($editresult['title_8']); } ?></div>
						
						</div>
						<textarea name="remarks" rows="3" class="gridfield " id="remarks"><?php echo stripslashes($editresult['remarks']); ?></textarea>
					</label>
				</div>
				
				<div class="" style="display: flex;width: 100%;">
					<div class="griddiv" style="width: 50%;">
						<label>
							<div class="gridlable">status</div>
							<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" style="width: 100%;">
								<option value="1" <?php if ($editresult['status'] == '1') { ?>selected="selected" <?php } ?>>Active</option>
								<option value="0" <?php if ($editresult['status'] == '0') { ?>selected="selected" <?php } ?>>In Active</option>
							</select>
						</label>
					</div>
					<!-- by default yes and no option added -->
					<div class="griddiv" style="width: 50%;">
						<label>
							<div class="gridlable">Default</div>
							<select id="byDefault" type="text" class="gridfield" name="byDefault" displayname="Default" autocomplete="off" style="width: 100%;">
								
								<option value="0" <?php if ($editresult['byDefault'] == '0') { ?>selected="selected" <?php } ?>>No</option>
								<option value="1" <?php if ($editresult['byDefault'] == '1') { ?>selected="selected" <?php } ?>>Yes</option>
							</select>
						</label>
					</div>
				</div>


				<input name="editId" type="hidden" id="editId" value="<?php echo $id ; ?>" />
				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
				<input name="action" type="hidden" id="action" value="addedit_GITInculsionsIExculsionsITCICancellationPolicy" />
			</form>

			
					<script>
						function editGITOverviewTitle(param){
							// if(param=='1'){
								$("#clickableGITBox_"+param).hide();
								$("#displayGITTitle_"+param).hide();
								$("#IncGITTextBox_"+param).show();
								$("#saveGITTitle_"+param).css('display','inline-block');
								$("#cancelGITTitle_"+param).css('display','inline-block');
							// }

						
						}

						

						function saveGITTitleText(param){
							// if(param=='1'){
								
								var title = $("#IncGITTextBox_"+param).val();

								$("#displayGITTitle_"+param).load(`final_frmaction.php?action=updateGITINCTitleText&id=<?php echo $editresult['id']; ?>&titleText=${encodeURI(title)}&param=${param}`);

								$("#clickableGITBox_"+param).show();
								$("#displayGITTitle_"+param).css('display','inline-block');
								$("#IncGITTextBox_"+param).hide();
								$("#saveGITTitle_"+param).css('display','none');
								$("#cancelGITTitle_"+param).css('display','none');
							// }

						
						}

						function cancelGITTitleText(param){
							// if(param=='1'){
								$("#clickableGITBox_"+param).show();
								$("#displayGITTitle_"+param).show();
								$("#IncGITTextBox_"+param).hide();
								$("#saveGITTitle_"+param).css('display','none');
								$("#cancelGITTitle_"+param).css('display','none');
							// }
						}

					</script>

	<style>
	.overview_cls{
		border: 1px solid #5b9d50;
		padding: 4px 6px;
		font-size: 20px;
		color: #5b9d50;
		background: #efefef;
		cursor:pointer;
		border-radius: 4px;
		margin-bottom: 5px;
		
				}
	.actionbtn{
		display: none;
		cursor: pointer;
		width: 50px;
		padding: 5px 10px;
		color: #fff;
		font-weight: 500;
		font-size: 15px;
		text-align: center;
		border-radius: 5px;
		}
</style>



			<script src="tinymce/tinymce.min.js"></script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#inclusion",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#exclusion",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#termscondition",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#cancelation",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#paymentpolicy",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#remarks",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});


				// Started ----js Service upgradation and Optional Tour sec  
				tinymce.init({
					selector: "#serviceupgradation",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
				tinymce.init({
					selector: "#optionaltour",
					themes: "modern",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
				// Ended ----js Service upgradation and Optional Tour sec
			</script>
			
		</div>
		<div id="buttonsbox" style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="  Save  " onclick="formValidation('addmasters','submitbtn','0');" />
					</td>
					<td style="padding-right:20px;">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
					</td>
				</tr>
			</table>
		</div>
	</div>

<?php }
// ended Git inclusion and exclusion



if($_GET['action']=='addedit_proposalsettings' ){ 

	if($_GET['id']!=''){

		$id=clean($_GET['id']);

		$select1='*';  

		$where1='id='.$id.''; 

		$rs1=GetPageRecord($select1,'proposalSettingMaster',$where1); 

 		$editresult=mysqli_fetch_array($rs1); 

	}

	?>

<div class="contentclass">

<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Proposal Settings </h1>

  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >

<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td ><div class="griddiv">
    	<label>
				<div class="gridlable">Proposal&nbsp;Name<span class="redmind"></span></div>

				<input name="proposalName" type="text" class="gridfield" id="proposalName" displayname="Name" value="<?php echo strip($editresult['proposalName']); ?>" readonly/>

				</label>

		</div>
	</td>
</tr>
<tr>
	<td>
		<div class="griddiv">
    	<label>
				<div class="gridlable">Proposal&nbsp;Num</div>

				<input name="proposalNum" class="gridfield " id="proposalNum" displayname="Name" value="<?php echo strip($editresult['proposalNum']); ?>"  style="background-color: #efefef;cursor: not-allowed;" readonly />

				</label>

		</div>
	</td> 
</tr> 

<tr>
	<td>
		<div class="griddiv" style="border:none !important;"><label> 

		<div class="gridlable" style="width: 155px  !important;padding-top: 10px;vertical-align: top;">Select Background Color: </div>

		<input type="color" id="backgroundColor" name="backgroundColor" value="<?php if($editresult['proposalColor']!=''){ echo $editresult['proposalColor']; }else{ echo '#7D2FFF'; } ?>" style="width: 240px; height:36px; border: 1px solid #ccc;">

		</label></div></td></tr>

<tr><td>
<div class="griddiv" style="border:none !important;">
<label> 

<div class="gridlable" style="width: 155px  !important;padding-top: 10px;vertical-align: top;">Select Text Color: </div>

<input type="color" id="textColor" name="textColor" value="<?php if($editresult['textColor']!=''){ echo $editresult['textColor']; }else{ echo '#ffffff'; } ?>" style="width: 240px; height:36px; border: 1px solid #ccc;">

</label>

</div>
</td></tr>
<tr>
	<td>
		<div class="griddiv">
    	<label>
			<div class="gridlable">Photo&nbsp;Dimensions</div>
			<select id="photoDimension" name="photoDimension" class="gridfield" autocomplete="off" >
          <optgroup label="Proposal Images">
            <option value="790x100" <?php if($editresult['photoDimension'] == '790x100'){ ?> selected="selected" <?php } ?> >790x100</option>
            <option value="800x300" <?php if($editresult['photoDimension'] == '800x300'){ ?> selected="selected" <?php } ?> >800x300</option>
            <option value="750x500" <?php if($editresult['photoDimension'] == '750x500'){ ?> selected="selected" <?php } ?> >750x500</option>
          </optgroup>
				</select>
				</label>
		</div>
	</td> 
</tr> 
</table>
<input name="proposalNum" type="hidden" class="gridfield " id="proposalNum" displayname="Name" value="<?php echo strip($editresult['proposalNum']); ?>"  style="background-color: #efefef;cursor: not-allowed;" disabled />   
<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
<input name="action" type="hidden" id="action" value="addedit_proposalsettings" />
</form>
  </div>

  <div id="buttonsbox"  style="text-align:center;">

 <table border="0" align="right" cellpadding="0" cellspacing="0">

      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

      </tr>

   </table>

</div></div>

	<?php 

} 



// proposal header footer code start

if($_GET['action']=='addedit_proposalheaderfooter' ){ 

	if($_GET['id']!=''){

		$id=clean($_GET['id']);

		$select1='*';  

		$where1='id='.$id.''; 

		$rs1=GetPageRecord($select1,'proposalSettingMaster',$where1); 

 		$editresult=mysqli_fetch_array($rs1); 

	}

	?>

<div class="contentclass">

<h1 style="text-align:left;"><?php if($_REQUEST['id']!='headerImage' && ($editresult['footerImage']!='' || $editresult['']!='')){ echo 'Edit'; } else { echo 'Add'; } ?> Proposal <?php echo $_GET['type']; ?> </h1>

  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >

<?php 
if ($_GET['type']=='header') { ?>
	<tr>
		<td>
			<div>
				<img src="upload/proposal/<?php if($editresult['headerImage']!='') {echo $editresult['headerImage']; }else{ echo 'no-image.png';} ?>" width="150">
			</div>
		</td>
	</tr>	
<?php }else{ ?>
	<tr>
		<td>
			<div>
				<img src="upload/proposal/<?php if($editresult['footerImage']!='') {echo $editresult['footerImage']; }else{ echo 'no-image.png';} ?>" width="150">
			</div>
		</td>
	</tr>
<?php } ?>


<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td ><div class="griddiv">
    	<label>
				<div class="gridlable">Proposal&nbsp;<?php echo $_GET['type']; ?></div>

				<input name="Image" type="file" class="gridfield" id="headerImage" displayname="Proposal Header" />

				</label>

		</div>
	</td>
</tr>

</table>   
<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
<input name="action" type="hidden" id="action" value="addedit_proposalheaderfooter" />
<?php 
if ($_GET['type']=='header') { ?>
	<input name="old_Image" type="hidden" id="action" value="<?php echo $editresult['headerImage']; ?>" />
	<input name="imagefor" type="hidden" id="action" value="header" />
<?php }else{ ?>
	<input name="old_Image" type="hidden" id="action" value="<?php echo $editresult['footerImage']; ?>" />
	<input name="imagefor" type="hidden" id="action" value="footer" />
<?php } ?>

</form>
  </div>

  <div id="buttonsbox"  style="text-align:center;">

 <table border="0" align="right" cellpadding="0" cellspacing="0">

      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

      </tr>

   </table>

</div></div>

	<?php 

} 


// proposal header footer code end

		// letter maater

		if ($_GET['action'] == 'addedit_lettermaster') {



			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

				$select1 = '*';

				$where1 = 'id=' . $id . '';

				$rs1 = GetPageRecord($select1, 'letterMaster', $where1);

				$editresult = mysqli_fetch_array($rs1);
			}

		?>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Letter </h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="5">

							<tr>

								<td width="50%" colspan="2">
									<div class="griddiv">
										<label>

											<div class="gridlable">Name<span class="redmind"></span></div>

											<input name="letterName" type="text" class="gridfield validate" id="letterName" displayname="Name" value="<?php echo strip($editresult['letterName']); ?>" />

											<input name="letterType" type="hidden" class="gridfield" id="letterType" displayname="Welcome Letter Type" value="<?php echo $editresult['letterType']; ?>" />

										</label>

									</div>
								</td>

							</tr>
							<tr>
								<td>
								<div class="griddiv">
										<label>

											<div class="gridlable">Greetings Note<span class="redmind"></span></div>

											<input name="greetingNote" type="text" class="gridfield validate" id="greetingNote" displayname="Greetings Note" value="<?php echo strip($editresult['greetingNote']); ?>"  />

										</label>

									</div>
								</td>
							</tr>
							<tr>
								<td>
								<div class="griddiv">
										<label>

											<div class="gridlable" style="padding-bottom: 10px;">Welcome Note<span class="redmind"></span></div>
									<textarea name="welcomeNote" id="welcomeNote" style="width: 98%; padding:4px; height:200px;"><?php echo strip($editresult['welcomeNote']); ?></textarea>
									</label>

									</div>
									<script src="tinymce/tinymce.min.js"></script>
								<script type="text/javascript">
								
													tinymce.init({
														selector: "#welcomeNote",
														paste_enable_default_filters : false,
														selector: 'textarea',
															plugins: 'paste',
															menubar: 'edit',
															toolbar: 'paste',
															paste_word_valid_elements: '',
															themes: "modern",

														plugins: [

															"advlist autolink lists link image charmap print preview anchor",

															"searchreplace visualblocks code fullscreen"

														],
														toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

														forced_root_block: "" ,
														force_br_newlines: true,
														force_p_newlines: false,


														setup: function (editor) {
															editor.on('init', function (e) {
																editor.setContent(parameters);
															});
														}

													});
												</script>
								</td>
								</tr>

							<tr>
							<td colspan="2">
									<div class="griddiv"><label>

											<div class="gridlable">Status</div>

											<select id="status" name="status" class="gridfield " autocomplete="off">

												<option value="1" <?php if ($editresult['status'] == '1') { ?> selected="selected" <?php } ?>>Active</option>

												<option value="0" <?php if ($editresult['status'] == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

											</select>

										</label>

									</div>
								</td>
							</tr>

						</table>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="dmcId" type="hidden" id="editId" value="<?php echo $editresult2['id']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_lettermaster" />

					</form>





				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>





		<?php

		}

		if ($_GET['action'] == 'addedit_guidepaxslabmaster') {

			if ($_GET['editId'] != '') {

				$editId = clean($_GET['editId']);

				$select1 = '*';

				$where1 = 'id=' . $editId . '';

				$rs1 = GetPageRecord($select1, 'guidePaxSlabMaster', $where1);

				$editresult = mysqli_fetch_array($rs1);

				$minPax = clean($editresult['minPax']);

				$maxPax = clean($editresult['maxPax']);
			}

		?>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Tour Escort Pax Slab Master</h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="5">

							<tr>

								<td>
									<div class="griddiv"><label>

											<div class="gridlable">Min&nbsp;Pax<span class="redmind"></span></div>

											<input name="minPax" type="number" class="gridfield validate" id="minPax" displayname="minPax" value="<?php echo $minPax; ?>" maxlength="100" />

										</label>

									</div>
								</td>

								<td>
									<div class="griddiv"><label>

											<div class="gridlable">Max&nbsp;Pax<span class="redmind"></span></div>

											<input name="maxPax" type="number" class="gridfield validate" id="maxPax" displayname="maxPax" value="<?php echo $maxPax; ?>" maxlength="100" />

										</label>

									</div>
								</td>



								<td>

									<div class="griddiv"><label>

											<div class="gridlable">Status</div>

											<select class="gridfield" name="status" id="status">

												<option value="1" <?php if ($editresult['status'] == 1 || $editresult['id'] == '') { ?>selected="selected" <?php } ?>>Active</option>

												<option value="0" <?php if ($editresult['status'] == 0 && $editresult['id'] != '') { ?>selected="selected" <?php } ?>>Inactive</option>

											</select>

										</label>

									</div>

								</td>

							</tr>



							<style>
								.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {

									width: 100% !important;

								}
							</style>

						</table>

						<input name="editId" type="hidden" value="<?php echo $_GET['editId']; ?>" />

						<input name="module" type="hidden" value="guidepaxslabmaster" />

						<input name="action" type="hidden" id="action" value="addedit_guidepaxslabmaster" />

					</form>





				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>





			<?php }



		if ($_GET['action'] == 'addedit_letterLanguage') {



			if ($_GET['id'] != '') {



				$id = clean($_GET['id']);



				$select1 = '*';



				$where1 = 'id=' . $id . '';



				$rs1 = GetPageRecord($select1, 'letterMaster', $where1);



				$editresult = mysqli_fetch_array($rs1);



				$name = clean($editresult['letterName']);





			?>



				<style type="text/css">
					.saveBtn {
						font-size: 20px !important;

						color: #006699;

						cursor: pointer;

						/* float: right; */

						display: flex;

						padding: 5px 7px;

						border: 0px solid #ddd;

						border-radius: 1px;

					}
				</style>



				<div class="contentclass">

					<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
														echo 'Edit';
													} else {
														echo 'Add';
													} ?> &nbsp;<?php echo $name; ?></h1>



					<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">



						<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">





							<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">



								<tbody>



									<tr>

										<td>S.No</td>

										<td>Language</td>

										<td>Language Description</td>

									</tr>

									<script src="tinymce/tinymce.min.js"></script>

									<?php

									// $count = 1;

									$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');

									while ($languageDetails = mysqli_fetch_array($rs)) {
										$count = $languageDetails['id'];
										?>

										<tr>

											<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>

											<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>

											<td bgcolor="#FFFFFF">

												<script type="text/javascript">
													tinymce.init({



														selector: "#description<?php echo $count ?>",



														themes: "modern",



														plugins: [



															"advlist autolink lists link image charmap print preview anchor",



															"searchreplace visualblocks code fullscreen"



														],



														toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"



													});
												</script>

												<?php

												$rs1 = GetPageRecord('*', 'letterLanguageMaster', '1 and letterId="' . $_GET['id'] . '" and languageId="' . $languageDetails['id'] . '"');

												$editresult = mysqli_fetch_array($rs1);

												?>

												<textarea name="description<?php echo $count; ?>" class="gridfield" id="description<?php echo $count ?>"><?php echo stripslashes($editresult['description']); ?></textarea>

												<input type="hidden" name="letterId<?php echo $count; ?>" value="<?php echo $_GET['id'] ?>">

												<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">

												<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">

											</td>

										</tr>

									<?php 
									//$count++;
									} ?>

								</tbody>

							</table>

							<input type="hidden" name="action" value="saveLetterLanguage">

							 

							<div style="float: right;">

								<input type="submit" name="savelanguage" value="Save" class="bluembutton submitbtn">

								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

							</div>

						</form>

					</div>

				</div>

			<?php }
		}


		if ($_GET['action'] == 'addedit_queryOverviewLanguage' && $_GET['sectiontype'] == 'queryOverview') {

			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

			?>

				<style type="text/css">
					.saveBtn {
						font-size: 20px !important;
						color: #006699;
						cursor: pointer;
						/* float: right; */
						display: flex;
						padding: 5px 7px;
						border: 0px solid #ddd;
						border-radius: 1px;
					}
				</style>

				<div class="contentclass">
					<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
														echo 'Edit';
													} else {
														echo 'Add';
													} ?>&nbsp;Overview</h1>

					<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

						<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">


							<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

								<tbody>

									<tr>
										<td>S.No</td>
										<td>Language</td>
										<td>Overview</td>
										<td>Highlights</td>
										<td>Itinerary introduction</td>
										<td>Itinerary Summary</td>
									</tr>
									<?php
									//$count = 1;
									$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
									$totalrow = mysqli_num_rows($rs);
									while ($languageDetails = mysqli_fetch_array($rs)) {
										$count = $languageDetails['id'];
										$rs1 = GetPageRecord('*', 'overviewLanguageMaster', '1 and overviewId="' . $_GET['id'] . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
									?>
										<tr>
											<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
											<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="overview<?php echo $count; ?>" class="gridfield" id="overview<?php echo $count ?>"><?php echo stripslashes($editresult['overview']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="highlight<?php echo $count; ?>" class="gridfield" id="highlight<?php echo $count ?>"><?php echo stripslashes($editresult['highlight']); ?></textarea>
											</td>

											<!-- itineraryintr,itinerarysumm -->
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="itineraryIntro<?php echo $count; ?>" class="gridfield" id="itineraryIntro<?php echo $count ?>"><?php echo stripslashes($editresult['itineraryIntro']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="itinerarySummary<?php echo $count; ?>" class="gridfield" id="itinerarySummary<?php echo $count ?>"><?php echo stripslashes($editresult['itinerarySummary']); ?></textarea>
											</td>


											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</tr>
									<?php 
									//$count++;
									} ?>
								</tbody>
								
							</table>
							<input type="hidden" name="overviewId" value="<?php echo $_GET['id'] ?>">
							<input type="hidden" name="action" value="saveOverviewLanguage">
							<input type="hidden" name="count" value="<?php echo $totalrow; ?>">
							<div style="float: right;">
								<input type="submit" name="saveOverviewLanguage" value="Save" class="bluembutton submitbtn">
								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
							</div>
						</form>
					</div>
				</div>
			<?php }
		}



		// fit veiw language code started 
		if ($_GET['action'] == 'addedit_queryfitLanguage' && $_GET['sectiontype'] == 'queryFit') {





			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

				$select1 = '*';
				$where1 = 'id="' .$id. '"';
				$rs1 = GetPageRecord($select1, 'fitIncExcMaster', $where1);
				$editresult = mysqli_fetch_array($rs1);
				$editdestinationId = clean($editresult['destinationId']);

			?>

				<style type="text/css">
					.saveBtn {
						font-size: 20px !important;
						color: #006699;
						cursor: pointer;
						/* float: right; */
						display: flex;
						padding: 5px 7px;
						border: 0px solid #ddd;
						border-radius: 1px;
					}
				</style>

				<div class="contentclass">
					<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
														echo 'Edit';
													} else {
														echo 'Add';
													} ?>&nbsp;FIT Inclusion</h1>

					<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

						<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">


							<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

								<tbody>

									<tr>
										<td>S.No</td>
										<td>Language</td>
										<td>
											<?php if($editresult['title_1']==''){ echo "Inclusion"; }else{ echo $editresult['title_1']; } ?>
										</td>
										<td>
										<?php if($editresult['title_2']==''){ echo "Exclusion"; }else{ echo $editresult['title_2']; } ?>										
										</td>
										<td>
											<?php if($editresult['title_3']==''){ echo "Terms Condition"; }else{ echo $editresult['title_3']; } ?>
										</td>
										<td>
											<?php if($editresult['title_4']==''){ echo "Cancelation"; }else{ echo $editresult['title_4']; } ?>	
										</td>
										<td>
											<?php if($editresult['title_7']==''){ echo "Payment Policy"; }else{ echo $editresult['title_7']; } ?>
										</td>
										<td>
											<?php if($editresult['title_5']==''){ echo "Service Upgradation"; }else{ echo $editresult['title_5']; } ?>
										</td>
										<td>
											<?php if($editresult['title_6']==''){ echo "Optional Tour"; }else{ echo $editresult['title_6']; } ?>
										</td>
										
										<td>
											<?php if($editresult['title_8']==''){ echo "Remarks"; }else{ echo $editresult['title_8']; } ?>
										</td>
									</tr>
									<?php
									//$count = 1;
									$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
									$totalrow = mysqli_num_rows($rs);
									while ($languageDetails = mysqli_fetch_array($rs)) {
										$count = $languageDetails['id'];
										$rs1 = GetPageRecord('*', 'fitLanguageMaster', '1 and fitId="' . $_GET['id'] . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
									?>
										<tr>
											<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
											<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="inclusion<?php echo $count; ?>" class="gridfield" id="inclusion<?php echo $count ?>"><?php echo stripslashes($editresult['inclusion']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="exclusion<?php echo $count; ?>" class="gridfield" id="exclusion<?php echo $count ?>"><?php echo stripslashes($editresult['exclusion']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="termscondition<?php echo $count; ?>" class="gridfield" id="termscondition<?php echo $count ?>"><?php echo stripslashes($editresult['termscondition']); ?></textarea>
											</td>
											
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="cancelation<?php echo $count; ?>" class="gridfield" id="cancelation<?php echo $count ?>"><?php echo stripslashes($editresult['cancelation']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="paymentpolicy<?php echo $count; ?>" class="gridfield" id="paymentpolicy<?php echo $count ?>"><?php echo stripslashes($editresult['paymentpolicy']); ?></textarea>
											</td>


											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="serviceupgradation<?php echo $count; ?>" class="gridfield" id="serviceupgradation<?php echo $count ?>"><?php echo stripslashes($editresult['serviceupgradation']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="optionaltour<?php echo $count; ?>" class="gridfield" id="optionaltour<?php echo $count ?>"><?php echo stripslashes($editresult['optionaltour']); ?></textarea>
											</td>


											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="remarks<?php echo $count; ?>" class="gridfield" id="remarks<?php echo $count ?>"><?php echo stripslashes($editresult['remarks']); ?></textarea>
											</td>
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</tr>
									<?php 
									//$count++;
									} ?>
								</tbody>
							</table>
							<input type="hidden" name="fitId" value="<?php echo $_GET['id'] ?>">
							<input type="hidden" name="action" value="saveFitLanguage">
							<input type="hidden" name="count" value="<?php echo $totalrow; ?>">
							<div style="float: right;">
								<input type="submit" name="saveFitLanguage" value="Save" class="bluembutton submitbtn">
								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
							</div>
						</form>
					</div>
				</div>
			<?php }
		}
		// fit view language code ended






		// git veiw language code started 
		if ($_GET['action'] == 'addedit_querygitLanguage' && $_GET['sectiontype'] == 'queryGit') {

			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);
				$select1 = '*';
				$where1 = 'id="' .$id. '"';
				$rs1 = GetPageRecord($select1, 'gitIncExcMaster', $where1);
				$editresult = mysqli_fetch_array($rs1);
				$editdestinationId = clean($editresult['destinationId']);

			?>

				<style type="text/css">
					.saveBtn {
						font-size: 20px !important;
						color: #006699;
						cursor: pointer;
						/* float: right; */
						display: flex;
						padding: 5px 7px;
						border: 0px solid #ddd;
						border-radius: 1px;
					}
				</style>

				<div class="contentclass">
					<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
														echo 'Edit';
													} else {
														echo 'Add';
													} ?>&nbsp;Git Inclusion</h1>

					<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

						<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">


							<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

								<tbody>

									<tr>
										<td>S.No</td>
										<td>Language</td>
										<td>
											<?php if($editresult['title_1']==''){ echo "Inclusion"; }else{ echo $editresult['title_1']; } ?>
										</td>
										<td>
											<?php if($editresult['title_2']==''){ echo "Exclusion"; }else{ echo $editresult['title_2']; } ?>
										</td>
										<td>
											<?php if($editresult['title_3']==''){ echo "Terms Condition"; }else{ echo $editresult['title_3']; } ?>
										</td>
										<td>
											<?php if($editresult['title_4']==''){ echo "Cancelation"; }else{ echo $editresult['title_4']; } ?>
										</td>
										<td>
											<?php if($editresult['title_5']==''){ echo "Service Upgradation"; }else{ echo $editresult['title_5']; } ?>
										</td>
										<td>
											<?php if($editresult['title_6']==''){ echo "Optional Tour"; }else{ echo $editresult['title_6']; } ?>
										</td>
										<td>
											<?php if($editresult['title_7']==''){ echo "Payment Policy"; }else{ echo $editresult['title_7']; } ?>
										</td>
										<td>
											<?php if($editresult['title_8']==''){ echo "Remarks"; }else{ echo $editresult['title_8']; } ?>
										</td>
									</tr>
									<?php
									//$count = 1;
									$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
									$totalrow = mysqli_num_rows($rs);
									while ($languageDetails = mysqli_fetch_array($rs)) {
										$count = $languageDetails['id'];
										$rs1 = GetPageRecord('*', 'gitLanguageMaster', '1 and gitId="' . $_GET['id'] . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
									?>
										<tr>
											<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
											<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="inclusion<?php echo $count; ?>" class="gridfield" id="inclusion<?php echo $count ?>"><?php echo stripslashes($editresult['inclusion']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="exclusion<?php echo $count; ?>" class="gridfield" id="exclusion<?php echo $count ?>"><?php echo stripslashes($editresult['exclusion']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="termscondition<?php echo $count; ?>" class="gridfield" id="termscondition<?php echo $count ?>"><?php echo stripslashes($editresult['termscondition']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="cancelation<?php echo $count; ?>" class="gridfield" id="cancelation<?php echo $count ?>"><?php echo stripslashes($editresult['cancelation']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="serviceupgradation<?php echo $count; ?>" class="gridfield" id="serviceupgradation<?php echo $count ?>"><?php echo stripslashes($editresult['serviceupgradation']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="optionaltour<?php echo $count; ?>" class="gridfield" id="optionaltour<?php echo $count ?>"><?php echo stripslashes($editresult['optionaltour']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="paymentpolicy<?php echo $count; ?>" class="gridfield" id="paymentpolicy<?php echo $count ?>"><?php echo stripslashes($editresult['paymentpolicy']); ?></textarea>
											</td>
											<td bgcolor="#FFFFFF">
												<textarea rows="4" style="width: 100%" name="remarks<?php echo $count; ?>" class="gridfield" id="remarks<?php echo $count ?>"><?php echo stripslashes($editresult['remarks']); ?></textarea>
											</td>
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</tr>
									<?php 
									//$count++;
									} ?>
								</tbody>
							</table>
							<input type="hidden" name="fitId" value="<?php echo $_GET['id'] ?>">
							<input type="hidden" name="action" value="saveGitLanguage">
							<input type="hidden" name="count" value="<?php echo $totalrow; ?>">
							<div style="float: right;">
								<input type="submit" name="saveGitLanguage" value="Save" class="bluembutton submitbtn">
								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
							</div>
						</form>
					</div>
				</div>
			<?php }
		}
		// git view language code ended

		if ($_GET['action'] == 'fittermsinclusionlanguage' && $_GET['id'] != '') {

			?>
			<style type="text/css">
				table.table-bordered.dataTable tbody td {
					border: 0.01em solid #ccc;
				}
			</style>
			<div class="contentclass">
				<h1 style="text-align:left;">Inclusion Language</h1>

				<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

							<tbody>
								<tr>
									<td>S.No</td>
									<td>Language</td>
									<td>Inclusion Information</td>
								</tr>
								<?php
								// $count = 1;
								$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
								$countrow = mysqli_num_rows($rs);
								while ($languageDetails = mysqli_fetch_array($rs)) {
									$count = $languageDetails['id'];
									?>
									<tr>
										<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
										<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
										<td bgcolor="#FFFFFF">

											<script type="text/javascript">
												tinymce.init({

													selector: "#inclusion<?php echo $count ?>",

													themes: "modern",

													plugins: [

														"advlist autolink lists link image charmap print preview anchor",

														"searchreplace visualblocks code fullscreen"

													],

													toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

												});
											</script>
											<?php
											$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
											$editresult = mysqli_fetch_array($rs1);
											?>
											<textarea name="inclusion<?php echo $count; ?>" class="gridfield" id="inclusion<?php echo $count ?>"><?php echo stripslashes($editresult['inclusion']); ?></textarea>
											<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</td>
									</tr>
								<?php 
								//$count++;
								} ?>
							</tbody>
						</table>
						<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
						<input type="hidden" name="action" value="saveFitTermsInclusionLanguage">
						<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
						<div style="float: right;">
							<input type="submit" name="saveFitTermsInclusionLanguage" value="Save" class="bluembutton submitbtn">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
							<script>
								function closeEditor() {
									var count = $('.count').val();
									for (i = 1; i <= count; i++) {
										tinymce.remove('#inclusion' + i);
									}
								}
							</script>

						</div>
					</form>
				</div>
			</div>
		<?php }
		if ($_GET['action'] == 'fittermsexclusionlanguage' && $_GET['id'] != '') {

		?>
			<style type="text/css">
				table.table-bordered.dataTable tbody td {
					border: 0.01em solid #ccc;
				}
			</style>
			<div class="contentclass">
				<h1 style="text-align:left;">Exclusion Language</h1>

				<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

							<tbody>
								<tr>
									<td>S.No</td>
									<td>Language</td>
									<td>Exclusion Information</td>
								</tr>
								<?php
								// $count = 1;
								$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
								$countrow = mysqli_num_rows($rs);
								while ($languageDetails = mysqli_fetch_array($rs)) {
									$count = $languageDetails['id'];
									?>
									<tr>
										<td bgcolor="#FFFFFF"><?php echo $count; ?></td>
										<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
										<td bgcolor="#FFFFFF">

											<script type="text/javascript">
												tinymce.init({

													selector: "#exclusion<?php echo $count ?>",

													themes: "modern",

													plugins: [

														"advlist autolink lists link image charmap print preview anchor",

														"searchreplace visualblocks code fullscreen"

													],

													toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

												});
											</script>
											<?php
											$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
											$editresult = mysqli_fetch_array($rs1);
											?>
											<textarea name="exclusion<?php echo $count; ?>" class="gridfield" id="exclusion<?php echo $count ?>"><?php echo stripslashes($editresult['exclusion']); ?></textarea>
											<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</td>
									</tr>
									<?php 
									//$count++;
								} ?>
							</tbody>
						</table>
						<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
						<input type="hidden" name="action" value="saveFitTermsExclusionLanguage">
						<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
						<div style="float: right;">
							<input type="submit" name="saveFitTermsExclusionLanguage" value="Save" class="bluembutton submitbtn">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
							<script>
								function closeEditor() {
									var count = $('.count').val();
									for (i = 1; i <= count; i++) {
										tinymce.remove('#exclusion' + i);
									}
								}
							</script>

						</div>
					</form>
				</div>
			</div>
		<?php }
		if ($_GET['action'] == 'fittermscondlanguage' && $_GET['id'] != '') {

		?>
			<style type="text/css">
				table.table-bordered.dataTable tbody td {
					border: 0.01em solid #ccc;
				}
			</style>
			<div class="contentclass">
				<h1 style="text-align:left;">Terms & Conditions Language</h1>

				<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

							<tbody>
								<tr>
									<td>S.No</td>
									<td>Language</td>
									<td>Terms & Conditions Information</td>
								</tr>
								<?php
								// $count = 1;
								$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
								$countrow = mysqli_num_rows($rs);
								while ($languageDetails = mysqli_fetch_array($rs)) {
									$count = $languageDetails['id'];
									?>
									<tr>
										<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
										<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
										<td bgcolor="#FFFFFF">

											<script type="text/javascript">
												tinymce.init({

													selector: "#termscondition<?php echo $count ?>",

													themes: "modern",

													plugins: [

														"advlist autolink lists link image charmap print preview anchor",

														"searchreplace visualblocks code fullscreen"

													],

													toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

												});
											</script>
											<?php
											$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
											$editresult = mysqli_fetch_array($rs1);
											?>
											<textarea name="termscondition<?php echo $count; ?>" class="gridfield" id="termscondition<?php echo $count ?>"><?php echo stripslashes($editresult['termscondition']); ?></textarea>
											<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</td>
									</tr>
									<?php 
									//$count++;
								} ?>
							</tbody>
						</table>
						<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
						<input type="hidden" name="action" value="saveFitTermsConditionLanguage">
						<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
						<div style="float: right;">
							<input type="submit" name="saveFitTermsConditionLanguage" value="Save" class="bluembutton submitbtn">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
							<script>
								function closeEditor() {
									var count = $('.count').val();
									for (i = 1; i <= count; i++) {
										tinymce.remove('#termscondition' + i);
									}
								}
							</script>
						</div>
					</form>
				</div>
			</div>
		<?php }



// git payments and policy started
if ($_GET['action'] == 'fittermspaymentpolicylanguage' && $_GET['id'] != '') {

	?>
		<style type="text/css">
			table.table-bordered.dataTable tbody td {
				border: 0.01em solid #ccc;
			}
		</style>
		<div class="contentclass">
			<h1 style="text-align:left;">Payment Policy Language</h1>

			<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

						<tbody>
							<tr>
								<td>S.No</td>
								<td>Language</td>
								<td>Payment Policy Information</td>
							</tr>
							<?php
							//$count = 1;
							$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
							$countrow = mysqli_num_rows($rs);
							while ($languageDetails = mysqli_fetch_array($rs)) {
								$count = $languageDetails['id'];
							?>
								<tr>
									<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
									<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
									<td bgcolor="#FFFFFF">

										<script type="text/javascript">
											tinymce.init({

												selector: "#paymentpolicy<?php echo $count ?>",

												themes: "modern",

												plugins: [

													"advlist autolink lists link image charmap print preview anchor",

													"searchreplace visualblocks code fullscreen"

												],

												toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

											});
										</script>
										<?php
										$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
										?>
										<textarea name="paymentpolicy<?php echo $count; ?>" class="gridfield" id="paymentpolicy<?php echo $count ?>"><?php echo stripslashes($editresult['paymentpolicy']); ?></textarea>
										<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
										<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
										<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
									</td>
								</tr>
							<?php 
							//$count++;
							} ?>
						</tbody>
					</table>
					<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
					<input type="hidden" name="action" value="saveTremFitPaymentLanguage">
					<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
					<div style="float: right;">
						<input type="submit" name="saveTremFitPaymentLanguage" value="Save" class="bluembutton submitbtn">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
						<script>
							function closeEditor() {
								var count = $('.count').val();
								for (i = 1; i <= count; i++) {
									tinymce.remove('#paymentpolicy' + i);
								}
							}
						</script>
					</div>
				</form>
			</div>
		</div>
	<?php }
// payments and policy ended

// remarks started
if ($_GET['action'] == 'fittermremarkslanguage' && $_GET['id'] != '') {

	?>
		<style type="text/css">
			table.table-bordered.dataTable tbody td {
				border: 0.01em solid #ccc;
			}
		</style>
		<div class="contentclass">
			<h1 style="text-align:left;">Remarks Language</h1>

			<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

						<tbody>
							<tr>
								<td>S.No</td>
								<td>Language</td>
								<td>Remarks Information</td>
							</tr>
							<?php
							// $count = 1;
							$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
							$countrow = mysqli_num_rows($rs);
							while ($languageDetails = mysqli_fetch_array($rs)) {
								$count = $languageDetails['id'];
								?>
								<tr>
									<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
									<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
									<td bgcolor="#FFFFFF">

										<script type="text/javascript">
											tinymce.init({

												selector: "#remarks<?php echo $count ?>",

												themes: "modern",

												plugins: [

													"advlist autolink lists link image charmap print preview anchor",

													"searchreplace visualblocks code fullscreen"

												],

												toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

											});
										</script>
										<?php
										$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
										?>
										<textarea name="remarks<?php echo $count; ?>" class="gridfield" id="remarks<?php echo $count ?>"><?php echo stripslashes($editresult['remarks']); ?></textarea>
										<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
										<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
										<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
									</td>
								</tr>
							<?php 
							//$count++;
							} ?>
						</tbody>
					</table>
					<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
					<input type="hidden" name="action" value="saveFitTermsRemarksLanguage">
					<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
					<div style="float: right;">
						<input type="submit" name="saveFitTermsRemarksLanguage" value="Save" class="bluembutton submitbtn">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
						<script>
							function closeEditor() {
								var count = $('.count').val();
								for (i = 1; i <= count; i++) {
									tinymce.remove('#remarks' + i);
								}
							}
						</script>
					</div>
				</form>
			</div>
		</div>
	<?php } 
// remarks ended

		if ($_GET['action'] == 'fittermscancellanguage' && $_GET['id'] != '') {

		?>
			<style type="text/css">
				table.table-bordered.dataTable tbody td {
					border: 0.01em solid #ccc;
				}
			</style>
			<div class="contentclass">
				<h1 style="text-align:left;">Cancellation Language</h1>

				<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

							<tbody>
								<tr>
									<td>S.No</td>
									<td>Language</td>
									<td>Cancellation Information</td>
								</tr>
								<?php
								// $count = 1;
								$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
								$countrow = mysqli_num_rows($rs);
								while ($languageDetails = mysqli_fetch_array($rs)) {
									$count = $languageDetails['id'];
									?>
									<tr>
										<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
										<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
										<td bgcolor="#FFFFFF">

											<script type="text/javascript">
												tinymce.init({

													selector: "#cancellation<?php echo $count ?>",

													themes: "modern",

													plugins: [

														"advlist autolink lists link image charmap print preview anchor",

														"searchreplace visualblocks code fullscreen"

													],

													toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

												});
											</script>
											<?php
											$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
											$editresult = mysqli_fetch_array($rs1);
											?>
											<textarea name="cancellation<?php echo $count; ?>" class="gridfield" id="cancellation<?php echo $count ?>"><?php echo stripslashes($editresult['cancellation']); ?></textarea>
											<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</td>
									</tr>
								<?php 

								// $count++;
								} ?>
							</tbody>
						</table>
						<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
						<input type="hidden" name="action" value="saveFitTermsCancelLanguage">
						<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
						<div style="float: right;">
							<input type="submit" name="saveFitTermsCancelLanguage" value="Save" class="bluembutton submitbtn">
							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
							<script>
								function closeEditor() {
									var count = $('.count').val();
									for (i = 1; i <= count; i++) {
										tinymce.remove('#cancellation' + i);
									}
								}
							</script>
						</div>
					</form>
				</div>
			</div>
			<?php }


// started payment language view
if ($_GET['action'] == 'paymentpolicylanguage' && $_GET['id'] != '') {

	?>
		<style type="text/css">
			table.table-bordered.dataTable tbody td {
				border: 0.01em solid #ccc;
			}
		</style>
		<div class="contentclass">
			<h1 style="text-align:left;">Payment Policy Language</h1>

			<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

						<tbody>
							<tr>
								<td>S.No</td>
								<td>Language</td>
								<td>Payment Policy Information</td>
							</tr>
							<?php
							// $count = 1;
							$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
							$countrow = mysqli_num_rows($rs);
							while ($languageDetails = mysqli_fetch_array($rs)) {
								$count = $languageDetails['id'];
							?>
								<tr>
									<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
									<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
									<td bgcolor="#FFFFFF">

										<script type="text/javascript">
											tinymce.init({

												selector: "#paymentpolicy<?php echo $count ?>",

												themes: "modern",

												plugins: [

													"advlist autolink lists link image charmap print preview anchor",

													"searchreplace visualblocks code fullscreen"

												],

												toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

											});
										</script>
										<?php
										$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
										?>
										<textarea name="paymentpolicy<?php echo $count; ?>" class="gridfield" id="paymentpolicy<?php echo $count ?>"><?php echo stripslashes($editresult['paymentpolicy']); ?></textarea>
										<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
										<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
										<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
									</td>
								</tr>
							<?php //$count++;
							} ?>
						</tbody>
					</table>
					<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
					<input type="hidden" name="action" value="saveFitTermsPaymentLanguage">
					<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
					<div style="float: right;">
						<input type="submit" name="saveFitTermsPaymentLanguage" value="Save" class="bluembutton submitbtn">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
						<script>
							function closeEditor() {
								var count = $('.count').val();
								for (i = 1; i <= count; i++) {
									tinymce.remove('#paymentpolicy' + i);
								}
							}
						</script>
					</div>
				</form>
			</div>
		</div>
		<?php } 
// ended payment language view 




// started remarks language view
if ($_GET['action'] == 'remarkslanguage' && $_GET['id'] != '') {

	?>
		<style type="text/css">
			table.table-bordered.dataTable tbody td {
				border: 0.01em solid #ccc;
			}
		</style>
		<div class="contentclass">
			<h1 style="text-align:left;">Remarks Language</h1>

			<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

				<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

					<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

						<tbody>
							<tr>
								<td>S.No</td>
								<td>Language</td>
								<td>Remarks Information</td>
							</tr>
							<?php
							// $count = 1;
							$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
							$countrow = mysqli_num_rows($rs);
							while ($languageDetails = mysqli_fetch_array($rs)) {
								$count = $languageDetails['id'];
								?>
								<tr>
									<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
									<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
									<td bgcolor="#FFFFFF">

										<script type="text/javascript">
											tinymce.init({

												selector: "#remarks<?php echo $count ?>",

												themes: "modern",

												plugins: [

													"advlist autolink lists link image charmap print preview anchor",

													"searchreplace visualblocks code fullscreen"

												],

												toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

											});
										</script>
										<?php
										$rs1 = GetPageRecord('*', 'termsConditionsLanguageMaster', '1 and fit_gitId="' . decode($_GET['id']) . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
										?>
										<textarea name="remarks<?php echo $count; ?>" class="gridfield" id="remarks<?php echo $count ?>"><?php echo stripslashes($editresult['remarks']); ?></textarea>
										<input type="hidden" name="fitgitId<?php echo $count; ?>" value="<?php echo decode($_GET['id']); ?>">
										<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
										<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
									</td>
								</tr>
							<?php //$count++;
							} ?>
						</tbody>
					</table>
					<input type="hidden" name="redirectId" value="<?php echo decode($_GET['id']); ?>">
					<input type="hidden" name="action" value="saveFitTermsRemarksLanguage">
					<input type="hidden" name="count" class="count" value="<?php echo $countrow; ?>">
					<div style="float: right;">
						<input type="submit" name="saveFitTermsRemarksLanguage" value="Save" class="bluembutton submitbtn">
						<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();closeEditor();" />
						<script>
							function closeEditor() {
								var count = $('.count').val();
								for (i = 1; i <= count; i++) {
									tinymce.remove('#remarks' + i);
								}
							}
						</script>
					</div>
				</form>
			</div>
		</div>
		<?php } 
// ended remarks language view 


		if ($_GET['action'] == 'addedit_querySubjectLanguage' && $_GET['sectiontype'] == 'querySubject') {

			if ($_GET['id'] != '') {

				$id = clean($_GET['id']);

			?>

				<style type="text/css">
					.saveBtn {
						font-size: 20px !important;
						color: #006699;
						cursor: pointer;
						/* float: right; */
						display: flex;
						padding: 5px 7px;
						border: 0px solid #ddd;
						border-radius: 1px;
					}
				</style>

				<div class="contentclass">
					<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
														echo 'Edit';
													} else {
														echo 'Add';
													} ?>&nbsp;Subject</h1>

					<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px;">

						<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">


							<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">

								<tbody>

									<tr>
										<td>S.No</td>
										<td>Language</td>
										<td>Title</td>
										<td>Description</td>
									</tr>
									<?php
									// $count = 1;
									$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
									$totalrow = mysqli_num_rows($rs);
									while ($languageDetails = mysqli_fetch_array($rs)) {
										$count = $languageDetails['id'];
										$rs1 = GetPageRecord('*', 'subjectLanguageMaster', '1 and subjectId="' . $_GET['id'] . '" and languageId="' . $languageDetails['id'] . '"');
										$editresult = mysqli_fetch_array($rs1);
									?>
										<tr>
											<td bgcolor="#FFFFFF"><?php echo $count;  ?></td>
											<td bgcolor="#FFFFFF"><?php echo $languageDetails['name']; ?></td>
											<td bgcolor="#FFFFFF">
												<div class="griddiv">
													<label>
														<input name="title<?php echo $count ?>" type="text" class="gridfield validate" id="title<?php echo $count ?>" displayname="Title" value="<?php echo $editresult['title']; ?>" maxlength="100" />
													</label>
												</div>
											</td>
											<td bgcolor="#FFFFFF" width="540px">
												<textarea rows="4" class="langdescription22" style="width: 100%;border-color: #e0e0e0;outline: none;" name="description<?php echo $count; ?>" class="gridfield" id="description<?php echo $count ?>"><?php echo strip_tags(stripslashes($editresult['description'])); ?></textarea>
											</td>
											<input type="hidden" name="languageId<?php echo $count; ?>" value="<?php echo $languageDetails['id'] ?>">
											<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
										</tr>
									<?php //$count++;
									} ?>
								</tbody>
							</table>
							<input type="hidden" name="subjectId" value="<?php echo $_GET['id'] ?>">
							<input type="hidden" name="action" value="saveSubjectLanguage">
							<input type="hidden" name="count" value="<?php echo $totalrow; ?>">
							<div style="float: right;">
								<input type="submit" name="saveSubjectLanguage" value="Save" class="bluembutton submitbtn">
								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />
							</div>
						</form>
					</div>
				</div>
				<script src="js/jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" href="css/selectize.css">
	<script src="tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: ".langdescription22"
		});   
	</script>
			<?php }
		}

// SAC Code Master start ============================

if($_GET['action']=='addedit_SACcodeMaster' && $_GET['sectiontype']=='SACcodeMaster'){


	if($_GET['id']!=''){
	
	$id=clean($_GET['id']);
	
	$select1='*';
	
	$where1='id='.$id.'';
	
	$rs1=GetPageRecord($select1,'sacCodeMaster',$where1);
	
	$editresult=mysqli_fetch_array($rs1);
	
	$serviceType=clean($editresult['serviceType']);
	
	$sacCode=clean($editresult['sacCode']);
	
	$status=clean($editresult['status']);
	$setDefault=clean($editresult['setDefault']);
	
	}
	
	?>
	
	<div class="contentclass">
	
		<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> SAC Code </h1>
	
		<div id="contentbox" class="addeditpagebox"
			style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">
	
			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters"
				target="actoinfrm" id="addmasters">
	
				<div style="display: grid;grid-template-columns:1fr;grid-gap: 15px;">
					<div>
	
						<div class="griddiv"><label>
	
								<div class="gridlable">Service&nbsp;Type<span class="redmind"></span></div>
	
								
								<select name="serviceType" type="text" class="gridfield validate" id="serviceType"
									displayname="Service Type">
										<option value="hotel" <?php if($serviceType=="hotel"){ echo 'selected'; } ?> >Hotel</option>
										<option value="guide" <?php if($serviceType=="guide"){ echo 'selected'; } ?>>Guide</option>
										<option value="transfer" <?php if($serviceType=="transfer"){ echo 'selected'; } ?>>Transfer</option>
										<option value="entrance" <?php if($serviceType=="entrance"){ echo 'selected'; } ?>>Entrance</option>
										<option value="activity" <?php if($serviceType=="activity"){ echo 'selected'; } ?>>Activity</option>
										<option value="flight" <?php if($serviceType=="flight"){ echo 'selected'; } ?>>Flight</option>
										<option value="train" <?php if($serviceType=="train"){ echo 'selected'; } ?>>Train</option>
										<option value="ferry" <?php if($serviceType=="ferry"){ echo 'selected'; } ?>>Ferry</option>
										<option value="restaurant" <?php if($serviceType=="restaurant"){ echo 'selected'; } ?>>Restaurant</option>
										<option value="other" <?php if($serviceType=="other"){ echo 'selected'; } ?>>Additional</option>
								</select>
	
							</label>
	
						</div>
	
						<div class="griddiv"><label>
	
								<div class="gridlable">SAC&nbsp;Code<span class="redmind"></span></div>
	
								<input name="sacCode" type="number" class="gridfield validate" id="sacCode"
									displayname="SAC Code" value="<?php echo $sacCode; ?>" />
	
							</label>
	
						</div>
	
						<div class="griddiv">
	
							<label>
	
								<div class="gridlable">Status</div>
	
								<select id="status" type="text" class="gridfield" name="status" displayname="Status"
									autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">
	
									<option value="1" <?php if($status=='1'){ ?>selected="selected" <?php } ?>>Active
									</option>
	
									<option value="0" <?php if($status=='0'){ ?>selected="selected" <?php } ?>>In Active
									</option>
	
								</select>
							</label>
						</div>

						<div class="griddiv">

					<input type="checkbox" name="defaultSACCode" id="defaultSACCode" value="1" <?php if($editresult['setDefault']==1){ ?> checked="checked" <?php } ?> style="display: inline-block;"> Set Default

					</div>

					</div>
	
					<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
	
					<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
	
					<input name="action" type="hidden" id="action" value="addedit_SACcodeMaster" />
	
			</form>
	
	
		</div>
	
		<div id="buttonsbox" style="text-align:center;">
	
			<table border="0" align="right" cellpadding="0" cellspacing="0">
	
				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn"
							value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
	
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel"
							value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
	
				</tr>
	
			</table>
	
		</div>
	</div>
	
	<?php }


		if ($_GET['action'] == 'addedit_bankMaster' && $_GET['sectiontype'] == 'bankMaster') {


			if ($_GET['id'] != '') {


				$id = clean($_GET['id']);

				$select1 = '*';

				$where1 = 'id=' . $id . '';

				$rs1 = GetPageRecord($select1, 'bankMaster', $where1);
				$editresult = mysqli_fetch_array($rs1);

				$bankName = clean($editresult['bankName']);
				$title = clean($editresult['title']);
				$editId = clean($editresult['id']);

				$accountType = clean($editresult['accountType']);

				$accountNumber = clean($editresult['accountNumber']);

				$branchAddress = clean($editresult['branchAddress']);

				$branchIFSC = clean($editresult['branchIFSC']);

				$branchSwiftCode = clean($editresult['branchSwiftCode']);
								
				// hhhhhhhhhhhhhhhhhhhhhhhhhhhh
				// bankupid,qrcodeimage 
				$bankupid = clean($editresult['bankupid']);
				$qrcodeimage = clean($editresult['qrcodeimage']);
				

				$beneficiaryName = clean($editresult['beneficiaryName']);
				
				$status = clean($editresult['status']);
				$bydefshowhide = clean($editresult['bydefshowhide']);

				$setDefault = clean($editresult['setDefault']);

			}

			?>

			<div class="contentclass">

				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> Bank </h1>

				<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

						<div style="display: grid;grid-template-columns: 1fr 1fr;grid-gap: 15px;">
							<div>

								<div class="griddiv"><label>

										<div class="gridlable">Bank&nbsp;Name<span class="redmind"></span></div>

										<input name="bankname" type="text" class="gridfield validate" id="bankname" displayname="Bank Name" value="<?php echo $bankName; ?>" />

									</label>

								</div>

								<div class="griddiv"><label>

										<div class="gridlable">Account&nbsp;Number<span class="redmind"></span></div>

										<input name="accountnumber" type="text" class="gridfield validate" id="accountnumber" displayname="Account Number" value="<?php echo $accountNumber; ?>" />

									</label>

								</div>


								<div class="griddiv"><label>

										<div class="gridlable ">Branch&nbsp;Address<span class="redmind"></span></div>

										<textarea name="branchaddress" rows="3" class="gridfield validate" displayname="Branch Address" id="branchaddress"><?php echo $branchAddress; ?></textarea>
									</label>

								</div>
								<!-- add new UPI Id fields -->

								<div class="griddiv">
								
								<div class="gridlable">UPI&nbsp;ID<span class=""></span></div>

								<input name="bankupid" type="text" class="gridfield " id="bankupid" displayname="UPI ID" value="<?php echo $bankupid; ?>" />

								</div>

								<div class="griddiv">

									<label>

										<div class="gridlable">Status</div>

										<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>" style="width: 100%;">

											<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

											<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

										</select>
									</label>

								</div>
								<div class="griddiv">

									<label>

										<div class="gridlable">Show/Hide</div>

										<select id="bydefshowhide" type="text" class="gridfield" name="bydefshowhide" displayname="Status" autocomplete="off" value="<?php echo $bydefshowhide; ?>" style="width: 100%;">

											<option value="1" <?php if ($bydefshowhide == '1') { ?>selected="selected" <?php } ?>>Yes</option>

											<option value="0" <?php if ($bydefshowhide == '0') { ?>selected="selected" <?php } ?>>No</option>

										</select>
									</label>

								</div>





							</div>

							<div>

								<div class="griddiv"><label>

										<div class="gridlable">Account&nbsp;Type<span class="redmind"></span></div>

											<select name="accounttype" type="text" class="gridfield validate" id="accounttype" displayname="Account Type">
												<option>Select Account Type</option>
												<option value="Saving" <?php if($accountType == 'Saving'){?> selected="selected" <?php }?>>Saving</option>
												<option value="Current" <?php if($accountType == 'Current'){?> selected="selected" <?php }?>>Current</option>
											</select>

									</label>

								</div>

								<div class="griddiv"><label>

										<div class="gridlable">Beneficiary&nbsp;Name<span class="redmind"></span></div>

										<input name="beneficiaryname" type="text" class="gridfield validate" id="beneficiaryname" displayname="Beneficiary Name" value="<?php echo $beneficiaryName; ?>" />

									</label>

								</div>

								<div class="griddiv"><label>

								<div id="nameBoxId" class="gridlable" style="width:100%;">
									<span id="clickableIcon" class="fa fa-pencil" onclick="$('#titleBox').hide();$('#inputBox').show();$('#savebtn').show();$('#clickableIcon').hide();" style="border: 1px solid;border-radius: 4px;padding: 2px 5px;cursor: pointer; color:#5b9d50;display:inline-block;"></span>

									<span id="titleBox"><?php if($title!=''){ echo $title; }else{ echo 'Branch&nbsp;IFSC'; } ?></span>

									<span id="inputBox" style="display:none;"><input type="text"  value="<?php if($title!=''){ echo $title; }else{ echo 'Branch&nbsp;IFSC'; } ?>" name="title" id="title" style="width:95%;padding:4px;" />
									 <div id="cancelbtn" class="btntext" style="background-color: red;border: 1px solid #ff0000;float: right;" onclick="$('#inputBox').hide();$('#clickableIcon').show();$('#titleBox').show();">Cancel</div> <?php if($editId!=''){ ?> <div onclick="saveTitle();" id="savebtn" class="btntext" style="margin-right: 10px;">Save</div> <?php } ?> </span> <span class="redmind"></span>
								</div>

										<input name="branchifsc" type="text" class="gridfield validate" id="branchifsc" displayname="Branch IFSC" value="<?php echo $branchIFSC; ?>" />

									</label>

								</div>

								<style>
									.btntext{
										display: inline-block;font-size: 15px;border: 1px solid #233a49;border-radius: 5px;padding: 5px 7px;background-color: #233a49;color: #f8f8f8;cursor: pointer;float: right;
										margin-top:5px;
									}
								</style>

								<script>
									function saveTitle(){
										var title = $("#title").val();
										$("#titleBox").load(`final_frmaction.php?action=saveBankMasterTitle&title=${encodeURI(title)}&id=<?php echo $editId; ?>`)
										$('#inputBox').hide();
										$('#clickableIcon').show();
										$('#titleBox').show();
									}
								</script>
							

								<div class="griddiv"><label>

										<div class="gridlable">Branch&nbsp;Swift&nbsp;Code<span class="redmind"></span></div>

										<input name="branchswiftcode" type="text" class="gridfield validate" id="branchswiftcode" displayname="Branch Swift Code" value="<?php echo $branchSwiftCode; ?>" />

									</label>

								</div>

								<!-- 	bankupid,qrcodeimage  -->
								<!-- new fields added QR Code - image sec started -->
								<div class="griddiv">
								<label>
									<div style="display: grid;"><?php if($_REQUEST['id']==''){  }else{ ?> <img align="left" style="display: inline-block;" src="packageimages/<?php echo $qrcodeimage; ?>" alt="" width="85px" height="70px">  <?php } ?>
									</div>
									<div class="gridlable">Attach&nbsp;QR&nbsp;Code&nbsp;Image<span class="redmind"></span></div>
									<input name="qrcodeimage" type="file" class="gridfield" id="qrcodeimage" value="<?php echo $qrcodeimage; ?>" displayname="Upload Q R Code Image"/>
								
									<input type="hidden" name="oldqrcodeimage" id="oldqrcodeimage" value="<?php if($editresult['image']!=''){echo $editresult['image'];} ?>" />
								
								</label>
								
								</div>
							<!-- image sec ended -->


								<div class="griddiv" style="padding-bottom: 4px;">
									<label>

										<div class="gridlable">Set Default<span class="redmind"></span></div>

										<input name="setDefault" type="checkbox" value="1" <?php if ($setDefault == 1) { ?> checked <?php } ?> class="gridfield" style="width: auto; float: left; margin: 2px; margin-right: 10px;">

									</label>

								</div>

							</div>

						</div>

						<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

						<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

						<input name="action" type="hidden" id="action" value="addedit_bankMaster" />

					</form>


				</div>

				<div id="buttonsbox" style="text-align:center;">

					<table border="0" align="right" cellpadding="0" cellspacing="0">

						<tr>
							<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>
			</div>

		<?php }

		if ($_GET['action'] == 'bankdelete') { ?>

			<div class="delbg"><img src="images/Remove-64.png" /></div>

			<div class="contentclass">

				<h1 style="padding:15px 0px !important;">Are you sure you want to Deactivate selected <?php echo $_REQUEST['name']; ?>?</h1>

				<div id="buttonsbox">

					<table border="0" align="center" cellpadding="0" cellspacing="0">

						<tr>

							<td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Deactivate" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>

			</div>



		<?php }

		if ($_GET['action'] == 'marketdelete') { ?>

			<div class="delbg"><img src="images/Remove-64.png" /></div>

			<div class="contentclass">

				<h1 style="padding:15px 0px !important;">Are you sure you want to Deactivate selected <?php echo $_REQUEST['name']; ?>?</h1>

				<div id="buttonsbox">

					<table border="0" align="center" cellpadding="0" cellspacing="0">

						<tr>

							<td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Deactivate" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');" /></td>

							<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>

						</tr>

					</table>

				</div>

			</div>



		<?php }

		?>

		<?php
		if ($_GET['action'] == 'addedit_enrouteLanguage' && $_GET['sectiontype'] == 'queryEnroute') {



			$id = clean($_GET['id']);

			$select1 = '*';

			$where1 = 'id=' . $id . '';

			$rs1 = GetPageRecord($select1, _PACKAGE_BUILDER_ENROUTE_MASTER_, $where1);


			$editresult = mysqli_fetch_array($rs1);


			$name = clean($editresult['enrouteName']);


			$rsdes = GetPageRecord('*', _DESTINATION_MASTER_, 'name="' . $_REQUEST['destinationName'] . '"');



			$destinationresult = mysqli_fetch_array($rsdes);



			$destinationId = $destinationresult['id'];



		?>



			<style type="text/css">
				.saveBtn {
					font-size: 20px !important;

					color: #006699;

					cursor: pointer;

					/* float: right; */

					display: flex;

					padding: 5px 7px;

					border: 0px solid #ddd;

					border-radius: 1px;

				}
			</style>



			<div class="contentclass">
				<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != '') {
													echo 'Edit';
												} else {
													echo 'Add';
												} ?> &nbsp;<?php echo $name; ?></h1>


				<div id="contentbox" class="addeditpagebox" style="padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">


						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-striped table-bordered gridtable dataTable no-footer" style="border: 1px solid #ccc;">
							<tbody>
								<tr>

									<td>S.No</td>

									<td>Language</td>

									<td>Language Description</td>

								</tr>

								<?php
								// $count = 1;
								$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0');
								$totalrow = mysqli_num_rows($rs);
								while ($languageDetails = mysqli_fetch_array($rs)) {
									$count = $languageDetails['id'];
									$rs1 = GetPageRecord('*', 'enrouteLanguageMaster', '1 and enrouteId="' . $id . '"');
									$editresult = mysqli_fetch_array($rs1);
								?>
									<tr>
										<td bgcolor="#FFFFFF"><?php echo $count; ?></td>
										<td bgcolor="#FFFFFF"><?php echo $languageDetails['name'] ?></td>
										<td bgcolor="#FFFFFF">
											<textarea rows="4" style="width: 100%;border-color: #e0e0e0;outline: none;" name="description<?php echo $count; ?>" class="gridfield" id="description<?php echo $count ?>"><?php echo $editresult['lang_0' . $count]; ?></textarea>
										</td>
										<input type="hidden" name="editId<?php echo $count; ?>" value="<?php echo $editresult['id'] ?>">
									</tr>
								<?php 
								//$count++;
								} ?>
							</tbody>
							<style>
								.tbl td {
									padding: 4px 10px !important;
								}
							</style>
						</table>
						<input type="hidden" name="action" value="saveEnrouteLanguage">
						<input type="hidden" name="destinationId" value="<?php echo $destinationId  ?>">
						<input type="hidden" name="enrouteId" value="<?php echo encode($id); ?>">

						<div style="float: right;">

							<input type="submit" name="saveenroute" value="Save" class="bluembutton submitbtn">

							<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" />

					</form>

				</div>

			</div>
		<?php
		}
		?>
		<?php
		if ($_REQUEST['action'] == 'addeditGallery') {  ?>

			<div class="contentclass">
				<div id="contentbox" class="addeditpagebox" style="padding:0px; overflow:auto; text-align:left; margin-bottom:0px; position: relative;">
					<h1 style="text-align:left;display: inline-block;width: 100px;">Add Image</h1>
					<div style="display: inline-block;width: 150px;position: absolute; text-align: center;">
					<span style="font-size: 14px;font-weight: 500;">File From Desktop </span>
					 <div class="uploadclass" onmouseover="addColor();" onmouseout="removeColor();" onclick="alertspopupopen('action=addFilesToMaster&parentId=<?php echo $_REQUEST['parentId'] ?>&galleryType=<?php echo $_REQUEST['galleryType'] ?>','400px','auto');" style="font-size: 15px;border: 2px dashed #a5682a;color:#a5682a;padding: 5px 15px;cursor:pointer;background:rgb(235 235 235);"><i class="fa fa-upload" aria-hidden="true"></i> Choose File</div> </div>
					<script>
						function addColor(){
							$(".uploadclass").css("background-color","#a5682a");
							$(".uploadclass").css("color","#fff");
							$(".uploadclass").css("border","2px dashed #ccc");
						}

						function removeColor(){
							$(".uploadclass").css("background-color","rgb(235 235 235)");
							$(".uploadclass").css("color","#a5682a");
							$(".uploadclass").css("border","2px dashed #a5682a");
						}
						
					</script>
					<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
						<div id="loadFolderAndFiles">
							<script type="text/javascript">
								function listFolders() {
									$('#loadFolderAndFiles').load('masters_loadalertbox.php?action=listFolders');
								}
								listFolders();
							</script>
						</div>
					</form>
				</div>

				<div id="buttonsbox" style="text-align:center;">
					<table border="0" align="right" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<div style="display: none;" id="saveGalleryPhoto"></div>
								<script type="text/javascript">
									function saveGalleryPhoto(fileId) {
										$('#saveGalleryPhoto').load('loadSaveGalleryPhoto.php?action=saveGalleryPhoto&parentId=<?php echo clean($_REQUEST['parentId']); ?>&galleryType=<?php echo clean($_REQUEST['galleryType']); ?>&fileId=' + fileId);
									}
								</script>
							</td>
							<td style="padding-right:20px;">
								<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="history.go(0)" />
							</td>
						</tr>
					</table>
				</div>
			</div>
		<?php
		}

		if ($_GET['action'] == 'listFolders') {

			$folderId = decode($_REQUEST['folderId']);
			if ($folderId > 0) {
				$folderIdQuery = ' and folderId=' . $folderId . '';
			} else {
				$folderIdQuery = ' and folderId=0 ';
			}
			$rs = '';
			$rs = GetPageRecord('*', _DOCUMENT_FOLDER_MASTER_, '1 and id = "' . $folderId . '"');
			$foldersData = mysqli_fetch_array($rs);
			if ($foldersData['folderId'] > 0) {
				$parentFolderN = ucfirst($foldersData['name']);
				
				$parentFolder = $foldersData['folderId'];
			} else {
				$parentFolderN = ucfirst('Document Management');
				$parentFolder = 0;
			}
		?>
		<!-- onclick="openMainFolder('<?php echo encode($parentFolder); ?>');" -->
			<div class="headingm" style=" position: absolute; padding: 10px 0; "><?php //echo $parentFolderN; 
			
			?><span class="whitembutton" onclick="alertspopupopenClose();" style="margin: 0;padding: 7px 12px;">Back</span></div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="loadFolderAndFilesTable">
				<thead>
					<tr>
						<th width="5%" valign="middle" align="left" class="header">&nbsp;#</th>
						<th width="25%" valign="middle" align="left" class="header"> Folder Name </th>
						<th width="12%" valign="middle" align="left" class="header"> Dimensions</th>
						<th width="18%" valign="middle" align="left" class="header">Created Date </th>
						<th width="10%" valign="middle" align="center" class="header">Files/Size</th>
						<th width="10%" valign="middle" align="left" class="header"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>action </th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;

					$folderQuery = '';
					$folderQuery = GetPageRecord('*', _DOCUMENT_FOLDER_MASTER_, ' deletestatus=0 ' . $folderIdQuery . ' order by id desc');
					while ($folderData = mysqli_fetch_array($folderQuery)) {
						// $countfolder = countFolderFiles($folderData['id']); 
						$countfiles = scan_dir($folderData['id'])['total_files'];
					?>
						<tr>
							<td valign="middle" align="left"><img src="images/blkfolder.png" width="36" title="<?php echo date('d-m-y h:i a', trim($folderData['dateAdded'])); ?>" onClick="openMainFolder('<?php echo encode($folderData['id']); ?>');" /></td>
							<td valign="middle" align="left"><a onClick="openMainFolder('<?php echo encode($folderData['id']); ?>');"><?php echo str_replace('-',' ',$folderData['name']); ?></a></td>
							<td valign="middle" align="left"><?php ?></td>
							<td valign="middle" align="left"><?php echo date('d-m-y h:i a', trim($folderData['dateAdded'])); ?></td>
							<td valign="middle" align="center"><?php echo $countfiles; ?> Files</td>
							<td valign="middle" align="left"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<a onClick="openMainFolder('<?php echo encode($folderData['id']); ?>');" style="color:#2ca1cc!important;font-size: 22px;"><i class="fa fa-eye"></i></a>
							</td>
						</tr>
					<?php
						$no++;
					}

					$fileQuery = '';
					$fileQuery = GetPageRecord('*', _DOCUMENT_FILES_MASTER_, ' deletestatus=0 ' . $folderIdQuery . ' order by id desc');
					while ($folderFileData = mysqli_fetch_array($fileQuery)) {
					?>
						<tr>
							<td valign="middle" align="left">
								<a href="<?php echo geDocFileSrc($folderFileData['id']); ?>" target="_blank"><img src="<?php echo getFileIcon($folderFileData['fileType']); ?>" width="30" /></a>
							</td>
							<td valign="middle" align="left"><a href="<?php echo geDocFileSrc($folderFileData['id']); ?>" target="_blank"><?php echo ($folderFileData['name']); ?></a></td>
							<td valign="middle" align="left"><?php echo ($folderFileData['fileDimension']); ?></td>
							<td valign="middle" align="left"><?php echo date('d-m-y h:i a', trim($folderFileData['dateAdded'])); ?></td>
							<td valign="middle" align="left"><?php echo $sum6 = formatBytes($folderFileData['fileSize'], $precision = 2); ?></td>
							<td valign="middle" align="left">
								<a style="color:#2ca1cc!important;font-size: 18px;" id="savePhotoText<?php echo $folderFileData['id']; ?>" onclick="saveGalleryPhoto(<?php echo $folderFileData['id']; ?>);"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Add</a>
							</td>
						</tr>
					<?php
						$no++;
					}
					?>
				</tbody>
			</table>




			<script type="text/javascript">
				function openMainFolder(folderId) {
					$('#loadFolderAndFiles').load('masters_loadalertbox.php?action=listFolders&folderId=' + encodeURI(folderId) + '');
				}
				// $('#loadFolderAndFilesTable_wrapper .row:first div:first').text('Add Images');
				$(document).ready(function() {
					$('#loadFolderAndFilesTable').DataTable({
						"paging": false,
						"ordering": true,
						"info": false,
						"searching": true,
						"order": [
							[0, 'desc']
						]
					});
				});
			</script>
			<style type="text/css">
				.col-md-6 {
					display: block !important;
				}

				.dataTables_filter .form-control {
					margin-left: 0.5em;
					display: inline-block;
					width: auto;
					padding: 6px 10px;
					border: 1px #e8e8e8 solid;
					border-radius: 50px;
					outline: 0px;
					background-size: 17px;
				}
			</style>
		<?php

		}




		

// add expense type masteer code started
if ($_GET['action'] == 'addedit_commissionMaster' && $_GET['sectiontype'] == 'commissionMaster') {

	if ($_GET['id'] != '') {

		$id = clean($_GET['id']);

		$select1 = '*';

		$where1 = 'id="'.$id.'"';

		$rs1 = GetPageRecord($select1, 'commissionMaster', $where1);

		$editresult = mysqli_fetch_array($rs1);
		$name = clean($editresult['name']);
		$percent = clean($editresult['percent']);
		$status = clean($editresult['status']);

	}

?>

	<div class="contentclass">

		<h1 style="text-align:left;"><?php if ($_REQUEST['id'] != ''){ echo 'Edit'; }else{ echo 'Add'; } ?> Commission Master </h1>

		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; ">

			<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

				<div class="griddiv"><label>

						<div class="gridlable">Commission Name<span class="redmind"></span></div>
						<input name="commissionName" type="text" class="gridfield validate" id="name" displayname="Commission Name" value="<?php echo $name; ?>" maxlength="100" />

					</label>

				</div>

				<div class="griddiv"><label>

						<div class="gridlable" style="width: 170px;">Commission Percentage(%)<span class="redmind"></span></div>

						<input name="commissionPercent" type="text" class="gridfield validate" id="commissionPercent" displayname="Commission Percentage" value="<?php echo $percent; ?>" maxlength="100" />
					</label>

				</div>

				<div class="griddiv">

					<label>

						<div class="gridlable">status</div>

						<select name="status" id="status" type="text" class="gridfield" displayname="Status" autocomplete="off" style="width: 100%;">

							<option value="1" <?php if ($status == '1') { ?>selected="selected" <?php } ?>>Active</option>

							<option value="0" <?php if ($status == '0') { ?>selected="selected" <?php } ?>>In Active</option>

						</select>
					</label>

				</div>

				<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />

				<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />

				<input name="action" type="hidden" id="action" value="addedit_commissionMaster" />

			</form>
		</div>

		<div id="buttonsbox" style="text-align:center;">

			<table border="0" align="right" cellpadding="0" cellspacing="0">

				<tr>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>

					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>

				</tr>

			</table>

		</div>
	</div>

<?php }
		?>
