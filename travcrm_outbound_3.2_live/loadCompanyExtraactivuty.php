<?php
include "inc.php"; 

if($_REQUEST['action']=='financeSetting'){
    $dateAdded=time();
    
    $namevalue ='companySettingId="'.addslashes(trim($_REQUEST['id'])).'",markupSerType="'.addslashes(trim($_REQUEST['selectMarkupType'])).'",taxType="'.addslashes(trim($_REQUEST['taxType'])).'",marSerAmount="'.addslashes(trim($_REQUEST['sermarprice'])).'",taxAcmount="'.$_REQUEST['taxprice'].'",financialYear="'.$_REQUEST['financialYear'].'",daterange="'.$_GET['daterange'].'",addedBy="'.addslashes(trim($_SESSION['userid'])).'",dateAdded="'.$dateAdded.'"';
    if($_REQUEST['editid']==''){
        $lastid = addlistinggetlastid('componyFinanceSetting',$namevalue);
    }else{
        $where='id="'.$_REQUEST['editid'].'"';
        $lastid = updatelisting('componyFinanceSetting',$namevalue,$where);
    }

    // $allvaluefinance ='financeYear="'.$_REQUEST['financialYear'].'",daterange="'.$_GET['daterange'].'",status=1, deletestatus=0';
    // $add = addlisting('financeYearMaster',$allvaluefinance);
  
    if(!empty($lastid)){
        ?>
        <script>
          $('#successmessage2').show();
          setTimeout( function(){
              $('#successmessage2').hide();
          }  , 1500 );
        </script>
        <?php 
    }
}




if($_REQUEST['action']=='developerremarks'){
    $dateAdded=time();
    $namevalue ='companySettingId="'.addslashes(trim($_REQUEST['id'])).'",developerName="'.addslashes(trim($_REQUEST['developerName'])).'",remarks="'.addslashes(trim($_REQUEST['remark'])).'",addedBy="'.addslashes(trim($_SESSION['userid'])).'",dateAdded="'.$dateAdded.'"';
    $lastid = addlistinggetlastid('companyDeveloperRemark',$namevalue);
    if(!empty($lastid)){
    ?>
    <script>
    $('#dsuccessmessage').show();
    setTimeout( function(){
      $('#dsuccessmessage').hide();
    }  , 1000 );
    </script>
    <?php }
}



if($_REQUEST['action']=='versioninformation'){
    $dateAdded=time();
    $namevalue ='companySettingId="'.addslashes(trim($_REQUEST['id'])).'",versionNo="'.addslashes(trim($_REQUEST['versionNo'])).'",developerName="'.addslashes(trim($_REQUEST['developerName'])).'",databaseName="'.addslashes(trim($_REQUEST['databaseName'])).'",dateAdded="'.addslashes(trim($_REQUEST['dateAdded'])).'",addedBy="'.addslashes(trim($_SESSION['userid'])).'"';
    if($_REQUEST['editid']==''){
    $lastid = addlistinggetlastid('companyVersionInfoSetting',$namevalue);
    }else{
    $where='id="'.$_REQUEST['editid'].'"';
    $lastid = updatelisting('companyVersionInfoSetting',$namevalue,$where);
    }
    if(!empty($lastid)){
    ?>
    <script>
    $('#vsuccessmessage').show();
    setTimeout( function(){
      $('#vsuccessmessage').hide();
    }  , 1000 );
    </script>
    <?php }
}

if($_REQUEST['action']=='devstatus'){
    $namevalue ='status="'.addslashes(trim($_REQUEST['status'])).'"';
    $where='id="'.$_REQUEST['id'].'"';
    $lastid = updatelisting('companyDeveloperRemark',$namevalue,$where);

    if(!empty($lastid)){
    ?>
    <script>
    <?php if($_REQUEST['status'] == 0){ ?>
       $('changestatus'+'<?php echo $_REQUEST['id']; ?>').html('<input id="status1<?php echo $_REQUEST['id']; ?>" class="status1" value="Accept" type="button" onclick="changestatus('0','<?php echo $_REQUEST['id']; ?>')">');
    <?php } ?>
    <?php if($_REQUEST['status'] == 1){ ?>
       $('changestatus'+'<?php echo $_REQUEST['id']; ?>').val('<input id="status<?php echo $_REQUEST['id']; ?>" class="status1" value="Rejected" type="button" onclick="changestatus('1','<?php echo $_REQUEST['id']; ?>')">');
    <?php } ?>
    </script>
    <?php }
}

?>