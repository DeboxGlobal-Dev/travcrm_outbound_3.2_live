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

// SAC code master module here
$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_sacCodeMaster.php" and url="sacCodeMaster"');
if(mysqli_num_rows($rs)==0){ 

  $namevalue1 ='moduleName="SAC Code Master",moduleFile="sacCodeMaster.php",url="sacCodeMaster",sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="SAC Code Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="sacCodeMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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

  echo "Done, sacCodeMaster module created<br>";

}else{
  echo "Error, sacCodeMaster already created<br>";
}


// Proposal Settings Master Module

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_proposalsettings.php" and url="proposalsettings"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Proposal Settings Master",moduleFile="crm_proposalsettings.php",url="proposalsettings",sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Proposal Settings Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="proposalsettings",status="1",mainmenu="2",modifyBy="37",modifyDate="'.time().'"';
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

  echo "Done, proposalsettings module created<br>";

}else{
  echo "Error, proposalsettings already created<br>";
}

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_additionalHotelMaster.php" and url="additionalHotelMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Additional Hotel Master",moduleFile="crm_additionalHotelMaster.php",url="additionalHotelMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Additional Hotel Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="additionalHotelMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, additionalHotelMaster module created<br>";
}else{
  echo "Error, additionalHotelMaster already created<br>";
}

// Room Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_roomMaster.php" and url="roomMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Room Master",moduleFile="crm_roomMaster.php",url="roomMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Room Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="roomMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, RoomMaster module created<br>";
}else{
  echo "Error, RoomMaster already created<br>";
}



// Expense Type Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_expenseType.php" and url="expenseType"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Expense Type",moduleFile="crm_expenseType.php",url="expenseType", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Expense Type",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="expenseType",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, expenseType module created<br>";
}else{
  echo "Error, expenseType already created<br>";
}



// Expense Head Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_expenseHead.php" and url="expenseHead"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Expense Head",moduleFile="crm_expenseHead.php",url="expenseHead", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Expense Head",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="expenseHead",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, expenseHead module created<br>";
}else{
  echo "Error, expenseHead already created<br>";
}


// Visa Type Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_visatype.php" and url="VISAtype"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="VISA Type Master",moduleFile="crm_visatype.php",url="VISAtype", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="VISA Type Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="VISAtype",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, VISA Type Master module created<br>";
}else{
  echo "Error, VISA Type Master already created<br>";
}



// Visa Type Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_visacostmaster.php" and url="visacostmaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="VISA Cost Master",moduleFile="crm_visacostmaster.php",url="visacostmaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="VISA Cost Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="visacostmaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, VISA Cost module created<br>";
}else{
  echo "Error, VISA Cost module already created<br>";
}

// Insurance Type Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_insurancetype.php" and url="insuranceType"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Insurance Type Master",moduleFile="crm_insurancetype.php",url="insuranceType", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Insurance Type Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="insuranceType",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Insurance Type module created<br>";
}else{
  echo "Error, Insurance Type module already created<br>";
}


// Insurance Cost Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_insurancecostmaster.php" and url="insurancecostmaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Insurance Cost Master",moduleFile="crm_insurancecostmaster.php",url="insurancecostmaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Insurance Cost Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="insurancecostmaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Insurance Cost module created<br>";
}else{
  echo "Error, Insurance Cost module already created<br>";
}


// Passport Type Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_passportTypeMaster.php" and url="passportTypeMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Passport Type Master",moduleFile="crm_passportTypeMaster.php",url="passportTypeMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Passport Type Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="passportTypeMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Passport Type module created<br>";
}else{
  echo "Error, Passport Type module already created<br>";
}

// Poassport Cost Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_passportCostMaster.php" and url="passportCostMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Passport Cost Master",moduleFile="crm_passportCostMaster.php",url="passportCostMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Passport Cost Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="passportCostMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Passport Cost module created<br>";
}else{
  echo "Error, Passport Cost module already created<br>";
}


// Commission Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_commissionMaster.php" and url="commissionMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Commission Master",moduleFile="crm_commissionMaster.php",url="commissionMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Commission Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="commissionMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Commission Master module created<br>";
}else{
  echo "Error, Commission Master already created<br>";
}

