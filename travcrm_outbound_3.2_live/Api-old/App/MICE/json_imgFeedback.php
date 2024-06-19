<?php 
// include "../../../inc.php";
include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$refId =$_REQUEST['Refid'];
$img1 = $_FILES['img1']['name'];
$img2 = $_FILES['img2']['name'];
$img3 = $_FILES['img3']['name'];
$img4 = $_FILES['img4']['name'];

// get images url


// if($_FILES['img1']['name']!=''){ 
//     $uploadimg1=$_FILES['img1']['name']; 
//     $uploadimg1=time().'-'.$uploadimg1; 
//     copy($_FILES['img1']['tmp_name'],"../../../dirfiles/".$uploadimg1);  
//     }

    if(!empty($_FILES['img1']['name'])){
		$uploadimg1='dirfiles/'.time().str_replace(' ','',$_FILES['img1']['name']);
		copy($_FILES['img1']['tmp_name'],$uploadimg1);
	}else{
		$uploadimg1 = $_POST['userImageOld'];
	}

if($_FILES['img2']['name']!=''){ 
    $uploadimg2=$_FILES['img2']['name']; 
    $uploadimg2=time().'-'.$uploadimg2; 
    copy($_FILES['img2']['tmp_name'],"../../../dirfiles/".$uploadimg2);  
    }

if($_FILES['img3']['name']!=''){ 
    $uploadimg3=$_FILES['img3']['name']; 
    $uploadimg3=time().'-'.$uploadimg3; 
    copy($_FILES['img3']['tmp_name'],"../../../dirfiles/".$uploadimg3);  
    }

if($_FILES['img4']['name']!=''){ 
    $uploadimg4=$_FILES['img4']['name']; 
    $uploadimg4=time().'-'.$uploadimg4; 
    copy($_FILES['img4']['tmp_name'],"../../../dirfiles/".$uploadimg4);  
    }

$select='*';
$where='referanceNumber="'.$refId.'" order by id desc';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$querydata=mysqli_fetch_array($rs);
$queryId=$querydata['id'];



if($queryId!=''){
    $namevalue = 'queryId="'.$queryId.'",RefId="'.$refId.'",feedbackImage="'.$uploadimg1.'",feedbackImage2="'.$uploadimg2.'",feedbackImage3="'.$uploadimg3.'",feedbackImage4="'.$uploadimg4.'",sectionType="ImageFeedback"';
    $lasId = addlistinggetlastid('clientfeedbackmaster',$namevalue);


    $message = 'Images Uploaded Sucessfully';

    if($lasId>0){

        $json_result = '{
            "msg" : "'.$message.'",
            "img1" : "'.$img1.'",
            "img2" : "'.$img2.'",
            "img3" : "'.$img3.'",
            "img4" : "'.$img4.'"
        }';
    }

    ?>
        <?php echo $json_result; ?>
    
    <?php
}

?>