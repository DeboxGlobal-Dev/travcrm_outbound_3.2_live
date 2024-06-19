<?php
ob_start();   
include "inc.php";  
include "config/logincheck.php";
$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']);
$fromDate=date('d-m-Y', strtotime($_GET['fromDate']));
$toDate=date('d-m-Y', strtotime($_GET['toDate']));
$assignto=$_GET['assignto'];
$destinationId=$_GET['destinationId'];
$categoryId=$_GET['categoryId'];
$tourType=$_GET['tourType'];
$clientType=$_GET['clientType'];
$clients=$_GET['Clients'];
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-weight: bold}
-->

#exTab1 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

#exTab2 h3 {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

/* remove border radius for the tab */

#exTab1 .nav-pills > li > a {
  border-radius: 0;
}

/* change border radius for the tab , apply corners on top*/

#exTab3 .nav-pills > li > a {
  border-radius: 4px 4px 0 0 ;
}

#exTab3 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}


.reporttabs{}
.reporttabs a {
    float: left;
    padding: 10px 8px;
    margin-left: 5px;
    border: 1px solid #ddd;
    color: #333333;
    font-weight: 500;
    font-size: 12px;
}
.rightsectionheader {
    background-color: #f8f8f8;
    border-bottom: 1px solid #eee;
    border-top: 1px solid #eee;
    padding: 10px 0px 10px !important;
    font-weight: 500;
    color: #333333;
    font-size: 22px;
    margin-top: 51px;
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    z-index: 999;
    margin-top: 109px !important;
    position: absolute!important;
}

.topsearchfiledmain, .topsearchfiledmainselect {
    padding: 5px !important; 
    font-size: 12px !important;
    border-radius: 0px !important;
}
 
 
 .searchbtnmain { 
    padding: 4px 14px !important; 
    font-size: 12px !important; 
    border-radius: 0px !important; 
    padding-left: 30px; 
	background-image:none !important; 
}

.reporttabs a:hover{background-color:#edededc7; color:#333333;}
.reporttabs .active{background-color:#45b558; color:#fff;}
.rightsectionheader .headingm {
    margin-left: 10px;
	    font-size: 16px !important;
}

.gridtable .header {     padding-bottom: 12px !important;
    background-color: #233a49 !important;
    color: #fff !important;
}
</style>




		

<div style="margin-top:62px; padding:10px; min-width:100px;">

<div class="reporttabs" style="" >

  <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=1" <?php if($_REQUEST['report']==1){ ?>class="active"<?php } ?>>User Wise Query</a>
  
  <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&clientType=1&module=reports&report=2" <?php if($_REQUEST['report']==2){ ?>class="active"<?php } ?>>Agent Wise Query </a>
  
  
  
  <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&clientType=2&module=reports&report=3" <?php if($_REQUEST['report']==3){ ?>class="active"<?php } ?>>Client Wise Query </a>
  
  
  
  <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d');?>&paymentstatus=0&module=reports&report=5" <?php if($_REQUEST['report']==5){ ?>class="active"<?php } ?>>Client Payment Pending</a>
  
  
  
  <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&paymentstatus=0&module=reports&report=6"  <?php if($_REQUEST['report']==6){ ?>class="active"<?php } ?>>Supplier Payment Pending</a>
  
  


  </div>

</div>
 	
	
	

















<?php if($_REQUEST['report']=='1'){
$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
if($assignto!=''){  
$strWhere.=' and assignTo='.$assignto.'';
}
if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}
if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}
if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
}
?>

	

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" ><span id="topheadingmain">  User Wise Query Report </span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
        <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate_y" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate_y" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>
   
        <td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; " >
            <option value="">All Operations Person</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=1 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($assignto==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="width:110px; " >
            <option value="">Destinations</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' name!="" and deletestatus=0 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="categoryId" id="categoryId" class="topsearchfiledmainselect" style="width:150px; " >
            <option value="">All Hotel Category</option>
			  <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_HOTEL_CATEGORY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$categoryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="tourType" id="tourType" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Tour Type</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$tourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
          </select></td>
		  <script>
		  function loadsearchClients(){
		 var clientType = $('#clientType').val();
		 $('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
		  }
		  </script>
        <td style="padding:0px 0px 0px 5px;" ><select onchange="loadsearchClients();" id="clientType" name="clientType" class="topsearchfiledmainselect" displayname="Client Type" autocomplete="off" style="width:110px; " > 
<option value=""  <?php if($clientType==0){ ?>selected="selected"<?php } ?>>All Clients</option> 
<option value="1"  <?php if($clientType==1){ ?>selected="selected"<?php } ?>>Agent</option> 
<option value="2"  <?php if($clientType==2){ ?>selected="selected"<?php } ?>>B2C</option> 
</select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Clients</option>
			 
          </select></td>
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		
		<input name="report" id="report" type="hidden" value="1" />
		
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();


$('#fromDate_y').Zebra_DatePicker({
      format: 'd-m-Y',  
      pair: $('#toDate_y'),
   });

   $('#toDate_y').Zebra_DatePicker({
       format: 'd-m-Y',
       
   });
   
</script>
</div>
</form>
 
<div id="pagelisterouter" style="padding-left: 0px; padding: 10px; padding-top: 47px;">
 
<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>
<div class="norec">Please Select From Date and To Date then Press Search </div>
<?php } else { ?>
<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
   <thead>
   <tr>
   <th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Name</label></th> 
      <th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
      <th align="center" valign="middle" class="header" >Created</th>
      <th align="center" class="header">Confirmed</th>
     <th align="center" class="header">Reverted</th>
     <th align="center" class="header">Assigned</th>
     <th align="center" class="header">Sent</th>
     <th align="center" class="header">Follow&nbsp;Up</th>
     <th align="center" class="header"> Lost</th>
    <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->
     <th align="right" class="header"> Sales</th>
     <th align="right" class="header"  >Gross&nbsp;Margin </th>
     <th align="right" class="header"  >Total&nbsp;Pax</th>
     <th align="right" class="header"  >No(s)&nbsp;Nights </th>
     </tr>
   </thead>
 
 
  	<tbody>
  	<?php 
  	////////////if assign to is not blank. Comes from search.////////////
  	if($assignto!=''){ 
  	?>
  	<tr style="font-size:13px;">
    <td align="left" valign="middle">
		<div class="bluelink" onclick="masters_alertspopupopen('action=addedit_userWiseReportExport&id=13','400px','auto');">
		<?php echo getUserName($_REQUEST['assignto']); ?>		</div>	</td>
    <td align="center" valign="middle">
 		
			<?php  
			echo $strWhere;
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?>
 		 	</td>
    <td align="center" valign="middle"><?php  
			 $sql567="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res567 = mysqli_query(db(),$sql567);
			echo $tquery567=mysqli_num_rows($res567);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="right">
	
	<?php
	
$suppliertotalcost_sum=0;
$suppliertotalcost_gross=0;
$salesqueryGrossTotal=0;
 

$menu=mysqli_query(db(),"select * from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
 
$suppliertotalcost_sum = $suppliertotalcost_sum+$res_menu['totalQueryCost'];
$suppliertotalcost_gross = $suppliertotalcost_gross+$res_menu['totalQueryCostwithoutpercent'];
}

echo $suppliertotalcost_sum;
$salesqueryTotal=$salesqueryTotal+$suppliertotalcost_sum;
?></td>
    <td align="right" >
	
	<?php echo $gross=$suppliertotalcost_sum-$suppliertotalcost_gross; $salesqueryGrossTotal=$gross+$salesqueryGrossTotal;  ?>	</td>
    <td align="right" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $adultsum+$row2['childsum'];
?></td>
    <td align="right" >
	
	<?php   
  
 $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $adultsum+$row3['nightsum'];
?>	</td>
    </tr>
  	<?php 
	} else {
	
   	////////////if assign to is blank comes from report////////////
	$totalcreated=''; 
	$select=''; 
	$where=''; 
	$rs='';  
	$select='*';    
	$where=' userType=1 and status=1 order by firstName asc';  
	$rs=GetPageRecord($select,_USER_MASTER_,$where); 
	while($resListing=mysqli_fetch_array($rs)){  
	?>
    <tr style="font-size: 13px;">
  <td align="left" valign="middle"><?php echo $resListing['firstName']; ?></td>
    <td align="center" valign="middle">
	
		<div class="bluelink" onclick="masters_alertspopupopen('action=addedit_userWiseReportExport&assignto=<?php echo $resListing['id']; ?>&searchreport=2&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>&queryshow=2','1400px','auto');">
		  	<?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']." ";
			$res5 = mysqli_query(db(),$sql5); 
			echo $tquery=mysqli_num_rows($res5);
			$tqueryTotal=$tqueryTotal+$tquery;
			?>
		</div>	
	</td>
    <td align="center" valign="middle"><?php  
            $sql567="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and assignTo=".$resListing['id']."";
			$res567 = mysqli_query(db(),$sql567);
			
			echo $tquery567=mysqli_num_rows($res567);
			$totalcreated=$totalcreated+mysqli_num_rows($res567);
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$confirmedqueryTotl=$tquery+$confirmedqueryTotl;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$revertedqueryTotal=$revertedqueryTotal+$tquery;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$assignedqueryTotal=$assignedqueryTotal+$tquery;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6 and assignTo=".$resListing['id']." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$sentqueryTotal=$tquery+$sentqueryTotal;
			?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$followQueryTotal=$followQueryTotal+$tquery;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$lostqueryTotal=$lostqueryTotal+$tquery;
			?></td>
 <!--   <td align="center"></td>-->
    <td align="right">
	
	<?php
	
$suppliertotalcost_sum=0;
$suppliertotalcost_gross=0;
$salesqueryGrossTotal=0;
 

$menu=mysqli_query(db(),"select * from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."");
while($res_menu=mysqli_fetch_array($menu)){
 
$suppliertotalcost_sum = $suppliertotalcost_sum+$res_menu['totalQueryCost'];
$suppliertotalcost_gross = $suppliertotalcost_gross+$res_menu['totalQueryCostwithoutpercent'];
}

echo $suppliertotalcost_sum;
$salesqueryTotal=$salesqueryTotal+$suppliertotalcost_sum; 
?></td>
    <td align="right" >
	<?php echo $gross=$suppliertotalcost_sum-$suppliertotalcost_gross; $salesqueryGrossTotal=$gross+$salesqueryGrossTotal;  ?>	 	</td>
    <td align="right" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']." and assignTo=".$resListing['id'].""); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']." and assignTo=".$resListing['id'].""); 
$row2 = mysqli_fetch_assoc($result2); 
echo $totalpax=$adultsum+$row2['childsum'];
$totalpaxTotal=$totalpax+$totalpaxTotal;
?></td>
    <td align="right" >
	
	<?php   
  
 $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id'].""); 
$row3 = mysqli_fetch_assoc($result3); 
echo $nonights=$adultsum+$row3['nightsum'];
$nonightsTotal=$nonights+$nonightsTotal;
?>	</td>
    </tr> 
 	<?php 
	} 
	?>
 
 <!--Total start-->
 <tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
 <td align="left" valign="middle"><strong>Total</strong></td>
    <td align="center" valign="middle"><?php echo $tqueryTotal;?></td>
    <td align="center" valign="middle"><?php echo $totalcreated;?></td>
    <td align="center"><?php  echo $confirmedqueryTotl;?> </td>
    <td align="center"><?php  echo $revertedqueryTotal;?></td>
    <td align="center"><?php  echo $assignedqueryTotal;?></td>
    <td align="center"><?php  echo $sentqueryTotal;?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php echo $followQueryTotal;?></td>
    <td align="center"><?php  echo $lostqueryTotal;?></td>
 <!--   <td align="center"></td>-->
    <td align="right">
	
	<?php echo $salesqueryTotal;?>	</td>
    <td align="right" >
	
	<?php echo $salesqueryGrossTotal;?>	</td>
    <td align="right" ><?php   echo $totalpaxTotal;?></td>
    <td align="right" >
	
	<?php   echo $nonightsTotal;?>	</td>
    </tr> 
	
 <!--Total end-->
 <?php  
 	} ?>
</tbody></table>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#reportdata').val(boxreport);  
$('#downloadrtm').submit();  
}




</script>
<?php if($_REQUEST['assignto']==''){ ?>
  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['QUERIES', 'CONFIRMED', 'REVERTED', 'ASSIGNED', 'SENT', 'FOLLOW UP', 'LOST', { role: 'annotation' } ],
        <?php
		$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=1 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>['<?php echo addslashes($resListing['firstName']); ?>', <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$confirmedqueryTotl=$tquery+$confirmedqueryTotl;
			?>, <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$revertedqueryTotal=$revertedqueryTotal+$tquery;?>, <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$assignedqueryTotal=$assignedqueryTotal+$tquery;
			?>, <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6 and assignTo=".$resListing['id']." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$sentqueryTotal=$tquery+$sentqueryTotal;
			?>, <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$followQueryTotal=$followQueryTotal+$tquery;
			?>, <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$lostqueryTotal=$lostqueryTotal+$tquery;
			?>, ''], 
<?php } ?>
      ]);

      var options = {
        width: 1000,
        height: 400,
        legend: { position: 'top', maxLines: 3 },
        bar: {groupWidth: '75%'},
        isStacked: true,
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_stacked'));
      chart.draw(data, options);
  }
  
  </script>
  
  <div id="columnchart_stacked" style="width:800px; text-align:center;"></div>
<?php } ?>

 <?php } ?>
</div> 	</td>
  </tr>
  
  
  
  
  
  
  
  <?php if($_REQUEST['sp']=='1'){?>  
  
  
  
  
  
  
  
    <tr>
    <td width="91%" align="left" valign="top">
	
 
 	</td>
  </tr><?php }?>
  
  
  
  
  
  
  
  
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>
<?php if($_REQUEST['report']=='2'){
$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($clients!=''){  
$strWhere.=' and companyId='.$clients.'';
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  Agent Wise Query	Report</span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
        <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>
   
        <script>
		  function loadsearchClients(){
		 var clientType = $('#clientType').val();
		 $('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
		  }
		  </script>
        <td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Clients</option>
			 
          </select></td>
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input name="clientType" id="clientType" type="hidden" value="1" />
		
		<input name="report" id="report" type="hidden" value="2" />
		
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table>
		<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
 
<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>
<div class="norec">Please Select From Date and To Date then Press Search </div>
<?php } else { ?>
<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
   <thead>
   <tr>
   <th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Name</label></th> 
      <th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
     <th align="center" class="header">Confirmed</th>
     <th align="center" class="header">Reverted</th>
     <th align="center" class="header">Assigned</th>
     <th align="center" class="header">Sent</th>
     <th align="center" class="header">Follow&nbsp;Up</th>
     <th align="center" class="header"> Lost</th>
    <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->
     <th align="center" class="header"> Sales</th>
     <th align="center" class="header"  >Gross&nbsp;Margin </th>
     <th align="center" class="header"  >Total&nbsp;Pax</th>
     <th align="center" class="header"  >No(s)&nbsp;Nights </th>
     </tr>
   </thead>
 
 
  <tbody>
  <?php 
  ////////////if assign to is not blank. Comes from search.////////////
  if($_REQUEST['Clients']!=''){ 
  ?>
  <tr style="font-size:13px;">
    <td align="left" valign="middle"><?php echo showClientTypeUserName(1,$_REQUEST['Clients']); ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
?>	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum;
?>	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
  
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $row3['nightsum'];
?>	</td>
    </tr>
  
  <?php } else {
  
  ////////////if assign to is blank comes from report////////////
  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and name!=""  group by name asc';  
$rs=GetPageRecord($select,_CORPORATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
  <tr style="font-size: 13px;">
  <td align="left" valign="middle"><?php echo $resListing['name']; ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$queririesTotal=$tquery+$queririesTotal;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$confirmTotal=$tquery+$confirmTotal;?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2 and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$revertTotal=$tquery+$revertTotal;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$assTotal=$tquery+$assTotal;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6 and companyId=".$resListing['id']." and clientType=1  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$stotal=$tquery+$tquery;
			?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7 and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$ftotal=$tquery+$ftotal;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$tlost=$tquery+$tquery;
			
			?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=1 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum; $tsales=$suppliertotalcost_sum+$tsales;
?>	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=1 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum; $gmargin=$suppliertotalcost_sum-$companytotalcost_sum+$gmargin;
?>	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=1 "); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=1 "); 
$row2 = mysqli_fetch_assoc($result2); 
echo $row2['childsum']; $totalpax=$row2['childsum']+$totalpax;
if(trim($row2['childsum'])=='' && $row2['childsum']!='0'){echo '0';}
?></td>
    <td align="center" >
	
	<?php   
  $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=1 "); 
$row3 = mysqli_fetch_assoc($result3); 
echo $row3['nightsum']; $totalnights=$row3['nightsum']+$totalnights;
if(trim($row3['nightsum'])=='' && $row3['nightsum']!='0'){echo '0';}
?>	</td>
    </tr> 
	
 <?php } ?>
 
 <!--Total start-->
 <tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
 <td align="left" valign="middle"><strong>Total</strong></td>
    <td align="center" valign="middle"><?php  echo $queririesTotal;?></td>
    <td align="center"><?php  echo $confirmTotal;?> </td>
    <td align="center"><?php  echo $revertTotal;?></td>
    <td align="center"><?php  echo $assTotal;?></td>
    <td align="center"><?php  echo $stotal;?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  echo $ftotal;?></td>
    <td align="center"><?php echo $tlost;?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php echo $tsales;
?>	</td>
    <td align="center" >
	
	<?php echo $gmargin;
?>	</td>
    <td align="center" ><?php   echo $totalpax;
?></td>
    <td align="center" >
	
	<?php echo $totalnights;
?>	</td>
    </tr> 
	
 <!--Total end-->
 <?php  }?>
</tbody></table>
  <?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and companyId=".$resListing['id']." and clientType=1 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$tlost=$tquery+$tquery;
			
			?>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#reportdata').val(boxreport);  
$('#downloadrtm').submit();  
}
</script>
 <?php } ?>
