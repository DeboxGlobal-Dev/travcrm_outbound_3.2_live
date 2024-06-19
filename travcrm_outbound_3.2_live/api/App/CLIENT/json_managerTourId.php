<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$mobile = $_REQUEST['mobile'];


if ($mobile != '') {
    $where2 = 'phone="' . $mobile . '" ORDER BY id DESC';
    $rs2 = GetPageRecord('*', 'tbl_guidemaster', $where2);
    $refid = mysqli_num_rows($rs2);

if ($refid > 0) {
 $json_result = '';
    $resListing = mysqli_fetch_assoc($rs2);
    $rs3='SELECT * FROM queryMaster WHERE tourManager="'.$resListing['id'].'"';
    $fetchmanager = mysqli_query(db(), $rs3);
    while ($managerId = mysqli_fetch_assoc($fetchmanager)) {
    $tourId = $managerId['id'];
    $refId = $managerId['referanceNumber'];
    $destinationId= $managerId['destinationId'];
    $array =explode(',',$destinationId);
    $destinationList = '';
    foreach ($array as $id) {
        $destinationList.= getDestination($id) . ', ';
    }
    $res = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId =' . $tourId . ' ORDER BY id ASC');
    $quotationData = mysqli_fetch_assoc($res);
    
    
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
        $json_result.= '{
            "tourid" : "' .$result. '",
            "refid" :  '.json_encode($refId) . ',
           "destination": "'.rtrim($destinationList, ', ').'",
            "tourDate": "'.$tourDate.'",
            "quotationId" : "'.encode($quotationData['id']).'"
        },';
    }
    }
    //   $destinationList = rtrim($destinationList, ', ');
        // print_r($destinationList);

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
?>