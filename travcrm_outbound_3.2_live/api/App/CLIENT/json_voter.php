<?php 
    include "../../../inc.php";
    // include "../../../travcrm-dev/inc.php";
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
    header('Cache-Control: max-age=900');
    header("Content-Type: application/json");
    
    
    // $guestId =$_REQUEST['guestId'];

    $mobile =$_REQUEST['mobile'];
    $queryId =$_REQUEST['queryId'];

    $img1 = $_FILES['img1']['name'];
    // $img2 = $_FILES['img2']['name'];
    // $img3 = $_FILES['img3']['name'];
    // $img4 = $_FILES['img4']['name'];
    
    // get images url
    
    
    // if($_FILES['img1']['name']!=''){ 
    //     $uploadimg1=$_FILES['img1']['name']; 
    //     $uploadimg1=time().'-'.$uploadimg1; 
    //     copy($_FILES['img1']['tmp_name'],"../../../dirfiles/".$uploadimg1);  
    //     }
    
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
    
    // if(!empty($_FILES['img2']['name'])){
    // $uploadimg2='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img2']['name']);
    // copy($_FILES['img2']['tmp_name'],$uploadimg2);
    // }else{
    // $uploadimg2 = $_POST['userImageOld2'];
    // }
    
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
 
    
    
    
    if($queryId!=''){
        
         $namevalue = 'queryId="' . $queryId . '" and mobile_number="' . $mobile . '"';
  $documenttype = "UPDATE `mice_guestListMaster` SET `voter_attachment` = '$des' ,`voter_status`=1 WHERE $namevalue";
    $fetch = mysqli_query(db(), $documenttype);
    
    // $namevalue = 'queryId="'.$queryId.'",RefId="'.$RefId.'",Image1="'.$uploadimg1.'",Image2="'.$uploadimg2.'",imageType="Voter"';
    // $lasId = addlistinggetlastid('MiceDocApi',$namevalue);
    
    
    $message = ' Voter Images Uploaded Sucessfully';
    
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