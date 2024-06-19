<?php
 


$select='*'; 
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$invoicesetting=mysqli_fetch_array($rs); 

 $latid=decode($_GET['id']);


if($_GET['id']!=''){

$id=clean(decode($_GET['id']));

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(decode($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_VOUCHER_MASTER_,$where); 
$resultinvoicepage=mysqli_fetch_array($rs); 

$invoiceNotes=$resultinvoicepage['invoiceNotes']; 
$payment=$resultinvoicepage['payment']; 

$select1='*';  
$where1='queryid='.$resultinvoicepage['queryId'].' order by id asc'; 
$rs1=GetPageRecord($select1,_QUERYMAILS_MASTER_,$where1); 
$querymailmaster=mysqli_fetch_array($rs1);


$select1='*';  
$where1='id='.$resultinvoicepage['queryId'].''; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
 
$editdescription=clean($editresult['description']);   
$lastId=$editresult['id'];






/*$select1='id';  
$where1='queryid='.$resultinvoicepage['queryId'].' order by id desc'; 
$rs1=GetPageRecord($select1,_PAYMENT_REQUEST_MASTER_,$where1); 
$finalpaymentId=mysqli_fetch_array($rs1);

$select1='*';  
$where1='paymentId='.$finalpaymentId['id'].' order by id asc'; 
$rs1=GetPageRecord($select1,_PAYMENT_SUPPLIER_LIST_MASTER_,$where1); 
$finalPymentList=mysqli_fetch_array($rs1);

$totalgross2333=0;
$thisid='0';
$select2='*';
$where2='paymentId='.$finalpaymentId['id'].' order by id desc'; 
$rs2=GetPageRecord($select2,_PAYMENT_SUPPLIER_LIST_MASTER_,$where2); 
while($listofsupplierssdsdsd=mysqli_fetch_array($rs2)){
$totalgross2333=$totalgross2333+$listofsupplierssdsdsd['suppliertoalcost'];

}*/


}
 
?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#description",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
    <div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
        <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
           
            <td style="padding-right:20px;"><input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox" style="background-color: #dedede;">
  <input name="action" type="hidden" id="action" value="<?php if($_GET['id']!=''){ echo 'savevoucher';} else { echo 'addquery'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
 <div class="col-md-6" style="width:915px;margin: auto;
    border: 1px #ccc solid;
    background-color: #fff;">
          <!-- general form elements -->
          <div class="box box-primary">
<div style="padding:20px;">
 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" align="left"><img src="download/<?php echo $invoicesetting['logo']; ?>" width="200" /></td>
        </tr>
      <tr>
        <td colspan="3" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" style="display:none;">
		
		<strong><?php echo $invoicesetting['companyname']; ?></strong><br />
		<?php echo $invoicesetting['address']; ?><br />
		<strong>Phone:</strong> <?php echo $invoicesetting['phone']; ?><br />
		<?php if($invoicesetting['email']!=''){ ?>
		<strong>Email:</strong> <?php echo $invoicesetting['email']; ?><br />
		<?php } ?>
		<?php if($invoicesetting['website']!=''){ ?>
		<strong>Website:</strong> <?php echo $invoicesetting['website']; ?><?php } ?>		</td>
      </tr>
      <tr>
        <td colspan="3" align="left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" style="display:none;"><div style="color:#999999; padding:10px 0px;">Bill To:</div></td>
      </tr>
      
	  <tr>
        <td colspan="3" align="left"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;">
          <tr>
            <td width="50%"><div class="form-group"  >
                  <label for="exampleInputEmail1">User Type</label> 
				 
				 
            </div></td>
            <td colspan="3" style="padding-left:10px;"> </td>
            </tr>
          
          
        </table></td>
      </tr>
      <tr>
        <td colspan="3" align="left" style="display:none;"><div id="useraddress">
		
		<?php
		

		
		
		
		if($editresult['clientType']==1){
$select4='*';  
 $where4='id='.$editresult['companyId'].''; 
$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4); 
$mobilemailtype='corporate';
}

