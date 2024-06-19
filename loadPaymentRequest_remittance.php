<?php
include "inc.php"; 
include "config/logincheck.php"; 

 
if($_REQUEST['deleteId']!=''){ 
deleteRecord(_REM_PAYMENT_REQUEST_,' id = '.$_REQUEST['deleteId'].' and queryId='.$_REQUEST['id'].''); 
}

if($_REQUEST['savereqeust']=='1'){
$namevalue = 'status=1,invoiceGenerateDate="'.date('Y-m-d').'"';  
$where='queryId='.$_REQUEST['id'].'';  
$update = updatelisting(_REM_PAYMENT_REQUEST_,$namevalue,$where); 
}


$id=$_GET['id'];
?>
<?php
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=$id; 
$where='queryId='.$id.''; 
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
$dmcReqest=mysqli_fetch_array($rs);  
?>
<?php if($dmcReqest['id']!=''){ ?>
<!--<div style="padding: 10px 20px;
    font-size: 14px;
    background-color: #c9e6ef;
    font-weight: bold;">DMC Payment Request </div>
<div class="paymentboxmain" style="background-color: #e3f7fd; border-bottom: 2px #c9e6ef solid;">
sadf 
</div>-->
<?php } ?>
<?php
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=$id; 
$where='queryId='.$id.''; 
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
$dmcReqestyesno=mysqli_fetch_array($rs);  
?>
<?php if($dmcReqestyesno['status']==1){ ?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="paymentboxpending" id="pendingpaymentredbox" style="display:none;">Payment: <strong>Pending</strong> </div>



<div class="paymentboxmain">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <th align="left" class="paymentboxtable" style="padding:10px;"><strong>Received
      </td>
    </strong>
    <td class="paymentboxtable"><strong>Attachment</strong></td>
    <td class="paymentboxtable"><strong>Description</strong></td>
    <td class="paymentboxtable"><strong>Receive Date</strong></td>
  </tr>
<?php
$s=1;
$select2='*';
$where2='queryId='.$_REQUEST['id'].' order by id ASC'; 
$rs2=GetPageRecord($select2,_REM_PAYMENT_LIST_MASTER_,$where2); 
while($listofpayment=mysqli_fetch_array($rs2)){ ?>
  
  <tr>
     <td align="left" class="paymentboxtable">
	 
	 
	 <?php 
	 $select3='*';  
$where3='id='.$listofpayment['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
	 
	 echo $curname['name'].' '.$listofpayment['amount']; ?></td>
    <td class="paymentboxtable"><?php if($listofpayment['attachmentFile']!=''){ ?><a href="download/<?php echo $listofpayment['attachmentFile']; ?>" target="_blank">Download</a><?php } ?></td>
    <td class="paymentboxtable"><?php echo clean($listofpayment['details']); ?></td>
    <td class="paymentboxtable"><div><?php 
$select=''; 
$where=''; 
$rs='';  
$select='firstName,lastName';   
$where='id="'.$listofpayment['addedBy'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($userss=mysqli_fetch_array($rs)){  

echo $userss['firstName'].' '.$userss['lastName'];

}
?></div><div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($listofpayment['dateAdded'],$loginusertimeFormat);?></div></td>
    </tr>
	<?php $s++; } ?>
</table>
<?php if($s==1){ ?>
<div style="text-align:center;" class="paymentboxtable">No Payment History </div>
<?php } ?>
<?php if($resultpaymentpage['status']!=1){ ?>
<div style="text-align:center; margin-top:20px;">

 

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left"><div style="padding:10px; background-color:#FFFFFF; float:left;"><table border="0" cellpadding="8" cellspacing="0" bgcolor="#fff">
      <tr>
        <td colspan="2" style="padding-right:20px;    border-bottom: 2px #e8e8e8 solid;">&nbsp;</td>
      <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$_REQUEST['id'].'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   
?>  <td align="right" style="padding-right:20px;    border-bottom: 2px #e8e8e8 solid;"><?php  echo ($curname['name']); ?></td>
<?php } ?>
      </tr>
      <tr>
        <td colspan="2" style="padding-right:20px;border-bottom: #f1f1f1 1px solid;">Total Pending Amount:<strong> </strong></td>
		<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$_REQUEST['id'].'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   
?>
        <td align="right" style="padding-right:20px;border-bottom: #f1f1f1 1px solid;"><strong><span id="box<?php echo ($curname['id']); ?>"></span>
        </strong></td>
		<?php } ?>
      </tr>
      <tr>
        <td colspan="2" style="border-bottom: #f1f1f1 1px solid;">Received:</td>
       <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$_REQUEST['id'].'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   
?>
        <td align="right" style="padding-right:20px;border-bottom: #f1f1f1 1px solid;"><strong><span id="rbox<?php  echo ($curname['id']); ?>"><?php 
$t=0;
$select4=''; 
$where4=''; 
$rs4='';  
$select4='sum(amount) as cramount';    
$where4='currencyId='.$curname['id'].' and queryId="'.$_REQUEST['id'].'"';  
$rs4=GetPageRecord($select4,_REM_PAYMENT_LIST_MASTER_,$where4); 
while($a=mysqli_fetch_array($rs4)){   
if($a['cramount']!=''){
echo $a['cramount'];
} else {
echo '0';
}

} ?></span>
        </strong></td>
		<?php } ?>
      </tr>
      <tr>
        <td colspan="2" style="border-bottom: #f1f1f1 1px solid;">Pending:</td>
       <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$_REQUEST['id'].'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   
?>
        <td align="right" style="padding-right:20px;border-bottom: #f1f1f1 1px solid;"><strong><span id="pbox<?php  echo ($curname['id']); ?>"></span>
        </strong></td>
		<?php } ?>
      </tr>
      
    </table></div></td>
    <td width="9%" align="right" valign="top"><input name="addnewuserbtn" type="button" class="greenmbutton3 submitbtn" id="addnewuserbtn" value="Update Payment"  onclick="alertspopupopen('action=Remittancemakepaymentrequestpayment&queryId=<?php echo ($_REQUEST['id']); ?>','500px','auto');" /></td>
  </tr>
