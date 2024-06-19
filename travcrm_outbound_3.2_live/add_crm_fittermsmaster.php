<?php
if($addpermission!=1 && $_GET['id']==''){
	header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_GET['id']!=''){
	header('location:'.$fullurl.'');
}
$lastId=clean(decode($_GET['id']));
$select1='*';  
$where1='id="'.$lastId.'"'; 
$rs1=GetPageRecord($select1,_PACKAGE_TERMS_CONDITIONS_MASTER,$where1); 
if(mysqli_num_rows($rs1)==0){
	deleteRecord(_PACKAGE_TERMS_CONDITIONS_MASTER,' 1 and fit_git="'.$_GET['type'].'" and termsType=1');

  $dateAdded=time();
  $namevalue ='id="'.$lastId.'",termsType=1,fit_git="'.$_GET['type'].'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
  $lastId = addlistinggetlastid(_PACKAGE_TERMS_CONDITIONS_MASTER,$namevalue);
}


$select1='*';  
$where1='id="'.$lastId.'"'; 
$rs1=GetPageRecord($select1,_PACKAGE_TERMS_CONDITIONS_MASTER,$where1); 
$editresult=mysqli_fetch_array($rs1);

$inclusion=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['inclusion'])))));
$exclusion=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['exclusion'])))));
$termscondition=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['termscondition'])))));
$cancelation=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['cancelation'])))));
$paymentpolicy=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['paymentpolicy'])))));
$remarks=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['remarks'])))));
$travelbasic=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['travelbasic'])))));
$booking=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['booking'])))));
$whyuse=str_replace('&nbsp;',' ',(stripslashes(preg_replace('/\\\\/', '',clean($editresult['whyuse'])))));
   
$editqueryStatus=clean($editresult['queryStatus']);
$lastId=$editresult['id'];
$termsType=$editresult['termsType'];

