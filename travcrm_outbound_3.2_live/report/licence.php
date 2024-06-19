<?php 
include "../inc.php";  
?>
<div style="display:nones;">
	<?php  
 	
	$select=$rs=$where='';
	$select='*'; 
	echo $where='id="'.$adminData['id'].'" '; 
	$rs=GetPageRecord($select,_USER_MASTER_,$where); 
	$adminData2=mysqli_fetch_array($rs);  
  
	$expiredOn = strtotime($adminData2['expiryDate']); 
	$diff = abs($expiredOn - time());
		
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days2 = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	 
	  
	
	?> 
</div>
<div style=" padding:40px 0px; width:100%; background-color:#4B4B4B; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#333333; ">
<div style="background-color:#fff; width:800px; padding:0px; margin:auto; border-top:8px #ffc115 solid;    box-shadow: 0px 0px 13px #0000007d;">
<div><img src="<?php echo $fullurl; ?>report/reportbanner.png"></div>
<br>
<h2 style="    text-align: center; margin: 0px; padding: 20px; border-bottom: 1px #cccccc69 solid; background-color: #cccccc26;">Licence Expire Report  - <?php echo date('D d M Y',strtotime($adminData['expiryDate'])); ?></h2>
<br>
<div style="padding:30px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> Your subscription is getting expired in <?php echo $days2;  ?> days </tr>
</table> 
</div>
<div style="padding:30px;background-color: #cccccc26; text-align:center; ">
<img src="<?php echo $fullurl; ?>images/travCRM-highres-logo.png" width="109"><br>
<br>
Powered by travCRM
</div>

</div>
</div>
