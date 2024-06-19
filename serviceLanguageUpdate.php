<?php 
include "inc.php";
if(trim($_REQUEST['action'])=='saveDestinationLanguage' && trim($_REQUEST['id'])!='' && trim($_REQUEST['sno'])!=''){
	$sno = $_REQUEST['sno'];
	if($sno == 1){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_01="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);

	   //    For Destination description
		$desrres = GetPageRecord('*','destinationLanguageMaster','id="'.$langrwId.'"');
		$resultdesc = mysqli_fetch_assoc($desrres);

		$namevaluedMU='description="'.$lanName.'"';
		$whereDMU = 'id="'.$resultdesc['destinationId'].'"';

		if ($update=='yes') {	
			$update = updatelisting(_DESTINATION_MASTER_,$namevaluedMU,$whereDMU);
		}
		// else{
		// 	$update = updatelisting('destinationLanguageMaster',$namevalue,$where);
		// 	$update = updatelisting(_DESTINATION_MASTER_,$namevalueDM,$whereDM);
		// }
	}
	if($sno == 2){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_02="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 3){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_03="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 4){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_04="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 5){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_05="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 6){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_06="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 7){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_07="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 8){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_08="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 9){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_09="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
	if($sno == 10){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_10="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('destinationLanguageMaster',$namevalue,$where);
	}
}

if(trim($_REQUEST['action'])=='saveActivityLanguage' && trim($_REQUEST['id'])!='' && trim($_REQUEST['sno'])!=''){
	$sno = $_REQUEST['sno'];
	if($sno == 1){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_01="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 2){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_02="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 3){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_03="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 4){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_04="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 5){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_05="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 6){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_06="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 7){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_07="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 8){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_08="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 9){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_09="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
	if($sno == 10){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_10="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('activityLanguageMaster',$namevalue,$where);
	}
}

if(trim($_REQUEST['action'])=='saveEntranceLanguage' && trim($_REQUEST['id'])!='' && trim($_REQUEST['sno'])!=''){
	$sno = $_REQUEST['sno'];
	if($sno == 1){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_01="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 2){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_02="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 3){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_03="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 4){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_04="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 5){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_05="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 6){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_06="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 7){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_07="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 8){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_08="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 9){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_09="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
	if($sno == 10){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_10="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	}
}

if(trim($_REQUEST['action'])=='saveEnrouteLanguage' && trim($_REQUEST['id'])!='' && trim($_REQUEST['sno'])!=''){
	$sno = $_REQUEST['sno'];
	if($sno == 1){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_01="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 2){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_02="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 3){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_03="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 4){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_04="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 5){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_05="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 6){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_06="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 7){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_07="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 8){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_08="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 9){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_09="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
	if($sno == 10){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_10="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
	}
}

if(trim($_REQUEST['action'])=='saveItineneryTitleLanguage' && trim($_REQUEST['id'])!='' && trim($_REQUEST['sno'])!=''){
	$sno = $_REQUEST['sno'];
	if($sno == 1){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_01="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 2){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_02="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 3){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_03="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 4){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_04="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 5){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_05="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 6){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_06="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 7){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_07="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 8){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_08="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 9){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_09="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
	if($sno == 10){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_10="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineryTitleLanguageMaster',$namevalue,$where);
	}
}
if(trim($_REQUEST['action'])=='saveItineneryDescriptionLanguage' && trim($_REQUEST['id'])!='' && trim($_REQUEST['sno'])!=''){
	$sno = $_REQUEST['sno'];
	if($sno == 1){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_01="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 2){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_02="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 3){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_03="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 4){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_04="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 5){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_05="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 6){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_06="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 7){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_07="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 8){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_08="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 9){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_09="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
	if($sno == 10){
       $lanName = $_REQUEST['lanName'];
       $langrwId = $_REQUEST['id']; 
       $namevalue ='lang_10="'.$lanName.'"';
 	   $where='id="'.$langrwId.'"';
	   $update = updatelisting('itineneryDesLanguageMaster',$namevalue,$where);
	}
}

 ?>