</table>

</div>
<?php } ?>
</div>
<div style="margin-top:20px; padding:0px !important; text-align:right;">
<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="View Invoice" onclick="invoicedmc();$('#invoicetop').show();" style="margin-right:20px;">
</div>
<div style="padding:20px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="center" class="header" >S.N.</th>

      <th align="left" class="header">Date</th>
      <th align="left" class="header">Reference&nbsp;No. </th>
      <th align="left" class="header">Description</th>
      <th align="center" class="header">Pax </th>
      <th align="right" class="header">Rate</th>
      <th align="center" class="header">ReMTT Charges</th>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   
?>
      <th align="right" class="header"><?php  echo ($curname['name']); ?></th>
	    <?php } ?>
	  <th align="center" class="header">&nbsp;</th>
   </tr>
   </thead>

 


 

  <tbody>
<?php
$n=1;
$select1=''; 
$wher1=''; 
$rs1='';  
$select1='*';    
$where1='  queryId="'.$id.'"  order by id asc';  
$rs1=GetPageRecord($select1,_REM_PAYMENT_REQUEST_,$where1); 
while($dmcroommastermain=mysqli_fetch_array($rs1)){   
?>
  <tr>
    <td align="center">
	
	<?php  echo $n; ?>	</td>

    <td align="left"><?php  echo date("d-m-Y", strtotime($dmcroommastermain['fromDate']));  ?></td>
    <td align="left"><?php  echo ($dmcroommastermain['referenceNo']); ?></td>
    <td align="left"><?php  echo  ($dmcroommastermain['description']); ?></td>
    <td align="center"><?php  echo  ($dmcroommastermain['pax']); ?></td>
    <td align="right"><?php  echo  ($dmcroommastermain['rate']); ?></td>
    <td align="center"><?php  echo  ($dmcroommastermain['remcharges']); ?></td>
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 

$select4='*';  
$where4='currencyId='.$resListing['currencyId'].' and queryId="'.$id.'" and id='.$dmcroommastermain['id'].' '; 
$rs4=GetPageRecord($select4,_REM_PAYMENT_REQUEST_,$where4); 
$curnameval=mysqli_fetch_array($rs4);   
?>
    <td align="right"><?php echo $curnameval['subtotal']; ?></td><?php  } ?>
    <td align="center"><a style="color:#FF0000 !important;  font-size:12px;" onclick="if(confirm('Are you sure you want delete this request?')) loadPaymentRequestdmc('<?php echo $dmcroommastermain['id']; ?>');" >Delete</a></td>
  </tr>	<?php  $n++; } ?>
  <tr style="background-color: #e8e8e8;">
    <td colspan="7" align="right"><strong>Total</strong></td>
    <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 
