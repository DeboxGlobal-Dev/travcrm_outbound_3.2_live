<?php

$searchField=clean($_GET['searchField']);



 if($loginuserprofileId==1){ 

$wheresearchassign=' 1 and ';

} else { 

 $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
 
  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') and ';

}
?>



<link href="css/main.css" rel="stylesheet" type="text/css" />

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="91%" align="left" valign="top">

	<form id="listform" name="listform" method="get">

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>

	<div id="deactivatebtn" style="display:none;">

	 <?php if($deletepermission==1){ ?> 

	

<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Voucher','600px','auto');" />

	<?php } ?>

	</div>

	

	</div></td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

         <td >

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:200px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Voucher or Query Id" onkeyup="numericFilter(this);"/></td>

     <td style="padding:0px 0px 0px 5px;" > 

           

 </td>

   

        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>

        <td style="padding-right:20px;">&nbsp;</td>

  </tr>

</table>



		</td>

        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="alertspopupopen('action=voucherqueryid','400px','auto');" /></td> <?php } ?>

      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>



<div id="pagelisterouter" style="padding-left:30px;">



<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<input name="action" type="hidden" value="voucherdelete" id="action" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



   <thead>



   <tr>
	 <th width="3%" align="left" class="header">&nbsp;</th>
     <th width="219" align="left" class="header" >Voucher ID</th>
     <th width="503" align="left" class="header">Booking Code </th>
	 <th width="100" align="left" class="header">Package&nbsp;Voucher</th>
	 <th width="503" align="left" class="header">Voucher Type</th>
     <th width="503" align="left" class="header">Voucher genrated Date </th>
     <th width="194" align="left" class="header">Status</th>
     <th width="290" align="center" class="header">Action </th>
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

   
 $profileiddata='';   
 if($loginuserprofileId=='48'){
  
 
$profileiddata=' and  queryId in (select id from miceMaster where companyId in ( select companyId from userMaster where id='.$_SESSION['userid'].'))';
}
  

 

$where='where deletestatus=0 '.$mainwhere.' and queryId in (select id from '._QUERY_MASTER_.' where '.$wheresearchassign.' totalQueryCostwithoutpercent>0 ) and queryId in (select queryid from '._PAYMENT_REQUEST_MASTER_.') '.$profileiddata.' order by id desc'; 

$page=$_GET['page'];

 

$targetpage=$fullurl.'showpage.crm?module=voucher&records='.$limit.'&searchField='.$searchField.'&'; 
$rs=GetRecordList($select,_VOUCHER_MASTER_,$where,$limit,$page,$targetpage);  
$totalentry=$rs[1]; 

$paging=$rs[2]; 

