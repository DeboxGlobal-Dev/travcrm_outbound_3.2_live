<?php 
include "inc.php";   
if($_REQUEST['action'] == 'generateTourDays' ){

 	$queryId=trim(decode($_REQUEST['queryId']));
 	$quotationId=trim($_REQUEST['quotationId']);
	$isEditable = $_REQUEST['isEditable'];
	
	
	
		$fromDate=date("Y-m-d", strtotime($_REQUEST['fromDate'])); 
		$toDate=date("Y-m-d", strtotime($_REQUEST['toDate']));
		$objec=date_diff(date_create($fromDate),date_create($toDate));
		$night = $objec->format("%a");
	
$newDays = GetPageRecord('id','newQuotationDays','queryId="'.$queryId.'" and quotationId="'.$quotationId.'"');
$newDaysData = mysqli_num_rows($newDays);

if($newDaysData == 0){
	$begin = new DateTime( $fromDate );
	$end   = new DateTime( $toDate );
	$day = 1; 
	for($i = $begin; $i <= $end; $i->modify('+1 day')){  
		$date = $i->format("Y-m-d"); 	
			$namevalue ='srdate="'.$date.'",srn="'.$day.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'"';  
			$lastId = addlistinggetlastid('newQuotationDays',$namevalue);					
		
		$day++;
	}  
}
	?>
	<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#DDD" class="daysbox" >
	<thead>
		<tr>
	<th width="15%">Sr.No.</th>
	<th width="30%" >Date/Day</th>
	<th width="40%" align="center">Destination</th>
	<th width="15%" align="center">&nbsp;</th>
	</tr>
	</thead>
	<tbody class="row_drag">
	<?php
	$day = 1; 
	$rs1="";
	$rs1=GetPageRecord('*','newQuotationDays','queryId="'.$queryId.'" and quotationId="'.$quotationId.'" order by srdate asc'); 
	while($packageQueryData=mysqli_fetch_array($rs1)){
		if($_REQUEST['quotationId'] != '' && isset($_REQUEST['quotationId'])){
			$date = date('d-m-Y /D', strtotime('+'.($day-1).' day', strtotime($fromDate)));
		}else{
			$date = date('d-m-Y /D',strtotime($packageQueryData["srdate"])); 
		}
		$pqId= $packageQueryData["id"]; 
		$cityId= $packageQueryData["cityId"]; 
		
		?>
		<tr class="row<?php echo $pqId; ?>">
		<th><span class="standardC">Day&nbsp;<?php echo $day; ?></span></th>
		<th><span class="standardC"><?php echo $date; ?></span></th>
		<th> 
			<input type="hidden" value="dayId<?php echo $pqId; ?>" name="dayId<?php echo $pqId; ?>" />
			<?php if($isEditable == 1){ ?>
			<select id="cityId<?php echo $pqId; ?>" name="destinationId[]" class=" validate selectBoxDest"  onChange="saveDayCityId(<?php echo $pqId; ?>);" displayname="'Day&nbsp;<?php echo $day; ?>' City Name"  >
			<option value="">Select City</option>
			<?php 
			$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
			while($resListing=mysqli_fetch_array($rs)){  
			?><option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$cityId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option><?php } ?>
			</select>
			<?php } else{ ?>
			<span class="standardC"><?php echo getDestination($cityId); ?></span>	
			<?php } ?>
		</th>
		<th align="left"> 
			<?php if($isEditable == 1){ ?>
			<a class="moveBtn del-row-btn" onclick="deleteTourDay('<?php echo $pqId; ?>');" ><i class="fa fa-trash" style="color: #F44336;"></i></a>
			<?php } ?>
		</th>
		</tr>
		<?php 
		$day++;	
	}
	?>
	</tbody>
	</table> 
	<div id="loadTourDaysAction" style="display:none;"></div>
	<link rel="stylesheet" href="css/selectize.css"> 
	<script src="js/jquery-1.11.3.min.js?id=<?php echo time();?>"></script>  
 	<script type="text/javascript" src="js/selectize.js"></script>
 	<script type="text/javascript">  
		$('.selectBoxDest').selectize();
		//$('.selectBoxDest').select2(); 
		function saveDayCityId(dayId){ 
			var cityId = $('#cityId'+dayId).val();
			if(cityId > 0 && dayId > 0){
				//load page
				$('#loadTourDaysAction').load('query_frmaction.php?action=saveTourDay&queryId=<?php echo $queryId;?>&dayId='+dayId+'&cityId='+cityId);
			}else{
				$('#cityId'+dayId).css('border-color','#ec0707');
			}
			return false; 
		}
		
		function deleteTourDay(dayId){ 
			if(dayId > 0){
				//load page
				$('#loadTourDaysAction').load('query_frmaction.php?action=deleteTourDay&queryId=<?php echo $queryId;?>&dayId='+dayId);
			}else{
				//$('#row'+dayId).css('border-color','#ec0707');
			}
			return false; 
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
		margin-left: 15px;
		
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
