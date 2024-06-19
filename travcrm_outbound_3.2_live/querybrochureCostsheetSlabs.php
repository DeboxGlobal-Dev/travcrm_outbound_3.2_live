<?php 
ob_start();   
include "inc.php";  

if($_REQUEST['queryId']!='' && $_REQUEST['brochureslabfrompax']!='' && $_REQUEST['brochureslabtopax']!='' && $_REQUEST['brochureslabgroupmanager']!=''){
	$brochureslabfrompax=$_REQUEST['brochureslabfrompax'];
	$brochureslabtopax=$_REQUEST['brochureslabtopax'];
	$brochureslabgroupmanager=$_REQUEST['brochureslabgroupmanager'];
	$queryId=$_REQUEST['queryId'];
	
	$namevalue ='queryId="'.$queryId.'",fromPax="'.$brochureslabfrompax.'",toPax="'.$brochureslabtopax.'",brochureslabgroupmanager="'.$brochureslabgroupmanager.'"';
	addlisting('inboundCostsheetSlabsMaster',$namevalue); 
}




if($_REQUEST['queryId']!='' && $_REQUEST['did']!=''){	
	$sql_del="delete from inboundCostsheetSlabsMaster  where id='".$_REQUEST['did']."'"; 
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
}

?>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>From Pax </strong></td>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>To Pax </strong></td>
    <td width="15%" align="center" bgcolor="#F5F5F5"><strong>Tour&nbsp;Manager</strong></td>
     <td bgcolor="#F5F5F5"><strong>Action</strong></td>
  </tr>
 <?php  
$rs=GetPageRecord('*','inboundCostsheetSlabsMaster','queryId="'.$_REQUEST['queryId'].'" order by id');
if(mysqli_num_rows($rs)>0){
?>
<script>$('#discountSlabs').val('1');</script>
<?php 
while($rest=mysqli_fetch_array($rs)){  ?>
  <tr>
    <td width="15%" align="center"><?php echo $rest['fromPax']; ?></td>
    <td width="15%" align="center"><?php echo $rest['toPax']; ?></td>
    <td width="15%" align="center"><?php echo $rest['brochureslabgroupmanager']; ?></td>
     <td><a  style="font-size:12px; color:#CC0000 !important; cursor:pointer; " onClick="deletebrochurediscountslab('<?php echo $rest['id']; ?>');">Delete</a></td>
  </tr>
  <?php } } ?>
  <tr>
    <td width="15%" align="center"><input name="brochureslabfrompax" type="number" id="brochureslabfrompax" style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="1"></td>
    <td width="15%" align="center"><input name="brochureslabtopax" type="number" id="brochureslabtopax"  style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="1"></td>
    <td width="15%" align="center"><input name="brochureslabgroupmanager" type="number" id="brochureslabgroupmanager" style="padding:6px; border:1px solid #ccc; text-align:center; width:100%; box-sizing:border-box;" min="0">
      <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Add" onClick="savebrochurediscountslab();" ></td>
  </tr>
</table>
<script>
function deletebrochurediscountslab(id){
	$('#brochureCostsheetSlabs').load('querybrochureCostsheetSlabs.php?queryId=<?php echo $_REQUEST['queryId']; ?>&did='+id);
}


function savebrochurediscountslab(){
	var brochureslabfrompax = $('#brochureslabfrompax').val();
	var brochureslabtopax = $('#brochureslabtopax').val();
	var brochureslabgroupmanager = $('#brochureslabgroupmanager').val();
	$('#brochureCostsheetSlabs').load('querybrochureCostsheetSlabs.php?queryId=<?php echo $_REQUEST['queryId']; ?>&brochureslabfrompax='+brochureslabfrompax+'&brochureslabtopax='+brochureslabtopax+'&brochureslabgroupmanager='+brochureslabgroupmanager);
}
</script>