// Cruise Name Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_cruiseNameMaster.php" and url="cruiseNameMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Cruise Name Master",moduleFile="crm_cruiseNameMaster.php",url="cruiseNameMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Cruise Name Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="cruiseNameMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Cruise Name Master created<br>";
}else{
  echo "Error, Cruise Name Master already created<br>";
}

// Template Voucher Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_voucherTemplates.php" and url="voucherTemplates"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Voucher Templates",moduleFile="crm_voucherTemplates.php",url="voucherTemplates", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Voucher Templates",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="voucherTemplates",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Voucher Template module created<br>";
}else{
  echo "Error, Voucher Template already created<br>";
}

// System Configuration Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_systemConfiguration.php" and url="systemConfiguration"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="System Configuration",moduleFile="crm_systemConfiguration.php",url="systemConfiguration", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="System Configuration",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="systemConfiguration",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, System Configuration module created<br>";
}else{
  echo "Error, System Configuration already created<br>";
}






// Luxury Train Module Start ===============================================================

// $rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_luxurytrain.php" and url="luxurytrain"');
// if(mysqli_num_rows($rs)==0){  
//   $namevalue1 ='moduleName="Luxury Train",moduleFile="crm_luxurytrain.php",url="luxurytrain", sr="71",mainmenu="50"';
//   $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

//   // take the users module ffor this information 
//   $select='*';
//   $where='deletestatus = 0 and admin=1 order by id asc';
//   $rs=GetPageRecord($select,_USER_MASTER_,$where);
//   while($userD=mysqli_fetch_array($rs)){
//     $namevalue2 ='moduleName="Luxury Train",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="luxurytrain",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
//     addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
//   }

//   // take the permission
//   $select='*';
//   $where='deletestatus = 0 order by id asc';
//   $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
//   while($profileclone=mysqli_fetch_array($rs)){
//     $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
//     addlisting(_PERMISSION_MASTER_,$namevalue3);
//   }
//   echo "Done, Luxury Train module created<br>";
// }else{
//   echo "Error, Luxury Train already created<br>";
// }

// Train Cabin Type Module Start ===============================================================

// $rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_traincabintype.php" and url="traincabintype"');
// if(mysqli_num_rows($rs)==0){  
//   $namevalue1 ='moduleName="Train Cabin Type",moduleFile="crm_traincabintype.php",url="traincabintype", sr="71",mainmenu="50"';
//   $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

//   // take the users module ffor this information 
//   $select='*';
//   $where='deletestatus = 0 and admin=1 order by id asc';
//   $rs=GetPageRecord($select,_USER_MASTER_,$where);
//   while($userD=mysqli_fetch_array($rs)){
//     $namevalue2 ='moduleName="Train Cabin Type",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="traincabintype",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
//     addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
//   }

//   // take the permission
//   $select='*';
//   $where='deletestatus = 0 order by id asc';
//   $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
//   while($profileclone=mysqli_fetch_array($rs)){
//     $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
//     addlisting(_PERMISSION_MASTER_,$namevalue3);
//   }
//   echo "Done, Train Cabin Type module created<br>";
// }else{
//   echo "Error, Train Cabin Type already created<br>";
// }


// Train Package Module Start ===============================================================

// $rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_trainpackage.php" and url="trainpackage"');
// if(mysqli_num_rows($rs)==0){  
//   $namevalue1 ='moduleName="Train Package",moduleFile="crm_trainpackage.php",url="trainpackage", sr="40",mainmenu="2"';
//   $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

//   // take the users module ffor this information 
//   $select='*';
//   $where='deletestatus = 0 and admin=1 order by id asc';
//   $rs=GetPageRecord($select,_USER_MASTER_,$where);
//   while($userD=mysqli_fetch_array($rs)){
//     $namevalue2 ='moduleName="Train Package",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="trainpackage",status="1",mainmenu="2",modifyBy="37",modifyDate="'.time().'"';
//     addlistinggetlastid(_USER_MODULE_MASTER_,$namevalue2);
//   }

