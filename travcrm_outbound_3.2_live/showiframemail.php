
<link href="css/main.css" rel="stylesheet" type="text/css">
<?php 
ob_start();   
include "inc.php";  
include "config/logincheck.php";  
ini_set('post_max_size', '10M'); 
ini_set('upload_max_filesize', '10M');  







if($_GET['id']!=''){
$select=''; 
$where=''; 
$rs='';   
$select='*';   
$id=clean(decode($_GET['id']));   
$where='id='.$id.'';   
$rs=GetPageRecord($select,'miceMaster',$where);  
$resultpage=mysqli_fetch_array($rs);  
 
$select=''; 
$where=''; 
$rs='';   
$select='email';  
$where='id='.$resultpage['assignTo'].''; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$resultpageassignemail=mysqli_fetch_array($rs);
$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,'maicemails',$where); 
$resultpageemail=mysqli_fetch_array($rs); 
if($resultpage['clientType']==2){
	
	$select2='*';  
$where2='id='.$resultpage['companyId'].''; 
$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
$contantnamemain=mysqli_fetch_array($rs2);
$clientnemdisplay = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
$getphone =  getPrimaryPhone($resultpage['companyId'],'contacts');
$getemail =  getPrimaryEmail($resultpage['companyId'],'contacts'); 
} 
if($resultpage['clientType']==1){ 
$select2='*';  
$where2='id='.$resultpage['companyId'].''; 
$rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2); 
$contantnamemain=mysqli_fetch_array($rs2);
$clientnemdisplay = $contantnamemain['contactPerson'];
$clientnem = getCorporateCompany($editcompanyId);
$getemail = getPrimaryEmail($resultpage['companyId'],"corporate");
$getphone = getPrimaryPhone($resultpage['companyId'],"corporate");
 
} 

}



$select=''; 
$where=''; 
$rs='';  
$select='*';   
 $where='id='.$_GET['mailid'].' order by adddate desc'; 
$rsm=GetPageRecord($select,'maicemails',$where);  
//echo mysqli_num_rows($rs);
while($querylisting=mysqli_fetch_array($rsm)){ 
  
  $queryemaildate=$querylisting['adddate'];
 $querydate=date("Y-m-d H:i:s",$resultpage['dateAdded']);
?> 
 <script src="js/jquery-1.11.3.min.js"></script>   

<div  style="padding:20px; "id="displaymaintab<?php echo $querylisting['id']; ?>">
 <div class="datebox" style="position:relative;"><?php $originalDate = $querylisting['adddate']; echo date("g:iA - d-m-Y", strtotime($originalDate)); ?> </div>
 <div class="mailusers">
		   
	<?php if($loginuserprofileId!='48'){ ?>	   <div class="mailusersbox"><strong>Client: </strong><?php if($resultpage['clientType']==1){ echo getPrimaryEmail($resultpage['companyId'],'corporate'); } if($resultpage['clientType']==2){ echo getPrimaryEmail($resultpage['companyId'],'contacts'); } ?></div> <?php } ?>
		   <div class="mailusersbox"><strong>Operation Person: </strong><?php echo $resultpageassignemail['email']; ?></div> 
		   
		   <?php
		   if($resultpage['clientType']==1){
$select111=''; 
$where111=''; 
$rs111='';   
$select111='*';  
$where111='id='.$resultpage['companyId'].''; 
$rs111=GetPageRecord($select111,_CORPORATE_MASTER_,$where111); 
$resultpageassignemail=mysqli_fetch_array($rs111); 
$select111=''; 
$where111=''; 
$rs111='';   
$select111='*';  
$where111='id='.$resultpageassignemail['assignTo'].''; 
$rs111=GetPageRecord($select111,_USER_MASTER_,$where111); 
$resultpageassignemail=mysqli_fetch_array($rs111); 
$corporatesalesperson=$resultpageassignemail['email']; 
 
?>
		   
		<div class="mailusersbox"><strong>Sales Person: </strong><?php echo $corporatesalesperson; ?></div> 
		
		<?php } ?>
		
		   
	<!--<div class="mailusersbox"><strong>Group: </strong><?php echo $resultpageemail['queryemail']; ?></div> -->	   
<?php if($querylisting['fromMail']!=''){ ?><div class="mailusersbox"><strong>From: </strong><?php echo $querylisting['fromMail']; ?></div><?php } else {
 
if($querylisting['addBy']!='0'){
 $select='*'; 
$where='id="'.$querylisting['addBy'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$LoginUserDetails=mysqli_fetch_array($rs); 
 ?>
<div class="mailusersbox"><strong>From: </strong><?php echo $LoginUserDetails['email']; ?></div>
<?php } } ?>
		   
		   <?php
		   if($querylisting['multiemails']!=''){
		   $variableAry=explode(",",$querylisting['multiemails']); //you have array now
                foreach($variableAry as $var)
                {
				?>
		   <div class="mailusersbox"><?php echo $var; ?></div> 
		   <?php } } ?>
	    </div>
 
 <?php 
 //if($queryemaildate==$querydate){ echo nl2br(($querylisting['description']));}else{echo nl2br(strip_html_tags($querylisting['description']));} 
  
 if($querylisting['fromMail']==''){
 echo stripslashes($querylisting['description']);
 
 } else { 
 
 echo  stripslashes($querylisting['description']);
 }
 
 }
 ?></div>
 