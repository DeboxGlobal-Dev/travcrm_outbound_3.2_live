

<div class="rightsectionheader" style="margin-top: 48px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="font-weight:500;
    font-size: 20px;"><span id="topheadingmain"> Update <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
            <td style="padding-right:20px;">&nbsp; </td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter">
 
<div class="addeditpagebox" style="padding: 30px;">
    <?php 
    
    $rsvi=GetPageRecord('*','companyVersionInfoSetting','id>0');
    $editresultvi=mysqli_fetch_array($rsvi);
    $editId = $editresultvi['id'];
?>
        	<!-- VERSION INFO -->
		<div style="margin: 20px 0px;" >
			<div style="color: #8a8a8a;margin-bottom: 7px;font-size: 13px;">Version Infomation<span id="vsuccessmessage" style="color: #4CAF50;font-size: 15px;
			margin-left: 68px;display:none;">Version Info Updated Successfully</span></div>
			<div id="developerremark" style="border: 1px solid #eee;padding: 0px;">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#eee">
					<tr>
						<td width="22%"><div class="griddiv">
							<label><div class="gridlable" style="width: 50%;">Version No<span id="validationalertvn" style="color: #ef0505;
								margin-left:12px;display:none;">* &nbsp; Please Enter Developer Name</span></div><input name="versionNo" type="text" class="gridfield " id="versionNo" value="<?php echo $editresultvi['versionNo']; ?>" autocomplete="off"></label>
							</div></td>
							<td width="22%"><div class="griddiv">
								<label>
									<div class="gridlable" style="width: 50%;">Developer Name</div>
									<input name="developerNamev" type="text" class="gridfield " id="developerNamev" value="<?php echo $editresultvi['developerName']; ?>" autocomplete="off">
									
								</label>
							</div></td>
							<td width="22%"><div class="griddiv">
								<label>
									<div class="gridlable" style="width: 50%;">Database Name</div>
									<input name="databaseNamev" type="text" class="gridfield " id="databaseNamev" value="<?php echo $editresultvi['databaseName']; ?>" autocomplete="off">
									
								</label>
							</div></td>
							<td width="22%"><div class="griddiv">
								<label>
									<div class="gridlable" style="width: 50%;">Deployment date</div>
									<input name="dateAdded" type="date" class="gridfield " id="dateAdded" value="<?php echo $editresultvi['dateAdded']; ?>" autocomplete="off">
									<input name="editidv" type="hidden" class="gridfield " id="editidv" value="<?php echo $editresultvi['id']; ?>" >
								</label>
							</div></td>
							<td width="10%" align="center"><input name="addnewuserbtn2" type="button" class="savebutton" id="addnewuserbtn2" value="Save" onclick="addversioninfo('<?php echo $editId; ?>')" style="border-radius: 3px; cursor:pointer;width: 70px;padding: 5px;font-size: 14px;"></td>
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
						$("#loadversioninfo").load('loadCompanyExtraactivuty.php?action=versioninformation&versionNo='+encodeURI(versionNo)+'&developerName='+encodeURI(developerName)+'&databaseName='+encodeURI(databaseName)+'&dateAdded='+encodeURI(dateAdded)+'&id='+id+'&editid='+editid);
					}else{
					$('#validationalertvn').show();
					}
					
				}
				
				function loadalldevelopers(){
				$("#developerremarklist").load('loadalldevelopers.php');
				}
				</script>
					<!-- started Module enable and disable sec  -->
					<div style="position:relative;height:300px;overflow-y: auto;background: #f3f3f3;margin: 20px auto;border: 2px dashed #ccc;width: 495px;border-radius: 5px;">
					<ul><li onclick="showModuleLIst();" style="font-weight: 600; font-size: 14px; color: #fff; background: #7a96ff;" class="moduleBox">Module Selection <i style="float: right;font-size: 18px;" class="fa fa-angle-down" aria-hidden="true"></i> </li>
				</ul>
				
					
					<div id="moduleDisableList" style="position: absolute;top: 50px; padding-bottom: 30px;"></div>
		
				</div>
			<!-- Ended Module enable and disable sec  -->



					


				<!-- started Proposal enable and disable sec  -->
				<div style="position:relative;height:300px;overflow-y: auto;background: #f3f3f3;margin: 20px auto;border: 2px dashed #ccc;width: 495px;border-radius: 5px;">
							<ul>
								<li onclick="showProposalLIst();" style="font-weight: 600; font-size: 14px; color: #fff; background: #7a96ff;" class="moduleBox">Proposal Selection <i style="float: right;font-size: 18px;" class="fa fa-angle-down" aria-hidden="true"></i> 
								</li>
							</ul>
							<div id="proposalDisableList" style="position: absolute;top: 50px; padding-bottom: 30px;"></div>
					</div>
					<!-- Ended Proposal enable and disable sec  -->
				
		</div>
		

