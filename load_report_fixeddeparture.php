 
<?php
include "inc.php";
$searchField=clean($_GET['searchField']);
$subFDId=clean($_GET['subFDId']); 

if($loginuserprofileId==1){ 
	$wheresearchassign=' 1   '; 
} else {  
	$wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';

	$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
}
 
?> 
<link href="css/main.css" rel="stylesheet" type="text/css" />
  
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="91%" align="left" valign="top">
<form id="listform" name="listform" method="get">
<div class="">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
 
  <tr> 
	<h3 class="cms_title">Fixed&nbsp;Departure&nbsp;Report</h3>
    <td width="25%">
	<div class="headingm" style="margin-left:30px;">
		<span id="topheadingmain"></span>
		<div id="deactivatebtn" style="display:none;">
		<?php if($deletepermission==1){ ?> 
		<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
		<?php } ?>
		</div>
	</div>
	</td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td > 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
   		<tr>
         <td>
		 <select name="subFDId" id="subFDId" class="topsearchfiledmainselect" style="width:200px;padding: 9px;margin-right: 5px;" >
           <option value="">All Fix Departure</option>
              <?php    
              $rscsup='';    
              $rscsup=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and isFD=1 and id in ( select quotationId  from quotationMaster where status=1 and queryType=3  ) ');              
			  while($fdConfData=mysqli_fetch_array($rscsup)){  
              ?>
              <option value="<?php echo $fdConfData['id']; ?>"  ><?php echo $fdConfData['subName']; ?></option>
              <?php }?> 
          </select>
        </td>
   		<td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:200px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Fixed Departure" onkeyup="numericFilter(this);"/></td>
        <td ><input name="module" id="module" type="hidden" value="reports" />
        <input name="report" id="report" type="hidden" value="45" />
        <input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        <td style="padding-right:20px;">&nbsp;</td>
		  </tr>
		</table>
        </td> 
      </tr>
     </table>
	</td> 
  </tr>
 
