<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
   <table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
                    <tr>  
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:170px;">TOUR Code</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">LEAD PAX NAME</th>
    
    
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">CITY</th>
    
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">HOTEL NAME</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">ROOM TYPE</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">CHECK IN DATE</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">CHECK OUT DATE</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">AMOUNT</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">STATUS</th>
   
                    </tr>';

                    $no=0;   

                    $daterangeQuery='';
                    
                    if($_GET['daterange']!=''){ 
                    
                    
                    
                        $myString = $_GET['daterange'];
                    
                    
                    
                        $myArray = explode(' - ', $myString);  
                    
                    
                    
                        $daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'"';
                    
                    
                    
                    }else{
                    
                    
                    
                        $daterangeQuery = ' and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" ' ;
                    
                    
                    
                    }
                    
                    if($_GET['destinationId']!=''){
                    
                        $destinationIds = 'and destinationId="'.$_GET['destinationId'].'"';
                    }else{
                    
                        $destinationIds = '  ' ;
                    }
                    
                    if($_GET['hotelId']!=''){
                    
                      $hotelserch = ' and supplierId="'.$_GET['hotelId'].'"' ;
                    }else{
                    
                      $hotelserch = '  ' ;
                    }
                    
                         
                    
                    
                    $rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId in (select id from quotationMaster where status=1)    and queryId in (select id from queryMaster where queryStatus=3) and supplierId!=0 '.$daterangeQuery.' '.$destinationIds.' '.$hotelserch.'  group by startDayDate,endDayDate  order by id asc '); 
                    
                    
                    while($resultlists=mysqli_fetch_array($rs)){  
                    
                     ++$no;
                    
                    $rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by id asc '); 
                    
                    while($hotelData=mysqli_fetch_array($rsHotel)){
                    
                    
                    
                    
                    $rsqt=GetPageRecord('*,count(id) as totalnight','quotationHotelMaster',' supplierId="'.$resultlists['supplierId'].'" and quotationId="'.$resultlists['quotationId'].'"  order by id asc '); 
                    $nights = mysqli_num_rows($rsqt);
                    while($quotationDatates=mysqli_fetch_array($rsqt)){
                    
                    
                     }
                    
                    
                    
                    
                    
                    $rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 
                    $quotationData=mysqli_fetch_array($rsq); 
                    
                    $rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 
                    
                    
                    
                    $queryData=mysqli_fetch_array($rsquery);
                    
                    
                    $status=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$resultlists['quotationId'].'" and deletestatus=0');
                                  
                    ////$status=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$quotationData['quotationId'].'"   order by id asc '); 
                    /////$status=GetPageRecord('*','finalQuotSupplierStatus','supplierId="'.$resultlists['supplierId'].'" and quotationId="'.$resultlists['quotationId'].'"');
                    $supplierStatus=mysqli_fetch_array($status); 
                    
                    
                    $rsHotelroom=GetPageRecord('name','roomTypeMaster',' id="'.$resultlists['roomType'].'" order by id asc '); 
                    
                    
                    
                    $hotelroom=mysqli_fetch_array($rsHotelroom);
                    
                    
                    
                     $sele='*';
                    
                    
                    
                     $whereDest=' id="'.$resultlists['destinationId'].'" ';   
                    
                    
                    
                     $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
                    
                    
                    
                     $ddest=mysqli_fetch_array($rsDest);
                     $singlCost=0;
                     $doubleCost=0;
                     $tripleCost=0;
					 $twinCost=0;
                     $totalpax = $queryData['adult']+$queryData['child'];
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
                     $serviceTax = $quotationData['serviceTax'];
                     $totalHotelRoomCost = ($singlCost+$doubleCost+$tripleCost+$twinCost);
                     $totalHotelRoomCostwithgst = $totalHotelRoomCost+$totalHotelRoomCost*$serviceTax/100;
                    
                     $rs12=GetPageRecord('*',_ROOM_TYPE_MASTER_,'1 and id="'.$resultlists['roomType'].'"'); 
                     $editresult2=mysqli_fetch_array($rs12);
                     ///$statusss= if( $supplierStatus['status']==0){ echo 'PENDING'  ; elseif( $supplierStatus['status']==2){ echo   'REQUESTED';  elseif( $supplierStatus['status']==3){ echo  ' CONFIRM'; } elseif( $supplierStatus['status']==4){ echo 'REJECTED'; } 


 $output .= '<tr style="text-align:center;">
                 
                 <td  align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.makeQueryTourId($queryData['id']).'</td>
           
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['leadPaxName'].'</td>

                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$hotelData['hotelName'].'</td>

                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$editresult2['name'].'</td>


                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($resultlists['startDayDate'])).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($resultlists['endDayDate'])+86400).'</td>
                
                 
                
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.getTwoDecimalNumberFormat($totalHotelRoomCostwithgst).'</td>
                  
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"> '.CONFIRMED.'</td>
                
                

           </tr>';


 } }




 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Hotel Booking Report.xls');
  echo $output;
 }

?>
