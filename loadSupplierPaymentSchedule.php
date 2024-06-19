<?php

include "inc.php";
$totalCost = 0;
$paid = 0;
$totalPending=0; 

// finalQuote
$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$_REQUEST['quotationId'].'" and id="'.$_REQUEST['supplierStatusId'].'" and deletestatus=0'); 
$supplierStatusData=mysqli_fetch_array($fianlSuppQuery);

// scheduletalbe
$totalCost = $supplierStatusData['totalSupplierCost'];
$quotationId = $supplierStatusData['quotationId'];
$currencyId = $_REQUEST['currencyId'];

$r2='';
$r2=GetPageRecord('sum(amount) as totalAmount,count(id) as num,ssp.*','supplierSchedulePaymentMaster ssp','supplierStatusId="'.$supplierStatusData['id'].'" and amount!="" and value!=""'); 
$schedulePaymentData = mysqli_fetch_array($r2);
$schedulePaymentNum = $schedulePaymentData['num'];
$remainAmount = $totalCost-$schedulePaymentData['totalAmount'];	
if($schedulePaymentNum > 0){
	
	$r3=GetPageRecord('sum(amount) as totalpaid, spm.*','supplierPaymentMaster spm',' supplierStatusId="'.$supplierStatusData['id'].'" and paymentStatus=1'); 
	$supplierPaymentData = mysqli_fetch_array($r3);
	$paid = ($supplierPaymentData['totalpaid']==0)?0:$supplierPaymentData['totalpaid'];
	
	$remainValue = round(($remainAmount/$totalCost*100),2);
	if($schedulePaymentData['totalAmount'] < $totalCost  && $remainAmount > 0){
		 $namevalue1 ='type=1,paymentType=2,status=1,dueDate="'.date('Y-m-d').'",value="'.$remainValue.'",amount="'.$remainAmount.'",supplierStatusId="'.$supplierStatusData['id'].'",quotationId="'.$quotationId.'"';
		$scheduleId2 = addlistinggetlastid('supplierSchedulePaymentMaster',$namevalue1);  
	} 	
	
}else{	
	$namevalue ='type=1, value=100, paymentType=2, status=1, dueDate="'.date('Y-m-d').'",amount="'.$totalCost.'", supplierStatusId="'.$supplierStatusData['id'].'",quotationId="'.$quotationId.'"';
	$scheduleId = addlistinggetlastid('supplierSchedulePaymentMaster',$namevalue);  
}
$totalPending = $totalCost-$paid;  

$bb="";
$bb=GetPageRecord('*','suppliersMaster',' id="'.$supplierStatusData['supplierId'].'" order by name'); 
$supplierData=mysqli_fetch_array($bb); 
$pageTitle = $supplierData['name'];
$paymentTerms = ($supplierData['paymentTerm']==1)?'Cash':'Credit';
				 