</div>
</div>
<script>
// Started  Module enable and disable sec js

	function selectModuleList(moduleId,url){

		let moduleName = $(`#moduleName${moduleId}`).is(":checked");
		var moduleStatus = '';
		if(moduleName==true){
			moduleStatus = 1;
		}else{
			 moduleStatus = 0;
		}
		$("#moduleDisableList").load(`searchaction.php?action=moduleListToDisable&moduleId=${moduleId}&moduleStatus=${moduleStatus}&module=${url}`);
	}

	selectModuleList();

	function hideOffbtn(moduleId,status,url){
		$("#moduleDisableList").load(`searchaction.php?action=moduleListToDisable&moduleId=${moduleId}&moduleStatus=${status}&enableStatus=yes&module=${url}`);
	}

	function hideOnbtn(moduleId,status,url){

		$("#moduleDisableList").load(`searchaction.php?action=moduleListToDisable&moduleId=${moduleId}&moduleStatus=${status}&disableStatus=yes&module=${url}`);
	}
// Ended  Module enable and disable sec js







// Started  Proposal enable and disable sec js
function selectProposalList(moduleId){

let proposalNum = $(`#proposalNum${moduleId}`).is(":checked");
var moduleStatus = '';
if(proposalNum==true){
	moduleStatus = 1;
}else{
	 moduleStatus = 0;
}
	$("#proposalDisableList").load(`searchaction.php?action=proposalListToDisable&id=${moduleId}&moduleStatus=${moduleStatus}`);
}

selectProposalList();

function proposalhideOffbtn(moduleId,status){
	$("#proposalDisableList").load(`searchaction.php?action=proposalListToDisable&id=${moduleId}&moduleStatus=${status}&enableStatus=yes`);
}

function proposalhideOnbtn(moduleId,status){

	$("#proposalDisableList").load(`searchaction.php?action=proposalListToDisable&id=${moduleId}&moduleStatus=${status}&disableStatus=yes`);
}
// Ended  Proposal enable and disable sec j



</script>
<style>
	.moduleNames{
		padding: 8px;
		border-bottom: 1px solid #ccc;
		 width: 387px;
		 border-left: 1px solid #ccc;
		 background: #fff;
		 z-index: 99999;
	}
	.checkedModule{
		display: inline-block !important;
		float: right;
		cursor: pointer;
	}
	.moduleSelection{
		height: 300px;
		overflow-y: scroll;
   		width: 412px;
		list-style: none;
		position: absolute;
   		top: 50px;
		display: none;
		z-index: 99999;
		background: #f3f3f3;
		margin-top: 0px;
		box-shadow: 1px 3px 2px 0px #ccc;
	}
	.moduleBox{
	border: 1px solid #ccc;
    padding: 10px;
    list-style: none;
	width: 390px;
	background: #fff;
	cursor: pointer;
	}

	.moduleList{
		padding: 8px;
		border-bottom: 1px solid #ccc;
		 width: 394px;
		 border-left: 1px solid #ccc;
		 border-right: 1px solid #ccc;
		 background: #fbfbfb;
		 list-style: none;
		 cursor: pointer;
		 /* font-weight: 500; */
	
	
	}


	.proposalList{
		padding: 8px;
		border-bottom: 1px solid #ccc;
		width: 394px;
		border-left: 1px solid #ccc;
		border-right: 1px solid #ccc;
		background: #fbfbfb;
		list-style: none;
		cursor: pointer;
		/* font-weight: 500; */
	}

	.onbutton{
	float: right;
    color: green;
    font-size: 22px;
	display: inline-block;
	}

	.offbutton{
	float: right;
    color: #939393;
    font-size: 22px;
	display: inline-block;
	}
</style>