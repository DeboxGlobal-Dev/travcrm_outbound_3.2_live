<?php 
include "../../../inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');   
header("Content-Type: application/json");

if (isset($_REQUEST['guestId']) && isset($_REQUEST['year'])) {
    $guestId = $_REQUEST['guestId'];
    $year = $_REQUEST['year'];

    if (!empty($guestId) && !empty($year)) {
        $select1 = '*';  
        $where1 = 'id = ' . $guestId; 
        $rs1 = GetPageRecord($select1, 'userMaster', $where1); 
        $editresult = mysqli_fetch_array($rs1);

        $queryId = clean($editresult['id']);
        
        $select2 = '*';  
        $where2 = 'assign_to = ' . $editresult['id'] . ' AND year = "' . $year . '"';
        $res3 = GetPageRecord($select2, 'target', $where2);

        $json_result = [];

        while ($quotationData = mysqli_fetch_assoc($res3)) {
            // Extract data here and format it as needed
            $jan = clean($quotationData['January']);
            $achieved_jan = clean($quotationData['achieved']);
            $unachieved_jan = clean($quotationData['unachieved']);
            
            $feb=clean($quotationData['February']);
        	$achieved_feb=clean($quotationData['achieved']);
        	$unachieved_feb=clean($quotationData['unachieved']);
        	
        	$march=clean($quotationData['March']);
        		$achieved_march=clean($quotationData['achieved']);
        	$unachieved_march=clean($quotationData['unachieved']);
        	
        	$april=clean($quotationData['April']);
        		$achieved_april=clean($quotationData['achieved']);
        	$unachieved_april=clean($quotationData['unachieved']);
        	
        	$may=clean($quotationData['May']);
        		$achieved_may=clean($quotationData['achieved']);
        	$unachieved_may=clean($quotationData['unachieved']);
        	
        	$june=clean($quotationData['June']);
        		$achieved_june=clean($quotationData['achieved']);
        	$unachieved_june=clean($quotationData['unachieved']);
        	
        	$july=clean($quotationData['July']);
        		$achieved_july=clean($quotationData['achieved']);
        	$unachieved_july=clean($quotationData['unachieved']);
        	
        	$aug=clean($quotationData['August']);
        		$achieved_aug=clean($quotationData['achieved']);
        	$unachieved_aug=clean($quotationData['unachieved']);
        	
        	$sep=clean($quotationData['September']);
        		$achieved_sep=clean($quotationData['achieved']);
        	$unachieved_sep=clean($quotationData['unachieved']);
        	
        	$oct=clean($quotationData['October']);
        		$achieved_oct=clean($quotationData['achieved']);
        	$unachieved_oct=clean($quotationData['unachieved']);
        	
        	$nov=clean($quotationData['November']);
        		$achieved_nov=clean($quotationData['achieved']);
        	$unachieved_nov=clean($quotationData['unachieved']);
        	
        	$des=clean($quotationData['December']);
        		$achieved_des=clean($quotationData['achieved']);
        	$unachieved_des=clean($quotationData['unachieved']);

            // Add more data as needed

            $json_result[] = [
                "target Jan" => $jan,
                "achieved Jan" => $achieved_jan,
                "unachieved Jan" => $unachieved_jan,
                
                "target feb" => "'.$feb.'",
                "achieved feb" => "'.$achieved_feb.'",
                "unachieved feb" => "'.$unachieved_feb.'",
                
                 "target march" => "'.$march.'",
                "achieved march" => "'.$achieved_march.'",
                "unachieved march" => "'.$unachieved_march.'",

                 "target april" => "'.$april.'",
                "achieved april" => "'.$achieved_april.'",
                "unachieved april" => "'.$unachieved_april.'",
                
                 "target may" => "'.$may.'",
                "achieved may" => "'.$achieved_may.'",
                "unachieved may" => "'.$unachieved_may.'",
        
                 "target june" => "'.$june.'",
                "achieved june" => "'.$achieved_june.'",
                "unachieved june" => "'.$unachieved_june.'",
                
                
                "target july" => "'.$july.'",
                "achieved july" => "'.$achieved_july.'",
                "unachieved july" => "'.$unachieved_july.'",
                
                "target Aug" => "'.$aug.'",
                "achieved Aug" => "'.$achieved_aug.'",
                "unachieved Aug" => "'.$unachieved_aug.'",
                
               
                "target Sep" => "'.$sep.'",
                "achieved Sep" => "'.$achieved_sep.'",
                "unachieved Sep" => "'.$unachieved_sep.'",
                
                "target Oct" => "'.$oct.'",
                "achieved Oct" => "'.$achieved_oct.'",
                "unachieved Oct" => "'.$unachieved_oct.'",
                
                "target Nov" => "'.$nov.'",
                "achieved Nov" => "'.$achieved_nov.'",
                "unachieved Nov" => "'.$unachieved_nov.'",
                
                 "target Dec" => "'.$des.'",
                "achieved Dec" => "'.$achieved_des.'",
                "unachieved Dec" => "'.$unachieved_des.'",
                
                
                
                
            ];
        }

        $response = [
            "status" => "true",
            "results" => $json_result
        ];

        echo json_encode($response);
    } else {
        $json_result = [
            "error" => "Please provide valid guestId and year"
        ];

        $response = [
            "status" => "false",
            "results" => $json_result
        ];

        echo json_encode($response);
    }
} else {
    $json_result = [
        "error" => "Missing guestId or year in request"
    ];

    $response = [
        "status" => "false",
        "results" => $json_result
    ];

    echo json_encode($response);
}
?>