</div> 	</td>
  </tr>
  
  
  
  
  
  
  
  <?php if($_REQUEST['sp']=='1'){?>  
  
  
  
  
  
  
  
    <tr>
    <td width="91%" align="left" valign="top">
	
 
 	</td>
  </tr><?php }?>
  
  
  
  
  
  
  
  
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>
<?php if($_REQUEST['report']=='3'){
$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($clients!=''){  
$strWhere.=' and companyId='.$clients.'';
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  Client Wise Query	Report</span>
	    <div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
        <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>
   
        <script>
		  function loadsearchClients(){
		 var clientType = $('#clientType').val();
		 $('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
		  }
		  </script>
        <td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Clients</option>
			 
          </select></td>
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input name="clientType" id="clientType" type="hidden" value="2" />
		
		<input name="report" id="report" type="hidden" value="3" />
		
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table>
		<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
 
<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>
<div class="norec">Please Select From Date and To Date then Press Search </div>
<?php } else { ?>
<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
   <thead>
   <tr>
   <th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Client Name</label></th> 
      <th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
     <th align="center" class="header">Confirmed</th>
     <th align="center" class="header">Reverted</th>
     <th align="center" class="header">Assigned</th>
     <th align="center" class="header">Sent</th>
     <th align="center" class="header">Follow&nbsp;Up</th>
     <th align="center" class="header"> Lost</th>
    <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->
     <th align="center" class="header"> Sales</th>
     <th align="center" class="header"  >Gross&nbsp;Margin </th>
     <th align="center" class="header"  >Total&nbsp;Pax</th>
     <th align="center" class="header"  >No(s)&nbsp;Nights </th>
     </tr>
   </thead>
 
 
  <tbody>
  <?php 
  ////////////if assign to is not blank. Comes from search.////////////
  if($_REQUEST['Clients']!=''){ 
  ?>
  <tr style="font-size:13px;">
    <td align="left" valign="middle"><?php echo showClientTypeUserName(2,$_REQUEST['Clients']); ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
  
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $row3['nightsum'];
?>
	
	</td>
    </tr>
  
  <?php } else {
  
  ////////////if assign to is blank comes from report////////////
  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and firstName!=""  group by firstName asc';  
$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
  <tr style="font-size: 13px;">
  <td align="left" valign="middle"><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and companyId=".$resListing['id']." and clientType=2 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$queririesTotal=$tquery+$queririesTotal;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$confirmTotal=$tquery+$confirmTotal;?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2 and companyId=".$resListing['id']." and clientType=2 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$revertTotal=$tquery+$revertTotal;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and companyId=".$resListing['id']." and clientType=2 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			
			$assTotal=$tquery+$assTotal;?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6 and companyId=".$resListing['id']." and clientType=2  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$stotal=$tquery+$tquery;
			?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7 and companyId=".$resListing['id']." and clientType=2 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$ftotal=$tquery+$ftotal;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and companyId=".$resListing['id']." and clientType=2 ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$tlost=$tquery+$tquery;
			
			?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum; $tsales=$suppliertotalcost_sum+$tsales;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum; $gmargin=$suppliertotalcost_sum-$companytotalcost_sum+$gmargin;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 "); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 "); 
$row2 = mysqli_fetch_assoc($result2); 
echo $row2['childsum']; $totalpax=$row2['childsum']+$totalpax;
if(trim($row2['childsum'])=='' && $row2['childsum']!='0'){echo '0';}
?></td>
    <td align="center" >
	
	<?php   
  $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and companyId=".$resListing['id']." and clientType=2 "); 
$row3 = mysqli_fetch_assoc($result3); 
echo $row3['nightsum']; $totalnights=$row3['nightsum']+$totalnights;
if(trim($row3['nightsum'])=='' && $row3['nightsum']!='0'){echo '0';}
?>
	
	</td>
    </tr> 
	
 <?php } ?>
 
 <!--Total start-->
 <tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
 <td align="left" valign="middle"><strong>Total</strong></td>
    <td align="center" valign="middle"><?php  echo $queririesTotal;?></td>
    <td align="center"><?php  echo $confirmTotal;?> </td>
    <td align="center"><?php  echo $revertTotal;?></td>
    <td align="center"><?php  echo $assTotal;?></td>
    <td align="center"><?php  echo $stotal;?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  echo $ftotal;?></td>
    <td align="center"><?php echo $tlost;?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php echo $tsales;
?>
	
	</td>
    <td align="center" >
	
	<?php echo $gmargin;
?>
	
	
	</td>
    <td align="center" ><?php   echo $totalpax;
?></td>
    <td align="center" >
	
	<?php echo $totalnights;
?>
	
	</td>
    </tr> 
	
 <!--Total end-->
 <?php  }?>
</tbody></table></div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#reportdata').val(boxreport);  
$('#downloadrtm').submit();  
}
</script>
 <?php } ?>
</div> 	</td>
  </tr>
  
  
  
  
  
  
  
  <?php if($_REQUEST['sp']=='1'){?>  
  
  
  
  
  
  
  
    <tr>
    <td width="91%" align="left" valign="top">
	
 
 	</td>
  </tr><?php }?>
  
  
  
  
  
  
  
  
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>
<?php if($_REQUEST['report']=='4'){
$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
if($assignto!=''){  
$strWhere.=' and assignTo='.$assignto.'';
}
if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}
if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}
if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  Travel Report</span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>
   
        <td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; " >
            <option value="">All Operations Person</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=1 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($assignto==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="width:140px; " >
            <option value="">All Destinations</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' name!="" and deletestatus=0 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="categoryId" id="categoryId" class="topsearchfiledmainselect" style="width:150px; " >
            <option value="">All Hotel Category</option>
			  <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_HOTEL_CATEGORY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$categoryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="tourType" id="tourType" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Tour Type</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$tourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
          </select></td>

		  <script>
		  function loadsearchClients(){
		 var clientType = $('#clientType').val();
		 $('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
		  }
		  </script>
        <td style="padding:0px 0px 0px 5px;" ><select onchange="loadsearchClients();" id="clientType" name="clientType" class="topsearchfiledmainselect" displayname="Client Type" autocomplete="off" style="width:110px; " > 
<option value=""  <?php if($clientType==0){ ?>selected="selected"<?php } ?>>All Clients</option> 
<option value="1"  <?php if($clientType==1){ ?>selected="selected"<?php } ?>>Agent</option> 
<option value="2"  <?php if($clientType==2){ ?>selected="selected"<?php } ?>>B2C</option> 
</select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Clients</option>
			 
          </select></td>
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		
		<input name="report" id="report" type="hidden" value="1" />
		
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
 
<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>
<div class="norec">Please Select From Date and To Date then Press Search </div>
<?php } else { ?>
<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
   <thead>
   <tr>
   <th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Name</label></th> 
      <th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
     <th align="center" class="header">Confirmed</th>
     <th align="center" class="header">Reverted</th>
     <th align="center" class="header">Assigned</th>
     <th align="center" class="header">Sent</th>
     <th align="center" class="header">Follow&nbsp;Up</th>
     <th align="center" class="header"> Lost</th>
    <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->
     <th align="center" class="header"> Sales</th>
     <th align="center" class="header"  >Gross&nbsp;Margin </th>
     <th align="center" class="header"  >Total&nbsp;Pax</th>
     <th align="center" class="header"  >No(s)&nbsp;Nights </th>
     </tr>
   </thead>
 
 
  <tbody>
  <?php 
  ////////////if assign to is not blank. Comes from search.////////////
  if($assignto!=''){ 
  ?>
  <tr style="font-size:13px;">
    <td align="center" valign="middle"><?php echo getUserName($_REQUEST['assignto']); ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $adultsum+$row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  
 $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $adultsum+$row3['nightsum'];
?>
	
	</td>
    </tr>
  
  <?php } else {
  
  ////////////if assign to is blank comes from report////////////
  
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=1 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
  <tr style="font-size: 13px;">
  <td align="center" valign="middle"><?php echo $resListing['firstName']; ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6 and assignTo=".$resListing['id']." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4 and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']." and assignTo=".$resListing['id'].""); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']." and assignTo=".$resListing['id'].""); 
$row2 = mysqli_fetch_assoc($result2); 
echo $adultsum+$row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  
 $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id'].""); 
$row3 = mysqli_fetch_assoc($result3); 
echo $adultsum+$row3['nightsum'];
?>
	
	</td>
    </tr> 
	
 <?php } ?>
 
 <!--Total start-->
 <tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
 <td align="center" valign="middle"><strong>Total</strong></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=6  ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td> <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}
echo $suppliertotalcost_sum-$companytotalcost_sum;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query(db(),"SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];
$result2 = mysqli_query(db(),"SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $adultsum+$row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  
 $result3 = mysqli_query(db(),"SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $adultsum+$row3['nightsum'];
?>
	
	</td>
    </tr> 
	
 <!--Total end-->
 <?php  }?>
</tbody></table></div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#reportdata').val(boxreport);  
$('#downloadrtm').submit();  
}
</script>
 <?php } ?>
</div> 	</td>
  </tr>

  <?php if($_REQUEST['sp']=='1'){?> 
    <tr>
    <td width="91%" align="left" valign="top">
	
 
 	</td>
  </tr><?php }?>

</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>

<?php if($_REQUEST['report']=='5'){ ?>
<?php
$searchField=clean($_GET['searchField']);
$paymentid=clean($_GET['paymentid']);
$paymentstatus=clean($_GET['paymentstatus']);
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%"><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> &nbsp;&nbsp;Client&nbsp;Payment&nbsp;Pending&nbsp;Report&nbsp;&nbsp;</span>
	    <div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
	<style>
	.makeclass{
    position: relative;
    top: auto;
    right: auto;
    bottom: auto;
    left: auto;
    padding: 7px;
    border-radius: 42px;
    border: 1px solid #ccc;
   
	cursor: pointer;
    text-align: center;
}
.h1:hover{
background-color:#4caf50;
color:#fff;

}
.selected{ background-color:#64aefb; color:#fff; }
	</style>
    <td width="75%"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="5%"><input name="fromDate" type="text"  class="  makeclass h1" id="fromDate_r" size="6" placeholder="From"  value=""style="width: 89px";/></td>
        <td width="7%"><input name="toDate" type="text"  class="  makeclass h1" id="toDate_r" size="6" placeholder="To" value=""/></td>
		
        <td width="6%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d'); ?>&module=reports&report=5&Today=Today">
          <input name="todayreport2" type="text" id="todayreport" value="Today" class="  makeclass h1 <?php if($_REQUEST['Today']=='Today') { ?> selected <?php } ?>"  readonly="readonly" style="width:55px"/>
        </a></td>
		 <td width="8%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d',strtotime('+1 days')); ?>&module=reports&report=5&tomorrow=tomorrow">
          <input name="tomorrowreport" type="text"  id="tomorrow" value="Tomorrow" class="  makeclass h1 <?php if($_REQUEST['tomorrow']=='tomorrow') { ?> selected <?php } ?>"   readonly="readonly" style="width: 76px"/></a></td>
        <td width="5%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d',strtotime('+5 days')); ?>&module=reports&report=5&T5=T5" >
      <input name="T5" type="T5" id="T5" value="T-5" class="  makeclass h1 <?php if($_REQUEST['T5']=='T5') { ?> selected <?php } ?>"  readonly="readonly"style=" width: 46px;" />
    </a></td>

        <td width="5%"><input name="searchField" type="text"  class="  makeclass h1" id="searchField" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>
		
        <td width="14%"><select name="paymentstatus" id="paymentstatus" class="makeclass <?php if($_REQUEST['paymentstatus']=='T5') { ?> selected <?php } ?>">
      <option value=""> Select Payment Status</option>
      <option value="1" <?php if($_GET['paymentstatus']=='1'){ ?>selected="selected"<?php  } ?>>Paid</option>
      <option value="0" <?php if($_GET['paymentstatus']=='0'){ ?>selected="selected"<?php  } ?>>Pending</option>
    </select></td>
	
        <td width="50%"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
        <input name="report" id="report" type="hidden" value="5" />
        <input type="submit" name="Submit" value="Search" class="   makeclass" style="background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;" /></td>
        </tr>
    </table></td>
  </tr>
  
</table>
</div>
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="paymentdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
      
     <th width="192" align="left" class="header">Travel Date </th>
     <th width="213" align="left" class="header">query&nbsp;ID </th>
     <th width="208" align="left" class="header">Client Name </th>
     <th width="211" align="left" class="header">Contact Person</th>
     <th width="194" align="left" class="header">Contact Number</th>
     <th width="194" align="left" class="header">Total Amount </th>
     <th width="252" align="left" class="header">Client&nbsp;Pending&nbsp;Amt</th>
     </tr>
   </thead>
   
  <tbody>
  <?php
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$searchField=clean(trim(ltrim($_GET['searchField'], '0')));
$mainwhere='';
if($searchField!=''){ 
 $an2ssg=GetPageRecord('id',_QUERY_MASTER_,'displayId='.$searchField.' order by id desc');
 $getidt=mysqli_fetch_array($an2ssg);
$mainwhere=' and  queryId='.$getidt['id'].'';
}
$whereFromDate='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){ 
$fromDate=date('Y-m-d', strtotime($fromDate));
$toDate=date('Y-m-d', strtotime($toDate));
$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
} 
$paymentid=clean(trim(ltrim($_GET['paymentid'], '0')));
 
if($paymentid!=''){
$paymentid=' and  id='.$paymentid.'';
}
$paystatus=''; 
if($paymentstatus!=''){
//$paymentstatus=' and  status='.$paymentstatus.'';
if($paymentstatus==0){
$paystatus='pendingCost>0';
}
if($paymentstatus==1){
$paystatus='pendingCost<1';
}
$paymentstatus=' and id in (select paymentId from '._AGENT_PAYMENT_REQUEST_.' where '.$paystatus.')';

}	 
$fromDatetrav='';
if($_REQUEST['fromDatetrav']!=""){	 
$fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';
} 
		
 $where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where id!="" '.$whereFromDate.' '.$fromDatetrav.' order by fromDate asc) '.$mainwhere.' '.$paymentid.' '.$paymentstatus.'  '; 
