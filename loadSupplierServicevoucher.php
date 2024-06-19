<script src="js/jquery-1.11.3.min.js"></script>
<?php 
include "inc.php";

$select='*';   
$where='id="'.$_REQUEST['queryId'].'"';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs);
$rsp="";
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($rsp); 
$quotationId = $quotationData['id'];
$update = updatelisting(_QUOTATION_MASTER_,'isPaymentRequest=1','id="'.$_REQUEST['quotationId'].'"');
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
		 $("#updatefinalquotation").load('cancleFinalquoteSuppliervoucher.php?QuotId='+QuotId+'&type='+type+'&supplierId='+supplierId+'&serviceId='+serviceId+'&quotationId='+quotationId);
		 if(supplierId!=''){
		    $('#selectedcon'+QuotId).closest('tr').remove();
		  }
	}
    updateQuothotel('<?php echo $quotationId; ?>','','','all');
</script>
