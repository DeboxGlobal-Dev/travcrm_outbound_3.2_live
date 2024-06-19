<?php 
include "inc.php";  
include "config/logincheck.php";   
$quotationId=$_REQUEST['quotationId'];
$supplierStatusId=$_REQUEST['supplierStatusId'];


if(trim($_REQUEST['action'])=='deleteotherGuest' && $_REQUEST['delId']!=''){  
	$sql_del="delete from otherLeadPaxDetails  where id='".$_REQUEST['delId']."'";  
	mysqli_query(db(),$sql_del) or die(mysqli_error(db())); 

}


if(trim($_REQUEST['action'])=='saveotherGuest'  && $_REQUEST['quotationId']!='' && $_REQUEST['supplierStatusId']!='' && $_REQUEST['otherGuestName']!=''){  

	$namevalue ='otherGuestName="'.addslashes(trim($_REQUEST['otherGuestName'])).'",quotationId="'.addslashes(trim($_REQUEST['quotationId'])).'",supplierStatusId="'.addslashes(trim($_REQUEST['supplierStatusId'])).'"'; 
	addlistinggetlastid('otherLeadPaxDetails',$namevalue); 



}
?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-top:5px;">
<tr>
<td width="16%"><span><strong>Other Pax Details </strong>:</span></td>
<?php 

$cnt=1;	
$rs12=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$_REQUEST['quotationId'].'" and supplierStatusId="'.$_REQUEST['supplierStatusId'].'"');  
while($editresult2=mysqli_fetch_array($rs12)){
?>

<!-- <td width="63%">Pax <?php echo $cnt; ?></td> -->
<td align="left"><?php echo $editresult2['otherGuestName']; ?>&nbsp;&nbsp;&nbsp; <i class="fa fa-trash removeEle"  aria-hidden="true" style="font-size: 13px; color: red; cursor:pointer;" onclick="delother('<?php echo $editresult2['id']; ?>','<?php echo $editresult2['supplierStatusId']; ?>');"></i> <strong>|</strong>&nbsp;&nbsp;</td>


<?php 
$cnt++;
} ?>
</tr>
</table>
