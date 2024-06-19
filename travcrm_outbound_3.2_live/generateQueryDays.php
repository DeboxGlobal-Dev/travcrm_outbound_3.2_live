<?php 
include "inc.php";   
if($_REQUEST['action'] == 'generateQueryDays' ){

 	$queryId=trim($_REQUEST['queryId']);
	$dayWise = $_REQUEST['dayWise'];
 	$seasonType = $_REQUEST['seasonType'];
	$seasonYear = $_REQUEST['seasonYear'];
	$isEditable = $_REQUEST['isEditable'];
	
	
	
	if(trim($_REQUEST['dayWise']) == 1){
		$fromDate=date("Y-m-d", strtotime($_REQUEST['fromDate'])); 
		$toDate=date("Y-m-d", strtotime($_REQUEST['toDate']));
		$objec=date_diff(date_create($fromDate),date_create($toDate));
		$night = $objec->format("%a");
	}else{ 
		$quotSql="";
		$quotSql=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['quotationId']).'"  ');  
		if(mysqli_num_rows($quotSql)>0 ){ 
			$quotationData=mysqli_fetch_array($quotSql);
			 
			$dayWise = 2;
			$fromDate=date("Y-m-d", strtotime($quotationData['fromDate'])); 
			$toDate=date("Y-m-d", strtotime($quotationData['toDate']));
			$objec=date_diff(date_create($fromDate),date_create($toDate));
			$night = $objec->format("%a"); 
		} else{
			//for day wise query
			$night = $_REQUEST['nights'];
			if($seasonType == 1 || $seasonType == 3){ 
				$seasonDate = $seasonYear;
				if($seasonYear == date('Y')){
					$fromDate = date('Y-m-d',strtotime($seasonDate)); 
				}else{
					$fromDate = date('Y-04-01',strtotime($seasonDate)); 
				}
				$toDate = date("Y-m-d", strtotime("+".$night." days", strtotime($fromDate))); 
			}else{  
				$fromDate = date('Y-10-01',strtotime($seasonYear."-01-01"));
				$toDate = date("Y-m-d", strtotime("+".$night." days", strtotime($fromDate))); 
			} 
		}
	}
	$rschk="";
	$rschk=GetPageRecord('id,moduleType',_QUERY_MASTER_,' id="'.$queryId.'" order by id asc');  
	if(mysqli_num_rows($rschk)>0  && $isEditable == 1){ 
		//$queryData=mysqli_fetch_array($rschk);  
		updatelisting(_QUERY_MASTER_,'fromWebsite=1,fromDate="'.$fromDate.'",toDate="'.$toDate.'",night="'.$night.'"','id="'.$queryId.'"');
	}

	$begin = new DateTime( $fromDate );
	$end   = new DateTime( $toDate );
	$day = 1; 
	for($i = $begin; $i <= $end; $i->modify('+1 day')){  
		$date = $i->format("Y-m-d"); 
		$rschk2="";
		$rschk2=GetPageRecord('*','packageQueryDays',' queryId="'.$queryId.'" and srdate="'.$date.'"');  
		if( mysqli_num_rows($rschk2) < 1 && $isEditable == 1 && $_REQUEST['quotationId'] == ''){
			$packQueryData = mysqli_fetch_array($rschk2);
			$namevalue ='lastdeleted=1,srdate="'.$date.'",srn="'.$day.'",queryId="'.$queryId.'",packageId="'.$queryId.'"';  
			$lastId = addlistinggetlastid('packageQueryDays',$namevalue);					
		}
		$day++;
	}  
	?>
	<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#DDD" class="daysbox" >
	<thead>
	<tr>
			<td align="right" colspan="5">
			<input name="addnewuserbtn" type="button" class="bluembutton" style="border-radius: 3px;background: #3c993c !important;" id="addnewuserbtn" value="+ Add Destination" onClick="masters_alertspopupopen('action=addedit_querydestinationFromQuery&sectiontype=querydestination&queryDashboard=yes','900px','auto');" />

			
			</td>
		</tr>
	<tr>
	<th width="10%">Sr.No.</th>
	<?php if($dayWise == 1){ ?> <th width="25%" >Date/Day</th><?php } ?>
	<th width="28%" align="center">Country</th>
	<th width="32%" align="center">Destination</th>
	<th width="5%" align="center">&nbsp;</th>
	</tr>
	</thead>
	<tbody class="row_drag">
	<?php
	$day = 1; 
	$rs1="";
	$rs1=GetPageRecord('*','packageQueryDays','queryId="'.$queryId.'" order by srdate asc'); 
	while($packageQueryData=mysqli_fetch_array($rs1)){
		if($_REQUEST['quotationId'] != '' && isset($_REQUEST['quotationId'])){
			$date = date('d-m-Y/D', strtotime('+'.($day-1).' day', strtotime($fromDate)));
		}else{
			$date = date('d-m-Y/D',strtotime($packageQueryData["srdate"])); 
		}
		$pqId= $packageQueryData["id"]; 
		$cityId= $packageQueryData["cityId"]; 
		
		?>
		<tr class="row<?php echo $pqId; ?>">
		<th><span class="standardC">Day&nbsp;<?php echo $day; ?></span></th>
		<?php if($dayWise == 1){ ?><th><span class="standardC"><?php echo $date; ?></span></th><?php } ?>
		<!-- country -->
		<th> 
			<input type="hidden" value="dayId<?php echo $pqId; ?>" name="dayId<?php echo $pqId; ?>" />
			<?php if($isEditable == 1){ ?>
				<div class="griddiv" style="margin: 0px !important;"><label>
					<div class="gridlable" style="display: block !important;"><span class="redmind"></span></div>
					<select id="destCountryId<?php echo $pqId; ?>" name="destCountryId[]" class=" validate"  onChange="getDestinationCity(<?php echo $pqId; ?>);" onload="getSelectedDestination<?php echo $pqId; ?>()" displayname="'Day&nbsp;<?php echo $day; ?>' Country Name" style="width: 100%;padding: 4px;border-radius: 2px;border-color: #ccc;color:#423e3e; font-weight:500;"  >
						<option value="All">All</option>
						<?php 
						$rs=GetPageRecord('*',_COUNTRY_MASTER_,' deletestatus=0 and id in ( select countryId from destinationMaster where status=1 and deletestatus=0 ) and status=1 order by name asc'); 
						while($resListing=mysqli_fetch_array($rs)){  
						?><option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['setDefault']=='1'){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option><?php } ?>
					</select>
				</label>
				</div>
				<?php 
			} else{ ?> 
				<span class="standardC"><?php echo getCountryName(getCountryIdByDestinationId($cityId)); ?></span>
				<?php
			} 
			?>
		</th>
		<!-- destination -->
		<th> 
			<input type="hidden" value="dayId<?php echo $pqId; ?>" name="cityId<?php echo $pqId; ?>" />
			<?php if($isEditable == 1){ ?>
			<div class="griddiv" style="margin: 0px !important;"><label>
				<div class="gridlable" style="display: block !important;"><span class="redmind"></span></div></label>
				<select id="cityId<?php echo $pqId; ?>" name="destinationId[]" class="validate  gridfield"  onChange="saveDayCityId(<?php echo $pqId; ?>);" displayname="'Day&nbsp;<?php echo $day; ?>' City Name"  >
					<option value="">Select City</option>	
					<?php 
					$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
					while($resListing=mysqli_fetch_array($rs)){  
					?><option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$cityId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option><?php } ?>
				</select>
			</div>
			<?php } else{ ?>
			<span class="standardC"><?php echo getDestination($cityId); ?></span>	
			<?php } ?>
		</th>
		<th align="left"> 
			<?php if($isEditable == 1){ ?>
		<!--<a class="moveBtn drag-handler"><i class="fa fa-arrows-alt" style="color:#CCCCCC;transform: rotate(45deg);"></i></a>
			<a class="moveBtn add-row-btn" data-dayId="<?php echo $pqId; ?>" data-date="<?php echo date('Y-m-d',strtotime($packageQueryData["srdate"])); ?>" ><i class="fa fa-plus" style="color: #4caf50;"></i></a>
		-->	 
			<a class="moveBtn del-row-btn" onclick="deleteQueryDay('<?php echo $pqId; ?>');" ><i class="fa fa-trash" style="color: #F44336;"></i></a>
			<?php } ?>
		</th>
		</tr>

		<!-- hide for destination refrace -->
		<!-- <script>
			let getSelectedDestination<?php echo $pqId; ?>=()=>{
			var destCountryId = $('#destCountryId<?php echo $pqId; ?>').val();
		$('#cityId<?php echo $pqId; ?>').load('query_frmaction.php?action=getDestinationCities&queryId=<?php echo $queryId;?>&dayId=<?php echo $pqId; ?>'+'&CountryId='+destCountryId);
		}
		getSelectedDestination<?php echo $pqId; ?>();
		</script> -->
		<?php 
		$day++;	
	}
	?>
	</tbody>
	</table> 
	<div id="loadQueryDaysAction" style="display:none;"></div>
	<link rel="stylesheet" href="css/selectize.css"> 
	<script src="js/jquery-1.11.3.min.js?id=<?php echo time();?>"></script>  
 	<script type="text/javascript" src="js/selectize.js"></script>
 	<script type="text/javascript">  
		$('.selectBoxDest').selectize();
		//$('.selectBoxDest').select2(); 
		
		let getDestinationCity=(dayId)=>{
		
		var destCountryId = $('#destCountryId'+dayId).val();
		$('#cityId'+dayId).load('query_frmaction.php?action=getDestinationCities&queryId=<?php echo $queryId;?>&dayId='+dayId+'&CountryId='+destCountryId);
	}
		
	


	// window.onload() = function getDestinationCity(dayId){
	// 	var destCountryId = $('#destCountryId'+dayId).val();
	// 	$('#cityId'+dayId).load('query_frmaction.php?action=getDestinationCities&queryId=<?php echo $queryId;?>&dayId='+dayId+'&CountryId='+destCountryId);
	// }

	

		function saveDayCityId(dayId){ 
			var cityId = $('#cityId'+dayId).val();
			if(cityId > 0 && dayId > 0){
				//load page
				$('#loadQueryDaysAction').load('query_frmaction.php?action=saveQueryDay&queryId=<?php echo $queryId;?>&dayId='+dayId+'&cityId='+cityId);
			}else{
				$('#cityId'+dayId).css('border-color','#ec0707');
			}
			return false; 
		}
		
		function deleteQueryDay(dayId){ 
			if(dayId > 0){
				//load page
				$('#loadQueryDaysAction').load('query_frmaction.php?action=deleteQueryDay&queryId=<?php echo $queryId;?>&dayId='+dayId);
			}else{
				//$('#row'+dayId).css('border-color','#ec0707');
			}
			return false; 
		}
					
		function addDayToDate(no_of_days,date_string){
			var someDate = new Date(date_string);
			someDate.setDate(someDate.getDate() + no_of_days); 
			someDate.setTime(someDate.getTime() + (330 * 60 * 1000));
			var findate = someDate.toISOString().substr(0,10);
			return findate;
		}
	</script>
	<style>
	.select2-dropdown--below {
		margin-top: -33px !important;
		border-radius: 4px !important;
	} 
	.del-row-btn{
		display:none;
	}
	.moveBtn{ 
		cursor:pointer;
		padding:3px;
		color:#423e3e;
		font-weight:normal;
		border-radius:2px; 
		margin-left: 1px;
		
	}
	table.daysbox  tr:last-of-type th:last-of-type .del-row-btn{ 
		display:block;
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

}
?>
