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
        <th bgcolor="#FAFDFE" width:100px;">Destination</th>

        <th bgcolor="#FAFDFE" width:100px;">Hotel Name</th>
        <th bgcolor="#FAFDFE" width:100px;">Room Type</th>

         '.$headercon.'
      </tr>';

$datewhere='';
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';

}

$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 '.$datewhere.''.$daterangeQuery.'  and supplierId!=0 group by supplierId order by fromDate desc'); 
    while($resultlists=mysqli_fetch_array($rs)){
    
        $rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
        $destinationResult=mysqli_fetch_array($rsdes);
    
        
      $rsHots=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$resultlists['supplierId'].'" order by id asc '); 
      $hotelDatas=mysqli_fetch_array($rsHots);


       foreach ($outputt as $monthY) {

        $months = date('m',strtotime($monthY));
        $years = date('Y',strtotime($monthY));
        $agentAmount = 0;
        $totalppax = 0;
        $rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" and supplierId="'.$resultlists['supplierId'].'" and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 

        //        $rsquot=GetPageRecord('*',_QUOTATION_MASTER_,' 1 and queryId in (select queryId from packageQueryDays where cityId in (select id from destinationMaster where destinationId="'.$destinationResult['destinationId'].'")) and status=1 and month(fromDate) ="'. $months.'" and  year(fromDate) ="'.$years.'"'); 
                $countTour = mysqli_num_rows($rsquot);
                while($quotationResult=mysqli_fetch_array($rsquot)){
         
        
        
                   $rsHot=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$quotationResult['supplierId'].'" order by id asc '); 
                   $hotelData=mysqli_fetch_array($rsHot);
        
                   
                  $rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
                  $queryData=mysqli_fetch_array($rsquery);
                  
                  $totalrooms = $queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom']+$queryData['twinRoom'];
        }

    
        $output1 .= '<td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['sglRoom'].' <br> '.$queryData['dblRoom'].' <br> '.$queryData['tplRoom'].' <br> '.$queryData['twinRoom'].' <br> '.$totalrooms.'</td>';
    }


  $output .= '  <tr style="text-align:center;">

    <td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$destinationResult['name'].'</strong></td>
    <td align="center" valign="middle" bgcolor="#FAFDFE"><strong>'.$hotelDatas['hotelName'].'</strong></td>

    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"> Single  <br> Double<br> Triple<br> Twin <br>  Total </td>


      '.$output1.'
    



    </tr>';

}
 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Hotel Room Night Analysis.xls');
  echo $output;
 }

?>
