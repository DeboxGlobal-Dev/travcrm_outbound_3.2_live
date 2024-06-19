<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{

  if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){

    $fromDate = date('Y-m-d',strtotime($_REQUEST['fromDate']));
    $toDate = date('Y-m-d',strtotime($_REQUEST['toDate']));
   
   }


$outputt = [];
$time   = strtotime($fromDate);
$last   = date('M Y', strtotime($toDate));

do {
$month = date('M Y', $time);
$total = date('t', $time);

$outputt[] = $month;

$time = strtotime('+1 month', $time);
} while ($month != $last);
$xyz = implode(",", $outputt);
$outputt = explode(',', $xyz);
  
foreach ($outputt as $monthY) {
    $headercon .= '<th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:170px;">'.$monthY.'</th>';

} 





  $output .= '
   <table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
      <tr>  
        <th width:100px;"></th>

        <th width:100px;"></th>

         '.$headercon.'
      </tr>';

$datewhere='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';

}


$rsdes=GetPageRecord('*',_DESTINATION_MASTER_,' 1 and countryId!=0 group by countryId order by id asc');
while($resultlists=mysqli_fetch_array($rsdes)){

    $rscom=GetPageRecord('*',_COUNTRY_MASTER_,'1 and id="'.$resultlists['countryId'].'"'); 
    $countryResult=mysqli_fetch_array($rscom);

       foreach ($outputt as $monthY) {

        $months = date('m',strtotime($monthY));
        $years = date('Y',strtotime($monthY));
        $agentAmount = 0;
        $totalppax = 0;
        $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from packageQueryDays where cityId in (select id from destinationMaster where countryId="'.$resultlists['countryId'].'")) and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 
        $countTour = mysqli_num_rows($rsquot);
        while($quotationResult=mysqli_fetch_array($rsquot)){
 
           $rs = GetPageRecord('*', _AGENT_PAYMENT_REQUEST_, 'queryId="' . $quotationResult['queryId'] . '"');
           $agentPaymentRequestData = mysqli_fetch_array($rs);

           $agentAmount = $agentAmount+$agentPaymentRequestData['finalCost'];
           $totalppax = $totalppax+($quotationResult['adult']+$quotationResult['child']);
        }

        
    $agentcontent .= '<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><?php echo $totalppax; ?><hr style="border-top: 1px dashed black;">'.$agentAmount.'</td>';

} 

  $output .= '  <tr style="text-align:center;">

    <td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$countryResult['name'].'</strong></td>

    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">Pax<hr style="border-top: 1px dashed black;">Sale</td>


    '.$agentcontent.'  




    </tr>';

}
 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Tour Registration Report.xls');
  echo $output;
 }

?>
