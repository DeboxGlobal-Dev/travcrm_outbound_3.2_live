<?php 
include "../inc.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

include('phpqrcode/qrlib.php');

$qrUname = $_POST['qrUname'];
$qc =  $_POST['link'];
$qrImgName = "aamir".rand();

$final="$qrUname.$qc";
$qrs = QRcode::png($final,"QRimage/$qrImgName.png","H","3","3");
$qrimage = $qrImgName.".png";
$workDir = $_SERVER['HTTP_HOST'];
$qrlink = $workDir."/QRimage".$qrImgName.".png";

?>