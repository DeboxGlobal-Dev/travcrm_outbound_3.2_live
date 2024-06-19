<?php 
include "inc.php";

if($_REQUEST['action']=='hotel' && $_REQUEST['id']!='' && $_REQUEST['st']!='' ){

$namevalue ='shareQuoteStatus="'.$_REQUEST['st'].'"';   
$where='id="'.decode($_REQUEST['id']).'" ';  
$update = updatelisting('finalQuote',$namevalue,$where); 

}
if($_REQUEST['action']=='transfer' && $_REQUEST['id']!='' && $_REQUEST['st']!='' ){
	
	$namevalue ='shareQuoteStatus="'.$_REQUEST['st'].'"';   
	$where='id="'.decode($_REQUEST['id']).'" ';  
	$update = updatelisting('finalQuotetransfer',$namevalue,$where); 

}

if($_REQUEST['action']=='entrance' && $_REQUEST['id']!='' && $_REQUEST['st']!='' ){
	
	$namevalue ='shareQuoteStatus="'.$_REQUEST['st'].'"';   
	$where='id="'.decode($_REQUEST['id']).'" ';  
	$update = updatelisting('finalQuoteEntrance',$namevalue,$where); 

}
if($_REQUEST['action']=='activity' && $_REQUEST['id']!='' && $_REQUEST['st']!='' ){
	
	$namevalue ='shareQuoteStatus="'.$_REQUEST['st'].'"';   
	$where='id="'.decode($_REQUEST['id']).'" ';  
	$update = updatelisting('finalQuoteActivity',$namevalue,$where); 

}
?>
<div style="margin:auto; width:800px; background-color:#FFFFFF; border:5px solid #ccc; padding:20px; text-align:center;">
<div style="padding:50px 50px; font-size:40px; padding-bottom:30px;">Thank You</div>
<div style="font-size:16px;">Your quotation has been submitted successfully!</div>
</div>