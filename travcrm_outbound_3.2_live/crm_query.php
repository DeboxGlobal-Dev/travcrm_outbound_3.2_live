<?php
$searchField = '';
$searchField=clean($_GET['searchField']);
$tourIdsearchField=clean($_GET['tourIdsearchField']);
$searchFieldcommon=clean($_GET['searchFieldcommon']);
$loadqueryyes=1;
$queryshow = $_GET['queryshow'];


// if OpsPerson of query have logged IN or query add user and opsPerson reporting person loged in
$wheresearchassign = ' assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].' or assignTo in ( select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in ( select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].')))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].')))))) ';


// if B2C sales person logged in or b2c salesPerson reporting person logged in
$whereB2CSalesPersonQuery = ' or ( clientType=2 and companyId in (
	select id from contactsMaster where assignTo='.$_SESSION['userid'].'
		or assignTo in ( select id from userMaster where reportingManager = '.$_SESSION['userid'].' )
		or assignTo in ( select id from userMaster where reportingManager in ( select id from userMaster where reportingManager='.$_SESSION['userid'].' ))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].')))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].'))))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].')))))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].'))))))) ) ';

// if Agent Opsperson (desired Person, This opsperson not added in query ) logged in or Agent OpsPerson reporting person logged in
$whereAgentOpsPersonQuery = ' or ( clientType=1 and companyId in (
	select id from corporateMaster where OpsAssignTo='.$_SESSION['userid'].'
		or OpsAssignTo in ( select id from userMaster where reportingManager = '.$_SESSION['userid'].' )
		or OpsAssignTo in ( select id from userMaster where reportingManager in ( select id from userMaster where reportingManager='.$_SESSION['userid'].' ))
		or OpsAssignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].')))
		or OpsAssignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].'))))
		or OpsAssignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].')))))
		or OpsAssignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].'))))))) )';

// if Agent Sales person logged in or Agent SalesPerson reporting person logged in
$whereAgentSalesPersonQuery = ' or ( clientType=1 and companyId in (
	select id from corporateMaster where assignTo='.$_SESSION['userid'].'
		or assignTo in ( select id from userMaster where reportingManager = '.$_SESSION['userid'].' )
		or assignTo in ( select id from userMaster where reportingManager in ( select id from userMaster where reportingManager='.$_SESSION['userid'].' ))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].')))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].'))))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].')))))
		or assignTo in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager in (select id from userMaster where reportingManager ='.$_SESSION['userid'].'))))))) )'; 
