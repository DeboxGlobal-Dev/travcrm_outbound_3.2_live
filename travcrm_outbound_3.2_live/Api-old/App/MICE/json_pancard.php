<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$guestId =$_REQUEST['guestId'];
$img1 = $_FILES['img1']['name'];

if(!empty($_FILES['img1']['name'])){
$uploadimg1='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img1']['name']);
copy($_FILES['img1']['tmp_name'],$uploadimg1);
}else{
$uploadimg1 = $_POST['userImageOld'];
}


$select='*';
$where='id="'.$guestId.'" order by id desc';  
$rs=GetPageRecord($select,contactsMaster,$where); 
$querydata=mysqli_fetch_array($rs);
$queryId=$querydata['queryId2'];
$guestId=$querydata['id'];


$rsr=GetPageRecord('*','MiceDocApi','1 and image1!="" and guestId ="'.$_POST['guestId'].'"');

if(mysqli_num_rows($rsr) > 0 ){

 $allreadyfill = 'Your All Ready fill documents';
echo $allreadyfill;
}else{

if($img1==''){
$status="0";
}else{
$status="1";
}



if($queryId!=''){
$namevalue = 'queryId="'.$queryId.'",guestId="'.$guestId.'",Image1="'.$uploadimg1.'",imageType="PAN",imagestatus="'.$status.'"';
$lasId = addlistinggetlastid('MiceDocApi',$namevalue);



$message = 'Images Uploaded Sucessfully';

if($lasId>0){

$json_result = '{
"msg" : "'.$message.'",
"img1" : "'.$img1.'",
"status" : "'.$status.'"

}';
}
}
?>

{
"status":"true",
"results":[<?php echo trim($json_result, ',');?>]
}


<?php
}



?>