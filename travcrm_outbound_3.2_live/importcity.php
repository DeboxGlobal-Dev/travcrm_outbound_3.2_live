<?php
ob_start();
include "inc.php"; 
require_once 'reader.php';


if($_FILES['importfield']['name']!=''){ 

$duplicaterecored.='';
if(!empty($_FILES['importfield']['name'])){
$file_name=$_FILES['importfield']['name'];
copy($_FILES['importfield']['tmp_name'],"importfile/".$file_name);
 
$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
	     $path="importfile/".$file_name;
		  
		$data->read($path);

for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
$cityname = trim($data->sheets[0]["cells"][$x][1]); 
$state = trim($data->sheets[0]["cells"][$x][2]);

$companytypegetresult='';
$select1='id';  
$where1='name="'.$cityname.'"'; 
$rs1=GetPageRecord($select1,'cityMaster',$where1); 
$companytypegetresult=mysqli_fetch_array($rs1);



$stateid='';
$select2='id';  
$where2='name="'.$state.'"'; 
$rs2=GetPageRecord($select2,'stateMaster',$where2); 
$stateid=mysqli_fetch_array($rs2);


if($companytypegetresult['id']==''){

$namevalue ='status=1,name="'.$cityname.'",stateId="'.$stateid['id'].'"';  
$lastid = addlistinggetlastid('cityMaster',$namevalue);

}
	


}

}
}
?>









 <form   method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"     >
 <input name="importexcel" id="importexcel" type="hidden" value="Y" /> 
 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel"   />
   <label>
   <input type="submit" name="Submit" value="Submit">
   </label>
 </div>
 </form>