<?php
include "inc.php"; 
include "config/logincheck.php";  
$queryId=clean($_REQUEST['queryId']);
$quotationId=clean($_REQUEST['quotationId']);
$Id=clean($_REQUEST['Id']);
$sId=clean($_REQUEST['sId']);
$tId=clean($_REQUEST['tId']);
$supnumber=clean($_REQUEST['supnumber']);
$paymentModeId=clean($_REQUEST['paymentModeId']);
$agentCodeId=clean($_REQUEST['agentCodeId']);
$fileNumber=clean($_REQUEST['fileNumber']);
$arrivalById=clean($_REQUEST['arrivalById']);
$departureById=clean($_REQUEST['departureById']);
$specialRequestId=clean($_REQUEST['specialRequestId']);
$DurationTime=($_REQUEST['totalDuration']);
$from=clean($_REQUEST['from']);
$time=clean($_REQUEST['time']);
$transfrom=clean($_REQUEST['transfrom']);
$transtime=clean($_REQUEST['transtime']);
$totalTransDuration=clean($_REQUEST['totalTransDuration']);
$_REQUEST['quotationYes'];
if($_REQUEST['hotel']=='1' && $_REQUEST['quotationYes']=='2'){   
$where='id="'.$Id.'"'; 
 $namevalue ='confirmation="'.$supnumber.'",paymentMode="'.$paymentModeId.'",agentCode="'.$agentCodeId.'",fileNo="'.$fileNumber.'",arrivalBy="'.$arrivalById.'",departureBy="'.$departureById.'",specialRequest="'.$specialRequestId.'"';
updatelisting(_QUOTATION_HOTEL_MASTER_,$namevalue,$where);
}
if($_REQUEST['Sightseeing']=='1' && $_REQUEST['quotationYes']=='2'){   
$where='id="'.$sId.'"'; 
$namevalue ='pickupTime="'.$time.'",pickupFrom="'.$from.'",duration="'.$DurationTime.'"';
updatelisting(_QUOTATION_SIGHTSEEING_MASTER_,$namevalue,$where);

}
if($_REQUEST['transfer']=='1' && $_REQUEST['quotationYes']=='2'){   
$where='id="'.$tId.'"'; 
 $namevalue ='pickupTime="'.$transtime.'",pickupFrom="'.$transfrom.'",duration="'.$totalTransDuration.'"';
updatelisting(_QUOTATION_TRANSFER_MASTER_,$namevalue,$where);
}

if($_REQUEST['hotel']=='1' && $_REQUEST['quotationYes']=='0'){   
$where='id="'.$Id.'"'; 
$namevalue ='confirmation="'.$supnumber.'",paymentMode="'.$paymentModeId.'",agentCode="'.$agentCodeId.'",fileNo="'.$fileNumber.'",arrivalBy="'.$arrivalById.'",departureBy="'.$departureById.'",specialRequest="'.$specialRequestId.'"';
updatelisting(_PACKAGE_QUERY_HOTEL_,$namevalue,$where);
}
if($_REQUEST['Sightseeing']=='1' && $_REQUEST['quotationYes']=='0'){   
$where='id="'.$sId.'"'; 
 $namevalue ='pickupTime="'.$time.'",pickupFrom="'.$from.'",duration="'.$DurationTime.'"';
updatelisting(_PACKAGE_QUERY_SIGHTSEEING_,$namevalue,$where);
}
if($_REQUEST['transfer']=='1' && $_REQUEST['quotationYes']=='0'){   
$where='id="'.$tId.'"'; 
 $namevalue ='pickupTime="'.$transtime.'",pickupFrom="'.$transfrom.'",duration="'.$totalTransDuration.'"';
updatelisting(_PACKAGE_QUERY_TRANSFER_,$namevalue,$where);
}


if($_REQUEST['hotel']=='1' && $_REQUEST['quotationYes']=='1'){   
$where='id="'.$Id.'"'; 
$namevalue ='confirmation="'.$supnumber.'",paymentMode="'.$paymentModeId.'",agentCode="'.$agentCodeId.'",fileNo="'.$fileNumber.'",arrivalBy="'.$arrivalById.'",departureBy="'.$departureById.'",specialRequest="'.$specialRequestId.'"';
updatelisting(_PACKAGE_BUILDER_HOTEL_,$namevalue,$where);
}

if($_REQUEST['Sightseeing']=='1' && $_REQUEST['quotationYes']=='1'){   
$where='id="'.$sId.'"'; 
 $namevalue ='pickupTime="'.$time.'",pickupFrom="'.$from.'",duration="'.$DurationTime.'"';
updatelisting(_PACKAGE_BUILDER_SIGHTSEEING_,$namevalue,$where);
}

?>
