<?php 
include "inc.php"; 

if($_REQUEST['action']=='loadallstates' && $_REQUEST['countryId']!=''){
    $whereT = 'countryId="'.$_REQUEST['countryId'].'" and status=1 and deletestatus=0 ';
        $result = GetPageRecord('*','stateMaster',$whereT);
        
        while( $getstates = mysqli_fetch_assoc($result)){
            $statesName = $getstates['name'];
            $statesId = $getstates['id'];
            ?>
            <option value="<?php echo $statesId; ?>" <?php if($_REQUEST['selectIdst']==$statesId){ ?> selected="selected" <?php } ?> ><?php echo $statesName; ?></option>
        <?php
        }
    
    }

    if($_REQUEST['action']=='loadallCities' && $_REQUEST['stateId']!=''){
        $where = 'stateId="'.$_REQUEST['stateId'].'" and status=1 and deletestatus=0 ';
            $resultc = GetPageRecord('*','cityMaster',$where);
            
            while( $getcity = mysqli_fetch_assoc($resultc)){
                $cityName = $getcity['name'];
                $cityId = $getcity['id'];
                ?>
                <option value="<?php echo $cityId; ?>" <?php if($_REQUEST['selectIdct']==$cityId){ ?> selected="selected" <?php } ?> ><?php echo $cityName; ?></option>
            <?php
            }
        
        }

?>