$curid=$resListing['currencyId'];
?><td align="right"><strong>
INR.
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  id="'.$curid.'" ';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
$currenyvalue=mysqli_fetch_array($rs);
$curvalue=$currenyvalue['currencyValue'];
?>
<?php 
$t=0;
$select4=''; 
$where4=''; 
$rs4='';  
$select4='sum(subtotal) as TotaladultCost';    
$where4='currencyId='.$resListing['currencyId'].' and queryId="'.$id.'"';  
$rs4=GetPageRecord($select4,_REM_PAYMENT_REQUEST_,$where4); 
while($adultcostSightseeingcost=mysqli_fetch_array($rs4)){   
$t=$adultcostSightseeingcost['TotaladultCost'];
echo $t*$curvalue;
} ?></strong></td> 

<script>
$('#box<?php echo $resListing['currencyId']; ?>').text('<?php echo $t; ?>');
var rbox<?php echo $resListing['currencyId']; ?> = $('#rbox<?php echo $resListing['currencyId']; ?>').text();
$('#pbox<?php echo $resListing['currencyId']; ?>').text(Number(<?php echo $t; ?>-rbox<?php echo $resListing['currencyId']; ?>));

var pbox<?php echo $resListing['currencyId']; ?> = Number($('#pbox<?php echo $resListing['currencyId']; ?>').text());

if(pbox<?php echo $resListing['currencyId']; ?>>0){
$('#pendingpaymentredbox').show(); 
} else {
$('#pendingpaymentredbox').hide();
}
</script>
 <?php } ?>
    <td align="center">&nbsp;</td>
  </tr> 
</tbody></table>
</div>

<?php } else {?>
<div style="padding:20px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header">Services</th>
      <th align="left" class="header">Reference&nbsp;No. </th>
      <th align="left" class="header">Des.</th>
      <th align="left" class="header">Pax Type </th>
      <th align="left" class="header">Pax (NOS)</th>
      <th align="left" class="header">Currency</th>
      <th align="right" class="header">Rate</th>
      <th align="right" class="header">Total</th>
      <th align="right" class="header">ReMTT Charges </th>
      <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){


$select3='*';  
$where3='id='.$resListing['currencyId'].''; 
$rs3=GetPageRecord($select3,_QUERY_CURRENCY_MASTER_,$where3); 
$curname=mysqli_fetch_array($rs3); 
   
?>
      <?php } ?>
	  <th align="right" class="header">Sub&nbsp;Total</th>
	
      <th align="center" class="header">&nbsp;</th>
   </tr>
   </thead>

 


 

  <tbody>
