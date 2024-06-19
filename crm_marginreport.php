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

$strWhere='';

if($fromDate!='' && $toDate!=''){
$fromDate = date('Y-m-d', strtotime( $fromDate ));
$toDate = date('Y-m-d', strtotime( $toDate ));

$strWhere.=' dateAdded BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';
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

<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
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
   
        <!-- <td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; " >
            <option value="">All Operations Person</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' userType=1 order by firstName asc';  
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
			 
          </select></td> -->
        <td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
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
 
<div id="pagelisterouter" style="padding-left:30px;">


 

<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>


<div class="norec">Please Select From Date and To Date then Press Search </div>
<div id="margin">
<table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">

   <thead>

   <tr>
     <th  align="center" valign="middle" class="header"><label for="checkAll"><span></span>Booking ID</label></th> 
     <th align="center" class="header"> Payment Type</th>
     <th align="center" class="header">Query Date</th>
     <th align="center" class="header">Corporate </th>
     <th align="center" class="header">Guest </th>
     <th align="center" class="header">Sales Person</th>
     <th align="center" class="header"> Hotel</th>
     <th align="center" class="header"> City</th>
     <th align="center" class="header"  >Check-In </th>
     <th align="center" class="header"  >Check-Out</th>
     <th align="center" class="header"  >Rooms</th>
     <th align="center" class="header"  >Company Cost</th>
     <th align="center" class="header"  >Tax Company</th>
     <th align="center" class="header"  >Gross Selling</th>
     <th align="center" class="header"  >Gross Cost </th>
     <th align="center" class="header"  >Tax component</th>
     <th align="center" class="header"  >Client Cost</th>
     <th align="center" class="header"  >Currency</th>
     <th align="center" class="header"  >Booking Status</th>
     <th align="center" class="header"  >Booking Agent</th>
     <th align="center" class="header"  >Commission</th>
     <th align="center" class="header"  >BTC/Direct</th>
     <th align="center" class="header"  >SUP Confirmation</th>
     <th align="center" class="header"  >GST</th>
     <th align="center" class="header"  >Nights</th>
     <th align="center" class="header"  >Remarks</th>
     <th align="center" class="header"  >CCPROVIDEDFOR</th>
     </tr>
   </thead>
  <tbody>
    <?php

      $n=1; 
      $select='*'; 
      $where=''; 
      $rs=''; 
      $where=' order  by id desc'; 
      $rs=GetRecordList($select,_PAYMENT_LIST_MASTER_,$where);
      $totalentry=$rs[1]; 
      $paging=$rs[2];
      while($resultlists=mysqli_fetch_array($rs[0])){ 
        //print_r($resultlists);
      $pid = $resultlists['paymentRequestId'];
    ?>
    <?php 
      $selectpsq='*'; 
      $wherepsq='';
      $wherepsq='where   paymentId="'.$pid.'" order by id desc ';
      $rspsq=GetRecordList($selectpsq,_PAYMENT_SUPPLIER_LIST_MASTER_,$wherepsq); 
      $totalentrypsq=$rspsq[1]; 
      $pagingpsq=$rspsq[2]; 
      $resultlistpsq=mysqli_fetch_array($rspsq[0]);
      //print_r($resultlistpsq);
    ?>
    <?php 
      $selects='*'; 
      $wheres='';
      $wheres='where   id="'.$pid.'" '; 
      $rss=GetRecordList($selects,_PAYMENT_REQUEST_MASTER_,$wheres); 
      $totalentrys=$rss[1]; 
      $pagings=$rss[2]; 
      $resultlistps=mysqli_fetch_array($rss[0]);
      //print_r($resultlistps);
      $queryid = $resultlistps['queryid'];
    ?>
    <?php 
      $selectq='*'; 
      $whereq='';
      // $whereq=$strWhere;
      $whereq='where   id="'.$queryid.'" and queryDate!="" ';
      $rsq=GetRecordList($selectq,_QUERY_MASTER_,$whereq); 
      $totalentryq=$rsq[1]; 
      $pagingq=$rsq[2]; 
      $resultlist=mysqli_fetch_array($rsq[0]);
      if($resultlist['queryDate']!=''){
    ?>
    
        <tr>
          <td align="center"> <?php echo makeQueryId($resultlist['id']);?></td>
          <td align="center"> <?php $paymenttype = strip($resultlists['paymentType']);
          if($paymenttype==1){ echo "Full Payment";} if($paymenttype==2){ echo "Partial Payment";} if($paymenttype==3){ echo "OnCredit";}?></td>
          <td align="center"> <?php echo showdate($resultlist['queryDate']);?></td>
          <td align="center"> <?php echo showClientTypeUserName($resultlist['clientType'],$resultlist['companyId']);?></td>
          <td align="center"> <?php echo strip($resultlist['guest1']);?></td>
          <td align="center"> <?php  $companyid = $resultlist['companyId'];
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
          //echo $companyid?></td>
          <td align="center"> <?php $hotel = strip($resultlistpsq['supplierId']);
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
          echo $hotel;?></td>
          <td align="center"> <?php $selectcity='*'; 
          $wherecity='';
          $wherecity='where   id="'.$cityid.'" ';
          $city=GetRecordList($selectcity,_CITY_MASTER_,$wherecity); 
          $totalentrycity=$city[1]; 
          $pagingcity=$city[2]; 
          $resultlistcity=mysqli_fetch_array($city[0]);
          $cityaddress = $resultlistcity['name'];
          echo $cityaddress;
           ?></td>
          <td align="center"> <?php echo showdate($resultlist['fromDate']);?></td>
          <td align="center"> <?php echo showdate($resultlist['toDate']); ?></td>
          <td align="center"> <?php echo strip($resultlist['rooms']); ?></td>
          <td align="center"> <?php echo strip($resultlistpsq['companytotalcost']);?></td>
          <td align="center"> <?php $taxcompany = strip($resultlistpsq['companycgst'])+strip($resultlistpsq['companysgst'])+strip($resultlistpsq['companyigst']); 
          $companytotalcost = strip($resultlistpsq['companytotalcost']);
          $companytax = $taxcompany*$companytotalcost; echo $totaltaxcompany = $companytax/100;?></td>
          <td align="center"> <?php $companytoalcost = strip($resultlistpsq['companytoalcost']); echo $companytoalcost;?></td>
          <td align="center"> <?php $suppliercost = strip($resultlistpsq['suppliertotalcost']); echo $suppliercost ;?></td>
          <td align="center"> <?php $taxcomponent = strip($resultlistpsq['suppliercgst'])+strip($resultlistpsq['suppliersgst'])+strip($resultlistpsq['supplierigst']); $tax = $taxcomponent*$suppliercost; echo $totaltax = $tax/100;?></td>
          <td align="center"> <?php $suppliertoalcost = strip($resultlistpsq['suppliertoalcost']);
          echo  $suppliertoalcost;?></td>
          
          <td align="center"> <?php echo "INR";?></td>
          <td align="center"> <?php if($resultlist['queryStatus']==6){ echo '<div class="assignquery">Options&nbsp;Sent</div>'; }if($resultlist['queryStatus']==7){ echo '<div class="assignquery">Follow-up</div>'; }if($resultlist['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; } if($resultlist['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlist['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlist['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlist['queryStatus']==5){ echo '<div class="closequery">Time Limit Booking</div>'; }  if($resultlist['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?></td>
          <td align="center"> <?php $sid = strip($resultlistpsq['supplierId']);$selectsup='*'; 
            $wheresup='';
            $wheresup='where   id="'.$sid.'" ';
            $sup=GetRecordList($selectsup,_SUPPLIERS_MASTER_,$wheresup); 
            $totalentrysup=$sup[1]; 
            $pagingsup=$sup[2]; 
            $resultlistsup=mysqli_fetch_array($sup[0]);
            echo $resultlistsup['name'];?></td>
          <td align="center"> <?php $commision = $suppliertoalcost-$companytoalcost; echo $commision;?></td>
          <td align="center"> <?php echo strip($resultlists['paymentBy']); ?></td>
          <td align="center"> <?php $voucher = strip($resultlist['id']);$wheresvoucher='';$selectvoucher='*';
            $wheresvoucher='where   queryId="'.$voucher.'" ';
            $voucher=GetRecordList($selectvoucher,_VOUCHER_LIST_MASTER_,$wheresvoucher); 
            $totalentryvoucher=$voucher[1]; 
            $pagingvoucher=$voucher[2]; 
            $resultlistvoucher=mysqli_fetch_array($voucher[0]);
            echo $resultlistvoucher['supplierserviceid'];?></td>
          
          <td align="center"> <?php echo $totaltax; ?></td>
          <td align="center"> <?php echo strip($resultlist['night']);?></td>
          <td align="center"> <?php echo strip($resultlists['details']);?></td>
          <td align="center"> <?php echo strip($resultlist['details']); ?></td>
        </tr>
    <?php } $n++; }  ?>
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





<?php } else { ?>





<div id="boxreport">
  <table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">

   <thead>

   <tr>
     <th  align="center" valign="middle" class="header"><label for="checkAll"><span></span>Booking ID</label></th> 
     <th align="center" class="header"> Payment Type</th>
     <th align="center" class="header">Query Date</th>
     <th align="center" class="header">Corporate </th>
     <th align="center" class="header">Guest </th>
     <th align="center" class="header">Sales Person</th>
     <th align="center" class="header"> Hotel</th>
    
     <th align="center" class="header"> City</th>
     <th align="center" class="header"  >Check-In </th>
     <th align="center" class="header"  >Check-Out</th>
     <th align="center" class="header"  >Rooms</th>
     <th align="center" class="header"  >Company Cost</th>
     <th align="center" class="header"  >Tax Company</th>
     <th align="center" class="header"  >Gross Selling</th>
     <th align="center" class="header"  >Gross Cost </th>
     <th align="center" class="header"  >Tax component</th>
     <th align="center" class="header"  >Client Cost</th>
     <th align="center" class="header"  >Currency</th>
     <th align="center" class="header"  >Booking Status</th>
     <th align="center" class="header"  >Booking Agent</th>
     <th align="center" class="header"  >Commission</th>
     <th align="center" class="header"  >BTC/Direct</th>
     <th align="center" class="header"  >SUP Confirmation</th>
     
     <th align="center" class="header"  >GST</th>
     <th align="center" class="header"  >Nights</th>
     <th align="center" class="header"  >Remarks</th>
     <th align="center" class="header"  >CCPROVIDEDFOR</th>
     </tr>
   </thead>
  <tbody>
    <?php

      $n=1; 
      $select='*'; 
      $where=''; 
      $rs=''; 
      $where=' order  by id desc'; 
      $rs=GetRecordList($select,_PAYMENT_LIST_MASTER_,$where);
      $totalentry=$rs[1]; 
      $paging=$rs[2];
      while($resultlists=mysqli_fetch_array($rs[0])){ 
        //print_r($resultlists);
      $pid = $resultlists['paymentRequestId'];
    ?>
    <?php 
      $selectpsq='*'; 
      $wherepsq='';
      $wherepsq='where   paymentId="'.$pid.'" order by id desc ';
      $rspsq=GetRecordList($selectpsq,_PAYMENT_SUPPLIER_LIST_MASTER_,$wherepsq); 
      $totalentrypsq=$rspsq[1]; 
      $pagingpsq=$rspsq[2]; 
      $resultlistpsq=mysqli_fetch_array($rspsq[0]);
      //print_r($resultlistpsq);
    ?>
    <?php 
      $selects='*'; 
      $wheres='';
      $wheres='where   id="'.$pid.'" '; 
      $rss=GetRecordList($selects,_PAYMENT_REQUEST_MASTER_,$wheres); 
      $totalentrys=$rss[1]; 
      $pagings=$rss[2]; 
      $resultlistps=mysqli_fetch_array($rss[0]);
      //print_r($resultlistps);
      $queryid = $resultlistps['queryid'];
    ?>
    <?php 
      $selectq='*'; 
      $whereq='';
      $whereq='where id="'.$queryid.'" and queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and queryDate!="0000-00-00" and deletestatus=0 order by id desc ';
      $rsq=GetRecordList($selectq,_QUERY_MASTER_,$whereq); 
      $totalentryq=$rsq[1]; 
      $pagingq=$rsq[2]; 
      $resultlist=mysqli_fetch_array($rsq[0]);
      if($resultlist['queryDate']!=''){
    ?>
    
        <tr>
          <td align="center"> <?php echo makeQueryId($resultlist['id']);?></td>
          <td align="center"> <?php $paymenttype = strip($resultlists['paymentType']);
          if($paymenttype==1){ echo "Full Payment";} if($paymenttype==2){ echo "Partial Payment";} if($paymenttype==3){ echo "OnCredit";}?></td>
          <td align="center"> <?php echo showdate($resultlist['queryDate']);?></td>
          <td align="center"> <?php echo showClientTypeUserName($resultlist['clientType'],$resultlist['companyId']);?></td>
          <td align="center"> <?php echo strip($resultlist['guest1']);?></td>
          <td align="center"> <?php  $companyid = $resultlist['companyId'];
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
          //echo $companyid?></td>
          <td align="center"> <?php $hotel = strip($resultlistpsq['supplierId']);
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
          echo $hotel;?></td>
          <td align="center"> <?php $selectcity='*'; 
          $wherecity='';
          $wherecity='where   id="'.$cityid.'" ';
          $city=GetRecordList($selectcity,_CITY_MASTER_,$wherecity); 
          $totalentrycity=$city[1]; 
          $pagingcity=$city[2]; 
          $resultlistcity=mysqli_fetch_array($city[0]);
          $cityaddress = $resultlistcity['name'];
          echo $cityaddress;
           ?></td>
          <td align="center"> <?php echo showdate($resultlist['fromDate']);?></td>
          <td align="center"> <?php echo showdate($resultlist['toDate']); ?></td>
          <td align="center"> <?php echo strip($resultlist['rooms']); ?></td>
          <td align="center"> <?php echo strip($resultlistpsq['companytotalcost']);?></td>
          <td align="center"> <?php $taxcompany = strip($resultlistpsq['companycgst'])+strip($resultlistpsq['companysgst'])+strip($resultlistpsq['companyigst']); 
          $companytotalcost = strip($resultlistpsq['companytotalcost']);
          $companytax = $taxcompany*$companytotalcost; echo $totaltaxcompany = $companytax/100;?></td>
          <td align="center"> <?php $companytoalcost = strip($resultlistpsq['companytoalcost']); echo $companytoalcost;?></td>
          <td align="center"> <?php $suppliercost = strip($resultlistpsq['suppliertotalcost']); echo $suppliercost ;?></td>
          <td align="center"> <?php $taxcomponent = strip($resultlistpsq['suppliercgst'])+strip($resultlistpsq['suppliersgst'])+strip($resultlistpsq['supplierigst']); $tax = $taxcomponent*$suppliercost; echo $totaltax = $tax/100;?></td>
          <td align="center"> <?php $suppliertoalcost = strip($resultlistpsq['suppliertoalcost']);
          echo  $suppliertoalcost;?></td>
          
          <td align="center"> <?php echo "INR";?></td>
          <td align="center"> <?php if($resultlist['queryStatus']==6){ echo '<div class="assignquery">Options&nbsp;Sent</div>'; }if($resultlist['queryStatus']==7){ echo '<div class="assignquery">Follow-up</div>'; }if($resultlist['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; } if($resultlist['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlist['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlist['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlist['queryStatus']==5){ echo '<div class="closequery">Time Limit Booking</div>'; }  if($resultlist['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?></td>
          <td align="center"> <?php $sid = strip($resultlistpsq['supplierId']);$selectsup='*'; 
            $wheresup='';
            $wheresup='where   id="'.$sid.'" ';
            $sup=GetRecordList($selectsup,_SUPPLIERS_MASTER_,$wheresup); 
            $totalentrysup=$sup[1]; 
            $pagingsup=$sup[2]; 
            $resultlistsup=mysqli_fetch_array($sup[0]);
            echo $resultlistsup['name'];?></td>
          <td align="center"> <?php $commision = $suppliertoalcost-$companytoalcost; echo $commision;?></td>
          <td align="center"> <?php echo strip($resultlists['paymentBy']); ?></td>
          <td align="center"> <?php $voucher = strip($resultlist['id']);$wheresvoucher='';$selectvoucher='*';
            $wheresvoucher='where   queryId="'.$voucher.'" ';
            $voucher=GetRecordList($selectvoucher,_VOUCHER_LIST_MASTER_,$wheresvoucher); 
            $totalentryvoucher=$voucher[1]; 
            $pagingvoucher=$voucher[2]; 
            $resultlistvoucher=mysqli_fetch_array($voucher[0]);
            echo $resultlistvoucher['supplierserviceid'];?></td>
          
          <td align="center"> <?php echo $totaltax; ?></td>
          <td align="center"> <?php echo strip($resultlist['night']);?></td>
          <td align="center"> <?php echo strip($resultlists['details']);?></td>
          <td align="center"> <?php echo strip($resultlist['details']); ?></td>
        </tr>
    <?php } $n++; }  ?>
  </tbody>
 </table>
</div>

<div style="text-align:center; margin-top:30px;">
<form method="post" name="downloadrtm" id="downloadrtm" action="download_marginreport.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Margin Report"  style="margin-left:0px;" onclick="copydatatodata();" ><textarea name="marginreportdata" id="marginreportdata" cols="" rows="" style=" display:none;"></textarea></form></div>
<script>
function copydatatodata(){
var boxreport = $('#boxreport').html();
$('#marginreportdata').val(boxreport);  
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