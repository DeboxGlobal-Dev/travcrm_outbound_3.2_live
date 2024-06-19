<?php
ob_start();
include "inc.php";

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_ferryCompanymaster.php" and url="ferryCompanymaster"');
if(mysqli_num_rows($rs)==0){ 

  $namevalue1 ='moduleName="Ferry Master",moduleFile="crm_ferryCompanymaster.php",url="ferryCompanymaster",sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Ferry Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="ferryCompanymaster",status="1",mainmenu="2",modifyBy="37",modifyDate="'.time().'"';
    addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
  }

  // take the permission
  $select='*';
  $where='deletestatus = 0 order by id asc';
  $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
  while($profileclone=mysqli_fetch_array($rs)){
    $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
    addlisting(_PERMISSION_MASTER_,$namevalue3);
  }

  echo "Done, ferryCompanymaster module created<br>";

}else{
  echo "Error, ferryCompanymaster already created<br>";
}




$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_ferryMaster.php" and url="ferryMaster"');
if(mysqli_num_rows($rs)==0){ 

  $namevalue1 ='moduleName="Ferry Master",moduleFile="crm_ferryMaster.php",url="ferryMaster",sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Ferry Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="ferryMaster",status="1",mainmenu="2",modifyBy="37",modifyDate="'.time().'"';
    addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
  }

  // take the permission
  $select='*';
  $where='deletestatus = 0 order by id asc';
  $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
  while($profileclone=mysqli_fetch_array($rs)){
    $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
    addlisting(_PERMISSION_MASTER_,$namevalue3);
  }

  echo "Done, ferryMaster module created<br>";

}else{
  echo "Error, ferryMaster already created<br>";
}





$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_ferryClassmaster.php" and url="ferryClassmaster"');
if(mysqli_num_rows($rs)==0){ 

  $namevalue1 ='moduleName="Ferry Master",moduleFile="crm_ferryClassmaster.php",url="ferryClassmaster",sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Ferry Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="ferryClassmaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
    addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
  }

  // take the permission
  $select='*';
  $where='deletestatus = 0 order by id asc';
  $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
  while($profileclone=mysqli_fetch_array($rs)){
    $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
    addlisting(_PERMISSION_MASTER_,$namevalue3);
  }

  echo "Done, ferryClassmaster module created<br>";

}else{
  echo "Error, ferryClassmaster already created<br>";
}





$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_ferryPricemaster.php" and url="ferryPricemaster"');
if(mysqli_num_rows($rs)==0){ 

  $namevalue1 ='moduleName="Ferry Master",moduleFile="crm_ferryPricemaster.php",url="ferryPricemaster",sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Ferry Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="ferryPricemaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
    addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
  }

  // take the permission
  $select='*';
  $where='deletestatus = 0 order by id asc';
  $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
  while($profileclone=mysqli_fetch_array($rs)){
    $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
    addlisting(_PERMISSION_MASTER_,$namevalue3);
  }

  echo "Done, ferryPricemaster module created<br>";

}else{
  echo "Error, ferryPricemaster already created<br>";
}