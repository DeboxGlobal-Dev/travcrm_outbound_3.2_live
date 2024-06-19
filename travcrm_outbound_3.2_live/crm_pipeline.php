<?php
$startdate=date('Y-m').'-1';
$enddate=date('Y-m').'-30';
$whereQuery=' and fromDate>"'.$startdate.'" and fromDate<"'.$enddate.'"';

 if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

 $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
 
  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))'; 

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
 <style>
 .pipeborderright{border-right: 1px #ccc5c56b solid;}
 body{ background-color:#f8f8f8 !important;}
.pipeheadingbox {
    padding: 10px;
    color: #FFFFFF;
    font-weight: 500;
    width: 100%;
    box-sizing: border-box;
    font-size: 14px;
} 
.pipequerybox:hover{background-color:#F8F8F8;}
.pipequerybox{padding:10px; background-color:#FFFFFF; border-bottom:1px #ccc5c56b solid;}
.pipequerybox .qtitle{font-size:13px; font-weight:500; color:#333333; margin-bottom:5px;text-overflow: ellipsis; overflow:hidden;white-space: nowrap; max-width:150px;}
.pipequerybox .qouter{overflow:hidden;}
.pipequerybox .qamount{max-width:30%; padding-right:5px; font-size:12px; color:#999999; float:left;text-overflow: ellipsis; overflow:hidden;white-space: nowrap;}
.pipequerybox .qcompanyname{max-width:65%; font-size:12px; color:#999999; float:left;text-overflow: ellipsis; overflow:hidden;white-space: nowrap;}



</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	  	<td width="7%" align="left">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module'];?>" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>    
     </td>
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Query','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right">
	
	
	</td>
  </tr>
  
</table>
</div>

</form>

<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:10px; padding-right:0px; padding-left:0px;">
 <div style="    margin-top: -10px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="min-height:500px;">
  <tr>
    <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#2ca1cc;">Assigned (20%) </div>
	<?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=1 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
	
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank"><div class="pipequerybox" title="<?php echo clean($resquery['subject']); ?>">
	<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
	<div class="qouter">
	<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
	<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
	</div>
	</div></a>
	<?php } ?>	</td>
    <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#FF6600">Reverted (40%) </div>
	
	<?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=2 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
	
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>"><div class="pipequerybox">
	<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
	<div class="qouter">
	<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
	<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
	</div>
	</div></a>
	<?php } ?>	</td>
    <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#ff9800;">Option Sent (60%) </div>
	<?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=6 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
	
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>"><div class="pipequerybox">
	<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
	<div class="qouter">
	<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
	<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
	</div>
	</div></a>
	<?php } ?>	</td>
    <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#ffc107;">Follow-up (80%) </div>
	<?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=7 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
	
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>"><div class="pipequerybox">
	<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
	<div class="qouter">
	<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
	<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
	</div>
	</div></a>
	<?php } ?>	</td>
    <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#82b767;">Confirmed (100%) </div><?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=3 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
	
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>"><div class="pipequerybox">
	<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
	<div class="qouter">
	<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
	<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
	</div>
	</div></a>
	<?php } ?></td>
    <td width="14%" align="left" valign="top" class="pipeborderright"><div class="pipeheadingbox" style="background-color:#c75858;">Query Lost (0%) </div><?php
	$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=''.$wheresearchassign.' and queryStatus=4 and deletestatus=0 '.$whereQuery.' order by id'; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
while($resquery=mysqli_fetch_array($rs)){ 
?>
	
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>"><div class="pipequerybox">
	<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
	<div class="qouter">
	<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
	<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
	</div>
	</div></a>
	<?php } ?></td>
	
	<td width="14%" align="left" valign="top" class="pipeborderright" style="display: none;"><div class="pipeheadingbox" style="background-color:#c75858;">Total Pax </div><?php
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';   
	$where=''.$wheresearchassign.' and queryStatus=4 and deletestatus=0 '.$whereQuery.' order by id'; 
	$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
	while($resquery=mysqli_fetch_array($rs)){ 
	?>
		
		<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resquery['id']); ?>" target="_blank" title="<?php echo clean($resquery['subject']); ?>"><div class="pipequerybox">
		<div class="qtitle"><?php echo clean($resquery['subject']); ?></div>
		<div class="qouter">
		<?php if($resquery['expectedSales']!=''){ ?><div class="qamount">$<?php echo $resquery['expectedSales']; ?> -</div><?php } ?>
		<div class="qcompanyname"><?php echo showClientTypeUserName($resquery['clientType'],$resquery['companyId']); ?></div>
		</div>
		</div></a>
		<?php } ?></td>
    </tr>
</table>

	</div>
 

 
</div></form>	</td>
  </tr>
</table>

 