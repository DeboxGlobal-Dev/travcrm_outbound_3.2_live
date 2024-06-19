<?php 
include "inc.php";   
include "config/mail.php";
 
 
$select4=''; 
$where4=''; 
$rs4='';   
$select4='*';  
$where4='id=1'; 
$rs4=GetPageRecord($select4,_VOUCHER_SETTING_MASTER_,$where4); 
$resultmainmail=mysqli_fetch_array($rs4); 
 
 
 
$mailto=$resultmainmail['groupEmailId']; 
$ccmail='';
$fromemail=''; 
$mailsubject=''.date('d-m-Y',strtotime("-1 days")).' Sales Report';
$maildescription=url_get_contents(''.$fullurl.'report_mail.php').'<br><br><br><div style="color: #a1a1a1; font-size: 12px;">Note: This is auto generated mail by travCRM.</div>'; 
  
send_template_mail($fromemail,$mailto,$mailsubject,$maildescription,$ccmail);  
?>




