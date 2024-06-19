<?php 
include "../inc.php";  
$quotationId = decode($_REQUEST['id']);

$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');  
$resultpageQuotation=mysqli_fetch_array($rsp);  

$q_token = $resultpageQuotation['q_token'];
// if($_REQUEST['q_token']!='' && $_REQUEST['q_token']==$q_token && isset($_REQUEST['q_token'])){
if($_REQUEST['q_token']==$q_token && isset($_REQUEST['q_token'])){
	$isMenu = 1;
	// include "../logincheck.php";  
	if($_SESSION['username']=="" || $_SESSION['sessionid']!=session_id() || $_SESSION['userid']=="" || $_SESSION['uSession']=="" || $_SESSION['otpvar']==""){ 
		header("Location:404.html");
		exit(); 
	}
// }elseif($_REQUEST['q_token']!=$q_token || !isset($_REQUEST['q_token']) || $_REQUEST['q_token']=='' ){
}elseif($_REQUEST['q_token']!=$q_token || !isset($_REQUEST['q_token'])){
	$isMenu = 0;
}else{
	die();
}
$propNum = $_REQUEST['propNum'];
if($propNum!=''){
	$propNum=$propNum;
}else{
	$propNum=4;
}
if($propNum==1){
	$proName='costsheet_proposal';
}
if($propNum==2){
	$proName='brief_proposal';
}
if($propNum==3){
	$proName='detailed_proposal';
}
if($propNum==4){
	$proName='elite_proposal';
}
if($propNum==6){
	$proName='vivid_proposal';
}
if($propNum==7){
	$proName='indian_proposal';
}

$select='*';  
$where='id='.$resultpageQuotation['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 

$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];

$overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText='';
if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
	$overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText'])); 
}
if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
	$highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
}
if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
	$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
	$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
	$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
}
if($resultpageQuotation['specialText']!='' || $resultpageQuotation['specialText']!='undefined'){
	$specialText=preg_replace('/\\\\/', '',clean($resultpageQuotation['specialText']));
}



$colorres = GetPageRecord('*','proposalSettingMaster','deletestatus=0 and proposalNum="'.$propNum.'"');
$colorResult = mysqli_fetch_assoc($colorres);


if($resultpageQuotation['quotationSubject']!=''){
	$quotationSubject = preg_replace('/\\\\/', '',clean($resultpageQuotation['quotationSubject']));
}else{
	$quotationSubject = strtoupper(strip($resultpage['subject']));
}

?>  
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $quotationSubject; ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,600;1,700;1,900&display=swap" rel="stylesheet"> 

	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>PreviewFiles/css/proposal-main.css">
	<script src="<?php echo $fullurl; ?>PreviewFiles/js/proposal-main.js?t=<?php echo time(); ?>"></script> 

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
	<script src="<?php echo $fullurl; ?>js/jquery-3.5.0.min.js?t=<?php echo time(); ?>"></script> 
	<script src="<?php echo $fullurl; ?>js/main.js?t=<?php echo time(); ?>"></script> 
	<script src="<?php echo $fullurl; ?>js/validation.js?id=1660111833"></script> 
	<style type="text/css">
		.calcostsheet{
			display: none;
			visibility: hidden;
		}
	</style> 
</head>
<body>
	<iframe id="actoinfrm" name="actoinfrm" src="" style="display:none;"></iframe>
	<div id="proposal_alertbox" style="display:none; background-image:url(img/bgpop.png); background-repeat:repeat;">
	 	<div id="proposal_alertswhitebox"> </div> 
	</div> 
<!-- <header>sssssss</header> 
<footer>
	<img src="<?php echo $fullurl; ?>images/company-info-footer.png"  width="100%" />
</footer>  -->

<?php 
if($isMenu == 1){
	include_once("proposal_header.php"); 
}
?>
<div class="calcostsheet removeDiv" id="removeDiv">
<?php 
if($resultpageQuotation['quotationType']==2){ 

	if($resultpage['travelType']==2){
		include_once("../loadGITCostSheet_domestic.php"); 
	}else{
		include_once("../loadGITCostSheet.php"); 
	}

}else{
	if($resultpage['travelType']==2){
		include_once("../loadFITCostSheet_domestic.php"); 
	}else{
		include_once("../loadFITCostSheet.php"); 
	}
}

$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];

?>
</div>
<div id="printBox" style="width: 768px;margin: 0px auto;">

<?php include_once("proposal_0".$propNum.".php"); ?> 
</div> 
</body>
</html>
