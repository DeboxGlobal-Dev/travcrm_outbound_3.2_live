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
    <td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo $fromDate; ?>"/></td>
     <td style="padding:0px 0px 0px 5px;" > 
           <input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo $toDate; ?>"/> </td>
   
        <td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; " >
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
			 
          </select></td>
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
<table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">

   <thead>

   <tr>
     <th  align="center" valign="middle" class="header" style="width: 20%; !important;"><label for="checkAll"><span></span>Booking ID</label></th> 
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
     <th align="center" class="header"  >Tax component</th>
     <th align="center" class="header"  >Gross Cost </th>
     <th align="center" class="header"  >Client Cost</th>
     <th align="center" class="header"  >Gross Selling</th>
     <th align="center" class="header"  >Currency</th>
     <th align="center" class="header"  >Booking Status</th>
     <th align="center" class="header"  >Booking Agent</th>
     <th align="center" class="header"  >Commission</th>
     <th align="center" class="header"  >Bmision and </th>
     <th align="center" class="header"  >RESERVATION</th>
     <th align="center" class="header"  >MARKUP AMOUNT</th>
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

 

$where='order  by id desc'; 

$rs=GetRecordList($select,_PAYMENT_LIST_MASTER_,$where); 

$totalentry=$rs[1]; 
$paging=$rs[2];
while($resultlists=mysqli_fetch_array($rs[0])){ 
  //print_r($resultlists);
$pid = $resultlists['paymentRequestId'];
//echo 'pid='.''.$pid;


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
//echo 'queryid='.''.$queryid.''.'p=payment';
?>
<?php 
      $selectq='*'; 
      $whereq='';
      $whereq='where   id="'.$queryid.'" ';
      $rsq=GetRecordList($selectq,_QUERY_MASTER_,$whereq); 
      $totalentryq=$rsq[1]; 
      $pagingq=$rsq[2]; 
      $resultlist=mysqli_fetch_array($rsq[0]);
?>
    
        <tr>
          <td> <?php  echo makeQueryId($resultlist['id']);?> </td>
          <td>  <?php echo showdate($resultlist['queryDate']);?></td>
          <td> <?php echo makeQueryId($resultlistps['paymentStatus']);?> </td>
          <td> <?php echo strip($resultlist['id']);?> </td>
          <td>  <?php echo makeQueryId($resultlist['id']);?></td>
          <td>  <?php echo showdate($resultlist['queryDate']);?></td>
          <td> <?php echo makeQueryId($resultlistps['paymentStatus']);?>  </td>
          <td>  <?php echo strip($resultlist['id']); ?></td>
          <td> <?php echo makeQueryId($resultlist['id']);?> </td>
          <td> <?php echo showdate($resultlist['queryDate']); ?></td>
          <td> <?php echo makeQueryId($resultlistps['paymentStatus']); ?> </td>
          <td> <?php echo strip($resultlist['id']);?></td>
          <td><?php echo makeQueryId($resultlist['id']);?> </td>
          <td> <?php  echo makeQueryId($resultlist['id']);?> </td>
          <td>  <?php echo showdate($resultlist['queryDate']);?></td>
          <td> <?php echo makeQueryId($resultlistps['paymentStatus']);?> </td>
          <td> <?php echo strip($resultlist['id']);?> </td>
          <td>  <?php echo makeQueryId($resultlist['id']);?></td>
          <td>  <?php echo showdate($resultlist['queryDate']);?></td>
          <td> <?php echo makeQueryId($resultlistps['paymentStatus']);?>  </td>
          <td>  <?php echo strip($resultlist['id']); ?></td>
          <td> <?php echo makeQueryId($resultlist['id']);?> </td>
          <td> <?php echo showdate($resultlist['queryDate']); ?></td>
          <td> <?php echo makeQueryId($resultlistps['paymentStatus']); ?> </td>
          <td> <?php echo strip($resultlist['id']);?></td>
          <td><?php echo makeQueryId($resultlist['id']);?> </td>
          <td> <?php echo showdate($resultlist['queryDate']); ?></td>
          
          
        </tr>
     </tbody>
   </table>

<?php $n++; }  ?>
<?php } else { ?>
<div id="boxreport">
  <table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">

   <thead>

   <tr>
     <th  align="center" valign="middle" class="header" style="width: 20%; !important;"><label for="checkAll"><span></span>Booking ID</label></th> 
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
     <th align="center" class="header"  >Tax component</th>
     <th align="center" class="header"  >Gross Cost </th>
     <th align="center" class="header"  >Client Cost</th>
     <th align="center" class="header"  >Gross Selling</th>
     <th align="center" class="header"  >Currency</th>
     <th align="center" class="header"  >Booking Status</th>
     <th align="center" class="header"  >Booking Agent</th>
     <th align="center" class="header"  >Commission</th>
     <th align="center" class="header"  >Bmision and </th>
     <th align="center" class="header"  >RESERVATION</th>
     <th align="center" class="header"  >MARKUP AMOUNT</th>
     <th align="center" class="header"  >GST</th>
     <th align="center" class="header"  >Nights</th>
     <th align="center" class="header"  >Remarks</th>
     <th align="center" class="header"  >CCPROVIDEDFOR</th>
     </tr>
   </thead>

 


 

  <tbody>


  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 

 
$searchFieldcommonquery='';
if($searchFieldcommon!=''){
$searchFieldcommonquery=' and (subject like "%'.$searchFieldcommon.'%" or companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$searchFieldcommon.'%"))';
} 
 

  
$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in (select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].') or companyId in (select id from  '._CORPORATE_MASTER_.' where assignTo='.$_SESSION['userid'].')  ) '.$searchFieldcommonquery.''; 
  
  
 if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.' '.$searchFieldcommonquery.''; 
} else {
$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].' or  assignTo in (select id from  '._USER_MASTER_.' where superParentId='.$_SESSION['userid'].') or companyId in (select id from  '._CORPORATE_MASTER_.' where assignTo='.$_SESSION['userid'].')  ) '.$searchFieldcommonquery.''; 
}
 
 
  
 
$where='where  '.$strWhere.' and deletestatus=0 order by dateAdded desc'; 
//$page=$_GET['page'];
 
