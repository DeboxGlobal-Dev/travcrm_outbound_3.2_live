<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
if($_SESSION['companymastersettingsId']==''){
header('location:crm_logout_page.php');
}

$rs1=GetPageRecord('*','companySettingsMaster','id=1');
if(mysqli_num_rows($rs1)==0){
	$sql_del="TRUNCATE TABLE companySettingsMaster";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));

	$sql_del="TRUNCATE TABLE componyFinanceSetting";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));

	$sql_del="TRUNCATE TABLE companyVersionInfoSetting";
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));

	$namevalue ='queryIdSequence="",tourId="",referanceIdType="",clientVoucherNoSequence=""';
	$editId=addlistinggetlastid('companySettingsMaster',$namevalue);


	$namevalue1 ='companySettingId="'.$editId.'"';
	addlistinggetlastid('componyFinanceSetting',$namevalue1);


	$namevalue2 ='companySettingId="'.$editId.'"';
	addlistinggetlastid('companyVersionInfoSetting',$namevalue2);


}else{
	$editresult=mysqli_fetch_array($rs1);
	$editId=clean($editresult['id']);
}
  
$rsfs=GetPageRecord('*','componyFinanceSetting','companySettingId="'.$editId.'"');
$editresultfs=mysqli_fetch_array($rsfs);

$rsvi=GetPageRecord('*','companyVersionInfoSetting','companySettingId="'.$editId.'"');
$editresultvi=mysqli_fetch_array($rsvi);

?>
<style>
.savebutton{
	border-radius: 3px;
	background-color: #568b93;
	border: 1px solid #568b93;
	color: white;
	padding: 5px;
	width: 51px;
}
.mb-15{
	margin-bottom: 15px!important;
}
</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="plugins/select2/select2.min.js"></script>
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<script src="plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
$(function () {
	$('input[type="radio"]').iCheck({
   	checkboxClass: 'icheckbox_square-blue',
   	radioClass   : 'iradio_square-blue',
   	increaseArea : '20%' // optional
	})
})
</script>
<div class="rightsectionheader">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><div class="headingm"><span id="topheadingmain">Update Company Master Settings </span></div></td>
		<td align="right"><?php
			$ccc="select id from "._USER_MASTER_." where  superParentId=".$loginusersuperParentId."  and status=1 ";
			$ddd = mysqli_query(db(),$ccc);
			$totaluserscreated=mysqli_num_rows($ddd);
			if($Logintimeuserzone['noofusers']>$totaluserscreated || $Logintimeuserzone['noofusers']==$totaluserscreated){ } else {?><table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>        </td>
					<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
					<td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
					<td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
				</tr>
				
			</table><?php } ?></td>
		</tr>
		
	</table>
</div>
<div id="pagelisterouter">

<!-- Office branches code started  -->
<div class="branchesSecMain" style="padding-left: 40px;">
	<?php 
	include 'officeBranchs.php'; 
	?>
