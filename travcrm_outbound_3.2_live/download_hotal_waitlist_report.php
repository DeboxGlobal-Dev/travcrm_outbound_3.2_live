<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
   <table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
                    <tr>  
               <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">S.No</th>
               <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:170px;">TOUR CODE</th>


    
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">CHECK IN DATE</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">CHECK IN OUT</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;"> NIGHTS</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;"> TOTAL PAX</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">SINGLE ROOM</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">DOUBLE ROOM</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">TRIPLE ROOM</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">TOTAL ROOMS</th>
   
                    </tr>';

                    $no=0;   
                    $grandTotalPaxx=0;
                    $totalnightt=0;
                    $sglRoomm=0;
                    $dblRoomm=0;
                    $tplRoomm=0;
                    $totalroomsss=0;
                    
                    if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
                     $datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
                    }
                    
                    $daterangeQuery='';
                    if($_GET['daterange']!=''){ 
                      $myString = $_GET['daterange'];
                      $myArray = explode(' - ', $myString);  
                      $daterangeQuery = 'and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
                      $datewhere='';
                    }
                    
                    /*if($_GET['guideId']!=''){
                    
                        $guideId = 'and id in (select guideQuoteId from guideAllocation where 1 and GuideId="'.$_GET['guideId'].'")' ;
                    }else{
                    
                        $guideId = '  ' ;
                    }*/
                    
                    if($_GET['destinationId']!=''){
                    
                        $destinationIds = 'and destinationId="'.$_GET['destinationId'].'"';
                    }else{
                    
                        $destinationIds = '  ' ;
                    }
                    
                    $rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 and quotationId in (select quotationId  from finalQuotSupplierStatus where status=5) '.$datewhere.' '.$daterangeQuery.' '.$destinationIds.' '.$hotelserch.' and deletestatus=0 and supplierId!=0 group by supplierId order by fromDate desc'); 

                    while($resultlists=mysqli_fetch_array($rs)){
                    
                        $rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
                        $destinationResult=mysqli_fetch_array($rsdes);
                    
                        $rsHots=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$resultlists['supplierId'].'" order by id asc '); 
                        $hotelDatas=mysqli_fetch_array($rsHots);
                    
                        $output .= '<tr style="text-align:center;">
                        <td colspan="3" align="left" style="color: #4CAF4D;"><strong>City Name:&nbsp;&nbsp;'.$destinationResult['name'].' </strong></td>
                        <td colspan="5" align="left" style="color: #4CAF4D;"><strong>Hotel Name:&nbsp;&nbsp;'.$hotelDatas['hotelName'].'</strong></td>
                        
                        </tr>';

$no = 0;
$pax = 0;
$night=0;
$sglRoom=0;
$dblRoom=0;
 $tplRoom=0;
 $totalroomss=0;
///$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' 1 '.$agentname.' '.$daterangeQuery.' '.$datewhere.' '.$guideId.' and tariffId!=0 order by quotationId desc '); 

$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and quotationId  in (select quotationId from finalQuotSupplierStatus where status=5 and deletestatus=0) and destinationId="'.$resultlists['destinationId'].'" and supplierId="'.$resultlists['supplierId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.' group by startDayDate,endDayDate'); 
$countTour = mysqli_num_rows($rsquot);
while($quotationResult=mysqli_fetch_array($rsquot)){
$no++;
$rsHot=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$quotationResult['supplierId'].'" order by id asc '); 
$hotelData=mysqli_fetch_array($rsHot);

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationResult['queryId'].'" order by id asc '); 
$queryData=mysqli_fetch_array($rsquery);
$totalpax = $queryData['adult']+$queryData['child'];
$days = $queryData['night']+1;

$totaldays = $totaldays+$days;

$pax = $pax+$totalpax;

$nights=$queryData['night'];
$night = $night+$nights;


 if($queryData['sglRoom']>0){
 	$singlCost = $resultlists['singleoccupancy']*$nights*$queryData['sglRoom'];
 }
 if($queryData['dblRoom']>0){
 	$doubleCost = $resultlists['doubleoccupancy']*$nights*$queryData['dblRoom'];
 }
 if($queryData['tplRoom']>0){
 	$tripleCost = $resultlists['tripleoccupancy']*$nights*$queryData['tplRoom'];
 }
$totalrooms = $queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom'];
                
$totalroomss=$totalroomss+$totalrooms;
$serviceTax = $quotationData['serviceTax'];
 $totalHotelRoomCost = ($singlCost+$doubleCost+$tripleCost);
 $totalHotelRoomCostwithgst = $totalHotelRoomCost+$totalHotelRoomCost*$serviceTax/100;

 $sglRoom=$sglRoom+$queryData['sglRoom'];
 $dblRoom=$dblRoom+$queryData['dblRoom'];
 $tplRoom=$tplRoom+$queryData['tplRoom'];



 $output .= '<tr style="text-align:center;">
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$no.'</td>
                 <td  align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.makeQueryTourId($queryData['id']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($quotationResult['startDayDate'])).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($quotationResult['endDayDate'])+86400).'</td>
                
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$nights.'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalpax.'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['sglRoom'].'</td>
                  <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['dblRoom'].'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['tplRoom'].'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$totalrooms.'</td>
              
                

           </tr>';


 }

$output .= '<tr style="text-align:center;">
<td colspan="4" align="right" style="color: #4CAF4D;" ><strong>Sub Total</strong></td>
<td colspan="1" align="center" style="color: #4CAF4D;" >'.$night.'</td>
<td colspan="1" align="center" style="color: #4CAF4D;" >'.$pax.'</td>
<td colspan="1" align="center" style="color: #4CAF4D;" >'.$sglRoom.'</td>
<td colspan="1" align="center" style="color: #4CAF4D;" >'.$dblRoom.'</td>
<td colspan="1" align="center" style="color: #4CAF4D;" >'.$tplRoom.'</td>
<td colspan="1" align="center" style="color: #4CAF4D;" >'.$totalroomss.'</td>

           </tr>';
           $grandTotalPaxx = $grandTotalPaxx+$pax; $totalnightt = $totalnightt+$night;  
           $sglRoomm = $sglRoomm+$sglRoom; 
           $dblRoomm = $dblRoomm+$dblRoom;
           $tplRoomm = $tplRoomm+$tplRoom;
           $totalroomsss = $totalroomsss+$totalroomss;
}

$output .= '<tr style="text-align:center;">
                 
                  <td colspan="4" align="right" style="color: #4CAF4D;" ><strong>Grand Total</strong></td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$totalnightt.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$grandTotalPaxx.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$sglRoomm.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$dblRoomm.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$tplRoomm.'</td>
                  <td colspan="1" align="center" style="color: #4CAF4D;" >'.$totalroomsss.'</td>

           </tr>';



 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Tour Registration Report.xls');
  echo $output;
 }

?>
