<?php
include "inc.php"; 
include "config/logincheck.php";  
$id=clean($_REQUEST['id']);


$select='*'; 
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$invoicesetting=mysqli_fetch_array($rs); 

 


if($_REQUEST['add']==1 && $_REQUEST['rate']!='' && $_REQUEST['qty']!=''  && $_REQUEST['name']!=''){ 

	$rate=clean($_REQUEST['rate']);
	$qty=clean($_REQUEST['qty']);
	$name=clean($_REQUEST['name']); 

	$namevalue ='rate="'.$rate.'",qty="'.$qty.'",name="'.$name.'",parentId="'.$id.'"';
	$add = addlisting(_INVOICE_RATE_LIST_MASTER_,$namevalue); 

}



if($_REQUEST['update']==1 && $_REQUEST['editrate']!='' && $_REQUEST['editqty']!=''  && $_REQUEST['editname']!=''){ 

	$updateid=clean($_REQUEST['updateid']);
	$rate=clean($_REQUEST['editrate']);
	$qty=clean($_REQUEST['editqty']);
	$name=clean($_REQUEST['editname']); 

	$namevalue ='rate="'.$rate.'",qty="'.$qty.'",name="'.$name.'"'; 

	$where='id='.$updateid.'';  
	updatelisting(_INVOICE_RATE_LIST_MASTER_,$namevalue,$where);  

}
 
if($_REQUEST['did']!='' && $_REQUEST['dlt']=='1'){ 
	
	$sql_del="delete from "._INVOICE_RATE_LIST_MASTER_."  where id='".$_GET['did']."' and parentId=".$id.""; 
	mysqli_query(db(),$sql_del) or die(mysqli_error(db()));

}


if($id!=''){
?> 


<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-radius: 5px; overflow:hidden;">
     
<?php
$totalcost='0'; 
$no=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='parentId='.$id.' order by id asc';  
$rs=GetPageRecord($select,_INVOICE_RATE_LIST_MASTER_,$where); 
while($resultlists=mysqli_fetch_array($rs)){ 

if($_REQUEST['editid']==$resultlists['id']){
?>
	  <tr>
        <td style="padding:8px 0px; "><input name="editname" type="text" class="form-control" id="editname" value="<?php echo strip($resultlists['name']); ?>" maxlength="150"  autocomplete="off" placeholder="Description"></td>
        <td width="10%" align="right"  style="padding:8px 0px; display:none; "><input name="editrate" type="number" class="form-control" id="editrate" value="1" maxlength="150"   autocomplete="off" placeholder="Rate"></td>
        <td colspan="2" align="right"  style="padding:8px 0px; "><table border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-left:5px;"><button type="button" class="btn btn-info pull-right" onclick="updateloadinvoiceratefunction('<?php echo strip($resultlists['id']); ?>');">Save</button></td>
    <td style="padding-left:5px;"><button type="button" class="btn btn-default" onclick="loadinvoiceratefunction();">Cancel</button></td>
    </tr>
  
</table>  </td>
      </tr>
	  <?php } else { ?>
	  
	  <tr>
        <td style="padding:8px; border-bottom:1px #CCCCCC solid;"><?php echo $no; ?>- <?php echo strip($resultlists['name']); ?></td>
        <td width="10%" align="right"  style="padding:8px; border-bottom:1px #CCCCCC solid; display:none;"> </td>
        <td width="9%" align="right"  style="padding:8px; border-bottom:1px #CCCCCC solid; display:none;"><?php echo $currency['name']; ?> <?php echo $resultlists['rate']*$resultlists['qty']; $totalcost=$totalcost+$resultlists['rate']*$resultlists['qty']; ?></td>
        <td width="8%" align="right"><div class="btn-group" style="float:right;    width: 75px;">
 <button type="button" class="btn btn-default btn-flat" onclick="editloadinvoiceratefunction('<?php echo strip($resultlists['id']); ?>');"><i class="fa fa-pencil"></i></button> 
                       
					   <button type="button" class="btn btn-default btn-flat" onclick="dltloadinvoiceratefunction('<?php echo strip($resultlists['id']); ?>');"><i class="fa fa-trash"></i></button> 
					  
					  
                    </div></td>
	  </tr>
<?php  } $no++; } ?>

<?php
if($no==1){ 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_INVOICE_MASTER_,$where); 
$resultinvoicepage=mysqli_fetch_array($rs);  

$select1='id';  
$where1='queryid='.$resultinvoicepage['queryId'].' and quotationId='.$resultinvoicepage['quotationId'].' order by id desc'; 
$rs1=GetPageRecord($select1,_PAYMENT_REQUEST_MASTER_,$where1); 
$finalpaymentId=mysqli_fetch_array($rs1);

if($finalpaymentId['id']!=''){
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
	}
}


$select1='tourType';  
$where1='id='.$resultinvoicepage['queryId'].' order by id desc'; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
  
$querymain=mysqli_fetch_array($rs1);

	$select1='name';  
	$where1='id='.$querymain['tourType'].' order by id desc'; 
	$rs1=GetPageRecord($select1,_TOUR_TYPE_MASTER_,$where1); 
	$tourtype=mysqli_fetch_array($rs1);
	
	
	$rate=$totalgross2333;
	$qty='1';
	$name=$tourtype['name']; 
	
	$namevalue ='rate="'.$rate.'",qty="'.$qty.'",name="'.$name.'",parentId="'.$id.'"';
	//$add = addlisting(_INVOICE_RATE_LIST_MASTER_,$namevalue); 
	?>
	<script>
	//loadinvoiceratefunction();
	</script>
	<?php
	}
	?>
</table>
	
<?php } ?>

<div class="form-group" style="margin-bottom:0px;">
                   
				 
				  <table width="100%" border="0" cellpadding="5" cellspacing="0" id="additem" style="display:none; margin:10px 0px;">
  <tbody><tr>
    <td width="70%"><input name="name" type="text" class="form-control" id="name" value="" maxlength="150"  autocomplete="off" placeholder="Description"></td>
    <td width="12%" style="display:none;"><input name="qty" type="number" class="form-control" id="qty" value="1" max="200"   autocomplete="off" placeholder="Qty."></td>
    <td width="12%" style=" display:none;"><input name="rate" type="number" class="form-control" id="rate"  max="1000000"   autocomplete="off" placeholder="Rate" value="1"></td>
    <td width="1%" style="padding:0px 5px;"><button type="button" class="btn btn-info pull-right" onclick="addloadinvoiceratefunction();">Save</button></td>
    <td width="0%"><button type="button" class="btn btn-default" onclick="$('#rbutton').show();$('#additem').hide();">Cancel</button></td>
  </tr>
</tbody></table>

 
  <div class="box-footer" style="padding:10px 0px; text-align:left;"> 
			   
                <button type="button" class="btn btn-info pull-right" onclick="$('#additem').show();$('#rbutton').hide();" id="rbutton">+ Line Item</button>
  </div>
</div>
				
				
<script>
$('#subTotalval').val('<?php echo $totalcost; ?>');
$('#subtotal').text('<?php echo $totalcost; ?>');
<?php  if($_REQUEST['editid']==''){ ?>
calculateinvoice();
<?php } ?>
</script>
<?php } ?>

