<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


 $output .= '<table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" class="display table tablesorter gridtable sortable" id="example">  
                    <tr>  
                        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:134px;">Hotel Name</th>



    <th  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">CITY</th>


    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;width:120px;">Total Nights</th>


    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Total Rooms</th>





    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Total Night Room</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Amount</th>



    



                    </tr>';
$daterangeQuery = '';
 if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" ' ;
}

if($_REQUEST['destinationId']!=''){

    $destinationId = 'and destinationId="'.$_REQUEST['destinationId'].'"';
}else{

    $destinationId = '  ' ;
}



if($_GET['hotelName']!=''){

  $hotelNames = 'and supplierId="'.$_GET['hotelName'].'"';
}else{

  $hotelNames = '  ' ;
  }

///$rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' 1 '.$agentname.' '.$daterangeQuery.' '.$datewhere.' '.$guideId.' and tariffId!=0 order by quotationId desc '); 
$rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId in (select id from quotationMaster where status=1) and queryId in (select id from queryMaster where queryStatus=3) and supplierId!=0 '.$daterangeQuery.' '.$destinationIds.' '.$roomType.' '.$hotelNames.' order by id asc '); 


while($resultlists=mysqli_fetch_array($rs)){  

 ++$no;


$rsqt=GetPageRecord('*,count(id) as totalnight','quotationHotelMaster',' supplierId="'.$resultlists['supplierId'].'" and quotationId="'.$resultlists['quotationId'].'" order by id asc '); 
$quotationDatates=mysqli_fetch_array($rsqt);

$nights = $quotationDatates['totalnight'];


$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 
$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 





$queryData=mysqli_fetch_array($rsquery);



$rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by id asc '); 



$hotelData=mysqli_fetch_array($rsHotel);



$rsHotelroom=GetPageRecord('name','roomTypeMaster',' id="'.$resultlists['roomType'].'" order by id asc '); 



$hotelroom=mysqli_fetch_array($rsHotelroom);



 $sele='*';



 $whereDest=' id="'.$resultlists['destinationId'].'" ';   



 $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



 $ddest=mysqli_fetch_array($rsDest);

 $totalpax = $queryData['adult']+$queryData['child'];
 $totalHotelRoomCost=0;
 $singlCost=0;
 $doubleCost=0;
 $tripleCost=0;
  $twinCost=0;
 if($queryData['sglRoom']>0){
 	$singlCost += $resultlists['singleoccupancy']*$nights*$queryData['sglRoom'];
 }
 if($queryData['dblRoom']>0){
 	$doubleCost += $resultlists['doubleoccupancy']*$nights*$queryData['dblRoom'];
 }
 if($queryData['tplRoom']>0){
 	$tripleCost += $resultlists['tripleoccupancy']*$nights*$queryData['tplRoom'];
 }
 if($queryData['twinRoom']>0){
 	$twinCost += $resultlists['twinoccupancy']*$nights*$queryData['twinRoom'];
 }
$totalrooms = $queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom']+$queryData['twinRoom'];
 $serviceTax = $quotationData['serviceTax'];

 $totalHotelRoomCost = ($singlCost+$doubleCost+$tripleCost+$twinCost);
 $totalHotelRoomCostwithgst = $totalHotelRoomCost+$totalHotelRoomCost*$serviceTax/100;

 $rs12=GetPageRecord('*',_ROOM_TYPE_MASTER_,'1 and id="'.$resultlists['roomType'].'"'); 
 $editresult2=mysqli_fetch_array($rs12);

  $output .= '<tr style="text-align:center;">



    <td  align="center" valign="middle" bgcolor="#FAFDFE">'.$hotelData['hotelName'].'</td>


    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>



    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$nights.'</td>


    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="">'.$totalrooms.'</td>
    
    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="">'.$totalrooms*$nights.'</td>
    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="">'.$totalHotelRoomCostwithgst.'</td>


</tr>';
 
}
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Hotel Room Night Analysis.xls');
  echo $output;
}


?>