$whereSearchUserQuery = ' ( '.$wheresearchassign.' '.$whereB2CSalesPersonQuery.' '.$whereAgentOpsPersonQuery.' '.$whereAgentSalesPersonQuery.' ) ';
?>
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css" /> -->
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style>
.col-md-6 {  display: none !important;}
#pagelisterouter{ padding:10px !important; padding-top: 130px !important;}
body{overflow-x:hidden !important;}
.header{font-weight: 500 !important; font-size: 13px !important;}
#mainsectiontable .fa-pencil-square{cursor: pointer;
font-size: 20px;
color: #ff5c00;

}
.header{
	padding: 7px !important;
}
.tableClass tr td{
	padding: 7px !important;
}
</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="91%" align="left" valign="top">
			<form action="" method="get">
				<div class="rightsectionheader" style="overflow:auto;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><div class="headingm" style="margin-left:5px; display:none;"><span id="topheadingmain"><?php if($_REQUEST['dashboard']!=''){?><a href="http://travcrm.in/"><img src="images/backicon.png" width="20" style=" cursor:pointer;" /></a><?php } ?> </span>
						<div id="deactivatebtn" style="display:none;">
						</div>
					</div></td>
					<td align="left"><table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>        </td>
							<td >
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
										<td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:50px;" value="<?php echo $searchField; ?>" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>

										<td style="padding:0px 0px 0px 5px;"><input name="tourIdsearchField" type="text"  class="topsearchfiledmain" id="tourIdsearchField" style="width:80px;" value="<?php echo $tourIdsearchField; ?>" placeholder="Tour Id" onkeyup="numericFilter(this);"/></td>

										<td style="padding:0px 0px 0px 5px;" ><input name="searchFieldcommon" type="text"  class="topsearchfiledmain" id="searchFieldcommon" style="width:110px;" value="<?php echo $searchFieldcommon; ?>" size="100" maxlength="100" placeholder="Company, Lead Pax Name"  /></td>
										
										<td style="padding:0px 0px 0px 5px;" >
										<input name="daterange" type="text" readonly="" class="topsearchfiledmain" id="daterange" style="width:130px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { $today = date('d-m-Y');  echo date("01-m-Y").' - '.$today; } ?>" size="100" maxlength="100" placeholder="Query Date"/>
									
										</td>
									
									<td style="padding:0px 0px 0px 5px;" >
										<select name="destination" id="destination" class="topsearchfiledmainselect" style="width:120px; " >
											<option value="">All Destination</option>
											<?php
											$select='';
											$where='';
											$rs='';
											$select='*';
											$where=' deletestatus!=1 order by name asc';
											$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
											while($resListing=mysqli_fetch_array($rs)){
											?>
											<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['destination']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> </option>
											<?php } ?>
										</select> </td>
										<td style="padding:0px 0px 0px 5px;" >
											<select name="priority" id="priority" class="topsearchfiledmainselect" style="width:105px; " >
												<option value="">All Priority</option>
												<option value="1" <?php if($_GET['priority']=='1'){ ?>selected="selected"<?php  } ?>>Low</option>
												<option value="2" <?php if($_GET['priority']=='2'){ ?>selected="selected"<?php  } ?>>Medium</option>
												<option value="3" <?php if($_GET['priority']=='3'){ ?>selected="selected"<?php  } ?>>High</option>
											</select> </td>
											<td style="padding:0px 0px 0px 5px;" >
												<select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:160px; " >
													<option value="">All Operations Persons</option>
													<?php
													if($loginuserprofileId==1){
													$select='*';
													$where=' id!="" order by firstName asc';
													$rs=GetPageRecord($select,_USER_MASTER_,$where);
													while($resListing=mysqli_fetch_array($rs)){
													?>
													<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
													<?php } }  else {  ?>
													<?php
													$rs='';
													$select2='*';
													$where2=' 1 and ( '.$whereSearchUserQuery.' ) and  assignTo!="" group by assignTo order by assignTo asc';
													$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);
													while($resListingQuery=mysqli_fetch_array($rs2)){
													if($resListingQuery!='' && $resListingQuery!=0){
													$select='*';
													$where=' id='.$resListingQuery['assignTo'].' order by firstName asc';
													$rs=GetPageRecord($select,_USER_MASTER_,$where);
													while($resListing=mysqli_fetch_array($rs)){
													?>
													<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
													<?php } } } } ?>
												</select>
											</td>
											<td style="padding:0px 0px 0px 5px;" >
													<select name="querystatus" id="querystatus" class="topsearchfiledmainselect" style="width:105px; " >
														<option value="">All Status</option>
														<!-- <option value="1" <?php //if($_GET['querystatus']=='1'){ ?>selected="selected"<?php  //} ?>>Assigned</option> -->
														<option value="10" <?php if($_GET['querystatus']=='10'){ ?>selected="selected"<?php  } ?>>Created</option>
														<option value="20" <?php if($_GET['querystatus']=='20'){ ?>selected="selected"<?php  } ?>>Cancelled</option>
														<option value="2" <?php if($_GET['querystatus']=='2'){ ?>selected="selected"<?php  } ?>>Reverted</option>
														<option value="3" <?php if($_GET['querystatus']=='3'){ ?>selected="selected"<?php  } ?>>Confirmed</option>
														<option value="4" <?php if($_GET['querystatus']=='4'){ ?>selected="selected"<?php  } ?>>Lost</option>
														<option value="5" <?php if($_GET['querystatus']=='5'){ ?>selected="selected"<?php  } ?>>Quotation Generated</option>
														<option value="6" <?php if($_GET['querystatus']=='6'){ ?>selected="selected"<?php  } ?>>Quote Sent</option>
														<option value="7" <?php if($_GET['querystatus']=='7'){ ?>selected="selected"<?php  } ?>>Follow-up</option>
														<option value="11" <?php if($_GET['querystatus']=='11'){ ?>selected="selected"<?php  } ?>>TMS Closed</option>
													</select>
												</td>
												<td style="padding:0px 0px 0px 5px;" >
													<select name="queryshow" id="queryshow" class="topsearchfiledmainselect" style="width:120px; " onchange="changequerytstatus();" >
													<!-- <option value="">Select</option> -->
														<option value="1" <?php if($queryshow==1){ ?> selected="selected"<?php } ?>>Current Query</option>
														<option value="2" <?php if($queryshow==2){ ?> selected="selected"<?php } ?>>All Query</option>
														<option value="3" <?php if($_REQUEST['queryshow']==3){ ?> selected="selected"<?php } ?>>Today's Queries</option>
														<option value="4" <?php if(date('Y-m-d',strtotime("-1 days"))==$_REQUEST['searchdate']){ ?> selected="selected"<?php } ?>>Yesterday's Queries</option>
														<option value="5" <?php if($_REQUEST['queryshow']==5){ ?> selected="selected"<?php } ?>><?php echo date('F'); ?>'s Queries</option>
													</select>
													<input name="searchdate" type="hidden" id="searchdate" value="" />
													<input name="thismonth" type="hidden" id="thismonth" value="" />
												</td>
												<td style="padding:0px 0px 0px 5px;display:none" >
													<select name="moduleType" id="moduleType" class="topsearchfiledmainselect" style="width:120px; " >
														<option value="">Query Type</option>
														<?php
														$select='';
														$where='';
														$rs='';
														$select='*';
														$where=' status=1 order by name asc';
														$rs=GetPageRecord($select,'moduleTypeMaster',$where);
														while($resListing=mysqli_fetch_array($rs)){
														?>
														<option value="<?php echo $resListing['id']; ?>" <?php if($_GET['moduleType']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> </option>
														<?php } ?>
													</select> </td>
													<script>
													function changequerytstatus(){
													var queryshow = $('#queryshow').val();
													if(queryshow=='3'){
														var startDate = new Date();
													$('#daterange').data('daterangepicker').setStartDate(startDate);
													$('#daterange').data('daterangepicker').setEndDate(startDate);
													}
													if(queryshow=='4'){
														var startDate = new Date();
													$('#daterange').data('daterangepicker').setStartDate(startDate);
													$('#daterange').data('daterangepicker').setEndDate(startDate);
											
													}
													if(queryshow=='5'){
														var startDate = new Date();
													$('#daterange').data('daterangepicker').setStartDate('01-m-Y');
													$('#daterange').data('daterangepicker').setEndDate(startDate);
													}

													}
													


									$(function() {
										$('input[name="daterange"]').daterangepicker({
											"autoApply": true,
											opens: 'right',
											locale: {
												format: 'DD-MM-YYYY'
											}
										}, function(start, end, label) {
											//console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
										});
									});
									</script>
													<td><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
												</tr>
											</table>
										</td>
										
										<!--//onclick="add();" setupbox('showpage.crm?module=query&add=yes');-->
										<?php if($addpermission==1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Query" onclick="add();" style="margin-left: 5px !important;" /></td> <?php } ?>
										<td><a href="showpage.crm?module=crmrates" class="bluembutton" style="margin: 0px; background-color: #9466be !important; border: 1px solid #9466be !important; font-weight:100;margin-left: 5px !important;">View&nbsp;Rates</a></td>
									</tr>
								</table></td>
							</tr>
						</table>
						</div>
					</form>
					<?php 	
					$daterangeQuery='';
					$daterangeConfirmQuery='';
					$daterangeCreatedQuery='';
						if($_GET['daterange']!='' && $_GET['searchField']=='' && $_GET['searchFieldcommon']==''){
							$myString = $_GET['daterange'];
							$myArray = explode(' - ', $myString);
						
							$daterangeConfirmQuery = ' and queryConfirmingDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
							
							$daterangeQuery = ' and queryDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

							$queryRevertDateRage = ' and queryRevertDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

							$quotationGeneratedDate = ' and quotationDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

							$queryCancelDateRange = ' and queryCancelDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

							$queryCloseDateRange = ' and queryCloseDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

							$optionSentDateRange = ' and optionSentDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

							$followupdateRange = ' and followupdate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

						} 

						$myStringtoal = $_GET['totalQuerydaterange'];
						$myArraytotal = explode(' - ', $myStringtoal);
						
					$totalQuerydaterange = ' and queryDate BETWEEN "'.date('01-m-d').'" and "'.date('Y-m-d').'"' ;
						
						?>

					<form id="listform" name="listform" action="" method="get">
						<div id="pagelisterouter" style="padding-left:30px;">
							<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
							<input name="action" type="hidden" value="querydelete" id="action" />

							<input name="daterange" type="text" readonly="" style="display: none;" class="topsearchfiledmain" id="daterange" style="width:130px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { $today = date('d-m-Y');  echo date("01-m-Y").' - '.$today; } ?>" size="100" maxlength="100" placeholder="Query Date"/>
							<input name="action" type="hidden" value="querydelete" id="action" />

							<input type="text" name="querystatus" id="querystatus" value="<?php echo $_GET['querystatus']; ?>" style="display:none;">

							<input type="text" name="destination" id="destination" value="<?php echo $_GET['destination'] ?>" style="display:none;">
							<input type="text" name="priority" id="priority" value="<?php echo $_GET['priority'] ?>" style="display:none;">
							<input type="text" name="thismonth" id="thismonth" value="<?php echo $_GET['thismonth'] ?>" style="display:none;">
							<input type="text" name="assignto" id="assignto" value="<?php echo $_GET['assignto'] ?>" style="display:none;">
							<input type="text" name="queryshow" id="queryshow" value="<?php echo $_GET['queryshow'] ?>" style="display:none;">
							<input type="text" name="searchdate" id="searchdate" value="<?php echo $_GET['searchdate'] ?>" style="display:none;">


							<div style="margin:5px 0px;">
								<table width="100%" border="0" cellpadding="5" cellspacing="0">
									<tr>
										<td width="8%" align="left" valign="top" style="padding-left:0px;    padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#26A69A;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div id="totalQuery"  style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster', 'where deletestatus=0 '.$daterangeQuery.''); ?></div>
											<div style="font-size:12px; font-weight:500;">Total Queries</div>
										</div></td>
										<?php
										if($_GET['moduleType']==1){
										?>
										<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=10 and deletestatus=0 '.$daterangeCreatedQuery.''); ?></div>
											<div style="font-size:12px; font-weight:500;">Created</div>
										</div></td>
										<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#FF6600;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=2 and deletestatus=0 '.$queryRevertDateRage.''); ?></div>
											<div style="font-size:12px; font-weight:500;">Reverted</div>
										</div></td>
										<td width="9%" align="left" valign="top" ><div style="padding:10px; color:#fff; font-size:12px; background-color:#9466be;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=7 and deletestatus=0 '.$followupdateRange.''); ?></div>
											<div style="font-size:12px; font-weight:500;">Follow-up</div>
										</div></td>
									
									<!-- <td width="9%" align="left" valign="top" >
										<div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where confirmedAssignTo>0 and deletestatus=0 '); ?></div>
											<div style="font-size:12px; font-weight:500;">Assigned</div>
										</div>
									</td> -->

								<td width="11%" align="left" valign="top" ><div style="padding:10px; color:#fff; font-size:12px; background-color:#a598d9;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5 and deletestatus=0 '.$quotationGeneratedDate.''); ?></div>
									<div style="font-size:12px; font-weight:500;">Quotation Generated</div>
								</div></td>
										<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#82b767;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=3   and deletestatus=0 '); ?></div>
											<div style="font-size:12px; font-weight:500;">Confirmed</div>
										</div></td>
										
										<!--   <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#333333;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">-->
										<!--<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5   and deletestatus=0 '); ?></div>-->
										<!--<div style="font-size:12px; font-weight:500;">Time&nbsp;Limit</div>-->
										<!--</div></td>-->
										<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=6 and deletestatus=0 '.$optionSentDateRange.''); ?></div>
											<div style="font-size:12px; font-weight:500;">Quote Sent</div>
										</div></td>
									
										<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#c75858;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
											<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=20 and deletestatus=0 '.$queryCancelDateRange.''); ?></div>
											<div style="font-size:12px; font-weight:500;">Cancelled</div>
										</div></td> <td width="9%" align="left" valign="top" style="padding-right:0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#a92525;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=4 and deletestatus=0 '.$queryCloseDateRange.''); ?></div>
										<div style="font-size:12px; font-weight:500;">Lost</div>
									</div></td>
									<?php }elseif($_GET['moduleType']==2){ ?>
									<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=10   and moduleType=2 and deletestatus=0 '.$daterangeCreatedQuery.' '); ?></div>
										<div style="font-size:12px; font-weight:500;">Created</div>
									</div></td>
									<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#FF6600;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=2 and moduleType=2 and deletestatus=0 '.$queryRevertDateRage.''); ?></div>
										<div style="font-size:12px; font-weight:500;">Reverted</div>
									</div></td>
									<td width="9%" align="left" valign="top" ><div style="padding:10px; color:#fff; font-size:12px; background-color:#9466be;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=7 and moduleType=2 and deletestatus=0 '.$followupdateRange.''); ?></div>
										<div style="font-size:12px; font-weight:500;">Follow-up</div>
									</div></td>
									<!-- <td width="9%" align="left" valign="top" ><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php //echo countlisting('id','queryMaster','where confirmedAssignTo>0 and deletestatus=0 '); ?></div>
									<div style="font-size:12px; font-weight:500;">Assigned</div>
								</div></td> -->
								<td width="11%" align="left" valign="top" ><div style="padding:10px; color:#fff; font-size:12px; background-color:#a598d9;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5 and deletestatus=0 '.$quotationGeneratedDate.''); ?></div>
									<div style="font-size:12px; font-weight:500;">Quotation Generated</div>
								</div></td>
									<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#82b767;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=3   and moduleType=2 and deletestatus=0 '); ?></div>
										<div style="font-size:12px; font-weight:500;">Confirmed</div>
									</div></td>
								
									<!--   <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#333333;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">-->
									<!--<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5   and moduleType=2 and deletestatus=0 '); ?></div>-->
									<!--<div style="font-size:12px; font-weight:500;">Time&nbsp;Limit</div>-->
									<!--</div></td>-->
									<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=6 and moduleType=2 and deletestatus=0 '.$optionSentDateRange.''); ?></div>
										<div style="font-size:12px; font-weight:500;">Quote Sent</div>
									</div></td>
									
									<td width="9%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#c75858;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
										<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=20 and moduleType=2 and deletestatus=0 '.$queryCancelDateRange.''); ?></div>
										<div style="font-size:12px; font-weight:500;">Cancelled</div>
									</div></td> <td width="9%" align="left" valign="top" style="padding-right:0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#a92525;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=4 and moduleType=2 and deletestatus=0 '.$queryCloseDateRange.''); ?></div>
									<div style="font-size:12px; font-weight:500;">Lost</div>
								</div></td>
								
								<?php }else{?>
								<td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=10 and deletestatus=0 '.$daterangeQuery.' '); ?></div>
									<div style="font-size:12px; font-weight:500;">Created</div>
								</div></td>
								<td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#FF6600;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo (countlisting('id','queryMaster','where queryStatus=2 and deletestatus=0 '.$queryRevertDateRage.' '))?0:0; ?></div>
									<div style="font-size:12px; font-weight:500;">Reverted</div>
								</div></td>
								<td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#9466be;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php $folloup = countlisting('id','queryMaster','where queryStatus=7 and deletestatus=0 '.$followupdateRange.'');
									echo ($folloup>0)?$folloup:0;
									 ?></div>
									<div style="font-size:12px; font-weight:500;">Follow-up</div>
								</div></td>
								<!-- <td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where confirmedAssignTo>0 and deletestatus=0 '.$daterangeQuery.''); ?></div>
									<div style="font-size:12px; font-weight:500;">Assigned</div>
								</div></td> -->
								<td width="9%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#a598d9;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5 and deletestatus=0 '.$quotationGeneratedDate.''); ?></div>
									<div style="font-size:12px; font-weight:500;">Quotation Generated</div>
								</div></td>
								<td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#82b767;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=3 and deletestatus=0 '.$daterangeConfirmQuery.' '); ?></div>
									<div style="font-size:12px; font-weight:500;">Confirmed</div>
								</div></td>
								<!-- <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#e52929;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where deletestatus=0 and id in (select queryid from '._PAYMENT_REQUEST_MASTER_.' where supplierPendingamount>0 and deletestatus!=1) '); ?></div>
									<div style="font-size:12px; font-weight:500;">Unpaid</div>
								</div></td> -->
								<!--   <td width="10%" align="left" valign="top"><div style="padding:10px; color:#fff; font-size:12px; background-color:#333333;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">-->
								<!--<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=5   and deletestatus=0 '); ?></div>-->
								<!--<div style="font-size:12px; font-weight:500;">Time&nbsp;Limit</div>-->
								<!--</div></td>-->
								<td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php $quotSent = countlisting('id','queryMaster','where queryStatus=6 and deletestatus=0 '.$optionSentDateRange.'');
									echo ($quotSent>0)?$quotSent:0;?></div>
									<div style="font-size:12px; font-weight:500;">Quote Sent</div>
								</div></td>
							
								<td width="8%" align="left" valign="top" style="padding-right: 0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#c75858;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
									<div style="font-size:20px; font-weight:600;"><?php 
									$quotSent = countlisting('id','queryMaster','where queryStatus=20 and deletestatus=0 '.$queryCancelDateRange.'');
									echo ($quotSent>0)?$quotSent:0;?></div>
									<div style="font-size:12px; font-weight:500;">Cancelled</div>
								</div></td> <td width="8%" align="left" valign="top" style="padding-right:0px;"><div style="padding:10px; color:#fff; font-size:12px; background-color:#a92525;border-left: 4px solid #000;border-radius: 4px; overflow: hidden;">
								<div style="font-size:20px; font-weight:600;"><?php echo countlisting('id','queryMaster','where queryStatus=4 and deletestatus=0 '.$queryCloseDateRange.''); ?></div>
								<div style="font-size:12px; font-weight:500;">Lost</div>
							</div></td>
							<?php }?>
						</tr>
					</table>
				</div>
				<table width="100%" border="0" cellpadding="0" cellspacing="0"  id="mainsectiontable" class="table table-striped table-bordered tableClass">
					<thead>
						<tr>
							<th align="center" valign="middle" class="header" >&nbsp;</th>
							<th align="left" class="header" style="min-width: 104px !important;">Query&nbsp;ID </th>
							<th align="left" class="header" width="80px">Tour&nbsp;Id &<br>Reference&nbsp;No</th>
							<th align="left" class="header">Type</th>
							<th align="left" class="header">Name</th>
							<th align="center" class="header">Query&nbsp;Date </th>
							<th align="left" class="header" style="min-width:74px;">Tour&nbsp;Date </th>
							<th align="left" class="header" >Destination</th>
							
							<th align="left" class="header" >Travel&nbsp;Type</th>
							<th align="center" class="header">Query&nbsp;Type</th>
							<th align="left" class="header" >Lead&nbsp;Source</th>
							<th align="left" class="header" >Priority</th>
							<th align="left" class="header" >Ops.&nbsp;Person</th>
							<th align="left" class="header" >Sales&nbsp;Person</th>
							<th align="center" class="header" style="width:50px;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$strWheredash;
						$no=1;
						$select='*';
						$where='';
						$rs='';
						$wheresearch='';
						$limit=clean($_GET['records']);

						$arrayQid = explode('/',$_GET['searchField']);
						$financeYear = $arrayQid[0];
						$arrayQIdData = $arrayQid[1];
						$searchField=clean(trim(ltrim($arrayQIdData, '0')));
						$mainwhere='';
						if($searchField!=''){
							$mainwhere=' and  displayId="'.$searchField.'" and financeYear="'.$financeYear.'"';
						}

						$array = explode('/',$_GET['tourIdsearchField']);
						$tourIdpart0 = date('Y',strtotime($array[0].'-01-01')); // year
						$tourIdpart1 = date('m',strtotime($array[0].'-'.$array[1].'-01')); // months
						$tourIdpart2 = $array[2]; // sequence 

						$tourIdNo=clean(trim(ltrim($tourIdpart2, '0')));
						$searchByTourId='';
						if(isset($_GET['tourIdsearchField']) && $_GET['tourIdsearchField']!='' && $tourIdNo!='' && $tourIdSequence==1){
							$searchByTourId=' and monthTourId="'.$tourIdNo.'"';
						}
						if(isset($_GET['tourIdsearchField']) && $_GET['tourIdsearchField']!='' && $tourIdNo!='' && $tourIdSequence==2){
							$searchByTourId=' and ( yearTourId="'.$tourIdNo.'" or monthTourId="'.$tourIdNo.'") ';
						}
						if(isset($_GET['tourIdsearchField']) && $_GET['tourIdsearchField']!='' && $tourIdpart0>0 && $tourIdpart1>0){
							$searchByTourId .=' and YEAR(fromDate) = "'.$tourIdpart0.'" and MONTH(fromDate) = "'.$tourIdpart1.'" ';
						}

						
						// $array = explode('/',$_GET['tourIdsearchField']);
						// $arrayData = $array[2];
						// $tourIdsearchField=clean(trim(ltrim($arrayData, '0')));
						// $searchByTourId='';
						// if($tourIdsearchField!=''){
						// 	$searchByTourId=' and  queryConfirmingTourId="'.$tourIdsearchField.'"';
						// }

						$assignto='';
						if($_GET['assignto']!=''){
							$assignto=' and	assignTo="'.$_GET['assignto'].'"';
						}
						$destination='';
						if($_GET['destination']!=''){
							$destination=' and	destinationId="'.clean($_GET['destination']).'"';
						}
						$moduleTypes='';
						if($_GET['moduleType']!=''){
							$moduleTypes=' and	moduleType="'.clean($_GET['moduleType']).'"';
						}else{
							$moduleTypes=' and	moduleType=1';
							
						}
						$priority='';
						if($_GET['priority']!=''){
							$priority=' and	queryPriority='.clean($_GET['priority']).'';
						}
						$querystatus='';
						if($_GET['querystatus']!=''){
							$querystatus=' and	queryStatus='.clean($_GET['querystatus']).'';
						}

						$daterangeQuery='';
						if($_GET['daterange']!='' && $_GET['searchField']=='' && $_GET['searchFieldcommon']==''){
							$myString = $_GET['daterange'];
							$myArray = explode(' - ', $myString);

								if($_GET['daterange']!='' && $_GET['querystatus']=='3'){

									$daterangeQuery = ' and queryDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='1'){

									$daterangeQuery = ' and queryDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;

								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='10'){

									$daterangeQuery = ' and queryDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='20'){

									$daterangeQuery = ' and queryCancelDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='5'){

									$daterangeQuery = ' and quotationDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='6'){

									$daterangeQuery = ' and optionSentDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='7'){

									$daterangeQuery = ' and followupdate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='2'){

									$daterangeQuery = ' and queryRevertDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='4'){

									$daterangeQuery = ' and queryCloseDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']=='11'){

									$daterangeQuery = ' and queryCloseDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
									
								}elseif($_GET['daterange']!='' && $_GET['querystatus']==''){

									$daterangeQuery = ' and queryDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
								} 
							
						}
						

						$searchFieldcommonquery='';
						if($searchFieldcommon!=''){
							$searchFieldcommonquery=' and ( displayId like "%'.$searchFieldcommon.'%" or subject like "%'.$searchFieldcommon.'%" or subject like "%'.$searchFieldcommon.'%" or leadPaxName like "%'.$searchFieldcommon.'%" or guest1 like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%" ) or companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$searchFieldcommon.'%" or lastName like "%'.$searchFieldcommon.'%" ) )';
						}
						$wheresearch=' addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in ( select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].') or companyId in (select id from  '._CORPORATE_MASTER_.' where assignTo='.$_SESSION['userid'].')  '.$searchFieldcommonquery.'';

						if($loginuserprofileId==1){
							$wheresearch=' 1 '.$mainwhere.' '.$searchFieldcommonquery.'';
						} else {
							$wheresearch=' '.$whereSearchUserQuery.' '.$mainwhere.' '.$searchFieldcommonquery.'';
						}
						if($_GET['searchFieldQueryDate']!=''){
						$searchFieldQueryDate='and queryDate="'.date('Y-m-d',strtotime($_GET['searchFieldQueryDate'])).'"';
						}
						$fromDate = $_REQUEST['fromDate'];
						$toDate = $_REQUEST['toDate'];
						$dashbord = $_REQUEST['dashboard'];
						$dashqueryst = $_REQUEST['querystatus'];
						if($dashbord==1 && $fromDate!='' && $toDate!=''){
						$fromDate = date('Y-m-d', strtotime( $fromDate ));
						$toDate = date('Y-m-d', strtotime( $toDate ));
						$strWheredas =' and  queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
						}
						if($dashbord==1 && $fromDate!='' && $toDate!='' && $dashqueryst==3){
							$fromDate2 = date('Y-m-d', strtotime( $fromDate ));
							$toDate2 = date('Y-m-d', strtotime( $toDate ));
							$dashbordconfirmed =' and  queryDate BETWEEN "'.$fromDate2.'" and "'.$toDate2.'" and deletestatus=0 and queryStatus=3 ';
							}
						$queryshow='';
						if($_GET['queryshow']==2 ){
						$where=' where '.$wheresearch.' '.$whereFromDate.' '.$assignto.' '.$mainwhere.' '.$searchByTourId.' '.$destination.' '.$priority.' '.$querystatus.' '.$dashbordconfirmed.' '.$strWheredas.' '.$moduleTypes.' and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';
						}
						// if($_GET['searchdate']!=''){
						// $where=' where '.$wheresearch.''.$daterangeQuery.' '.$assignto.' '.$mainwhere.' '.$searchByTourId.' '.$destination.' '.$priority.' '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and queryDate ="'.$_REQUEST['searchdate'].'"  and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';
						// }
						if($_GET['thismonth']=='1'){
							$start = date("Y-m-1 00:00:00");
							$end = date("Y-m-d H:i:s");
							$where=' where '.$wheresearch.' '.$assignto.' '.$mainwhere.' '.$destination.' '.$priority.' '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and queryDate BETWEEN "'.$start.'" and "'.$end.'" and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';
						}
						if($_GET['queryshow']==5 || $_GET['queryshow']==4 || $_GET['queryshow']==3 && $_GET['daterange']!=''){
							$where=' where '.$wheresearch.' '.$daterangeQuery.' '.$assignto.' '.$mainwhere.' '.$searchByTourId.' '.$destination.' '.$priority.' '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';
						}
						if($_GET['queryshow']==1 || $_GET['queryshow']==''){
							$where=' where '.$wheresearch.' '.$daterangeQuery.' '.$assignto.' '.$mainwhere.' '.$searchByTourId.' '.$destination.' '.$priority.' '.$querystatus.' '.$queryDateDash.' '.$moduleTypes.' and deletestatus=0 ORDER BY queryOrder DESC, dateAdded DESC ';
						}
						if($searchField!='' || $tourIdsearchField!=''){
							$where = '';
							$where=' where 1 '.$mainwhere.' '.$searchByTourId.' and deletestatus=0  ORDER BY queryOrder DESC, dateAdded DESC ';
						}
						if($_GET['searchdate']!='' && $_GET['querystatus']==3 && $_GET['queryshow']==3){
							$where = ' where 1 and queryDate = "'.date('Y-m-d',strtotime($_GET['searchdate'])).'" and queryStatus=3 and deletestatus=0 ' ;
						}

						$page=$_GET['page'];
						// echo $where;
						$targetpage=$fullurl.'showpage.crm?module=query&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&queryshow='.$_REQUEST['queryshow'].'&searchdate='.$_REQUEST['searchdate'].'&daterange='.$_GET['daterange'].'&querystatus='.$_GET['querystatus'].'&thismonth='.$_REQUEST['thismonth'].'&';
						// echo $where;
						$rs=GetRecordList($select,_QUERY_MASTER_,$where,$limit,$page,$targetpage);
						$totalentry=$rs[1];
						$paging=$rs[2];
						$count=mysqli_num_rows($rs[0]);
						while($resultlists=mysqli_fetch_array($rs[0])){
						?>
						<tr <?php if($resultlists['queryStatus']==20){ ?>style="background-color: #fff2f2;"<?php } ?>>
							<td align="center" valign="middle" style=" width:30px;">
								<?php
								if($editpermission==1){
								if($resultlists['moduleType'] == 1){ ?>
								<i class="fa fa-pencil-square" aria-hidden="true" onclick="edit('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
								<?php }
								if($resultlists['moduleType'] == 2){ ?>
								<i class="fa fa-pencil-square" aria-hidden="true" onclick="editSeries('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
								<?php }
								if($resultlists['moduleType'] == 3){ ?>
								<i class="fa fa-pencil-square" aria-hidden="true" onclick="editFixDep('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
								<?php }
								if($resultlists['moduleType'] == 4){ ?>
								<i class="fa fa-pencil-square" aria-hidden="true" onclick="editPackage('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
								<?php }
							} ?></td>
							<script>
								function editSeries(id){
							setupbox('showpage.crm?module=series&edit=yes&id='+id+'');
							}
							function editFixDep(id){
							setupbox('showpage.crm?module=fixdeparture&edit=yes&id='+id+'');
							}
							function editPackage(id){
							setupbox('showpage.crm?module=package&edit=yes&id='+id+'');
							}
							</script>
								<td align="left">
									<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; " onclick="view('<?php echo encode($resultlists['id']); ?>&b2bquotation=1');"><?php echo makeQueryId($resultlists['id']); ?>
										<?php
										if(countQueryunreadMails($resultlists['id'])!=0){ ?><div class="numberbubbol" style=" left: 94px; top: -1px; margin-bottom: 3px;"><?php echo countQueryunreadMails($resultlists['id']); ?></div>
										<?php } ?>
										<?php
										if(countSupplierunreadMails($resultlists['id'])!=0){ ?><div class="numberbubbol" style="background-color:#359ec5;left: 94px; top: 22px; margin-bottom: 3px;"><?php echo countSupplierunreadMails($resultlists['id']); ?></div>
										<?php } ?>
									</div>
								</td>
								<td align="left">
									<?php if($resultlists['queryStatus']==3 && $resultlists['queryConfirmingDate']!='' || $resultlists['queryStatus']==20 && $resultlists['queryConfirmingDate']!=''){ ?>
									<div class="bluelink" style="position:relative; padding-right:10px; font-weight:500; color:#45b558 !important; " onclick="view('<?php echo encode($resultlists['id']); ?>&b2bquotation=1');" > <?php echo makeQueryTourId($resultlists['id']); ?> </div>
									<?php } ?>
									<?php if(trim($resultlists['referanceNumber'])!='' && strlen($resultlists['referanceNumber'])>0){ ?>
									<div style="" class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');">& <?php echo clean($resultlists['referanceNumber']); ?></div>
									<?php } ?>
								</td>
								<td align="left"><?php echo showClientType($resultlists['clientType']); ?></td>
								<td align="left"><?php if($resultlists['leadPaxName']!=''){ echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']).'<br>'.'<b>Lead Pax:</b>&nbsp;'.$resultlists['leadPaxName']; }else{ echo showagentNamewf($resultlists['clientType'],$resultlists['companyId']); } ?></td>
								<td align="left"><div style="width:66px;"><?php echo date('d-m-Y',$resultlists['dateAdded']); ?><br /><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('h:i:A',$resultlists['dateAdded']); ?></div></td>
								<td align="left" ><?php if($resultlists['dayWise']!=2) { echo showdate($resultlists['fromDate']); } ?></td>
								<td align="left" >
								<?php
								$dest='';
								$selectDest='*';
								$whereDest=' queryId='.$resultlists['id'].' and lastdeleted = 1 group by cityId order by srdate asc';
								$rsDest=GetPageRecord($selectDest,'packageQueryDays',$whereDest);
								while($resListingDest=mysqli_fetch_array($rsDest)){  $dest.= getDestination($resListingDest['cityId']).', ';  } echo rtrim($dest,', '); ?></td>
							<style>
							.pack{width: 80px;
							border: 1px solid;
							padding: 5px;
							text-align:center;
							border-radius: 3px;
							color: #33CC00;}
							.pack2{    width: 80px;
							border: 1px solid;
							padding: 4px;
							text-align:center;
							border-radius: 3px;
							color: #EC798D;}
							.pack3{    width: 80px;
							border: 1px solid;
							padding: 5px;
							text-align:center;
							border-radius: 3px;
							color: #EC797E;}
							</style>
							<td align="left" >
								<?php
								if($resultlists['travelType']==1){ ?>
								<div style="padding: 4px 10px;color: white;background: #9466be;border-radius: 3px;text-align: center;font-size: 14px;font-weight: 500;">International</div>
								<?php }else{ ?>
								<div style="padding: 4px 10px;color: white;background: #9466be;border-radius: 3px;text-align: center;font-size: 14px;font-weight: 500;">Domestic</div>
								<?php } ?>
							</td>
							
							<!-- <td align="left" style="display: none;">
								<?php
								if($resultlists['paxType']==1){ ?>
								<div style="padding: 4px 10px;color: white;background: #9466be;border-radius: 3px;text-align: center;font-size: 14px;font-weight: 500;">GIT</div>
								<?php }else{ ?>
								<div style="padding: 4px 10px;color: white;background: #9466be;border-radius: 3px;text-align: center;font-size: 14px;font-weight: 500;">FIT</div>
								<?php } ?>
							</td> -->
							<!-- <td align="center"  style="display: none;">
								<?php if($resultlists['queryStatus']<3 || $resultlists['queryStatus']==6 || $resultlists['queryStatus']==7){ if($resultlists["queryTimer"]>0){  echo makedatetime($resultlists["queryTimer"]); } else { echo '-'; } } else { echo '-'; }?>
							</td>  -->

							<td align="center"  >
								<div class=" <?php echo 'pack2'; ?>">
									<?php
									if($resultlists['queryType'] == 1){ ?>Query <?php }
									if($resultlists['queryType'] == 2){ ?>Series <?php }
									if($resultlists['queryType'] == 3){ ?>Fix Dep. <?php }
									if($resultlists['queryType'] == 4){ ?>Package <?php } 
									if($resultlists['queryType'] == 5){ ?>ChatBot <?php } 
									if($resultlists['queryType'] == 6){ ?>Transfer <?php } 
									if($resultlists['queryType'] == 7){ ?>Train <?php } 
									if($resultlists['queryType'] == 8){ ?>Flight <?php }
									if($resultlists['queryType'] == 9){ ?>VISA <?php }
									if($resultlists['queryType'] == 10){ ?>Insurance <?php } 
									if($resultlists['queryType'] == 11){ ?>Passport <?php } 
									if($resultlists['queryType'] == 13){ ?>Multi&nbsp;Services <?php } 
									if($resultlists['queryType'] == 14){ ?>Activity <?php } ?>
								</div>
								<?php if($resultlists['queryType'] == 13){
									$serviceName='';
									if($resultlists['needVisa']=='2'){ $serviceName=', Visa'; }
									if($resultlists['needInsurance']=='2'){ $serviceName.=', Insurance'; }
									if($resultlists['needFlight']=='2'){ $serviceName.=', Flight'; }
									if($resultlists['needTrain']=='2'){ $serviceName.=', Train'; }
									if($resultlists['needTransfer']=='2'){ $serviceName.=', Transfer'; }
									echo ltrim($serviceName,', ');
								  } ?>
							</td>
							<td align="center">
							<?php 
							$lead = GetPageRecord('name','leadssourceMaster','id="'.$resultlists['leadsource'].'" and status=1');
							$leadData = mysqli_fetch_assoc($lead);
							echo $leadData['name'];
							?></td>
							<td align="left" ><?php if($resultlists['queryPriority']==1 || $resultlists['queryPriority']==0){ ?><div class="lowpire">Low</div><?php } ?><?php if($resultlists['queryPriority']==2){ ?><div class="mediampire">Medium</div><?php } ?><?php if($resultlists['queryPriority']==3){ ?><div class="highpire">High</div><?php } ?></td>
							
							<td align="left" ><span class="badge badge-primary" style="background-color:#2bbbad;font-size: 13px;padding: 7px;"><?php echo getUserName($resultlists['assignTo']); ?></span></td>
							<td><?php echo getUserName($resultlists['salesPersonId']);?></td>
								
							<td align="center"style="width:50px;">
								<?php


									$gt = "";
									$gt = GetPageRecord('*','tmsBooking','queryId="'.$resultlists['id'].'" and queryStatus=11'); 
									$tmsData = mysqli_fetch_array($gt);

								if($resultlists['queryStatus']==6){ echo '<div class="assignquery">Quote&nbsp;Sent</div>'; }if($resultlists['queryStatus']==7){ echo '<div class="assignquery" style="background-color:#9466be;">Follow-up</div>'; }if($resultlists['queryStatus']==1 || $resultlists['queryStatus']==10){ if($resultlists['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; }  if($resultlists['queryStatus']==10){ echo '<div class="assignquery">Created</div>'; }} if($resultlists['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlists['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlists['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlists['queryStatus']==5){ echo '<div class="closequery" style="background-color:#a598d9;">Quotation Generated</div>'; }  if($resultlists['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; } if($resultlists['queryStatus']==20){ echo '<div class="lossquery">Cancelled</div>';}
								
								
								if($resultlists['queryStatus']==11){ echo '<div class="closequery" style="background-color:#613789;">TMS Closed </div>'; 

									// domesticE,domesticS,internationF,internationC,carB,hacH,domesticH,flightT,trainT,grp,pab,BookingId
									if($tmsData['domesticE']==1){
										echo '<b>'.'Domestic-EBK'.'</b><br>';
									}
									if($tmsData['domesticS']==1){
										echo '<b>'.'Domestic-SPL'.'</b><br>';
									}
									if($tmsData['internationF']==1){
										echo '<b>'.'Internation-Fixed Tour'.'</b><br>';
									}
									if($tmsData['internationC']==1){
										echo '<b>'.'Internation Customized'.'</b><br>';
									}
									if($tmsData['carB']==1){
										echo '<b>'.'Car Booking'.'</b><br>';
									}
									if($tmsData['hacH']==1){
										echo '<b>'.'HAC-Hotel'.'</b><br>';
									}
									if($tmsData['domesticH']==1){
										echo '<b>'.'Domestic Hotels'.'</b><br>';
									}
									if($tmsData['flightT']==1){
										echo '<b>'.'Flight Ticket'.'</b><br>';
									}
									if($tmsData['trainT']==1){
										echo '<b>'.'Train Ticket'.'</b><br>';
									}
									if($tmsData['grp']==1){
										echo '<b>'.'GRP'.'</b><br>';
									}
									if($tmsData['pab']==1){
										echo '<b>'.'PAB'.'</b><br>';
									}

								} 
								
								



								
								?>
								
								<?php
								//  if($resultlists['queryStatus']==20){
								?>
								<!-- <div class="lossquery">Cancelled</div> -->
								<?php
								// } else {
								?>
								<?php
								// $result =mysqli_query (db(),"select * from "._PAYMENT_REQUEST_MASTER_." where queryid='".$resultlists['id']."' and deletestatus!=1")  or die(mysqli_error(db()));
								// $number =mysqli_num_rows($result);
								// $getpaymentid=mysqli_fetch_array($result);
								// if($number>0)
								// {
								?>
								<?php /*?><div class="wonquery" <?php if($getpaymentid['status']==0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['status']==0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div><?php */?>
								<!-- <div class="wonquery" <?php if($getpaymentid['supplierPendingamount']>0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['supplierPendingamount']>0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div> -->
								<?php
								//  } else {
								?>
								<?php
								// if($resultlists['queryStatus']==6){ echo '<div class="assignquery">Quote&nbsp;Sent</div>'; }if($resultlists['queryStatus']==7){ echo '<div class="assignquery" style="background-color:#9466be;">Follow-up</div>'; }if($resultlists['queryStatus']==1 || $resultlists['queryStatus']==10){ if($resultlists['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; }  if($resultlists['queryStatus']==10){ echo '<div class="assignquery">Created</div>'; }} if($resultlists['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlists['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlists['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlists['queryStatus']==5){ echo '<div class="closequery">Time Limit Booking</div>'; }  if($resultlists['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?>
								<?php
								//  }
								// ?>
								<?php
								//  }
								?>
							</td>
						</tr>
						<?php $no++; } ?>
						<script>
						$(document).ready(function(){
						$('#totalQuery').text('<?php echo $totalentry;?>');
						});
						</script>
					</tbody></table>
					<?php if($no==1){ ?>
					<div class="norec">No <?php echo $pageName; ?></div>
					<?php } ?>
					<div class="pagingdiv">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tbody><tr>
								<td><table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
										<!-- onchange="this.form.submit();" -->
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
				</div></form>	</td>
			</tr>
		</table>
		<script type="text/javascript">
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
		<?php //include "loadmail.php"; ?>
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
		$(document).ready(function() {
		$('#mainsectiontable').DataTable({
		"paging":   false,
		"ordering": true,
		"info":     true,
		dom: 'frtilB',
		buttons: [
		{extend: 'copyHtml5', title: 'TravCRM Query'},
		{extend: 'excelHtml5', title: 'TravCRM Query'},
		{extend: 'pdfHtml5', title: 'TravCRM Query',
			orientation: 'landscape',
			pageSize: 'A3'
		}
		],
		language: { 
    search: "Tour Id: ",
    searchPlaceholder: "Search By Keyword",
},
		} );
		} );
		</script>
		<style>
		.topsearchfiledmain, .topsearchfiledmainselect{
		padding: 12px !important; border-radius: 3px !important;padding-right: 20px !important;font-size: 12px;
		}
		
		.fg-button{
		background: #cccccc;
		border-radius: 3px;
		color: #000000 !important;
    	font-weight: 500;
		}


		.dt-buttons{
			width: 330px;
			margin: 30px auto;
		}
		.buttons-html5 {
		padding: 8px 20px 8px 15px;
		border-radius: 50px;
		cursor: pointer;
		font-size: 15px;
    	font-weight: 600;
		margin-right: 13px;
	}

	.buttons-html5:hover {
		background-color: #b8b8bb !important;
	}
	.buttons-copy::before {
		font-family: 'Font Awesome 5 Free';
		/* content: "\f24d"; */
		font-weight: 900;
		padding-right: 6px;
	}

	.buttons-excel::before {
		font-family: 'Font Awesome 5 Free';
		/* content: "\f019"; */
		font-weight: 900;
		padding-right: 6px;
	}

	.buttons-pdf::before {
		font-family: 'Font Awesome 5 Free';
		/* content: "\f1c1"; */
		font-weight: 900;
		padding-right: 6px;
	}
	#mainsectiontable_filter{
		display: none !important;
	}

</style>