<?php
$s=1;
$select1=''; 
$wher1=''; 
$rs1='';  
$select1='*';    
$where1='  queryId="'.$id.'"  order by id asc';  
$rs1=GetPageRecord($select1,_REM_PAYMENT_REQUEST_,$where1); 
while($dmcroommastermain=mysqli_fetch_array($rs1)){   
?>
  <tr>
    <td align="left"><?php 
 
$select='*';    
$where=' id='.$dmcroommastermain['tourType'].'';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

echo  $resListing['name'];

 } ?></td>
    <td align="left"><?php  echo ($dmcroommastermain['referenceNo']); ?></td>
    <td align="left"><?php  echo  nl2br($dmcroommastermain['description']); ?></td>
    <td align="left"><?php  if($dmcroommastermain['paxType']==1){ echo 'Adult'; } if($dmcroommastermain['paxType']==2){ echo 'Child'; } ?></td>
    <td align="left"><?php  echo  ($dmcroommastermain['pax']); ?></td>
    <td align="left"><?php 
 
$select='*';    
$where=' id='.$dmcroommastermain['currencyId'].'';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

echo  $resListing['name'];

 } ?></td>
    <td align="right"><?php  echo  ($dmcroommastermain['rate']); ?></td>
    <td align="right"><?php echo $dmcroommastermain['rate']*$dmcroommastermain['pax'];   ?></td>
    <td align="right"><?php  echo  ($dmcroommastermain['remcharges']); ?></td>
    <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  queryId="'.$id.'" group by currencyId order by id asc';  
$rs=GetPageRecord($select,_REM_PAYMENT_REQUEST_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 

$select4='*';  
$where4='currencyId='.$resListing['currencyId'].' and queryId="'.$id.'" and id='.$dmcroommastermain['id'].' '; 
$rs4=GetPageRecord($select4,_REM_PAYMENT_REQUEST_,$where4); 
$curnameval=mysqli_fetch_array($rs4);   
?>
    <?php  } ?>
    <td align="right"><?php $totalsub=$dmcroommastermain['rate']*$dmcroommastermain['pax']; $totalsubgst=$dmcroommastermain['remcharges']; echo  $totalsub+$totalsubgst; ?></td>
    
	
    <td align="center">  
<a style="color:#FF0000 !important;  font-size:12px;" onclick="if(confirm('Are you sure you want delete this request?')) loadPaymentRequestdmc('<?php echo $dmcroommastermain['id']; ?>');" >Delete</a></td>
  </tr>	<?php  $s++; } ?>
</tbody></table>

