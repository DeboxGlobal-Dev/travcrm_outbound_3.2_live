<?php 
include "../../../inc.php";
//include "../../../travcrm-dev/inc.php";
// include "../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


// Mausam Code
// $clientType=$_REQUEST['type'];
$refId =$_REQUEST['Refid'];
$responseData = array();
$clientrating=$_REQUEST['rating'];
$serviceId=$_REQUEST['serviceId'];
$clientexperience=addslashes($_REQUEST['experience']);
$date = date('Y-m-d H:i:s');
//$uploadPhoto=$_REQUEST['images'];
$uploadPhoto='';
if($_FILES['images']['name']!=''){ 
$uploadPhoto=$_FILES['images']['name']; 
$uploadPhoto=time().'-'.$uploadPhoto; 
copy($_FILES['images']['tmp_name'],"../dirfiles/".$uploadPhoto);  
}
if($_FILES['images2']['name']!=''){ 
$uploadPhoto2=$_FILES['images2']['name']; 
$uploadPhoto2=time().'-'.$uploadPhoto2; 
copy($_FILES['images2']['tmp_name'],"../dirfiles/".$uploadPhoto);  
}
if($_FILES['images3']['name']!=''){ 
$uploadPhoto3=$_FILES['images3']['name']; 
$uploadPhoto3=time().'-'.$uploadPhoto3; 
copy($_FILES['images3']['tmp_name'],"../dirfiles/".$uploadPhoto);  
}
if($_FILES['images4']['name']!=''){ 
$uploadPhoto4=$_FILES['images4']['name']; 
$uploadPhoto4=time().'-'.$uploadPhoto4; 
copy($_FILES['images4']['tmp_name'],"../dirfiles/".$uploadPhoto);  
}
if($_POST['oldimg']!=''){
$uploadPhoto=addslashes($_POST['oldimg']);
}

$select='*';
$where='referanceNumber="'.$refId.'" order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
$querymasterDetail=mysqli_fetch_array($rs);
$queryid = $querymasterDetail['id'];
$companyId = $querymasterDetail['companyId'];
$clientType = $querymasterDetail['clientType'];
$fromDate = $querymasterDetail['fromDate'];

$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'queryId="'.$queryid.'" and status=1');  
$quotationData=mysqli_fetch_array($rs1);
//$queryId=$quotationData['queryId'];
$quotationId=$quotationData['id'];
$feedBackForm=1;

$namevalue ='queryId="'.$queryid.'",companyId="'.$companyId.'",serviceId="'.$serviceId.'",quotationId="'.$quotationId.'",clientrating="'.$clientrating.'",clientexperience="'.$clientexperience.'",feedbackImage="'.$uploadPhoto.'",feedbackImage2="'.$uploadPhoto2.'",feedbackImage3="'.$uploadPhoto3.'",feedbackImage4="'.$uploadPhoto4.'",fromDate="'.$fromDate.'",feedbackDate="'.$date.'",clientType="'.$clientType.'",feedBackForm="'.$feedBackForm.'"';
$add = addlisting('clientfeedbackmaster',$namevalue); 

if($add==true){
 
 http_response_code(200);   
 $responseData['response'] = array("success" => "true", "imgmessage" => "image uploaded", "msg" => "Thank You For Feedback", "imagedata" => array("url1" => $uploadPhoto, "url2" => $uploadPhoto2, "url3" => $uploadPhoto3, "url4" => $uploadPhoto4));

}else{

 http_response_code(400);
 $responseData['response'] = array("success" => "false", "msg" => "Error!");
}
 echo json_encode($responseData);

?>