?>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap4.css">
<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="plugins/pace/pace.min.css">
<script src="plugins/pace/pace.min.js"></script>
<script src="js/validation.js"></script>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!-- <script src="tinymce/tinymce.min.js"></script> -->
<style>
.topnavtab{ margin-bottom:0px; overflow:hidden; border-bottom:2px solid #ffc115;}
.topnavtab a{float:left; padding:10px 20px; font-size:16px; color:#FFFFFF; margin-right:10px; background-color:#333333; text-decoration:none; font-weight:600;}
.topnavtab .active{background-color:#ffc115;}
.contentboxiti{padding:20px; background-color:#FFFFFF; border:1px #CCCCCC solid; border-top:0px;}
</style>
<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    // tinymce.init({

    //     selector: "#description",

    //     themes: "modern",   

    //     plugins: [

    //         "advlist autolink lists link image charmap print preview anchor",

    //         "searchreplace visualblocks code fullscreen" 

    //     ],

    //     toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    // });

    </script>
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	 <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td>
      <td ><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
        
          <!-- <?php echo $pageName; ?>  -->
		  <h5>Proposal Contact Detail</h5>
		
		</span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
            
            <td style="padding-right:20px;">

<!-- <input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /> -->


</td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;margin-top: -20px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
<div class="addeditpagebox" style="padding: 30px;">
  <input name="action" type="hidden" id="action" value="editfitterms" />
  <input name="Ttype" type="hidden" id="Ttype" value="FIT" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  
		

  <div class="hide-forfit" style="display: none;">
		<div style="margin-bottom:10px; border:1px #0099CC solid;">
			<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Inclusion</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" 
	onclick="masters_alertspopupopen('action=fittermsinclusionlanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>
			<div style="padding:10px; overflow:hidden;">
				<div class="griddiv">
					<label>
						<div class="gridlable"></div>
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
						<textarea name="inclusion" class="gridfield" id="inclusion"  ><?php echo $inclusion; ?></textarea>
					</label>
				</div>
			</div>
		</div>
		<div style="margin-bottom:10px; border:1px #0099CC solid;">
			<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Exclusion</div> 
				<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermsexclusionlanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>
			<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
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
							<textarea name="exclusion" class="gridfield" id="exclusion"  ><?php echo $exclusion; ?></textarea>
						</label>
					</div>
			</div>
		</div>
		<div style="margin-bottom:10px; border:1px #0099CC solid;">
			<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Terms & Conditions</div> 
				<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermscondlanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>
			<div style="padding:10px; overflow:hidden;">
		 		<div class="griddiv">
					<label>
						<div class="gridlable"></div>
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
						<textarea name="termscondition" class="gridfield" id="termscondition"  ><?php echo $termscondition; ?></textarea>
					</label>
				</div>
			</div>
	</div>

<!-- started for cancelation  -->
<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
<div>Cancellation</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermscancellanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>
				<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
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
							<textarea name="cancelation" class="gridfield" id="cancelation"  ><?php echo $cancelation; ?></textarea>
						</label>
					</div>
			</div>
</div>

<!-- ended for cancelation  -->


<!-- started for Payment Policy  -->
<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
<div>Payment Policy</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=paymentpolicylanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>
				<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
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
							<textarea name="paymentpolicy" class="gridfield" id="paymentpolicy"  ><?php echo $paymentpolicy; ?></textarea>
						</label>
					</div>
			</div>
</div>

<!-- ended for Payment Policy  -->

<!-- started for remarks  -->
<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
<div>Remarks</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=remarkslanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>
				<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
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
							
								</script>
							<textarea name="remarks" class="gridfield" id="remarks"  ><?php echo $remarks; ?></textarea>
						</label>
					</div>
			</div>
</div>


</div>
<!-- kkkkkkkkkkk -->
<!-- ended for remarks  -->


<br>
			<style>
				#showEmergencyName{
					padding: 10px 23px;
					color: #5b9d50;
					font-size: 24px;
					font-family: raleway;
					font-weight: 600;
					margin-bottom: 15px;
				}
				#emerg_Detail{
					width: 50%;
    				display: inline-block;
					padding-right: 20px;
				}
				.emergencyDetailCancel,
				.emergencyDetailSave{
					display: inline-block;
					font-size: 15px;
					border: 1px solid #233a49;
					border-radius: 5px;
					padding: 5px 7px;
					background-color: #233a49;
					color: #f8f8f8;
					cursor: pointer;
				}
				.emergencyDetailCancel{
					background-color: red;
    				border: 1px solid #ff0000;
				}
				#editEmergencyDetail{
					margin-left: 20px;
					margin-bottom: 40px;
					display: none;
				}

				.editemdetail{
					width: 40%;
    				padding: 5px;
					margin-right: 60px;
				}
				#contactForm{
					margin-left: 20px;
				}
				.headingName{
					font-size: 15px;
					font-weight: 500;
					padding-bottom: 8px;
				}
				.gridBox{
					padding: 10px;
				}
				.inputBox{
					padding: 6px;
   					 width: 25%;
				}
			</style>					
		<div id="showEmergencyName" >
			<div id="emerg_Detail"><?php if($editresult['emergencyHeading']!=''){ echo 'Proposal Contact Detail'; }else{ echo 'Proposal Contact Detail'; } ?></div><span style="display: none;" class="fa fa-pencil" onclick="$('#editEmergencyDetail').show();$('#showEmergencyName').hide();" style="border: 1px solid;border-radius: 4px;padding: 2px 5px;cursor:pointer;"></span>
			<span id="addcontactD" style="float: right;cursor:pointer;" onclick="$('#contactForm').show();$('#contdetailTableDiv').hide();$('#addcontactD').hide();$('#showContactD').show();">Add/Edit Information</span>
			<span id="showContactD" style="float: right;cursor:pointer;display:none;" onclick="$('#contactForm').hide();$('#contdetailTableDiv').show();$('#addcontactD').show();$('#showContactD').hide();" >Show Information</span>
		</div>
		<!-- style="display:none;" -->
		<div id="editEmergencyDetail">
		<input type="text" name="emergencyDetail" id="emergencyDetail" class="editemdetail" value="<?php if($editresult['emergencyHeading']!=''){ echo $editresult['emergencyHeading']; }else{ echo 'Proposal Contact Detail'; } ?>">
		<div class="emergencyDetailSave" onClick="saveEmergencyDetail();">save</div>
		<div class="emergencyDetailCancel" onClick="$('#showEmergencyName').show();$('#editEmergencyDetail').hide();">Cancel</div>
		</div>
		
		<!-- <td style="border: 1px solid #e0e0e0;padding: 6px;font-size: 15px;"><input type="checkbox" <?php if($editresult['internationalQuery']==1){ ?> checked <?php } ?> name="international" id="international" value="1" style="display: inline-block;"> <span style="position: relative;top: -2px;">International</span></td> -->


		<div id="contactForm" style="display: none;">
		<div style="display: flex; justify-content: right; position: relative;left: -28px;">
		<input <?php if($editresult['contactdddttl']==1){ ?> checked <?php } ?> type="checkbox" id="contactdddttl" name="contactdddttl" value="1" >
		<h2 style="font-size: 18px; margin-bottom: 15px;color: #4d4d5d;font-weight: 400;font-family: raleway;">Show In Proposal</h2>	
		
		</div>
		<div class="cntdlt" style="display: grid;
    grid-template-columns: auto auto;
    grid-gap: 0px;
    height: 150px;">
			<div class="gridBox" style="width: 50%;">
			<div class="headingName">Contact Person Name</div>
				<div class="inputClass">
					<input  style="width: 100%;" type="text" name="contactPerson" id="contactPerson" value="<?php echo $editresult['contactPerson']; ?>" class="inputBox">
				</div>
			</div>
		
			
			
			
			<div class="gridBox" style="width: 40%;">

			<div class="headingName">Country Code 
				<span style="position: relative;left: 38%;">Mobile No.</span></div>
				<div class="inputClass" style="display: flex">

					<!-- country code related code  started-->
					<?php 
					$rsn="";
					$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
					$cmpcountryData=mysqli_fetch_array($rs1cmp);
					$compcountryCode = $cmpcountryData['compcountryCode'];
					?>


					<input style="width: 26%;" type="text" name="countryCode" id="countryCode" value="<?php if($editresult['countryCode'] !=''){ echo $editresult['countryCode']; }else{ echo '+'. $compcountryCode;}  ?>" class="inputBox" placeholder="+91" min="1" max="5">
					<!--country code related code ended -->

					<input style="width: 53%;position: relative;left: 40%;" type="text" name="phoneNo" id="phoneNo" value="<?php echo $editresult['phone']; ?>" class="inputBox">
				</div>
			</div>

			<div class="gridBox" style="width: 50%;">
			<div class="headingName">Email ID</div>
				<div class="inputClass">
					<input style="width: 100%;" type="text" name="emailId" id="emailId" value="<?php echo $editresult['email']; ?>" class="inputBox">
				</div>
			</div>
			<div class="gridBox" style="width: 50%;">
			<div class="headingName">Available On</div>
				<div class="inputClass">
					<input style="width: 100%;" type="text" name="availableOn" id="availableOn" value="<?php echo $editresult['availableOn']; ?>" class="inputBox">
				</div>
			</div>
		</div>



			<!-- social media links sec started input  -->
			<style>
				.inputBox1{
					padding: 6px;
    				width: 90%;
				}
				.socialtestsec{
					background: #c9c3c3;
				}
			</style>

			
			<h2 style="font-size: 27px;
    margin-bottom: 15px;
    color: #5b9d50;
    font-weight: 600;font-family: raleway;margin-top: 10px;">Social Media Links </h2>

	<div style="display: flex; justify-content: right; position: relative;left: -28px;top: -30px;">
		<input <?php if($editresult['socialmediadtlshow']==1){ ?> checked <?php } ?> type="checkbox" id="socialmediadtlshow" name="socialmediadtlshow" value="1">
		<h2 style="font-size: 18px; margin-bottom: 15px;color: #4d4d5d;font-weight: 400;font-family: raleway;">Show In Proposal</h2>	
		
		</div>
			<div class="socialtestsec" style="display: grid;grid-template-columns: auto auto auto;grid-gap: 2px;height: 420px;position: relative; top: -30px;">
				<div class="gridBox">
				<div class="headingName">Name</div>
					<div class="inputClass">
						<input type="text" name="facename" id="facename" value="Facebook" placeholder="Facebook" class="inputBox1" readonly>
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Logo</div>
					<div class="inputClass" style="border: 1px solid #524a4a;background: white;">
						<input type="file" name="facelogo" id="facelogo" value="<?php echo $editresult['facelogo']; ?>" class="inputBox1">
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">URL</div>
					<div class="inputClass">
						<input type="text" name="faceurl" id="faceurl" value="<?php echo $editresult['faceurl']; ?>" class="inputBox1">
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Name</div>
					<div class="inputClass">
						<input type="text" name="twittername" id="twittername" value="Twitter" class="inputBox1" placeholder="Twitter"  readonly>
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Logo</div>
					<div class="inputClass" style="border: 1px solid #524a4a;background: white;">
						<input type="file" name="twitterlogo" id="twitterlogo" value="<?php echo $editresult['twitterlogo']; ?>" class="inputBox1" >
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">URL</div>
					<div class="inputClass">
					
						<input type="text" name="twitterurl" id="twitterurl" value="<?php echo $editresult['twitterurl']; ?>" class="inputBox1" >
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Name</div>
					<div class="inputClass">
						<input type="text" name="instaname" id="instaname" value="Instagram" class="inputBox1" placeholder="Instagram"  readonly>
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Logo</div>
					<div class="inputClass" style="border: 1px solid #524a4a;background: white;">
						<input type="file" name="instalogo" id="instalogo" value="<?php echo $editresult['instalogo']; ?>" class="inputBox1">
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">URL</div>
					<div class="inputClass">
						<input type="text" name="instaurl" id="instaurl" value="<?php echo $editresult['instaurl']; ?>" class="inputBox1">
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Name</div>
					<div class="inputClass">
						<input type="text" name="linkname" id="linkname" value="Linkdin" class="inputBox1" placeholder="Linkdin"  readonly>
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Logo</div>
					<div class="inputClass" style="border: 1px solid #524a4a;background: white;">
						<input type="file" name="linklogo" id="linklogo" value="<?php echo $editresult['linklogo']; ?>" class="inputBox1">
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">URL</div>
					<div class="inputClass">
						<input type="text" name="linkurl" id="linkurl" value="<?php echo $editresult['linkurl']; ?>" class="inputBox1">
					</div>
				</div>

				<!-- Started youtube sec -->
				<div class="gridBox">
				<div class="headingName">Name</div>
					<div class="inputClass">
						<input type="text" name="youtubename" id="youtubename" value="Youtube" class="inputBox1" placeholder="Youtube"  readonly>
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">Logo</div>
					<div class="inputClass" style="border: 1px solid #524a4a;background: white;">
						<input type="file" name="youtubelogo" id="youtubelogo" value="<?php echo $editresult['youtubelogo']; ?>" class="inputBox1">
					</div>
				</div>
				<div class="gridBox">
				<div class="headingName">URL</div>
					<div class="inputClass">
						<input type="text" name="youtubeurl" id="youtubeurl" value="<?php echo $editresult['youtubeurl']; ?>" class="inputBox1">
					</div>
				</div>
				<!-- ended youtube sec -->
			</div>

			

			<!-- social media links sec ended input -->
		</div>
	<div id="contdetailTableDiv">
	<table width="95%" border="1" align="center" cellpadding="10" cellspacing="0">
		<tr style="position: relative;color:#333; background-color:#F0F0F0;">
		<th align="center">Contact Name</th>
		<th align="center">Country Code</th>
		<th align="center">Mobile Number</th>
		<th align="center">Email Id</th>
		<th align="center">Available On</th>
		<!-- <th align="center"></th> -->
		</tr>
		
		<?php
		 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
		while($emData = mysqli_fetch_assoc($rsem)){
		
		?>
		<tr>
			<td align="center"><?php echo $emData['contactPerson']; ?></td>
			<td align="center"><?php echo $emData['countryCode']; ?></td>
			<td align="center"><?php echo $emData['phone']; ?></td>
			<td align="center"><?php echo $emData['email']; ?></td>
			<td align="center"><?php echo $emData['availableOn']; ?></td>
		</tr>
		<?php } ?>
	</table>



	<br>

	<!-- social media links show sec started -->
	<!-- facelogo,faceurl,twitterlogo,twitterurl,instalogo,instaurl,linklogo,linkurl,facename,twittername,instaname,linkname -->

	
			<h2 style="font-size: 27px;
    margin-bottom: 15px;
    color: #5b9d50;
    font-weight: 600;font-family: raleway;    margin-left: 30px;">Social Media Links </h2>

	<table width="95%" border="1" align="center" cellpadding="10" cellspacing="0">
		<tr style="position: relative;color:#333; background-color:#F0F0F0;">
		<th style="width: 20%;" align="center">Name</th>
		<th style="width: 40%;" align="center">Logo</th>
		<th style="width: 40%;" align="center">URL</th>

		</tr>
		
		<?php
		 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
		while($emData = mysqli_fetch_assoc($rsem)){
		
		?>
		<tr>
		
			<td align="center"><?php echo $emData['facename']; ?></td>



			<td align="center">

				
			<?php if($emData['facelogo']!=''){ ?><img src="dirfiles/<?php echo $emData['facelogo']; ?>" width="75" height="58" /><?php } ?>


				<!-- <?php echo $emData['facelogo']; ?> -->
		
			</td>
			<td align="center"><?php echo $emData['faceurl']; ?></td>
		</tr>
		<?php } ?>
	</table>
	<br>
	<table width="95%" border="1" align="center" cellpadding="10" cellspacing="0">
		<tr style="position: relative;color:#333; background-color:#F0F0F0;">
		<th style="width: 20%;" align="center">Name</th>
		<th style="width: 40%;" align="center">Logo</th>
		<th style="width: 40%;" align="center">URL</th>
		</tr>
		
		<?php
		 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
		while($emData = mysqli_fetch_assoc($rsem)){
		
		?>
		<tr>
			
			<td align="center"><?php echo $emData['twittername']; ?></td>
			<td align="center">
				
			<?php if($emData['twitterlogo']!=''){ ?><img src="dirfiles/<?php echo $emData['twitterlogo']; ?>" width="75" height="58" /><?php } ?>

				<!-- <?php echo $emData['twitterlogo']; ?> -->
			</td>
			<td align="center"><?php echo $emData['twitterurl']; ?></td>

		</tr>
		<?php } ?>
	</table><br>
	<table width="95%" border="1" align="center" cellpadding="10" cellspacing="0">
		<tr style="position: relative;color:#333; background-color:#F0F0F0;">
		<th style="width: 20%;" align="center">Name</th>
		<th style="width: 40%;" align="center">Logo</th>
		<th style="width: 40%;" align="center">URL</th>
		</tr>
		
		<?php
		 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
		while($emData = mysqli_fetch_assoc($rsem)){
		
		?>
		<tr>
		
			<td align="center"><?php echo $emData['instaname']; ?></td>

			<td align="center">
				
			<?php if($emData['instalogo']!=''){ ?><img src="dirfiles/<?php echo $emData['instalogo']; ?>" width="75" height="58" /><?php } ?>

				<!-- <?php echo $emData['instalogo']; ?> -->
			</td>
			<td align="center"><?php echo $emData['instaurl']; ?></td>
		</tr>
		<?php } ?>
	</table><br>
	<table width="95%" border="1" align="center" cellpadding="10" cellspacing="0">
		<tr style="position: relative;color:#333; background-color:#F0F0F0;">
		<th style="width: 20%;" align="center">Name</th>
		<th style="width: 40%;" align="center">Logo</th>
		<th style="width: 40%;"align="center">URL</th>
		</tr>
		
		<?php
		 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
		while($emData = mysqli_fetch_assoc($rsem)){
		
		?>
		<tr>
		
			<td align="center"><?php echo $emData['linkname']; ?></td>


			<td align="center">
				<?php if($emData['linklogo']!=''){ ?><img src="dirfiles/<?php echo $emData['linklogo']; ?>" width="75" height="58" /><?php } ?>

				<!-- <?php echo $emData['linklogo']; ?> -->
			</td>
			<td align="center"><?php echo $emData['linkurl']; ?></td>
		</tr>

		<?php } ?>
	</table><br>
	<table width="95%" border="1" align="center" cellpadding="10" cellspacing="0">
		<tr style="position: relative;color:#333; background-color:#F0F0F0;">
		<th style="width: 20%;" align="center">Name</th>
		<th style="width: 40%;" align="center">Logo</th>
		<th style="width: 40%;"align="center">URL</th>
		</tr>
		
		<?php
		 $rsem = GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'contactPerson!=""');
		while($emData = mysqli_fetch_assoc($rsem)){
		
		?>
		<tr>
		
			<td align="center"><?php echo $emData['youtubename']; ?></td>


			<td align="center">
				<?php if($emData['youtubelogo']!=''){ ?><img src="dirfiles/<?php echo $emData['youtubelogo']; ?>" width="75" height="58" /><?php } ?>

				<!-- <?php echo $emData['youtubelogo']; ?> -->
			</td>
			<td align="center"><?php echo $emData['youtubeurl']; ?></td>
		</tr>

		<?php } ?>
	</table>
		<!-- social media links show sec ended -->
		
	</div>
		<script>
			function saveEmergencyDetail(){

				var emergencyDetail = $("#emergencyDetail").val();
				$("#emerg_Detail").load('final_frmaction.php?action=emergencyHeadingDetail&headingName='+encodeURI(emergencyDetail));
				$("#showEmergencyName").show();
				$("#editEmergencyDetail").hide();
			}

		</script>

		<div style="margin-bottom:10px; border:1px #0099CC solid;display:none;">
			<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;">Travel Basics</div>
				<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
							<script type="text/javascript">
							
								tinymce.init({
							
									selector: "#travelbasic",
							
									themes: "modern",   
							
									plugins: [
							
										"advlist autolink lists link image charmap print preview anchor",
							
										"searchreplace visualblocks code fullscreen" 
							
									],
							
									toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
							
								});
							
								</script>
							<textarea name="travelbasic" class="gridfield" id="travelbasic"  ><?php echo $travelbasic; ?></textarea>
						</label>
					</div>
				</div>
		</div>
		<div style="margin-bottom:10px; border:1px #0099CC solid;display:none; .....\\\\\\\\\\\\\\\\\\\\\//'';;;;;;;;;;;;;;;;;;;;;;;;;;;;;[]]\\]\]  ">
			<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;">Booking Terms</div>
				<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
							<script type="text/javascript">
							
								tinymce.init({
							
									selector: "#booking",
							
									themes: "modern",   
							
									plugins: [
							
										"advlist autolink lists link image charmap print preview anchor",
							
										"searchreplace visualblocks code fullscreen" 
							
									],
							
									toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
							
								});
							
								</script>
							<textarea name="booking" class="gridfield" id="booking"  ><?php echo $booking; ?></textarea>
						</label>
					</div>
				</div>
		</div>
		<div style="margin-bottom:10px; border:1px #0099CC solid;display:none;">
			<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;">Why use Us</div>
				<div style="padding:10px; overflow:hidden;">
			 		<div class="griddiv">
						<label>
							<div class="gridlable"></div>
							<script type="text/javascript">
							
								tinymce.init({
							
									selector: "#whyuse",
							
									themes: "modern",   
							
									plugins: [
							
										"advlist autolink lists link image charmap print preview anchor",
							
										"searchreplace visualblocks code fullscreen" 
							
									],
							
									toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
							
								});
							
								</script>
							<textarea name="whyuse" class="gridfield" id="whyuse"  ><?php echo $whyuse; ?></textarea>
						</label>
					</div>
				</div>
		</div>
</div>
<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> 
		<input name="editId" type="hidden" id="editId" value="<?php  echo encode($lastId);  ?>" />
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
        <td style="padding-right:20px;">
<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
</td>
      </tr>
    </table>
	</td>
  </tr>
  
</table>
</div>
</form>
 
</div>

<!-- alertnotificationsmainbox --> 
<!--  <div id="alertnotificationsmainbox" style="display:none; background-image:url(images/bgpop.png); background-repeat:repeat;">
 <div id="alertswhitebox"> 
 </div> 
 </div> -->



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
</script>
<script src="plugins/select2/select2.full.min.js"></script>

<script>
  $(document).ready(function() {
  $('.select2').select2();
   
  });
  
   
</script>