</table> 
</div> 
<div id="pagelisterouter"  style="margin-top: 14px!important;"> 
	<?php 
	$searchField=$subFDId='';
	$searchField=clean(trim(ltrim($_GET['searchField'], '0')));
	$subFDId=clean(trim($_GET['subFDId']));
	$mainwhere2 = $mainwhere = '';
	if($searchField!=''){
		$mainwhere2 = ' and subName like "%'.$searchField.'%"';
	}
	
	if($subFDId!=''){
		$mainwhere = ' and id = "'.$subFDId.'"';
	}  
	$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' 1 '.$mainwhere.' and deletestatus=0 and queryId in ( select id from '._QUERY_MASTER_.' where deletestatus=0 and queryType=3 ) limit 1');  
	if(mysqli_num_rows($rs2) > 0){
	$fdData=mysqli_fetch_array($rs2); 
	
		$rs1='';
		$rs1=GetPageRecord('*',_QUERY_MASTER_,' 1 and id="'.$fdData["queryId"].'"');  
		$queryfdData=mysqli_fetch_array($rs1); 
		 
		$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and status=1 and queryType=3 ');   
		$fdConfirmedData=mysqli_fetch_array($rs2);
		
		$confPax = $fdConfirmedData['adult']+$fdConfirmedData['child'];
		
	/*	$slabSql="";
		$slabSql=GetPageRecord('count(localEscort) as t_localEscort, count(foreignEscort) as t_foreignEscort,tps.* ','totalPaxSlab as tps',' 1 and quotationId in ( select id from quotationMaster where status=1 and queryType=3 and quotationId="'.$fdConfirmedData['id'].'" ) and quotationId="'.$fdConfirmedData['id'].'" and status=1'); 
		if(mysqli_num_rows($slabSql) > 0 ){
			$slabsData=mysqli_fetch_array($slabSql); 
			$t_localEscort = $slabsData['t_localEscort']; 
			$t_foreignEscort = $slabsData['t_foreignEscort']; 
		}*/
	?>
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
	   <tbody>
			<tr>
			<td width="247" align="left" class="header">Fixed&nbsp;Departure&nbsp;Code</td>
			<td width="271" align="left" class="header">Fixed&nbsp;departure&nbsp;Name</td>
			<td width="486" align="left" class="header">Tour&nbsp;Code</td>
			<td width="228" align="left" class="header">Tour&nbsp;Start&nbsp;Date</td>
			<td width="271" align="left" class="header">Tour&nbsp;End&nbsp;Date</td>
			<td width="228" align="left" class="header">Total&nbsp;Pax</td>
			<td width="228" align="left" class="header">Booked&nbsp;Pax</td>
			<td width="228" align="left" class="header">Pending&nbsp;Pax</td>
			</tr>
			<tr>
			  <td height="20"><?php echo makeQueryId($queryfdData['id']); ?></td>
			  <td><?php echo trim($fdData['subName']); ?></td>
			  <td>21/07/0016</td>
			  <td><?php echo date('d-m-Y',strtotime($fdData['fromDate']));?></td>
			  <td><?php echo date('d-m-Y',strtotime($fdData['toDate']));?></td>
			  <td><?php echo $pax = trim($fdData['adult']+$fdData['child']); ?></td>
			  <td><?php echo $confPax; $remainPax = ($pax-$confPax)?></td>
			  <td><?php echo $remainPax;?></td>
			</tr>
			
			<tr>
			<th width="247" align="left" class="header">Single&nbsp;Room</th>
			<th width="271" align="left" class="header">Double&nbsp;Room</th>
			<th width="486" align="left" class="header">Twin&nbsp;Room</th>
			<th width="228" align="left" class="header">Tripple&nbsp;Room</th>
			<th width="271" align="left" class="header">FOC&nbsp;Foreign</th>
			<th width="228" align="left" class="header">FOC&nbsp;Local</th>
			<th width="228" align="left" class="header">Vehicle&nbsp;Prefrence</th>
			<th width="228" align="left" class="header">&nbsp;</th>
			</tr>
			<tr>
			  <td height="20" align="left"><?php echo $fdData['sglRoom'];?></td>
			  <td align="left"><?php echo $fdData['dblRoom'];?></td>
			  <td align="left"><?php echo $fdData['twinRoom'];?></td>
			  <td align="left"><?php echo $fdData['tplRoom'];?></td>
			  <td align="left">&nbsp;</td>
			  <td align="left">&nbsp;</td>
			  <td><?php 
					$rss=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,' 1 and id="'.$queryfdData['vehicleId'].'"'); 
					$resListingv=mysqli_fetch_array($rss);  
			 		echo $resListingv['model'];?></td>
			  <td >&nbsp;</td>
			</tr>
	   </tbody> 
	</table>
	<?php //} ?>
	<br /> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
	<thead> 
			<tr>
			<th width="247" align="left" class="header">Query&nbsp;Id</th>
			<th width="271" align="left" class="header">Tour&nbsp;Code</th>
			<th width="486" align="left" class="header">Agent&nbsp;Name</th>
			<th width="228" align="left" class="header">Pax</th>
			<th width="271" align="left" class="header">Travel&nbsp;Date</th>
			<th width="228" align="left" class="header">Operation&nbsp;Person&nbsp;Name</th>
			<th width="228" align="left" class="header">Status</th>
			<th width="228" align="left" class="header">Confirmation&nbsp;Date</th>
			<th width="228" align="left" class="header">Guest&nbsp;List</th>
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
  		$mainwhere=''; 
		if($subFDId!=''){
			$mainwhere .= ' and quotationId = "'.$fdData['id'].'"';
		}else{
			$mainwhere .= ' and quotationId in ( select id  from quotationMaster where isFD=1  ) ';
		}
	/*	$whereFromDate='';
		if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){ 
			$fromDate=date('Y-m-d', strtotime($fromDate));
			$toDate=date('Y-m-d', strtotime($toDate));
			$whereFromDate=' and fromDate BETWEEN "'.date('Y-m-d',strtotime($fromDate)).'" and "'.date('Y-m-d',strtotime($toDate)).'"';
		}     
	*/
		$where='where status!=2 and queryType=3 '.$mainwhere.' order by id desc '; 
		$page=$_GET['page'];
		$targetpage=$fullurl.'showpage.crm?module=reports&report=45&records='.$limit.'&searchField='.$searchField.'&';
		$rs=GetRecordList($select,_QUOTATION_MASTER_,$where,$limit,$page,$targetpage); 
		$totalentry=$rs[1]; 
		$paging=$rs[2]; 
		while($fdQuotationData=mysqli_fetch_array($rs[0])){ 
			$rs3='';
			$rs3=GetPageRecord('*',_QUERY_MASTER_,' 1 and id="'.$fdQuotationData["queryId"].'"');  
			$queryData=mysqli_fetch_array($rs3); 
			?>
			<tr>
			  <td height="20"><?php echo makeQueryId($queryData['id']); ?></td>
			  <td><?php echo makeQueryTourId($queryData['id']); ?></td>
			  <td><?php echo showClientTypeUserName($queryData['clientType'],$queryData['companyId']);?></td>
			  <td><?php echo $pax = trim($fdQuotationData['adult']+$fdQuotationData['child']); ?></td>
			  <td align="center"><?php echo date('d-m-Y',strtotime($fdQuotationData['fromDate']));?></td>
			  <td><?php echo getUserName($queryData['assignTo']); ?></td>
			  <td><?php if($fdQuotationData['status']==1){ echo "Confirmed";}else{ echo "Pending"; }?></td>
			  <td align="center"><?php echo date('d-m-Y',strtotime($queryData['queryConfirmingDate']));?></td>
			<td align="left" ><a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryData['id'])?>&guestlist=1">click here</a></td>
			</tr> 
			<?php 
			$no++;  
		}
		?>
	</tbody>
	</table>
	<div class="pagingdiv">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tbody><tr>
		<td><table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
		<td><select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >
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
	<?php } else{ ?> 
	<div class="norec">No result found...</div>
	<?php } ?>
	
</div>
</form>   
</td>
</tr>
</table> 
 <style>
	 .gridtable .header {
		padding-bottom: 13px;
		background-color: #ecf7ed;
	}
 </style>
 


 
 