if($editresult['clientType']==2){
$select4='*';  
 $where4='id='.$editresult['companyId'].''; 
$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
$resultCompany=mysqli_fetch_array($rs4); 
$mobilemailtype='contacts';
}
if($mobilemailtype!=''){
$select4='*';  
$where4='addressType="'.$mobilemailtype.'" and addressParent='.$editresult['companyId'].''; 
$rs4=GetPageRecord($select4,_ADDRESS_MASTER_,$where4); 
$address=mysqli_fetch_array($rs4); 
?>
	 
<strong><?php echo showClientTypeUserName($editresult['clientType'],$editresult['companyId']); ?></strong><br />
		 <?php echo $address['address']; ?><br /> 
		 <strong>Phone: </strong><?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?><br /> 
		 <strong>Email:</strong> <?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?> 
		 <br />
		 <strong>GSTN:</strong> <?php echo $address['gstn']; ?> 

 
		</div> <?php } ?></td>
      </tr>
     
	 
	   
	 
      <tr>
        <td colspan="3" align="left">&nbsp;</td>
      </tr>
      
    </table></td>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" align="right"><div style="font-size:40px; font-weight:normal;">
          <input name="editId" type="hidden" id="editId" value="<?php echo $latid; ?>" />
		   <input name="action" type="hidden" id="action" value="editvouchermain" />
		    <input name="addinvi" type="hidden" id="addinvi" value="<?php if($_REQUEST['id']!=''){ echo '2'; } else { echo '1'; } ?>" />
          VOUCHER</div></td>
        </tr>
      
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="right">
		  <table border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px; display:none;">voucher Date:</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle" style="display:none;"> <div class="input-group date">
                   
                  <input name="fromDate" type="text" class="form-control pull-right " id="fromDate" displayname="Date" value="<?php if($invoicedetails['invoiceDate']!=''){ echo date("m-d-Y", strtotime($invoicedetails['invoiceDate'])); } else { echo date("d-m-Y"); } ?>">
                </div></td>
            </tr>
            
            <tr style="display:none;">
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">voucher Type</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><select id="voucherType" name="voucherType" class="form-control pull-right validate"   autocomplete="off" > 
	<option value="1" selected="selected">Tax Invoice</option>
 <option value="2" >Performa</option>  
