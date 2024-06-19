	<?php
	include "inc.php"; 
	include "config/logincheck.php"; 
	 
	?>
	<!-- tinymce text editor -->
	 
	<style type="text/css">
		#alertnotificationsmainbox .contentclass {
			padding: 0px;
			text-align: center;
		}
		#alertnotificationsmainbox #alertswhitebox #contentbox { 
			padding:15px;
			padding-bottom: 5px;
			border-bottom: 1px solid #ccc;
		} 
		#alertnotificationsmainbox #alertswhitebox h1 {
 			padding: 15px;
			background-color: #233a49;
			color: #fff;
		    border: 1px solid #ddd;
		    border-radius: 5px 5px 0 0;
		}
		#alertnotificationsmainbox #buttonsbox {
			overflow: hidden;
			padding: 10px; 
		}
		
		.upload_quotBanner, .bluembutton {
			background-color: #233a49!important;
			border: 1px solid #233a49!important;
			border-bottom: 2px solid #9bbb18!important;
    		padding: 8px 15px!important;
			border-radius: 22px!important;
		}
		 
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
		
		.leftDiv50,.rightDiv50,.ckLeftDiv50,.ckRightDiv50{
			width: 47%;padding: 1%; float:left; padding-top: 2%;box-shadow: 0px 0px 2px 0px #ccc;display: inline-block;overflow: visible!important;
		} 
		.leftDiv50{
			margin-right: 1%; 
		}
		.rightDiv50{
			margin-left: 1%; 
		}
		.ckLeftDiv50{
			margin-right: 1%; 
		    padding: 3% 1%;
		}
		.ckRightDiv50{
			margin-left: 1%; 
		    padding: 3% 1%;
		}
		
		.leftDiv100,.rightDiv100,.ckLeftDiv100,.ckRightDiv100{
			width: 100%;padding: 1%; padding-top: 2%;box-shadow: 0px 0px 2px 0px #ccc;display: inline-block;overflow: visible!important;
		} 
		.ckLeftDiv100,.ckRightDiv100{
		    padding: 3% 1%;
		} 
		
		
		.labelBorder{
			width: auto;
			position: absolute;
			top: -10px;
			color: #233a49;
			background-color: white;
		}
		input:disabled {
			background-color: #fafafa!important;
    		cursor: no-drop;
		}
		.moveBtn{
			cursor: pointer;
			padding: 10px 24px;
			color: #423e3e;
			font-weight: normal;
			border-radius: 2px; 
		} 
		 .standardC{
		 	color:#423e3e;
			font-weight:normal
		 }
		.selectBox{
			padding: 5px;
			width: 100%;
			border-radius: 2px;
			border-color: #ccc;
			color:#423e3e;
			font-weight:normal
			
		}
	</style>
	
 	<?php
 	if($_GET['action']=='tourDateChange' && $_GET['quotationId']!=''){
		if($_GET['quotationId']!=''){
			$id=decode($_GET['quotationId']); 
			$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$id.'');
			$quotationData=mysqli_fetch_array($rs1);
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
		<div class="contentclass">
			<h1 style="text-align:left;">Change Arrival Date</h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:15px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="query_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;">
						<label>Name:&nbsp;<?php echo ($quotationSubject);echo "&nbsp;#".$queryDisplayId; ?></label>
					</div>
					<div class="griddiv leftDiv50">
						<label>
							<div class="labelBorder" >Currenct Arrival Date</div>
							<input type="date" class="gridfield" id="oldTourDate" name="oldTourDate"value="<?php echo $oldTourDate; ?>" disabled>
						</label>
					</div>
 					<div class="griddiv rightDiv50">
						<label>
							<div class="labelBorder" >New Arrival Date</div>
 							<input type="date" class="gridfield" id="newTourDate" name="newTourDate" value="<?php echo $oldTourDate; ?>" >
						</label>
					</div> 
					<div class="griddiv ckLeftDiv50" style="display: none;">
						<label class="labelBorder" >
							<input name="reservation" style="width: 16px;" type="checkbox" class="gridfield" value="1" checked="checked">Update Reservations
						</label>
					</div>
					<div class="griddiv ckRightDiv50"  style="display: none;">
						<label class="labelBorder" >
 							<input name="voucher" style="width: 16px;" type="checkbox" class="gridfield" value="1" checked="checked">Update Vouchers
						</label>
					</div>
					<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
 					<input name="action" type="hidden" id="action" value="tourDateChangeAction" />
 				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel"  onclick="query_alertboxClose();" /></td>
				</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	
	if($_GET['action']=='askToRegenrateQuotation' && $_GET['quotationId']!=''){
		if($_GET['quotationId']!=''){
			$id=decode($_GET['quotationId']); 
			$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$id.'');
			$quotationData=mysqli_fetch_array($rs1);
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
	 	<div class="delbg" style="padding: 12px 0px; height: 60px;"><img src="images/regenerate-icon.png" style=" width: 60px; "></div>
		<div class="contentclass">
			<h1 style="background-color: #ffffff;color: #233a49;">Tour arrival date is changed, So please regenerate it again!!</h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:15px; overflow:auto; text-align:left; margin-bottom:0px; display:none;" >
				<form action="query_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;text-align:center;">
						<label>Name:&nbsp;<?php echo ($quotationSubject);echo "&nbsp;#".$queryDisplayId; ?></label>
					</div> 
					<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
 					<input name="action" type="hidden" id="action" value="askToRegenrateQuotation" />
 				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="center" cellpadding="0" cellspacing="0">
					<tr><td  ><input name="addnewuserbtn" type="button" class="redmbutton2 submitbtn" id="addnewuserbtn" value=" Re-Generate Now " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td ><a href="showpage.crm?module=quotations&view=yes&alt=3&id=<?php echo $_REQUEST['quotationId']; ?>"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" /></a></td>

					<!-- <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="query_alertboxClose();" /></td> -->
				</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	
	if($_GET['action']=='regenrateQuotationInfo' && $_GET['quotationId']!=''){
		if($_GET['quotationId']!=''){
			$id=decode($_GET['quotationId']); 
			$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$id.'');
			$quotationData=mysqli_fetch_array($rs1);
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
	 	<div class="delbg" style="padding: 12px 0px; height: 60px;"><img src="images/regenerate-icon.png" style=" width: 60px; "></div>
		<div class="contentclass">
			<h1 style="background-color: #ffffff;color: #233a49;">Information</h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:15px; overflow:auto; text-align:left; margin-bottom:0px;;" >
				<div id="regenrateQuotationInfo"></div>
				<form action="query_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters" style="display:none">
					<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;text-align:center;">
						<label>Name:&nbsp;<?php echo ($quotationSubject);echo "&nbsp;#".$queryDisplayId; ?></label>
					</div> 
					<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
 					<input name="action" type="hidden" id="action" value="askToRegenrateQuotation" />
 				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="center" cellpadding="0" cellspacing="0"> 
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value=" OK " onclick="setupbox('showpage.crm?module=quotations&view=yes&id=<?php echo trim($_REQUEST['quotationId']); ?>');" /></td>
				</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	
	if($_GET['action']=='updatePaxRoom' && $_GET['quotationId']!=''){
		
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
		<div class="contentclass">
			<h1 style="text-align:left;">Amend Accommondation</h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:15px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="query_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;">
						<label>Name:&nbsp;<?php echo ($quotationSubject); echo "&nbsp;#".$queryDisplayId;?></label>
					</div>
					
					
					<div class="griddiv leftDiv50"  >
 						<div class="labelBorder" >Current Accommondation</div>
						<div class="griddiv"  >
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Adult</div>
									<input type="number" class="gridfield" id="oldAdult" name="oldAdult"value="<?php echo $quotationData['adult']; ?>" disabled>
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Child</div>
									<input type="number" class="gridfield" id="oldChild" name="oldChild"value="<?php echo $quotationData['child']; ?>" disabled>
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Infant</div>
									<input type="number" class="gridfield" id="oldInfant" name="oldInfant"value="<?php echo $quotationData['infant']; ?>" disabled>
								</label>
								</td>
 							</tr> 
							</table>
						</div>
						<div class="griddiv"  >
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Single</div>
									<input type="number" class="gridfield" id="oldSingle" name="oldSingle" value="<?php echo $quotationData['sglRoom']; ?>" disabled>
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Double</div>
									<input type="number" class="gridfield" id="oldDouble" name="oldDouble" value="<?php echo $quotationData['dblRoom']; ?>" disabled>
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Triple</div>
									<input type="number" class="gridfield" id="oldTripple" name="oldTripple" value="<?php echo $quotationData['tplRoom']; ?>" disabled>
								</label>
								</td>
 							</tr> 
							</table>
						</div> 
						
 					</div>
					
 					<div class="griddiv rightDiv50">
						<div class="labelBorder">New Accommondation</div>
						<div class="griddiv"  >
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Adult</div>
									<input type="number" class="gridfield" id="newAdult" name="newAdult"value="<?php echo $quotationData['adult']; ?>" >
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Child</div>
									<input type="number" class="gridfield" id="newChild" name="newChild"value="<?php echo $quotationData['child']; ?>" >
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Infant</div>
									<input type="number" class="gridfield" id="newInfant" name="newInfant"value="<?php echo $quotationData['infant']; ?>" >
								</label>
								</td>
 							</tr> 
							</table>
						</div>
						<div class="griddiv"  >
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Single</div>
									<input type="number" class="gridfield" id="newSingle" name="newSingle" value="<?php echo $quotationData['sglRoom']; ?>" >
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Double</div>
									<input type="number" class="gridfield" id="newDouble" name="newDouble" value="<?php echo $quotationData['dblRoom']; ?>" >
								</label>
								</td>
								<td>
								<label>
									<div class="gridlable" style="width:100%;">Triple</div>
									<input type="number" class="gridfield" id="newTriple" name="newTriple" value="<?php echo $quotationData['tplRoom']; ?>" >
								</label>
								</td>
 							</tr> 
							</table>
						</div>
					</div>
					
					<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
 					<input name="action" type="hidden" id="action" value="askToRegenrateQuotation_updatePaxRoom" />
 				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Regenerate Now " onclick="formValidation('addmasters','submitbtn','0');" /></td>
					<td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="query_alertboxClose();" /></td>
				</tr>
				</table>
			</div>
		</div>
		<?php 
	}
	
	if($_GET['action']=='modifyRoute' && $_GET['quotationId']!=''){
		if($_GET['quotationId']!=''){
			$quotationId=decode($_GET['quotationId']); 
			$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
			$quotationData=mysqli_fetch_array($rs1); 
			$queryId = $quotationData['queryId'];
 			
			$rs1=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).'');
			$queryData=mysqli_fetch_array($rs1);
			$dayWise = $queryData['dayWise'];
			if($quotationSubject != ''){
				$quotationSubject = stripslashes($queryData['subject']);
			}else{
				$quotationSubject = stripslashes($quotationData['quotationSubject']);
			}
			$queryDisplayId = makeQuotationId($quotationData['id']);
 		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;">Modify Route</h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:15px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="query_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;">
						<label style="background: #ccc;">Name:&nbsp;<?php echo ($quotationSubject); echo "&nbsp;#".$queryDisplayId; ?></label>
					</div>
				  	<div class="griddiv leftDiv100" id="reloadModifyRoute" > 
 						<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#DDD"  >
						<thead>
						<tr>
						<th width="70px">Sr.No.</th>
						<?php if($dayWise == 1){ ?><th width="120px">Date/Day</th><?php } ?>
						<th width="180px" align="left">Destination</th>
						<th width="30px" align="center">&nbsp;</th>
						</tr> 
						</thead>
						<tbody class="row_drag2" onclick="modifyRoute();" id="reloadModifyRoute" >
						<?php
						$n = 1; 
						$rs1="";
						$dayIdArr="";
						$rs1=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" and addstatus=0 order by srdate asc'); 
						while($newQuoteData=mysqli_fetch_array($rs1)){
							
 							$dayDate = date('d-m-Y /D',strtotime($newQuoteData["srdate"])); 
							$pqId= $newQuoteData["id"]; 
							$cityId= $newQuoteData["cityId"];
							$dayIdArr .= trim($newQuoteData["id"]).",";  
							?>
							<tr class="row<?php echo $pqId; ?>" dayId = "<?php echo trim($newQuoteData["id"]); ?>">
							<td width="70px" >Day&nbsp;<?php echo $n; ?></td>
							<?php if($dayWise == 1){ ?>
							<td width="120px"><?php echo $dayDate; ?></td>
							<?php } ?>
							<td width="180px"><?php echo getDestination($cityId); ?></td>
							<td width="30px" align="left"><a class="moveBtn drag-handler"><i class="fa fa-arrows-alt" style="color:#CCCCCC;transform: rotate(45deg);"></i></a></td>
							</tr>
							<?php 
							$n++;	
						}
						?>
						</tbody>
						</table>  
  					</div>
					<script type="text/javascript">  
							function modifyRoute(){
								$( ".row_drag2" ).sortable({
									handle: '.drag-handler',
									axis: "y",
									revert: true,
									scroll: false, 
									cursor: "move", 
									update: function( event, ui ) { 
										var dayIdArr = [];
										$('.row_drag2 tr').each(function() {
											
											var srn = $(this).index()+1;
											var ele = $(this).children('td:first-child');
											var dayId = $(this).attr('dayId');
											//alert(cityId);
											dayIdArr.push(dayId); 
											ele.html('Day '+ srn);
											
 										});  
										$('#dayIdArr').val(dayIdArr);
   									}
								}); 
							}
							
							function updateModifyRoute(){
								var dayIdArr = $('#dayIdArr').val();
								setTimeout(function(){
									$('#reloadModifyRoute').load('query_frmaction.php?action=updateModifyRoute&quotationId=<?php echo encode($quotationId);?>&dayIdArr='+dayIdArr);
									$('#regenerateQuotation').show();
									// $('#hideCancel').show();
								}, 1000);
							}
 
						</script>
					<input name="dayIdArr" type="hidden" id="dayIdArr" value="<?php echo rtrim($dayIdArr,','); ?>" />
					<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
 					<input name="action" type="hidden" id="action" value="askToRegenrateQuotation_updateModifyRoute" />
 				</form>
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr>
					
					<td id="regenerateQuotation" style="display:none;"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value=" Regenerate Now " onclick="formValidation('addmasters','submitbtn','0');" style="font-size: 14px!important;" /></td>
					<td><input type="button" class="whitembutton" onClick="updateModifyRoute();" value=" Update Change " style="background-color: #8BC34A;color: #fff;"/></td>
					<td id="hideCancel"><a href="showpage.crm?module=quotations&view=yes&id=<?php echo $_REQUEST['quotationId']; ?>"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" /></a></td>
					</tr>
				</table>
			</div>
			
			
		</div>
		<?php 
	}
	
	
	if($_GET['action']=='amendCityDay' && $_GET['quotationId']!=''){
		if($_GET['quotationId']!=''){
			$quotationId=decode($_GET['quotationId']); 
			$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id='.$quotationId.'');
			$quotationData=mysqli_fetch_array($rs1); 
			$queryId = $quotationData['queryId'];
 			
			$rs1=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).'');
			$queryData=mysqli_fetch_array($rs1);
			$dayWise = $queryData['dayWise'];
			if($quotationSubject != ''){
				$quotationSubject = stripslashes($queryData['subject']);
			}else{
				$quotationSubject = stripslashes($quotationData['quotationSubject']);
			}
			$queryDisplayId = makeQuotationId($quotationData['id']);
 		}
		?>
		<div class="contentclass">
			<h1 style="text-align:left;">Amend Day/City</h1>
			<div id="contentbox" class="addeditpagebox" style="  padding:15px; overflow:auto; text-align:left; margin-bottom:0px; " >
				<form action="query_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
					<div class="griddiv" style="padding-bottom: 10px;font-size: 14px;font-weight: 500;">
						<label style="background: #ccc;">Name:&nbsp;<?php echo ($quotationSubject); echo "&nbsp;#".$queryDisplayId; ?></label>
					</div>
				  	<div class="griddiv leftDiv100" id="reloadModifyRoute" > 
						<div class="labelBorder" >Current Accommondation</div> 
 						<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#DDD"  >
						<thead>
						<tr>
						<th width="122px">Sr.No.</th>
						<?php if($dayWise == 1){ ?><th width="194px">Date</th><?php } ?>
						<th width="121px" align="left">Destination</th>
						<th width="131px" align="center">&nbsp;</th>
						</tr> 
						</thead>
						<tbody class="row_drag2" onclick="modifyRoute();" id="reloadModifyRoute" >
						<?php
						$n = 1; 
						$rs1="";
						$dayIdArr="";
						$rs1=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" and deletestatus=0 order by srdate asc'); 
						while($newQuoteData=mysqli_fetch_array($rs1)){
							
 							$dayDate = date('d-m-Y /D',strtotime($newQuoteData["srdate"])); 
							$dayId= $newQuoteData["id"]; 
							$cityId= $newQuoteData["cityId"];
							$dayIdArr .= trim($newQuoteData["id"]).",";  
							?>
							<tr class="row<?php echo $dayId; ?>" dayId = "<?php echo trim($newQuoteData["id"]); ?>">
							<td width="122px" >Day&nbsp;<?php echo $n; ?></td>
							<?php if($dayWise == 1){ ?>
							<td width="194px"><?php echo $dayDate; ?></td>
							<?php } ?>
							<td width="121px">
								<input type="hidden" value="<?php echo $dayId; ?>" name="dayIdArr[]" />
								<input type="hidden" class="validate" value="<?php echo $cityId; ?>" name="cityId[]" />
								<?php 
								if($cityId == 0 || $cityId == ''){ ?>
								<select id="destinationId<?php echo $dayId; ?>" name="destinationId[]" class="selectBox" >
									<option value="">Select</option>
									<?php 
									$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
									while($resListing=mysqli_fetch_array($rs)){  
									?>
									<option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option>
									<?php } ?>
								</select>
								<?php 
								}else{  
									echo getDestination($cityId);
								} ?>
							</td>
							<td width="131px" align="center">
							
								<a class="moveBtn2 drag-handler"><i class="fa fa-arrows-alt" style="color:#CCCCCC;transform: rotate(45deg);"></i></a>
								<?php if($cityId == 0 || $cityId == ''){ ?>
								<a class="moveBtn2 add-row-btn" onclick="saveAmendDay('<?php echo $dayId; ?>');"  ><i class="fa fa-save" style="color: #4caf50;"></i></a>
								<?php } else { ?>
								<a class="moveBtn2 add-row-btn" onclick="addAmendDay('<?php echo $dayId; ?>');"  ><i class="fa fa-plus" style="color: #4caf50;"></i></a>
								<?php } ?>
								<a class="moveBtn2 del-row-btn" onclick="deleteRow('<?php echo $dayId; ?>');"><i class="fa fa-trash" style="color: #F44336;"></i></a>
							</td>	
							</tr>
							<?php 
							$n++;	
						}
						?>
						</tbody>
						</table>  
  					</div>
					<div id="loadBox" style="display:none;"></div>
					<style>
						.moveBtn2 {
							cursor: pointer;
							padding: 3px 5px;
							color: #423e3e;
							font-weight: normal;
							border-radius: 2px;
							margin-left: 11px;
						}
						.selectBox{
							padding:3px;
						}
					</style>
					<script type="text/javascript"> 
						function modifyRoute(){
							$( ".row_drag2" ).sortable({
								handle: '.drag-handler',
								axis: "y",
								revert: true,
								scroll: false, 
								cursor: "move", 
								update: function( event, ui ) { 
									var dayIdArr = [];
									$('.row_drag2 tr').each(function() {
										
										var srn = $(this).index()+1;
										var ele = $(this).children('td:first-child');
										var dayId = $(this).attr('dayId');
										//alert(cityId);
										dayIdArr.push(dayId); 
										ele.html('Day '+ srn);
										
									});  
									$('#dayIdArr').val(dayIdArr);
									$('#regenerateQuotation').hide(); 
								}
							}); 
 						}
						
						function addAmendDay(dayId){   
							$('#loadBox').load('query_frmaction.php?action=addAmendCity_row&quotationId=<?php echo encode($quotationId);?>&dayId='+dayId);	 
						} 
						function saveAmendDay(dayId){ 
							var cityId = document.getElementById('destinationId'+dayId).value;
							if( cityId > 0){
							  $('#loadBox').load('query_frmaction.php?action=saveAmendCity_row&quotationId=<?php echo encode($quotationId);?>&dayId='+dayId+'&cityId='+cityId);	 
							}else{
								document.getElementById('destinationId'+dayId).focus();
							}
						} 
						function deleteRow(dayId){ 
							if(dayId > 0){
 							if( confirm('Delete this record? You will not be able to undo this action.')){
							  $('#loadBox').load('query_frmaction.php?action=deleteAmendCity_row&quotationId=<?php echo encode($quotationId);?>&dayId='+dayId);	 
							} 
							}
						} 
						
						function regenerateQuotation(){ 
							var cityIdArray = Array.prototype.slice.call(document.getElementsByName('cityId[]'));
							var cityIdArr = cityIdArray.map((o) => o.value);
							var cityIdStatusArray = cityIdArr.filter(function(x) {
								return x < 1;
							}); 

          
							if(cityIdArray.length > 0 && cityIdStatusArray.length < 1){
								if( confirm('Please do not refresh the page and wait while we are generating new quotation. This can take a few minutes.')){
								formValidation('addmasters','submitbtn','0');
								//$('#loadBox').load('query_frmaction.php?action=deleteAmendCity_row&quotationId=<?php echo encode($quotationId);?>&dayId='+dayId);	 
								} 
							}else{
								$('#regenerateQuotation').hide();
								$('#hideCancel').hide();
								alert('Please select city and save then update change.');
								
							} 
						} 
						
						function updateAmendCityDrag(page){ 
 							var dayIdArray = Array.prototype.slice.call(document.getElementsByName('dayIdArr[]'));
							var dayIdArr = dayIdArray.map((o) => o.value);
 							//alert(values);
							var cityIdArray = Array.prototype.slice.call(document.getElementsByName('cityId[]'));
							var cityIdArr = cityIdArray.map((o) => o.value);
							var cityIdStatusArray = cityIdArr.filter(function(x) {
								return x < 1; 
							}); 
							//alert(cityIdStatusArray.length);
							if(dayIdArr.length > 0 && ( cityIdStatusArray.length < 1 || page == 1 ) ){
								setTimeout(function(){
									$('#reloadModifyRoute').load('query_frmaction.php?action=updateAmendCityDrag&quotationId=<?php echo encode($quotationId);?>&dayIdArr='+dayIdArr);
									$('#regenerateQuotation').show();
									// $('#hideCancel').hide();
								}, 1000);
							}else{
								alert('Please select city and save.');
								$('#regenerateQuotation').hide(); 
							}
						}

					</script>
 					<input name="quotationId" type="hidden" id="editId" value="<?php echo $_GET['quotationId']; ?>" />
 					<input name="action" type="hidden" id="action" value="askToRegenrateQuotation_updateAmendCityDrag" />
 				</form>
				
			</div>
			<div id="buttonsbox"  style="text-align:center;">
				<table border="0" align="right" cellpadding="0" cellspacing="0">
					<tr> 
					<td id="regenerateQuotation" style="display:none;"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" value=" Regenerate Now " onclick="regenerateQuotation();" style="font-size: 14px!important;" /></td>
					<td><input type="button" class="whitembutton" onClick="updateAmendCityDrag(0);" value=" Update Change " style="background-color: #8BC34A;color: #fff;"/></td>
					<td id="hideCancel"><a href="showpage.crm?module=quotations&view=yes&id=<?php echo $_REQUEST['quotationId']; ?>"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" /></a></td>
					</tr>
				</table>
			</div>
			
			
		</div>
		<?php 
	} 

	
  	?>
 