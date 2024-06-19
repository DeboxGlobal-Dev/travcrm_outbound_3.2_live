<?php 
include "inc.php";

$quotationId=$_REQUEST['quotationId'];
$queryId=$_REQUEST['queryId'];
$datef=time(); 
if($_FILES['insurenceVoucher']['name']!=''){ 
    $file_name=$_FILES['insurenceVoucher']['name']; 
    $ext=$file_name;
    $file_name=str_replace (" ", "",$datef.$ext);
    copy($_FILES['insurenceVoucher']['tmp_name'],"upload/".$file_name);
    
    $image=$file_name;
}   

$namevalue2 ='insurenceVoucher="'.$image.'",quotationId="'.$quotationId.'",queryId="'.$queryId.'"';
$lastId = addlistinggetlastid('finalQuoteInsurence',$namevalue2); 

?>