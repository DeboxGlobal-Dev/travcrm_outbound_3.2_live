<?php 
ob_start();
include "inc.php"; 
include "config/logincheck.php"; 
?>
<h3 class="cms_title">Payable - Not updated</h3> 
<style>
.reportfilter{
border-right:1px solid #e6e6e6; cursor:pointer;
}

</style>
<div style="padding: 0px 20px;"><table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#f8f8f8" style="font-size: 14px;">
  <tr>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(1);">Next 7 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==2){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(2);">Next 15 Days</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==3){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(3);">This Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==4){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(4);">Next Month</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==5){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(5);">Next 3 Months</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==6){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(6);">Next 6 Months</td>
    <td class="reportfilter" <?php if($_REQUEST['filterId']==7){ ?> style="background: #6ebac7; border-top: 1px solid #e6e6e6; border-bottom: 1px solid #e6e6e6; color: #fff;" <?php } ?> onClick="getSupplierPayableNotUpdatedfun(7);">Next 12 Months</td>
  </tr>
</table>
</div>

                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalQuery">0</div>
                    <div class="text">Total Query </div> 
                </div> 
            
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalPax">0</div>
                    <div class="text">Total Pax </div>
            </div>
             
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalPayable">0</div>
                    <div class="text">Total Payable</div>
            </div>
             
                <div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalBalance">0</div>
                    <div class="text">Total Balance</div>
            </div>
            
                <!--<div class="iconbox">
                     <div style="color: #313131; font-size:28px;" id="totalOverdueReceivable">0</div>
                    <div class="text">Overdue Receivable </div>
            </div>-->
             
				<div class="iconbox">
					<div style="color: #313131; font-size:28px;" id="totalNight">0</div> 
					<div class="text">Total Night </div>
		    </div>
		   
            <div style="border: 1px solid #ccc; padding: 10px; margin: 21px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left"><div style="font:'Courier New', Courier, monospace; font-size:16px; font-weight:400;">Receivable Report : <?php if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ echo date('d-M-Y').' to '.date('d-M-Y', strtotime('+6 days')); } if($_REQUEST['filterId']==2){ echo date('d-M-Y').' to '.date('d-M-Y', strtotime('+14 days')); } if($_REQUEST['filterId']==3){ echo date('01-M-Y').' to '.date('t-M-Y'); } if($_REQUEST['filterId']==4){ echo date('01-M-Y', strtotime('+1 month')).' to '.date('t-M-Y', strtotime('+1 month')); } if($_REQUEST['filterId']==5){ echo date('01-M-Y').' to '.date('t-M-Y', strtotime('+3 month')); } if($_REQUEST['filterId']==6){ echo date('01-M-Y').' to '.date('t-M-Y', strtotime('+6 month')); } if($_REQUEST['filterId']==7){ echo date('01-M-Y').' to '.date('t-M-Y', strtotime('+12 month')); } ?></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td width="20%" align="left" bgcolor="#f8f8f8"><strong>QueryId</strong></td>
    <td width="18%" align="center" bgcolor="#f8f8f8"><strong>Travel Location</strong></td>
    <td width="22%" align="center" bgcolor="#f8f8f8"><strong>Travel Date</strong></td>
    <td width="20%" align="center" bgcolor="#f8f8f8"><strong>Payable</strong></td>
    <td width="20%" align="center" bgcolor="#f8f8f8"><strong>Balance</strong></td>
  </tr>
  <?php
  
$startDate = '';
$endDate = '';
$totalBalance=0;
$totalPayable=0; 
$totalPax=0; 
$totalNight=0; 
$no=0;
  $next7Days='';
  if($_REQUEST['filterId']==1 || $_REQUEST['filterId']==''){ 
	$next7Days=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d', strtotime('+6 days')).'"'; 
  }
  $next15Days='';
  if($_REQUEST['filterId']==2){ 
  	$next15Days=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d', strtotime('+14 days')).'"'; 
  }
  $thisMonth='';
  if($_REQUEST['filterId']==3){ 
  	$thisMonth=' and MONTH(fromDate)="'.date('m').'" and YEAR(fromDate)="'.date('Y').'"'; 
  }
  $nextMonth='';
  if($_REQUEST['filterId']==4){ 
  	$nextMonth=' and MONTH(fromDate)="'.date('m',strtotime('+1 month')).'" and YEAR(fromDate)="'.date('Y').'"'; 
  }
  $next3Month='';
  if($_REQUEST['filterId']==5){  
  	$next3Month=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+3 month')).'"'; 
  }
  $next6Month='';
  if($_REQUEST['filterId']==6){  
  	$next6Month=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+6 month')).'"'; 
  }
  $next12Month='';
  if($_REQUEST['filterId']==7){  
  	$next12Month=' and fromDate between "'.date('Y-m-d').'" and "'.date('Y-m-d',strtotime('+12 month')).'"'; 
  }  
    
  $wherecondition = ' deletestatus=0 and queryStatus=3 and totalQuotCost>0  '.$next7Days.' '.$next15Days.' '.$thisMonth.' '.$nextMonth.' '.$next3Month.' '.$next6Month.' '.$next12Month.' order by id asc';
  $rs1=GetPageRecord('*',_QUERY_MASTER_,$wherecondition);  
  $totalQuery = mysqli_num_rows($rs1);
  while($resultQuery=mysqli_fetch_array($rs1)){
  ++$no;
  $totalPax=$totalPax+($resultQuery['adult']+$resultQuery['child']);
  $totalNight=$totalNight+($resultQuery['night']);
	
	$rsQDD=GetPageRecord('cityId,srdate','packageQueryDays','queryId="'.$resultQuery['id'].'" order by srdate asc'); 
	$resDest=mysqli_fetch_array($rsQDD);

   ?>
  <tr>
    <td align="left">#<?php echo makeInvoiceId($resultQuery['id']); ?></td>
    <td align="center"><?php echo getDestination($resDest['cityId']); ?></td>
    <td align="center"><?php echo date('d-M-Y', strtotime($resDest['srdate'])); ?></td>
    <td align="center"><?php echo $resultQuery['totalQuotCost']; $totalPayable=$totalPayable+$resultQuery['totalQuotCost']; ?></td>
    <td align="center"><?php echo round($resultQuery['totalQuotCost']); $totalBalance=$totalBalance+round($resultQuery['totalQuotCost']); ?></td>
  </tr>
  <?php
 }   

   ?>
  <script>
  $('#totalQuery').text('<?php echo $no; ?>');
  $('#totalPax').text('<?php echo $totalPax; ?>');
  $('#totalPayable').text('<?php echo $totalPayable; ?>');
  $('#totalBalance').text('<?php echo $totalBalance; ?>');
  //$('#totalOverdueReceivable').text('<?php //echo ($totalReceivableOverDue); ?>');
  $('#totalNight').text('<?php echo $totalNight; ?>');
  </script>
</table>
</td>
  </tr>
</table>
</div>
			
<style>
.cmsouter .iconbox {
width:15% !important;
}
</style>