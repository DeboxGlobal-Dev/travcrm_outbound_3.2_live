<?php
if($loginuserID == 37){
  $emailSearch = ' and 1 ';
}else{
  $emailSearch = ' and userId="'.$loginuserID.'" ';
}
?>
<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php echo $pageName; ?></span>
	 
	
	</div></td>
    <td align="right"><a href="setupsetting.crm?module=emailsettings&add=yes"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Email" style="margin-right:10px;" /></a></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<div class="roldouter">
<div class="xcontent" style="overflow:hidden;">
<?php
$select='';
$where='';
$rs=''; 
$select='*';  
$where=' 1 '.$emailSearch.' order by id asc';
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
if(mysqli_num_rows($rs)>0){ 
  while($rest=mysqli_fetch_array($rs)){ 
  ?>
 <div class="emailsetupboxdone" style="float:left; height:240px;">
   <table width="100%" border="0" cellpadding="10" cellspacing="0">
     
     <tr>
       <td align="center" style="position:relative;">
          <img src="images/bigemailicon.png" width="100" />
          <?php if($rest['isDefault']==1){ ?>
          <div class="isDefault"></div>
          <?php } ?>
        </td>
     </tr>
     <tr>
       <td align="center" style="color:#009900; padding:5px;"><?php echo $rest['from_name']; ?></td>
     </tr>
     <tr>
       <td align="center" style=" font-size:13px; padding:5px;"><div class="email"><?php echo $rest['email']; ?></div></td>
     </tr>
     
     <tr>
       <td align="center" style=" padding:5px;">
	   <a href="setupsetting.crm?module=emailsettings&add=yes&id=<?php echo encode($rest['id']); ?>"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Setting"   style="margin-left:0px; padding:5px;" /></a></td>
     </tr>
   </table>
 </div> 
 <?php } 
} else { ?>
  <div class="emailsetupbox">
    <table width="100%" border="0" cellpadding="10" cellspacing="0">
     <tr>
       <td align="center"><img src="images/nobigemailicon.png" width="100" style="margin-top:30px;" /></td>
     </tr>
     <tr>
       <td align="center">No Email Configured</td>
     </tr>
     <tr>
       <td align="center"><input name="addnewuserbtn2" type="button" class="bluembutton" id="addnewuserbtn2" value="+ Configure Email" onclick="add();" style="margin-left:0px;" /></td>
     </tr>
    </table>
  </div>
  <?php 
} ?>
</div>

</div>
</div></form>
<script> 
comtabopenclose('linkbox','op1');
</script>
<style type="text/css">
  .isDefault{
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-top: 30px solid #5cb31b;
    border-right: 30px solid #5cb31b;
    border-bottom: 30px solid transparent;
    border-left: 30px solid transparent;
  }
</style>