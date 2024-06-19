<?php
$searchField=clean($_GET['searchField']);
$searchFieldcommon=clean($_GET['searchFieldcommon']);
if($_REQUEST['id']!=''){
$select1='*';
$where1='id='.decode($_REQUEST['id']).'';
$rs1=GetPageRecord($select1,'cmspackageBuilderDetail',$where1);
$editresult=mysqli_fetch_array($rs1);
}

?>
 
<?php if($_REQUEST['type']==2){
$selecttab=1;
if($_REQUEST['selecttab']!=''){
$selecttab=$_REQUEST['selecttab'];
}
if($_REQUEST['id']!=''){
$select='';
	$where='';
	$rs='';
	$select='*';
	$where=' packageId='.$editresult['id'].'  ';
	$rs=GetPageRecord($select,_PACKAGE_BUILDER_TERMS_CONDITIONS_,$where);
	$termsmaintable=mysqli_fetch_array($rs);
	}
	
	
	
	
	
	
	
if($_REQUEST['dlt']==1){
$wheredel='packageId='.trim($editresult['id']).'';
deleteRecord(_PACKAGE_BUILDER_DAYS_MASTER_,$wheredel);

$wheredel='packageId='.trim($editresult['id']).'';
deleteRecord(_PACKAGE_BUILDER_HOTEL_CITY_MASTER_,$wheredel);
$wheredel='packageId='.trim($editresult['id']).'';
deleteRecord(_PACKAGE_BUILDER_HOTEL_,$wheredel);
$wheredel='packageId='.trim($editresult['id']).'';
deleteRecord(_PACKAGE_BUILDER_SIGHTSEEING_,$wheredel);
$wheredel='packageId='.trim($editresult['id']).'';
deleteRecord(_PACKAGE_BUILDER_TRANSFER_,$wheredel);
$wheredel='packageId='.trim($editresult['id']).'';
deleteRecord(_PACKAGE_BUILDER_AIRLINES_,$wheredel);
?>
<script>
window.location.href = "showpage.crm?module=packagebuilder&add=yes&id=<?php echo encode($editresult['id']); ?>&selecttab=2";
</script>
<?PHP
}
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap4.css">
<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="plugins/pace/pace.min.css">
<script src="bower_components/PACE/pace.min.js"></script>
<script src="js/validation.js"></script>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script src="tinymce/tinymce.min.js"></script>
<script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
<style>
.topnavtab{ margin-bottom:0px; overflow:hidden; border-bottom:2px solid #ffc115;}
.topnavtab a{float:left; padding:10px 20px; font-size:16px; color:#FFFFFF; margin-right:10px; background-color:#333333; text-decoration:none; font-weight:600;}
.topnavtab .active{background-color:#ffc115;}
.contentboxiti{padding:20px; background-color:#FFFFFF; border:1px #CCCCCC solid; border-top:0px;}
</style>
<div id="pagelisterouter" style="padding: 20px; box-sizing: border-box; padding-top: 60px;">


<div class="addeditpagebox contentboxiti" style="margin-top:20px; border:0px !important; ">
<style>
.tbheaderm {
margin-bottom: 20px;
font-size: 16px;
font-weight: 500;
padding: 10px;
background-color: #cccccc61;
border-bottom: 2px #0b992a solid;
}
.mainbox .gridlable{margin-bottom:2px !important;margin-top:10px !important; border:0px !important;}
.griddiv{ border:0px !important;}
input{max-height: 35px !important;}


.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #0b992a;
    border-radius: 4px;
    border-radius: 0px; 
    min-height: 35px;
}
</style>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">

<div style="padding: 20px; border: 1px solid #cccccc94;   box-shadow: 0px 0px 10px #c8c8c8; margin-bottom:10px;" class="mainbox">
<h2 style="text-align:left;text-align: left; padding: 10px; background-color: #cccccc40; border-bottom: 2px solid #e3e3e3; margin-bottom:0px;">Package Details</h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr>
		<td colspan="3" align="left" valign="top" style="padding-bottom:20px; display:none;">
			
			
			
			
			<label class='checked checkbox-inline text-center' style="width:100% !important;">
			<input name='pacakageSection' type='radio'   class='' value ='1' />  Static Package</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label class='checked checkbox-inline text-center' style="width:100% !important;">
			<input type='radio' name='pacakageSection' value ='2'  checked="checked" <?php if($editresult['pacakageSection']==2) { echo 'checked' ;}?>  class=''  />
			Dynamic Package			</label>
			<div class="griddiv" style="display:none;">
				<label>
					<div class="gridlable">GSTN</div>
					<input name="gstn" type="text" class="gridfield" id="gstn" value="<?php echo $editgstn; ?>" maxlength="100"  style="text-transform:uppercase;" />
				</label>
			</div>
			<div style="display:none;">
				<div class="griddiv">
					<label>
						<div class="gridlable">Country  <span class="redmind"></span></div>
						<select id="countryId" name="countryId" class="gridfield" displayname="Country" autocomplete="off" onchange="selectstate();" >
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
							<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcountryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
							<?php } ?>
						</select>
					</label>
				</div>
				
				<div class="griddiv">
					<label>
						<div class="gridlable">State </div>
						<select id="stateId" name="stateId" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();" >
						</select>
					</label>
				</div>
				
				
				<div class="griddiv">
					<label>
						<div class="gridlable">City </div>
						<select id="cityId" name="cityId" class="gridfield" displayname="State" autocomplete="off" >
						</select>
					</label>
				</div>
				
				<div class="griddiv">
					<label>
						<div class="gridlable">Address 1  </div>
						<input name="address1" type="text" class="gridfield" id="address1" value="<?php echo $editaddress1; ?>" maxlength="250" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Address 2  </div>
						<input name="address2" type="text" class="gridfield" id="address2" value="<?php echo $editaddress2; ?>" maxlength="250" />
					</label>
				</div>
				<div class="griddiv">
					<label>
						<div class="gridlable">Address 3</div>
						<input name="address3" type="text" class="gridfield" id="address3" value="<?php echo $editaddress3; ?>" maxlength="250" />
					</label>
				</div>
				
				<div class="griddiv">
					<label>
						<div class="gridlable">Pin Code </div>
						<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $editpinCode; ?>" maxlength="15" />
					</label>
				</div>
			</div>		</td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top" style="padding-right:20px;">
			<div class="griddiv" style="border-bottom:0px; display:none;">
				<label class='checked checkbox-inline text-center' style="width:100% !important;"> <div class="gridlable" style="    width: 100%;
				margin-bottom: 12px;">Bussiness Type   </div>
				<input name='pacakageType' type='radio'   class='' value ='1' checked="checked" />  Domestic</label>&nbsp;&nbsp;&nbsp;
				<label class='checked checkbox-inline text-center' style="width:100% !important;">
				<input type='radio' name='pacakageType' value ='2' <?php if($editresult['pacakageType']==2) { echo 'checked' ;}?>    class='' /> Inbound</label>&nbsp;&nbsp;&nbsp;
				<label class='checked checkbox-inline text-center' style="width:100% !important;">
				<input type='radio' name='pacakageType' value ='3' <?php if($editresult['pacakageType']==3) { echo 'checked' ;}?>   class='' /> International</label>
			</div>		</td>
	</tr>
	<tr>
	  <td colspan="3" align="left" valign="top" style="padding-right:20px;"></td>
	  </tr>
	<tr>
		<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
		<td align="left" valign="top" >&nbsp;</td>
		<td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="33%" align="left" valign="top" style="padding-right:20px;">

			<div class="griddiv">
				<label>
					<div class="gridlable">Package Name<span class="redmind"></span>  </div>
					<input name="pacakageName" type="text" class="gridfield validate" id="pacakageName" value="<?php echo stripslashes($editresult['pacakageName']); ?>" displayname="Pacakage Name" maxlength="100" />
				</label>
			</div>
		
			<div class="griddiv">
				<label>
					<div class="gridlable">Package Theme  <span class="redmind"></span>  </div>
					<select name="pacakageTheme[]" size="1" multiple="multiple" class="gridfield select2 " id="	pacakageTheme" displayname="Package Theme" autocomplete="off"   >
						<?php
						$select='';
						$where='';
						$rs='';
						$select='*';
						$where=' deletestatus=0 and status=1 order by name asc';
						$rs=GetPageRecord($select,_PACKAGE_THEME_MASTER_,$where);
						$newdata = explode(',', $editresult['pacakageTheme']);
						while($resListing=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($resListing['id']); ?>"<?php foreach ($newdata as $key => $value) { if($value == $resListing['id']){ echo 'selected="selected"'; } }?>><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
					</select>
				</label>
			</div>
				
		

			<div class="griddiv" style="width:100% !important;">
				<label>
					<div class="gridlable"style="margin-bottom: 10px;"> Website Heading </div>
					<?php
					$tourTypeData = explode(',', $editresult['tourType']);
					?>
					<select name="tourType[]" class="gridfield select2 " allowclewar="true" id="tourType" multiple="multiple">
						<option value="1" <?php foreach ( $tourTypeData as $key => $value ) { if($value == '1'){ echo 'selected="selected"'; } }?> > Tailor Made Package </option>
						<option value="3" <?php foreach ( $tourTypeData as $key => $value ) { if($value == '3'){ echo 'selected="selected"'; } }?> > Holiday Package </option>
						<option value="2" <?php foreach ( $tourTypeData as $key => $value ) { if($value == '2'){ echo 'selected="selected"'; } }?> > Top Mice Destination </option>
						<option value="4" <?php foreach ( $tourTypeData as $key => $value ) { if($value == '4'){ echo 'selected="selected"'; } }?> > India Tour </option>
						<option value="5" <?php foreach ( $tourTypeData as $key => $value ) { if($value == '5'){ echo 'selected="selected"'; } }?> > International Tour </option>
						<option value="6" <?php foreach ( $tourTypeData as $key => $value ) { if($value == '6'){ echo 'selected="selected"'; } }?> > Home Packages </option>
					</select>
				</label>
			</div>
<div class="griddiv" id="startingCity">
				<label>
					<div class="gridlable">Starting City<span class="redmind"></span>  </div>
					<select id="startCity" name="startCity" class="gridfield  select2" displayname="Starting City" autocomplete="off"   >
						<option value="">Select</option>
						<?php
						$select='';
						$where='';
						$rs='';
						$select='*';
						$where=' deletestatus=0 and status=1 order by name asc';
						$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
						while($resListing=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['startCity']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
					</select>
				</label>
			</div>
			<div class="griddiv" style="width:100% !important;">
				<label>
					<div class="gridlable">Package Type<span>&nbsp;</span></div>
					<select name="packageType" size="1" class="gridfield " id="packageType" displayname="Activity Type" allowClear="true" onchange="activityload();">
						<option value="">Select</option>
						<option value="1" <?php if($editresult['packageType'] == 1){ echo 'selected="selected"'; } ?> >
							Activity						</option>
						<option value="2" <?php if($editresult['packageType'] == 2){ echo 'selected="selected"'; } ?> >
							Tour Packages						</option>
						<option value="3" <?php if($editresult['packageType'] == 3){ echo 'selected="selected"'; } ?> >
							Excursions						</option>
					</select>
				</label>
			</div>
			
				

			<script type="text/javascript"> 
				function activityload(){

					var activity = $('#packageType').val();
					
					if(activity=='1'){
					$('#days').val(11);
					}
					if(activity=='2' || activity=='3'){
					$('#activity_duration').val(11);
					}
				
					if(activity=='1'){
						$('#startingCity').hide();
						$('#startCity').hide('validate');
						$('#endCity').hide();
						$('#endCityDiv').text('Destination');
						$('#durationDiv').show();
						$('#daysDiv').hide();
						$('#nightDiv').hide();
						$('#startDateDiv').hide();
						$('#totalDiv').hide();
						$('#currencyDiv').hide();
						$('#flightDiv').hide();
						$('#plusDiv').hide();
						$('#plus1Div').hide();
						$('#visaDiv').hide();
						$('#hotelDiv').hide();
						$('#hotelfieldDiv').hide();
						$('#transferDiv').hide();
						$('#transferfieldDiv').hide();
						$('#sightseeingDiv').hide();
						$('#sightseeingfieldDiv').hide();
						$('#packageDetailDiv').text('Description');
						$('#daywiseDiv').hide();
						$('#daywiseitineraryDiv').hide();
					}else{
						$('#packageDetailDiv').text('Overview');
						$('#durationDiv').hide();
						$('#daysDiv').show();
						$('#nightDiv').show();
						$('#startingCity').show();
						$('#endCity').show();
						$('#endCityDiv').text('End City');
						$('#startDateDiv').show();
						$('#totalDiv').show();
						$('#currencyDiv').show();
						$('#flightDiv').show();
						$('#plusDiv').show();
						$('#plus1Div').show();
						$('#visaDiv').show();
						$('#hotelDiv').show();
						$('#hotelfieldDiv').show();
						$('#transferDiv').show();
						$('#transferfieldDiv').show();
						$('#sightseeingDiv').show();
						$('#sightseeingfieldDiv').show();
						$('#daywiseDiv').show();
						$('#daywiseitineraryDiv').show();
					}
				}
			</script>

			<input name="editId" type="hidden" id="editId" value="<?php echo $_REQUEST['id']; ?>" />
			<input name="page" type="hidden" id="page" value="<?php echo  $_REQUEST['page']; ?>" />
			<input name="records" type="hidden" id="records" value="<?php echo  $_REQUEST['records']; ?>" />
			<input name="action" type="hidden" id="action" value="cmscreatepackagedetail" />		</td>
		<td width="33%" align="left" valign="top" >
			
			<div class="griddiv" style="border-bottom:0px; ">
				<div class="gridlable" style="width:100%;">Places covered<span class="redmind"></span></div>
				<div id="selectOpsPersona">
					<select id="placesCovered" name="placesCovered[]" class="gridfield select2" displayname="Places covered" multiple="multiple" autocomplete="off"   >
						<option value="">Select</option>
						<?php
						$select='';
						$where='';
						$rs='';
						$select='*';
						$where=' deletestatus=0 and status=1 order by name asc';
						$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
						while($resListing=mysqli_fetch_array($rs)){
						$placesCovered = explode(',', $editresult['placesCovered']);
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php foreach($placesCovered as $key => $value){  if($resListing['id']==$value){ ?>selected="selected"<?php } } ?>><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
					</select>
					<input name="newPackageType" type="hidden" id="newPackageType" value="2" />
				</div>
			</div>

			<div class="griddiv" >
				<label style="width: 48%;float: left;">
					<div class="gridlable">Publish Date </div>
					<input name="publishDate" type="date" class="gridfield" id="publishDate" value="<?php if($editresult['publishDate']=='' || $editresult['publishDate']=='0000:00:00'){ echo date('Y-m-d'); } else {  echo date('Y-m-d',$editresult['publishDate']); } ?>" />
				</label>
				<label style="width: 50%;margin-left: 2%;float: left;">
					<div class="gridlable">Expiry Date </div>
					<input name="expiryDate" type="date" class="gridfield" id="expiryDate" value="<?php if($editresult['expiryDate']=='' || $editresult['expiryDate']=='0'){ echo date('Y-m-d'); } else {  echo date('Y-m-d',$editresult['expiryDate']); } ?>" />
				</label>
			</div>

			<div class="griddiv" style="border-bottom:0px;">
				<label>
					<div class="gridlable">Inclusions  <span class="redmind"></span>  </div>
					<select name="inclusions[]" size="1" multiple="multiple" class="gridfield select2 " id="inclusions" displayname="Inclusions" autocomplete="off"   >
						<?php
						$select='';
						$where='';
						$rs='';
						$select='*';
						$where=' deletestatus=0 and status=1 order by name asc';
						$rs=GetPageRecord($select,_PACKAGE_INCLUSION_MASTER_,$where);
						$newdata = explode(',', $editresult['inclusions']);
						while($resListing=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($resListing['id']); ?>"<?php foreach ($newdata as $key => $value) { if($value == $resListing['id']){ echo 'selected="selected"'; } }?>><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
					</select>
				</label>
			</div>

			

			<div class="griddiv">
				<label>
					<div class="gridlable" id="endCityDiv">End City / Destination<span class="redmind"></span>  </div>
					<select id="endCity" name="endCity" class="gridfield validate select2" displayname="End City" autocomplete="off"   >
						<option value="">Select</option>
						<?php
						$select='';
						$where='';
						$rs='';
						$select='*';
						$where=' deletestatus=0 and status=1 order by name asc';
						$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
						while($resListing=mysqli_fetch_array($rs)){
						?>
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresult['endCity']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
						<?php } ?>
					</select>
				</label>
			</div>		<div class="griddiv" style="width:50% !important; float:left;    margin-top: 27px;">
				<label style="overflow: hidden;display: block;">
					<div class="gridlable" style="margin-bottom: 10px;"><input name="viewOnWebsite" type="checkbox" <?php if($editresult['viewOnWebsite']==1){ ?> checked="checked" <?php  } ?> value="1" /> Show on Home </div>
					
				</label>
			</div>

			<div class="griddiv"  style="width:50% !important; float:left;    margin-top: 27px;">
				<label style="overflow: hidden;overflow: hidden;">
					<div class="gridlable" style="margin-bottom: 10px;"><input name="status" type="checkbox" <?php if($editresult['status']==1){ ?> checked="checked" <?php  } ?>  value="1" /> Status</div>
					
				</label>
			</div></td>
		<td width="33%" align="left" valign="top" style="padding-left:20px;">

			<div class="griddiv">
				<label>
					<div class="gridlable">Banner Image</div>
					<input name="packageImage" class="gridfield " type="file" />
					<input name="packageImage2" class="gridfield " type="hidden" value="<?php echo $editresult['uploadPhoto']; ?>" />
				</label>
			</div>

			<?php if($editresult['uploadPhoto']!=''){ ?>
			<div class="griddiv" style="    border-bottom: 0px;
    border-radius: 5px;
    margin-top: 10px;
    border: 0px solid #cccccc4a !important;
    margin:5px;
    box-shadow: 0px 0px 10px #adadad; margin-top:20px; "> 
	 
					<img style="width: 100%; height: 220px;" src="dirfiles/<?php echo $editresult['uploadPhoto']; ?>" /> 
			</div>
			<?php } ?>
			<div class="griddiv" style="border-bottom:0px; display:none;">
				<label class='checked checkbox-inline text-center' style="width:100% !important;"> 
					<div class="gridlable" style="    width: 100%;margin-bottom: 12px;">Upload Image   </div>
					<input name="uploadPhoto" type="file" id="uploadPhoto" />
					<?php if($editresult['uploadPhoto']!=''){ ?>
						<a target="_blank" href="dirfiles/<?php echo $editresult['uploadPhoto']; ?>">Download</a> 
					<?php } ?>
				</label>
				<input name="uploadPhoto2" type="hidden" id="uploadPhoto2" value="<?php echo $editresult['uploadPhoto']; ?>" />
			</div>		</td>
	</tr>
<?php if($_REQUEST['id']!=''){ ?> 
</table>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0">



	
<tr>
<td colspan="3" align="left" valign="top" ><div class="tbheaderm"><i class="fa fa-dollar"></i>&nbsp;&nbsp; Costing</div></td>
</tr>
<tr>
<td colspan="3" align="left" valign="top" style="padding-right:20px;"> <table width="300" border="0" cellpadding="5" cellspacing="0">
<tr><script>
function calculatemaincost(){
var flightCost = Number($('#flightCost').val());
var visaCost = Number($('#visaCost').val());
var landPackage = Number($('#landPackage').val());
var remark = Number($('#remark').val());
var remarkType = Number($('#remarkType').val());
$('#quotationPrice').val(Number(flightCost+visaCost+landPackage));
var quotationPrice = Number($('#quotationPrice').val());
if(remarkType==1){
var quotationPriceremark = Number(quotationPrice*remark/100);
$('#totalPrice').val(Number(quotationPriceremark+quotationPrice));
}

if(remarkType==2){
var quotationPriceremark = Number(quotationPrice+remark);
$('#totalPrice').val(Number(quotationPriceremark));
}
}
</script>
<script>
function calculatenights(){
var days = $('#days').val();
if(days==1){
$('#nights').val('1');
}
if(days>1){
var nights = Number(days-1);
$('#nights').val(nights);
}
if(days=='' || days=='0'){
$('#nights').val('0');
}
}
</script>
<td align="left" valign="top">
	<div class="griddiv" id="daysDiv" style="width: 120px;">
		<label>
			<div class="gridlable">Days<span class="redmind"></span>  </div>
			<input name="days" type="number" class="validate gridfield" id="days" value="<?php if($editresult['days']=='0'){ echo ''; } else { echo stripslashes($editresult['days']); } ?>" maxlength="100" displayname="Days" onkeyup="calculatenights();loadaddedhotelfun();addfundaywiseitenerymain();loadaddedsightseeingfun();" />
		</label>
	</div>
	<div class="griddiv" id="durationDiv" style="width: 120px;">
		<label>
			<div class="gridlable">Duration<span class="redmind"></span>( hours )</div>   
			<input name="activity_duration" id="activity_duration" type="text" class="validate gridfield "  value="<?php if($editresult['duration']=='0'){ echo ''; } else { echo $editresult['duration']; } ?>" displayname="Duration"  />
		</label>
	</div></td>
<td align="left" valign="top">
	<div class="griddiv" id="nightDiv" style="width: 120px; margin-left: 15px;">
		<label>
			<div class="gridlable">Nights<span class="redmind"></span>  </div>
			<input name="nights" type="number" class="gridfield "  id="nights" value="<?php echo stripslashes($editresult['nights']); ?>" maxlength="100" displayname="Nights" readonly="readonly" />
		</label>
	</div></td>
</tr>

</table></td>
</tr>
<tr>
	<td colspan="3" align="left" valign="top" style="padding-right:20px;">
		<table border="0" cellpadding="5" cellspacing="0">
			<tr>
				<td>
					<div class="griddiv" id="currencyDiv" style="width: 120px;">
						<label>
							<select id="currency" name="currency" class="gridfield ">
							<?php
							$select='';
							$where='';
							$rs='';
							$select='*';
							$where='id!="" order by name';
							$rs=GetPageRecord($select,_CURRENCY_MASTER_,$where);
							while($currency=mysqli_fetch_array($rs)){
							?>
							<option value="<?php echo strip($currency['id']); ?>" <?php if($currency['id']==$editresult['currency']){ ?>selected="selected"<?php } ?>><?php echo strip($currency['name']); ?></option>
							<?php } ?>
							</select>
						</label>
					</div>				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>

				<td>
					<label>
						<input name="costType" type="radio" value="1" <?php if($editresult['costType']==1){ ?>checked="checked"<?php } ?> /> Per Person					</label>				</td>
				<td width="48">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td id="totalDiv">
					<label>
						<input name="costType" type="radio" value="2"  <?php if($editresult['costType']==2){ ?>checked="checked"<?php } ?>/>
						Total					</label>				</td>
			</tr>
		</table>	</td>
</tr>
<tr>
<td colspan="3" align="left" valign="top" style="padding-right:20px;"><table width="200" border="0" cellpadding="5" cellspacing="0">
<tr>
<td><div class="griddiv" id="flightDiv"><label>
<div class="gridlable">Flight Cost    </div>
<input name="flightCost" type="number" class="gridfield" id="flightCost" value="<?php echo stripslashes($editresult['flightCost']); ?>" maxlength="100" style="width:120px;" onkeyup="calculatemaincost();" />
</label>
<script>
function calculatemaincost(){
var flightCost = Number($('#flightCost').val());
var visaCost = Number($('#visaCost').val());
var landPackage = Number($('#landPackage').val());
var remark = Number($('#remark').val());
var remarkType = Number($('#remarkType').val());
$('#quotationPrice').val(Number(flightCost+visaCost+landPackage));
var quotationPrice = Number($('#quotationPrice').val());
if(remarkType==1){
var quotationPriceremark = Number(quotationPrice*remark/100);
$('#totalPrice').val(Number(quotationPriceremark+quotationPrice));
}

if(remarkType==2){
var quotationPriceremark = Number(quotationPrice+remark);
$('#totalPrice').val(Number(quotationPriceremark));
}
}
</script>
</div></td>
<td style="font-size:30px;" id="plusDiv">+</td>
<td><div class="griddiv" id="visaDiv"><label>
<div class="gridlable">Visa Cost    </div>
<input name="visaCost" type="number" class="gridfield" id="visaCost" value="<?php echo stripslashes($editresult['visaCost']); ?>" maxlength="100" style="width:120px;"  onkeyup="calculatemaincost();" />
</label>
</div></td>
<td style="font-size:30px;" id="plus1Div">+</td>
<td><div class="griddiv"><label>
<div class="gridlable">Land Package Cost    </div>
<input name="landPackage" type="number" class="validate gridfield" displayname="Land Package Cost" id="landPackage"  value="<?php if($editresult['landPackage']=='0') { echo ''; } else { echo stripslashes($editresult['landPackage']); } ?>" maxlength="100" style="width:120px;"  onkeyup="calculatemaincost();"/>
</label>
</div></td>
<td style="font-size:30px;">=</td>
<td><div class="griddiv"><label>
<div class="gridlable">Quotation Price (Per Person)    </div>
<input name="quotationPrice" type="number" class="gridfield" id="quotationPrice" value="<?php echo stripslashes($editresult['quotationPrice']); ?>" maxlength="100" style="width:180px;" readonly="readonly"  />
</label>
</div></td>
<td colspan="2" align="left" valign="top">
	<div class="griddiv">
		<label>
			<div class="gridlable">Markup</div>
			<input name="remark" type="number" class="gridfield" id="remark" value="<?php echo stripslashes($editresult['remark']); ?>" maxlength="100" style="width:120px;" onkeyup="calculatemaincost();" />
		</label>
	</div></td>
<td width="50" align="left" valign="top">
	<div class="griddiv">
		<label>
			Type
			<select id="remarkType" name="remarkType" class="gridfield "   style="width:110px;" onchange="calculatemaincost();">
				<option value="1" <?php if($editresult['remarkType']==1){ ?>selected="selected"<?php } ?>>%</option>
				<option value="2" <?php if($editresult['remarkType']==2){ ?>selected="selected"<?php } ?>>Flat Rate</option>
			</select>
		</label>
	</div></td>
<td><div class="griddiv"><label>
<div class="gridlable">Total Price     </div>
<input name="totalPrice" type="number" class="gridfield" id="totalPrice" value="<?php echo stripslashes($editresult['totalPrice']); ?>" maxlength="100" style="width:120px;" />
</label>
</div></td>
</tr>

</table></td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>
<?php if($_REQUEST['id']!=''){ ?>
<tr>
<td colspan="3" align="left" valign="top" ><div class="tbheaderm" style="position:relative; overflow:hidden;"> <i class="fa fa-bed"></i>&nbsp;&nbsp; Image Gallery <label style="position: absolute; right: 10px; top: 10px; font-size: 12px;">



</label>
</div><div style="background-color:#f8f8f8; padding:20px; overflow:hidden; margin-bottom:30px;">
<script>
function removepicture(id){
$('#actiondiv').load('frmaction.php?action=packageremovepicture&&parentId=<?php echo decode($_REQUEST['id']); ?>&did='+id);
}

</script>
<?php
$g=1;
$select='';
$where='';
$rs='';
$select='*';
$where=' parentId='.decode($_REQUEST['id']).' and galleryType="Package" order by id desc';
$rs=GetPageRecord($select,_IMAGE_GALLERY_MASTER_,$where);
while($gallery=mysqli_fetch_array($rs)){
?>
<div style="background-color:#FFFFFF;  border-radius: 5px; padding:0px; float:left; margin:10px; overflow:hidden; width:150px; height:90px; position:relative;"><img src="dirfiles/<?php echo $gallery['name']; ?>" style="width:100%;" />
<a style="color:#FF0000 !important;  font-size:12px;" onclick="if(confirm('Are you sure you want delete this Picture?')) removepicture('<?php echo $gallery['id']; ?>');">
<div style="width: 20px;height: 20px;background-color:#FFFFFF;position:absolute;right:2px;bottom:2px;padding: 4px;border-radius: 5px; text-align: center; cursor:pointer;"><i class="fa fa-trash" style="font-size: 18px;color:#FF0000;"></i></div></a></div>

<?php $g++;} ?>
<?php if($g==1){ ?>
<div style="background-color:#FFFFFF; padding:20px; text-align:center; font-size:15px;">No Picture Uploaded<div style="text-align:center; margin-top:10px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Upload Picture" style=" background-color:#45b558 !important; border:#45b558 1px solid !important; margin-left:0px;" onclick="uploadgallery();"></div></div>
<?php } else { ?>
<div style="background-color:#45b558;  color:#fff; cursor:pointer; border-radius: 5px; text-align:center; padding:0px; float:left; margin:10px; overflow:hidden; width:150px; height:90px;" onclick="uploadgallery();"><i class="fa fa-fw fa-plus" style="font-size:55px; margin-top:21px;"></i></div>
<?php } ?>

<script>
function uploadgallery(){
$('#imagename').trigger('click');
}
</script>

</div></td>
</tr>
<?php } ?>
<tr id="hotelDiv">
	<td colspan="3" align="left" valign="top"> 
		<div class="tbheaderm" style="position:relative;">
			<i class="fa fa-bed"></i>
			&nbsp;&nbsp; 
			Hotel Details 
			<label style="position: absolute; right: 10px; top: 10px; font-size: 12px; display:none;">
			<input name="includeHotel" type="checkbox" id="includeHotel" value="1"  />
			&nbsp;Hotels not included</label>
		</div>	</td>
</tr>
<tr>
	<td colspan="3" align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" align="left" valign="top" style="padding-right:20px;">	</td>
</tr>
<tr id="hotelfieldDiv">
	<td colspan="3" align="left" valign="top" style="padding-right:20px;">
		<div id="loadaddedhotel"></div>
		<script>
			function loadaddedhotelfun(){
			var nights = $('#nights').val();
			$('#loadaddedhotel').load('loadaddedhotel.php?nights='+nights+'&packageId=<?php echo $editresult['id']; ?>');
			}
			loadaddedhotelfun();
		</script>	</td>
</tr>
<tr>
	<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
	<td align="left" valign="top" >&nbsp;</td>
	<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>
<tr id="sightseeingDiv">
	<td colspan="3" align="left" valign="top" ><div class="tbheaderm" style="position:relative;"><i class="fa fa-camera-retro"></i>&nbsp;&nbsp; Sighseeing Details 
		<label style="position: absolute; right: 10px; top: 10px; font-size: 12px; display:none;">
	<input name="includeHotel" type="checkbox" id="includeHotel" value="1"  />
&nbsp;Sighseeing not included</label>
</div></td>
</tr>
<tr>
<td colspan="3" align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="left" valign="top" style="padding-right:20px;">	</td>
</tr>
<tr id="sightseeingfieldDiv">
<td colspan="3" align="left" valign="top" style="padding-right:20px;">
<div id="loadaddedsightseeing"></div>

<script>
function loadaddedsightseeingfun(){
var nights = $('#nights').val();
$('#loadaddedsightseeing').load('loadaddedsightseeing.php?nights='+nights+'&packageId=<?php echo $editresult['id']; ?>');
}
loadaddedsightseeingfun();
</script>	</td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>


<tr  id="transferDiv">
<td colspan="3" align="left" valign="top"  ><div class="tbheaderm" style="position:relative;"><i class="fa fa-car"></i>&nbsp;&nbsp; Transfer Details
<label style="position: absolute; right: 10px; top: 10px; font-size: 12px; display:none;">

<input name="cabNotInclude" type="checkbox" id="cabNotInclude" value="1"  />
&nbsp;Cab not included</label>
</div></td>
</tr>
<tr id="transferfieldDiv">
<td colspan="3" align="left" valign="top" ><textarea name="cabDetail" rows="5" id="cabDetail" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo strip($editresult['cabDetail']); ?></textarea></td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>


<tr>
<td colspan="3" align="left" valign="top"  ><div class="tbheaderm" style="position:relative;"><i class="fa fa-eraser"></i>&nbsp;&nbsp; Inclusion / Exclusion

</div></td>
</tr>
<tr>
<td colspan="3" align="left" valign="top" >
<div style="width:840px;">
<table width="100%" border="0" cellpadding="10" cellspacing="0">
<tr>
<td width="50%" bgcolor="#f6fdff"><strong>MEAL PLAN </strong></td>
<td width="25%" align="center" bgcolor="#f6fdff"><strong>Inclusion</strong></td>
<td width="25%" align="center" bgcolor="#f6fdff"><strong>Exclusion</strong></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Breakfast </td>
<td align="center" bgcolor="#f6fdff"><input name='breakfast' type='radio'   class='' value ='1' <?php if($editresult['breakfast']=='1'){ ?>checked="checked"<?php } ?>/></td>
<td align="center" bgcolor="#f6fdff"><input name='breakfast' type='radio'   class='' value ='0' <?php if($editresult['breakfast']=='0'){ ?>checked="checked"<?php } ?>/></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Lunch</td>
<td align="center" bgcolor="#f6fdff"><input name='lunch' type='radio'   class='' value ='1' <?php if($editresult['lunch']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#f6fdff"><input name='lunch' type='radio'   class='' value ='0' <?php if($editresult['lunch']=='0'){ ?>checked="checked"<?php } ?>/></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Dinner</td>
<td align="center" bgcolor="#f6fdff"><input name='dinner' type='radio'   class='' value ='1' <?php if($editresult['dinner']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#f6fdff"><input name='dinner' type='radio'   class='' value ='0' <?php if($editresult['dinner']=='0'){ ?>checked="checked"<?php } ?> /></td>
</tr>
<tr>
<td bgcolor="#FFE8E9"><strong>VISA</strong></td>
<td align="center" bgcolor="#FFE8E9"></td>
<td align="center" bgcolor="#FFE8E9">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFE8E9">Assistance</td>
<td align="center" bgcolor="#FFE8E9"><input name='assistance' type='radio'   class='' value ='1' <?php if($editresult['assistance']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#FFE8E9"><input name='assistance' type='radio'   class='' value ='0' <?php if($editresult['assistance']=='0'){ ?>checked="checked"<?php } ?> /></td>
</tr>
<tr>
<td bgcolor="#FFE8E9">Fees</td>
<td align="center" bgcolor="#FFE8E9"><input name='fees' type='radio'   class='' value ='1' <?php if($editresult['fees']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#FFE8E9"><input name='fees' type='radio'   class='' value ='0' <?php if($editresult['fees']=='0'){ ?>checked="checked"<?php } ?> /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Airfare</td>
<td align="center" bgcolor="#f6fdff"><input name='airfare' type='radio'   class='' value ='1' <?php if($editresult['airfare']=='1'){ ?>checked="checked"<?php } ?>  /></td>
<td align="center" bgcolor="#f6fdff"><input name='airfare' type='radio'   class='' value ='0' <?php if($editresult['airfare']=='0'){ ?>checked="checked"<?php } ?>  /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Government Taxes/VAT/Service Charges</td>
<td align="center" bgcolor="#f6fdff"><input name='taxs' type='radio'   class='' value ='1' <?php if($editresult['taxs']=='1'){ ?>checked="checked"<?php } ?>  /></td>
<td align="center" bgcolor="#f6fdff"><input name='taxs' type='radio'   class='' value ='0' <?php if($editresult['taxs']=='0'){ ?>checked="checked"<?php } ?>  /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Travel Insurance</td>
<td align="center" bgcolor="#f6fdff"><input name='insurance' type='radio'   class='' value ='1' <?php if($editresult['insurance']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#f6fdff"><input name='insurance' type='radio'   class='' value ='0' <?php if($editresult['insurance']=='0'){ ?>checked="checked"<?php } ?> /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Sightseeing</td>
<td align="center" bgcolor="#f6fdff"><input name='sightseeing' type='radio'   class='' value ='1' <?php if($editresult['sightseeing']=='1'){ ?>checked="checked"<?php } ?>  /></td>
<td align="center" bgcolor="#f6fdff"><input name='sightseeing' type='radio'   class='' value ='0' <?php if($editresult['sightseeing']=='0'){ ?>checked="checked"<?php } ?>  /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">
<textarea name="sightseeingTaxt" rows="2" id="sightseeingTaxt" style="width:80%; padding:10px; box-sizing:border-box; border:1px #ccc solid;" placeholder="Write about sightseeing"><?php echo strip($editresult['sightseeingTaxt']); ?></textarea>   </td>
<td align="center" bgcolor="#f6fdff">&nbsp;</td>
<td align="center" bgcolor="#f6fdff">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#f6fdff">Arrival Transfer</td>
<td align="center" bgcolor="#f6fdff"><input name='arrivalTransfer' type='radio'   class='' value ='1'  <?php if($editresult['arrivalTransfer']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#f6fdff"><input name='arrivalTransfer' type='radio'   class='' value ='0'  <?php if($editresult['arrivalTransfer']=='0'){ ?>checked="checked"<?php } ?> /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">Departure Transfer</td>
<td align="center" bgcolor="#f6fdff"><input name='departureTransfer' type='radio'   class='' value ='1'   <?php if($editresult['departureTransfer']=='1'){ ?>checked="checked"<?php } ?> /></td>
<td align="center" bgcolor="#f6fdff"><input name='departureTransfer' type='radio'   class='' value ='0'   <?php if($editresult['departureTransfer']=='0'){ ?>checked="checked"<?php } ?> /></td>
</tr>
<tr>
<td bgcolor="#f6fdff">City tax on hotel </td>
<td align="center" bgcolor="#f6fdff"><input name='cityTax' type='radio'   class='' value ='1' <?php if($editresult['cityTax']=='1'){ ?>checked="checked"<?php } ?>/></td>
<td align="center" bgcolor="#f6fdff"><input name='cityTax' type='radio'   class='' value ='0' <?php if($editresult['cityTax']=='0'){ ?>checked="checked"<?php } ?>/></td>
</tr>
<tr>
<td bgcolor="#f6fdff"><textarea name="citytaxDetails" rows="2" id="citytaxDetails" style="width:80%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"  ><?php echo strip($editresult['citytaxDetails']); ?></textarea></td>
<td align="center" bgcolor="#f6fdff">&nbsp;</td>
<td align="center" bgcolor="#f6fdff">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#f6fdff">Other</td>
<td align="center" bgcolor="#f6fdff"><textarea name="otherInclusion" rows="2" id="otherInclusion" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo strip($editresult['otherInclusion']); ?></textarea></td>
<td align="center" bgcolor="#f6fdff"><textarea name="otherExclusion" rows="2" id="otherExclusion" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo strip($editresult['otherExclusion']); ?></textarea></td>
</tr>
</table>
</div></td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>


<tr id="daywiseDiv">
<td colspan="3" align="left" valign="top"  ><div class="tbheaderm" style="position:relative;"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Day wise itinerary

</div></td>
</tr>
<tr id="daywiseitineraryDiv">
<td colspan="3" align="left" valign="top" id="daywiseitenerymain" >Loading...</td>
<script>
function fundaywiseitenerymain(){
var days = Number($('#days').val());
if(days!=0 && days!=''){
$('#daywiseitenerymain').load('loaddaywiseitenerymain.php?days='+days+'&packageId=<?php echo $editresult['id']; ?>');
}
}

function addfundaywiseitenerymain(){
var days = Number($('#days').val());
if(days!=0 && days!=''){
$('#daywiseitenerymain').load('loaddaywiseitenerymain.php?days='+days+'&packageId=<?php echo $editresult['id']; ?>&action=adddaywise');
}
}

fundaywiseitenerymain();
</script>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>

<tr>
<td colspan="3" align="left" valign="top"  ><div class="tbheaderm" style="position:relative;"><i class="fa fa-briefcase"></i>&nbsp;&nbsp; Miscellaneous

</div></td>
</tr>
<script src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">

	tinymce.init({
		selector: "#flightDetail",
		themes: "modern",
		plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});

	
tinymce.init({
selector: "#termsCondition",
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
selector: "#otherInformation",
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
selector: "#thingsToNotes",
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
selector: "#destinationInfo",
themes: "modern",
plugins: [
"advlist autolink lists link image charmap print preview anchor",
"searchreplace visualblocks code fullscreen"
],
toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<tr>
<td colspan="3" align="left" valign="top"  > <table width="100%" border="0" cellpadding="5" cellspacing="0">
<tr>
	<td width="49%" align="left" valign="top">
		<div style="position:relative; margin-bottom:5px;" id="packageDetailDiv"><i class="fa fa-cube"></i>&nbsp;&nbsp; Overview 
			<label style="position: absolute; right:0px; top:-8px; font-size: 12px; display:none;">
				&nbsp;Use Default T&C			</label>
		</div>
		<script>
		function addterms(){
		$('#termsCondition').val('');
		$('#addtermsdiv').load('addterms.php');
		}
		</script>
		<div style="display:none;" id="addtermsdiv"></div>	</td>
	<td width="2%" align="left" valign="top">&nbsp;</td>
	<td width="49%" align="left" valign="top"><div style="position:relative; margin-bottom:5px;">Cancellation </div></td>
</tr>
<tr>
	<td align="left" valign="top"><textarea name="flightDetail" rows="5" id="flightDetail" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;">
		<?php echo strip($editresult['flightDetail']); ?></textarea></td>
	<td align="left" valign="top">&nbsp; </td>
	<td align="left" valign="top"><textarea name="otherInformation" rows="5" id="otherInformation" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;">
	<?php echo strip($editresult['otherInformation']); ?></textarea></td>
</tr>

</table></td>
</tr>

<tr>
<td colspan="3" align="left" valign="top"  > 
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="49%" align="left" valign="top">
				<div style="position:relative; margin-bottom:5px;">Highlights
					<label style="position: absolute; right:0px; top:-8px; font-size: 12px; display:none;">
					&nbsp;Use Default T&C </label>
				</div>
				<div style="display:none;" id="addtermsdiv"></div>			</td>
			<td width="2%" align="left" valign="top">&nbsp;</td>
			<td width="49%" align="left" valign="top"><div style="position:relative; margin-bottom:5px;">Terms &amp; Condition </div></td>
		</tr>
		<tr>
			<td align="left" valign="top"><textarea name="thingsToNotes" rows="5" id="thingsToNotes" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo strip($editresult['thingsToNotes']); ?></textarea></td>
			<td align="left" valign="top">&nbsp; </td>
			<td align="left" valign="top"><textarea name="termsCondition" rows="5" id="termsCondition" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo strip($editresult['termsCondition']); ?></textarea></td>
		</tr>
	</table></td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">&nbsp;</td>
</tr><?php } ?>
<tr>
<td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
<td align="left" valign="top" >&nbsp;</td>
<td align="right" valign="top" style="padding-left:20px;">
    <div class="griddiv" style="border-bottom:0px;">
        <label class='checked checkbox-inline text-center' style="width:100% !important; text-align:right;"><br />
            <input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save Package" onclick="formValidation('addeditfrm','submitbtn','0');" style="float:right;">
        </label>
    </div></td>
</tr>
</table>
</form>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="imageaddeditfrm" target="actoinfrm" id="imageaddeditfrm" style="display:none;">
<input name="imagename" id="imagename" type="file" accept="image/x-png,image/gif,image/jpeg" onchange="$('#imageaddeditfrm').submit();$('#pageloader').hide();$('#pageloading').hide();" />
<input name="action" id="action" type="hidden" value="uploadgalleryimagepackage" />
<input name="parentId" id="parentId" type="hidden" value="<?php echo decode($_REQUEST['id']); ?>" />
</form>
</div>


</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
$(function () {
$('input').iCheck({
checkboxClass: 'icheckbox_square-blue',
radioClass   : 'iradio_square-blue',
increaseArea : '20%' // optional
})
})
</script>

<script>
$('#maintable .checkall').on('ifChecked', function() {
$('#maintable input[type="checkbox"]').iCheck('check');
});
$('#maintable .checkall').on('ifUnchecked', function() {
$('#maintable input[type="checkbox"]').iCheck('uncheck');
});
// addterms();
</script>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
$(document).ready(function() {
$('.select2').select2();

});

function submitMainForm(){
		$('#addeditfrmb').submit();

}


function fungenratepdf(){
var loadingn=1;
setInterval(function(){
if(loadingn<120){
$('#loadingbarpdf').css('width',loadingn+'%');
loadingn=Number(loadingn+3);
}
}, 1500);
}

function saveCosting(){
$('#addQueryPaymentFrm').submit();
}
<?php if($editresult['termsCondition']==''){ ?>
addterms();
<?php } ?>
</script>
<style>
.markupclass input{padding:10px; width:100%; box-sizing:border-box; border:1px #CCCCCC solid;}
.markupclass select{padding:10px; width:100%; box-sizing:border-box; border:1px #CCCCCC solid;}


</style>
<style>
.sightseeingtransboxgray{    font-size: 12px;
padding: 10px;
background-color: #F7F7F7;
border: 1px solid #ccc;
margin-bottom: 10px;
box-shadow: 1px 1px 5px #ccc;}
	
	
.gridlable{width:100% !important;}
.griddiv{margin-bottom:5px !important;}
.select2-container { width:100% !important;}
/*.griddiv label{
	overflow: hidden;
    position: relative;
}*/
</style>

<script>
$(document).ready(function() {
$('#startDate').Zebra_DatePicker({
format: 'd-m-Y',
});

});

</script>
<?php if($editresult['id']!=''){ ?>
<script>
activityload();
</script>
<?php } } ?>