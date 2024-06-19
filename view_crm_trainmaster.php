<?php 
if($_REQUEST['id']!=''){  
$trainQuery=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.decode($_REQUEST['id']).'"'); 
$trainData=mysqli_fetch_array($trainQuery);
?> 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>    
     </td>
    <td width="93%" align="left">Train Name:&nbsp;<?php echo $trainData['trainName']; ?></td>
  </tr>
  
</table>
</div>
<div id="loadtrainmaster"></div> 
<script>   
function funloadtrainmaster(){ 
$('#loadtrainmaster').load('loadtrainmaster.php?serviceid=<?php echo decode($_REQUEST['id']); ?>'); 
} 
funloadtrainmaster(); 
$('#addnewuserbtn').show();
</script>
<?php 
}
?>
