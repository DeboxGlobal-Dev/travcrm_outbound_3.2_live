<?php
ob_start();
include "inc.php"; 
include "config/logincheck.php"; ?>
 <script src="js/jquery-1.11.3.min.js"></script>   
<?php
 /////////////////start country master///////////////////
if(trim($_POST['action'])=='addedit_countrymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();

$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_COUNTRY_MASTER_,$where); 
if($addnewyes=='yes'){

?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This country already exist.');
</script>
<?php

} else {

$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_COUNTRY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } }


if(trim($_POST['action'])=='addedit_countrymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();


 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 



if(trim($_POST['action'])=='addedit_currencymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_QUERY_CURRENCY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_mealplan' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_MEAL_PLAN_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 


if(trim($_POST['action'])=='addedit_vehiclemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['maxpax'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$maxpax=clean($_POST['maxpax']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",maxpax="'.$maxpax.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_VEHICLE_MASTER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 




if(trim($_POST['action'])=='addedit_sightseeingmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$destinationId=clean($_POST['destinationId']);
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_SIGHTSEEING_MASTER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 




if(trim($_POST['action'])=='addedit_transfermaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$destinationId=clean($_POST['destinationId']);  
$dateAdded=time();
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_TRANSFER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 





if(trim($_POST['action'])=='addedit_transfercategory' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$destinationId=clean($_POST['destinationId']);  
$dateAdded=time();
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_TRANSFER_CATEGORY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 



if(trim($_POST['action'])=='addedit_extraquotation' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$adultCost=clean($_POST['adultCost']);  
$childCost=clean($_POST['childCost']);  
$dateAdded=time();
$namevalue ='name="'.$name.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_EXTRA_QUOTATION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_extraquotation' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$adultCost=clean($_POST['adultCost']);  
$childCost=clean($_POST['childCost']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_EXTRA_QUOTATION_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 


if(trim($_POST['action'])=='addedit_currencymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_QUERY_CURRENCY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_mealplan' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_MEAL_PLAN_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 
 



if(trim($_POST['action'])=='addedit_vehiclemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['maxpax'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$maxpax=clean($_POST['maxpax']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",maxpax="'.$maxpax.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_VEHICLE_MASTER_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 




if(trim($_POST['action'])=='addedit_sightseeingmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$destinationId=clean($_POST['destinationId']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_SIGHTSEEING_MASTER_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 


if(trim($_POST['action'])=='addedit_transfermaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$destinationId=clean($_POST['destinationId']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_TRANSFER_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 



if(trim($_POST['action'])=='addedit_transfercategory' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$destinationId=clean($_POST['destinationId']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_TRANSFER_CATEGORY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 






if($_REQUEST['action']=='countrydelete'){  
 echo 'test';
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
 
generateLogs('country','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=countrymaster&alt=3');
</script>
<?php
}

/////////////////////////////start state master//////////////////////

if(trim($_POST['action'])=='addedit_statemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['countryId'])!='' && trim($_POST['module'])!=''){ 
$countryId=clean($_POST['countryId']); 
$name=clean($_POST['name']); 
$dateAdded=time();


$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_STATE_MASTER_,$where); 
if($addnewyes=='yes'){

?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This state already exist.');
</script>
<?php

} else {

$namevalue ='name="'.$name.'",countryId="'.$countryId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_STATE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } }
if(trim($_REQUEST['action'])=='countrydelete'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
 
generateLogs('country','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=countrymaster&alt=3');
</script>
<?php
}

if(trim($_POST['action'])=='addedit_statemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''  && trim($_POST['countryId'])!='' && trim($_POST['module'])!=''){ 
$countryId=clean($_POST['countryId']); 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",countryId="'.$countryId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_STATE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_REQUEST['action'])=='statedelete'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_STATE_MASTER_,$namevalue,$where); 
 
generateLogs('state','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=statemaster&alt=3');
</script>
<?php
}

/////////////////////////////start city master//////////////////////

if(trim($_POST['action'])=='addedit_citymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['stateId'])!='' && trim($_POST['module'])!=''){ 
$stateId=clean($_POST['stateId']); 
$name=clean($_POST['name']); 
$dateAdded=time();

$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_CITY_MASTER_,$where); 
if($addnewyes=='yes'){

?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This city already exist.');
</script>
<?php

} else {

$namevalue ='name="'.$name.'",stateId="'.$stateId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_CITY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } }

if(trim($_POST['action'])=='addedit_citymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''  && trim($_POST['stateId'])!='' && trim($_POST['module'])!=''){ 
$stateId=clean($_POST['stateId']); 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",stateId="'.$stateId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_CITY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_REQUEST['action'])=='citydelete'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_CITY_MASTER_,$namevalue,$where); 
 
generateLogs('city','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=citymaster&alt=3');
</script>
<?php
}


 /////////////////start phonetype master///////////////////
if(trim($_POST['action'])=='addedit_phonetype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_PHONE_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_phonetype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_PHONE_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 

 /////////////////start emailtype master///////////////////
if(trim($_POST['action'])=='addedit_emailtype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_EMAIL_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_emailtype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_EMAIL_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 

 /////////////////start attachmenttype master///////////////////
if(trim($_POST['action'])=='addedit_attachmenttype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_ATTACHMENT_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_attachmenttype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_ATTACHMENT_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 

 /////////////////start suppliertype master///////////////////
if(trim($_POST['action'])=='addedit_suppliertype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_SUPPLIERS_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_suppliertype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_SUPPLIERS_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 

 /////////////////start querydestination master///////////////////
if(trim($_POST['action'])=='addedit_querydestination' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",destinationImage="'.$file_name.'"';  
$adds = addlisting(_DESTINATION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_querydestination' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['hotelImage2'];
}
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'",destinationImage="'.$file_name.'"';  
$update = updatelisting(_DESTINATION_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 

 /////////////////start hotelcategory master///////////////////
if(trim($_POST['action'])=='addedit_hotelcategory' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_HOTEL_CATEGORY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_hotelcategory' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_HOTEL_CATEGORY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

 /////////////////start tourtype master///////////////////
if(trim($_POST['action'])=='addedit_tourtype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_TOUR_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_tourtype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_TOUR_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

 /////////////////start amenities master///////////////////
if(trim($_POST['action'])=='addedit_amenities' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_AMENITIES_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_amenities' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_AMENITIES_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }

 /////////////////start roomtype master///////////////////
if(trim($_POST['action'])=='addedit_roomtype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_ROOM_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 

if(trim($_POST['action'])=='addedit_roomtype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_ROOM_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php }














///////////////////////delete country////////////////////
if($_REQUEST['action']=='deletecountry'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
 
generateLogs('country','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=countrymaster&alt=3');
</script>
<?php
}

///////////////////////delete state////////////////////
if($_REQUEST['action']=='deletestate'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_STATE_MASTER_,$namevalue,$where); 
 
generateLogs('state','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=statemaster&alt=3');
</script>
<?php
}

if($_REQUEST['action']=='deletecity'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_CITY_MASTER_,$namevalue,$where); 
 
generateLogs('city','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=citymaster&alt=3');
</script>
<?php
}

///////////////////////delete phone////////////////////
if($_REQUEST['action']=='deletephone'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PHONE_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs('phone','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=phonetype&alt=3');
</script>
<?php
}

///////////////////////delete amenities////////////////////
if($_REQUEST['action']=='deleteamenities'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_AMENITIES_MASTER_,$namevalue,$where); 
 
generateLogs('amenities','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=amenities&alt=3');
</script>
<?php
}

///////////////////////delete amenities////////////////////
if($_REQUEST['action']=='deleteemil'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_EMAIL_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs('email','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=emailtype&alt=3');
</script>
<?php
}

///////////////////////delete attachment////////////////////
if($_REQUEST['action']=='deleteattachment'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_ATTACHMENT_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs('attachment','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=attachmenttype&alt=3');
</script>
<?php
}

///////////////////////delete supplier////////////////////
if($_REQUEST['action']=='deletesupplier'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_SUPPLIERS_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs('supplier','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=suppliertype&alt=3');
</script>
<?php
}

///////////////////////delete querydestination////////////////////
if($_REQUEST['action']=='deletequerydestination'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_DESTINATION_MASTER_,$namevalue,$where); 
 
generateLogs('querydestination','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=querydestination&alt=3');
</script>
<?php
}

///////////////////////delete hotelcategory////////////////////
if($_REQUEST['action']=='deletehotelcategory'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_HOTEL_CATEGORY_MASTER_,$namevalue,$where); 
 
generateLogs('hotelcategory','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=hotelcategory&alt=3');
</script>
<?php
}

///////////////////////delete tourtype////////////////////
if($_REQUEST['action']=='deletetourtype'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_TOUR_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs('tourtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=tourtype&alt=3');
</script>
<?php
}

///////////////////////delete roomtype////////////////////
if($_REQUEST['action']=='deleteroomtype'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_ROOM_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=roomtype&alt=3');
</script>
<?php
}




if($_REQUEST['action']=='deletecurrencymaster'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_QUERY_CURRENCY_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=currencymaster&alt=3');
</script>
<?php
}



if($_REQUEST['action']=='deletemealplan'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_MEAL_PLAN_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=mealplan&alt=3');
</script>
<?php
}






if($_REQUEST['action']=='deletevehiclemaster'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_VEHICLE_MASTER_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=vehiclemaster&alt=3');
</script>
<?php
}





if($_REQUEST['action']=='deletesightseeingmaster'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_SIGHTSEEING_MASTER_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=sightseeingmaster&alt=3');
</script>
<?php
}




if($_REQUEST['action']=='deletetransfermaster'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_TRANSFER_MASTER_,$namevalue,$where); 
 
generateLogs('transfermaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=transfermaster&alt=3');
</script>
<?php
}







if($_REQUEST['action']=='deletetransfercategory'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_TRANSFER_CATEGORY_MASTER_,$namevalue,$where); 
 
generateLogs('transfercategory','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=transfercategory&alt=3');
</script>
<?php
}






if($_REQUEST['action']=='deleteextraquotation'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_EXTRA_QUOTATION_MASTER_,$namevalue,$where); 
 
generateLogs('extraquotation','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=extraquotation&alt=3');
</script>
<?php
}




if(trim($_POST['action'])=='currencyconversion' && trim($_POST['editId'])=='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyValue'])!=''){ 

$currencyFrom=clean($_POST['currencyFrom']); 
$currencyTo=clean($_POST['currencyTo']); 
$currencyValue=clean($_POST['currencyValue']);  
$dateAdded=time();

$where='currencyFrom="'.$currencyFrom.'" and currencyTo="'.$currencyTo.'" ';  
$addnewyes = checkduplicate(_CURRENCY_CONVERSION_MASTER_,$where); 
if($addnewyes=='yes'){

?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This Currency already exist.');
</script>
<?php

} else {

$namevalue ='currencyFrom="'.$currencyFrom.'",currencyTo="'.$currencyTo.'",currencyValue="'.$currencyValue.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_CURRENCY_CONVERSION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } }





if(trim($_POST['action'])=='currencyconversion' && trim($_POST['editId'])!='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyValue'])!=''){  

 $currencyFrom=clean($_POST['currencyFrom']); 
$currencyTo=clean($_POST['currencyTo']); 
$currencyValue=clean($_POST['currencyValue']);  
$dateAdded=time();

  
$namevalue ='currencyFrom="'.$currencyFrom.'",currencyTo="'.$currencyTo.'",currencyValue="'.$currencyValue.'",modifyDate="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'"';  
$where='id="'.$_POST['editId'].'"';  
$update = updatelisting(_CURRENCY_CONVERSION_MASTER_,$namevalue,$where);  
 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php
}




if($_REQUEST['action']=='deletecurrencConversionymaster'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 


$sql_del="delete from "._CURRENCY_CONVERSION_MASTER_."  where id='".$ansval."'"; 
mysqli_query($sql_del) or die(mysqli_error(db()));
 
generateLogs('currencconversion','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=3');
</script>
<?php
}


if(trim($_POST['action'])=='addedit_packagetheme' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_PACKAGE_THEME_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 


if(trim($_POST['action'])=='addedit_packagetheme' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_PACKAGE_THEME_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 






if(trim($_POST['action'])=='addedit_cruisecompanymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'"';  
$adds = addlisting(_CRUISE_COMPANY_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 





if(trim($_POST['action'])=='addedit_cruisecompanymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'"';  
$update = updatelisting(_CRUISE_COMPANY_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 





if(trim($_POST['action'])=='addedit_cabintypemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'"';  
$update = updatelisting(_CABIN_TYPE_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 



if(trim($_POST['action'])=='addedit_cabintypemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'"';  
$adds = addlisting(_CABIN_TYPE_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 






 


if(trim($_POST['action'])=='addedit_cruisetypemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!='' && trim($_POST['companyId'])!='0'){ 
$name=clean($_POST['name']); 
$companyId=clean($_POST['companyId']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",companyId="'.$companyId.'"';  
$adds = addlisting(_CRUISE_TYPE_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 



if(trim($_POST['action'])=='addedit_cabincategorymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$namevalue ='name="'.$name.'"';  
$adds = addlisting(_CABIN_CATEGORY_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 


if(trim($_POST['action'])=='addedit_cruisetypemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!='' && trim($_POST['companyId'])!='0'){ 
$name=clean($_POST['name']); 
$companyId=clean($_POST['companyId']); 
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",companyId="'.$companyId.'"';  
$update = updatelisting(_CRUISE_TYPE_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 




if(trim($_POST['action'])=='addedit_cabincategorymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'"';  
$update = updatelisting(_CABIN_CATEGORY_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 












if($_REQUEST['action']=='deletepackagetheme'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_THEME_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=packagetheme&alt=3');
</script>
<?php
}















if($_REQUEST['action']=='deletepackagecruisecompany'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 

$sql_del="delete from "._CRUISE_COMPANY_."  where id='".$ansval."'"; 
mysqli_query($sql_del) or die(mysqli_error(db()));

} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cruisecompanymaster&alt=3');
</script>
<?php
}






if($_REQUEST['action']=='deletepackagecruisetype'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 

$sql_del="delete from "._CRUISE_TYPE_."  where id='".$ansval."'"; 
mysqli_query($sql_del) or die(mysqli_error(db()));

} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cruisetypemaster&alt=3');
</script>
<?php
}





if($_REQUEST['action']=='deletecabintype'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 

$sql_del="delete from "._CABIN_TYPE_."  where id='".$ansval."'"; 
mysqli_query($sql_del) or die(mysqli_error(db()));

} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cabintypemaster&alt=3');
</script>
<?php
}






if($_REQUEST['action']=='deletecabincategory'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 

$sql_del="delete from "._CABIN_CATEGORY_."  where id='".$ansval."'"; 
mysqli_query($sql_del) or die(mysqli_error(db()));

} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cabincategorymaster&alt=3');
</script>
<?php
}





if(trim($_POST['action'])=='addedit_inclusion' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_PACKAGE_INCLUSION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 

<?php } 




if(trim($_POST['action'])=='addedit_inclusion' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_PACKAGE_INCLUSION_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 

<?php } 


if($_REQUEST['action']=='deleteinclusion'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

  
$namevalue ='deletestatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_INCLUSION_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=inclusion&alt=3');
</script>
<?php
}













if(trim($_POST['action'])=='addedit_packagehotelmaster' && trim($_POST['editId'])=='' && trim($_POST['hotelName'])!=''){ 

$hotelName=clean($_POST['hotelName']); 
$hotelCity=clean($_POST['hotelCity']); 
$hotelCountry=clean($_POST['hotelCountry']);  
$hotelAddress=clean($_POST['hotelAddress']);  
$hotelCategory=clean($_POST['hotelCategory']);  
$supplier=clean($_POST['supplier']);  
$status=clean($_POST['status']);  

if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}


$dateAdded=time();

$namevalue ='hotelName="'.$hotelName.'",hotelCity="'.$hotelCity.'",hotelCountry="'.$hotelCountry.'",hotelAddress="'.$hotelAddress.'",hotelCategory="'.$hotelCategory.'",hotelImage="'.$file_name.'",status="'.$status.'",supplier="'.$supplier.'"';  
$adds = addlisting(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagehotelmaster&alt=1');
</script> 

<?php  }




if(trim($_POST['action'])=='addedit_packagehotelmaster' && trim($_POST['editId'])!='' && trim($_POST['hotelName'])!=''){ 

$hotelName=clean($_POST['hotelName']); 
$hotelCity=clean($_POST['hotelCity']); 
$hotelCountry=clean($_POST['hotelCountry']);  
$hotelAddress=clean($_POST['hotelAddress']);  
$hotelCategory=clean($_POST['hotelCategory']);  
$status=clean($_POST['status']);  

$editId=clean($_POST['editId']); 


if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['hotelImage2'];
}


$dateAdded=time();

$namevalue ='hotelName="'.$hotelName.'",hotelCity="'.$hotelCity.'",hotelCountry="'.$hotelCountry.'",hotelAddress="'.$hotelAddress.'",hotelCategory="'.$hotelCategory.'",hotelImage="'.$file_name.'",status="'.$status.'"';  


$where='id='.$_POST['editId'].''; 
$update = updatelisting(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=packagehotelmaster&alt=2');
</script> 

<?php  }







if(trim($_POST['action'])=='addedit_packagesightseeingmaster' && trim($_POST['editId'])=='' && trim($_POST['sightseeingName'])!=''){ 

$sightseeingName=clean($_POST['sightseeingName']); 
$sightseeingCity=clean($_POST['sightseeingCity']); 
$sightseeingDetail=addslashes($_POST['sightseeingDetail']); 
$sightseeingType=clean($_POST['sightseeingType']);  
$status=clean($_POST['status']);  

if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}


$dateAdded=time();

$namevalue ='sightseeingName="'.$sightseeingName.'",sightseeingCity="'.$sightseeingCity.'",sightseeingDetail="'.$sightseeingDetail.'",sightseeingImage="'.$file_name.'",sightseeingType="'.$sightseeingType.'",status="'.$status.'"';  
$adds = addlisting(_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagesightseeingmaster&alt=1');
</script> 

<?php  }




if(trim($_POST['action'])=='addedit_packagesightseeingmaster' && trim($_POST['editId'])!='' && trim($_POST['sightseeingName'])!=''){ 

$sightseeingName=clean($_POST['sightseeingName']); 
$sightseeingCity=clean($_POST['sightseeingCity']); 
$sightseeingDetail=addslashes($_POST['sightseeingDetail']);
$sightseeingType=clean($_POST['sightseeingType']);    
$status=clean($_POST['status']); 

$editId=clean($_POST['editId']); 


if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['hotelImage2'];
}


$dateAdded=time();

$namevalue ='sightseeingName="'.$sightseeingName.'",sightseeingCity="'.$sightseeingCity.'",sightseeingDetail="'.$sightseeingDetail.'",sightseeingImage="'.$file_name.'",sightseeingType="'.$sightseeingType.'",status="'.$status.'"'; 


$where='id='.$_POST['editId'].''; 
$update = updatelisting(_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=packagesightseeingmaster&alt=2');
</script> 

<?php  }










if(trim($_POST['action'])=='addedit_packagetransfermaster' && trim($_POST['editId'])=='' && trim($_POST['transferName'])!=''){ 

$transferName=clean($_POST['transferName']); 
$transferCity=clean($_POST['transferCity']); 
$transferDetail=addslashes($_POST['transferDetail']);   
$transferType=clean($_POST['transferType']); 
$status=clean($_POST['status']);  

if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}


$dateAdded=time();

$namevalue ='transferName="'.$transferName.'",transferCity="'.$transferCity.'",transferDetail="'.$transferDetail.'",transferImage="'.$file_name.'",transferType="'.$transferType.'",status="'.$status.'"';   
$adds = addlisting(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagetransfermaster&alt=1');
</script> 

<?php  }




if(trim($_POST['action'])=='addedit_packagetransfermaster' && trim($_POST['editId'])!='' && trim($_POST['transferName'])!=''){ 

$transferName=clean($_POST['transferName']); 
$transferCity=clean($_POST['transferCity']); 
$transferDetail=addslashes($_POST['transferDetail']); 
$transferType=clean($_POST['transferType']); 
$status=clean($_POST['status']); 

$editId=clean($_POST['editId']); 


if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['hotelImage2'];
}


$dateAdded=time();

$namevalue ='transferName="'.$transferName.'",transferCity="'.$transferCity.'",transferDetail="'.$transferDetail.'",transferImage="'.$file_name.'",transferType="'.$transferType.'",status="'.$status.'"'; 


$where='id='.$_POST['editId'].''; 
$update = updatelisting(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=packagetransfermaster&alt=2');
</script> 

<?php  }








if(trim($_POST['action'])=='addedit_packageairlinemaster' && trim($_POST['editId'])=='' && trim($_POST['flightName'])!=''){ 

$flightName=clean($_POST['flightName']); 
$flightCity=clean($_POST['flightCity']); 
$flightNo=clean($_POST['flightNo']);    
$status=clean($_POST['status']);  

if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}


$dateAdded=time();

$namevalue ='flightName="'.$flightName.'",flightCity="'.$flightCity.'",flightNo="'.$flightNo.'",flightImage="'.$file_name.'",status="'.$status.'"';   
$adds = addlisting(_PACKAGE_BUILDER_AIRLINES_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packageairlinemaster&alt=1');
</script> 

<?php  }






if(trim($_POST['action'])=='addedit_packageairlinemaster' && trim($_POST['editId'])!='' && trim($_POST['flightName'])!=''){ 

$flightName=clean($_POST['flightName']); 
$flightCity=clean($_POST['flightCity']); 
$flightNo=clean($_POST['flightNo']);    
$status=clean($_POST['status']);  

if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['hotelImage2'];
}


$dateAdded=time();

$namevalue ='flightName="'.$flightName.'",flightCity="'.$flightCity.'",flightNo="'.$flightNo.'",flightImage="'.$file_name.'",status="'.$status.'"';   
 $where='id='.$_POST['editId'].''; 
$update = updatelisting(_PACKAGE_BUILDER_AIRLINES_MASTER_,$namevalue,$where); 

?>
<script>
parent.setupbox('showpage.crm?module=packageairlinemaster&alt=2');
</script> 

<?php  }









if(trim($_POST['action'])=='addeditpackagesupplier_packagehotelmaster' && trim($_POST['supplierId'])!=''){ 

$hotelId=decode(clean($_POST['hotelId'])); 
$supplierId=clean($_POST['supplierId']); 


$dateAdded=time();

$namevalue ='hotelId="'.$hotelId.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
$adds = addlisting(_PACKAGE_HOTEL_SUPPLIER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagehotelmaster&supplier=1&hotelid=<?php echo $_POST['hotelId'];?>&alt=1');
</script> 

<?php  }

if(trim($_POST['action'])=='addeditpackagesupplier_packagesightseeingmaster' && trim($_POST['supplierId'])!=''){ 

$sightseeingid=decode(clean($_POST['sightseeingid'])); 
$supplierId=clean($_POST['supplierId']); 


$dateAdded=time();

$namevalue ='sightseeingId="'.$sightseeingid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
$adds = addlisting(_PACKAGE_SIGHTSEEING_SUPPLIER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagesightseeingmaster&supplier=1&sightseeingid=<?php echo $_POST['sightseeingid'];?>&alt=1');
</script> 

<?php  }

if(trim($_POST['action'])=='addeditpackagesupplier_packagetransfermaster' && trim($_POST['supplierId'])!=''){ 

$transferid=decode(clean($_POST['transferid'])); 
$supplierId=clean($_POST['supplierId']); 


$dateAdded=time();

$namevalue ='transferId="'.$transferid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
$adds = addlisting(_PACKAGE_TRANSFER_SUPPLIER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagetransfermaster&supplier=1&transferid=<?php echo $_POST['transferid'];?>&alt=1');
</script> 

<?php  }


if(trim($_POST['action'])=='addedit_certificatelogomaster'){ 
$name=clean($_POST['name']);   
$status=clean($_POST['status']); 

$editId=clean($_POST['editId']); 


if(!empty($_FILES['hotelImage']['name'])){  
$file_name=str_replace(' ', '_',time().$_FILES['hotelImage']['name']);  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{
$file_name=str_replace(' ', '_',$_REQUEST['hotelImage2']);
}
$dateAdded=time();

$namevalue ='name="'.$name.'",logo="'.$file_name.'",status="'.$status.'"';   
$where='id='.$_POST['editId'].''; 
if($editId!='')
{
$update = updatelisting(_CERTIFICATE_MASTER_,$namevalue,$where); }else
{$adds = addlisting(_CERTIFICATE_MASTER_,$namevalue);}

 ?>
<script>
parent.setupbox('showpage.crm?module=certificatelogomaster&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
</script> 

<?php  }















if(trim($_POST['action'])=='addedit_cruisemaster' && trim($_POST['editId'])=='' && trim($_POST['cruiseName'])!=''){ 

$cruiseCompany=clean($_POST['cruiseCompany']); 
$cabinNumber=clean($_POST['cabinNumber']); 
$cruiseType=clean($_POST['cruiseType']);  
$destination=clean($_POST['destination']);  
$cruiseName=clean($_POST['cruiseName']);  
$duration=clean($_POST['duration']);  
$cabinCategory=clean($_POST['cabinCategory']);  
$cabinType=clean($_POST['cabinType']);  
$status=clean($_POST['status']);  
$price=clean($_POST['price']);  

if(!empty($_FILES['cruiseImage']['name'])){  
$file_name=time().$_FILES['cruiseImage']['name'];  
copy($_FILES['cruiseImage']['tmp_name'],"packageimages/".$file_name); 
}


$dateAdded=time();

$namevalue ='cruiseCompany="'.$cruiseCompany.'",cabinNumber="'.$cabinNumber.'",cruiseType="'.$cruiseType.'",destination="'.$destination.'",cruiseName="'.$cruiseName.'",duration="'.$duration.'",cabinCategory="'.$cabinCategory.'",cabinType="'.$cabinType.'",status="'.$status.'",cruiseImage="'.$file_name.'",price="'.$price.'"';  
$adds = addlisting(_CRUISE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cruisemaster&alt=1');
</script> 

<?php  }




if(trim($_POST['action'])=='addedit_cruisemaster' && trim($_POST['editId'])!='' && trim($_POST['cruiseName'])!=''){ 

$cruiseCompany=clean($_POST['cruiseCompany']); 
$cabinNumber=clean($_POST['cabinNumber']); 
$cruiseType=clean($_POST['cruiseType']);  
$destination=clean($_POST['destination']);  
$cruiseName=clean($_POST['cruiseName']);  
$duration=clean($_POST['duration']);  
$cabinCategory=clean($_POST['cabinCategory']);  
$cabinType=clean($_POST['cabinType']);  
$status=clean($_POST['status']);  
$price=clean($_POST['price']);    

$editId=clean($_POST['editId']); 


if(!empty($_FILES['cruiseImage']['name'])){  
$file_name=time().$_FILES['cruiseImage']['name'];  
copy($_FILES['cruiseImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['cruiseImage2'];
}


$dateAdded=time();

$namevalue ='cruiseCompany="'.$cruiseCompany.'",cabinNumber="'.$cabinNumber.'",cruiseType="'.$cruiseType.'",destination="'.$destination.'",cruiseName="'.$cruiseName.'",duration="'.$duration.'",cabinCategory="'.$cabinCategory.'",cabinType="'.$cabinType.'",status="'.$status.'",cruiseImage="'.$file_name.'",price="'.$price.'"';  

$where='id='.$_POST['editId'].''; 
$update = updatelisting(_CRUISE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=cruisemaster&alt=2');
</script> 

<?php  }











if($_REQUEST['action']=='deletecruise'){  

$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 

$sql_del="delete from "._CRUISE_MASTER_."  where id='".$ansval."'"; 
mysqli_query($sql_del) or die(mysqli_error(db()));

} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cruisemaster&alt=3');
</script>
<?php
}










if(trim($_POST['action'])=='addeditpackageCruisesupplier_cruisemaster' && trim($_POST['supplierId'])!=''){ 



$cruiseid=decode(clean($_POST['cruiseid'])); 

$supplierId=clean($_POST['supplierId']); 





$dateAdded=time();



$namevalue ='cruiseid="'.$cruiseid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   

$adds = addlisting(_PACKAGE_CRUISE_SUPPLIER_MASTER_,$namevalue); 

?>

<script>

parent.setupbox('showpage.crm?module=cruisemaster&supplier=1&cruiseid=<?php echo $_POST['cruiseid'];?>&alt=1');

</script> 



<?php  }











if(trim($_POST['action'])=='addCruiseSupplierRate' && trim($_POST['supplierId'])!='' && trim($_POST['cruiseid'])!=''){ 



$cruiseid=(clean($_POST['cruiseid']));

$supplierId=clean($_POST['supplierId']);
$fromDate=date('Y-m-d',strtotime($_POST['fromDate']));
$toDate=date('Y-m-d',strtotime($_POST['toDate']));
$price=clean($_POST['price']);

$select='';
$where='';
$rs='';  
$select='*'; 
$where=' cruiseid="'.$cruiseid.'" and supplierId="'.$supplierId.'" order by id asc'; 
$rs=GetPageRecord($select,_PACKAGE_CRUISE_RATE_,$where); 
$count = mysqli_num_rows($rs);
$editresult=mysqli_fetch_array($rs);

$dateAdded=time();
$namevalue ='fromDate="'.$fromDate.'",toDate="'.$toDate.'",price="'.$price.'",cruiseid="'.$cruiseid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'"';  
if($count > 0){
$where = 'id="'.$editresult['id'].'"';
$update = updatelisting(_PACKAGE_CRUISE_RATE_,$namevalue,$where);
}else{
$adds = addlisting(_PACKAGE_CRUISE_RATE_,$namevalue); 
}
?>

<script>
parent.setupbox('showpage.crm?module=cruisemaster&supplier=1&cruiseid=<?php echo encode($cruiseid); ?>&alt=1');
</script> 
<?php  }


if(trim($_POST['action'])=='cms_add_gallery' && trim($_POST['title'])!=''){ 

if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}

$type='memoriesGallery';
$title=clean($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);

    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$package_theme.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=gallery&alt=1');
</script> 
<?php } else {

$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$package_theme.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);

?>
<script>
parent.setupbox('showpage.crm?module=cms&page=gallery&alt=2');
</script> 
<?php }?>

<?php } 

if(trim($_POST['action'])=='cms_add_images' && trim($_POST['title'])!=''){ 

if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}

$type='memoriesImages';
$title=clean($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);

    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$cid=$_POST['cid'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$cid.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=add-images&cid=<?php echo $cid;?>&alt=1');
</script> 
<?php } else {
$cid=$_POST['cid'];
$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$cid.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);

?>
<script>
parent.setupbox('showpage.crm?module=cms&page=add-images&cid=<?php echo $cid;?>&alt=2');
</script> 
<?php }?>

<?php } 

if(trim($_POST['action'])=='cms_add_blog' && trim($_POST['title'])!=''){ 

if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}

if($_FILES['file2']['name']!=''){ 
echo $file_name=$_FILES['file2']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file2']['tmp_name'],"upload/".$file_name);

 $image2=$file_name;
} else {
$image2=$_REQUEST['feature_img2'];
}

$type='blog';
$post_date=clean($_POST['post_date']);
$post_date=date("Y-m-d", strtotime($post_date));
$title=clean($_POST['title']);
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);

$feature_img2=clean($_POST['image2']);
$designation=clean($_POST['designation']);
$meta_title=clean($_POST['meta_title']);
$meta_description=clean($_POST['meta_description']);
$meta_keyword=clean($_POST['meta_keyword']);

$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",description="'.$description.'",designation="'.$designation.'",home_text="'.$home_text.'",post_date="'.$post_date.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image2="'.$image2.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=blog&alt=1');
</script> 
<?php } else {

$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",description="'.$description.'",designation="'.$designation.'",home_text="'.$home_text.'",post_date="'.$post_date.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image2="'.$image2.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);

?>
<script>
parent.setupbox('showpage.crm?module=cms&page=blog&alt=2');
</script> 
<?php }?>

<?php } 

if(trim($_POST['action'])=='cms_add_banner' && trim($_POST['title'])!=''){ 

if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}

$type='banner';
$title=clean($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);

    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=banner&alt=1');
</script> 
<?php } else {

$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);

?>
<script>
parent.setupbox('showpage.crm?module=cms&page=banner&alt=2');
</script> 
<?php }?>

<?php } 


if(trim($_POST['action'])=='addedit_vehiclebrandmaster' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']);  
    $brandName=clean($_POST['brandName']); 
    $vehicleType=clean($_POST['vehicleType']); 
    $status=clean($_POST['status']); 
    $dateAdded=time();

    // if(!empty($_FILES['vehicleImage']['name'])){  
    // $image=time().$_FILES['vehicleImage']['name'];  
    // copy($_FILES['vehicleImage']['tmp_name'],"packageimages/".$image); 
    // } else{
    // $image = $_REQUEST['vehicleImage2'];
    // }

    $where='name="'.$name.'" and deletestatus=0';  
    $addnewyes = checkduplicate(_VEHICLE_BRAND_MASTER_,$where); 
    if($addnewyes=='yes' && $_POST['editId']==''){ ?>
    <script>
    parent.$('#pageloader').hide();
    parent.$('#pageloading').hide();
    alert('<?php echo $name; ?> already exist.');
    </script>
    <?php

    } else {

    $namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",brandName="'.$brandName.'",vehicleType="'.$vehicleType.'",status="'.$status.'"';  
    //$adds = addlisting(_VEHICLE_BRAND_MASTER_,$namevalue); 

    $editId=$_POST['editId'];
    $where='id='.$editId.''; 
        if($editId!='')
        {
        $update = updatelisting(_VEHICLE_BRAND_MASTER_,$namevalue,$where); echo $where;}else
        {$adds = addlisting(_VEHICLE_BRAND_MASTER_,$namevalue);}
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
        </script> 

        <?php } }

        if($_REQUEST['action']=='vehiclebranddelete'){  
        echo 'test';
        $check_list=$_REQUEST['check_list'];  
        if($check_list!=""){  
        for($i=0;$i<=count($check_list)-1;$i++) 
        { 
        $ansval=trim(decode($check_list[$i])); 
        if(trim($ansval) != ''){   

        
        $namevalue ='status="0"';   
        $where='id="'.$ansval.'"';  
        $update = updatelisting(_VEHICLE_BRAND_MASTER_,$namevalue,$where); 
        
        generateLogs('vehiclebrand','delete',$ansval);
        } } } 
        ?>
        <script>
        parent.setupbox('showpage.crm?module=vehiclebrandmaster&alt=3');
        </script>
        <?php
        }

        /*if(trim($_POST['action'])=='addedit_vehiclebrandmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
        $name=clean($_POST['name']); 
        $modifyDate=time();


        
        $where='id='.$_POST['editId'].''; 
        $namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
        $update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
        </script> 

        <?php }*/ 
 ?>





 