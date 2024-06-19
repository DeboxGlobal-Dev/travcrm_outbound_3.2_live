<?php 
    include "../../../inc.php";
    // include "../../../travcrm-dev/inc.php";
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
    header('Cache-Control: max-age=900');
    header("Content-Type: application/json");
    
    
    $aadharNo =$_REQUEST['aadharNo'];
        $mobile =$_REQUEST['mobile'];
        $queryId =$_REQUEST['queryId'];


        $img1 = $_FILES['img1']['name'];
        // print_r($img1);die();
        // $img2 = $_FILES['img2']['name'];
    // $img3 = $_FILES['img3']['name'];
    // $img4 = $_FILES['img4']['name'];
    
    // get images url
    
    
    // if($_FILES['img1']['name']!=''){ 
    //     $uploadimg1=$_FILES['img1']['name']; 
    //     $uploadimg1=time().'-'.$uploadimg1; 
    //     copy($_FILES['img1']['tmp_name'],"../../../dirfiles/".$uploadimg1);  
    //     }
    
       // Check if img1 file is uploaded
       
        $where2 = 'mobile_number="' . $mobile . '" and queryId ="'.$queryId.'" ORDER BY id DESC';
    $rs2 = GetPageRecord('*', 'mice_guestListMaster', $where2);
    $refid = mysqli_fetch_array($rs2);
    
    $guestId = $refid['id'];
    $displayId = makeQueryId($queryId);  //  FH23-24/000001 
    $queryIdFolder = str_replace('/','_',str_replace('-','_',$displayId));
    
    $guestFolder = makeGuestCode($guestId);
    // print_r($guestFolder);die();
       
    if (!empty($_FILES['img1']['name'])) {
        $destinationDirectory = '../../../docFiles/TourCodes/'.$queryIdFolder.'/'.$guestFolder.'/aadhar/';
        
        $fileExtension = pathinfo($_FILES["img1"]['name'], PATHINFO_EXTENSION);

        // $uploadFileName = time() . str_replace(' ', '', $_FILES['img1']['name']);
        $aadhar_attachment1 = $destinationDirectory.time().'-aadhar-'.$guestFolder.'.'.$fileExtension;

        // $uploadimg1 = $destinationDirectory . $uploadFileName;
        
        $aadhar_attachment = str_replace('../../../', '', $aadhar_attachment1);
        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }
        if (move_uploaded_file($_FILES['img1']['tmp_name'], $aadhar_attachment1)) {
            echo "File uploaded successfully: $aadhar_attachment";
        } else {
            echo "Error uploading file.";
        }
        
        if($queryId!=''){
            $namevalue = 'queryId="' . $queryId . '" and mobile_number="' . $mobile . '"';
            $documenttype = "UPDATE `mice_guestListMaster` SET `aadhar_attachment` = '$aadhar_attachment',`aadhar_number`='$aadharNo',`aadhar_status`=1 WHERE $namevalue";
            $fetch = mysqli_query(db(), $documenttype);
   
            $message = 'Images Uploaded Sucessfully';
            
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
        
    } else {
        $uploadimg1 = $_POST['userImageOld'];
        echo "No file uploaded. Using old image: $aadhar_attachment";
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
    
    // $select='*';
    // $where='id="'.$guestId.'" order by id desc';  
    // $rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
    // $querydata=mysqli_fetch_array($rs);
    // $queryId=$querydata['queryId2'];
    // $guestId=$querydata['id'];
    
    
    
        
        
        ?>