<?php  
include "inc.php"; 

$output = '';
if(isset($_POST["export"]))
{


  $output .= '
   <table border="1" cellpadding="4" cellspacing="0" bordercolor="#E6E6E6" class="display table tablesorter gridtable sortable" id="example">  
                    <tr>  
                        <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:134px;">Tour Id</th>

    <th  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Tour Start Date</th>

    <th  align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Tour End Date</th>


    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;width:120px;">Destination</th>


    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Lead Pax Name</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Mode</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Driver</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important;color:#FFFFFF;width:130px;">Vehicle Name</th>



    <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;width:130px;">Vehicle Allocation</th>


     <th align="center" bgcolor="#57a0a4" class="header" style="background-color:#233a49 !important; color:#FFFFFF;width:130px;">Remark</th>

                    </tr>';


if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
 $datewhere='quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'" )';
}

$daterangeQuery='';
if($_REQUEST['daterange']!=''){ 
  $myString = $_REQUEST['daterange'];
  $myArray = explode(' - ', $myString);  
  $daterangeQuery = 'quotationId in (select id from quotationMaster where status=1 and fromDate BETWEEN "'.date('Y-m-d', strtotime($myArray[0])).'" and "'.date('Y-m-d', strtotime($myArray[1])).'" )' ;
  $datewhere='';
}

if($_REQUEST['destinationId']!=''){

    $destinationId = 'and destinationId="'.$_REQUEST['destinationId'].'"';
}else{

    $destinationId = '  ' ;
}

if($_GET['driverid']!=''){

    $driverId = 'and id in (select transferQuotId from driverAllocationDetails where driverId="'.$_REQUEST['driverid'].'")';
}else{

    $driverId = '  ' ;
}

$rs=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' 1 and queryId in (select id from queryMaster where queryStatus=3) and  '.$datewhere.' '.$daterangeQuery.' '.$destinationId.' '.$driverId.' order by id asc '); 

while($resultlists=mysqli_fetch_array($rs)){  

$rsq=GetPageRecord('*','quotationMaster',' id="'.$resultlists['quotationId'].'" order by id asc '); 

$quotationData=mysqli_fetch_array($rsq); 

$rsquery=GetPageRecord('*','queryMaster',' id="'.$quotationData['queryId'].'" order by id asc '); 

$queryData=mysqli_fetch_array($rsquery);

$selveh='id,carType,model,registrationNo';  

$whereveh='id="'.$resultlists['vehicleModelId'].'"'; 

$rsveh=GetPageRecord($selveh,_VEHICLE_MASTER_MASTER_,$whereveh); 

$vehicalname=mysqli_fetch_array($rsveh);

$rstranfer=GetPageRecord('transferName,transferCategory',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$resultlists['transferNameId'].'" order by id asc '); 

$tranferData=mysqli_fetch_array($rstranfer);

$desName='';

$dest='';

if($resultlists['serviceType']=='transportation'){

  $noOfDay = (strtotime($resultlists['toDate'])-strtotime($resultlists['fromDate']))/(60*60*24);  
  $frmDate = $resultlists['fromDate'];
  if($noOfDay>0)
  {
    for($i=0;$noOfDay>=$i;++$i)
    {
  
      $rsDest = GetPageRecord("cityId",'newquotationdays',' queryId='.$quotationData['queryId'].' and quotationId='.$resultlists['quotationId'].' and srdate="'.$frmDate.'"');
  
      $resListingDest = mysqli_fetch_array($rsDest);
      // $dest .= $frmDate.', ';
      // $dest .= $resListingDest['cityId'].', ';
      $dest .= getDestination($resListingDest['cityId']).',';
  
      $frmDate = date('Y-m-d',strtotime('+1 day',strtotime($frmDate)));
    }  
  
  }
  else
  {
    $rsDest = GetPageRecord("cityId",'newquotationdays',' queryId='.$quotationData['queryId'].' and quotationId='.$resultlists['quotationId'].' and srdate="'.$frmDate.'"');
  
    $resListingDest = mysqli_fetch_array($rsDest);
  
    $dest =getDestination($resListingDest['cityId']);
  }
    

  // $dest='';
// $selectDest='*';
// $whereDest=' queryId='.$resultlists['queryId'].' group by cityId order by srdate asc';
// $rsDest=GetPageRecord($selectDest,'packageQueryDays',$whereDest);
// while($resListingDest=mysqli_fetch_array($rsDest)){  
// $dest.=getDestination($resListingDest['cityId']).', ';  
// }
$desName = rtrim($dest,',');
}
if($resultlists['serviceType']=='transfer'){
$destinationIdq = explode(',',$resultlists['destinationId']); 
$destinationName = "";
foreach ($destinationIdq as $destinationresult) { 
$sele='*';
$whereDest=' id="'.$destinationresult.'" ';   
$rsDest=GetPageRecord($sele,'destinationMaster',$whereDest);
$ddest=mysqli_fetch_array($rsDest);
$destinationName.= $ddest['name'].',';
}
$desName = rtrim($destinationName,',');
}


$selecttime='*';

$wheretime=' quotationId="'.$resultlists['quotationId'].'" and transferQuoteId="'.$resultlists['id'].'" and supplierId="'.$resultlists['supplierId'].'" ';   

$rstimet=GetPageRecord($selecttime,'quotationTransferTimelineDetails',$wheretime);

$dtime=mysqli_fetch_array($rstimet);

$sel='*';
$wherev='transferQuotId = "'.$resultlists['id'].'" order by id desc';
$rsv=GetPageRecord($sel,'driverAllocationDetails',$wherev);
$driverAllocate=mysqli_fetch_array($rsv);

$rsDv=GetPageRecord('*',_DRIVER_MASTER_MASTER_,'1 and id="'.$driverAllocate['driverId'].'"  order by name'); 
$driverData=mysqli_fetch_array($rsDv);

if($driverAllocate['driverId']!='0'){
   $name = $driverData['name'];
   $phone = $driverData['mobile'];
}else{
   $name = $driverAllocate['name'];
   $phone = $driverAllocate['mobileNo'];  
}

$sel='*';
$wherev='transferQuotId = "'.$resultlists['id'].'" and  allocatedStatus=1 order by id desc';
$rsv=GetPageRecord($sel,'quotVhicleDetails',$wherev);
$allocatevahicle=mysqli_fetch_array($rsv);

  $output .= '<tr style="text-align:center;">



    <td  align="center" valign="middle" bgcolor="#FAFDFE">'.makeQueryTourId($queryData['id']).'</td>

    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($resultlists['fromDate'])).'</td>
    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.date('d-m-Y',strtotime($resultlists['toDate'])).'</td>

   <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$desName.'</td>


    <td  align="center" valign="middle" bgcolor="#FAFDFE">'.$queryData['leadPaxName'].'</td>



    <td  align="center" valign="middle" bgcolor="#FAFDFE">'.$tranferData['transferCategory'].'</td>



    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="white-space: nowrap;">'.$name.'<br>'.$phone.'</td>


    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="">'.$vehicalname['model'].'</td>
    <td  align="center" valign="middle" bgcolor="#FAFDFE" style="">'.$allocatevahicle['vehicleName'].'<br>'.$allocatevahicle['registrationNo'].'</td>

    <td  align="center" valign="middle" bgcolor="#FAFDFE" style=""></td>
</tr>';
 
}



 
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Download Driver Report.xls');
  echo $output;
 }

?>
