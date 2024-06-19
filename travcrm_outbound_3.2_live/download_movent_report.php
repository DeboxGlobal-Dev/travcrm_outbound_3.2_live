<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
   <table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" class="display table tablesorter gridtable sortable" id="example">  
                    <tr>  
                         <th width="100" height="30" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF; color:#FFFFFF;">Tour ID</th>



  <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour DATE</th>


  <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">CITY</th>



    <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Type</th>



  <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Agent Name</th>




  <th width="150" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">LEAD PAX NAME</th>



  <th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Total Pax</th>



<th width="100" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">STAY/ACTIVITY</th>

<th width="156" align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;">Tour Manager</th>
                    </tr>';


if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='quotationId in (select id from quotationMaster where status=1 and startDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
}

$daterangeQuery='';
if($_GET['daterange']!=''){ 
  $myString = $_GET['daterange'];
  $myArray = explode(' - ', $myString);  
  $daterangeQuery = 'quotationId in (select id from quotationMaster where status=1 and startDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
  $datewhere='';
}



if($_REQUEST['destinationId']!=''){

    $cityIdserch = ' and destinationId="'.$_REQUEST['destinationId'].'"' ;
}else{

    $cityIdserch = '  ' ;
}

if($_REQUEST['serviceType']!=''){

    $serviceType = 'and serviceType="'.$_REQUEST['serviceType'].'"';
}else{

    $serviceType = ' ' ;
}

if($_REQUEST['leadPaxName']!=''){

    $leadPaxName = 'and queryId in (select id from queryMaster where leadPaxName like "%'.$_REQUEST['leadPaxName'].'%")';
}else{

    $leadPaxName = ' ' ;
}
if($_REQUEST['agentname']!=''){

    $agentname = 'and queryId in (select id from queryMaster where companyId in ( select id from '._CORPORATE_MASTER_.' where name like "%'.$_REQUEST['agentname'].'%") or companyId in ( select id from '._CONTACT_MASTER_.' where firstName like "%'.$_REQUEST['agentname'].'%" or lastName like "%'.$_REQUEST['agentname'].'%" ))';
}else{

    $agentname = ' ' ;
}


$itineryDay=GetPageRecord('*','quotationItinerary','1 and '.$datewhere.' '.$daterangeQuery.' '.$leadPaxName.' '.$agentname.' '.$serviceType.' order by id asc');
 while($itineryDayData = mysqli_fetch_array($itineryDay)){

  if($itineryDayData['serviceType']=='hotel'){

      $rs=GetPageRecord('*','quotationHotelMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc '); 


while($resultlists=mysqli_fetch_array($rs)){  


$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'"  and status=1 order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery);



$rsHotel=GetPageRecord('hotelName','packageBuilderHotelMaster',' id="'.$resultlists['supplierId'].'" order by id asc '); 



$hotelData=mysqli_fetch_array($rsHotel);



 $sele='*';



 $whereDest=' id="'.$resultlists['destinationId'].'" ';   



 $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



 $ddest=mysqli_fetch_array($rsDest);





  $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Stay'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$hotelData['hotelName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>'; }}
 if($itineryDayData['serviceType']=='transfer'){
       $rs=GetPageRecord('*','quotationTransferMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){  






$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery); 



$selveh='carType';  



$whereveh='carType="'.$resultlists['vehicleId'].'"'; 



$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 



$vehicalname=mysqli_fetch_array($rsveh); 


$rsTrnsf=GetPageRecord('transferName,transferCategory','packageBuilderTransportMaster',' id="'.$resultlists['transferNameId'].'" order by id asc '); 



$transferData=mysqli_fetch_array($rsTrnsf);



 



 $sele='*';



 $whereDest=' id="'.$resultlists['destinationId'].'" ';   



 $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



 $ddest=mysqli_fetch_array($rsDest);



$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);
    $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$transferData['transferCategory'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$transferData['transferName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';
}}
if($itineryDayData['serviceType']=='train'){

      $rs=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){  



 ++$no;



$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery); 



 



$rstrain=GetPageRecord('trainName',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$resultlists['trainId'].'" order by id asc '); 



$trainData=mysqli_fetch_array($rstrain);



 



$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);

$sele='*';



 $whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);
     $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Train'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$trainData['trainName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';
}}
if($itineryDayData['serviceType']=='flight'){

      $rs=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.' order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){  

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery); 



 



$rsflight=GetPageRecord('flightName',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$resultlists['flightId'].'" order by id asc '); 



$flightData=mysqli_fetch_array($rsflight);



 



$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


 $sele='*';



 $whereDest=' id="'.$resultlists['destinationId'].'" ';   



 $rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



 $ddest=mysqli_fetch_array($rsDest);

    $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Flight'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$flightData['flightName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';

}}
if($itineryDayData['serviceType']=='entrance'){

$rs=GetPageRecord('*','quotationEntranceMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){   

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery);



 



$rsSight=GetPageRecord('entranceName',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$resultlists['entranceNameId'].'" order by id asc '); 



$entranceDataName=mysqli_fetch_array($rsSight);


$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);
    $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Entrance'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$entranceDataName['entranceName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';

}}
if($itineryDayData['serviceType']=='guide'){

$rs=GetPageRecord('*','quotationGuideMaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){   

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery);



 



$rsGuide=GetPageRecord('*','tbl_guidesubcatmaster',' id="'.$resultlists['guideId'].'" order by id asc '); 



$GuideDataName=mysqli_fetch_array($rsGuide);

$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);
    $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Guide'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$GuideDataName['name'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';

}}if($itineryDayData['serviceType']=='mealplan'){

$rs=GetPageRecord('*','quotationInboundmealplanmaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.' order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){   


$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery);




$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);


$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);
    $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Restaurant'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$resultlists['mealPlanName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';

}}
if($itineryDayData['serviceType']=='activity'){

$rs=GetPageRecord('*','quotationOtherActivitymaster',' 1 and quotationId="'.$itineryDayData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" '.$cityIdserch.'  order by id asc ');  



while($resultlists=mysqli_fetch_array($rs)){   

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 



$quotationData=mysqli_fetch_array($rsq); 



$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 



$queryData=mysqli_fetch_array($rsquery);




$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$resultlists['driverId'].'" order by name'); 



$driverData=mysqli_fetch_array($rsDv);




$sele='*';



$whereDest=' id="'.$resultlists['destinationId'].'" ';   



$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);



$ddest=mysqli_fetch_array($rsDest);

$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'id="'.$resultlists['otherActivityName'].'"');

$otherActivityData=mysqli_fetch_array($rs1);

   $output .= '<tr style="text-align:center;">



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($itineryDayData['startDate'])).'</td>

   <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$ddest['name'].'</td>

    <td align="center" valign="middle" bgcolor="#FAFDFE">'.'Activity'.'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.showClientTypeUserName($queryData['clientType'],$queryData['companyId']).'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['adult'].'</td>



    <td align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$otherActivityData['otherActivityName'].'</td>


    <td align="center" valign="middle" bgcolor="#FAFDFE" style="">'.getUserName($queryData['assignTo']).'</td>
</tr>';

}}


}



 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Daily Movement Report.xls');
  echo $output;
 }

?>
