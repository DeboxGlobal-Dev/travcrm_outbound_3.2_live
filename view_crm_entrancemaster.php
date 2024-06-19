<?php 
if($_REQUEST['entranceId']!=''){  
	$aaaaaa=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.decode($_REQUEST['entranceId']).'"'); 
	$otherActivityData=mysqli_fetch_array($aaaaaa);
}
?> 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
<td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>  
     </td>
        <td width="95%" align="left"><?php echo $otherActivityData['entranceName']; ?></td>
  </tr>
  
</table>
</div>
<div id="loadhotelmaster"></div>



<script>  

function funloadentrancemaster(){ 
$('#loadhotelmaster').load('loadentrancemaster.php?serviceid=<?php echo decode($_REQUEST['entranceId']); ?>'); 
}
 

funloadentrancemaster();
 

$('#addnewuserbtn').show();
</script>