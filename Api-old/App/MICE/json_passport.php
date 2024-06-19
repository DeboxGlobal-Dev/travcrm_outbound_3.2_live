<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$guestId =$_REQUEST['guestId'];
$passportno =$_REQUEST['passportno'];
$passissuedate=date("Y-m-d", strtotime($_REQUEST['passissuedate'])); 
$passexdate=date("Y-m-d", strtotime($_REQUEST['passexdate'])); 
$img1 = $_FILES['img1']['name'];

// get images url

if(!empty($_FILES['img1']['name'])){
$uploadimg1='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img1']['name']);
copy($_FILES['img1']['tmp_name'],$uploadimg1);
}else{
$uploadimg1 = $_POST['userImageOld'];
}

$select='*';
$where='id="'.$guestId.'" order by id desc';  
$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$queryId=$querydata['queryId2'];
$guestId=$querydata['id'];



if($queryId!=''){
$namevalue = 'queryId="'.$queryId.'",guestId="'.$guestId.'",image1="'.$uploadimg1.'",passportnumber="'.$passportno.'",passissueDate="'.date("Y-m-d", strtotime($_POST['passissuedate'])).'",passexDate="'.date("Y-m-d", strtotime($_REQUEST['passexdate'])).'",imageType="PASSPORT"';
$lasId = addlistinggetlastid('MiceDocApi',$namevalue);

print_r($namevalue);
exit();
$message = 'Passport Details Uploaded With Image Sucessfully';

if($lasId>0){

$json_result = '{
"msg" : "'.$message.'",
"img1" : "'.$img1.'",
"passportno" : "'.$passportno.'",
"passissueDate" : "'.$passissuedate.'",
"passexDate" : "'.$passexdate.'",
}';
}

?>
{
"status":"true",
"results":[<?php echo trim($json_result, ',');?>]
}

<?php
}

?>