<?php
include "inc.php";   

$dayQuery=GetPageRecord('*','newQuotationDays',' id="'.$_REQUEST['dayId'].'"');
$dayData = mysqli_fetch_array($dayQuery);
 

$destinationId = getDestination($_REQUEST['destinationId']);
$defaultWise = trim($_REQUEST['defaultWise']);

$queryId = $dayData['queryId'];
$dayId = $dayData['id'];
$quotationId = $dayData['quotationId'];  
 $fromDate=date("Y-m-d", strtotime($dayData['srdate']));
$fromYear=date("Y", strtotime($dayData['srdate']));
$toDate=date("Y-m-d", strtotime($dayData['srdate'])); 
$toYear=date("Y", strtotime($dayData['srdate']));

$enrouteQuery = "";
if($_REQUEST['enrouteId']!='' && $_REQUEST['enrouteId']!=0 ){
	$enrouteQuery = " and id = '".$_REQUEST['enrouteId']."'";
}
if($defaultWise == 2){
	$isDefault = '';
    }
    if($defaultWise == 1){
	$isDefault = ' and isDefault=1';
   }
 
$routQuery = GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' enrouteCity="'.$destinationId.'" '.$isDefault.' '.$enrouteQuery.' and status=1 and deletestatus=0 order by id desc'); 
	?>
 	<div style="font-size:16px; padding:10px;position:relative" >
		<span id="enroutecounding"> 0 Enroute Found </span>  
		<div class="addBtn" onclick="openinboundpop('action=addenroutetomaster&dayId=<?php echo $dayId; ?>','800px');">+&nbsp;Add New</div>
	</div> 
	<div style="background-color:#feffbc; padding:0px; display:none;" id="loadenroutesaveenroute" ></div>
	<div style="padding:10px; border:1px #e3e3e3 solid; background-color: #fff; margin-bottom:10px;" id="sicbox">
 		<div class="topaboxlist"  style="max-height: 300px; overflow: auto;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable"  id="enroutesicTable">
			<thead>
				<tr>
					<th align="left"  >Enroute Name</th>
					<th align="center" >Per&nbsp;Pax&nbsp;Cost</th>
					<th align="center" >&nbsp;</th>
				</tr>
			</thead>  
			<tbody>
			<?php
			$c1=1; 
			while($enrouteData = mysqli_fetch_array($routQuery)){   ?>
			  <tr> 
				<td align="left"><?php  
				echo ucfirst($enrouteData['enrouteName']);  
				$select2='name';  
				$where2='setDefault=1'; 
				$rs2=GetPageRecord($select2,_QUERY_CURRENCY_MASTER_,$where2); 
				$editresult2=mysqli_fetch_array($rs2); 
				$cur=clean($editresult2['name']);  
				?></td>
				<td align="center"><?php echo $cur; ?>&nbsp;<?php echo strip($enrouteData['adultCost']); ?></td>
				<td align="center"><div class="editbtnselect" onclick="addenroutetoquotations('<?php echo $enrouteData['id']; ?>','<?php echo $_REQUEST['destinationId']; ?>');" id="selectthis<?php echo $enrouteData['id']; ?>"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp;Select</div></td>
			  </tr>  
				<?php 
				$c1++;
			} ?>
			</tbody>
			</table>
		<script>
			function selectthis(ele){
				$(ele).html('Selected');
				$(ele).removeAttr('onclick');
				$(ele).css('background-color','#d88319');
			}
			  
		</script>
		</div>  
		<?php if($c1==1 ){ ?>
		<script>
		$('#sicbox').hide();
		$('#sicbox').append('<div style="text-align:center;">No Enroute Found</div>');
		</script>
		<?php } else{ ?> 
		<script>
		$('#enroutecounding').text('<?php echo $c1-1;?> Enroute Found');
		</script>
		<?php } ?> 
	</div>
	<style>
	.editbtnselect{    
		border: 1px solid;
		padding: 8px 15px;
		text-align: center;
		font-size: 13px;
		border-radius: 3px;
		background-color: #4caf50;
		cursor: pointer;
		color: #fff;
	}
	</style>	  