<style>
.gridlable{width:100% !important;}
</style>
<div style="margin-top:20px; padding:0px !important;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight2222" target="actoinfrm"  id="addflight2222"> <table border="0" cellpadding="2" cellspacing="0" class="addeditpagebox" style="padding:0px !important;">
  <tr>
    <td valign="top"><div class="griddiv" style="border-bottom:0px;"><label>
  
	<div class="gridlable" style="width:100%;">Service <span class="redmind"></span></div>
	<select id="tourType2" name="tourType2" class="gridfield validate" displayname="Tour Type" autocomplete="off" style="    height: 37px;"   >
	 <option value="">Select</option>
	 <?php
		$select=''; 
		$where=''; 
		$rs='';   
		$select='*'; 		
		$where='id='.$_REQUEST['id'].''; 
		$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
		$resultpage=mysqli_fetch_array($rs); 
	  ?>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$resultpage['tourType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	<style>
	.Zebra_DatePicker_Icon_Wrapper{width:100% !important;}
	</style>
	</label>
	 
 </div></td>
    <td valign="top"><div class="griddiv" style="    width: 104px;">
      <label> </label>
      <div class="gridlable">Reference No. </div>
      <input name="referenceNo" type="text" class="gridfield" id="referenceNo"   value="<?php echo $referenceNo; ?>" maxlength="200" displayname="Reference No."  autocomplete="off" style="width:104px;height: 37px;"  />
    </div></td>
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Description </div>
	<textarea name="description" rows="2" class="gridfield" id="description" displayname="Description" autocomplete="off" style="width:200px;"><?php echo $description; ?></textarea>
	</label>
	 
 </div></td>
    
     
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Pax&nbsp;Type<span class="redmind"></span></div>
	<select id="paxType2" name="paxType2" class="gridfield validate" displayname="Pax Type" autocomplete="off" style="width:100px;"  >
	 <option value="">Select</option> 
<option value="1" <?php if(1==$paxType){ ?>selected="selected"<?php } ?>>Adult</option> 
<option value="2" <?php if(2==$paxType){ ?>selected="selected"<?php } ?>>Child</option> 
</select>
	</label>
	 
 </div></td>
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Pax<span class="redmind"></span></div>
	<input name="pax2"   type="text" class="gridfield validate" id="pax2"   maxlength="3" displayname="Pax" style="width:50px;"  autocomplete="off" onkeyup="numericFilter(this);dmcpaymentrequestrate();" value="<?php echo $pax; ?>"  />
	</label>
	 
 </div></td>
    <td valign="top"><div class="griddiv" style="border-bottom:0px;"><label>
  
	<div class="gridlable" style="width:100%;">Currency  <span class="redmind"></span></div>
	<select id="currencyId2" name="currencyId2" class="gridfield validate" displayname="Currency" autocomplete="off" style="width:100px;"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){   
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	 
	</label>
	 
 </div></td>
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Rate<span class="redmind"></span></div>
	<input name="rate2"   type="text" class="gridfield" id="rate2"    maxlength="12" displayname="Rate"  autocomplete="off" onkeyup="numericFilter(this);dmcpaymentrequestrate();" value="<?php echo $rate; ?>"  />
	</label>
	<script>
	function dmcpaymentrequestrate(){
	var rate = Number($('#rate2').val());
	var pax = Number($('#pax2').val());
	var gst = Number($('#remcharges').val());
	 
	if(gst==''){
	gst=Number(0);
	}
	
	if(rate!='' && pax!=''){
	var totalsub=Number(pax*rate);
	$('#totalRate').val(totalsub);
	var gstval = Number(totalsub+gst); 
	$('#subtotal2').val(gstval);
	}
	}
	</script>
	 
 </div></td>
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Total<span class="redmind"></span></div>
	<input name="totalRate"   type="text" class="gridfield" id="totalRate"   displayname="Total"   autocomplete="off" value=""  readonly="readonly"   />
	</label>
	 
 </div></td>
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Remm&nbsp;Charges  </div>
	<input name="remcharges"   type="text" class="gridfield" id="remcharges" onkeyup="numericFilter(this);dmcpaymentrequestrate();" value="0"   maxlength="3" displayname="Remm Charges"    autocomplete="off"   />
	</label>
	 
 </div></td>
    <td valign="top"><div class="griddiv"><label>
  
	<div class="gridlable">Sub&nbsp;Total<span class="redmind"></span></div>
	<input name="subtotal2" type="text" class="gridfield" id="subtotal2"   maxlength="12" displayname="Sub Total"  autocomplete="off" onkeyup="numericFilter(this);" value="<?php echo $rate; ?>"  />
	</label>
	 
 </div></td>
    <td valign="top">  <input name="action" id="action" type="hidden" value="addREMpaymentrequest" />
    <input name="queryId" id="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
	<input name="fromDate3" id="fromDate3" type="hidden" value="<?php echo date('d-m-Y'); ?>" />
	<input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="Add" style="margin-right:10px;    margin-top: 20px;" onclick="formValidation('addflight2222','submitbtn','0');"></td>
  </tr>
</table>
</form>

</div>


<?php if($s>1){ ?>
<div style="margin-top:20px; padding:0px !important; text-align:right;">
<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save And Generate Invoice" onclick="loadPaymentRequestdmc('','1');">
</div>
<?php } ?>

</div>

 
<?php } ?>
<script>
$('#gvoucher').hide();
</script>
<!--<div class="addguestbutton"  onclick="alertspopupopen('action=adddmcpaymentrequest&queryId=<?php echo clean($_GET['id']); ?>&id=','600px','auto');">+ Add Request</div>-->