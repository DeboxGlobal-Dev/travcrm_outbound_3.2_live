<?php 
include "inc.php"; 
?>
<script src="js/jquery-1.11.3.min.js"></script>
<?php
$select='*';   
$where='id="'.$_REQUEST['queryId'].'"';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 
$rsp="";
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($rsp); 

$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$pax = ($quotationData['adult']+$quotationData['child']);

$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discountTax = $quotationData['discount'];

//slab Date
$slabSql="";
$slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and "'.$pax.'" BETWEEN fromRange and toRange and status=1'); 
if(mysqli_num_rows($slabSql) > 0 ){
	$slabsData=mysqli_fetch_array($slabSql);
	$slabId = $slabsData['id']; 
	$dfactor = $slabsData['dividingFactor']; 
}


//$update = updatelisting(_QUOTATION_MASTER_,'isPaymentRequest=1','id="'.$_REQUEST['quotationId'].'"');
?>

<div id="UassignedServices"></div>
<div id="updatefinalquotation"></div>
<div style="overflow:hidden; margin-top:20px;">
	 <table border="0" align="right" cellpadding="5" cellspacing="0">
	  	<tbody>
	  		<tr>
		    	<td>
				     <!-- <input type="button" class="bluembutton submitbtn" value="Save" onclick="savefinalQuote();"> -->
				     <input type="button" class="whitembutton" value="Close" onclick="alertspopupopenClose();window.location.reload();">
				</td>
		  	</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	function updateQuothotel(quotationId,QuotId,serviceId,type) {
		var supplierId = $('#supplier'+QuotId).val();
		 $("#updatefinalquotation").load('updatefinalquotsupplier.php?QuotId='+QuotId+'&type='+type+'&supplierId='+supplierId+'&serviceId='+serviceId+'&quotationId='+quotationId);
		 if(supplierId!=''){
		    $('#selectedcon'+QuotId).closest('tr').remove();
		  }

		  if(supplierId!=''){
		    $('.sameHotel'+serviceId).closest('tr').remove();
		  }
	}
    updateQuothotel('<?php echo $quotationId; ?>','','','all');

    function unassignedServices(quotationId,QuotId,serviceId,type){
		var supplierId = $('#supplier'+QuotId).val();
		 $("#UassignedServices").load('unassigned_services.php?QuotId='+QuotId+'&type='+type+'&supplierId='+0+'&serviceId='+serviceId+'&quotationId='+quotationId);
		//  if(supplierId==''){ for changing supplier
		    $('#selectedcon'+QuotId).closest('tr').remove();
		//   }
	}
     unassignedServices('<?php echo $quotationId; ?>','','','all');



</script>
