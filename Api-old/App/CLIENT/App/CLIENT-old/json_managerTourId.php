<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$mobile = $_REQUEST['mobile'];
// print_r($mobile);die();

if ($mobile != '') {
    $where2 = 'phone="' . $mobile . '" ORDER BY id DESC';
    $rs2 = GetPageRecord('*', 'tbl_guidemaster', $where2);
    $refid = mysqli_num_rows($rs2);

if ($refid > 0) {
$resListing = mysqli_fetch_array($rs2);
$rs3 = 'SELECT * FROM queryMaster WHERE tourManager="' .$resListing['id'] . '"';
    $fetchmanager = mysqli_query(db(), $rs3);
    $tourIds = array();
    $refId ="";
    $json_result = '';
    $tdestination="";
    $tourfromDate='';
    $tourtoDate='';

       while ($managerId = mysqli_fetch_assoc($fetchmanager)) {
    $tourId = $managerId['id'];
    $refId = $managerId['referanceNumber'];

    $res = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId =' . $tourId . ' ORDER BY id ASC');
    $quotationData = mysqli_fetch_assoc($res);
    
    $tdestination.= stripslashes(getDestination($managerId['destinationId'])).', ';
    
    if($managerId['fromDate']!='0' && $managerId['fromDate']!='' && $managerId['fromDate']!='0000-00-00'){
        $tourfromDate=date('d M Y',strtotime($managerId['fromDate']));
        }
        if($managerId['toDate']!='0' && $managerId['toDate']!='' && $managerId['toDate']!='0000-00-00'){
        $tourtoDate=date('d M Y',strtotime($managerId['toDate']));
        }
        $tourDate = $tourfromDate.' to '.$tourtoDate;

    if ($quotationData) {
        $quotationDataId = $quotationData['queryId'];
        $result = makeQueryTourId($quotationDataId);
        $json_result .= '{
            "tourid" : "' .$result. '",
            "refid" :  '.json_encode($refId) . ',
           "destination": "'.rtrim($tdestination, ', ').'",
            "tourDate": "'.$tourDate.'"
        },';
    }
}
    } else {
        $json_result .= '{
            "error" : "This Mobile No Does Not Match"
        }';
    }
} else {
    $json_result .= '{
        "error" : "Please Enter Mobile No"
    }';
}

if (!empty($json_result)) {
    echo '{
        "status": "true",
        "results": [' . trim($json_result, ',') . ']
    }';
} else {
    echo '{
        "status": "false",
        "error": "No tour data found for the given mobile number"
    }';
}
