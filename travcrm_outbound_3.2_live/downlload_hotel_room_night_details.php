<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
  <table border="1" cellpadding="20" cellspacing="0" bordercolor="#E6E6E6" class="" id="example" width="100%" >  
                    <tr>  
                   <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">S.No</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:170px;">TOUR Code</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Tour Name</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Agent/Client Name</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Pax</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;"> <table  cellpadding="0" cellspacing="0" id="example" class="display table tablesorter gridtable sortable">
            <tr>
                <th colspan="3" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Accommodation</th>
                <th colspan="3" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">FOC</th>
            </tr>
            <tr>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">SGL</th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">DBL </th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">TPL</th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">TWIN</th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">&nbsp;</th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">&nbsp;</th>
            </tr>
        </table></th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Check In Date</th>

     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Check Out Date</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Room</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Nights</th>
    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Room Nights</th>
                    </tr>';

$datewhere ='';                    
if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='and quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'")';
}

if($_REQUEST['hotelId']!=''){

    $hotelserch = ' and supplierId="'.$_REQUEST['hotelId'].'"' ;
}else{

    $hotelserch = '  ' ;
}

if($_REQUEST['destinationId']!=''){

    $destinationId = ' and destinationId="'.$_REQUEST['destinationId'].'"' ;
}else{

    $destinationId = '  ' ;
}


$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 '.$datewhere.''.$daterangeQuery.' '.$destinationId.' and supplierId!=0 group by supplierId order by fromDate desc'); 
while($resultlists=mysqli_fetch_array($rs)){

    $rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
    $destinationResult=mysqli_fetch_array($rsdes);

    $rsHots=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$resultlists['supplierId'].'" order by id asc '); 
    $hotelDatas=mysqli_fetch_array($rsHots);

  $output .= '<tr style="text-align:center;">
    <td colspan="5" align="left" style="color: #4CAF4D;"><strong>City Name:&nbsp;&nbsp;'.$destinationResult['name'].'</strong></td>

      <td colspan="9" align="left" style="color: #4CAF4D;"><strong>Hotel Name:&nbsp;&nbsp;'.$hotelDatas['hotelName'].'</strong></td>
</tr>';

$no = 0;
$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" and supplierId="'.$resultlists['supplierId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.' group by startDayDate,endDayDate'); 
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

$rsu=GetPageRecord('*',_USER_MASTER_,' id="'.$queryData['assignTo'].'"  '); 
$resListingu=mysqli_fetch_array($rsu);


if($quotationResult['startDayDate']!='0000-00-00'){
  $checkindate = date('d-m-Y',strtotime($quotationResult['startDayDate'])); 
}
if($quotationResult['endDayDate']!='0000-00-00'){
  $checkoutdate = date('d-m-Y',strtotime($quotationResult['endDayDate']) + 86400); 
}
$totalrooms = ($queryData['sglRoom']+$queryData['dblRoom']+$queryData['tplRoom']+$queryData['twinRoom']);

 $output .= '<tr style="text-align:center;">
               <td align="center" valign="middle" bgcolor="#FAFDFE">'.$no.'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.makeQueryTourId($queryData['id']).'</td>



     <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$queryData['subject'].'</td>


     <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>

     <td align="center" valign="middle" bgcolor="#FAFDFE">'.$totalpax.'</td>
    
    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><table  cellpadding="0" cellspacing="0" >
            <tr>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$queryData['sglRoom'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$queryData['dblRoom'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$queryData['tplRoom'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$queryData['twinRoom'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"></td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;"></td>
            </tr>
        </table></td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$checkindate.'</td>



     
    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$checkoutdate.'</td>
    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$totalrooms.'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['night'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['night']*$totalrooms.'</td>
                 

           </tr>';

 }


}





 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Hotel Details Report.xls');
  echo $output;
 }

?>
