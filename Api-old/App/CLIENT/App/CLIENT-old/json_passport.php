<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");


$mobile =$_REQUEST['mobile'];
$queryId =$_REQUEST['queryId'];
$issueDate =$_REQUEST['issueDate'];
$expDate =$_REQUEST['expDate'];
$passportNo =$_REQUEST['passportNo'];
// print_r($queryId);die();


$img1 = $_FILES['img1']['name'];
$img2 = $_FILES['img2']['name'];

if (!empty($_FILES['img1']['name'])) {
    $destinationDirectory = '../../../dirfiles/';
    $uploadFileName = time() . str_replace(' ', '', $_FILES['img1']['name']);
    $uploadimg1 = $destinationDirectory . $uploadFileName;
    
    $des = str_replace('../../../', '', $uploadimg1);
    if (!file_exists($destinationDirectory)) {
        mkdir($destinationDirectory, 0755, true);
    }
    if (move_uploaded_file($_FILES['img1']['tmp_name'], $uploadimg1)) {
        echo "File uploaded successfully: $uploadimg1";
    } else {
        echo "Error uploading file.";
    }
} else {
    $uploadimg1 = $_POST['userImageOld'];
    echo "No file uploaded. Using old image: $uploadimg1";
}

if (!empty($_FILES['img2']['name'])) {
    $destinationDirectory2 = '../../../dirfiles/';
    $uploadFileName2 = time() . str_replace(' ', '', $_FILES['img2']['name']);
    $uploadimg2 = $destinationDirectory2 . $uploadFileName2;
    
    $des2 = str_replace('../../../', '', $uploadimg2);
    if (!file_exists($destinationDirectory2)) {
        mkdir($destinationDirectory2, 0755, true);
    }
    if (move_uploaded_file($_FILES['img2']['tmp_name'], $uploadimg2)) {
        echo "File uploaded successfully: $uploadimg2";
    } else {
        echo "Error uploading file.";
    }
} else {
    $uploadimg2 = $_POST['userImageOld'];
    echo "No file uploaded. Using old image: $uploadimg2";
}

if($queryId!=''){
    
     $namevalue = 'queryId="' . $queryId . '" and mobile_number="' . $mobile . '"';
  $documenttype = "UPDATE `mice_guestListMaster` SET `passport_attachment` = '$des',`passport_back_attachment`='$des2',`passport_number`='$passportNo',`issue_date`='$issueDate',`expiry_date`='$expDate',`passport_status`=1 WHERE $namevalue";
    $fetch = mysqli_query(db(), $documenttype);
    
    
    // $namevalue = 'queryId="'.$queryId.'",RefId="'.$RefId.'",image1="'.$uploadimg1.'",passIssueDate="'.$issueDate.'",passExDate="'.$issueDate.'",passportnumber="'.$passportNo.'",imageType="PASSPORT"';
    // $lasId = addlistinggetlastid('MiceDocApi',$namevalue);

    $message = 'Passport Uploaded Sucessfully';
    

    if($fetch){

        $json_result = '{
            "msg" : "'.$message.'",
            "img1" : "'.$img1.'",
            "img2" : "'.$img2.'"
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