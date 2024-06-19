<?php 
if($_REQUEST['guidesubcatId']!=''){  
	$aaaaaa=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.decode($_REQUEST['guidesubcatId']).'"'); 
	$otherActivityData=mysqli_fetch_array($aaaaaa);
}
?> 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>    
     </td>
    <td width="93%" align="left"><?php if($otherActivityData['serviceType'] == 1){ echo "Porter"; }else{ echo "Guide";} ?>:&nbsp;<?php echo $otherActivityData['name']; ?></td>
  </tr>
  
</table>
</div>
<div id="loadguidesubcatmaster"></div> 

<script>   
function funloadguidesubcatmaster(){ 
$('#loadguidesubcatmaster').load('loadguidesubcatmaster.php?serviceid=<?php echo decode($_REQUEST['guidesubcatId']); ?>'); 
} 
funloadguidesubcatmaster(); 
$('#addnewuserbtn').show();
</script>