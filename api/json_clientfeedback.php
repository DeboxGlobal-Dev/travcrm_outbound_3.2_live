<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$masterid=$_REQUEST['id'];
$clientType=$_REQUEST['type'];
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
if($_POST['oldimg']!=''){
$uploadPhoto=addslashes($_POST['oldimg']);
}

$select='*';
$where='companyId='.$masterid.' and clientType='.$clientType.' and deletestatus=0 order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);
while($querymasterDetail=mysqli_fetch_array($rs)){
    $queryid = $querymasterDetail['id'];
    $companyId = $querymasterDetail['companyId'];
    $clientType = $querymasterDetail['clientType'];
    $fromDate = $querymasterDetail['fromDate'];
}
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$queryid.'"');  
$quotationData=mysqli_fetch_array($rs1);
//$queryId=$quotationData['queryId'];
$quotationId=$quotationData['id'];
$feedBackForm=1;

echo $namevalue ='queryId="'.$queryid.'",companyId="'.$companyId.'",serviceId="'.$serviceId.'",quotationId="'.$quotationId.'",clientrating="'.$clientrating.'",clientexperience="'.$clientexperience.'",feedbackImage="'.$uploadPhoto.'",fromDate="'.$fromDate.'",feedbackDate="'.$date.'",clientType="'.$clientType.'",feedBackForm="'.$feedBackForm.'"';
$add = addlisting('clientfeedbackmaster',$namevalue); 

if($add==true){ 
    http_response_code(200);   
    $responseData['response'] = array("success" => "true", "imgmessage" => "image uploaded", "msg" => "Thank You For Feedback"); 
}else{ 
    http_response_code(400);
    $responseData['response'] = array("success" => "false", "msg" => "Error!");
}
 echo json_encode($responseData);

?>