$page=$_GET['page'];
$targetpage=$fullurl.'showpage.crm?module=reports&report=5&fromDate='.$_REQUEST["fromDate"].'&toDate='.$_REQUEST["toDate"].'&';
$rs=GetRecordList($select,_PAYMENT_REQUEST_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
 
 $an2ss=GetPageRecord('fromDate',_QUERY_MASTER_,'id='.$resultlists['queryid'].' order by id desc');
 $getfrmdt=mysqli_fetch_array($an2ss);
?>
   
 
  <tr> 
 <!-- onclick="view('<?php //echo encode($resultlists['id']); ?>');"-->
 <?php 
	$select12=''; 
	$where12=''; 
	$rs12='';   
	$select12='*';  
	$where12='id='.$resultlists['queryid'].''; 
	$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 
	$editresultdisplay=mysqli_fetch_array($rs12);
		  
 ?>
    <td align="left"><?php if($getfrmdt['fromDate']==''){} else {  echo date("d-m-Y", strtotime($getfrmdt['fromDate'])); }
	$select55='*';  
   $where55='paymentRequestId='.$resultlists['id'].' order by id desc'; 
   $rs55=GetPageRecord($select55,_PAYMENT_LIST_MASTER_,$where55); 
   $gettotalcostofpayment=mysqli_fetch_array($rs55);  
   ?> </td>
		  
		  
    <td align="left">
	 <div class="bluelink" >
	 <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($editresultdisplay['id']);?>"><?php echo makeQueryId($editresultdisplay['id']); ?></a></div></td>
	
    <td align="left"><?php echo showClientTypeUserName($editresultdisplay['clientType'],$editresultdisplay['companyId']); ?></td>
	 
    <td align="left">
	 <?php
	    
	    $select13=''; 
		$where13=''; 
		$rs13='';   
		$select13='*';  
		 
		if($editresultdisplay['clientType']==1){   
		$rsc=GetPageRecord('contactPerson','contactPersonMaster',' corporateId="'.$editresultdisplay['companyId'].'" and deletestatus=0 order by id asc');
		$resListingc=mysqli_fetch_array($rsc);
		echo ($resListingc['contactPerson']);
		
		}
		if($editresultdisplay['clientType']==2){
		$where13="id='".$editresultdisplay['companyId']."'";
		$rs13=GetPageRecord($select13,_CONTACT_MASTER_,$where13); 
		$editresultcorporate=mysqli_fetch_array($rs13);
		echo $editresultcorporate['firstName'].' '.$editresultcorporate['lastName'];
		}
		
	 ?>	</td>
    <td align="left"><?php if($editresultdisplay['clientType']==1){     
   $rsc=GetPageRecord('*','contactPersonMaster',' corporateId="'.$editresultdisplay['companyId'].'" and deletestatus=0 order by id asc');  $resListingc=mysqli_fetch_array($rsc); 
   echo ($resListingc['phone']); }
   if($editresultdisplay['clientType']==2){ echo getPrimaryPhone($editresultdisplay['companyId'],'contacts'); } ?></td>
   
   
    <td align="left"><?php echo($editresultdisplay['totalQueryCost']==0)?'':$editresultdisplay['totalQueryCost'];?></td>
	
	

    <td align="left"><?php   
           $qid = $resultlists['queryid'];
          $selectpc='*';    
          $wherepc='queryId="'.$qid.'" ';  
          $rspc=GetPageRecord($selectpc,_AGENT_PAYMENT_REQUEST_,$wherepc); 
          while($resListingpc=mysqli_fetch_array($rspc)){ 
        $pendingamount=$resListingpc['pendingCost'];  
         }
		 
		 if($pendingamount<1){
        ?>
		<div style="color:#009900;"> <strong>Paid</strong></div>
		<?php } else { ?>
		<div style="color:#CC3300;"><strong><?php echo $editresultdisplay['totalQueryCostwithoutpercent']; ?></strong></div>
		<?php } ?> </td>
    <?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>
<div class="pagingdiv">
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;"><?php echo $totalentry=$totalentry-$differ;?> entries</td>
    <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
                    <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
                    <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
                    <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
                    <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
                    <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
                  </select></td>
  </tr>
  
</table></td>
    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>
  </tr>
</tbody></table>
	</div>
</div></form>	</td>
  </tr>
</table>
<style>
#pagelisterouter {
    padding-top: 50px !important;
    margin-top: 5px !important;}
</style>
<script> 
 $('#fromDate_r').Zebra_DatePicker({
      format: 'd-m-Y',  
      pair: $('#toDate_r'),
   });

   $('#toDate_r').Zebra_DatePicker({
       format: 'd-m-Y',
       
   });
   
   
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>
<?php if($_REQUEST['report']=='6'){ ?>
<?php
$searchField=clean($_GET['searchField']);
$paymentid=clean($_GET['paymentid']);
$paymentstatus=clean($_GET['paymentstatus']);

if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

 $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
 
  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

}
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="25%"><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> &nbsp;&nbsp;Supplier&nbsp;Payment&nbsp;Pending&nbsp;Report&nbsp;&nbsp;</span>
	    <div id="deactivatebtn" style="display:none;">
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate_r" style="width:80px;" size="6" placeholder="From"  value="" /></td>
        <td><input name="toDate" type="text"  class="topsearchfiledmain" id="toDate_r" style="width:80px;" size="6" placeholder="To" value=""/></td>
        <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     
        <td style="padding:0px 0px 0px 5px;" ><select name="searchsupId" id="searchsupId" class="topsearchfiledmainselect" style="width:120px; " >
		   <option value="">All Suppliers</option>
		      <?php   
			  $selectsup=''; 
			  $wheresup=''; 
			  $rscsup='';  
			  $selectsup='*';    
			  $wheresup='1';  
			  $rscsup=GetPageRecord($selectsup,_SUPPLIERS_MASTER_,$wheresup); 
			  while($suppliers=mysqli_fetch_array($rscsup)){ 
			  
			  if($suppliers['name']!=''){ 
			  ?>
			 <option value="<?php echo $suppliers['id']; ?>" <?php
		   foreach ($_REQUEST['name'] as $key => $value) {
				if($value == $suppliers['id']){
					echo 'selected="selected"';
				}
		   }
		   ?>><?php echo $suppliers['name']; ?></option>
		   <?php }} ?>
          </select>
		</td>
    <!--<td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php //echo $searchField; ?>" size="6" maxlength="12" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>-->
     <!--<td style="padding:0px 0px 0px 5px;" > 
           <input name="paymentid" type="text"  class="topsearchfiledmain" id="paymentid" style="width:96px;" value="<?php //echo $paymentid; ?>" size="6" maxlength="12" placeholder="Payment Id" onkeyup="numericFilter(this);"/>
 </td>-->
 
 <!--<td style="padding:0px 0px 0px 5px;" > 
           <select name="paymentstatus" id="paymentstatus" class="topsearchfiledmainselect" style="width:145px; " >
            <option value="">Payment Status</option> 
			<option value="1" <?php //if($_GET['paymentstatus']=='1'){ ?>selected="selected"<?php  //} ?>>Paid</option>
			<option value="0" <?php //if($_GET['paymentstatus']=='0'){ ?>selected="selected"<?php  //} ?>>Pending</option>  
			 
          </select>
 </td>-->
   
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input name="report" id="report" type="hidden" value="6" />
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        <td style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>

		</td>
       
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="paymentdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      
     <th width="247" align="left" class="header">payment&nbsp;ID</th>
     <th width="271" align="left" class="header">query&nbsp;ID </th>
	 <th width="486" align="left" class="header">Supplier Name</th>
     <th width="228" align="left" class="header">Contact Person</th>
	 <th width="271" align="left" class="header">Supplier&nbsp;Pending&nbsp;Amount</th>
     <!--     <th width="228" align="left" class="header">Payment&nbsp;Reminder&nbsp;Date</th>
-->     <th width="228" align="left" class="header">Travel Date </th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=10000;

$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';
if($searchField!=''){
$mainwhere=' and  queryId='.$searchField.'';
}
$whereFromDate='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){ 
$fromDate=date('Y-m-d', strtotime($fromDate));
$toDate=date('Y-m-d', strtotime($toDate));
$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
}    
$paymentid=clean(trim(ltrim($_GET['paymentid'], '0')));
 
if($paymentid!=''){
$paymentid=' and  id='.$paymentid.'';
}
$supplierid='';
if($_REQUEST['searchsupId']!=''){
$supplierid=' and  id='.$_REQUEST['searchsupId'].'';
}          
if($paymentstatus!=''){
$paymentstatus=' and  status='.$paymentstatus.'';
}	 
$fromDatetrav='';
if($_REQUEST['fromDatetrav']!=""){	 
$fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';
} 	  
 
//$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where '.$wheresearchassign.' ) '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc'; 
$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where deletestatus=0 '.$whereFromDate.' '.$fromDatetrav.') '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc';

$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=paymentrequest&records='.$limit.'&searchField='.$searchField.'&';
$rs=GetRecordList($select,_PAYMENT_REQUEST_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
//print_r($resultlists);
$select2='*';
$where2='paymentId='.clean($resultlists['id']).' and companyTypeId!=0 order by id desc limit 0,1'; 
$rs2=GetPageRecord($select2,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2); 
while($listofsuppliers=mysqli_fetch_array($rs2)){
$paymentdate = $listofsuppliers['paymentdate'];
$paymentreminderdate = $listofsuppliers['paymentreminderdate'];
}



$tatalpayment=0;
$select22='*';
$where22='paymentRequestId='.$resultlists['id'].' order by id ASC'; 
$rs22=GetPageRecord($select22,_PAYMENT_LIST_MASTER_,$where22); 
while($listofpayment=mysqli_fetch_array($rs22)){
$tatalpayment=$tatalpayment+$listofpayment['amount'];
}


	
$totalpaymentpending=0;
$select222='*';
$where222='paymentId='.$resultlists['id'].' order by id desc'; 
$rs222=GetPageRecord($select222,_PAYMENT_SUPPLIER_LIST_MASTER_,$where222); 
while($listofsuppliers=mysqli_fetch_array($rs222)){

$totalpaymentpending=$totalpaymentpending+$listofsuppliers['companytoalcost'];
} 


//////////////////////////////get supplier name,contactPerson from suppliersMaster/////////////////////
$rs122=GetPageRecord('id','paymentRequestMaster','queryid="'.$resultlists['queryid'].'"'); 
$getpaymentId=mysqli_fetch_array($rs122); 

$rs1222=GetPageRecord('supplierId','paymentRequestPayment ','paymentRequestId="'.$getpaymentId['id'].'"'); 
$getsupId=mysqli_fetch_array($rs1222); 

//////////////////////use supplier variable to get supplier search record from dropdown menu in this query/////////////////
$rs12222=GetPageRecord('name,contactPerson','suppliersMaster ','id="'.$getsupId['supplierId'].'" '.$supplierid.''); 
$getsuplist=mysqli_fetch_array($rs12222);
if($getsuplist['name']!=''){
?>

 
  <tr>
    
    <td align="left" class="bluelink"><?php echo makePaymentId($resultlists['id']); ?>	 

    </td>
    <td align="left"><?php if($getfrmdt['fromDate']==''){} else {  echo date("d-m-Y", strtotime($getfrmdt['fromDate'])); }
	    $select12=''; 
		$where12=''; 
		$rs12='';   
		$select12='*';  
		$where12='id='.$resultlists['queryid'].''; 
		$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 
		$editresultdisplay=mysqli_fetch_array($rs12);
		  
	 ?>
      <a class="bluelink" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($editresultdisplay['id']); ?>" ><?php  
		echo makeQueryId($editresultdisplay['id']); ?>	 
	     </a>
    </td>
	<td align="left"><?php
          echo $getsuplist['name'];	
	 ?></td>
	  <td align="left" > <?php
	    echo $getsuplist['contactPerson']; 
	 ?></td>
    <td align="left">
     <strong> <?php if($resultlists['supplierPendingamount']!=0){ ?>
     <div style="color:#CC3300;"><?php echo $resultlists['supplierPendingamount']; ?></div><?php } else {  ?></strong>
     <div style="color:#009900;">
       <strong>Paid</strong></div>
     <strong></strong><strong>
     <?php } ?>    
     </strong> </td>
    <td align="left" ><?php 
	    $select12=''; 
		$where12=''; 
		$rs12='';   
		$select12='*';  
		$where12='id='.$resultlists['queryid'].''; 
		$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 
		$travelDate=mysqli_fetch_array($rs12);
	echo $travelDate['fromDate']; ?>	 </td>
    
    </tr> 
	
	<?php   $no++;  }} ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>
<div class="pagingdiv">
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
    <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
                    <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
                    <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
                    <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
                    <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
                    <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
                  </select></td>
  </tr>
  
</table></td>
    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>
  </tr>
</tbody></table>
	</div>
</div></form>	</td>
  </tr>
</table>
<script>

$('#fromDate_r').Zebra_DatePicker({
      format: 'd-m-Y',  
      pair: $('#toDate_r'),
   });

   $('#toDate_r').Zebra_DatePicker({
       format: 'd-m-Y',
       
   });
 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>

<?php if($_REQUEST['report']=='7'){
$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
if($assignto!=''){  
$strWhere.=' and assignTo='.$assignto.'';
}
if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}
if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}
if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  Sales Report</span>
	    <div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>
   
        <td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; " >
            <option value="">All Sales Person</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=0 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($assignto==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="width:140px; " >
            <option value="">All Destinations</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' name!="" and deletestatus=0 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
			<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="categoryId" id="categoryId" class="topsearchfiledmainselect" style="width:150px; " >
            <option value="">All Hotel Category</option>
			  <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_HOTEL_CATEGORY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$categoryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
          </select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="tourType" id="tourType" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Tour Type</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$tourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
          </select></td>
		  <script>
		  function loadsearchClients(){
		 var clientType = $('#clientType').val();
		 $('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);
		  }
		  </script>
        <td style="padding:0px 0px 0px 5px;" ><select onchange="loadsearchClients();" id="clientType" name="clientType" class="topsearchfiledmainselect" displayname="Client Type" autocomplete="off" style="width:110px; " > 
<option value=""  <?php if($clientType==0){ ?>selected="selected"<?php } ?>>All Clients</option> 
<option value="1"  <?php if($clientType==1){ ?>selected="selected"<?php } ?>>Agent</option> 
<option value="2"  <?php if($clientType==2){ ?>selected="selected"<?php } ?>>B2C</option> 
</select></td>
        <td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >
            <option value="">All Clients</option>
			 
          </select></td>
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		
		<input name="report" id="report" type="hidden" value="7" />
		
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 2px;">
 
<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>
<div class="norec">Please Select From Date and To Date then Press Search </div>
<?php } else { ?>
<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
   <thead>
   <tr>
   <th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Name</label></th> 
      <th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 
     <th align="center" class="header">Tasks</th>
     <th align="center" class="header">Meetings</th>
     <th align="center" class="header">Calls</th>
     <!-- <th align="center" class="header">TAT&nbsp;followed</th>-->
     <th align="center" class="header"> Sales</th>
     </tr>
   </thead>
 
 
  <tbody>
  <?php 
  ////////////if assign to is not blank. Comes from search.////////////
  if($assignto!=''){ 
  ?>
  <tr style="font-size:13px;">
    <td align="left" valign="middle"><?php echo getUserName($_REQUEST['assignto']); ?></td>
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
?>	</td>
    </tr>
  
  <?php } else {
  
  ////////////if assign to is blank comes from report////////////
$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 and status=3 ';
} 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=0 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
  <tr style="font-size: 13px;">
  <td align="left" valign="middle"><?php echo $resListing['firstName']; ?></td>
    <td align="center" valign="middle"><?php 
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']." ";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			if($tquery=='' && $tquery!='0'){echo '0';}
			
			$queryTotal=$tquery+$queryTotal;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._TASKS_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$confirmedTotal=$tquery+$confirmedTotal;
			?> </td>
    <td align="center"><?php  
			$sql5="select id from "._MEETINGS_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$revertedTotal=$tquery+$revertedTotal;
			?></td>
    <td align="center"><?php  
			$sql5="select id from "._CALLS_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']."";
			$res5 = mysqli_query(db(),$sql5);
			echo $tquery=mysqli_num_rows($res5);
			$assignedTotal=$tquery+$assignedTotal;
			?></td>
    <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php
	$strWhere='';
if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));
$strWhere.=' followupdate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
}
	
$suppliertotalcost_sum=0;
//$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."");
$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where  queryStatus=3 and assignTo=".$resListing['id']."");
while($res_menu=mysqli_fetch_array($menu)){
$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  
$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}
echo $suppliertotalcost_sum;
$salesTotal=$suppliertotalcost_sum+$salesTotal;
?>	</td>
    </tr> 
	
 <?php } ?>
 
 <!--Total start-->
 <tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
 <td align="left" valign="middle"><strong>Total</strong></td>
    <td align="center" valign="middle"><?php  echo $queryTotal;?></td>
    <td align="center"><?php  echo $confirmedTotal;?> </td>
    <td align="center"><?php  echo $revertedTotal;?></td>
    <td align="center"><?php  echo $assignedTotal;?></td>
    <style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>
    <!--   <td align="center"></td>-->
    <td align="center">
	
	<?php echo $salesTotal;?>	</td>
    </tr> 
	
 <!--Total end-->
 <?php  }?>
