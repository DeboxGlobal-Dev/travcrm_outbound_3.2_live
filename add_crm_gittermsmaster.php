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
$where1='id='.$lastId.''; 
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
<script src="bower_components/PACE/pace.min.js"></script>
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
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
	 <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td> 
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
        
          <?php echo $pageName; ?> </span></div></td>
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
<div class="addeditpagebox" style="padding: 30px">
  <input name="action" type="hidden" id="action" value="editgitterms" />
  <input name="Ttype" type="hidden" id="Ttype" value="GIT" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  
		
		<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Inclusion</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermsinclusionlanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
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
			</div>				<div style="padding:10px; overflow:hidden;">
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
			</div>				<div style="padding:10px; overflow:hidden;">
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
		<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Cancellation Policy</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermscancellanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>				<div style="padding:10px; overflow:hidden;">
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

<!-- payment policy started  -->
<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Payment Policy</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermspaymentpolicylanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>				<div style="padding:10px; overflow:hidden;">
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
<!-- payment policy ended -->

<!-- Remarks started -->
<div style="margin-bottom:10px; border:1px #0099CC solid;">
<div style="background-color:#0099CC; color:#fff; font-weight:bold; padding:10px;display: grid;grid-template-columns: auto auto;">
				<div>Remarks</div> 
<div style="text-align: end"><input name="addnewuserbtn" type="button" class="bluembutton" style="background:white!important;color: black!important;" id="addnewuserbtn" value="View Language" onclick="masters_alertspopupopen('action=fittermremarkslanguage&id=<?php echo $_GET['id']; ?>','800px','auto');"></div>
			</div>				<div style="padding:10px; overflow:hidden;">
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
<!-- Remarks ended -->

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