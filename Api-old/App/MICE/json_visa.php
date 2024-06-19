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
 //$img2 = $_FILES['img2']['name'];
// $img3 = $_FILES['img3']['name'];
// $img4 = $_FILES['img4']['name'];

// get images url



if(!empty($_FILES['img1']['name'])){
	$uploadimg1='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img1']['name']);
	copy($_FILES['img1']['tmp_name'],$uploadimg1);
}else{
	$uploadimg1 = $_POST['userImageOld'];
}

// if($_FILES['img2']['name']!=''){ 
//     $uploadimg2=$_FILES['img2']['name']; 
//     $uploadimg2=time().'-'.$uploadimg2; 
//     copy($_FILES['img2']['tmp_name'],"../../../dirfiles/".$uploadimg2);  
//     }

// if($_FILES['img3']['name']!=''){ 
//     $uploadimg3=$_FILES['img3']['name']; 
//     $uploadimg3=time().'-'.$uploadimg3; 
//     copy($_FILES['img3']['tmp_name'],"../../../dirfiles/".$uploadimg3);  
//     }

// if($_FILES['img4']['name']!=''){ 
//     $uploadimg4=$_FILES['img4']['name']; 
//     $uploadimg4=time().'-'.$uploadimg4; 
//     copy($_FILES['img4']['tmp_name'],"../../../dirfiles/".$uploadimg4);  
//     }

$select='*';
$where='id="'.$guestId.'" order by id desc';  
$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$queryId=$querydata['queryId2'];
$guestId=$querydata['id'];



if($queryId!=''){
    $namevalue = 'queryId="'.$queryId.'",guestId="'.$guestId.'",image1="'.$uploadimg1.'",imageType="VISA"';
    $lasId = addlistinggetlastid('MiceDocApi',$namevalue);

    $message = 'Visa has been Uploaded Successfully';
    

    if($lasId>0){

        $json_result = '{
            "msg" : "'.$message.'",
            "img1" : "'.$img1.'"
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