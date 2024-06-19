<?php
include "inc.php"; 
include "config/logincheck.php";  

$queryId=ltrim($_REQUEST['queryId'], '0');
if($queryId>0){

$nod=1;
$select='*';
$where='id='.$queryId.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($queryIdmain=mysqli_fetch_array($rs)){ 
$compaid=$queryIdmain['companyId']; 
}



$nod=1;
$select='companyId';
$where='id='.$queryId.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($queryIdmain=mysqli_fetch_array($rs)){ 
$companyId=$queryIdmain['companyId']; 
}


$nod=1;
$select='id';
$where='queryid='.$queryId.''; 
$rs=GetPageRecord($select,_PAYMENT_REQUEST_MASTER_,$where); 
while($paymentrequest=mysqli_fetch_array($rs)){ 
 $paymentid=$paymentrequest['id']; 
}

if($compaid==''){ ?>
<script>
$('#loadcompanyandsupplier').hide();
</script>

<?php

}
?>

<div class="griddiv"><label>
 <div style="color:#CC0000; margin:10px 0px; display:none; text-align:left;" id="addpaymentreqesmsg"></div>
	<div class="gridlable">Company<span class="redmind"></span></div>
	<input name="compname" type="text" class="gridfield validate" id="compname"   value="<?php echo getCorporateCompany($companyId); ?>" autocomplete="off" readonly="readonly" />
	<input name="compcompanyId" type="hidden" id="compcompanyId" value="<?php echo $compaid; ?>">
	</label>
	 
</div>
 
 
 <div class="griddiv"><label>
 <div style="color:#CC0000; margin:10px 0px; display:none; text-align:left;" id="addpaymentreqesmsg"></div>
	<div class="gridlable">Supplier<span class="redmind"></span></div>
	<select id="supplierIdcomp" name="supplierIdcomp" class="textfieldsup"   autocomplete="off"   > 
 <?php 
if($paymentid!=''){
$select=''; 
$where=''; 
$rs='';  
$select='supplierId';    
$where=' paymentId='.$paymentid.'';  
$rs=GetPageRecord($select,_PAYMENT_SUPPLIER_LIST_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['supplierId']); ?>"><?php echo getsupplierCompany($resListing['supplierId']); ?></option>
<?php } } else { ?>
<option value="0">Select Supplier</option>
<?php } ?>
</select>
	 
	</label>
	 
 </div>
 
 <?php } ?>