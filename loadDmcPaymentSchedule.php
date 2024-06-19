<?php
include "inc.php";

$quotQuery="";
$quotQuery=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($quotQuery);

$queryQuery='';    
$queryQuery=GetPageRecord('*',_QUERY_MASTER_,'id='.clean($quotationData['queryId']).''); 
$queryData=mysqli_fetch_array($queryQuery); 

$quotationId = $quotationData['id'];
$queryId = $quotationData['queryId'];
 
$companyName = showClientTypeUserName($queryData['clientType'],$queryData['companyId']);
$pageTitle =  $companyName;

$totalCost = 0;
$paid = 0;
$totalPending=0; 

// finalQuote
$prmQuery=GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,' quotationId="'.$quotationData['id'].'" ');
$prmData=mysqli_fetch_array($prmQuery);

// scheduletalbe
$paymentId = $prmData['id'];
$totalCost = $prmData['totalClientCost'];
 

$r2='';
$r2=GetPageRecord('sum(amount) as totalAmount,ssp.*','agentSchedulePaymentMaster ssp','paymentId="'.$paymentId.'" and amount!="" and value!=""');
$schedulePaymentNum = mysqli_num_rows($r2);
$schedulePaymentData = mysqli_fetch_array($r2);
$remainAmount = $totalCost-$schedulePaymentData['totalAmount'];	
if($schedulePaymentNum > 0){
	
	$r3=GetPageRecord('sum(amount) as totalpaid, spm.*','agentPaymentMaster spm',' paymentId="'.$paymentId.'" and paymentStatus=1'); 
	$agentPaymentData = mysqli_fetch_array($r3);
	$paid = ($agentPaymentData['totalpaid']==0)?0:$agentPaymentData['totalpaid'];
	
	$remainValue = round(($remainAmount/$totalCost*100),2);
	if($schedulePaymentData['totalAmount'] < $totalCost  && $remainAmount > 0){
		$namevalue1 ='type=1,status=1,dueDate="'.date('Y-m-d').'",value="'.$remainValue.'",amount="'.$remainAmount.'",paymentId="'.$paymentId.'",quotationId="'.$quotationId.'"';
		$scheduleId2 = addlistinggetlastid('agentSchedulePaymentMaster',$namevalue1); 
	}	
}else{	
	$namevalue ='type=1, value=100, status=1, dueDate="'.date('Y-m-d').'", amount="'.$totalCost.'", paymentId="'.$paymentId.'",quotationId="'.$quotationId.'"';
	$scheduleId = addlistinggetlastid('agentSchedulePaymentMaster',$namevalue); 
}
$totalPending = $totalCost-$paid;  
				 
