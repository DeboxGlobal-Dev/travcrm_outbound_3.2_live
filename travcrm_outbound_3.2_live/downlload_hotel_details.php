<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
   <table border="1" cellpadding="10" cellspacing="0" bordercolor="#E6E6E6" class="" id="example">  
                    <tr>  
                   <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:40px;">S.No</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:170px;">TOUR Code</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Hotel Name</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:200px;">Hotel Group</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Category</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Address</th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;"> <table  cellpadding="0" cellspacing="0" id="example" class="display table tablesorter gridtable sortable">
            <tr>
                <th colspan="4" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Sales Manager</th>
            </tr>
            <tr>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">Name</th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">Contact No </th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">Destination</th>
                <th bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;border-bottom: 0px !important;">Email</th>
            </tr>
        </table></th>

    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Website</th>

     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Checkin Time</th>
                    </tr>';
$datewhere='';
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


$rs=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'1 '.$datewhere.' '.$destinationId.' and destinationId!=0 group by destinationId order by fromDate desc'); 
while($resultlists=mysqli_fetch_array($rs)){

    $rsdes=GetPageRecord('*',_DESTINATION_MASTER_,'id="'.$resultlists['destinationId'].'"'); 
    $destinationResult=mysqli_fetch_array($rsdes);


  $output .= '<tr style="text-align:center;">
   <td colspan="13" align="left" style="color: #4CAF4D;"><strong>City Name:&nbsp;&nbsp;'.$destinationResult['name'].'</strong></td>
</tr>';

$no = 0;

$rsquot=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' 1 and destinationId="'.$resultlists['destinationId'].'" '.$datewhere.''.$daterangeQuery.''.$hotelserch.''); 
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



$rsh=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' id="'.$quotationResult['categoryId'].'"  '); 
$resListingh=mysqli_fetch_array($rsh);

$rsc=GetPageRecord('*',ChainHotelMaster,' id="'.$hotelData['hotelChain'].'"  '); 
$resListingc=mysqli_fetch_array($rsc);



 $output .= '<tr style="text-align:center;">
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$no.'</td>
                 <td  align="left" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.makeQueryTourId($queryData['id']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$hotelData['hotelName'].'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.strip($resListingc['name']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.strip($resListingh['name']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.strip($hotelData['hotelAddress']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;"><table  cellpadding="0" cellspacing="0" >
            <tr>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$resListingu['firstName'].' '.$resListingu['lastName'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$resListingu['phone'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$resListingu['fax'].'</td>
                <td width="10" align="center" valign="middle" bgcolor="#FAFDFE" style="border-bottom: 0px !important;">'.$resListingu['email'].'</td>
            </tr>
        </table></td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.strip($hotelData['url']).'</td>
                 <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$hotelData['checkInTime'].'</td>
                


           </tr>';

 }


}





 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Hotel Details Report.xls');
  echo $output;
 }

?>
