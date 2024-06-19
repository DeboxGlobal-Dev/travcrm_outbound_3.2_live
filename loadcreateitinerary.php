<?php
include "inc.php"; ?> 
<div style="position:relative;"> 
	<div style="position: absolute;
    right: 3px;
    top: 2px;display:none;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();" style="background-color: #fff !important;"></div>
</div>
<?php       
$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['quotationId']).'"'); 
$quotationData=mysqli_fetch_array($rs2); 
//dkjhfaskdfasdfsdfksafsakjdfkjsadflzsdfn

$quotationId=$quotationData['id'];
$queryId = $quotationData['queryId'];

//sfljsakdjfhkhjsjhsbksasdfhsdjfhsdfsdfhds
$a=GetPageRecord('*','queryDateDestination',' queryId="'.$queryId.'" order by id asc'); 
$destinationDay=mysqli_fetch_array($a);
 
 $startdatevar = date('Y-m-d', strtotime('-1 day', strtotime($destinationDay['fromDate'])));     

$day=1;
$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by id asc'); 
?>
<div style="border-bottom: 1px solid #eee;" id="mainquationboxload">
<?php

$daysubject = "";
$ns = 1;
$lastCity = "";
while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
	 $dayDate = date('Y-m-d', strtotime('+'.$day.' day', strtotime($startdatevar))); 
  	 
  	?>  
	<div style="border: 1px solid #3b4fb5;margin-top: 10px;">
	<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#3b4fb5">
	<tr>
		<td width="66%"  style="color:#fff;"><?php echo $day; ?> - <?php echo getDestination($QueryDaysData['cityId']);?> - <?php echo date('d-m-Y',strtotime($dayDate));?></td>
	</tr> 
	</table>
	</div>
	<div style="padding:10px;border: 1px solid #3b4fb5;">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		<td width="50%"><div style="font-size:12px;">Subject</div> 
			<input name="title<?php echo $QueryDaysData['id']; ?>" type="text" id="title<?php echo $QueryDaysData['id']; ?>"  style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;"  value="<?php echo stripslashes($QueryDaysData['title']); ?>"  ></td>
	  </tr>
	  <tr>
		<td> 
		  <textarea name="description<?php echo $QueryDaysData['id']; ?>" rows="5" id="description<?php echo $QueryDaysData['id']; ?>" style="font-size:12px; padding:6px; width:100%; box-sizing:border-box;box-shadow:none;"  placeholder="Remark"><?php echo stripslashes($QueryDaysData['description']); ?></textarea> </td>
		</tr>
		 <tr>
		<td>  
		 <input name="Save" type="button" class="whitembutton submitBtn" id="Save" value="Save" onclick="saveitinerarydata(<?php echo $QueryDaysData['id']; ?>,'<?php echo $dayDate; ?>');" style="background-color: #3b4fb5 !important;margin: 0;padding: 4px 11px;color: white;display:none">
		 </td>
		</tr>
		
	  <tr>
		<td> 
		  
		<script> 
		$("#stbl<?php echo $QueryDaysData['id']; ?> tbody").sortable({
			handle: '.editButton',
			stop: function( event, ui ) {
				var obj={};
				var len=$("#stbl<?php echo $QueryDaysData['id']; ?> tbody > div").length;
				// alert("all Index");
				for(var i=0;i<len;i++){
					// var id
					//alert($("#testCaseContainer > div").eq(i).find('li').attr('id'));
					obj[i]=$("#stbl<?php echo $QueryDaysData['id']; ?> tbody > div").eq(i).find('li').attr('id');
					//  alert($("#testCaseContainer > div")[0].find('li').id);
				}
				$('#addeditquery<?php echo $QueryDaysData['id']; ?>').submit();
			}
		});
		</script> 
		</td>
		</tr>
	</table>
	</div>
	<?php 
 	$day++; 
 	$ns++;  
}  
 ?> 
	<div style="display:none;" id="saveitinerarydatadata"></div>
	<div style="overflow:hidden;">
		<table border="0" align="right" cellpadding="5" cellspacing="0">
		<tbody><tr> 
			<td> 
				<input name="Cancel" type="button" class="whitembutton" id="Cancel" value=" Close " onclick="alertspopupopenClose();"> 
				<input name="Save" type="button" class="whitembutton" id="Save" value=" Save " onclick="triggerBtn();">  
			</td> 
		</tr>
		</tbody></table>
	</div>
 
<script>    
	// Trigger to all 
	function triggerBtn(){
		$('.submitBtn').click();
	 	setTimeout(function(){
			location.reload();
		}, 500); 
	}
	 
	function saveitinerarydata(dayid,d){  
	//alert(sectionid);
		var title = $('#title'+dayid).val(); 
		var description = $('#description'+dayid).val();   
		var savequotationitinerary = 'savequotationitinerary';   
		
		$.ajax({
            type: "POST",
            url: 'frmaction.php',
            data: {title: title, description: description, dayid: dayid, d: d, action: savequotationitinerary, quotationId: '<?php echo encode($quotationId); ?>'},
            success: function(data){   
            	load_fixdeparture_guideinventoryfun();
            	$('#guideId').val('0'); 
            	$('#guideCost').val('0');  
            }
        });
		
		
		
		//$('#saveitinerarydatadata').load('frmaction.php?action=savequotationitinerary&quotationId=<?php echo encode($quotationId); ?>&dayid='+dayid+'&title='+title+'&description='+description+'&d='+d); 
	} 
	function reloaditinery(){
		alertspopupopen('action=createliveitinerary&quotationId=<?php echo encode($quotationId); ?>','900px','auto'); 
	}
	</script>