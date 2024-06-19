<?php
include "inc.php";  
 
if($_REQUEST['id']>0){
	  
	$supplierId= $_REQUEST['supplierId'];    
	$queryId= $_REQUEST['queryId'];        
	$quotationId= $_REQUEST['quotationId'];    
	$status= $_REQUEST['status'];      

	echo $namevalue='supplierId="'.$supplierId.'",queryId="'.$queryId.'",quotationId="'.$quotationId.'",status="'.$status.'"';
	updatelisting('finalQuotSupplierStatus',$namevalue,'id="'.$_REQUEST['id'].'"');

}

 
 
	
	?>