?>
<h1 style="text-align:left;position:relative;"><?php echo $pageTitle; ?><a onClick="masters_alertspopupopenClose();calculateclientPaymentRequest('na');" class="closeBtn">x</a></h1>
<div id="contentbox" class="addeditpagebox" style="  padding:1px 0px 0px; overflow:auto; text-align:left; margin-bottom:0px; " >
	<?php 
	$cnt2=1;
	$r31=="";
	// echo 'scheduleId in ( select id from agentSchedulePaymentMaster where 1 and paymentId="'.$paymentId.'"  ) and paymentStatus=1';
	$r31=GetPageRecord('*','agentPaymentMaster',' scheduleId in ( select id from agentSchedulePaymentMaster where 1 and paymentId="'.$paymentId.'"  ) and paymentStatus=1'); 
	if(mysqli_num_rows($r31) > 0){
	?>
	<div class="paidList">
		<table width="100%" cellpadding="3" cellspacing="0" border="1" style="border-color: #ddd;" class="table-strip ">
		<thead> 
		<tr>
		<th><strong>SR.&nbsp;NO.</strong></th>
		<th><strong>Payment Type</strong></th>
		<th><strong>Amount</strong></th>
		<th><strong>Payment&nbsp;Through</strong></th>
		<th><strong>Transaction Id/Cheque No.</strong></th>
		<th><strong>Remarks</strong></th>
		<th><strong>Status</strong></th>
		<th><strong>Action</strong></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		while($agentPaymentDataList = mysqli_fetch_array($r31)){
			$r212=GetPageRecord('*','agentSchedulePaymentMaster','id="'.$agentPaymentDataList['scheduleId'].'"'); 
			$agentSchedulePayData2 = mysqli_fetch_array($r212);
		?>
		<tr>
		<td><?php echo $cnt2; ?></td>
		<td><?php if($agentPaymentDataList['paymentType'] == 1){ echo "On Credit"; }elseif($agentPaymentDataList['paymentType'] == 2){ echo "Advanced";  }elseif($agentPaymentDataList['paymentType'] == 3){ echo "Direct&nbsp;Payment";  }else{ echo "Full Payment"; } ?></td>
		<td><?php echo $agentPaymentDataList['amount'];?></td>
		<!-- added by agent payment Through  -->
		<td>
			<?php 
			$rsMkt2=GetPageRecord('name','paymentTypeMaster',' id="'.$agentPaymentDataList['paymentBy'].'"');
		  	$resMarkt2=mysqli_fetch_array($rsMkt2);
			echo$resMarkt2['name'];   ?>
		</td>
		<td><?php echo $agentPaymentDataList['chequeNo'];?></td>
		<td><?php echo $agentPaymentDataList['remark'];?></td>
		<td><?php if($agentPaymentDataList['paymentStatus'] == 1){ echo "Paid"; }else{ echo "....";} ?></td>
		<td><input type="button" value="Payment Receipt" onclick="openPaymentReceipt('openpaymentreceipt','850px','<?php echo $agentSchedulePayData2['quotationId']; ?>','<?php echo $agentSchedulePayData2['id']; ?>','<?php echo $queryData['id']; ?>');" style="cursor: pointer;"></td>
		</tr>
		<?php
		$cnt2++;
		}
		?>
		</tbody> 
		</table>
		<br>
	</div> 
	<?php
	}
	?>
	<div class="totalCost">
		<div style="width: 68px;" class="tm"><strong>Total&nbsp;Amount<br><?php echo $totalCost; ?></strong></div>
		<div style="width: 38px;" class="tm"><strong>Paid<br><?php echo $paid; ?></strong></div>
		<div style="width: 48px;" class="tm"><strong>Pending<br><?php echo $totalPending; ?></strong></div>
		<!-- <div style="width: 80px; margin-left: 10px; float: right; background-color: #b7b7b7; color: #233a49;" class="tm"><strong>Payment&nbsp;Terms<br><?php echo $paymentTerms; ?></strong></div> -->
		<div style="width: 260px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 0 10px;border: 0;" class="tm">
		
		
		<div style="width: 260px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 0 10px;border: 0;" class="tm">
		<div style="width: 260px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 3px 10px;border: 0;" class="tm">
		<?php 
		$a=GetPageRecord('*','agentSchedulePaymentMaster',' paymentId="'.$paymentId.'" and quotationId = "'.$quotationId.'" and scheduleStatus=1 order by id asc'); 
		if(mysqli_num_rows($a)>0){
		$SchedulePayData = mysqli_fetch_array($a);
	 	?>
		<a target="_blank" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id']); ?>&quotationId=<?php echo encode($quotationId); ?>&scheduledAmount=yes&paymentId=<?php echo encode($SchedulePayData['paymentId']); ?>"><input type="button" value="Send&nbsp;Scheduled&nbsp;Payment" class="updatePaymentBtn" style="display:inline;" /></a>
			<?php } ?>
		</div>
		</div>
		</div>
	</div> 
	<div id="loadDmcPayment" style="display:none;"></div>
	<div class="schedulebox" >
	<table   width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
		<thead>
		<tr>
			<td width="2%"><strong>#</strong></td>
			<td width="5%"><strong>Type</strong></td>
			<td width="10%"><strong>Payment Type</strong></td>
			<td width="10%"><strong>Value</strong></td>
			<td width="15%"><strong>Amount</strong></td>
			<td width="10%"><strong>Due&nbsp;Date</strong></td>
			<td width="10%"><strong>Due&nbsp;Time</strong></td>
			<td width="12%"><strong>Remark</strong></td>
			<td width="15%" colspan="3"><strong id="updateMsg" style="color:#006600;">&nbsp;</strong></td>
		</tr>
		</thead>
		<tbody> 
		<?php 
		$cnt = 1;
		$r21="";
		
		$r21=GetPageRecord('*','agentSchedulePaymentMaster',' paymentId="'.$paymentId.'" and quotationId = "'.$quotationId.'" and id not in ( select scheduleId from agentPaymentMaster where paymentId="'.$paymentId.'" and paymentStatus=1 ) and value>0 order by id asc'); 
		while($agentSchedulePayData = mysqli_fetch_array($r21)){

			if($agentSchedulePayData['dueDate'] == "0000-00-00"){ $dueDate = date("Y-m-d"); }else{ $dueDate = date('Y-m-d',strtotime($agentSchedulePayData['dueDate'])); }
			if($agentSchedulePayData['dueTime'] == "00:00:00"){ $dueTime = date('H:i'); }else{ $dueTime = date('H:i',strtotime($agentSchedulePayData['dueTime'])); }
			//echo $dueDate;
		?>
		<tr>
			<td><strong><?php echo $cnt; ?></strong></td>
			<td align="center">
				<select id="type<?php echo $agentSchedulePayData['id']; ?>" onchange="calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(1);" name="type<?php echo $agentSchedulePayData['id']; ?>" class="paycl gstInput" autocomplete="off" >  
				  <option value="1" <?php if($agentSchedulePayData['type'] == 1){ ?> selected="selected" <?php } ?>>%</option>  
				  <option value="2" <?php if($agentSchedulePayData['type'] == 2){ ?> selected="selected" <?php } ?>>Flat</option> 
				</select>
			</td>
			<td align="right">
				<select id="paymentType<?php echo $agentSchedulePayData['id']; ?>" name="paymentType<?php echo $agentSchedulePayData['id']; ?>" class="paycl inputText" >  
					<option value="1" <?php if($agentSchedulePayData['paymentType'] == 1){ ?> selected="selected" <?php } ?>>On Credit</option>
					<option value="2" <?php if($agentSchedulePayData['paymentType'] == 2){ ?> selected="selected" <?php } ?>>Advanced Payment</option>
					<option value="3" <?php if($agentSchedulePayData['paymentType'] == 3){ ?> selected="selected" <?php } ?>>Direct&nbsp;Payment</option>
					<option value="0" <?php if($agentSchedulePayData['paymentType'] == 4){ ?> selected="selected" <?php } ?>>Full Payment</option>
				</select>
			</td>
			<td align="center">
				<input type="text" class="paycl inputText" name="value<?php echo $agentSchedulePayData['id']; ?>" id="value<?php echo $agentSchedulePayData['id']; ?>" value="<?php echo round($agentSchedulePayData['value']);  ?>" maxlength="20" displayname="Amount Value" onKeyUp="calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(2);" autocomplete="off" style="text-align:right;width:95%!important;">
			</td>
			<td align="center"><input  type="text" class="paycl inputText" name="amount<?php echo $agentSchedulePayData['id']; ?>" id="amount<?php echo $agentSchedulePayData['id']; ?>" value="<?php echo round($agentSchedulePayData['amount']); ?>" maxlength="20" autocomplete="off" disabled style="text-align:right;width:95%!important;"></td>
			
			<td align="center"> <input type="date" class="gridfield inputText" id="dueDate<?php echo $agentSchedulePayData['id']; ?>" name="dueDate<?php echo $agentSchedulePayData['id']; ?>" value="<?php echo $dueDate;?>" style="text-align:left;width:95%;padding: 3px;border-radius: 2px;" ></td>
			
			<td align="center"><input type="time" name="dueTime<?php echo $agentSchedulePayData['id']; ?>" id="dueTime<?php echo $agentSchedulePayData['id']; ?>" class="inputText" value="<?php echo $dueTime; ?>" min="10:00" max="18:00" style="text-align:left;width:90%;padding: 3px;border-radius: 2px;"></td>

			<td align="center"><textarea name="remarks<?php echo $agentSchedulePayData['id']; ?>" class="paycl inputText" id="remarks<?php echo $agentSchedulePayData['id']; ?>" style="height: 16px;"><?php echo $agentSchedulePayData['remarks']; ?></textarea></td>

			<td align="left"> 
				<input name="button" type="button" class="updatePaymentBtn" onclick="savePartial<?php echo $agentSchedulePayData['id']; ?>();" value="<?php if($agentSchedulePayData['paymentType']>0) echo 'Saved'; else echo 'Save'; ?>" style="display:inline; background-color: #233a49;" />	 
			</td>

			

			<td align="left"> 
			 <?php if($agentSchedulePayData['status'] == 1){ ?> 
				<input type="button" value="Update&nbsp;Payment" class="updatePaymentBtn" onclick="updatePartialPayment<?php echo $agentSchedulePayData['id']; ?>();" style="display:inline;" /> <?php  } ?>
			</td>
			
			<script type="text/javascript"> 
				calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(); 	
				function calculateAmtPer<?php echo $agentSchedulePayData['id']; ?>(actionTo){
					var totalAmt = Number('<?php echo $totalCost; ?>');
					var totalAmt = Number('<?php echo $totalCost; ?>');
					var amount = Number($('#amount<?php echo $agentSchedulePayData['id']; ?>').val());
					var value = Number($('#value<?php echo $agentSchedulePayData['id']; ?>').val());
					var type = Number($('#type<?php echo $agentSchedulePayData['id']; ?> :selected').val());
					if(type==2 && actionTo == 2){
						$('#amount<?php echo $agentSchedulePayData['id']; ?>').val(Number(value));
					}
					if(type==1 && actionTo == 2){
						$('#amount<?php echo $agentSchedulePayData['id']; ?>').val(Number(value/100*totalAmt));
					}
					if(type==2 && actionTo == 1){
						$('#value<?php echo $agentSchedulePayData['id']; ?>').val(Number(amount));
					}
					if(type==1 && actionTo == 1){
						$('#value<?php echo $agentSchedulePayData['id']; ?>').val(Number(amount/totalAmt*100));
					}
				}
				
				function savePartial<?php echo $agentSchedulePayData['id']; ?>(){
					var type = $("#type<?php echo $agentSchedulePayData['id']; ?>").val();
					var paymentType = $("#paymentType<?php echo $agentSchedulePayData['id']; ?>").val();
					var value = $("#value<?php echo $agentSchedulePayData['id']; ?>").val();
					var amount = $("#amount<?php echo $agentSchedulePayData['id']; ?>").val();
					var dueDate = $("#dueDate<?php echo $agentSchedulePayData['id']; ?>").val();
					var dueTime = $("#dueTime<?php echo $agentSchedulePayData['id']; ?>").val();
					var remark = $("#remarks<?php echo $agentSchedulePayData['id']; ?>").val();
					$("#updateMsg").text('Saved Successfull.');
					$("#loadDmcPayment").load("loadSave_DmcPayment.php?action=updatePartialAmount&paymentId=<?php echo $paymentId; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&scheduleId=<?php echo $agentSchedulePayData['id']; ?>&quotationId=<?php echo $quotationId; ?>&paymentType="+encodeURI(paymentType)+"&type="+encodeURI(type)+"&value="+encodeURI(value)+"&amount="+encodeURI(amount)+"&dueDate="+encodeURI(dueDate)+"&dueTime="+encodeURI(dueTime)+"&remark="+encodeURI(remark));
				} 
				function updatePartialPayment<?php echo $agentSchedulePayData['id']; ?>(){
					var value = $("#value<?php echo $agentSchedulePayData['id']; ?>").val();
					var amount = $("#amount<?php echo $agentSchedulePayData['id']; ?>").val();
					alertspopupopen('action=agentUpdatePayment&scheduleId=<?php echo $agentSchedulePayData['id'];?>','500px','auto');	
				}
				 
			</script>
		</tr>
		<?php $cnt++; } ?> 
		</tbody>
	</table>	
	</div>
