<?php 
ob_start();
include "inc.php"; 
include "config/logincheck.php"; 
?>
<h3 class="cms_title">Daily Wise Supplier Payment Pending Reports</h3> 

<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet">

<link href="css/datatablec.css" rel="stylesheet">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


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
</script>  
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}
</style>
<form method="get">
<input name="module" id="module" type="hidden" value="accounts">
<input name="sr" id="" type="hidden" value="19">
<div class="" style=" width:100%; margin: 0px 0px 3px 0px;">
  <table width="100%" border="0" cellpadding="10" cellspacing="0">
    <tbody><tr>
      <td width="83%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <!-- <td width="629" align="center">&nbsp;</td> -->
            <td width="252" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody><tr>
            <!-- <td width="629" align="center" >&nbsp;</td> -->
              <td style="padding:0px 0px 0px 5px;">
              <input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 150px; border-radius: 2px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y', strtotime($_REQUEST['fromDate'])).' - '.date('d-m-Y', strtotime($_REQUEST['toDate'])); } ?>" size="100" maxlength="100" placeholder="Query Date"/>
                <select name="supplier" id="assignto" class="topsearchfiledmainselect" style="width:200px; padding: 9px; ">
                <option value="">Supplier Name</option>
                <?php
                  $b=GetPageRecord('id,name',_SUPPLIERS_MASTER_,' 1 and deletestatus=0 and name!="" group by name order by name asc '); 
                  while($suppData=mysqli_fetch_array($b))
                  { ?>
                    <option <?php echo 'value="'.$suppData['id'].'"'; if($_REQUEST['supplier']==$suppData['id']){echo ' selected';} ?>><?=$suppData['name']?></option>';
                  <?php }
                ?>
              </select>
              <select name="contact_person" id="country" class="topsearchfiledmainselect" style="width:200px; padding: 9px; ">
                <option value="">Contact Persion</option>
                <?php
                  $rscon=GetPageRecord('corporateId,contactPerson','suppliercontactPersonMaster','  contactPerson!="" and deletestatus=0 group by contactPerson order by contactPerson  asc'); 
                  while($supContactPerson=mysqli_fetch_array($rscon))
                  {?>
                    <option <?php echo 'value="'.$supContactPerson['corporateId'].'"'; if($_REQUEST['contact_person']==$supContactPerson['corporateId']){echo ' selected';} ?>><?=$supContactPerson['contactPerson']?></option>';
                  <?php }
                ?>
              </select>  
              <input type="submit" name="Submit2" value="Search" class="inptSearcpd" style="width: 100px !important; background-color: #2bb0dd; border: 1px solid #5ba5f0; color: #fff; padding: 10px; text-align: center; border-radius: 2px; cursor:pointer;"> 
            </td>
            <td style="padding:0px 0px 0px 5px;"></td>
                </tr>
            </tbody></table></td>
          </tr>
      </tbody></table></td>
    </tr>
  </tbody></table>
