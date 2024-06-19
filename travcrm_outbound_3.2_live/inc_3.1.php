<?php 
error_reporting(0);
include "config/database.php"; 
include "config/dbtable.php"; 
include "config/function.php";  
$rscms=GetPageRecord('*','companySettingsMaster','id=1'); 
$editresultcsm=mysqli_fetch_array($rscms); 

$masterCompanyName=clean($editresultcsm['companyName']);  
$masterProposalLogo=clean($editresultcsm['proposalLogo']);  
$masterLogo = $editresultcsm['logoupload'];
$masterQueryIdSequence=clean($editresultcsm['queryIdSequence']);  
$defaultCountryId = $editresultcsm['countryId'];
$baseCurrencyId = $editresultcsm['baseCurrencyId'];
$tourIdSequence = $editresultcsm['tourIdSequence'];


if($baseCurrencyId > 0){
	$basecurrQuery="";
	$basecurrQuery=GetPageRecord('*','queryCurrencyMaster',' setDefault=1 ');  
	$basecurrQueryData=mysqli_fetch_array($basecurrQuery);	
	
	if(!isset($basecurrQueryData['id'])){
		$baseCurrencyId = $defaultCurr = 1;
		$roe = $baseCurrencyVal = 1;
	}else{
		$roe = $baseCurrencyVal = getCurrencyVal($baseCurrencyId);
		$currencyName = getCurrencyName($baseCurrencyId);
		$baseCurrencyId = $defaultCurr = $basecurrQueryData['id'];
	}
}

if(!empty($editresultcsm)){
  $rsfs=GetPageRecord('*','componyFinanceSetting','companySettingId="'.$editresultcsm['id'].'"');  
  $financeresult=mysqli_fetch_array($rsfs);	
}

// $fullurl='http://localhost/DevOutBound_3.1/TravCRMExtension/travcrm-dev/';
$fullurl='http://localhost/GitHub/outbound1.3/travcrm-dev/';

$systemname=$masterCompanyName;
global $clientnameglobal;
$clientnameglobal=$masterCompanyName;

// get the Current financial year

$curDate = date('Y-m-d');
$financialYearArray = getfinancialYearMaster($curDate);
 
$currFY_fromDate = $financialYearArray['fromDate'];
$currFY_toDate = $financialYearArray['toDate'];
// fyData

$nod=1;
$select='*';
$where='id=1'; 
$rs=GetPageRecord($select,_THEME_MASTER_,$where); 
while($themesetting=mysqli_fetch_array($rs)){
	$topLineColor=$themesetting['topLineColor'];
	$buttonColor=$themesetting['buttonColor'];
	$linkColor=$themesetting['linkColor'];  
	$loginColorone=$themesetting['loginColorone'];  
	$loginColortwo=$themesetting['loginColortwo'];  
}
 

$rss = GetPageRecord('setDefaultTemplate','voucherSettingMaster','id=1');
$voucherD = mysqli_fetch_assoc($rss);
$setDefaultTemplate = $voucherD['setDefaultTemplate'];

$rss=GetPageRecord('uSession',_USER_MASTER_,'id="'.$_SESSION['userid'].'" and email="'.$_SESSION['username'].'"'); 
$getusession=mysqli_fetch_array($rss); 
 
$select=$rs=$where='';
$select='*'; 
$where='id="'.$_SESSION['userid'].'" '; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$adminData=mysqli_fetch_array($rs);  

$select=$rs=$where='';
$select='zonetxt'; 
$where='id="'.$adminData['timeZone'].'"'; 
$rs=GetPageRecord($select,_TIMEZONE_MASTER_,$where); 
$timeZoneData=mysqli_fetch_array($rs); 

date_default_timezone_set($timeZoneData['zonetxt']);



?>