?>
<h1 style="text-align:left;position:relative;"><?php echo $pageTitle; ?><a onClick="masters_alertspopupopenClose();location.reload();" class="closeBtn">x</a></h1>
<div id="contentbox" class="addeditpagebox" style="  padding:1px 0px 0px; overflow:auto; text-align:left; margin-bottom:0px; " >
	<?php 
	$cnt2=1;
	$r31=="";
	$r31=GetPageRecord('*','supplierPaymentMaster',' scheduleId in ( select id from supplierSchedulePaymentMaster where 1 and  supplierStatusId="'.$supplierStatusData['id'].'"  ) and paymentStatus=1'); 
	if(mysqli_num_rows($r31) > 0){
	?>
	<div class="paidList">
		<table width="100%" cellpadding="3" cellspacing="0" border="1" style="border-color: #ddd;" class="table-strip ">
		<thead> 
		<tr>
		<th width="9%"><strong>SR.&nbsp;NO.</strong></th>
		<th width="10%"><strong>Payment&nbsp;Type</strong></th>
		<th width="9%"><strong>Amount</strong></th>
		<th width="9%"><strong>Payment&nbsp;Info</strong></th>
		<th width="9%"><strong>Bank &nbsp;Name</strong></th>
		<th width="35%"><strong>Remark</strong></th>
		<th width="19%"><strong>Payment Date</strong></th>
		<th width="9%"><strong>Status</strong></th>
		<th style="min-width: 50px;"><strong>Action</strong></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		while($paymentDataList = mysqli_fetch_array($r31)){
			$ressBankR = GetPageRecord('*','bankMaster','id="'.$paymentDataList['bankId'].'"');
			$suppBankD = mysqli_fetch_assoc($ressBankR);
			$bankName = $suppBankD['bankName'];
		?>
		<tr>
		<td><?php echo $cnt2; ?></td>
		<td><?php if($paymentDataList['paymentType'] == 1){ echo "On Credit"; }elseif($paymentDataList['paymentType'] == 2){ echo "Advanced";  }elseif($paymentDataList['paymentType'] == 3){ echo "Direct&nbsp;Payment";  }else{ echo "Full Payment"; } ?></td>
		<td><?php echo round($paymentDataList['amount']);?></td>
		
		<td><?php echo $paymentDataList['paymentBy'];?></td>
		<td><?php echo $bankName;?></td>
		<td><?php echo $paymentDataList['remark'];?></td>
		<td><?php if($paymentDataList['paymentDate']=='0000-00-00'){ echo date('d M Y',trim($paymentDataList['dateAdded']));}else{ echo date('d M Y',strtotime($paymentDataList['paymentDate'])); }?></td>
		<td><?php if($paymentDataList['paymentStatus'] == 1 && $paymentDataList['paymentType'] == 1){ echo "On Credit"; }else if($paymentDataList['paymentStatus'] == 1){ echo "Paid"; }else{ echo "...";} ?></td>

		<!-- Payment Receipt Button started   -->
		<td><input target="_blank" type="button" value="Payment Receipt" onclick="openSupplierPaymentReceipt('openpaymentreceiptSupp','850px','<?php echo $paymentDataList['quotationId']; ?>','<?php echo $paymentDataList['id']; ?>','<?php echo $supplierStatusData['queryId']; ?>','<?php echo $_REQUEST['supplierStatusId']; ?>');" style="cursor: pointer;"></td>
<!-- Payment Receipt Button Ended   -->
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

	$c=GetPageRecord('*','supplierDocumentMaster',' supplierStatusId = "'.$supplierStatusData['id'].'"'); 
	$suppdocument=mysqli_fetch_array($c);
	?>
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="getpaymentadd" target="actoinfrm"  id="getpaymentadd">
	<div class="totalCost">
		<div style="width: 60px;text-align: left;" class="tm"><strong>Currency<br><?php echo getCurrencyName($currencyId); ?></strong></div>
		<div style="width: 98px;" class="tm"><strong>Total&nbsp;Amount<br><?php echo $totalCost; ?></strong></div>
		<div style="width: 58px;" class="tm"><strong>Paid<br><?php echo $paid; ?></strong></div>
		<div style="width: 68px;" class="tm"><strong>Pending<br><?php echo $totalPending; ?></strong></div>
		<div style="width: 168px;" class="tm">
		<strong style="font-size: 10px;">Supplier Invoice<br>
		<?php	echo "<a href= '".$fullurl."dirfiles/".$suppdocument['documentFile']."' target='_blank' >";
		if($suppdocument['documentFile']!=''){
		echo $suppdocument['documentFile'];
		}
		echo "</a>";
		?>
		</strong></div>
		<div style="width: 120px; margin-left: 10px; float: right; background-color: #b7b7b7; color: #233a49;" class="tm"><strong>Payment&nbsp;Terms<br><?php echo $paymentTerms; ?></strong></div>
		<div style="width: 280px;margin-left: 10px;float: right;background-color: #b7b7b7;color: #233a49;padding: 0 10px;border: 0;" class="tm"></div>
	</div> 
	<div id="loadSupplierPayment" style="display:none;"></div>
	<div class="schedulebox" >
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
		<thead>
		<tr>
			<td width="2%"><strong>#</strong></td>
			<td width="5%"><strong>Type</strong></td>
			<td width="8%"><strong>Payment Type</strong></td>
			<td width="10%"><strong>Value</strong></td>
			<td width="15%"><strong>Amount</strong></td>
			<td width="5%"><strong>Due&nbsp;Date</strong></td>
			<td width="10%"><strong>Due&nbsp;Time</strong></td>
			<td width="10%"><strong>Remark</strong></td>
			<td width="15%" colspan="2"><strong id="updateMsg" style="color:#006600;">&nbsp;</strong></td>
		</tr>
		</thead>
		<tbody> 
		<?php 
		$cnt = 1;
		$r21="";
		// echo 'supplierStatusId="'.$supplierStatusData['id'].'" and quotationId = "'.$quotationId.'" and id not in ( select scheduleId from supplierPaymentMaster where supplierStatusId="'.$supplierStatusData['id'].'" and paymentStatus=1 ) order by id asc';
		$r21=GetPageRecord('*','supplierSchedulePaymentMaster','supplierStatusId="'.$supplierStatusData['id'].'" and quotationId = "'.$quotationId.'" and id not in ( select scheduleId from supplierPaymentMaster where supplierStatusId="'.$supplierStatusData['id'].'" and paymentStatus=1 ) order by id asc'); 
		while($scheduleData = mysqli_fetch_array($r21)){

			if($scheduleData['dueDate'] == "0000-00-00"){ $dueDate = date("Y-m-d"); }else{ $dueDate = date('Y-m-d',strtotime($scheduleData['dueDate'])); }
			if($scheduleData['dueTime'] == "00:00:00"){ $dueTime = date('H:i'); }else{ $dueTime = date('H:i',strtotime($scheduleData['dueTime'])); }
			//echo $dueDate;

			$r2111=GetPageRecord('*','supplierSchedulePaymentMaster','quotationId="'.$scheduleData['quotationId'].'" and supplierStatusId="'.$scheduleData['supplierStatusId'].'" order by id desc LIMIT 1');
			$resL = mysqli_fetch_assoc($r2111);
			$lastId = $resL['id'];
			$lastamount = $resL['amount'];
		?>
		<tr>
			<td><strong><?php echo $cnt; ?></strong></td>
			<td align="right">
				<select id="type<?php echo $scheduleData['id']; ?>" onchange="calculateAmtPer<?php echo $scheduleData['id']; ?>(1);" name="type<?php echo $scheduleData['id']; ?>" class="paycl gstInput" autocomplete="off" >  
				  <option value="1" <?php if($scheduleData['type'] == 1){ ?> selected="selected" <?php } ?>>%</option>  
				  <option value="2" <?php if($scheduleData['type'] == 2){ ?> selected="selected" <?php } ?>>Flat</option> 
				</select>
			</td>
			<td align="right">
				<select id="paymentType<?php echo $scheduleData['id']; ?>" name="paymentType<?php echo $scheduleData['id']; ?>" class="paycl inputText" >  
					<option value="1" <?php if($scheduleData['paymentType'] == 1){ ?> selected="selected" <?php } ?>>On Credit</option>
					<option value="2" <?php if($scheduleData['paymentType'] == 2){ ?> selected="selected" <?php } ?>>Advanced Payment</option>
					<option value="3" <?php if($scheduleData['paymentType'] == 3){ ?> selected="selected" <?php } ?>>Direct&nbsp;Payment</option>
					<option value="4" <?php if($scheduleData['paymentType'] == 4){ ?> selected="selected" <?php } ?>>Full Payment</option>
				</select>
			</td>
			<td align="right">
				<input type="text" class="paycl inputText" name="value<?php echo $scheduleData['id']; ?>" id="value<?php echo $scheduleData['id']; ?>" value="<?php echo $scheduleData['value'];  ?>" maxlength="20" displayname="Amount Value" onKeyUp="calculateAmtPer<?php echo $scheduleData['id']; ?>(2);" autocomplete="off" style="width:95%!important;text-align:right;">
			</td>
			<td align="left"><input  type="text" class="paycl inputText" name="amount<?php echo $scheduleData['id']; ?>" id="amount<?php echo $scheduleData['id']; ?>" value="<?php echo round($scheduleData['amount']); ?>" maxlength="20" autocomplete="off" disabled style="width:95%!important;text-align:right;"></td>
			
			<td align="left"> <input type="date" class="gridfield inputText" id="dueDate<?php echo $scheduleData['id']; ?>" name="dueDate<?php echo $scheduleData['id']; ?>" value="<?php echo $dueDate;?>" style="text-align:left;width:95%;padding: 3px;border-radius: 2px;" ></td>
			<td align="left"><input type="time" name="dueTime<?php echo $scheduleData['id']; ?>" id="dueTime<?php echo $scheduleData['id']; ?>" class="inputText" value="<?php echo $dueTime; ?>" min="10:00" max="18:00" style="text-align:left;width:90%;padding: 3px;border-radius: 2px;"></td>
			<td align="left"><textarea name="remarks<?php echo $scheduleData['id']; ?>" class="paycl inputText" id="remarks<?php echo $scheduleData['id']; ?>" style="height: 16px;"><?php echo $scheduleData['remarks']; ?></textarea></td>
			<td align="left"> 
				<input name="button" type="button" class="updatePaymentBtn" onclick="savePartial<?php echo $scheduleData['id']; ?>();" value="<?php if($scheduleData['scheduleStatus'] == 1) echo 'Saved'; else echo 'Save'; ?>" style="display:inline; background-color: #233a49;" />	 
			</td>
			<td align="left"> <?php if($scheduleData['status'] == 1){ ?> 
			<input type="button" value="Update&nbsp;Payment" class="updatePaymentBtn" onclick="updatePartialPayment<?php echo $scheduleData['id']; ?>();" style="display:inline;" /> 
			<?php  } ?>
			</td>
			
			<script type="text/javascript"> 
				calculateAmtPer<?php echo $scheduleData['id']; ?>(); 	
				function calculateAmtPer<?php echo $scheduleData['id']; ?>(actionTo){
					var totalAmt = Number('<?php echo $totalCost; ?>');
					var totalAmt = Number('<?php echo $totalCost; ?>');
					var amount = Number($('#amount<?php echo $scheduleData['id']; ?>').val());
					var value = Number($('#value<?php echo $scheduleData['id']; ?>').val());
					var type = Number($('#type<?php echo $scheduleData['id']; ?> :selected').val());
					if(type==2 && actionTo == 2){
						$('#amount<?php echo $scheduleData['id']; ?>').val(Number(value));
					}
					if(type==1 && actionTo == 2){
						$('#amount<?php echo $scheduleData['id']; ?>').val(Number(value/100*totalAmt));
					}
					if(type==2 && actionTo == 1){
						$('#value<?php echo $scheduleData['id']; ?>').val(Number(amount));
					}
					if(type==1 && actionTo == 1){
						$('#value<?php echo $scheduleData['id']; ?>').val(Number(amount/totalAmt*100));
					}
				}
				
				function savePartial<?php echo $scheduleData['id']; ?>(){
					var type = $("#type<?php echo $scheduleData['id']; ?>").val();
					var paymentType = $("#paymentType<?php echo $scheduleData['id']; ?>").val();
					var value = $("#value<?php echo $scheduleData['id']; ?>").val();
					var amount = $("#amount<?php echo $scheduleData['id']; ?>").val();
					var dueDate = $("#dueDate<?php echo $scheduleData['id']; ?>").val();
					var dueTime = $("#dueTime<?php echo $scheduleData['id']; ?>").val();
					var remark = $("#remarks<?php echo $scheduleData['id']; ?>").val();
					$("#updateMsg").text('Saved Successfull.');
					$("#loadSupplierPayment").load("loadSave_SupplierPayment.php?action=updatePartialAmount&supplierStatusId=<?php echo $supplierStatusData['id']; ?>&queryId=<?php echo $_REQUEST['queryId']; ?>&scheduleId=<?php echo $scheduleData['id']; ?>&type="+encodeURI(type)+"&paymentType="+encodeURI(paymentType)+"&value="+encodeURI(value)+"&amount="+encodeURI(amount)+"&dueDate="+encodeURI(dueDate)+"&dueTime="+encodeURI(dueTime)+"&remark="+encodeURI(remark));
				}
				<?php if($scheduleData['status'] == 1 ){ ?>
				function updatePartialPayment<?php echo $scheduleData['id']; ?>(){
					 
					var value = $("#value<?php echo $scheduleData['id']; ?>").val();
					var amount = $("#amount<?php echo $scheduleData['id']; ?>").val();
					alertspopupopen('action=serviceUpdatePayment&scheduleId=<?php echo $scheduleData['id'];?>&lastscheduleId=<?php echo $lastId ;?>&lastscheduleamount=<?php echo $lastamount ;?>','800px','auto');	
				}
				<?php } ?>
			</script>
		</tr>
		<?php $cnt++; } ?> 
		</tbody>
	</table>	
	</div>
	<input name="action" type="hidden"  value="serviceSchedulePayment" /> 
	<input name="supplierStatusId" type="hidden" id="supplierStatusId" value="<?php echo $_REQUEST['supplierStatusId']; ?>" /> 
	</form>
</div>
<style>
	.table-strip tr:nth-child(even){

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
		font-size: 15px;
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
	}

	#loapaymentreceiptSupp{ 
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
  #loapaymentreceiptSupp .payemntreceiptSupp {
    background-color: #FFFFFF;
    max-width: 850px;
    margin: auto;
    margin-top: 60px;
    margin-bottom: 40px;
  }
</style>
<script type="text/javascript">
	$('#supplierPendingCostpending<?php echo $supplierStatusData['id']; ?>').text('<?php echo $totalPending; ?>');
	$('#supplierCompanyCostpoid<?php echo $supplierStatusData['id']; ?>').text('<?php echo $paid; ?>');
</script>
</script>
<div id="loapaymentreceiptSupp" style="background-image: url('images/bgpop.png'); background-repeat: repeat;display:none;">
<div class="payemntreceiptSupp"></div>


<script type="text/javascript">

function receiptalertClose(){
    $("#loapaymentreceiptSupp").hide();
    window.location.reload();
    parent.$('#pageloading').hide();
    parent.$('#pageloader').hide();
    parent.masters_alertspopupopenClose();
  }

  
  function openSupplierPaymentReceipt(url,popwidth,quotationId,scheduleId,queryId,scheduleSupp){
    $("#loapaymentreceiptSupp").show();
    $(".payemntreceiptSupp").load('supplierPaymentReceipt.php?action='+url+'&quotationId='+quotationId+'&scheduleId='+scheduleId+'&queryId='+queryId+'&scheduleSuppId='+scheduleSupp);
    $(".payemntreceiptSupp").css('width',popwidth);
  }
  </script>