</div>
</form>		   
<div><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">
    <!-- Receivable Report : <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ echo date('d-M-Y', strtotime('-14 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==2){ echo date('d-M-Y', strtotime('-29 days')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==3){ echo date('d-M-Y', strtotime('-3 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==4){ echo date('d-M-Y', strtotime('-6 month')).' to '.date('d-M-Y'); } if($_REQUEST['filterId']==5){ echo date('d-M-Y', strtotime('-12 month')).' to '.date('d-M-Y'); } ?> -->
</div></td>
  </tr>
  <tr>
    <td>
    
    <table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" id="example" class="display table tablesorter gridtable sortable dataTable no-footer" data-page-length="25" style="width: 100%;" role="grid" aria-describedby="example_info">
    <thead>
        <tr>
            <td  align="center" bgcolor="#57a0a4"><strong>S.No</strong></td>
            <td  align="center" bgcolor="#57a0a4"><strong>Tour ID</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Travel Date</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Supplier Name</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Contact Person</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Contact Number</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Total Amount</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Schedule Date</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Schedule Amount</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Pending Amount</strong></td>
            <td align="center" bgcolor="#57a0a4"><strong>Status</strong></td>
        </tr>
    </thead>
    <tbody>
  <?php
  
$startDate = '';
$endDate = '';
$totalpaid=0;
$totalPayment=0;
$totalQueryCost=0;
$totalQueryCostwithoutpercent=0;
$totalReceivableOverDue=0;
$totalReceivableOverDue=0;
$totalamount=0;
$totalBalance=0;
$no=0;
  $whereSupplier='';                
  if(isset($_REQUEST['supplier']) && $_REQUEST['supplier']!='')
    $whereSupplier = ' and supplierId in (select id from suppliersMaster where id="'.$_REQUEST['supplier'].'" )';
  
  $whereContactPerson='';  
  if(isset($_REQUEST['contact_person']) && $_REQUEST['contact_person']!='')
    $whereSupplier = ' and supplierId in (select corporateId from suppliercontactPersonMaster where corporateId="'.$_REQUEST['contact_person'].'" )';
    
$last15Days='';
  if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
	// $last15Days=' and fromDate between "'.date('Y-m-d', strtotime('-14 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last30Days='';
  if($_REQUEST['filterId']==2){ 
  	$last30Days=' and fromDate between "'.date('Y-m-d', strtotime('-29 days')).'" and "'.date('Y-m-d').'"'; 
  }
  $last3Month='';
  if($_REQUEST['filterId']==3){ 
  	  $last3Month=' and fromDate between "'.date('Y-m-d', strtotime('-3 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last6Month='';
  if($_REQUEST['filterId']==4){ 
  	$last6Month=' and fromDate between "'.date('Y-m-d', strtotime('-6 month')).'" and "'.date('Y-m-d').'"'; 
  }
  $last12Month='';
//   if($_REQUEST['filterId']==5){  
  	$last12Month=' and fromDate between "'.date('Y-m-d', strtotime('-12 month')).'" and "'.date('Y-m-d').'"'; 
//   } 
  
  $wherecondition = ' quotationId in ( select id from quotationMaster where queryId in (select id from queryMaster where queryStatus=3) and status=1 '.$last15Days.' '.$last30Days.' '.$last3Month.' '.$last6Month.' '.$last12Month.') '.$whereSupplier.' '.$whereContactPerson.' and totalSupplierCost>0 and deletestatus=0 order by id desc';
  $rs1=GetPageRecord('*','finalQuotSupplierStatus',$wherecondition);  
  $totalQuery = mysqli_num_rows($rs1);
  while($supplierResult=mysqli_fetch_array($rs1)){ 
    $totalCost = 0;
    $paid = 0;
    $totalPending=0;
    $r2=GetPageRecord('*','supplierSchedulePaymentMaster','supplierStatusId="'.$supplierResult['id'].'" and amount!="" and value!=""');
    // $schedulePaymentNum = mysqli_num_rows($r2);
    while($schedulePaymentData = mysqli_fetch_array($r2))
    {
      ++$no;
        
	      $r3=GetPageRecord('amount','supplierPaymentMaster',' supplierStatusId="'.$supplierResult['id'].'" and paymentStatus=1'); 
	      $supplierPaymentData = mysqli_fetch_array($r3);
	      $paid = ($supplierPaymentData['totalpaid']==0)?0:$supplierPaymentData['totalpaid'];
		

      $totalPending = $supplierResult['totalSupplierCost']-$paid;  


      $rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$supplierResult['queryId'].'"'); 
      $queryResult=mysqli_fetch_array($rs);

      $b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierResult['supplierId'].'"'); 
      $suppData=mysqli_fetch_array($b);

      $rscon=GetPageRecord('*','suppliercontactPersonMaster',' corporateId='.$suppData['id'].' and contactPerson!="" and deletestatus=0 order by id asc'); 
      $supContactPerson=mysqli_fetch_array($rscon);

      $r3sd=GetPageRecord('sum(amount) as totalpaid','supplierPaymentMaster',' supplierStatusId = "'.$supplierResult['id'].'" and paymentStatus=1 '); 
      $supplierPaymentData = mysqli_fetch_array($r3sd);

      echo  '<tr>';
      echo '<td align="left">'.$no.'</td>';    
      echo '<td align="left">'.makeQueryTourId($queryResult['id']).'</td>';
      echo '<td align="left">'.showdate($queryResult['fromDate']).'</td>';
      echo '<td align="left">'.$suppData['name'].'</td>';
      echo '<td align="left">'.strip($supContactPerson['contactPerson']).'</td>';
      echo '<td align="left">'.strip($supContactPerson['phone']).'</td>';
      echo '<td align="left">'.$supplierResult['totalSupplierCost'].'</td>';
      echo '<td align="center">'.$schedulePaymentData['dueDate'].'</td>';
  
      // <td align="center">$totalPaidAmount</td>
      echo '<td align="center">'.$schedulePaymentData['amount'].'</td>';
      echo '<td align="center"></td>';
      echo '<td align="center"></td>';
      // echo '<td align="center">'.$totalBalance.'</td>';
      // echo '<td align="center">'.$totalSupplierCost.'</td>';
      
      echo '</tr>';
      
    }   
  }         
?>    
</tbody>
</table>   
  <script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable(
      {
        dom: 'Bfrtilp',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'pdfHtml5'
            ],
          language: { 
          search: "Search: ",
          searchPlaceholder: "Agent , Country , Pax , Amount",
        },            
      }
    );
} );
</script>

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
</script>


</td>
  </tr>
</table>
</div>
	<style>
.cmsouter .iconbox {
width:20% !important;
}
</style>		
	