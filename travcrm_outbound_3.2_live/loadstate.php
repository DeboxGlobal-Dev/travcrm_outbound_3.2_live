<?php
include "inc.php";  
if($_REQUEST['action']=="destinationMasterstate"){

	// Destination state
$countryId=$_REQUEST['countryId'];
$selectedId=$_REQUEST['selectedId'];

?>
<option value="0">Select State</option>  
<?php
$select=''; 
$where=''; 
$rs='';  
$select='*';    

if($countryId!=''){
	$countryId=' and countryId="'.$countryId.'" ';
}

$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
$rs=GetPageRecord($select,'stateMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectedId){ ?> selected="selected" <?php } ?> ><?php echo strip($resListing['name']); ?></option>
<?php } 
}


if($_REQUEST['action']=="loadAllstatescitymaster"){

	$countryId=$_REQUEST['countryId'];
	$selectId=$_REQUEST['selectId'];
	
	?>
	<option value="0">Select State</option>  
	<?php
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	
	if($countryId!=''){
		$countryId=' and countryId="'.$countryId.'" ';
	}
	
	$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
	$rs=GetPageRecord($select,'stateMaster',$where); 
	while($resListing=mysqli_fetch_array($rs)){  
	?>
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectId){ ?> selected="selected" <?php } ?> ><?php echo strip($resListing['name']); ?></option>
	<?php } 


}


if($_REQUEST['action']=="hotelstateselection"){

	// Destination state
$countryId=$_REQUEST['id'];
$selectId=$_REQUEST['selecteId'];

?>
<option value="0">Select State</option>  
<?php
$select=''; 
$where=''; 
$rs='';  
$select='*';    

if($countryId!=''){
	$countryId=' and countryId="'.$countryId.'" ';
}

$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
$rs=GetPageRecord($select,'stateMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php }
 
}
 
if($_REQUEST['action']=="loadescortstate"){

	// Destination state
$countryId=$_REQUEST['id'];
$selectId=$_REQUEST['selectId'];

?>
<option value="0">Select State</option>  
<?php
$select=''; 
$where=''; 
$rs='';  
$select='*';    

if($countryId!=''){
	$countryId=' and countryId="'.$countryId.'" ';
}

$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
$rs=GetPageRecord($select,'stateMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php }
 
}


if($_REQUEST['action']=="loadrestaurantstates"){

	// Destination state
$countryId=$_REQUEST['id'];
$selectId=$_REQUEST['selectId'];

?>
<option value="0">Select State</option>  
<?php
$select=''; 
$where=''; 
$rs='';  
$select='*';    

if($countryId!=''){
	$countryId=' and countryId="'.$countryId.'" ';
}

$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
$rs=GetPageRecord($select,'stateMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php }
 
}

// load state for corporat
if(clean($_REQUEST['action'])=="loadCorporateState"){

	// Destination state
$countryId=$_REQUEST['id'];
$selectedId=$_REQUEST['selectedId'];

?>
<option value="0">Select State</option>  
<?php
$select=''; 
$where=''; 
$rs='';  
$select='*';    

if($countryId!=''){
	$countryId=' and countryId="'.$countryId.'" ';
}

$where=' deletestatus=0 and status=1 '.$countryId.' order by name asc';  
$rs=GetPageRecord($select,'stateMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$selectedId){ ?> selected="selected" <?php } ?> ><?php echo strip($resListing['name']); ?></option>
<?php } 
}

?>