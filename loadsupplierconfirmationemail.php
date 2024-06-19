<?php 
include "inc.php"; 
$id=$_REQUEST['id'];  
$emailSupplierDataq=GetPageRecord('email,email1','suppliercontactPersonMaster','1 and id="'.decode($_REQUEST['id']).'"');  
$emailSupplierData=mysqli_fetch_array($emailSupplierDataq);  

if($emailSupplierData['email1'] == ''){
$email = decode($emailSupplierData['email']);	
}
else{
$email = decode($emailSupplierData['email']).';'.decode($emailSupplierData['email1']);	
}

?>


<div class="gridlable" style="width:100%;color: #8a8a8a; display: inline-block; padding-bottom: 0px; font-size: 13px; ">Supplier</div>
<input name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="Supplier Email" value="<?php echo $email; ?>" style="display: inline-block; outline: 0px; padding-bottom: 0px; width: 100%; background-color: #FFFFFF; font-size: 14px; border: 1px #e0e0e0 solid; box-sizing: border-box; height: auto; padding: 8px; margin-top: 5px; border-radius: 2px;" readonly/>