</tbody></table>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#reportdata').val(boxreport);  
$('#downloadrtm').submit();  
}
</script>
 <?php } ?>
</div> 	</td>
  </tr>
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<?php }?>

<?php if($_REQUEST['report']=='8'){ ?>
<?php
$searchField=clean($_GET['queryId']);
$invoiceid=clean($_GET['invoiceid']);
$search=clean($_GET['search']);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<style>
.btnsearchreport{
	/* background-color: #45b558; */
	/*text-align:center;*/
	padding: 3px 18px;
	margin-left: 5px;
	outline: 0px;
	color: #ffffff;
	font-size: 14px;
	/* border: 1px #45b558 solid; */
	/* border-radius: 27px; */
	cursor: pointer;
	background-image: url(../images/searchiconin.png);
	background-repeat: no-repeat;
	background-position: 7px center;
	padding-left: 30px;
	background-size: 16px;
}
.ttprice{
	white-space: nowrap;overflow:hidden;
}
.topsearchfiledmain1{   
	padding: 5px;
	margin-top:5px;
	border: 1px #a9a9a9 solid;
	outline: 0px;
	background-size: 17px;
}
.blockList{
	display:block!important;
}
.hideList{
	display:none;
}
.searvice_list_box{
	overflow: scroll;
	height: 200px;
	position: absolute;
	text-align: left;
	border: 1px solid #a9a9a9;
	/* border-radius: 1px; */
	width: 88px;
	background-color: white;
	z-index:1;
	display:none;
}
#service {
	/*padding-top: 9px;*/
}
#service span{
	font-weight:normal;
	/*border:1px solid #a9a9a9;
	padding: 5px 24px;*/
}
.searvice_list_box ul li{
	font-weight:normal;
}
</style>		   
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get" style="margin-top: 20px;">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  Travelbooking Report</span>
	
	    <div id="deactivatebtn" style="display:none;">	</div>
	
	</div></td>
	<style>
	.upclass{
    position: relative;
    top: auto;
    right: auto;
    bottom: auto;
    left: auto;
    padding: 7px;
    border-radius: 42px;
    border: 1px solid #ccc;
   
	cursor: pointer;
    text-align: center;
}
.h2:hover{
background-color:#4caf50;
color:#fff;

}
.selected1{ background-color:#64aefb; color:#fff; }
	</style>
	<div class="jhbjbj">
           <td width="6%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d'); ?>&module=reports&report=8&Today=Today">
           <input name="todayreport22" type="text" id="todayreport2" value="Today" class="  upclass h2  <?php if($_REQUEST['Today']=='Today') { ?> selected1 <?php } ?>"  readonly="readonly" style="width: 65px"/>
           </a></td>
       
          <td width="8%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d',strtotime('+1 days')); ?>&module=reports&report=8&tomorrow=tomorrow">
            <input name="tomorrowreport2" type="text"  id="tomorrowreport" value="Tomorrow" class="  upclass h2 <?php if($_REQUEST['tomorrow']=='tomorrow') { ?> selected1 <?php } ?>"     readonly="readonly" style="width: 92px"/>
          </a></td>
        <td width="5%"><a href="<?php echo $fullurl; ?>showpage.crm?fromDatetrav=<?php echo date('Y-m-d',strtotime('+5 days')); ?>&module=reports&report=8&T5=T5" >
      <input name="T5" type="T5" id="T5" value="T-5" class=" upclass h2 <?php if($_REQUEST['T5']=='T5') { ?> selected1 <?php } ?>"  readonly="readonly"style=" width: 37px;" />
    </a></td>
	</div>
	
	
    <td align="right" > <table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
		  <td height="22" style="padding-top: 20px;"><input name="queryId" type="text"  class="topsearchfiledmain" id="myinputqueryId" style="width:391px;"  size="6"  placeholder="Search"  value=""/>
		    <span style="padding-right:20px;">
		    <input name="module2" id="module2" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		    </span></td>  
        <td style="padding-right:20px;"><input name="report" id="report" type="hidden" value="8" />		</td>
  </tr>
</table>
		<input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />		 </td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
 
 
<div id="margin" class="filterable">
					<form method="get">
					<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
					<input name="report" id="report" type="hidden" value="8" /><br /><br />
					<input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="    width: 80px !important; margin-right: 9px; background-color: #2bb0dd; border: 1px solid #404346;	color: #fff; text-align:center;" />
					<a href="showpage.crm?module=reports&report=8" >
					<input type="button" name="Reset" value="Reset" class="inptSearcpd" style="width: 80px !important; margin-right: 9px; background-color: #000; border: 1px solid #404346; color: #fff; text-align:center;" /></a>  
					
				<table border="0" cellpadding="4" cellspacing="0" class="table tablesorter gridtable" id="orders-table" data-search="false" data-striped="true" data-pagination="true" data-filter-control="true" >
				   	<thead>
   		<tr style="font-family:normal;text-transform:uppercase;text-align:center;">
						
						 <th align="left" class="header">Query&nbsp;ID</th> 
						 <th align="left" class="header">TOUR&nbsp;DATE </th>
						 <th align="left" class="header">Payment&nbsp;Status</th>
						 <th align="left" class="header">TOUR&nbsp;NAME </th> 
						 <th align="left" class="header">Pax </th>
						 <th align="left" class="header">Full&nbsp;Name</th>
						 <th align="left" class="header">Contact&nbsp;No.</th>
						 <th align="left" class="header">Email</th>
						 <th align="left" class="header">Operation&nbsp;Person</th>
		   		      </tr>
					   <tr>
 
<script type="text/javascript">
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script>

					    
					    <th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="QueryId" id="queryId" name="queryId" value="<?php echo stripcslashes($_REQUEST["queryId"]); ?>"/></th>
					    <th align="left"><input  type="text"  class="topsearchfiledmain1 inptSearcpd" id="daterange" name="daterange" size="6"  placeholder="DD-MM-YYYY"  value="<?php echo $_REQUEST['daterange']; ?>" /></th>
					    <th align="left"> <select name="paymentstatus" id="paymentstatus" class="inptSearcpd" style="width:145px; " >
            <option value="" disabled="disabled">Payment Status</option> 
			<option value="1" <?php if($_GET['paymentstatus']=='1'){ ?>selected="selected"<?php  } ?>>Paid</option>
			<option value="0" <?php if($_GET['paymentstatus']=='0'){ ?>selected="selected"<?php  } ?>>Pending</option>  
          </select></th>
					   <th align="left">				 
					  <div style=" display:inline-block; position:relative;">
		 <a style="position: absolute; right: 15px; top: 3px; right: 6px; z-index: 999; font-weight: normal; font-size: 12px; width: 23px; height: 122px;" id="selectalllink"></a><?php echo $checkvalsightseeing; ?>
					  <select name="check_list[]" multiple="multiple" class="form-control select2 validate" id="check_list" style="width: 100%;" data-placeholder="Select Tour Type" displayname="Facilities" onchange="callme();">
                     
                                       <?php   
                                          $selectcfcly=''; 
                                          $wherecfcly=''; 
                                          $rscfcly='';  
                                          $selectcfcly='*';    
                                          $wherecfcly='1';  
                                          $rscfcly=GetPageRecord($selectcfcly,_TOUR_TYPE_MASTER_,$wherecfcly); 
                                          $newdata = explode(',', $checkvalsightseeing22);
                                          while($facility=mysqli_fetch_array($rscfcly)){   
                                          ?>
                                       <option value="<?php echo $facility['id']; ?>" <?php
                                       foreach ($_REQUEST['check_list'] as $key => $value) {
                                       		if($value == $facility['id']){
                                       			echo 'selected="selected"';
                                       		}
                                       }
                                       ?>><?php echo $facility['name']; ?></option>
                                       <?php } ?>
                        </select>
	  </div></th>
	                    <script type="text/javascript">
					   	$(document).ready(function(){
							$('#serviceList').on('click',function(){
								$('.searvice_list_box').toggleClass('blockList');
								$('.searvice_list_box').toggleClass('hideList');
							});
							
						});
						$(document).ready(function(){
							$('#searchbody').on('click',function(){
								$('.searvice_list_box').toggleClass('hideList');
								$('.searvice_list_box').toggleClass('hideList');
							});
							
						});
					   </script>
					   
					   <th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="Pax"  id="pax" name="pax" value="<?php echo stripcslashes($_REQUEST["pax"]); ?>" /> </th>
					   <th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="Name"  id="guestName" name="guestName" value="<?php echo stripcslashes($_REQUEST["guestName"]); ?>" /></th>
					   				    
					   
					   
					   <!--<th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="Address" id="address" name="address" value="<?php echo stripcslashes($_REQUEST["address"]); ?>"   /></th>-->
					   <th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="Phone Number"  id="guestPhone" name="guestPhone" value="<?php echo stripcslashes($_REQUEST["guestPhone"]); ?>" /></th>
					   <th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="Email"  id="guestEmail" name="guestEmail" value="<?php echo stripcslashes($_REQUEST["guestEmail"]); ?>" /></th>	
					   <th align="left"><input type="text" align="center" class="inptSearcpd" placeholder="Deal Person" id="assignTo" name="assignTo" value="<?php echo stripcslashes($_REQUEST["assignTo"]); ?>"   /></th>
					   </tr>
				  <style>
					   .inptSearcpd{padding:4px;width:80px; !important;margin-top:8px; outline: none;text-align:left; te}
					   </style>
				   
				  <tbody style="text-align:center;" id="mytableAllData">
				  <?php
				
					$no=1;  
					$where=''; 
					$rs='';  
					$wheresearch=''; 
					$limit=50;	
					$destination='';
					
					 if($_GET['destination']!=''){
					$destination=' and	destinationId='.clean($_GET['destination']).'';
					} 
					
              $whereFromDate='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){ 
$fromDate=date('Y-m-d', strtotime($fromDate));
$toDate=date('Y-m-d', strtotime($toDate));
$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
} 
		
			
					
					$queryId='';
					if($_GET['queryId']!=''){
						
						$queryId=' and	id='.$_GET['queryId'].'';
					}
					
					$sightseeingDate='';					
					if($_GET['daterange']!=''){
					
						$myString = $_GET['daterange'];
						$myArray = explode(' - ', $myString);
					
						$sightseeingDateval=$_GET['daterange'];
					    $sightseeingDate=' and	toDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" ' ;
					}
					
					if($_GET['paymentstatus'] == 1){ //paid _AGENT_PAYMENT_REQUEST_ pendingCost
						$paymentquery = "and id in ( select queryid from "._AGENT_PAYMENT_REQUEST_." where pendingCost < 1 )";
						
					}
					if($_GET['paymentstatus'] == 0){ //pending
						$paymentquery = "and id in ( select queryid from "._AGENT_PAYMENT_REQUEST_." where pendingCost > 1 )";
					}
					
					
					
					
					$check='';
					if(!empty($_GET['check_list'])) {
					    $count = count($_GET['check_list']);
						foreach($_GET['check_list'] as $check2) {
							 $checkvalsightseeingmulti.="'".$check2."',";
						}
						 $checkvalsightseeing = rtrim($checkvalsightseeingmulti,',');
						 $check=' and  tourType IN ('.$checkvalsightseeing.') ';
						
					}
					 
					$queryAdult='';
					if($_GET['queryAdult']!=''){
						$queryAdult=' and   adult='.$_GET['queryAdult'].' ';
					}
					$address='';
					if($_GET['address']!=''){
						$address=' and   pickupAddress like "%'.$_GET['address'].'%"';
					}
										$queryChild='';
					if($_GET['queryChild']!=''){
						
						$queryChild=' and  child='.$_GET['queryChild'].' ';
					}
					$queryInfant='';
					if($_GET['queryInfant']!=''){
						$queryInfant=' and   infant='.$_GET['queryInfant'].' ';
					}
						
					
					$queryPax='';
					if($_GET['pax']!=''){
						//$queryPax=' or   infant='.$_GET['pax'].' or child='.$_GET['pax'].' or adult='.$_GET['pax'].' ';
						$select = ' *, ( adult + child + infant) AS pax ';
						$pax = ' and adult = '.$_GET['pax'].' ';
						
						
						
					}else{					
						$select='*';
					}
					
					 
					$adult='';
					if($_GET['adult']!=''){
						$adult=' and   adult = '.$_GET['adult'].' ';
					}
					
					$child='';
					if($_GET['child']!=''){
						$child=' and  child = '.$_GET['child'].' ';
					}
					
						$infant='';
					if($_GET['infant']!=''){
						$infant=' and  infant = '.$_GET['infant'].' ';
					}
					
					$assignTo='';
					if($_GET['assignTo']!=''){
						$assignTo=' and  assignTo in ( select id from '._USER_MASTER_.' where firstName like "%'.$_GET['assignTo'].'%" or lastName like "%'.$_GET['assignTo'].'%" ) ';
					}
					$guestName='';
					if($_GET['guestName']!=''){
						if($clientType==2){
						$guestName=' and  companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_GET['guestName'].'%" or lastName like "%'.$_GET['guestName'].'%"  or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="contacts" and phoneNo like "%'.$_GET['guestName'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="contacts" and email like "%'.$_GET['guestName'].'%" ) )  ';
						}
						else{
							$guestName=' and  companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['guestName'].'%" or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="corporate" and phoneNo like "%'.$_GET['guestName'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="corporate" and email like "%'.$_GET['guestName'].'%" ) )  ';
						}
					}
					$guestPhone='';
					if($_GET['guestPhone']!=''){
						if($clientType==2){
							$guestPhone=' and  companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_GET['guestPhone'].'%" lastName like "%'.$_GET['guestPhone'].'%"  or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="contacts" and phoneNo like "%'.$_GET['guestPhone'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="contacts" and email like "%'.$_GET['guestPhone'].'%" ) )  ';
						}
						else{
							$guestPhone=' and  companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['guestPhone'].'%" or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="corporate" and phoneNo like "%'.$_GET['guestPhone'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="corporate" and email like "%'.$_GET['guestPhone'].'%" ) )  ';
						}
					}
					
					$guestEmail='';
					if($_GET['guestEmail']!=''){
						if($clientType==2){
						$guestEmail=' and  companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_GET['guestEmail'].'%" or lastName like "%'.$_GET['guestEmail'].'%"  or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="contacts" and phoneNo like "%'.$_GET['guestEmail'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="contacts" and email like "%'.$_GET['guestEmail'].'%" ) )  ';
						}
						else{
							$guestEmail=' and  companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_GET['guestEmail'].'%" or id in( select masterId from '._PHONE_MASTER_.' where  sectionType="corporate" and phoneNo like "%'.$_GET['guestEmail'].'%" ) or id in( select masterId from '._EMAIL_MASTER_.' where  sectionType="corporate" and email like "%'.$_GET['guestEmail'].'%" ) )  ';
						}
					}

					$dateserch='';
					if($_REQUEST['daterange']!=''){
					$dateserch=' toDate asc';
					}else{
					$dateserch=' queryOrder DESC, dateAdded DESC';
					}
	$todayDate='';
