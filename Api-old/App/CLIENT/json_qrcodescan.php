<?php
include "../../../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, x-prototype-version, x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$mobile = $_REQUEST['mobile'];
print_r($mobile);die();
?>