//$targetpage=$fullurl.'showpage.crm?module=query&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 
$rs=GetRecordList($select,_QUERY_MASTER_,$where); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
 <tr <?php if($resultlists['queryStatus']==20){ ?>style="background-color: #fff2f2;"<?php } ?>>
   
    <td align="left"><div class="bluelink" style="position:relative; padding-right:10px;" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo makeQueryId($resultlists['id']); ?>
  <?php if(countQueryunreadMails($resultlists['id'])!=0){ ?><div class="numberbubbol"><?php echo countQueryunreadMails($resultlists['id']); ?></div><?php } ?>
  </div>   </td>
    <td align="left"><div style="width:130px;" class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo clean($resultlists['subject']); ?></div></td>
    <td align="left"><?php echo  showdate($resultlists['queryDate']);?></td>
    <td align="left"><?php echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); ?></td>
    <td align="left"><?php echo  strip($resultlists['guest1']);?></td>
    <td align="left" ><?php echo showClientTypeUserName($resultlists['clientType']); ?></td>
    <td align="left" ><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left" ><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left" ><?php echo showdate($resultlists['fromDate']); ?></td>
    <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>
    <td align="left" ><?php echo strip($resultlists['rooms']); ?></td>
    <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>
    <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>
    <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>

    <td align="center" ><?php if($resultlists['queryStatus']<3 || $resultlists['queryStatus']==6 || $resultlists['queryStatus']==7){ if($resultlists["queryTimer"]>0){  echo makedatetime($resultlists["queryTimer"]); } else { echo '-'; } } else { echo '-'; }?></td>
    <td align="left" ><?php if($resultlists['queryPriority']==1 || $resultlists['queryPriority']==0){ ?><div class="lowpire">Low</div><?php } ?><?php if($resultlists['queryPriority']==2){ ?><div class="mediampire">Medium</div><?php } ?><?php if($resultlists['queryPriority']==3){ ?><div class="highpire">High</div><?php } ?></td>
    <td align="left" ><?php echo getUserName($resultlists['assignTo']); ?></td>
    <td align="center"style="width:50px;">
  <?php if($resultlists['queryStatus']==20){ ?>
  <div class="lossquery">Cancelled</div>
  <?php } else { ?>
   <?php  
$result =mysqli_query ("select * from "._PAYMENT_REQUEST_MASTER_." where queryid='".$resultlists['id']."' and deletestatus!=1")  or die(mysqli_error(db())); 
$number =mysqli_num_rows($result);
$getpaymentid=mysqli_fetch_array($result);  
if($number>0) 
{ 
?>
    <div class="wonquery" <?php if($getpaymentid['status']==0){ ?>style="background-color:#CC3300;"<?php } ?>><?php if($getpaymentid['status']==0){ echo 'Unpaid'; } else { echo 'Paid'; } ?></div>
    
  <?php } else { ?>
  <?php 
 
  
  if($resultlists['queryStatus']==6){ echo '<div class="assignquery">Options&nbsp;Sent</div>'; }if($resultlists['queryStatus']==7){ echo '<div class="assignquery">Follow-up</div>'; }if($resultlists['queryStatus']==1){ echo '<div class="assignquery">Assigned</div>'; } if($resultlists['queryStatus']==2){ echo '<div class="revertquery">Reverted</div>'; } if($resultlists['queryStatus']==3){ echo '<div class="wonquery">Confirmed</div>'; } if($resultlists['queryStatus']==4){ echo '<div class="lossquery">Lost</div>'; } if($resultlists['queryStatus']==5){ echo '<div class="closequery">Time Limit Booking</div>'; }  if($resultlists['queryStatus']==0){ echo '<div class="assignquery">Assigned</div>'; }  ?>
  <?php } ?>  
  <?php } ?>  </td>
    <td align="center" >
  
  <?php
  
