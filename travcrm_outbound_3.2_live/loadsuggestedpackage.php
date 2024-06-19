<?php 
include "inc.php";  
include "config/logincheck.php";  

// load suggested packages file
if($_REQUEST['tourextension'] == 1){
	$daysTable = 'newQuotationDays';
	$whereQuery = 'quotationId="'.($_REQUEST['quotationId']).'" order by srdate asc';
}else{
	$daysTable = 'packageQueryDays';
	$whereQuery = 'queryId="'.($_REQUEST['queryId']).'" order by srdate asc';
}

$rs="";
$rs=GetPageRecord('count(id) as days',$daysTable,$whereQuery);  
$countNightD=mysqli_fetch_array($rs);
$keyWordDaysC = $countNightD['days']; 
  
$hotCategory = implode(',',$_POST['hotCategory']); 
if($_POST['quotationType'] == 2 && $_REQUEST['hotCategory']!=0){
	$keyWordQuotType = "M";
	$keyWordHotCat = $hotCategory;
}else{
	$keyWordQuotType = "S";
	$keyWordHotCat = "*";
}


$rs="";
$rs=GetPageRecord('cityId',$daysTable,$whereQuery);
$keyWordDaysC = mysqli_num_rows($rs);
while($QueryDaysData=mysqli_fetch_array($rs)){
	//make keyword with dstin
	$destD=mysqli_fetch_array(GetPageRecord('name',_DESTINATION_MASTER_,'id="'.$QueryDaysData['cityId'].'"'));
	$keyWordCityNameVal .= strtolower($destD['name']).'/'; 
}

$searchKeyword = $keyWordCityNameVal.';'.$keyWordDaysC.';'.$keyWordQuotType.'/'.$keyWordHotCat; 
 
?>
<option value="0">Select&nbsp;Package</option>
<?php
if($keyWordDaysC>0 ){
$n = 0; 
$wherel=''; 
$rsl='';        
echo $wherel=' 1 and searchKeyword = "'.$searchKeyword.'" and isPackage=1 and isActive=0 and queryType=4 order by id asc';
$rsl=GetPageRecord('*','quotationMaster',$wherel); 
while($suggPackageData=mysqli_fetch_array($rsl)){   
	?>
	<option value="<?php echo strip($suggPackageData['id']); ?>"><?php echo $suggPackageData['quotationSubject']; ?> - Nights:<?php echo ($keyWordDaysC-1); ?> - Pax: <?php echo $suggPackageData['adult']; ?> - Cost:&nbsp;<?php echo $suggPackageData['totalClientCost']."&nbsp;"; echo getCurrencyName($suggPackageData['currencyId']);?></option>
	<?php 
	$n++; 
} 
} ?>  