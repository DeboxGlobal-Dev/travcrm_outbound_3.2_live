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
   <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=query" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
   </td> 
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Payment-Request','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
<!--    <td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Query Id" onkeyup="numericFilter(this);"/></td>
  --->   <td style="padding:0px 0px 0px 5px;" > 
           <input name="paymentid" type="text"  class="topsearchfiledmain" id="paymentid" style="width:96px;" value="<?php echo $paymentid; ?>" size="6" maxlength="12" placeholder="Payment Id" onkeyup="numericFilter(this);"/>
 </td>
 
 <td style="padding:0px 0px 0px 5px;" > 
           <select name="paymentstatus" id="paymentstatus" class="topsearchfiledmainselect" style="width:145px; " >
            <option value="">Payment Status</option> 
			<option value="1" <?php if($_GET['paymentstatus']=='1'){ ?>selected="selected"<?php  } ?>>Paid</option>
			<option value="0" <?php if($_GET['paymentstatus']=='0'){ ?>selected="selected"<?php  } ?>>Pending</option>  
			 
          </select>
 </td>
   
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
        <td style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>

		</td>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="alertspopupopen('action=paymentrequestqueryid','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="paymentdelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      
     <th width="247" align="left" class="header">payment&nbsp;ID</th>
     <th width="271" align="left" class="header">query&nbsp;ID </th>
     <th width="271" align="left" class="header">Supplier&nbsp;Pending&nbsp;Amount</th>
     <th width="271" align="left" class="header">Client&nbsp;Pending&nbsp;Amount</th>
     <th width="486" align="left" class="header">payment&nbsp;request&nbsp;Date </th>
     <th width="228" align="left" class="header">Payment&nbsp;Due&nbsp;Date</th>
     <!--     <th width="228" align="left" class="header">Payment&nbsp;Reminder&nbsp;Date</th>
-->     <th width="228" align="left" class="header">Payment&nbsp;Status </th>
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
$mainwhere=' and  queryId='.$searchField.'';
}
   
$paymentid=clean(trim(ltrim($_GET['paymentid'], '0')));
 
if($paymentid!=''){
$paymentid=' and  id='.$paymentid.'';
}
     
if($paymentstatus!=''){
$paymentstatus=' and  status='.$paymentstatus.'';
}	 
	 
	 
 
$where='where deletestatus=0 and queryid in (select id from '._QUERY_MASTER_.' where '.$wheresearchassign.' ) '.$mainwhere.' '.$paymentid.' '.$paymentstatus.' order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=paymentrequest&records='.$limit.'&searchField='.$searchField.'&';
$rs=GetRecordList($select,_PAYMENT_REQUEST_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 


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

 
?>

 
  <tr>
    
    <td align="left">
      <div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo makePaymentId($resultlists['id']); ?>	 
	      </div>
    </td>
    <td align="left">
      <div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php  
	    $select12=''; 
		$where12=''; 
		$rs12='';   
		$select12='*';  
		$where12='id='.$resultlists['queryid'].''; 
		$rs12=GetPageRecord($select12,_QUERY_MASTER_,$where12); 
		$editresultdisplay=mysqli_fetch_array($rs12);
		  
		echo makeQueryId($editresultdisplay['id']); ?>	 
	     </div>
    </td>
    <td align="left">
     <strong> <?php if($resultlists['supplierPendingamount']!=0){ ?>
     <div style="color:#CC3300;"><?php echo $resultlists['supplierPendingamount']; ?></div><?php } else {  ?></strong>
     <div style="color:#009900;">
       <strong>Paid</strong></div>
     <strong></strong><strong>
     <?php } ?>    
     </strong>    </td>
    <td align="left">
      <?php   
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
		<div style="color:#CC3300;"><strong><?php echo $pendingamount; ?></strong></div>
		<?php } ?>
      </td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td><!--
    <td align="left" ><?php echo date("d-m-Y", strtotime($paymentdate)); ?></td>-->
    <td align="left" ><?php if($resultlists['dueDate']==''){} else {  echo date("d-m-Y", strtotime($resultlists['dueDate'])); }
	
$select55='*';  
$where55='paymentRequestId='.$resultlists['id'].' order by id desc'; 
$rs55=GetPageRecord($select55,_PAYMENT_LIST_MASTER_,$where55); 
$gettotalcostofpayment=mysqli_fetch_array($rs55);  
 

	 ?></td>
    <td align="left" >
 <?php if($resultlists['supplierPendingamount']!=0){ ?>
 <div style="background-color:#CC3300; color:#fff; padding:5px 10px; width:100px; text-align:center; border-radius: 4px;">Pending</div>
 <?php } else { ?>
 <div style="background-color:#17a05b; color:#fff; padding:5px 10px; width:100px; text-align:center; border-radius: 4px;">Paid</div>
 <?php } ?>
 
	 
	
	</td>
    </tr> 
	
	<?php   $no++; } ?>
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