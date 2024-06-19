<?php 
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Content-Type: application/json");

$Id = $_REQUEST['id'];
$message =$_REQUEST['message'];
$mobile =$_REQUEST['mobile'];

if($Id!=""){
    $where='guestid="'.$Id.'", message="'.$message.'", mobile="'.$mobile.'" ,status =1 ';
    $rs =addlisting('chatroom',$where);
    $json_result = array();
   
    if ($rs) {
         $json_result[] = array(
            "message" => "Data insert successfuly!"
        );
       
    } else {
        $json_result[] = array(
            "error" => "Data not inserted"
        );
    }
    
}
echo json_encode(array(
    "status" => "true",
    "result" => $json_result
));

?>
