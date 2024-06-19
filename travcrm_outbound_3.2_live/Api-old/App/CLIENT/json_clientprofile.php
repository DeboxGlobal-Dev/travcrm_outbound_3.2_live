<?php 
include "../../../inc.php";
// include "../../../travcrm-dev/inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");

$masterid=$_REQUEST['id'];
$type=$_REQUEST['type'];
if($masterid>0 || $masterid!=''){
	if($type==1){
		$select='*';
		$where='id="'.$masterid.'" order by id desc';
		$rs=GetPageRecord($select,_CORPORATE_MASTER_,$where);
	}elseif($type==2){
		$select='*';
		$where='id="'.$masterid.'" order by id desc';
		$rs=GetPageRecord($select,_CONTACT_MASTER_,$where);
	}


while($resListing=mysqli_fetch_array($rs)){
	if($type==1){
		$id=$resListing['id'];   
		$corporateId = $resListing['id'];
		$select1='*';
		$where1='corporateId="'.$corporateId.'" and division=3 order by id desc';
		$rs1=GetPageRecord($select1,'contactPersonMaster',$where1);
		$contactp = mysqli_fetch_assoc($rs1);
		$firstName = $contactp['firstName'];
		$lastName = $contactp['lastName'];
		$phone = decode($contactp['phone']);
		$email = decode($contactp['email']);
		$dob=$contactp['dob'];
		$anniversaryDate=$contactp['anniversaryDate'];

		$where2='id="'.$resListing['countryId'].'"';
		$rs1=GetPageRecord('*',_COUNTRY_MASTER_,$where2);
		$CountryList=mysqli_fetch_array($rs1);
		$countryName = $CountryList['name'];
		$address1 = $resListing['address1'];


	}else{

$id=$resListing['id'];    
$firstName=$resListing['firstName'];
$lastName=$resListing['lastName'];
$dob=$resListing['birthDate'];
$anniversaryDate=$resListing['anniversaryDate'];
$address1=$resListing['address1'];
$accomodationpreferenceId=$resListing['preAccomodationMaster'];
$holyDayPacId=$resListing['holyDayPacId'];
$mealPreferenceId=$resListing['mealPreference'];
$physicalConditionId=$resListing['physicalCondition'];

$select3='*';    
$where3='id="'.$accomodationpreferenceId.'"';  
$rs3=GetPageRecord($select3,_PRE_ACCOMODATION_MASTER_,$where3); 
while($resListing3=mysqli_fetch_array($rs3)){
$AccomodationPreference = strip($resListing3['name']);
}
$select4='*';    
$where4='id="'.$holyDayPacId.'"';  
$rs4=GetPageRecord($select4,_PREHOLIDAYPAC_MASTER_,$where4); 
while($resListing4=mysqli_fetch_array($rs4)){   
$holidaypreference=strip($resListing4['name']);
}
$select5='*';    
$where5='id="'.$mealPreferenceId.'"';  
$rs5=GetPageRecord($select5,'mealPreference',$where5); 
while($resListing5=mysqli_fetch_array($rs5)){   
$mealPreference=strip($resListing5['name']);
}
$select6='*';    
$where6='id="'.$physicalConditionId.'"';  
$rs6=GetPageRecord($select6,'physicalCondition',$where6); 
while($resListing6=mysqli_fetch_array($rs6)){   
$specialassistance=strip($resListing6['name']);
} 

$select1='*';
$where1='id="'.$resListing['countryId'].'"';
$rs1=GetPageRecord($select1,_COUNTRY_MASTER_,$where1);
$CountryList=mysqli_fetch_array($rs1);
$countryName = $CountryList['name'];

$select2='*';
$where2='masterId="'.$resListing['id'].'" and primaryvalue=1';
$rs2=GetPageRecord($select2,_PHONE_MASTER_,$where2);
$phoneData=mysqli_fetch_array($rs2);
$phone = $phoneData['phoneNo'];
$select3='*';
$where3='masterId="'.$resListing['id'].'" and primaryvalue=1 order by id desc';
$rs3=GetPageRecord($select,_EMAIL_MASTER_,$where3);
$emailData=mysqli_fetch_array($rs3);
$email = $emailData['email'];
	}
    $json_result.= '{
        "id" : "'.$id.'",
		"firstName" : "'.$firstName.'",
		"lastName" : "'.$lastName.'",
		"country" : "'.$countryName.'",
		"mobile" : "'.$phone.'",
		"email" : "'.$email.'",
		"dob" : "'.$dob.'",
		"anniversaryDate" : "'.$anniversaryDate.'",
		"address" : "'.$address1.'",
		"accomodationpreference" : "'.$AccomodationPreference.'",
		"holidaypreference" : "'.$holidaypreference.'",
		"mealPreference" : "'.$mealPreference.'",
		"specialassistance" : "'.$specialassistance.'"
	},';

}
}else{
	$json_result.='{
			"error" : "Agent Or B2C does not exist"
	},';
}
?>
{
		"status":"true",
		"results":[<?php echo trim($json_result, ',');?>]
}
<?php 