$result =mysqli_query ("select * from "._PAYMENT_REQUEST_MASTER_." where queryid='".$resultlists['id']."' and deletestatus!=1")  or die(mysqli_error(db())); 
$number =mysqli_num_rows($result);
$getpaymentid=mysqli_fetch_array($result);  
if($number>0) 
{ 
  
$result =mysqli_query ("select * from "._VOUCHER_MASTER_." where queryId='".$resultlists['id']."' and deletestatus!=1")  or die(mysqli_error(db())); 
$number =mysqli_num_rows($result);  
if($number>0) 
{ 

   
$select2='*'; 
$id2=$resultlists['id']; 
$where2='queryId='.$id2.' order by id desc'; 
$rs2=GetPageRecord($select2,_VOUCHER_MASTER_,$where2); 
$resultvou=mysqli_fetch_array($rs2); 

if($resultvou['emailsent']==1){
 ?>
  <div class="bordergreenbtn" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['id']; ?>&vid=<?php echo $resultvou['id']; ?>','600px','auto');" style="cursor:pointer;">Sent</div>
 <?php } else { ?>
 <div class="borderorangebtn" style="cursor:pointer;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['id']; ?>&vid=<?php echo $resultvou['id']; ?>','600px','auto');" >Pending</div>  
 <?php } } } ?> <?php echo getUserName($resultlists['assignTo']);?></td>
 <td align="left" ><?php echo strip($resultlists['night']); ?></td>
 <td align="left" ><?php echo strip($resultlists['night']); ?></td>
 <td align="left" ><?php echo showdate($resultlists['fromDate']); ?></td>
 <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>
 <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>
 <td align="left" ><?php echo strip($resultlists['night']); ?></td>
 <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>
 <td align="left" ><?php echo showdate($resultlists['toDate']); ?></td>

    </tr> 

<?php $no++; } ?>
  <!--<tr style="font-size: 20px;">
    <td align="center" valign="middle"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";
			$res5 = mysqli_query($sql5);
      //echo $tquery=$res5[''];
      $BookingId = makeQueryId($res5['id']);
      echo $BookingId;
      print_r($BookingId);
			//echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?> </td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";
			$res5 = mysqli_query($sql5);
      echo showdate($res5['queryDate']);
			//echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1) ";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=7";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
    <td align="center"><?php  
			$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=4";
			$res5 = mysqli_query($sql5);
			echo $tquery=mysqli_num_rows($res5);?></td>
 
    <td align="center">
	
	<?php
	
$suppliertotalcost_sum=0;
$menu=mysqli_query("select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){

$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query($sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  


$result = mysqli_query("SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];
}

echo $suppliertotalcost_sum;
?>
	
	</td>
    <td align="center" >
	
	<?php
	$companytotalcost_sum=0;
$menu=mysqli_query("select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");
while($res_menu=mysqli_fetch_array($menu)){

$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 
$rs3=mysqli_query($sql3) or die(mysqli_error(db())); 
$result2=mysqli_fetch_array($rs3);  


$result = mysqli_query("SELECT SUM(companytotalcost) AS companytotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 
$row = mysqli_fetch_assoc($result); 
$companytotalcost_sum = $companytotalcost_sum+$row['companytotalcost_sum'];
}


echo $suppliertotalcost_sum-$companytotalcost_sum;
?>
	
	
	</td>
    <td align="center" ><?php   
	 
	
 $result = mysqli_query("SELECT SUM(adult) AS value_sum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row = mysqli_fetch_assoc($result); 
 $adultsum = $row['value_sum'];



$result2 = mysqli_query("SELECT SUM(child) AS childsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row2 = mysqli_fetch_assoc($result2); 
echo $adultsum+$row2['childsum'];
?></td>
    <td align="center" >
	
	<?php   
  
 $result3 = mysqli_query("SELECT SUM(night) AS nightsum from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3"); 
$row3 = mysqli_fetch_assoc($result3); 
echo $adultsum+$row3['nightsum'];
?>
	
	</td>
    </tr> -->
	
 
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