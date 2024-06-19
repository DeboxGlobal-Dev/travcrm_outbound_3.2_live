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


$img1 = $_FILES['img1']['name'];
 //$img2 = $_FILES['img2']['name'];
// $img3 = $_FILES['img3']['name'];
// $img4 = $_FILES['img4']['name'];

// get images url
 $where2 = 'mobile_number="' . $mobile . '" and queryId ="'.$queryId.'" ORDER BY id DESC';
    $rs2 = GetPageRecord('*', 'mice_guestListMaster', $where2);
    $refid = mysqli_fetch_array($rs2);
    
    $guestId = $refid['id'];
    $displayId = makeQueryId($queryId);  //  FH23-24/000001 
    $queryIdFolder = str_replace('/','_',str_replace('-','_',$displayId));
    
    $guestFolder = makeGuestCode($guestId);
    // print_r($guestFolder);die();
       
   if (!empty($_FILES['img1']['name'])) {
        $destinationDirectory = '../../../docFiles/TourCodes/'.$queryIdFolder.'/'.$guestFolder.'/covid/';
        
        $fileExtension = pathinfo($_FILES["img1"]['name'], PATHINFO_EXTENSION);

        // $uploadFileName = time() . str_replace(' ', '', $_FILES['img1']['name']);
        $covid_attachment1 = $destinationDirectory.time().'-covid-'.$guestFolder.'.'.$fileExtension;

        // $uploadimg1 = $destinationDirectory . $uploadFileName;
        
        $covid_attachment = str_replace('../../../', '', $covid_attachment1);
        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }
        if (move_uploaded_file($_FILES['img1']['tmp_name'], $covid_attachment1)) {
            echo "File uploaded successfully: $covid_attachment";
        } else {
            echo "Error uploading file.";
        }
        
        if($queryId!=''){
    
    $namevalue = 'queryId="' . $queryId . '" and mobile_number="' . $mobile . '"';
  $documenttype = "UPDATE `mice_guestListMaster` SET `vaccination_certificate` = '$covid_attachment',`vaccination_status`=1 WHERE $namevalue";
    $fetch = mysqli_query(db(), $documenttype);
    
    // $namevalue = 'queryId="'.$queryId.'",RefId="'.$RefId.'",image1="'.$uploadimg1.'",imageType="Vaccin"';
    // $lasId = addlistinggetlastid('MiceDocApi',$namevalue);

    $message = 'Vaccination Certificate Uploaded Sucessfully';
    

    if($fetch){

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
} else {
    $uploadimg1 = $_POST['userImageOld'];
    echo "No file uploaded. Using old image: $uploadimg1";
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





?>