if($_GET['checkday']=='1'){	 
$todayDate='and DATE(fromDate)="'.date('Y-m-d').'"';
}
if($_GET['checkday']=='2'){	 
$todayDate='and DATE(fromDate)="'.date('Y-m-d',strtotime('+1 days')).'"';
}
if($_GET['checkday']=='3'){	 
$todayDate='and DATE(fromDate)="'.date('Y-m-d',strtotime('+5 days')).'"';
}
$fromDatetrav='';
if($_REQUEST['fromDatetrav']!=""){	 
$fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';
} 


		
					
					 
					 
					
					
				 	$wheresearch='1   '.$guestName.' '.$guestEmail.'  '.$guestPhone.'   '.$assignTo.' '.$paymentquery.'  '; 
					  
				 	$where='where '.$wheresearch.'  '.$queryId.' '.$pax.'  '.$check.'  '.$sightseeingDate.' '.$fromDatetrav.' '.$todayDate.'   and  deletestatus=0 ORDER BY '.$dateserch.' ';  
					$page=$_GET['page'];
					$targetpage=$fullurl.'showpage.crm?module=travelbooking&records='.$limit.'&searchField='.$searchField.'&'; 
					$rs=GetRecordList($select,_QUERY_MASTER_,$where,$limit,$page,$targetpage); 

					$totalentry=$rs[1]; 
					$paging=$rs[2]; 
					while($resultlists=mysqli_fetch_array($rs[0])){ 
					
					?>					
							<tr style="text-align:center;">							  
							  <td align="left"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resultlists['queryId']);?>"><?php echo makeQueryId($resultlists['id']);?></a></td>
							  <td align="left"><?php echo showdate($resultlists['toDate']);?></td>
							   <td align="left">   <?php   
           $qid = ($resultlists['id']);
          $selectpc='*';    
          $wherepc='queryId="'.$qid.'" ';  
          $rspc=GetPageRecord($selectpc,_AGENT_PAYMENT_REQUEST_,$wherepc); 
          while($resListingpc=mysqli_fetch_array($rspc)){ 
        $pendingamount=$resListingpc['pendingCost'];  
         }
		 
		 if($pendingamount<1){
        ?>
		<div style="color:#009900;"> <strong>Paid</strong></div>
		<?php } else { ?>
		<div style="color:#CC3300;"><strong><?php echo $pendingamount; ?></strong></div>
		<?php } ?></td>
							   <td align="left">
							   <?php
								$sic = $resultlists['tourType'];
								$selectsic='*'; 
								$wheresic='';
								$wheresic='id="'.$sic.'" ';
								$sicr=GetPageRecord($selectsic,_TOUR_TYPE_MASTER_,$wheresic);             
								while($resultsic=mysqli_fetch_array($sicr))
								{							
									echo $resultsic['name'];
									echo '<br><br>';
								}									
								
								?></td>
								
							   <td align="left">
							    <?php 
								if($resultlists['adult']!=''){
									echo $total = $resultlists['adult'].'+';
								}if ($resultlists['child']!='') {
									echo $total = $resultlists['child'].'+';
								}if ($resultlists['infant']!='') {
									echo $total = $resultlists['infant'];
								}if($resultlists['adult']=='' && $resultlists['child']=='' && $resultlists['infant']=='')
								{
									echo $total="-";
								}
								// echo $total;
								?></td>
								<?php
								  $clientType=$resultlists['clientType'];
								  if($clientType==2){
								  $select22='*';  
								  $where22='id='.$resultlists['companyId'].''; 
								  $rs22=GetPageRecord($select22,_CONTACT_MASTER_,$where22); 
								  $contantnamemain2=mysqli_fetch_array($rs22);
								  
								   $clientnem2 = $contantnamemain2['firstName'].' '.$contantnamemain2['lastName'].'<br/>';
								   $getphone2 =  getPrimaryPhone($contantnamemain2['id'],'contacts').'<br/>';
								   $getemail2 =  getPrimaryEmail($contantnamemain2['id'],'contacts').'<br/>'; 
								  
								  }else{
								  
								  $select22='*';  
								  $where22='id='.$resultlists['companyId'].''; 
								  $rs22=GetPageRecord($select22,_CORPORATE_MASTER_,$where22); 
								  $contantnamemain2=mysqli_fetch_array($rs22);
								  
								   $clientnem2 = $contantnamemain2['name'].'<br/>';
								   $getphone2 =  getPrimaryPhone($contantnamemain2['id'],'corporate').'<br/>';
								   $getemail2 =  getPrimaryEmail($contantnamemain2['id'],'corporate').'<br/>';
								  }
								  ?>
								<td align="left"><?php if($clientType==2){ echo $clientnem2; }else { echo $clientnem2 ;}?></td>
								
								
								
								
									<td align="left"><?php if($clientType==2){ echo $getphone2; }else { echo $getphone2 ;}?></td>
									<td align="left"><?php if($clientType==2){ echo $getemail2; }else { echo $getemail2 ;}?></td>
								<td align="left">
								 
							   <?php echo getUserName($resultlists['assignTo']); ?></td>
							</tr>
						
						
						<?php $no++; } ?>
			  	  </tbody>
				 </table>			
					</form>
				 <?php if($no==1){ ?>
				<div class="norec">No <?php echo $pageName; ?></div>
				<?php } ?>
				<div class="pagingdiv">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  		<tbody>
						
							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0">
									  <tr>
										<td style="padding-right:20px;"><?php echo $totalentries= $totalentry+$totalentry1; ?> entries</td>
										<td>
											<select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >
												<!--<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>-->
												<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
												<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
												<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
												<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
											</select>										</td>
									  </tr>
									</table>								</td>
								<td align="right">
									<div class="pagingnumbers"><?php echo $paging; ?></div>								</td>
							</tr>
						</tbody>
					</table>
				</div>
		</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#reportdata').val(boxreport);  
$('#downloadrtm').submit();  
}
</script>
</div> 	</td>
  </tr> 
</table>

<script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('check_list[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
	
</script>
<script>
$(document).ready(function(){
  $("#searchdata").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myselectData li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
$(document).ready(function(){
  $("#myinputqueryId").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#mytableAllData tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
<style>
.inptSearcpd {
    padding: 4px;
    width: 100% !important;
    outline: none;
    text-align: left;
    box-sizing: border-box;
}
.Zebra_DatePicker_Icon_Wrapper{width:100% !important;}
.select2-container--default .select2-selection--multiple { 
    border: 1px solid #aaa !important;
    border-radius: 0px !important; min-height:50%;
}
.select2-container { 
   min-height:50%;
}
.select2-container--default .select2-selection--multiple { 
    min-width: 200px !important;
}
.select2-container .select2-selection--multiple { 
    min-height: 28px !important;
    margin-top: 8px; 
}
</style>
<link rel="stylesheet" href="select2.min.css">
<script src="select2.full.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
   $(document).ready(function() {
   	$('.select2').select2();
       $("#add").click(function() {
       	
           var lastField = $("#buildyourform div:last");
           var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
           var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
           fieldWrapper.data("idx", intId);
           var covered = $("<div class='col-md-3'><input type=\"text\" class=\"form-control  parsley-validated\" name=\"covered[]\" placeholder=\"covered\" /></div>");
           var Inclusions = $("<div class='col-md-3'><input type=\"text\" class=\"form-control  parsley-validated\" name=\"inclusions[]\" placeholder=\"inclusions\" /></div>");
           var Exclusions = $("<div class='col-md-3'><input type=\"text\" class=\"form-control  parsley-validated\" name=\"exclusions[]\" placeholder=\"exclusions\" /></div>");
           var Event = $("<div class='col-md-3'><input type=\"date\" class=\"form-control event parsley-validated\" name=\"event[]\" placeholder=\"event date\"/></div>");
           var removeButton = $("<input type=\"button\" class=\"remove\" value=\"X\" />");
           removeButton.click(function() {
               $(this).parent().remove();
           });
           fieldWrapper.append(covered);
           fieldWrapper.append(Inclusions);
           fieldWrapper.append(Exclusions);
           fieldWrapper.append(Event);
           fieldWrapper.append(removeButton);
           $("#buildyourform").append(fieldWrapper);
       });
   });
   
   $(document).ready(function() {
   //Add images
   $("#addimage").click(function() {
           var lastField = $("#buildgallarty div:last");
           var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
           var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
           fieldWrapper.data("idx", intId);
           var gallary = $("<input type=\"file\" class=\"selectfileclass\" name=\"gallary[]\" />");
           var removeButton = $("<input type=\"button\" class=\"remove\" value=\"X\" />");
           removeButton.click(function() {
               $(this).parent().remove();
           });
           fieldWrapper.append(gallary);
           fieldWrapper.append(removeButton);
           $("#buildgallarty").append(fieldWrapper);
       });
   });
   
    
</script>
<style>
   .fieldwrapper{margin-bottom:10px; position:relative;}
   .remove {
   background-color: #e00000;
   color: #fff;
   border: 0px;
   font-weight: bold;
   width: 25px;
   height: 25px;
   border-radius: 50px;
   }
   .selectfileclass {
   overflow: visible;
   border: 1px #f1f1f1 solid;
   margin-right: 10px;
   border-radius: 3px;
   }
   #buildyourform .fieldwrapper {
   padding: 10px;
   border: 1px #f3f3f3 solid;
   border-radius: 4px;
   background-color: #fdfdfd;
   position: relative;
   padding-right: 50px;height: 60px;
   }
   #buildyourform .remove{position:absolute;}
   
    .col-md-3 {
    float: left; 
}
.select2-container--default .select2-selection--multiple .select2-selection__choice { 
    width: 100%;
    box-sizing: border-box;
}
.daterangepicker.ltr { 
    box-shadow: 0px 0px 10px #40434687;
    border: 1px #ccc solid;
}
</style>
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
  "autoApply": true,
    opens: 'right',
	locale: {
            format: 'DD-MM-YYYY'
        }
  
  }, function(start, end, label) { 
     
  });
  
  
   
});
  <?php if($_GET['daterange']==''){ ?>
setTimeout(function(){
$('#daterange').val('');
 }, 500);
 <?php }  ?>
 $(function() {
  $('input[name="rangeDate"]').daterangepicker({
  "autoApply": true,
    opens: 'left',
	locale: {
            format: 'DD-MM-YYYY'
        }
  
  }, function(start, end, label) { 
     
  });
  
  
   
});
  <?php if($_GET['rangeDate']==''){ ?>
setTimeout(function(){
$('#rangeDate').val('');
 }, 500);
 <?php }  ?>
 function callme(){
 var toteldiv = $('.select2-selection__choice').length;
 $('.select2-selection__rendered').append('<li class="totaldiv">'+toteldiv+' Selected</li>');
 }
 
 $('#selectalllink').click(function() {
 $('.totaldiv').remove();
    $('#check_list option').prop('selected', true);
	var toteldiv = $('#check_list option').length;
	$('.select2-selection__rendered').append('<li class="totaldiv">'+toteldiv+' Selected</li>');
});
<?php if($_REQUEST['check_list']!=''){ ?>
setTimeout(function(){
$('.totaldiv').remove();  
	$('.select2-selection__rendered').append('<li class="totaldiv"><?php echo count($_REQUEST['check_list'], COUNT_RECURSIVE); ?> Selected</li>');
 }, 500);
<?php }  ?>
</script>
<style>
.select2-selection__choice{display:none;}
.select2-search__field:focus{margin-top: 22px !important;}
.totaldiv{    position: absolute;
    top: 15px;
    font-weight: normal;}
</style>
 <?php }?> 