</div>
<!-- Office branches code ended -->



	<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post" enctype="multipart/form-data">
		
		<div class="addeditpagebox">
			<input name="action" type="hidden" id="action" value="addcompanymastersettings" />
			<input name="savenew" type="hidden" id="savenew" value="0" />
			<input name="editid" type="hidden" id="editid" value="<?php echo encode($editId); ?>" />


			
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>Account Information</h2></div></td>
				</tr>
				<tr>
						<td width="50%" align="left" valign="top" style="padding-right:20px;">
							
							<div class="griddiv" style="display: none;">
								<label>
									<div class="gridlable">Company Name</div>
									<input name="companyName" type="text" class="gridfield" id="companyName" value="<?php echo clean($editresult['companyName']); ?>" />
								</label>
							</div>

							<div class="griddiv" style="display: none1;">
								<label>
									<div class="gridlable">PAN/IT Information</div>
									<input name="panInformation" type="text" class="gridfield" id="panInformation" value="<?php echo clean($editresult['panInformation']); ?>" />
								</label>
							</div>
									
							<div class="trnCin" style="display:flex;display: none1;">

								<!-- CIN Number -->
								<div class="griddiv">
									<label>
										<div class="gridlable">CIN</div>
										<input name="CINnumber" type="text" class="gridfield" id="CINnumber" value="<?php echo clean($editresult['CINnumber']); ?>" maxlength="50"/>
									</label>
								</div>

								<!-- TRN  -->
								<div class="griddiv" style="margin-left: 100px;">
									<label>
										<div class="gridlable">TRN No.</div>
										<input name="TRNnumber" type="text" class="gridfield" id="TRNnumber" value="<?php echo clean($editresult['TRNnumber']); ?>" maxlength="50"/>
									</label>
								</div>


							</div>
							



							
							<div class="griddiv">
								<label>
									<div class="gridlable">Query Id Sequence</div>
									<input name="queryIdSequence" type="text" class="gridfield " id="queryIdSequence" value="<?php echo clean($editresult['queryIdSequence']); ?>" maxlength="2" displayname="Query Id Sequence" autocomplete="off" />
								</label>
							</div>
							<div class="griddiv">
								<label>
									<div class="gridlable">Tour Id</div>
									<input name="tourId" type="text" class="gridfield " id="tourId" value="<?php echo clean($editresult['tourId']); ?>" autocomplete="off"  maxlength="2" />
								</label>
							</div>
							<?php
							if($editresult['referanceIdType']==1){
								$rfidon='style="display:block;"';
								$rfidoff='style="display:none;"';
							?>
							<script>
							$('#referanceId').prop('readonly', false);
							</script>
							<?php
							}else{
							$rfidon='style="display:none;"';
							$rfidoff='style="display:block;"';
							$readonlyreferanceId='readonly';
							
							}
							?>

					
					
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">

							<tr>
								<td width="37%" valign="top"><div >Footer&nbsp;Text&nbsp;</div>
								<?php 

								if($editresult['footerstatus']==1){ ?>
								<div id="onbtnproposal" class="selectviewall switchouter switchouteron" onclick="footerEnableDisable('showHidefooter');" ></div>
								<?php }else{ ?>
								<div id="offbtnproposal" class="selectviewall switchouter switchouteroff " onclick="footerEnableDisable('showHidefooter');" ></div>
								<?php } ?>
								<td>
								<div class="griddiv">
									<label>
										
										<input name="footertext" type="text" class="gridfield" id="footertext" autocomplete="off" placeholder="Generated by travCRM" value="<?php if($editresult['footertext']!=''){ echo $editresult['footertext']; }else{  echo "Generated by travCRM"; } ?>"/>
									</label>
								</div></td>
							</tr>
							<div id="loadfooterfile"></div>
							<script>
							
							function footerEnableDisable(action){
								
							$("#loadfooterfile").load('loadfootertextfile.php?action='+action);

							location.reload();
							
							}
							
							</script>
						</table>



						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">

							<tr>
								<td width="37%" valign="top"><div >Reference&nbsp;Id&nbsp;<span id="refauto">Auto</span><span id="refmanual" style="display:none;">Manual</span></div>
								<div id="onbtn" class="selectviewall switchouter switchouteron " onclick="$('#offbtn').show();$('#refmanual').show();$('#refauto').hide();$('#onbtn').hide();$('#referanceId').val('');$('#referanceIdType').val('0');$('#referanceId').prop('readonly', true);" <?php echo $rfidon; ?>></div>
								
								<div id="offbtn" class="selectviewall switchouter switchouteroff " onclick="$('#offbtn').hide();$('#refmanual').hide();$('#refauto').show();$('#onbtn').show();$('#referanceId').val('<?php echo clean($editresult['referanceId']); ?>');$('#referanceIdType').val('1');$('#referanceId').prop('readonly', false);" <?php echo $rfidoff; ?> ></div>
								<input type="hidden" name="referanceIdType" id="referanceIdType" value="<?php echo $editresult['referanceIdType']; ?>" /></td>
								<td width="63%"><div class="griddiv" id="refon">
									<label>
										<div class="gridlable">(Eg. R <?php echo date('Y'); ?> 0001)</div>
										<input name="referanceId" type="text" class="gridfield" id="referanceId" autocomplete="off" placeholder="x_xxxx_xxxx" value="<?php echo clean($editresult['referanceId']); ?>" maxlength="9" <?php echo $readonlyreferanceId; ?>/>
									</label>
								</div></td>
							</tr>
						</table>
						
						<?php
						if($editresult['clientVoucherType']==1){
							$onbtncvs='style="display:block;"';
							$offbtncvs='style="display:none;"';
						}else{
						$onbtncvs='style="display:none;"';
						$offbtncvs='style="display:block;"';
						$readonlyclientVoucherNoSequence='readonly';
						}
						?>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">
							<tr>
								<td width="37%" valign="top"><div >Client Voucher Sequence <span id="cvsauto">Auto</span><span id="cvsmanual" style="display:none;">Manual</span></div>
								<div id="onbtncvs" class="selectviewall switchouter switchouteron " onclick="$('#cvsmanual').show();$('#cvsauto').hide();$('#offbtncvs').show();$('#onbtncvs').hide();$('#clientVoucherNoSequence').val('');$('#clientVoucherType').val('0');$('#clientVoucherNoSequence').prop('readonly', true);" <?php  echo $onbtncvs; ?>></div>
								<div id="offbtncvs" class="selectviewall switchouter switchouteroff " onclick="$('#cvsmanual').hide();$('#cvsauto').show();$('#offbtncvs').hide();$('#onbtncvs').show();$('#clientVoucherNoSequence').val('<?php echo clean($editresult['clientVoucherNoSequence']); ?>');$('#clientVoucherType').val('1');$('#clientVoucherNoSequence').prop('readonly', false);" <?php  echo $offbtncvs; ?>></div>
								<input type="hidden" name="clientVoucherType" id="clientVoucherType" value="<?php echo $editresult['clientVoucherType']; ?>" /></td>
								<td width="63%"><div class="griddiv" id="refoncvs"><label><div class="gridlable">(Eg. R <?php echo date('Y'); ?> 0001)</div>
								<input name="clientVoucherNoSequence" type="text"  class="gridfield" id="clientVoucherNoSequence" value="<?php echo clean($editresult['clientVoucherNoSequence']); ?>" autocomplete="off" placeholder="x_xxxx_xxxx" maxlength="9" <?php echo $readonlyclientVoucherNoSequence; ?> />
							</label>
						</div></td>
					</tr>
				</table>
				
				
				<?php
				if($editresult['supplierVoucherType']==1){
					$onbtnsvs='style="display:block;"';
					$offbtnsvs='style="display:none;"';
				}else{
				$onbtnsvs='style="display:none;"';
				$offbtnsvs='style="display:block;"';
				$readonlysupplierVoucherNoSequence='readonly';
				}
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">
					<tr>
						<td width="37%" valign="top"><div >Supplier Voucher Sequence <span id="svsauto">Auto</span><span id="svsmanual" style="display:none;">Manual</span></div>
						<div id="onbtnsvs" class="selectviewall switchouter switchouteron " onclick="$('#svsmanual').show();$('#svsauto').hide();$('#offbtnsvs').show();$('#onbtnsvs').hide();$('#supplierVoucherNoSequence').val('');$('#supplierVoucherType').val('0');$('#supplierVoucherNoSequence').prop('readonly', true);" <?php  echo $onbtnsvs; ?>></div>
						<div id="offbtnsvs" class="selectviewall switchouter switchouteroff " onclick="$('#svsmanual').hide();$('#svsauto').show();$('#offbtnsvs').hide();$('#onbtnsvs').show();$('#supplierVoucherNoSequence').val('<?php echo clean($editresult['voucherNoSequence']); ?>');$('#supplierVoucherType').val('1');$('#supplierVoucherNoSequence').prop('readonly', false);" <?php  echo $offbtnsvs; ?>></div>
						<input type="hidden" name="supplierVoucherType" id="supplierVoucherType" value="<?php echo $editresult['supplierVoucherType']; ?>" /></td>
						<td width="63%"><div class="griddiv" id="refonsvs">
							<label><div class="gridlable">(Eg. R <?php echo date('Y'); ?> 0001)</div>
							<input name="supplierVoucherNoSequence" type="text"  class="gridfield" id="supplierVoucherNoSequence" value="<?php echo clean($editresult['supplierVoucherNoSequence']); ?>" autocomplete="off" placeholder="x_xxxx_xxxx" maxlength="9" <?php echo $readonlysupplierVoucherNoSequence; ?> />
						</label>
					</div></td>
				</tr>
			</table>
			<?php
			if($editresult['proformaInvoiceType']==1){
			$onbtnpi='style="display:block;"';
			$offbtnpi='style="display:none;"';
			}else{
			$onbtnpi='style="display:none;"';
			$offbtnpi='style="display:block;"';
			$readonlyproformaInvoiceNoSequence='readonly';
			}
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">
				<tr>
					<td width="37%" valign="top"><div >Proforma Invoice Sequence <span id="piauto">Auto</span><span id="pimanual" style="display:none;">Manual</span></div>
					<div id="onbtnpi" class="selectviewall switchouter switchouteron " onclick="$('#pimanual').show();$('#piauto').hide();$('#offbtnpi').show();$('#onbtnpi').hide();$('#proformaInvoiceNoSequence').val('');$('#proformaInvoiceType').val('0');$('#proformaInvoiceNoSequence').prop('readonly', true);" <?php  echo $onbtnpi; ?>></div>
					<div id="offbtnpi" class="selectviewall switchouter switchouteroff " onclick="$('#pimanual').hide();$('#piauto').show();$('#offbtnpi').hide();$('#onbtnpi').show();$('#proformaInvoiceNoSequence').val('<?php echo clean($editresult['proformaInvoiceNoSequence']); ?>');$('#proformaInvoiceType').val('1');$('#proformaInvoiceNoSequence').prop('readonly', false);" <?php  echo $offbtnpi; ?>></div>
					<input type="hidden" name="proformaInvoiceType" id="proformaInvoiceType" value="<?php echo $editresult['proformaInvoiceType']; ?>" /></td>
					<td width="63%"><div class="griddiv" id="refonsvs">
						<label><div class="gridlable">(Eg. R 0001)</div>
						<input name="proformaInvoiceNoSequence" type="text"  class="gridfield" id="proformaInvoiceNoSequence" value="<?php echo clean($editresult['proformaInvoiceNoSequence']); ?>" autocomplete="off" placeholder="x_xxxx_xxxx" maxlength="20" <?php echo $readonlyproformaInvoiceNoSequence; ?> />
					</label>
				</div></td>
			</tr>
		</table>
		
		<?php
		if($editresult['taxInvoiceType']==1){
		$onbtnti='style="display:block;"';
		$offbtnti='style="display:none;"';
		}else{
		$onbtnti='style="display:none;"';
		$offbtnti='style="display:block;"';
		$readonlytaxInvoiceNoSequence='readonly';
		}
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">
			<tr>
				<td width="37%" valign="top"><div >Tax Invoice Sequence <span id="tiauto">Auto</span><span id="timanual" style="display:none;">Manual</span></div>
				<div id="onbtnti" class="selectviewall switchouter switchouteron " onclick="$('#timanual').show();$('#tiauto').hide();$('#offbtnti').show();$('#onbtnti').hide();$('#taxInvoiceNoSequence').val('');$('#taxInvoiceType').val('0');$('#taxInvoiceNoSequence').prop('readonly', true);" <?php  echo $onbtnti; ?>></div>
				<div id="offbtnti" class="selectviewall switchouter switchouteroff " onclick="$('#timanual').hide();$('#tiauto').show();$('#offbtnti').hide();$('#onbtnti').show();$('#taxInvoiceNoSequence').val('<?php echo clean($editresult['taxInvoiceNoSequence']); ?>');$('#taxInvoiceType').val('1');$('#taxInvoiceNoSequence').prop('readonly', false);" <?php  echo $offbtnti; ?>></div>
				<input type="hidden" name="taxInvoiceType" id="taxInvoiceType" value="<?php echo $editresult['taxInvoiceType']; ?>" /></td>
				<td width="63%"><div class="griddiv" id="refonsvs">
					<label><div class="gridlable">(Eg. R 0001)</div>
					<input name="taxInvoiceNoSequence" type="text"  class="gridfield" id="taxInvoiceNoSequence" value="<?php echo clean($editresult['taxInvoiceNoSequence']); ?>" autocomplete="off" placeholder="x_xxxx_xxxx" maxlength="20" <?php echo $readonlytaxInvoiceNoSequence; ?> />
				</label>
			</div></td>
		</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">
	<tbody>
		<tr>
			<td width="30%" valign="top">
				<div class="griddiv" style="margin-bottom: 20px;border-bottom: 0;">
					<label>
					<div class="gridlable">Base Currency</div>
					<select id="baseCurrencyId" name="baseCurrencyId" class="gridfield validate"  displayname="Base Currency " >
						<option value="0">Select Base Currency</option>
						<?php 
						$rsn="";
						// echo $editresult['baseCurrencyId'];
						$rsn=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and country!=0 and status=1 '); 
						while($currencyData=mysqli_fetch_array($rsn)){ 
						?>
						<option value="<?php echo $currencyData['id']; ?>" <?php if($currencyData['id'] == $editresult['baseCurrencyId']){ ?>selected="selected"<?php } ?>><?php echo clean($currencyData['name']); ?></option>
						<?php } ?>
					</select>
					</label>
				</div>
			</td>
			
			<td width="30%">
				<div class="griddiv" style="margin-bottom: 20px;border-bottom: 0;">
					<label>
					<div class="gridlable">Base Country</div>
					<select id="countryId" name="countryId" class="gridfield validate"  displayname="Base Country " >
						<option value="0">Select Base Country</option>
						<?php 
						$rsn="";
						// echo $editresult['countryId'];
						$rsn=GetPageRecord('*',_COUNTRY_MASTER_,' deletestatus=0 order by name asc'); 
						while($countryData=mysqli_fetch_array($rsn)){ 
						?>
						<option value="<?php echo $countryData['id']; ?>" <?php if($countryData['id'] == $editresult['countryId']){ ?>selected="selected"<?php } ?>><?php echo clean($countryData['name']); ?></option>
						<?php } ?>
					</select>
					</label>
				</div>
			</td>
			<!-- added new fileds in nationalty default -->
			
			<!-- country code related code started -->
			<td width="20%">
				<div class="griddiv" style="margin-bottom: 20px;border-bottom: 0;">
					<label>
					<div class="gridlable">Country Code</div>
					<select id="compcountryCode" name="compcountryCode" class="gridfield validate"  displayname="Base Country " >
						<option value="0">Select Country Code</option>
						<?php 
						$rsn="";
						// echo $editresult['countryId'];
						$rsn=GetPageRecord('*',_COUNTRY_MASTER_,' deletestatus=0 order by name asc'); 
						while($countryData=mysqli_fetch_array($rsn)){ 
						?>
						<option value="<?php echo $countryData['phonecode']; ?>" <?php if($countryData['phonecode'] == $editresult['compcountryCode']){ ?>selected="selected"<?php } ?>><?php echo '+'.clean($countryData['phonecode']); ?></option>
						<?php } ?>
					</select>
					</label>
				</div>
			</td>
			<!-- country code related code ended -->
			<td width="20%" align="left">
				<div class="griddiv"><label>
				<div class="gridlable">Nationality<span class="redmind"></span></div>
                <select name="nationality" id="nationality" class="gridfield " displayname="Nationality">
                <option value=""> Select Nationality</option>
                <?php   
                $rs=GetPageRecord($select,'nationalityMaster',' deletestatus=0 order by name asc');  
                while($resListing22=mysqli_fetch_array($rs)){   
                ?> 
                <option value="<?php echo $resListing22['id']; ?>" <?php if($resListing22['id'] == $editresult['nationality']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing22['name']); ?></option> 
                <?php } ?>
                </select>
				</label>
				</div>
			</td>

		</tr>
	 

		<tr><td colspan="4"><hr></td></tr>
		<tr><td colspan="4">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;padding:10px;border:1px solid #ddd;border-radius: 2px;">
					<tr><td colspan="2"><label>Query Type</label><br><br></td></tr>	
					<tr>
					<td width="50%" valign="top">
						<div class="griddiv"> 
							<div colspan="2" style="border: 1px solid #e0e0e0;padding: 6px;font-size: 15px;">
								<input type="checkbox" <?php if($editresult['internationalQuery']==1){ ?> checked <?php } ?> name="international" id="international" value="1" style="display: inline-block;"> <span style="position: relative;top: -2px;">International</span>
								<br>
								<br>
								<input type="checkbox" <?php if($editresult['defaultQueryType']==1){ ?> checked <?php } ?> name="queryTypeSetDefault" id="queryTypeSetDefault" value="1" style="display: inline-block;"> <span style="position: relative;top: -2px;">Set Default</span>	
							</div> 
						</div>
					</td>
					<td width="50%" valign="top">
						<div class="griddiv"> 
							<div colspan="2" style="border: 1px solid #e0e0e0;padding: 6px;font-size: 15px;">
								<input type="checkbox" <?php if($editresult['domesticQuery']==1){ ?> checked <?php } ?> name="domestic" id="domestic" value="1" style="display: inline-block;"> <span style="position: relative;top: -2px;">Domestic</span>
								<br>
								<br>
								<input type="checkbox" <?php if($editresult['defaultQueryType']==2){ ?> checked <?php } ?> name="queryTypeSetDefault" id="queryTypeSetDefault" value="2" style="display: inline-block;"> <span style="position: relative;top: -2px;">Set Default</span>
							</div> 
						</div>
					</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="4"><hr></td></tr>
		<tr><td colspan="4">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;padding:10px;border:1px solid #ddd;border-radius: 2px;">
					<tr><td colspan="2"><label>Tax Type</label><br><br></td></tr>	
					<tr>
					<td width="50%" valign="top">
						<div class="griddiv"> 
							<div colspan="2" style="border: 1px solid #e0e0e0;padding: 6px;font-size: 15px;"><input type="checkbox" <?php if($editresult['sameOtherSTax']==1){ ?> checked <?php } ?> name="sameOtherSTax" id="sameOtherSTax" value="1" style="display: inline-block;"> <span style="position: relative;top: -2px;">Same and Other State</span></div> 
						</div>
					</td>
					<td width="50%" valign="top">
						<div class="griddiv"> 
							<div colspan="2" style="border: 1px solid #e0e0e0;padding: 6px;font-size: 15px;"><input type="checkbox" <?php if($editresult['taxOnly']==1){ ?> checked <?php } ?> name="taxOnly" id="taxOnly" value="1" style="display: inline-block;"> <span style="position: relative;top: -2px;">Tax Only</span></div> 
						</div>
					</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="4"><hr></td></tr>
		<tr>
			<td colspan="4"> 
				<label>TourId Sequence</label>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;padding:10px;border:1px solid #ddd;border-radius: 2px;">
					<tr>
					<td width="50%" valign="top">
						<div class="griddiv">
							<label class="gridlable" style="color:#000;margin-bottom:10px">TourId (Month Wise Sequence)</label>
							<div class="mb-15">
								<input type="radio" name="tourIdSequence" id="tourIdSq1" value="1" class="gridfield iradio_square-blue" <?php if($editresult['tourIdSequence']==1){ echo 'checked'; } ?>>
								<label for="tourIdSq1">&nbsp;&nbsp;YY/MM/MWS/UserInitial</label>
							</div>
						</div>
					</td>
					<td width="50%" valign="top">
						<div class="griddiv">
							<label class="gridlable" style="color:#000;margin-bottom:10px">TourId (Year Wise Sequence)</label>
							<div class="mb-15">
								<input type="radio" name="tourIdSequence" id="tourIdSq2" value="2" class="gridfield iradio_square-blue" <?php if($editresult['tourIdSequence']==2){ echo 'checked'; } ?>>
								<label for="tourIdSq2">&nbsp;&nbsp;YY/MM/YWS/UserInitial</label>
							</div>
						</div>
					</td>
					</tr>
				 
				</table>
			</td>
		</tr>
		<tr><td colspan="4"><hr></td></tr>
		<tr>
			<td colspan="4"> 
				<label>Hotel Import Format</label>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;padding:10px;border:1px solid #ddd;border-radius: 2px;">
					<tr>
						<td width="50%" valign="top" colspan="2">
							<div class="griddiv">
								<!-- <label class="gridlable" style="color:#000;margin-bottom:10px">TourId (Month Wise Sequence)</label> -->
								<div class="mb-15">
									<input type="radio" name="hotelImportFormatType" id="hift1" value="1" class="gridfield iradio_square-blue" <?php if($editresult['hotelImportFormatType']==1){ echo 'checked'; } ?>>
									<label for="hift1">&nbsp;&nbsp;INTERNATIONAL</label>
								</div>
							</div>
						</td>
						<td width="50%" valign="top" colspan="2">
							<div class="griddiv">
								<!-- <label class="gridlable" style="color:#000;margin-bottom:10px">TourId (Year Wise Sequence)</label> -->
								<div class="mb-15">
									<input type="radio" name="hotelImportFormatType" id="hift2" value="2" class="gridfield iradio_square-blue" <?php if($editresult['hotelImportFormatType']==2){ echo 'checked'; } ?>>
									<label for="hift2">&nbsp;&nbsp;DOMESTIC</label>
								</div>
							</div>
						</td>
					</tr>
				</table>
				
			</td>
		</tr> 


		<!-- TMS code started  -->
		<tr><td colspan="4"><hr></td></tr>
		<tr>
			<td colspan="4"> 
				<label>TMS </label>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;padding:10px;border:1px solid #ddd;border-radius: 2px;">
					<tr>
						<td width="50%" valign="top" colspan="2">
							<div class="griddiv">
								<!-- <label class="gridlable" style="color:#000;margin-bottom:10px">TourId (Month Wise Sequence)</label> -->
								<div class="mb-15">
									<input type="radio" name="TMS" id="hift1" value="1" class="gridfield iradio_square-blue" <?php if($editresult['TMS']==1){ echo 'checked'; } ?>>
									<label for="hift1">&nbsp;&nbsp;Show</label>
								</div>
							</div>
						</td>
						<td width="50%" valign="top" colspan="2">
							<div class="griddiv">
								<!-- <label class="gridlable" style="color:#000;margin-bottom:10px">TourId (Year Wise Sequence)</label> -->
								<div class="mb-15">
									<input type="radio" name="TMS" id="hift2" value="2" class="gridfield iradio_square-blue" <?php if($editresult['TMS']==2){ echo 'checked'; } ?>>
									<label for="hift2">&nbsp;&nbsp;No</label>
								</div>
							</div>
						</td>
					</tr>
				</table>
				
			</td>
		</tr>

		<!-- TMS code Ended  -->

		</tbody>
	</table>
	<script>
		$('input[type="checkbox"]').on('change', function() {
		    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
		});  
	</script>
	</td>
	<td width="50%" align="left" valign="top" style="padding-left:20px;">
		<div style="margin: 27px 0px 100px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left"><a href="<?php echo $fullurl; ?>showpage.crm?module=invoicesetting" target="_blank" style="border: 1px solid #568b93; padding: 8px 50px; width: fit-content; text-align: center; border-radius: 2px; background-color: #568b93; color: #fff !important; cursor: pointer;">Invoice Settings</a></td>
					<td align="left"><a href="<?php echo $fullurl; ?>showpage.crm?module=vouchersetting" target="_blank" style="border: 1px solid #f67e29; padding: 8px 50px; width: fit-content; text-align: center; border-radius: 2px; background-color: #f67e29; color: #fff !important; cursor: pointer;">Voucher Settings</a></td>
				</tr>
			</table>
		</div>


		<div class="griddiv"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($editresult['proposalLogo']); ?>" style="max-height: 130px; max-width: 500px;" />
		</div>
		
		<div class="griddiv"><label>
			<div class="gridlable">Proposal Logo Upload</div>
			<input name="proposalLogo" type="file" class="gridfield" id="proposalLogo" />
			<input type="hidden" name="oldproposalLogo" value="<?php echo clean($editresult['proposalLogo']); ?>" />
		</label>
		</div>




		<!-- Change Company setting login Image Started  -->

		<div class="griddiv"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($editresult['changeLoginImage']); ?>" style="max-height: 130px; width: 100%;" />
		</div>
		
		<div class="griddiv"><label>
			<div class="gridlable">Login Image Upload   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red;">( Image size:1415x612px )</span></div>
			<input name="changeLoginImage" type="file" class="gridfield" id="changeLoginImage" />
			<input type="hidden" name="oldchangeLoginImage" value="<?php echo clean($editresult['changeLoginImage']); ?>" />
		</label>
		</div>

		<!-- Chnage Company setting login Image Enede -->




		<div class="griddiv"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($editresult['logoupload']); ?>" style="max-height: 70px; max-width: 500px;" />
		</div>

		<div class="griddiv"><label>
			<div class="gridlable">Logo Upload</div>
			<input name="logoupload" type="file" class="gridfield" id="logoupload" />
			<input type="hidden" name="oldlogoupload" value="<?php echo clean($editresult['logoupload']); ?>" />
			</label>
		</div>
 
		<!-- VERSION INFO -->
		<div style="margin: 20px 0px">
			<div style="color: #8a8a8a;margin-bottom: 7px;font-size: 13px;">Version Infomation<span id="vsuccessmessage" style="color: #4CAF50;font-size: 15px;
			margin-left: 68px;display:none;">Version Info Updated Successfully</span></div>
			<div id="developerremark" style="border: 1px solid #eee;padding: 0px;">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#eee">
					<tr>
						<td width="30%"><div class="griddiv">
							<label><div class="gridlable">Version No<span id="validationalertvn" style="color: #ef0505;
								margin-left:12px;display:none;">* &nbsp; Please Enter Developer Name</span></div><input name="versionNo" type="text" class="gridfield " id="versionNo" value="<?php echo $editresultvi['versionNo']; ?>" autocomplete="off"></label>
							</div></td>
							<td width="35%"><div class="griddiv">
								<label>
									<div class="gridlable">Developer Name</div>
									<input name="developerNamev" type="text" class="gridfield " id="developerNamev" value="<?php echo $editresultvi['developerName']; ?>" autocomplete="off">
									
								</label>
							</div></td>
							<td width="33%"><div class="griddiv">
								<label>
									<div class="gridlable">Database Name</div>
									<input name="databaseNamev" type="text" class="gridfield " id="databaseNamev" value="<?php echo $editresultvi['databaseName']; ?>" autocomplete="off">
									
								</label>
							</div></td>
							<td width="25%"><div class="griddiv">
								<label>
									<div class="gridlable">Deployment date</div>
									<input name="dateAdded" type="date" class="gridfield " id="dateAdded" value="<?php echo $editresultvi['dateAdded']; ?>" autocomplete="off">
									<input name="editidv" type="hidden" class="gridfield " id="editidv" value="<?php echo $editresultvi['id']; ?>" >
								</label>
							</div></td>
							<td width="10%"><input name="addnewuserbtn2" type="button" class="savebutton" id="addnewuserbtn2" value="Save" onclick="addversioninfo('<?php echo $editId; ?>')" style="border-radius: 3px;"></td>
						</tr>
						
					</table>
					
					
				</div>
				<div id="loadversioninfo"></div>
				<script>
				function addversioninfo(id){
				var versionNo = $('#versionNo').val();
					var developerName = $('#developerNamev').val();
					var databaseName = $('#databaseNamev').val();
					var dateAdded = $('#dateAdded').val();
					alert(dateAdded);
					var editid = $('#editidv').val();
					if(versionNo!=''){
						$("#loadversioninfo").load('loadCompanyExtraactivuty.php?action=versioninformation&versionNo='+versionNo+'&developerName='+developerName+'&databaseName='+databaseName+'&dateAdded='+dateAdded+'&id='+id+'&editid='+editid);
					}else{
					$('#validationalertvn').show();
					}
					
				}
				
				function loadalldevelopers(){
				$("#developerremarklist").load('loadalldevelopers.php');
				}
				</script>
		</div>
	</td>
	</tr>
</table>

</div>
<div class="rightfootersectionheader">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="right">
	<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>        </td>
<td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','1');" /></td>
<td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
</tr>

</table></td>
</tr>

</table>
</div>

</form>

</div>
<style>
.addeditpagebox .griddiv .gridlable {
width: 100% !important;
	}
</style>