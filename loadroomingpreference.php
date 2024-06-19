<?php 
include "inc.php";
 
if($_GET['action']=='loadrooming_mealpreference' && $_GET['queryId']!='' && $_GET['guestId']!=''){
	$bb=GetPageRecord('*','guestList','id = "'.$_GET['guestId'].'"'); 
	$listsupplier=mysqli_fetch_array($bb);
	
	$rs=GetPageRecord('*','mealPreference','id="'.$listsupplier['mealPreference'].'"'); 
	$resListing=mysqli_fetch_array($rs);
	echo $resListing['name'];
}

if($_GET['action']=='loadrooming_physConpreference' && $_GET['queryId']!='' && $_GET['guestId']!=''){
	$bb=GetPageRecord('*','guestList','id = "'.$_GET['guestId'].'"'); 
	$listsupplier=mysqli_fetch_array($bb);
	
	$rs=GetPageRecord('*','physicalCondition','id="'.$listsupplier['physicalCondition'].'"'); 
	$resListing=mysqli_fetch_array($rs);
	echo $resListing['name'];
}
?>   