</div>
<style>
	.table-strip tr:nth-child(even),.table-strip thead{
		background-color: #efeaea;
	}
	.closeBtn{
		position: absolute;
	    right: 15px;
	    color: #ffffff;
	}
	.tm{
		text-align: right;
		display: inline-block;
		padding: 5px;
		border-radius: 5px;
		background-color: white;
		border: 1px solid;
		font-size: 11px;
	}
	.totalCost{
	    background-color: #b7b7b7;
		padding: 5px;
		overflow: auto;
		text-align: left;
		margin-bottom: 0px;
	}
	.gstInput{
		width: 46px;
		color: black;
		text-align: center;
		padding: 7px 9px 6px 6px!important;
	}
	.schedulebox .inputText{
		text-align: center;
		border-radius: 2px;
		padding: 6px 2px;
	}
	.updatePaymentBtn{
		padding: 5px 10px 5px 10px!important;
	    border-radius: 3px;
	    background-color: #43a426;
	    color: white;
	    border: 2px solid #838a81!important;
	    cursor: pointer;
	    font-size: 12px;
	}
	#loapaymentreceipt{	
		background-color: #00000094;
		background-color: rgba(50, 61, 76, 0.91);
		width: 100%;
		height: 100%;
		position: fixed;
		left: 0px;
		top: 0px;
		overflow: auto;
		display: none;
		z-index: 9999;

	}
	#loapaymentreceipt .payemntreceipt {
		background-color: #FFFFFF;
		max-width: 850px;
		margin: auto;
		margin-top: 60px;
		margin-bottom: 40px;
	}
</style>

<div id="loapaymentreceipt" style="background-image: url('images/bgpop.png'); background-repeat: repeat;display:none;"> <div class="payemntreceipt"></div> </div>

<script>
	function openPaymentReceipt(url,popwidth,quotationId,scheduleId,queryId){
		$("#loapaymentreceipt").show();
		$(".payemntreceipt").load('paymentReceipt.php?action='+url+'&quotationId='+quotationId+'&scheduleId='+scheduleId+'&queryId='+queryId);
		$(".payemntreceipt").css('width',popwidth);
	}
	function receiptalertClose(){
		$("#loapaymentreceipt").hide();
		window.location.reload();
		parent.$('#pageloading').hide();
		parent.$('#pageloader').hide();
		parent.masters_alertspopupopenClose();
	}
</script>