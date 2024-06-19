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

 $where2 = 'mobile_number="' . $mobile . '" and queryId ="'.$queryId.'" ORDER BY id DESC';
    $rs2 = GetPageRecord('*', 'mice_guestListMaster', $where2);
    $refid = mysqli_fetch_array($rs2);
    
    $guestId = $refid['id'];
    $displayId = makeQueryId($queryId);  //  FH23-24/000001 
    $queryIdFolder = str_replace('/','_',str_replace('-','_',$displayId));
    
    $guestFolder = makeGuestCode($guestId);
    // print_r($guestFolder);die();
       
   if (!empty($_FILES['img1']['name'])) {
        $destinationDirectory = '../../../docFiles/TourCodes/'.$queryIdFolder.'/'.$guestFolder.'/passport/';
        
        $fileExtension = pathinfo($_FILES["img1"]['name'], PATHINFO_EXTENSION);

        // $uploadFileName = time() . str_replace(' ', '', $_FILES['img1']['name']);
        $passport_attachment1 = $destinationDirectory.time().'-passport-'.$guestFolder.'.'.$fileExtension;

        // $uploadimg1 = $destinationDirectory . $uploadFileName;
        
        $passport_attachment = str_replace('../../../', '', $passport_attachment1);
        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }
        if (move_uploaded_file($_FILES['img1']['tmp_name'], $passport_attachment1)) {
            echo "File uploaded successfully: $passport_attachment";
        } else {
            echo "Error uploading file.";
        }
} else {
    $uploadimg1 = $_POST['userImageOld'];
    echo "No file uploaded. Using old image: $uploadimg1";
}

if (!empty($_FILES['img1']['name'])) {
        $destinationDirectory = '../../../docFiles/TourCodes/'.$queryIdFolder.'/'.$guestFolder.'/passport/';
        
        $fileExtension = pathinfo($_FILES["img1"]['name'], PATHINFO_EXTENSION);

        // $uploadFileName = time() . str_replace(' ', '', $_FILES['img1']['name']);
        $passport_attachment2 = $destinationDirectory.time().'-passport-'.$guestFolder.'.'.$fileExtension;

        // $uploadimg1 = $destinationDirectory . $uploadFileName;
        
        $passport_attachment_back = str_replace('../../../', '', $passport_attachment2);
        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }
        if (move_uploaded_file($_FILES['img1']['tmp_name'], $passport_attachment2)) {
            echo "File uploaded successfully: $passport_attachment_back";
        } else {
            echo "Error uploading file.";
        }
} else {
    $uploadimg2 = $_POST['userImageOld'];
    echo "No file uploaded. Using old image: $uploadimg2";
}

if($queryId!=''){
    
     $namevalue = 'queryId="' . $queryId . '" and mobile_number="' . $mobile . '"';
  $documenttype = "UPDATE `mice_guestListMaster` SET `passport_attachment` = '$passport_attachment',`passport_back_attachment`='$passport_attachment_back',`passport_number`='$passportNo',`issue_date`='$issueDate',`expiry_date`='$expDate',`passport_status`=1 WHERE $namevalue";
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