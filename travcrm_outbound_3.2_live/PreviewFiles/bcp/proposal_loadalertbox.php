<?php
include "../inc.php"; 

if($_GET['action']=='loadFormatSize' && $_GET['proposalType']!=''){
	$rs1=GetPageRecord('*','proposalSettingMaster','proposalNum="'.$_GET['proposalType'].'"');
	$proposalSettingData=mysqli_fetch_array($rs1);
	// 800x300
	$dimArr = explode('x', trim($proposalSettingData['photoDimension']));
	$max_width = $dimArr[0];
	$max_height = $dimArr[1];
	
	?>
	<script type="text/javascript">
		<?php if($_GET['proposalType']==1 || $_GET['proposalType']==2 ){ ?>
			$('#upload_quotBanner').css('cursor','no-drop');
			$('#upload_quotBanner>#proposalPhoto').attr('disabled','disabled');
			$('#dimensionLable').text('');
		<?php }else if($max_width>0 && $max_height>0){ ?>
			$('#upload_quotBanner').css('cursor','pointer');
			$('#upload_quotBanner>#proposalPhoto').removeAttr('disabled');

	        $('#maxwidth').val('<?php echo $max_width ?>');
			$('#maxheight').val('<?php echo $max_height ?>');
			$('#dimensionLable').text('Dimension:<?php echo $max_width ?>X<?php echo $max_height ?>');
		<?php }else{ ?>
	        alert("Failed, Please choose the proposal photo size in 'Proposal Setting Master'");
	        $('#dimensionLable').text('Dimension:_ _X_ _');
	    <?php } ?>
	</script>
	<?php
}

if($_GET['action']=='proposalSettings' && $_GET['quotationId']!=''){
	
	if($_GET['quotationId']!=''){
		$id=decode($_GET['quotationId']); 
		$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$id.'');
		$quotationData=mysqli_fetch_array($rs1);
		$name=clean($quotationData['id']);
		$oldTourDate = date('Y-m-d',strtotime($quotationData['fromDate']));
		
		$rs1=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).'');
		$queryData=mysqli_fetch_array($rs1);
		if($quotationSubject != ''){
			$quotationSubject = stripslashes($queryData['subject']);
		}else{
			$quotationSubject = stripslashes($quotationData['quotationSubject']);
		}
		$queryDisplayId = makeQuotationId($quotationData['id']);
	}
	?>
	<div class="contentdiv">
		<h1 class="contentheader">Preview Settings</h1>
		<div class="contentbody" >
			<form action="proposal_frmaction.php" method="post" enctype="multipart/form-data" name="proposalFrm" target="actoinfrm" id="proposalFrm">
				<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;margin-bottom: 10px;">
					<label>Name:&nbsp;<?php echo ($quotationSubject); echo "&nbsp;#".$queryDisplayId;?></label>
				</div>
				<table cellpadding="0" cellspacing="0" border="0" class="" width="100%" bordercolor="#ddd">
					<tr>
						<td>
							<div class="griddivLable" >
								<div class="griddiv " >
									<div class="labelBorder" >Language Type</div>
									<!--  onChange="insertlanguage(this.value);"  -->
									<select id="languageId" name="languageId" class="gridfield">
										<!-- <option value="0">Default</option> -->
										<?php 
										$rs=GetPageRecord('id,name','tbl_languagemaster','1 and status=1 and deletestatus=0');
								        $totalrow = mysqli_num_rows($rs);
								        while($languageDetails=mysqli_fetch_array($rs)){
							        	?>
							        	<option value="<?php echo $languageDetails['id']; ?>" <?php if($languageDetails['id'] == $quotationData['languageId']){ echo "selected"; } ?>><?php echo $languageDetails['name']; ?></option>
							        	<?php } ?>
									</select> 	
								</div>
							</div>	
						</td>
						<td>
							<div class="griddivLable"  >
								<div class="griddiv "  >
									<div class="labelBorder" >Proposal Type</div>
									<select id="proposalType" name="proposalType" class="gridfield" onchange="getFormate(this.value)" >
										<?php  if($queryData['moduleType'] == 2 || $queryData['moduleType'] == 3 || $queryData['moduleType'] == 4){ ?>
											<option value="4" <?php if($quotationData['proposalType'] == 4){ echo "selected"; } ?>>Elite&nbsp;Proposal</option>
										<?php	 } else{ ?> 
											<option value="3" <?php if($quotationData['proposalType'] == 3){ echo "selected"; } ?>>Detailed&nbsp;Proposal</option>
											<option value="6" <?php if($quotationData['proposalType'] == 6){ echo "selected"; } ?>>Vivid&nbsp;Proposal</option>
							 				<option value="2" <?php if($quotationData['proposalType'] == 2){ echo "selected"; } ?>>Brief&nbsp;Proposal</option>
											<option value="4" <?php if($quotationData['proposalType'] == 4){ echo "selected"; } ?>>Elite&nbsp;Proposal</option>
											<option value="7" <?php if($quotationData['proposalType'] == 7){ echo "selected"; } ?>>Indian&nbsp;Proposal</option>
											<!-- <option value="11" >Style&nbsp;Proposal</option>  --> 
										<?php } ?>
									</select> 
								</div>
							</div>	
						</td>
						<td>
							<div class="griddivLable"  >
								<div class="griddiv "  >
									<div class="labelBorder" id="dimensionLable" >Dimension:800X300</div>
									<label for="proposalPhoto" class="upload_quotBanner"  id="upload_quotBanner" >
			  							<input type="file" name="proposalPhoto" id="proposalPhoto" class="file_hidden" onchange="upload_quotBanner(this,'PreviewPhoto','PreviewPhotoIMG');">Photo
			  						</label>
								</div>
							</div>	
						</td>
					</tr>
					<tr id="PreviewPhoto" style="display:none">
						<td colspan="3">
							<div class="griddivLable"  >
								<div class="griddiv "  >
									<div class="labelBorder" >New Photo</div>
									<img src="" width="100%" height="auto" id="PreviewPhotoIMG">
								</div>
							</div>	
						</td>
					</tr>
					<?php if($quotationData['image']!='' && file_exists('upload/'.$quotationData['image'])){ ?>
					<tr>
						<td colspan="3">
							<div class="griddivLable"  >
								<div class="griddiv "  >
									<div class="labelBorder" >Old Photo</div>
									<img src="<?php echo $fullurl.'PreviewFiles/upload/'.$quotationData['image']; ?>" alt="<?php echo 'PreviewFiles/upload/'.$quotationData['image']; ?>" width="100%">
								</div>
							</div>	
						</td>
					</tr>
					<?php } ?>
				</table>
				<input type="hidden" name="maxwidth" id="maxwidth" value="800">
				<input type="hidden" name="maxheight" id="maxheight" value="300">
				<input type="hidden" name="proposalPhoto2" id="proposalPhoto2" value="<?php echo $quotationData['image']; ?>">
				<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
				<input name="action" type="hidden" id="action" value="proposalSettings" />
				<div style="display:none" id="loadPropTypeBox"></div>
			</form>
		</div>
		<div class="contentfooter"  style="text-align:center;">
			<table border="0" align="right" cellpadding="0" cellspacing="0">
				<tr><td  ><input name="addnewuserbtn" type="button" class="blackbutton" id="addnewuserbtn" value=" Preview " onclick="formValidation('proposalFrm','submitbtn','0');" /></td>
				<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitebutton" id="Cancel" value="Close" onclick="proposal_alertspopupClose();" /></td>
			</tr>
			</table>
		</div>
	</div>
	<?php 
}
?>