</select></td>
            </tr>
            <tr style="display:none;" >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Invoice No. </div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><div class="input-group date">
                   
                  <input name="invoiceNo" type="text" class="form-control pull-right " id="invoiceNo"  value="">
                </div></td>
            </tr>
            <tr style="display:none;"   >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">File No.</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="fileNo" type="text" class="form-control pull-right " id="fileNo"  value=""></td>
            </tr>
            <tr style="display:none;">
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">PO No.</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="poNo" type="text" class="form-control pull-right " id="poNo"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Customer Code</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="customerCode" type="text" class="form-control pull-right " id="customerCode"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Cost Centre</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="costCenter" type="text" class="form-control pull-right " id="costCenter"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">GL No.</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="glno" type="text" class="form-control pull-right " id="glno"  value=""></td>
            </tr>
            <tr style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Group Check In Date</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="groupCheckIn" type="date" class="form-control pull-right " id="groupCheckIn"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Group Check Out </div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="groupCheckOut" type="date" class="form-control pull-right " id="groupCheckOut"  value=""></td>
            </tr>
            <tr  style="display:none;"  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Pax /Room Count</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="pax" type="text" class="form-control pull-right " id="pax"  value=""></td>
            </tr> 
            <tr style="display:none;"   >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px;">Destinations</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><input name="destination" type="text" class="form-control pull-right " id="destination"  value=""></td>
            </tr>
            <tr  >
              <td align="right" valign="middle"><div style="color:#999999; padding:10px 0px; display:none;">Due Date:</div></td>
              <td>&nbsp;</td>
              <td align="left" valign="middle" style="display:none;"><div class="input-group date">
                   
                  <input name="toDate" type="text" class="form-control pull-right " id="toDate" displayname="Due Date" value="<?php if($invoicedetails['dueDate']!=''){ echo date("m-d-Y", strtotime($invoicedetails['dueDate'])); } else { echo date("d-m-Y"); }  ?>">
                </div></td>
            </tr>
            
            <tr style="display:none;">
              <td align="right" valign="middle"><div style="color:#000; font-size:18px; padding:10px 0px;"><strong>Balance Due:</strong></div></td>
              <td>&nbsp;&nbsp;</td>
              <td align="left" valign="middle"><strong><div style="color:#000; font-size:18px; padding:10px 0px;"><?php echo $currency['name']; ?> <span id="balancedue"><?php echo $balancedueVal; ?></span><input name="balancedueVal" type="hidden" id="balancedueVal" value="<?php echo $balancedueVal; ?>" /></div></strong></td>
            </tr>
          </table>		</td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding:10px 0px 5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-radius: 5px; overflow:hidden;">
      <tr>
        <td style="padding:8px; background-color:#353940; color:#fff;">Items</td>
        <td width="10%" align="right"  style="padding:8px; background-color:#353940; color:#fff;"></td>
        <td width="8%" align="right"  style="padding:8px; background-color:#353940; color:#fff;">&nbsp;</td>
      </tr>
      
    </table></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-bottom:10px;"><div style="" id="loadvoucherrate"></div>
	<script>
	function loadvoucherratefunction(){
	$('#loadvoucherrate').load('loadquotationvoucher.php?id=<?php echo $latid; ?>&queryId=<?php echo $resultinvoicepage['queryid']; ?>');
	}
	
	function addloadvoucherratefunction(){
	var name = encodeURIComponent($('#name').val());
	var qty = 1;
	var rate = encodeURIComponent($('#rate').val());
	if(name!='' && qty!='' && rate!=''){
	$('#loadvoucherrate').load('loadquotationvoucher.php?id=<?php echo $latid; ?>&name='+name+'&qty='+qty+'&rate='+rate+'&add=1');
	}
	} 
	
	
	function updateloadvoucherratefunction(id){
	var name = encodeURIComponent($('#editname').val());
	var qty = '1';
	var rate = encodeURIComponent($('#editrate').val());
	if(name!='' && qty!='' && rate!=''){
	$('#loadvoucherrate').load('loadquotationvoucher.php?id=<?php echo $latid; ?>&editname='+name+'&editqty='+qty+'&editrate='+rate+'&updateid='+id+'&update=1');
	}
	} 
	
	
	function dltloadvoucherratefunction(did){ 
	$('#loadvoucherrate').load('loadquotationvoucher.php?id=<?php echo $latid; ?>&did='+did+'&dlt=1');
	} 
	
	function editloadvoucherratefunction(eid){ 
	$('#loadvoucherrate').load('loadquotationvoucher.php?id=<?php echo $latid; ?>&editid='+eid);
	} 
	
	</script>	</td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top">

	</td>
    </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="display:none;"><div class="form-group">
                  <label for="exampleInputPassword1">Notes</label> 
				  <textarea name="invoiceNotes" rows="3" class="form-control" id="invoiceNotes" displayname="Location" autocomplete="off" style="height:100px;"><?php echo strip($invoiceNotes); ?></textarea>
                </div></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="display:none;"><div class="form-group">
                  <label for="exampleInputPassword1">Terms</label> 
				  <textarea name="terms" rows="3" class="form-control" id="terms" displayname="Location" autocomplete="off" style="height:100px;"><?php echo nl2br(strip_tags(stripslashes($invoicesetting['termscondition']))); ?></textarea>
                </div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="display:none;"><div class="form-group">
                  <label for="exampleInputPassword1">Payment</label> 
				  <input name="payment" type="text" class="form-control" id="payment" value="<?php echo strip($payment); ?>" displayname="Location" autocomplete="off" />
                </div></td>
  </tr>
</table>

 
</div>
               
            

               
       
          </div>
          

        </div> 


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo $resultinvoicepage['id']; ?>" />
		<input name="queryId" type="hidden" id="queryId" value="<?php echo $lastId; ?>" />
		 
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
	 
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<script>  

comtabopenclose('linkbox','op2');

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
}



function showDays(firstDate,secondDate){ 
                  var startDay = new Date(firstDate);
                  var endDay = new Date(secondDate);
                  var millisecondsPerDay = 1000 * 60 * 60 * 24;

                  var millisBetween = startDay.getTime() - endDay.getTime();
                  var days = millisBetween / millisecondsPerDay;

                  // Round down.
                  return ( Math.floor(days));

              }

 

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
   
  
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  } 
} 
</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}


.form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	box-sizing: border-box;
}


.btn-default {
    background-color: #f4f4f4;
    color: #444;
    border-color: #ddd;
}

.btn {
    border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 1px solid transparent;padding: 8px;
}

.btn-info {
    background-color: #00c0ef;
    border-color: #00acd6; color:#fff;
}
</style>
<script>
loadvoucherratefunction();
</script>