<?php if($_REQUEST['report']=='9'){ ?>
<?php
$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']);
$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate'];
$assignto=$_GET['assignto'];
$destinationId=$_GET['destinationId'];
$categoryId=$_GET['categoryId'];
$tourType=$_GET['tourType'];
$clientType=$_GET['clientType'];
$clients=$_GET['Clients'];

if($assignto!=''){  
$strWhere.=' and assignTo='.$assignto.'';
}
if($destinationId!=''){  
$strWhere.=' and destinationId='.$destinationId.'';
}
if($categoryId!=''){  
$strWhere.=' and categoryId='.$categoryId.'';
}
if($tourType!=''){  
$strWhere.=' and tourType='.$tourType.'';
}
if($clientType!=''){  
$strWhere.=' and clientType='.$clientType.'';
}
if($Clients!=''){  
$strWhere.=' and companyId='.$Clients.'';
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="25%"><div class="headingm" style="margin-left:6px;"  ><span id="topheadingmain"> &nbsp;&nbsp;Tax&nbsp;Report</span>
	    <div id="deactivatebtn" style="display:none;">
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate_r" style="width:80px;" size="6" placeholder="From"  value="<?php if($_GET['fromDate']!=''){ echo  date('d-m-Y', strtotime($_GET['fromDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>
        <td><input name="toDate" type="text"  class="topsearchfiledmain" id="toDate_r" style="width:80px;" size="6" placeholder="To" value="<?php if($_GET['toDate']!=''){ echo  date('d-m-Y', strtotime($_GET['toDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>
        <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
 
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input name="report" id="report" type="hidden" value="9" />
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>  
        <td style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>

		</td>
       
      </tr>
      
	</table></td>
	</tr>

</table>

</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">

<div id="margin"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
   <thead>
   <tr>
     <th width="109" align="center" class="header">Query&nbsp;ID</th> 
     <th width="109" align="center" class="header"> Invoice No.</th>
     <th width="96"  align="center" valign="middle" class="header">Invoice Date</th> 
     <th width="40" align="center" class="header"> Client</th>
     <th width="43" align="center" class="header"> GSTN</th>
	 <th width="43" align="center" class="header"> Sale&nbsp;Amount</th>
	 <th width="41" align="center" class="header">IGST </th>
	 <th width="43" align="center" class="header"> CGST</th>
     <th width="44" align="center" class="header">SGST </th>
	</tr> 
   </thead>
  <tbody>
    <?php
	
	  $n=1; 
	  $select='*'; 
	  $where=''; 
	  $rs=''; 
	  $wheresearch=''; 
	  //$where='1 order by id desc';
	  
	  $limit=clean($_GET['records']);
	  $searchField=clean(trim(ltrim($_GET['searchField'], '0')));
	  $mainwhere='';
	  if($searchField!=''){
	  $mainwhere=' and  queryId='.$searchField.'';
	  }
	  $strWhere='';
	  if($fromDate!='' && $toDate!=''){
	  $fromDate = date('Y-m-d', strtotime( $fromDate ));
	  $toDate = date('Y-m-d', strtotime( $toDate ));
	  $strWhere.='and invoicedate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus = 0';
	  }
	  $fromDatetrav='';
	  if($_REQUEST['fromDatetrav']!=""){	 
	  $fromDatetrav='and DATE(fromDate)="'.$_REQUEST['fromDatetrav'].'"';
	  } 
	  $invoiceid=clean(trim(ltrim($_GET['invoiceid'], '0')));
	 
	  if($invoiceid!=''){
	  $invoiceid=' and  id='.$invoiceid.'';
	  }
	   $profileiddata='';   
	  if($loginuserprofileId=='48'){
	  
	  $profileiddata=' and  queryId in (select id from miceMaster where companyId in ( select companyId from userMaster where id="'.$_SESSION['userid'].'"))';
	  }

	  $where=' 1 and mice=0 '.$mainwhere.' '.$invoiceid.' '.$strWhere.' '.$fromDatetrav.' '.$profileiddata.' and invoicedate!="0000-00-00" order by id asc'; 
	  $page=$_GET['page'];
	  $targetpage=$fullurl.'showpage.crm?module=invoice&records='.$limit.'&searchField='.$searchField.'&';
	   
      $rs=GetPageRecord('*',_INVOICE_MASTER_,$where,$limit,$page,$targetpage);
	  while($resultlists=mysqli_fetch_array($rs)){
	  //print_r($resultlists); 
     // $pid = $resultlists['id'];
      ?>
     <?php 
	   $rs1=GetPageRecord('companyId,clientType','queryMaster','id="'.$resultlists['queryId'].'"'); 
       $getqueryId=mysqli_fetch_array($rs1);
	   //echo $getqueryId['clientType'];
	   if($getqueryId['clientType']==1){
	   $rs2=GetPageRecord('name','corporateMaster ','companyTypeId="'.$getqueryId['companyId'].'"'); 
       $getcompanyid=mysqli_fetch_array($rs2);
	   //echo $getcompanyid['companyTypeId'];
	   $getClientName=$getcompanyid['name'];
	   }  
	   
	   if($getqueryId['clientType']==2){
	       $rs3=GetPageRecord('firstName','contactsMaster ','id="'.$getqueryId['companyId'].'"'); 
		   $getclientlist=mysqli_fetch_array($rs3);
		  // print_r($getclientlist);
		  $getClientName=$getclientlist['firstName'];
	   }
	   
//////////////////////////////////get all gst ///////////////////////////
				   
	        $select1=''; 
			$where1=''; 
			$rs1='';   
			$select1='*';  
			$where1='queryid="'.$resultlists['queryId'].'" order by id desc'; 
			$rs1=GetPageRecord($select1,_PAYMENT_REQUEST_MASTER_,$where1); 
			$resultpaymentpage=mysqli_fetch_array($rs1);
			
			$select2=''; 
			$where2=''; 
			$rs2='';   
			$select2='*';  
			$where2='paymentId="'.$resultpaymentpage['id'].'"  order by id desc'; 
			$rs2=GetPageRecord($select2,_AGENT_PAYMENT_REQUEST_,$where2); 
			$requesetdata=mysqli_fetch_array($rs2);
			
			$Totalsaleamount = $Totalsaleamount+$requesetdata['finalCost'];
			//print_r($requesetdata);
			$reqclientGst=$requesetdata['reqclientGst'];
			$reqmarginGst=$requesetdata['reqmarginGst'];
			
			if($reqclientGst!=0){
			$GST=$requesetdata['reqclientGst'];
			$Cgst=$requesetdata['reqclientCGst'];
			$Sgst=$requesetdata['reqclientSGst'];
			$Igst=$requesetdata['reqclientIGst'];
			$finalReqCost=$requesetdata['reqclientCost'];
			///////start get total/////////////
			$TotalIgst = $TotalIgst+round(($Igst*$requesetdata['reqclientCost'])/100);
			$TotalCgst = $TotalCgst+round(($Cgst*$requesetdata['reqclientCost'])/100);
			$TotalSgst = $TotalSgst+round(($Sgst*$requesetdata['reqclientCost'])/100);
			/////end get total/////////
			}
			
			if($reqmarginGst!=0){
			$GST=$requesetdata['reqmarginGst'];
			$Cgst=$requesetdata['reqmarginCGst'];
			$Sgst=$requesetdata['reqmarginSGst'];
			$Igst=$requesetdata['reqmarginIGst'];
			$finalReqCost=$requesetdata['reqmarginCost'];
			} 
//////////////////////////////////end gst code here////////////////////			
     ?>
    
        <tr>
		<td align="center"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resultlists['queryId']);?>"><?php echo makeQueryId($resultlists['id']);?></a></td>
		<td align="center"><div class="bluelink">
	
		<?php if($resultlists['docName']!=''){ ?>
	 <a href="dirfiles/<?php echo $resultlists['docName']; ?>" target="_blank"><?php echo 'INV';  ?><?php echo makeInvoiceId($resultlists['id']); ?></a>
		 <?php } else { ?>
	<a href="genrateDOMPdf.php?pageurl=<?php echo $fullurl;  ?>invoicepdf.php?id=<?php echo encode($resultlists['id']); ?>&mice=<?php echo $resultlists['mice'];     ?>" target="_blank"><?php if($resultlists['invoiceType']=='1'){ echo 'INV'; } else { echo 'PER'; } ?><?php echo makeInvoiceId($resultlists['id']); ?></a>
		 <?php } ?> </div></td>
       <td align="center"><?php if($resultlists['invoicedate']!=''){ echo showdate($resultlists['invoicedate']);} ?></td>
       <td align="center" ><?php
		$select2='companyId,clientType'; 
		$where2='id="'.$resultlists['queryId'].'"'; 
		if($resultlists['mice']=='0'){
		$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2); 
		} else { 
		$rs2=GetPageRecord($select2,'miceMaster',$where2);  
		}
		$queryCompany=mysqli_fetch_array($rs2); 
        ?><?php echo showClientTypeUserName($queryCompany['clientType'],$queryCompany['companyId']); ?> 
		</td>
        <td align="center"><?php
		if($getqueryId['clientType']==1){ 
		$resulttype='corporate';
		}if($editresult['clientType']==2){ 
		$resulttype='contacts';
		}
		if($resulttype!=''){
		$select6='*';  
		$where6='addressType="'.$resulttype.'" and addressParent="'.$queryCompany['companyId'].'"'; 
		$rs6=GetPageRecord($select6,_ADDRESS_MASTER_,$where6); 
		$address=mysqli_fetch_array($rs6); 
		echo $address['gstn'];  } ?></td>
		
		<td align="center"><?php echo $requesetdata['finalCost'];?></td> 

		<td align="center"><?php if($Igst!=0){ echo (($Igst*$requesetdata['reqclientCost'])/100); }  ?></td> 
		<td align="center"><?php if($Sgst!=0){ echo (($Cgst*$requesetdata['reqclientCost'])/100); } ?></td>
        <td align="center"><?php if($Sgst!=0){ echo (($Sgst*$requesetdata['reqclientCost'])/100); } ?></td>  
        </tr>
	 <?php } $n++; ?>
		 <!--Total start-->
		 <tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">
		 <td align="center" valign="middle"><strong>Total</strong></td>
			<td align="center" valign="middle">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="center"><?php echo $Totalsaleamount; ?></td>
			<td align="center"><?php echo $TotalIgst; ?></td>
			<td align="center"><?php echo $TotalCgst; ?></td>
			<td align="center"><?php echo $TotalSgst; ?></td>
	  </tr> 
			
		 <!--Total end-->
  </tbody>
 </table>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadmargin" id="downloadmargin" action="download_marginreport.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Margin Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="marginreport" id="marginreport" cols="" rows="" style=" display:none;"></textarea></form></div>

<script>
function copydatatodata(){
var margin = $('#margin').html();
$('#marginreport').val(margin);  
$('#downloadmargin').submit();  
}
</script>

<script>
$('#fromDate_r').Zebra_DatePicker({
      format: 'd-m-Y',  
      pair: $('#toDate_r'),
   });

   $('#toDate_r').Zebra_DatePicker({
       format: 'd-m-Y',
       
   });
 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
 <?php }?> 
<?php if($_REQUEST['report']=='10'){ 

$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']); 
$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate']; 

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>



<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   
    <td>
    	<div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> &nbsp;Finance report</span>
		<div id="deactivatebtn" style="display:none;">
		 	
		 	<?php if($deletepermission==1){ ?> 
			<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
			<?php } ?>
		
		</div>
			
		</div>
	</td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php if($fromDate!=''){ echo date('d-m-Y',strtotime($fromDate));} ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php if($toDate!=''){ echo date('d-m-Y',strtotime($toDate));} ?>"/> </td>
    
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" />
		<input name="report" id="report" type="hidden" value="9" />	
		</td>
  </tr>
</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 0px;">

<style>
#example_wrapper .row{padding:20px !important;}
#margin {border:1px #eee solid !important;}
#margin table td{border-bottom:1px #eee solid !important; padding:8px !important;}
#margin table th{background-color:#eee !important;}
#example_wrapper .col-sm-6{    float: left;
    padding: 19px 0px;}
#example_wrapper .col-sm-6 .form-control{margin-left:5px;}	
#example_wrapper .dataTables_length{display:none;}
.dataTables_info{ display:none;}	
.paging_simple_numbers ul{ padding:0px; margin:0px; }
.pagination ul li{    float: left;
   list-style:none !important;}
.dataTables_filter{    margin-top: -24px;
   margin-left: 1206px;}
.dataTables_filter input{
padding:4px;
}
.dataTables_length{    margin-left: 250px;
   margin-top: -25px;
}
.dataTables_length select { padding:4px;}
.dataTables_paginate ul li{    float: left;
   padding: 5px;
   list-style: none;
   border: 1px solid #2bb0dd;}
.dataTables_paginate ul li active{ background-color:#000;}
.paginate_button page-item active{ background-color:#2bb0dd;}
.dataTables_paginate{    margin-right: 0px;
   margin-top: -25px;
   margin-left: 1251px;}
.pagination> li.active {
   z-index: 2;
   color: #fff;
   cursor: default;
   background-color: #337ab7;
   border-color: #337ab7;
}
.pagination> li.active>a {
  color: #fff !important;
}
.table a{ color:#fff;} 
</style>
<div id="margin" style="width:3500px;">
<table width="1050" border="0" cellpadding="8" cellspacing="0" class="table table-striped table-bordered" id="example" style="width:100%; margin-top: 3px !important; "> 
   <thead> 
   <tr>
     <th width="100"  align="left" valign="middle" class="header"><label for="checkAll">
     <div align="left">Booking Ref#</div>
     </label></th> 
     <th width="100" align="left" class="header"  ><div align="left">Booking&nbsp;Date</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Corporate&nbsp;Name</div></th>
     <th width="100" align="left" class="header"  > <div align="left">Sales&nbsp;Agent</div></th>
     <th width="100" align="left" class="header"  > <div align="left">Sales&nbsp;Manager</div></th> 
     <th width="100" align="left" class="header"  ><div align="left">Supplier</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Check-In</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Check-Out</div></th>
     <th width="100" align="left" class="header"  ><div align="left">No&nbsp;Of&nbsp;Rooms</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Cost&nbsp;Price</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Tax&nbsp;component</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Gross&nbsp;Cost&nbsp;Price</div></th> 
     <th width="100" align="left" class="header"  ><div align="left">Selling&nbsp;Price</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Gross&nbsp;Selling&nbsp;Price</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Currency</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Booking&nbsp;Status</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Booked&nbsp;By</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Commission</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Mode</div></th>
     <th width="100" align="left" class="header"  ><div align="left">Hotel&nbsp;RESERVATION&nbsp;ID</div></th>
     <th width="100" align="left" class="header"  ><div align="left">MARKUP&nbsp;AMOUNT</div></th>
     </tr>
   </thead>
  <tbody>
    <?php 
      $n=0; 	  
	  $strWhere=''; 
	  $multiSearch='';
	  $multiSearch=clean($_GET['multiSearch']);  

 

	if($fromDate!='' && $toDate!=''){
	$fromDate = date('Y-m-d', strtotime( $fromDate ));
	$toDate = date('Y-m-d', strtotime( $toDate )); 
	$strWhere=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and ';
	}
  
	  $select='*'; 
      $where='';
      $where=' '.$strWhere.' deletestatus=0 order by id desc ';
      $rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
      while($resultlist=mysqli_fetch_array($rs)){ 
	  
	  $selects='*'; 
      $wheres='';
      $wheres='queryid="'.$resultlist['id'].'" and deletestatus=0 '; 
      $rss=GetPageRecord($selects,_PAYMENT_REQUEST_MASTER_,$wheres);  
      while($resultlistps=mysqli_fetch_array($rss)){
      //print_r($resultlistps);
      $pid = $resultlistps['id']; 
	  
	  $selectpsq='*'; 
      $wherepsq='';
      $wherepsq='paymentId="'.$pid.'" order by id desc ';
      $rspsq=GetPageRecord($selectpsq,_PAYMENT_SUPPLIER_LIST_MASTER_,$wherepsq);  
      $resultlistpsq=mysqli_fetch_array($rspsq);
	  
	  $selecta='*'; 
      $wherea=''; 
      $rsa=''; 
      $wherea=' paymentRequestId='.$pid.' order  by id desc'; 
      $rsa=GetPageRecord($selecta,_PAYMENT_LIST_MASTER_,$wherea); 
      while($resultlistsaa=mysqli_fetch_array($rsa)){
        //print_r($resultlistsa);
      $paymentRequestId = $resultlistsaa['paymentRequestId'];
      
	  
    ?>
    
    
        <tr>
          <td width="100" align="left"> <div align="left"><?php echo makeQueryId($resultlist['id']);?></div></td>
          <td width="100" align="left"> <div align="left"><?php echo showdate($resultlist['queryDate']);?></div></td>
          <td width="100" align="left"> <div align="left"><?php echo showClientTypeUserName($resultlist['clientType'],$resultlist['companyId']);?></div></td>
          <td width="100" align="left" style="width: 100px;"> <div align="left"><?php $companyid = $resultlist['companyId'];
		  
          $selectcomp='*'; 
          $wherecomp='';
          $wherecomp='where   id="'.$companyid.'" ';
          $comp=GetRecordList($selectcomp,_CORPORATE_MASTER_,$wherecomp); 
          $totalentrycomp=$comp[1]; 
          $pagingcomp=$comp[2]; 
          $resultlistcomp=mysqli_fetch_array($comp[0]);
          $saleid = $resultlistcomp['companyCategory'];
          $editassignTo=clean($resultlistcomp['assignTo']);
		  
          $selectuser='*'; 
          $whereuser='';
          $whereuser='where   id="'.$saleid.'" ';
          $user=GetRecordList($selectuser,_USER_MASTER_,$whereuser); 
          $totalentryuser=$user[1]; 
          $paginguser=$user[2]; 
          $resultlistuser=mysqli_fetch_array($user[0]);
          $user = $resultlistuser['firstName'].$resultlistuser['lastName'];
          echo getUserName($editassignTo);
          //echo $companyid?></div></td>
          <td width="100" align="left"> <div align="left">
            <?php  $companyid = $resultlist['companyId'];
          $selectcomp='*'; 
          $wherecomp='';
          $wherecomp='where   id="'.$companyid.'" ';
          $comp=GetRecordList($selectcomp,_CORPORATE_MASTER_,$wherecomp); 
          $totalentrycomp=$comp[1]; 
          $pagingcomp=$comp[2]; 
          $resultlistcomp=mysqli_fetch_array($comp[0]);
          $saleid = $resultlistcomp['companyCategory'];
          $editassignTo=clean($resultlistcomp['assignTo']);
		  
          $selectuser='*'; 
          $whereuser='';
          $whereuser='where   id="'.$saleid.'" ';
          $user=GetRecordList($selectuser,_USER_MASTER_,$whereuser); 
          $totalentryuser=$user[1]; 
          $paginguser=$user[2]; 
          $resultlistuser=mysqli_fetch_array($user[0]);
          $user = $resultlistuser['firstName'].$resultlistuser['lastName'];
          echo getUserName($editassignTo);
          //echo $companyid?>
          </div></td>
          <td width="100" align="left" style="width: 100px;"><div align="left"><?php echo $hotel = strip($resultlistsaa['supplierId']);
          //echo $hotel;
          $selecthotel='*'; 
          $wherehotel='';
          $wherehotel='where   id="'.$hotel.'" ';
          $hotel=GetRecordList($selecthotel,_SUPPLIERS_MASTER_,$wherehotel); 
          $totalentryhotel=$hotel[1]; 
          $paginghotel=$hotel[2]; 
          $resultlisthotel=mysqli_fetch_array($hotel[0]);
          $hotel = $resultlisthotel['name'];
          $cityid = $resultlisthotel['cityId'];
          echo $hotel;?></div></td>
          <td width="100" align="left"><?php echo showdate($resultlist['fromDate']);?></td>
          <td width="100" align="left"> <div align="left"><?php echo showdate($resultlist['toDate']); ?></div></td>
          <td width="100" align="left"> <div align="left"><?php echo strip($resultlist['rooms']); ?></div></td>
          <td width="100" align="left"> <div align="left"><?php echo strip($resultlistpsq['companytotalcost']);?></div></td>
          <td width="100" align="left"> <div align="left"><?php $taxcomponent = strip($resultlistpsq['suppliercgst'])+strip($resultlistpsq['suppliersgst'])+strip($resultlistpsq['supplierigst']); $tax = $taxcomponent*$suppliercost; echo $totaltax = $tax/100;?></div></td>
          <td width="100" align="left"> <div align="left"><?php $suppliercost = strip($resultlistpsq['suppliertotalcost']); echo $suppliercost ;?></div></td>
          <td width="100" align="left"> <div align="left">&nbsp;</div></td>
          <td width="100" align="left"> <div align="left"><?php echo strip($resultlistpsq['companytoalcost']); ?></div></td>
          
          <td width="100" align="left"> <div align="left"><?php echo "INR";?></div></td>
          <td width="100" align="left"> <div align="left"><?php if($resultlist['queryStatus']==6){ echo '<div class="assignquery">Options&nbsp;Sent</div>'; }if($resultlist['queryStatus']==7){ echo '<div class="assignquery">Follow-up</div>'; }if($resultlist['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; } if($resultlist['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlist['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlist['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlist['queryStatus']==5){ echo '<div class="closequery">Time Limit Booking</div>'; }  if($resultlist['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?></div></td>
          <td width="100" align="left" style="width: 100px;"><div align="left"><?php $sid = strip($resultlist['assignTo']);
		    $selectsup='*'; 
            $wheresup='';
            $wheresup='where   id="'.$sid.'" ';
            $sup=GetRecordList($selectsup,_USER_MASTER_,$wheresup); 
            $totalentrysup=$sup[1]; 
            $pagingsup=$sup[2]; 
            $resultlistsaup=mysqli_fetch_array($sup[0]);
            echo $resultlistsaup['firstName'].' '.$resultlistsaup['lastName'];?></div></td>
          <td width="100" align="left"> <div align="left">
		  <?php $suppliertoalcost = strip($resultlistpsq['suppliertotalcost']);
		   $commision = $suppliertoalcost-strip($resultlistpsq['companytotalcost']); if($resultlist['paymentMode']==2){ echo $commision; } ?>
		   </div></td>
          <td width="100" align="left"> <div align="left"><?php if($resultlist['paymentMode']==1){ echo 'Margin'; } if($resultlist['paymentMode']==2){ echo 'Commision'; } ?></div></td>
          <td width="100" align="left" style="width: 100px;"><div align="left">
		  <?php $select2z='*';
$where2z='queryId='.$resultlist['id'].' order by id desc'; 
$rs2z=GetPageRecord($select2z,_VOUCHER_LIST_MASTER_,$where2z); 
$listofsuppliersw=mysqli_fetch_array($rs2z); echo $listofsuppliersw['supplierserviceid']; ?>
</div></td>
          
          <td width="100" align="left"> <div align="left"><?php  if($resultlist['paymentMode']==1){ echo $commision; } ?></div></td>
        </tr>

    <?php $n++; }} }  ?>
  </tbody>
 </table>
</div>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadmargin" id="downloadmargin" action="download_marginreport.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Margin Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="marginreport" id="marginreport" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var margin = $('#margin').html();
$('#marginreport').val(margin);  
$('#downloadmargin').submit();  
}
</script>

</div> 	</td>
  </tr>
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
 <?php }?>
<?php if($_REQUEST['report']=='11'){ ?>
<?php
$searchField=clean($_GET['queryId']);
$invoiceid=clean($_GET['invoiceid']);
$search=clean($_GET['search']);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?> 
<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
.btnsearchreport{
/* background-color: #45b558; */
/*text-align:center;*/
padding: 3px 18px;
margin-left: 5px;
outline: 0px;
color: #ffffff;
font-size: 14px;
/* border: 1px #45b558 solid; */
/* border-radius: 27px; */
cursor: pointer;
background-image: url(../images/searchiconin.png);
background-repeat: no-repeat;
background-position: 7px center;
padding-left: 30px;
background-size: 16px;
}
.ttprice{
white-space: nowrap;overflow:hidden;
}
.topsearchfiledmain1{  
padding: 5px;
margin-top:5px;
border: 1px #a9a9a9 solid;
outline: 0px;
background-size: 17px;
}
.blockList{
display:block!important;
}
.hideList{
display:none;
}
.searvice_list_box{
overflow: scroll;
height: 200px;
position: absolute;
text-align: left;
border: 1px solid #a9a9a9;
/* border-radius: 1px; */
width: 88px;
background-color: white;
z-index:1;
display:none;
}
#service {
/*padding-top: 9px;*/
}
#service span{
font-weight:normal;
/*border:1px solid #a9a9a9;
padding: 5px 24px;*/
}
.searvice_list_box ul li{
font-weight:normal;
}
</style>    
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
<form method="get" style="margin-top: 20px;">
<div class="rightsectionheader"><table border="0" cellpadding="10" cellspacing="0">
  <tr> 
    <td colspan="3" align="left"><div style="text-align:left; font-size:25px;">Movement Chart Report</div></td>
    </tr>
 
</table>

</div>
</form>
 
<div id="pagelisterouter" style="padding-left:0px;padding-top: 14px;">
 
 
<div id="margin" class="filterable" style="padding:0px 5px;">
<form method="get">
<input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
<input name="report" id="report" type="hidden" value="11" /><br /><br />

 

<table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" class="table tablesorter gridtable" id="movetment"  >
  <thead>
    <tr style="font-family:normal;text-transform:uppercase;text-align:center;">
      <th width="48" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>S.No.</strong></th>
<th width="126" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important"><strong>Query</strong></th>
<th width="131" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Guest&nbsp;Name</strong></th>
 <th width="31" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Pax</strong></th>
<th width="112" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Stay&nbsp;Details</strong></th>
<th width="104" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Stay&nbsp;Area</strong></th>
<th width="120" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Arrival/Dep.</strong></th>
<th width="317" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Activity</strong></th>
<th width="104" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Pickup&nbsp;Time</strong></th>
<th width="128" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Pickup&nbsp;Info</strong></th>
<th width="127" align="center" bgcolor="#78BEE4" class="header" style="background-color:#233a49 !important;"><strong>Driver</strong></th>
       </tr>
 <tfoot style="position: absolute;
    width: 100%;
    top:32px;" > 
<tr>
  <th width="48" align="left" valign="top" bgcolor="#E0E0E0">S.No.</th>
<th width="126" align="left" valign="top" bgcolor="#E0E0E0">Query</th> 
<th width="131" align="left" valign="top" bgcolor="#E0E0E0">Guest&nbsp;Name</th>
<th width="31" align="left" valign="top" bgcolor="#E0E0E0">Pax</th>
<th width="112" align="left" valign="top" bgcolor="#E0E0E0">Stay&nbsp;Details</th>
<th width="104" align="left" valign="top" bgcolor="#E0E0E0">Stay&nbsp;Area</th>
<th width="120" align="left" valign="top" bgcolor="#E0E0E0">Arrival/Dep.</th>
<th width="317" align="left" valign="top" bgcolor="#E0E0E0">Activity</th>
<th width="104" align="left" valign="top" bgcolor="#E0E0E0">Pickup&nbsp;Time</th>
<th width="128" align="left" valign="top" bgcolor="#E0E0E0">Pickup&nbsp;Info</th>
<th width="127" align="left" valign="top" bgcolor="#E0E0E0">Driver</th> 
</tr>
</tfoot >
 
 <tbody style="text-align:center; color: #917474; font-size: 13px;"  >
 
  <?php
 
$no=1;  
$select='*';  
$where='';  
$rs='';  
$wheresearch='';  
$limit=clean($_GET['records']);    
$page=$_GET['page'];

if($_REQUEST['datefilter']==1){
$datewhere=' and fromDate="'.$_REQUEST['fromDate'].'"  ';
}

if($_REQUEST['datefilter']==2){
$datewhere=' and fromDate="'.$_REQUEST['fromDate'].'"  ';
}

if($_REQUEST['datefilter']==3){
$datewhere=' and    fromDate BETWEEN "'.$_REQUEST['fromDate'].'" AND "'.$_REQUEST['toDate'].'" ';
}

$where=' 1 '.$datewhere.' and quotationYes=2 order by id desc ';
 
$aall=GetPageRecord('*',_QUERY_MASTER_,$where);
while($resultlists=mysqli_fetch_array($aall)){  
 

$a=GetPageRecord('*','guestListb2b','queryId="'.trim($resultlists['id']).'" and primaryGuest=1');
$guestdata=mysqli_fetch_array($a);


$b=GetPageRecord('*','quotationMaster','queryId="'.trim($resultlists['id']).'" and status=1');
$quotationdetails=mysqli_fetch_array($b);

 
$c=GetPageRecord('*','quotationHotelMaster','queryId="'.trim($quotationdetails['id']).'" ');
$hoteldata=mysqli_fetch_array($c);


$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.trim($hoteldata['supplierId']).'" ');
$hoteldisplaydata=mysqli_fetch_array($d);


$hotelname='';
$hotelname=stripslashes($hoteldisplaydata['hotelName']);

$hoteladdress='';
$hoteladdress=$hoteldisplaydata['hotelAddress'].' '.$hoteldisplaydata['hotelCity'].' '.$hoteldisplaydata['hotelCountry'];

?>
<tr style="text-align:center;">
    <td width="48" align="left" valign="top" bgcolor="#FAFDFE"><strong><?php echo $no++; ?></strong></td>
    <td width="126" align="left" valign="top" bgcolor="#FAFDFE"><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resultlists['id']);?>" target="_blank"><strong><?php echo makeQueryId($resultlists['id']); ?></strong></a></td>


 
<?php
$select22='*';  
$where22='queryId='.$resultlists['id'].'';
$rs22=GetPageRecord($select22,'addguestPerson',$where22);
$contantnamemain2=mysqli_fetch_array($rs22);
$clientnem2 = $contantnamemain2['firstname'].' '.$contantnamemain2['lastname'].'<br/>';
?>
<td width="131" align="left" valign="top" bgcolor="#FAFDFE"><div style="border:1px solid #ccc; background-color:#cccccc0f; padding:3px; border-radius:3px;"><?php echo $resultlists['guest1']; ?><div style="margin-top:6px;">
<?php echo $resultlists['guest1phone']; ?></div></div></td>
<td width="31" align="left" valign="top" bgcolor="#FAFDFE"> <strong><?php echo round($resultlists['adult']+$resultlists['child']+$resultlists['infant']); ?></strong>
    
<div style="margin-top:5px; color:#c1b0b0;">
<?php 
if($resultlists['adult']>0){
echo $resultlists['adult'].'A ';
}
if ($resultlists['child']>0) {
echo $resultlists['child'].'C ';
}
if ($resultlists['infant']>0) {
echo $resultlists['infant'].'I';
}
if ($resultlists['child']>0) {
echo '<br />';
if ($resultlists['age1']>0) {
echo '('.$resultlists['age1'].'Y) ';
}
if ($resultlists['age2']>0) {
echo '('.$resultlists['age2'].'Y) ';
}
if ($resultlists['age3']>0) {
echo '('.$resultlists['age3'].'Y) ';
}
}
?></div></td>
<td width="112" align="left" valign="top" bgcolor="#FAFDFE"><strong><?php echo $hotelname; ?></strong><br />
 <?php echo $hoteladdress; ?></td>
<td width="104" align="left" valign="top" bgcolor="#FAFDFE"><?php echo $hoteldisplaydata['area'];?></td>
<td width="120" align="left" valign="top" bgcolor="#FAFDFE"><?php $fcc=GetPageRecord('*','flightMaster','queryId="'.trim($resultlists['id']).'" ');  
while($flightDetails=mysqli_fetch_array($fcc)){ echo $flightDetails['flightDetails']; } ?></td>
  <td width="317" align="left" valign="top" bgcolor="#FAFDFE"><?php
  $s=1;
$f=GetPageRecord('*','quotationSightseeingMaster','queryId="'.trim($quotationdetails['id']).'" ');  
while($sightseeingdata=mysqli_fetch_array($f)){

$g=GetPageRecord('*',_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,'id="'.trim($sightseeingdata['sightseeingNameId']).'" ');
$sightseeingdisplaydata=mysqli_fetch_array($g);
?>

<strong><?php echo $s.': '?></strong> <?php echo trim($sightseeingdisplaydata['sightseeingName']); ?><br />
<br />

<?php

$s++; } ?>     </td>
  <td width="104" align="left" valign="top" bgcolor="#FAFDFE">&nbsp; </td>
  <td width="128" align="left" valign="top" bgcolor="#FAFDFE">&nbsp; </td>
  <td width="127" align="left" valign="top" bgcolor="#FAFDFE">&nbsp; </td>
</tr>


<?php  } ?>
   </tbody>
</table>

<style>
table a {
    color: #2ca1cc !important;
}
#movetment input { 
width:100%; 
    padding: 3px !important;
}
table.dataTable tfoot th, table.dataTable tfoot td { 
    border-top:0px solid #111 !important;
	padding: 6px 10px 6px 10px !important;
}

 
#movetment_filter{display:none !important;}
#movetment_length{display:none !important;}


</style>
</form> 
<script>
$(':input').removeAttr('placeholder');
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#movetment tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#movetment').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
</script>

<div class="pagingdiv">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody>

<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0">
 <tr>
<td style="padding-right:20px;"><?php echo $totalentries= $totalentry+$totalentry1; ?> entries</td>
<td>
<select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >
<!--<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>-->
<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
</select> </td>
 </tr>
</table> </td>
<td align="right">
<div class="pagingnumbers"><?php echo $paging; ?></div> </td>
</tr>
</tbody>
</table>
</div>
</div>
<div style="text-align:center; margin-top:30px; display:none;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
 
</div> </td>
  </tr>
</table>
 
 
 
 
 <?php }?>
 <?php if($_REQUEST['report']=='12'){ 

$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']);
echo $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate'];
$strWhere='';

?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain">  <?php if($_REQUEST['assignto']!=''){ echo getUserName(decode($_REQUEST['assignto'])); }else{ echo getUserName(37); } ?>&nbsp;<?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php if($fromDate!=''){ echo date('d-m-Y',strtotime($fromDate));} ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php if($toDate!=''){ echo date('d-m-Y',strtotime($toDate));} ?>"/> </td>
		   <td>
		   <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:200px; " >
            <option value="">Select User</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='deletestatus=0 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
if($resListing['id']==37 || $resListing['id']==116 || $resListing['id']==107 || $resListing['id']==76){
?>
			<option value="<?php echo encode($resListing['id']); ?>" <?php if(decode($_GET['assignto'])==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } } ?>
          </select>		   </td>
     <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
<input name="report" id="report" type="hidden" value="12" />		 </td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px;padding-top: 29px; ">


 
  
<div id="sale">
  <table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">
    <thead>
      <tr>
        <th width="182"  align="center" valign="middle" class="header" style="background-color: #233a49 !important;"><label for="checkAll"><span></span>Query ID</label></th>
        <th width="138" align="center" class="header" style="background-color: #233a49 !important;">Invoice Date</th>
        <th width="129" align="left" class="header" style="background-color: #233a49 !important;">Corporate </th>
        <!-- <th align="center" class="header">Sales Person</th>-->
        <th width="158" align="center" class="header" style="background-color: #233a49 !important;">Pax</th>
        <th width="239" align="center" class="header" style="background-color: #233a49 !important;">Invoice Cost</th>
        <th width="278" align="center" class="header" style="background-color: #233a49 !important;">Operation Person</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $n=1; 
	  $limit=500;	
      $select='*'; 
      $where=''; 
      $rs=''; 
	  $totalcountPax='';
	  $totalcountAmount='';
	  $totalPax='';
	  $totalInvoiceAmount='';
	  $queryCount=0;
	  
	   $page=$_GET['page'];  
	   
	  if($_REQUEST['assignto']!=''){ $assignto=decode($_REQUEST['assignto']); }
	   
	  if($fromDate!='' && $toDate!=''){
		$fromDate = date('Y-m-d',strtotime($fromDate));
		$toDate = date('Y-m-d',strtotime($toDate));  
		$resu = "select * from invoiceMaster where queryId in (select id from queryMaster where  deletestatus=0 and companyId in (select id from corporateMaster where assignTo='".$assignto."' and deletestatus=0 )  ) and subTotal!=0 and invoicedate BETWEEN '".$fromDate."' and '".$toDate."' ";
	  }else{
        $resu = "select * from invoiceMaster where queryId in (select id from queryMaster where deletestatus=0 and companyId in (select id from corporateMaster where assignTo='".$assignto."' and deletestatus=0 ) or assignTo='".$assignto."' ) and subTotal!=0 and MONTH(invoicedate) = MONTH(CURRENT_DATE()) AND YEAR(invoicedate) = YEAR(CURRENT_DATE()) "; 
	  } 
 	  $rsdsu=mysqli_query(db(),$resu);  
      while($resultlists=mysqli_fetch_array($rsdsu)){  
	  
		$select1='*';
		$rs1=''; 
		$where1='id='.$resultlists['queryId'].' '; 
		$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);
		$resultlist=mysqli_fetch_array($rs1);
		$queryId=$resultlist['id'];    
		 
    ?>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo showdate($resultlists['invoicedate']);?></td>
        <td align="left"><?php echo showClientTypeUserName($resultlist['clientType'],$resultlist['companyId']);?></td>
        <!--<td align="center"> <?php  $companyid = $resultlist['companyId'];
          $selectcomp='*'; 
          $wherecomp='';
          $wherecomp='where   id="'.$companyid.'" ';
          $comp=GetRecordList($selectcomp,_CORPORATE_MASTER_,$wherecomp); 
          $totalentrycomp=$comp[1]; 
          $pagingcomp=$comp[2]; 
          $resultlistcomp=mysqli_fetch_array($comp[0]);
          $saleid = $resultlistcomp['companyCategory'];
          $editassignTo=clean($resultlistcomp['assignTo']);          
          echo getUserName($editassignTo);
           ?></td>-->
        <td align="center"><?php echo $totalcountPax=$resultlist['adult']+$resultlist['child']+$resultlist['infant'];?></td>
        <td align="center"><?php echo $totalcountAmount=$resultlists['subTotal'];?></td>
        <td align="center"><?php $sid = $resultlists['addedBy'];
		    $selectsup='*'; 
            $wheresup='';
            $wheresup='where   id="'.$sid.'" ';
            $sup=GetRecordList($selectsup,_USER_MASTER_,$wheresup); 
            $totalentrysup=$sup[1]; 
            $pagingsup=$sup[2]; 
            $resultlistsup=mysqli_fetch_array($sup[0]);
            echo getUserName($sid);?></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?php $totalPax=$totalcountPax+$totalPax;
	     $totalInvoiceAmount=$totalcountAmount+$totalInvoiceAmount; 
		  $n++; $queryCount++; }  ?>
      <tr>
        <td align="center" ><strong>Total Invoice -
          <?php  echo $queryCount; ?>
        </strong> </td>
        <td align="left"  >&nbsp;</td>
        <td align="left"  ><?php echo makeQueryId($resultlists['queryId']);?> </td>
        <td align="center"  ><strong>
          <?php  echo $totalPax; ?>
        </strong></td>
        <td align="center" ><strong >
          <?php  echo $totalInvoiceAmount; ?>
        </strong></td>
        <td align="center"  >&nbsp;</td>
        <td width="10" align="center" >&nbsp;</td>
      </tr>
    </tbody>
  </table>
</div>
<div style="text-align:center; margin-top:30px;">
<a href="<?php echo str_replace('showpage.crm','download_salereport.php',$actual_link); ?>"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Sale Report"  style="margin-left:0px;"   ></a></div>
<script>
function copydatatodata(){
var margin = $('#sale').html();
$('#salereport').val(margin);  
$('#downloadsale').submit();  
}
</script>
</div> 	</td>
  </tr>
</table>

<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);




comtabopenclose('linkbox','op2');
</script> <?php } ?>










<?php if($_REQUEST['report']=='13'){ ?>
<?php
$searchField=clean($_GET['searchField']);
$paymentid=clean($_GET['paymentid']);
$paymentstatus=clean($_GET['paymentstatus']);
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%"><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> &nbsp;&nbsp;Login&nbsp;Report&nbsp;&nbsp;</span>
	    <div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
	
    <td width="75%"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
	  
        <td width="50%"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
        <input name="report" id="report" type="hidden" value="5" />
        </td>
        </tr>
    </table></td>
  </tr>
  
</table>
</div>


<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
      
     <th width="192" height="37" align="left" class="header">Employee Name</th>
     <th width="213" align="left" class="header">Department </th>
     <th width="208" align="left" class="header">Date </th>
     <th width="211" align="left" class="header">First Login </th>
     <th width="194" align="left" class="header">Last login</th>
     <th width="194" align="left" class="header">IP Address </th>
	 <th width="194" align="left" class="header">Details</th>
     </tr>
   </thead>
   
   <?php 			 
$select31=''; 
$where31=''; 
$rs13='';  
$select31='*';    
$where31='deletestatus=0 and status=1 order by firstName asc';  
$rs13= GetPageRecord($select31,_USER_MASTER_,$where31); 
while($user=mysqli_fetch_array($rs13)){

 ?>

 
  <tbody>
  <tr>    <?php if($result['transferType']==1){ echo 'SIC';} if($result['transferType']==2) {echo 'private';}?>
    <td align="left"><?php echo $user['firstName'];?></td>
    <td align="left"><?php 
$select100='name';  
$where100='id="'.$user['roleId'].'"'; 
$rs188=GetPageRecord($select100,_ROLE_MASTER_,$where100); 
$res212=mysqli_fetch_array($rs188);
echo $res212['name'];
?>
</td>


    <td align="left"><?php echo date("Y-m-d",$user['modifyDate']); ?></td>
    <td align="left"><?php echo $user['lLogin'];?></td>
    <td align="left"><?php echo $user['cLogin']; ?></td>
    <td align="left"><?php echo $user['currentIp']; ?></td>
    <td align="left">&nbsp;</td>
  
	<?php  } ?>
</tbody></table>


</div></form>	
  
</table>

<style>
#pagelisterouter {
    padding-top: 60px !important;
    margin-top: 5px !important;}
</style>

<?php }?>




<?php if($_REQUEST['report']=='14'){ 

$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']); 
$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate']; 

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>



<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   
    <td>
    	<div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><a href="showpage.crm?module=reports"><img src="images/backicon.png" width="20" style=" cursor:pointer;" /></a>&nbsp;Client Feedback report</span>
		<div id="deactivatebtn" style="display:none;">
		 	
		 	<?php if($deletepermission==1){ ?> 
			<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
			<?php } ?>
		
		</div>
			
		</div>
	</td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php if($fromDate!=''){ echo date('d-m-Y',strtotime($fromDate));} ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php if($toDate!=''){ echo date('d-m-Y',strtotime($toDate));} ?>"/> </td>
    
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" />
		<input name="report" id="report" type="hidden" value="14" />	
		</td>
  </tr>
</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />
		 </td>
         
      </tr>
      
    </table></td>
  </tr>
  
</table>
<script>
loadsearchClients();
</script>
</div>
</form>
 
<div id="pagelisterouter" style="padding-left:6px;">

<style>
#example_wrapper .row{padding:20px !important;}
#margin {border:1px #eee solid !important;}
#margin table td{border-bottom:1px #eee solid !important; padding:8px !important;}
#margin table th{
    padding-bottom: 12px !important;
    background-color: #233a49 !important;
    color: #fff !important;
    font-size: small;
    font-family: sans-serif;
}
#example_wrapper .col-sm-6 .form-control{margin-left:5px;}	
#example_wrapper .dataTables_length{display:none;}
.dataTables_info{ display:none;}	
.paging_simple_numbers ul{ padding:0px; margin:0px; }
.pagination ul li{    float: left;
   list-style:none !important;}
.dataTables_filter{    margin-top: -24px;
   margin-left: 1206px;}
.dataTables_filter input{
padding:4px;
}
.dataTables_length{    margin-left: 250px;
   margin-top: -25px;
}
.dataTables_length select { padding:4px;}
.dataTables_paginate ul li{    float: left;
   padding: 5px;
   list-style: none;
   border: 1px solid #2bb0dd;}
.dataTables_paginate ul li active{ background-color:#000;}
.paginate_button page-item active{ background-color:#2bb0dd;}
.dataTables_paginate{    margin-right: 0px;
   margin-top: -25px;
   margin-left: 1251px;}
.pagination> li.active {
   z-index: 2;
   color: #fff;
   cursor: default;
   background-color: #337ab7;
   border-color: #337ab7;
}
.pagination> li.active>a {
  color: #fff !important;
}
.table a{ color:#fff;} 
</style>
<div id="margin" style="width:3545px!important;margin-top: -106px;">
<table width="100%" border="0" cellpadding="8" cellspacing="0" class="table table-striped table-bordered" id="example" style="width:38%; margin-top: 3px !important; "> 
   <thead> 
   <tr>
     <th width="13%"  align="left" valign="middle" class="header"><label for="checkAll">
     <div align="left">#Query Id</div>
     </label></th>
     <th width="13%" align="left" class="header"><div align="left">Travel&nbsp;Date</div></th>
     <th width="13%" align="left" class="header"><div align="left">Client&nbsp;Rating</div></th>
     <th width="13%" align="left" class="header"><div align="left">Client&nbsp;Experience</div></th>
     <th width="13%" align="left" class="header"> <div align="left">Image</div></th>
     <th width="13%" align="left" class="header"> <div align="left">Full&nbsp;Name</div></th>
     <th width="13%" align="left" class="header"> <div align="left">Contact&nbsp;Number</div></th> 
     <th width="13%" align="left" class="header"> <div align="left">Email</div></th>
     <th width="13%" align="left" class="header"> <div align="left">Operation&nbsp;Person</div></th>
     <th width="13%" align="left" class="header"> <div align="left">Destination</div></th>
     </label></th> 
     </tr>
   </thead>
  <tbody>
    <?php 
      $n=0; 	  
	  $strWhere=''; 
	  $multiSearch='';
	  $multiSearch=clean($_GET['multiSearch']);  

 

      if($fromDate!='' && $toDate!=''){
      $fromDate = date('Y-m-d', strtotime( $fromDate ));
      $toDate = date('Y-m-d', strtotime( $toDate )); 
      $strWhere='and fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'"';
      }
  
	  $select='*'; 
      $where='';
      //$where=' '.$strWhere.' deletestatus=0 order by id desc ';
      $where='1 '.$strWhere.' order by id desc ';
      $rs=GetPageRecord($select,clientfeedbackmaster,$where);  
      while($resultlist=mysqli_fetch_array($rs)){ 
	  
    ?>
   
        <tr>
          <td width="100" align="left"> <div align="left"><?php echo makeQueryId($resultlist['queryId']);?></div></td>
          <td width="100" align="left"> <div align="left"><?php 
          $an2ss=GetPageRecord('fromDate',_QUERY_MASTER_,'id='.$resultlist['queryId'].' order by id desc');
         $getfrmdt=mysqli_fetch_array($an2ss);
         if($getfrmdt['fromDate']==''){} else {  echo date("d-m-Y", strtotime($getfrmdt['fromDate'])); }
          ?></div></td>
          <td width="100" align="left"> <div align="left" style='font-size:16px;'><?php if($resultlist['clientrating']==1){echo "Sad&#128546;";}elseif($resultlist['clientrating']==2){ echo "Neutral&#128528;";}elseif($resultlist['clientrating']==3){ echo "Happy&#128522";}?></div></td>
          <td width="100" align="left"> <div align="left"><?php echo $resultlist['clientexperience'];?></div></td>
          <td width="100" align="left"> <div align="left"><?php echo $resultlist['feedbackImage'];?></div></td>
          
          <?php
            $clientType=$resultlist['clientType'];
            if($clientType==2){
            $select22='*';  
            $where22='id='.$resultlist['companyId'].''; 
            $rs22=GetPageRecord($select22,_CONTACT_MASTER_,$where22); 
            $contantnamemain2=mysqli_fetch_array($rs22);
            
            $clientnem2 = $contantnamemain2['firstName'].' '.$contantnamemain2['lastName'].'<br/>';
            $getphone2 =  getPrimaryPhone($contantnamemain2['id'],'contacts').'<br/>';
            $getemail2 =  getPrimaryEmail($contantnamemain2['id'],'contacts').'<br/>';
           }else{

            $select22='*';  
            $where22='id='.$resultlists['companyId'].''; 
            $rs22=GetPageRecord($select22,_CORPORATE_MASTER_,$where22); 
            $contantnamemain2=mysqli_fetch_array($rs22);
            
            $clientnem2 = $contantnamemain2['name'].'<br/>';
            $getphone2 =  getPrimaryPhone($contantnamemain2['id'],'corporate').'<br/>';
            $getemail2 =  getPrimaryEmail($contantnamemain2['id'],'corporate').'<br/>';
            }
          ?>
          
          
          <td width="100" align="left"> <div align="left"><?php if($clientType==2){ echo $clientnem2; }else { echo $clientnem2 ;}?></div></td>
          <td width="100" align="left"> <div align="left"><?php if($clientType==2){ echo $getphone2; }else { echo $getphone2 ;}?></div></td>
          <td width="100" align="left"> <div align="left"><?php if($clientType==2){ echo $getemail2; }else { echo $getemail2 ;}?></div></td>
            <?php 
            $select1='*';    
            $where1='companyId="'.$resultlists['companyId'].'"';  
            $rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
            $usermasterData=mysqli_fetch_array($rs1);
            $operationperson=$usermasterData['firstName'].''.$usermasterData['lastName'];
            ?>
          <td width="100" align="left"> <div align="left"><?php echo $operationperson; ?></div></td>
          <td width="100" align="left"> <div align="left"><?php 
            $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$resultlist['quotationId'].'" order by id asc'); 
            $QueryDaysData=mysqli_fetch_array($QueryDaysQuery); 
            $destn = getDestination($QueryDaysData['cityId']);
            echo $destn;
          ?></div></td>
          
        </tr>

    <?php $n++; } ?>
  </tbody>
 </table>
</div>
</div>
<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadmargin" id="downloadmargin" action="download_marginreport.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Margin Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="marginreport" id="marginreport" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var margin = $('#margin').html();
$('#marginreport').val(margin);  
$('#downloadmargin').submit();  
}
</script>

</div> 	</td>
  </tr>
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
</script>
 <?php }?>

 
 
 

  
<?php if($_REQUEST['report']==''){?>
<style>
body{ background-repeat:no-repeat; background-position:center bottom; background-size:100%;}
</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">

</form>
 
<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 47px;">
<div class="card">
                            <div class="tab-content">
                                
<?php /*?><div class="container">
    
    <div class="row" style="text-align:center">
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=1" id="button">
                <span>User Wise Query <br />Report</span>
            </a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&clientType=1&module=reports&report=2" id="button">
                <span>Agent Wise Query <br />Report</span>
            </a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&clientType=2&module=reports&report=3" id="button">
                <span>Client Wise Query <br />Report</span>
            </a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12" style="display:none;">
            <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&module=reports&report=4" id="button" target="_blank">
                <span>Travel <br />Report</span>
            </a>
        </div>
    
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d');?>&paymentstatus=0&module=reports&report=5" id="button">
                <span>Client Payment Pending Report</span>
            </a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('Y-m-d', strtotime(' -90 day'));?>&toDate=<?php echo date('Y-m-d', strtotime(' -1 day'));?>&paymentstatus=0&module=reports&report=6" id="button">
                <span>Supplier Payment Pending Report</span>
            </a>
        </div>
		<div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=7" id="button">
                <span>Sales <br /> Report</span>
            </a>
        </div>
		
		<div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=8" id="button">
                <span>Travelbooking <br />Report</span>
            </a>
        </div>
		
		<div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=9" id="button">
                <span>Tax <br />Report</span>
            </a>
        </div>
		
		<div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=10" id="button">
                <span>Finance <br />Report</span>
            </a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=reports&report=11" id="button">
                <span>Movement Chart <br />Report</span>
            </a>
        </div>

		<div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('01-m-Y');?>&toDate=<?php echo date('t-m-Y');?>&status=0&module=reports&report=12" id="button">
                <span>Monthly&nbsp;Invoice<br />
Report</span>
            </a>
        </div>
		
		<div class="col-md-3 col-sm-4 col-xs-12">
            <a href="showpage.crm?fromDate=<?php echo date('01-m-Y');?>&toDate=<?php echo date('t-m-Y');?>&status=0&module=reports&report=13" id="button">
                <span>Login&nbsp;Report<br />
Report</span>
            </a>
        </div>
            </a>
        </div>
		
		<!--<div class="col-md-3 col-sm-4 col-xs-12">-->
  <!--          <a href="showpage.crm?module=reports&report=10" id="button">-->
  <!--              <span>Agent Sales <br />Report</span>-->
  <!--          </a>-->
  <!--      </div>	-->
		<!--<div class="col-md-3 col-sm-4 col-xs-12">-->
  <!--          <a href="showpage.crm?module=reports&report=10" id="button">-->
  <!--              <span>Sightseeing <br />Report</span>-->
  <!--          </a>-->
  <!--      </div>		<div class="col-md-3 col-sm-4 col-xs-12">-->
  <!--          <a href="showpage.crm?module=reports&report=10" id="button">-->
  <!--              <span>Hotel <br />Report</span>-->
  <!--          </a>-->
  <!--      </div>		<div class="col-md-3 col-sm-4 col-xs-12">-->
  <!--          <a href="showpage.crm?module=reports&report=10" id="button">-->
  <!--              <span>Transfer <br />Report</span>-->
  <!--          </a>-->
  <!--      </div>		<div class="col-md-3 col-sm-4 col-xs-12">-->
  <!--          <a href="showpage.crm?module=reports&report=10" id="button">-->
  <!--              <span>Airline <br />Report</span>-->
  <!--          </a>-->
  <!--      </div>		<div class="col-md-3 col-sm-4 col-xs-12">-->
  <!--          <a href="showpage.crm?module=reports&report=10" id="button">-->
  <!--              <span>Cruise <br />Report</span>-->
  <!--          </a>-->
  <!--      </div>-->
		
		
		
		
		
		
		
		
		
		
		
		
    </div><?php */?>
    
</div>
        </div>
      </div>
</div> 	</td>
  </tr>
  
  
  
  
  
  
  
  
  
  
</table>
<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
		
      if(!checked) { 
	  $("#deactivatebtn").hide();
	  $("#topheadingmain").show();
      } else {
	  $("#deactivatebtn").show();
	  $("#topheadingmain").hide();
	  } 
}, 100);
comtabopenclose('linkbox','op2');
loadsearchClients();



</script>
<?php }?>



<style>
.col-md-3 {width:20%; display:inline-block; margin:10px;}
.col-md-3 a{
    background-color: #17a6d1;
    display: block;
    padding: 20px;
    margin: 20px 36px;
    font-size: 16px;
    color: #fff !important;
    border-radius: 10px;
    border: 2px solid #40434626;
}
</style>