while($resultlists=mysqli_fetch_array($rs[0])){ 

$selectdisplay='*'; 
$wheredisplay='id="'.$resultlists['queryId'].'"'; 
$displayId=GetPageRecord($selectdisplay,_QUERY_MASTER_,$wheredisplay); 
$display=mysqli_fetch_array($displayId);
 $quotationYes = $display['quotationYes'];
 $queryId = $display['id'];
if($resultlists['voucherAgent']==1){

?>

  <tr>

    <?php /*?><td align="left"><div class="bluelink"><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeQueryId($resultlists['queryId']); ?></a>	 

	</div></td><?php */?>
	<td align="left"><a href="showpage.crm?module=voucher&add=yes&id=<?php echo encode($resultlists['id']); ?>"><img src="images/editicon.png" class="editicon" ></a></td>
	<td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-agentvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=0" target="_blank"  style="font-weight:500; color:#45b558 !important;"><?php echo makeQueryId($display['id']); ?></a></div></td>

    <td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-agentvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=0" target="_blank">IND<?php echo $resultlists['docId']; ?></a></div></td>
	<td align="left"><div class="bluelink"><?php if($quotationYes==0){ echo 'Itinerary'; } if($quotationYes==1){ echo 'Quotation'; } if($quotationYes==2){ echo 'Quotation'; } ?></div></td>
	<td align="left"><div class="bluelink"><?php echo 'Agent Voucher'; ?></div></td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>

    <td align="left" ><?php  if($resultlists['emailsent']==1){

 ?>

  <div class="bordergreenbtn" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=1','600px','auto');" style="cursor:pointer;">Sent</div>

 <?php } else { ?>

 <div class="borderorangebtn"  style="cursor:pointer;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=1','600px','auto');" >Pending</div>  

 <?php }   ?></td>

    <td align="center" ><div style="width:162px;">

<div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=1','600px','auto');"><img src="images/emailiconsmall.png"  /></div>

<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-agentvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=0" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

	<?php /*?><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>&print=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a><?php */?>

	

	<?php /*?><a href="tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl;  ?>voucherhtml.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></a><?php */?>

	

	<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-agentvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"/></div></a>

<?php

$select2='*';  
$where2='id='.$resultlists['queryId'].'';  
$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
$queryiddetail=mysqli_fetch_array($rs2);

if($queryiddetail['clientType']==2){  
$getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
} 
 
if($queryiddetail['clientType']==1){ 
$getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
}  
?>

	<a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Voucher: <?php echo $fullurl; ?>doc/<?php echo ($resultlists['id']); ?>/1.html&source=&data=" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>

	</div></td>
    </tr> 

	

	<?php $no++; } if($resultlists['voucherHotel']==1){

?>

  <!--<tr>

    <?php /*?><td align="left"><div class="bluelink"><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeQueryId($resultlists['queryId']); ?></a>	 

	</div></td><?php */?>
	<td align="left"><a href="showpage.crm?module=voucher&add=yes&id=<?php echo encode($resultlists['id']); ?>"><img src="images/editicon.png" class="editicon" ></a></td>
	<td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=0" target="_blank"  style="font-weight:500; color:#45b558 !important;"><?php echo makeQueryId($display['id']); ?></a></div></td>

    <td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=0" target="_blank">IND<?php echo $resultlists['docId']; ?></a></div></td>
	<td align="left"><div class="bluelink"><?php  echo 'Hotel Voucher';?></div></td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>

    <td align="left" ><?php  if($resultlists['emailsent']==1){

 ?>

  <div class="bordergreenbtn" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');" style="cursor:pointer;">Sent</div>

 <?php } else { ?>

 <div class="borderorangebtn"  style="cursor:pointer;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');" >Pending</div>  

 <?php }   ?></td>

    <td align="center" ><div style="width:162px;">

<div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');"><img src="images/emailiconsmall.png"  /></div>

<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=0" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

	<?php /*?><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>&print=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a><?php */?>

	

	<?php /*?><a href="tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl;  ?>voucherhtml.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></a><?php */?>

	

	<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($resultlists['id']); ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"/></div></a>

<?php

$select2='*';  
$where2='id='.$resultlists['queryId'].'';  
$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
$queryiddetail=mysqli_fetch_array($rs2);

if($queryiddetail['clientType']==2){  
$getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
} 
 
if($queryiddetail['clientType']==1){ 
$getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
}  
?>

	<a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Voucher: <?php echo $fullurl; ?>doc/<?php echo ($resultlists['id']); ?>/1.html&source=&data=" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>

	</div></td>
    </tr>--> 
	
	<?php 
	if($quotationYes==2){
	$select12='';
	$select12='*';
	$where12=''; 
 	$where12=' queryId="'.$queryId.'"';  
	$rs12=GetPageRecord($select12,_QUOTATION_MASTER_,$where12);  
	$listofsuppliers=mysqli_fetch_array($rs12);
	$packageId=$listofsuppliers['id'];
	$select13='';
	$select13='*';
	$where13='';
	$where13=' queryId="'.$queryId.'" and status=1 ';  
	$rs13=GetPageRecord($select13,_QUOTATION_HOTEL_MASTER_,$where13);  
	while($hotellisting=mysqli_fetch_array($rs13)){
	
	$select14=''; 
	$where14=''; 
	$rs14='';  
	$select14='*';    
	$where14='  id="'.$hotellisting['supplierId'].'" ';  
	$rs14=GetPageRecord($select14,_PACKAGE_BUILDER_HOTEL_MASTER_,$where14); 
	while($resListing=mysqli_fetch_array($rs14)){
	?>

	<tr>

    <?php /*?><td align="left"><div class="bluelink"><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeQueryId($resultlists['queryId']); ?></a>	 

	</div></td><?php */
	//$url = $fullurl.'/download-hotelvoucher.php?id='.encode($resultlists['id']).'&hotelId='.encode($resListing['id']).'&download=0';
	$id = ($resultlists['id']).'&hotelId='.($resListing['id']); ?>
	<td align="left"><a href="showpage.crm?module=voucher&add=yes&id=<?php echo encode($resultlists['id']); ?>"><img src="images/editicon.png" class="editicon" ></a></td>
	<td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank"  style="font-weight:500; color:#45b558 !important;"><?php echo makeQueryId($display['id']); ?></a></div></td>

    <td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank">IND<?php echo $resultlists['docId']; ?></a></div></td>
	<td align="left"><div class="bluelink"><?php if($quotationYes==2){ echo 'Quotation'; } ?></div></td>
	<td align="left"><div class="bluelink"><?php  echo $resListing['hotelName'].' - Hotel';?></div></td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>

    <td align="left" ><?php  if($resultlists['emailsent']==1){

 ?>

  <div class="bordergreenbtn" onclick="alertspopupopen('action=sendhotelvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&hotelId=<?php echo $resListing['id']; ?>&hotelId=<?php echo $resListing['id']; ?>&voucherType=2','600px','auto');" style="cursor:pointer;">Sent</div>

 <?php } else { ?>

 <div class="borderorangebtn"  style="cursor:pointer;" onclick="alertspopupopen('action=sendhotelvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&hotelId=<?php echo $resListing['id']; ?>&voucherType=2','600px','auto');" >Pending</div>  

 <?php }   ?></td>

    <td align="center" ><div style="width:162px;">

<div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendhotelvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&hotelId=<?php echo $resListing['id']; ?>&voucherType=2','600px','auto');"><img src="images/emailiconsmall.png"  /></div>

<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

	<?php /*?><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>&print=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a><?php */?>

	

	<?php /*?><a href="tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl;  ?>voucherhtml.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></a><?php */ 
	?>

	 

	<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"/></div></a>

<?php

$select2='*';  
$where2='id="'.$resultlists['queryId'].'"';  
$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
$queryiddetail=mysqli_fetch_array($rs2);

if($queryiddetail['clientType']==2){  
$getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
} 
 
if($queryiddetail['clientType']==1){ 
$getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
}  
?>

	<a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Voucher: <?php echo $fullurl; ?>doc/<?php echo ($resultlists['id']); ?>/1.html&source=&data=" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>

	</div></td>
    </tr>
	<?php } } } ?>
	
	<?php 
	
	if($quotationYes==1){
	
	$select13='';
	$select13='*';
	$where13='';
	$where13=' packageId="'.$display['quotationId'].'"  group by hotelName';  
	$rs13=GetPageRecord($select13,_PACKAGE_BUILDER_HOTEL_,$where13);  
	while($hotellisting=mysqli_fetch_array($rs13)){
	
	$select14=''; 
	$where14=''; 
	$rs14='';  
	$select14='*';    
	$where14='  id="'.$hotellisting['hotelId'].'"';  
	$rs14=GetPageRecord($select14,_PACKAGE_BUILDER_HOTEL_MASTER_,$where14); 
	$resListing=mysqli_fetch_array($rs14);
	
	?>

	<tr>

    <?php /*?><td align="left"><div class="bluelink"><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeQueryId($resultlists['queryId']); ?></a>	 

	</div></td><?php */
	$id = ($resultlists['id']).'&hotelId='.($resListing['id']); ?>
	<td align="left"><a href="showpage.crm?module=voucher&add=yes&id=<?php echo encode($resultlists['id']); ?>"><img src="images/editicon.png" class="editicon" ></a></td>
	<td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank"  style="font-weight:500; color:#45b558 !important;"><?php echo makeQueryId($display['id']); ?></a></div></td>

    <td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank">IND<?php echo $resultlists['docId']; ?></a></div></td>
	<td align="left"><div class="bluelink"><?php if($quotationYes==1){ echo 'B2C Quotation'; } ?></div></td>
	<td align="left"><div class="bluelink"><?php  echo $resListing['hotelName'].' - Hotel';?></div></td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>

    <td align="left" ><?php  if($resultlists['emailsent']==1){

 ?>

  <div class="bordergreenbtn" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');" style="cursor:pointer;">Sent</div>

 <?php } else { ?>

 <div class="borderorangebtn"  style="cursor:pointer;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');" >Pending</div>  

 <?php }   ?></td>

    <td align="center" ><div style="width:162px;">

<div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');"><img src="images/emailiconsmall.png"  /></div>

<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

	<?php /*?><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>&print=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a><?php */?>

	

	<?php /*?><a href="tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl;  ?>voucherhtml.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></a><?php */?>

	

	<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"/></div></a>

<?php

$select2='*';  
$where2='id="'.$resultlists['queryId'].'"';  
$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
$queryiddetail=mysqli_fetch_array($rs2);

if($queryiddetail['clientType']==2){  
$getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
} 
 
if($queryiddetail['clientType']==1){ 
$getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
}  
?>

	<a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Voucher: <?php echo $fullurl; ?>doc/<?php echo ($resultlists['id']); ?>/1.html&source=&data=" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>

	</div></td>
    </tr>
	<?php  } } ?>
	
	<?php 
	
	if($quotationYes==0){
	
	$select13='';
	$select13='DISTINCT hotelId';
	$where13='';
	$where13=' packageId="'.$queryId.'"  ';  
	$rs13=GetPageRecord($select13,_PACKAGE_QUERY_HOTEL_,$where13);  
	while($hotellisting=mysqli_fetch_array($rs13)){
	
	$select14=''; 
	$where14=''; 
	$rs14='';  
	$select14='*';    
	$where14='  id='.$hotellisting['hotelId'].'';  
	$rs14=GetPageRecord($select14,_PACKAGE_BUILDER_HOTEL_MASTER_,$where14); 
	while($resListing=mysqli_fetch_array($rs14)){
	?>

	<tr>

    <?php /*?><td align="left"><div class="bluelink"><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeQueryId($resultlists['queryId']); ?></a>	 

	</div></td><?php */
	$id = ($resultlists['id']).'&hotelId='.($resListing['id']); ?>
	<td align="left"><a href="showpage.crm?module=voucher&add=yes&id=<?php echo encode($resultlists['id']); ?>"><img src="images/editicon.png" class="editicon" ></a></td>
	<td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank"  style="font-weight:500; color:#45b558 !important;"><?php echo makeQueryId($display['id']); ?></a></div></td>

    <td align="left"><div class="bluelink"><a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank">IND<?php echo $resultlists['docId']; ?></a></div></td>
	<td align="left"><div class="bluelink"><?php if($quotationYes==0){ echo 'Itinerary'; } ?></div></td>
	<td align="left"><div class="bluelink"><?php  echo $resListing['hotelName'].' - Hotel';?></div></td>
    <td align="left"><?php echo showdatetime($resultlists['dateAdded'],$loginusertimeFormat);?></td>

    <td align="left" ><?php  if($resultlists['emailsent']==1){

 ?>

  <div class="bordergreenbtn" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');" style="cursor:pointer;">Sent</div>

 <?php } else { ?>

 <div class="borderorangebtn"  style="cursor:pointer;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');" >Pending</div>  

 <?php }   ?></td>

    <td align="center" ><div style="width:162px;">

<div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendvoucheremail&voucherid=<?php echo $resultlists['queryId']; ?>&vid=<?php echo $resultlists['id']; ?>&voucherType=2','600px','auto');"><img src="images/emailiconsmall.png"  /></div>

<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=0" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

	<?php /*?><a href="send-voucher.php?id=<?php echo encode($resultlists['id']); ?>&print=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a><?php */?>

	

	<?php /*?><a href="tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl;  ?>voucherhtml.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></a><?php */?>

	

	<a href="<?php echo $fullurl; ?>/tcpdf/examples/genratevoucher.php?pageurl=<?php echo $fullurl; ?>/download-hotelvoucher.php?id=<?php echo encode($id); ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"/></div></a>

<?php

$select2='*';  
$where2='id="'.$resultlists['queryId'].'"';  
$rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
$queryiddetail=mysqli_fetch_array($rs2);

if($queryiddetail['clientType']==2){  
$getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
} 
 
if($queryiddetail['clientType']==1){ 
$getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
}  
?>

	<a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Voucher: <?php echo $fullurl; ?>doc/<?php echo ($resultlists['id']); ?>/1.html&source=&data=" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>

	</div></td>
    </tr>
	<?php } } } ?>

	<?php $no++; } } ?>
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