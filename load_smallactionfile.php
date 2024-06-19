<?php 
ob_start();   
include "inc.php";  

if($_REQUEST['action']=="selectSupplierDestinations"){
	if($_REQUEST['countryId']!=''){

	    $countryId = $_REQUEST['countryId'];
	    $where=' deletestatus=0 and status=1 and countryId="'.trim($_REQUEST['countryId']).'" order by id asc';  
	    $rs=GetPageRecord('*',_DESTINATION_MASTER_,$where); 
	    $alldest=explode(',',$_REQUEST['destinationId']);  
	    while($resListing=mysqli_fetch_array($rs)){ 
	    	$isSelected = in_array($resListing['id'], $alldest) ? 'selected="selected"' : ''; 
	        ?>
	        <option value="<?php echo $resListing['id']; ?>" <?php if($resListing['countryId']==$countryId){ echo 'selected="selected"'; } ?>><?php echo $resListing['name']; ?> </option>
	        <?php
	    }
	    ?>
	    <script type="text/javascript">$('.js-example-basic-multiple').select2();</script>
	    <?php
	    
	}elseif($_REQUEST['countryId']==''){

	    $select='';  
	    $where='';  
	    $rs='';   
	    $select='*';    
	    $where=' deletestatus=0 and countryId>0 and status=1 order by name asc';   
	    $rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
	    $alldest=explode(',',$_REQUEST['destinationId']);  
	    while($resListing=mysqli_fetch_array($rs)){  
	    	$isSelected = in_array($resListing['id'], $alldest) ? 'selected="selected"' : ''; 

	    ?> 
	    <option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> 
	    <?php } 
	    ?>
	    <script type="text/javascript">$('.js-example-basic-multiple').select2();</script>
	    <?php
	}
}




















?>
