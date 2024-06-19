<?php
include "inc.php"; 
include "config/logincheck.php";
if($_REQUEST['nights']!=''){
$nights=$_REQUEST['nights'];
} else { 
$nights=0;
} 
echo $_REQUEST['id'];
if($_REQUEST['id']!=''){
$dayTitle = addslashes($_REQUEST['dayTitle']);
$daydescription = addslashes($_REQUEST['daydescription']);
$id = addslashes($_REQUEST['id']);  
$namevalue ='title="'.$dayTitle.'",remarks="'.$daydescription.'"';   
$where='id='.$id.'';  
$lastid = updatelisting('newPackageDays',$namevalue,$where); 
}



 

?>

 