//   // take the permission
//   $select='*';
//   $where='deletestatus = 0 order by id asc';
//   $rs=GetPageRecord($select,_PROFILE_MASTER_,$where);
//   while($profileclone=mysqli_fetch_array($rs)){
//     $namevalue3 ='profileId='.$profileclone['id'].',moduleId='.$mdlId.',view=1,edit=1,import=1,export=1,dlt=1,addentry=1';
//     addlisting(_PERMISSION_MASTER_,$namevalue3);
//   }
//   echo "Done, Train Package module created<br>";
// }else{
//   echo "Error, Train Package already created<br>";
// }

// Payment Type Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_paymentType.php" and url="PaymentType"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Payment Type",moduleFile="crm_paymentType.php",url="PaymentType", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Payment Type",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="PaymentType",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, PaymentType module created<br>";
}else{
  echo "Error, PaymentType already created<br>";
}



// vehicle Type Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_vehicleTypeMaster.php" and url="vehicleTypeMaster"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Vehicle Type Master",moduleFile="crm_vehicleTypeMaster.php",url="vehicleTypeMaster", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Vehicle Type Master",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="vehicleTypeMaster",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Vehicle Type Master module created<br>";
}else{
  echo "Error, Vehicle Type Master already created<br>";
}
// ended for vehicle type master 



// Template Voucher Master Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_invoiceTemplates.php" and url="invoiceTemplates"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="Invoice Templates",moduleFile="crm_invoiceTemplates.php",url="invoiceTemplates", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="Invoice Templates",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="invoiceTemplates",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, Invoice Template module created<br>";
}else{
  echo "Error, Invoice Template already created<br>";
}
// ended for invoice templates




// FIT Inculsions I Exculsions I T & C I Cancellation Policy Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_fitterms.php.php" and url="FITInculsionsIExculsionsITCICancellationPolicy"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="FIT Inculsions I Exculsions I T & C I Cancellation Policy",moduleFile="crm_fitterms.php",url="FITInculsionsIExculsionsITCICancellationPolicy", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="FIT Inculsions I Exculsions I T & C I Cancellation Policy",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="FITInculsionsIExculsionsITCICancellationPolicy",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, FIT Inculsions I Exculsions I T & C I Cancellation Policy module created<br>";
}else{
  echo "Error, FIT Inculsions I Exculsions I T & C I Cancellation Policy already created<br>";
}
// ended for FIT Inculsions I Exculsions I T & C I Cancellation Policy



// GIT Inculsions I Exculsions I T & C I Cancellation Policy Module Start ===============================================================

$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_gitterms.php" and url="GITInculsionsIExculsionsITCICancellationPolicy"');
if(mysqli_num_rows($rs)==0){  
  $namevalue1 ='moduleName="GIT Inculsions I Exculsions I T & C I Cancellation Policy",moduleFile="crm_gitterms.php",url="GITInculsionsIExculsionsITCICancellationPolicy", sr="50",mainmenu="40"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="GIT Inculsions I Exculsions I T & C I Cancellation Policy",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="GITInculsionsIExculsionsITCICancellationPolicy",status="1",mainmenu="50",modifyBy="37",modifyDate="'.time().'"';
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
  echo "Done, GIT Inculsions I Exculsions I T & C I Cancellation Policy module created<br>";
}else{
  echo "Error, GIT Inculsions I Exculsions I T & C I Cancellation Policy already created<br>";
}
// ended for GIT Inculsions I Exculsions I T & C I Cancellation Policy


// 


// started for CMS 
$rs=GetPageRecord('*',_MODULE_MASTER_,' moduleFile="crm_cms.php" and url="cms"');
if(mysqli_num_rows($rs)==0){

  $namevalue1 ='moduleName="CMS",moduleFile="crm_cms.php",url="cms",sr="3",mainmenu="1"';
  $mdlId  = addlistinggetlastid(_MODULE_MASTER_,$namevalue1);

  // take the users module ffor this information 
  $select='*';
  $where='deletestatus = 0 and admin=1 order by id asc';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  while($userD=mysqli_fetch_array($rs)){
    $namevalue2 ='moduleName="CMS",parentId="'.$mdlId.'",userId="'.$userD['id'].'",url="cms",status="1",mainmenu="1",modifyBy="'.$userD['id'].'",modifyDate="'.time().'"';
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
  echo "Done, Cms module created<br>"; 
}else{
  echo "Error, Cms already created<br>";
}
// Ended for CMS 


?>



