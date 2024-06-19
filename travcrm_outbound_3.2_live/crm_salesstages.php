<?php
$searchField=clean($_GET['searchField']);
$searchFieldcommon=clean($_GET['searchFieldcommon']);

 if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

$wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 

?>


<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">Customize Sales Stages</span>
	    <div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Query','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
         <td >
		 

		</td>
<?php if($addpermission==1){ ?><td style="padding-right:20px;"><a onclick="alertspopupopen('action=addstage','400px','auto');"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Stage" /></a></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

</form>

 <div style="margin-top:120px; padding:20px;">
 <div style="padding:20px 10px; background-color:#ecf1f5;border-radius: 4px; overflow:hidden; margin-bottom:30px;">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   <?php
   $n=1;
$select='';
$where='';
$rs=''; 
$select='*';  
$where='1 order by id asc';
$rs=GetPageRecord($select,'salesStageMaster',$where);
while($rest=mysqli_fetch_array($rs)){ 

$n++; }

$totalwidth=$n-1;
$totalwidth = 100/$totalwidth;

 
$select='';
$where='';
$rs=''; 
$select='*';  
$where='1 order by id asc';
$rs=GetPageRecord($select,'salesStageMaster',$where);
while($rest=mysqli_fetch_array($rs)){ 
?>  <td colspan="3" width="<?php echo $totalwidth; ?>%"><div style="background-color:#ffffff;border-radius:2px;  box-shadow: 1px 1px 1px #cccccc59; margin:0px 10px; cursor:pointer; " onclick="alertspopupopen('action=addstage&id=<?php echo stripslashes($rest['id']); ?>','400px','auto');">
 <div style="padding:10px; font-size:16px; font-weight:500; <?php if($rest['status']==0){ ?>background-color:#ffb0b0;<?php } ?>"><?php echo stripslashes($rest['name']); ?></div>
 <div style="border-top:1px #ebeff2 solid; background-color:#fafbfd; font-size:12px; padding:10px;"><?php echo stripslashes($rest['probability']); ?>% probability</div>
 </div></td><?php } ?>
    </tr>
</table>

 
 
 
 
 
 
 </div>
 
 <table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size: 13px; color: #6d6d6d;">
  <tr>
    <td colspan="49%" align="left" valign="top"><div>
      <h3 style="margin-bottom:10px; font-weight:500;">About sales stages</h3>
    </div>
      <div>
        <div>Here you can customize the sales stages for your company. Just click &quot;add stage&quot; to add additional steps, or click on the current stage names to edit or delete them.</div>
        <div>Please bear in mind the following:</div>
        <div>
          <ul>
            <li>Sales stages are shared with all users throughout your company.</li> 
            <li>Do not use &quot;won&quot; or &quot;lost&quot; as stages. You already can mark deals won or lost regardless of the stage they are in.</li>
          </ul>
        </div>
      </div></td>
    <td width="2%" align="left" valign="top">&nbsp;</td>
    <td width="49%" align="left" valign="top"><div>
      <h3 style="margin-bottom:10px; font-weight:500;">About probabilities</h3>
    </div>
      <div>
        <div>Deal probability is a percentage between 0% an 100% that you can assign either to a deal or pipeline stage. This value represents your confidence in winning the deal by the expected close date. Pipedrive will then automatically calculate the deal values based on the probability you&rsquo;ve configured to make sales volume prediction easier for coming periods.<br />
          <br />
        </div>
        <h3 style="margin-bottom:10px; font-weight:500;">Stage probability</h3>
        <div>This probability type is set on a per-stage basis. Default probability of each stage is 100% and can be adjusted in this very page by clicking on a stage&rsquo;s name.<br />
          <br />
        </div>
        <h3 style="margin-bottom:10px; font-weight:500;">Lead probability</h3>
        <div>When enabled in a chosen pipeline, you&rsquo;ll be able to configure individual Deal probability. This type of probability overrides stage probability, which will be reflected in your weighted values in your pipeline and forecast views.</div>
      </div></td>
  </tr>
</table>

 
 </div></td>
  </tr>
</table>

 