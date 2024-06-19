<?php 
if($_REQUEST['ferryTransferId']!=''){  
	$aaaaaa=GetPageRecord('*','ferryPriceMaster', 'id="'.decode($_REQUEST['ferryTransferId']).'"'); 
	$FerryPrice=mysqli_fetch_array($aaaaaa);  
}  
?> 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
<td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>  
     </td>
        <td width="95%" align="left"><?php echo $FerryPrice['name']; ?></td>
  </tr>
  
</table>
</div>
<div id="loadFerrymaster"></div>



<script>  

function funloadFerrymaster(){ 
$('#loadFerrymaster').load('loadferryprice.php?serviceid=<?php echo decode($_REQUEST['ferryTransferId']); ?>'); 
}

funloadFerrymaster();

$('#addnewuserbtn').show();
</script>