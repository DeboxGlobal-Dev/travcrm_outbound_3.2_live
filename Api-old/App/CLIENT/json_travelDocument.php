<?php
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobRefId = $_REQUEST['refId'];
$mobile = $_REQUEST['mobile'];
$documentType = $_REQUEST['documenttype'];

$json_result = ''; // Initialize JSON result variable

if ($documentType == 'visa' || $documentType == 'flightticket' || $documentType == 'insurance') {
    if ($mobRefId != '' && strlen($mobRefId) > 5) {
        $where4 = 'referanceNumber="' . $mobRefId . '" order by id desc';
        $rs4 = GetPageRecord('*', 'queryMaster', $where4);
        $resListing4 = mysqli_fetch_array($rs4);
        $queryId = $resListing4['id'];

        if ($mobile != "") {
            $where1 = 'mobile_number="' . $mobile . '" and queryId="' . $queryId . '" order by id desc';
            $rs1 = GetPageRecord('*', 'mice_guestListMaster', $where1);
            $refid1 = mysqli_num_rows($rs1);

            if ($refid1 > 0) {
                $resListing1 = mysqli_fetch_array($rs1);

                if ($documentType == 'visa') {
                    $visa1 = $resListing1['visa1_attachment'];
                    $visa2 = $resListing1['visa2_attachment'];
                    $visa3 = $resListing1['visa3_attachment'];

                    $json_result .= '{
                        "mobRefId": "' . $resListing4['referanceNumber'] . '",
                        "queryId": "' . $resListing4['id'] . '",
                        "mobile": "' . $resListing1['mobile_number'] . '",
                        "visa_1": "https://funnfunholidays.in/live/' . $visa1 . '",
                        "visa_2": "https://funnfunholidays.in/live/' . $visa2 . '",
                        "visa_3": "https://funnfunholidays.in/live/' . $visa3 . '"
                    },';
                } elseif ($documentType == 'flightticket') {
                    $flight1 = $resListing1['flightticket1_attachment'];
                    $flight2 = $resListing1['flightticket2_attachment'];
                    $flight3 = $resListing1['flightticket3_attachment'];

                    $json_result .= '{
                        "mobRefId": "' . $resListing4['referanceNumber'] . '",
                        "queryId": "' . $resListing4['id'] . '",
                        "mobile": "' . $resListing1['mobile_number'] . '",
                        "flight_1": "https://funnfunholidays.in/live/' . $flight1 . '",
                        "flight_2": "https://funnfunholidays.in/live/' . $flight2 . '",
                        "flight_3": "https://funnfunholidays.in/live/' . $flight3 . '"
                    },';
                } elseif ($documentType == 'insurance') {
                    $insurance1 = $resListing1['insurance1_attachment'];
                    $insurance2 = $resListing1['insurance2_attachment'];
                    $insurance3 = $resListing1['insurance3_attachment'];

                    $json_result .= '{
                        "mobRefId": "' . $resListing4['referanceNumber'] . '",
                        "queryId": "' . $resListing4['id'] . '",
                        "mobile": "' . $resListing1['mobile_number'] . '",
                        "insurance_1": "https://funnfunholidays.in/live/' . $insurance1 . '",
                        "insurance_2": "https://funnfunholidays.in/live/' . $insurance2 . '",
                        "insurance_3": "https://funnfunholidays.in/live/' . $insurance3 . '"
                    },';
                }
            } else {
                $json_result .= '{
                    "error": "This Mobile No Does Not Match"
                },';
            }
        } else {
            $json_result .= '{
                "error": "Please Enter Mobile No"
            },';
        }
    } else {
        $json_result .= '{
            "error": "This Reference Id Does Not Match"
        },';
    }
} else {
    $json_result .= '{
        "error": "Invalid Document Type"
    },';
}

// Output JSON result
echo '{
    "status": "true",
    "results": [' . rtrim($json_result, ',') . ']
}';
?>
