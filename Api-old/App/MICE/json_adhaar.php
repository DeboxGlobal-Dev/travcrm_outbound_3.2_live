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
    $img2 = $_FILES['img2']['name'];
    // $img3 = $_FILES['img3']['name'];
    // $img4 = $_FILES['img4']['name'];
    
    // get images url
    
    
    // if($_FILES['img1']['name']!=''){ 
    //     $uploadimg1=$_FILES['img1']['name']; 
    //     $uploadimg1=time().'-'.$uploadimg1; 
    //     copy($_FILES['img1']['tmp_name'],"../../../dirfiles/".$uploadimg1);  
    //     }
    
    if(!empty($_FILES['img1']['name'])){
    $uploadimg1='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img1']['name']);
    copy($_FILES['img1']['tmp_name'],$uploadimg1);
    }else{
    $uploadimg1 = $_POST['userImageOld'];
    }
    
    if(!empty($_FILES['img2']['name'])){
    $uploadimg2='../../../dirfiles/'.time().str_replace(' ','',$_FILES['img2']['name']);
    copy($_FILES['img2']['tmp_name'],$uploadimg2);
    }else{
    $uploadimg2 = $_POST['userImageOld2'];
    }
    
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
    $rs=GetPageRecord($select,contactsMaster,$where); 
    $querydata=mysqli_fetch_array($rs);
    $queryId=$querydata['queryId2'];
    $guestId=$querydata['id'];
    
    
    
    if($img1=='' && $img2=='' ){
         $status="0";
    }else{
        $status="1";
    }
    
        

    
    
    if($queryId!=''){
    $namevalue = 'queryId="'.$queryId.'",guestId="'.$guestId.'",Image1="'.$uploadimg1.'",Image2="'.$uploadimg2.'",imageType="Adhaar",imagestatus="'.$status.'"';
    $lasId = addlistinggetlastid('MiceDocApi',$namevalue);

    
    
    $message = 'Images Uploaded Sucessfully';
    
    if($lasId>0){
    
    $json_result = '{
    "msg" : "'.$message.'",
    "img1" : "'.$img1.'",
    "img2" : "'.$img2.'",
    "status" : "'.$status.'"
    
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