<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];

$select='*';
$where='masterId="'.$masterid.'" and primaryvalue=1 order by id desc';
$rs=GetPageRecord($select,_EMAIL_MASTER_,$where);
$resListing=mysqli_fetch_array($rs);
$email=$resListing['email'];
$data="OTP Verification";

$otp=rand(1000,9999);
$namevalue ='mobilePin="'.$otp.'"';
$where='id="'.$resListing['masterId'].'"'; 
$update = updatelisting(_CONTACT_MASTER_,$namevalue,$where); 

$mailBodyContent.='</div>
<p>One time Password For Login Authentication is '.$otp.'</p>
</div>';

$headers = 'From: '.$data.'<info@deboxglobal.co.in>'. "\r\n";
//$headers  = "From:travcrm@deboxglobal.co.in \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$issueSubject="";
$issueSubject="Otp";
$mailSent=@mail($email,$issueSubject,$mailBodyContent,$headers);
if($mailSent==TRUE){
    $json_result.= '{
		"otp" : "Otp Sent Successfully."
	},';
}else {
    $json_result.= '{
		"error" : "Please try again."
	},';
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}