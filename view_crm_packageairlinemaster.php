<?php 
if($_REQUEST['id']!=''){  
$flightQuery=GetPageRecord('*',_PACKAGE_BUILDER_AIRLINES_MASTER_,' id="'.decode($_REQUEST['id']).'"'); 
$flightData=mysqli_fetch_array($flightQuery);
?> 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>    
     </td>
    <td width="93%" align="left">Airline:&nbsp;<?php echo $flightData['flightName']; ?></td>
  </tr>
  
</table>
</div>
<div id="loadairlinemaster"></div> 
<script>   
function funloadairlinemaster(){ 
$('#loadairlinemaster').load('loadairlinemaster.php?serviceid=<?php echo decode($_REQUEST['id']); ?>'); 
} 
funloadairlinemaster(); 
$('#addnewuserbtn').show();
</script>
<?php 
}else{
  echo 'something went wronge';
  // header('location: showpage.crm?module='.$_REQUEST['module'].'')
} ?>
