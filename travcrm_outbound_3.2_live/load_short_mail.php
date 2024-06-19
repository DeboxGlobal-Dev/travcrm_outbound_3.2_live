<?php  
include "inc.php";  
?>
<script>
$('#converttoquerybtn').hide();
$('#gotoquerybtn').hide();
</script>

<?php 

$select1='*';   
$select1='*'; 
if($LoginUserDetails['profileId']=='47'){
$where1='email="'.$LoginUserDetails['email'].'"'; 
} else {
$where1='id='.($_REQUEST['mailid']).''; 
}
 
$rs1=GetPageRecord($select1,_EMAIL_SETTING_MASTER_,$where1); 
$mainmailid=mysqli_fetch_array($rs1); 



if($_REQUEST['status']!='' && $_REQUEST['id']!='' && $_REQUEST['mailtype']!=''){
$namevalue ='mailStatus="'.$_REQUEST['status'].'"';
$where='id="'.$_REQUEST['id'].'" ';  
$update = updatelisting(_MAIL_SECTION_MASTER_,$namevalue,$where); 

}


if($_REQUEST['status']=='5' && $_REQUEST['id']!='' && $_REQUEST['mailtype']=='1' && $_REQUEST['mailid']!='' && $_REQUEST['subjectmail']!=''){
  
 $namevalue ='mailSubject="'.addslashes($_REQUEST['subjectmail']).'",dateTime="'.trim($_REQUEST['dateTimeadd']).'"';   
 addlistinggetlastid('trashMailMaster',$namevalue);

?>
<script> //alert('<?php echo $_REQUEST['subjectmail']; ?>');  
loadmails('12'); 
</script>
<?php 
 
}



if($_REQUEST['mailtype']==1 || $_REQUEST['mailtype']==2){

$wheremail='';
$where2='';

if($_REQUEST['mailtype']=='8'){
$where2=' and mailStatus=1 ';
}



 


include('incomingMailSetting.php');



$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to domain:' . imap_last_error());

$searchkeyword = trim($_REQUEST['searchkeyword']);

if($searchkeyword!=''){
$keyword='BODY "'.$searchkeyword.'"';

if (strpos($searchkeyword, '@') !== false) {

 $keyword='FROM "'.$searchkeyword.'"';
}

} else {
$keyword='ALL';
}


$emails = imap_search($inbox,''.$keyword.'');   
if($emails){  
$output = ''; 
 
rsort($emails);  
$totalmail=0;
$n=1;
foreach($emails as $email_number) { 

if($totalmail<100){ 




$subject='';  
$message='';  
$body='';  
$email='';  
$date='';
 

$overview = imap_fetch_overview($inbox,$email_number,0);  
$subject = $subject=$overview[0]->subject; 

  

$messagestatus =  $overview[0]->seen ? 'read' : 'unread';

$mailUserName = addslashes(strip_tags($overview[0]->from));
$email=$from=$overview[0]->from;  
   
$ccemail=$from=$overview[0]->cc;    
preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails);   
$email= str_replace('["','',json_encode($found_mails[0]));   
$email=  str_replace('"]','',$email);  
$structure = imap_fetchstructure($inbox, $email_number); 
 
$timestamp = strtotime($date=$overview[0]->date);  
date_default_timezone_set('asia/kolkata');  
$date = date('Y-m-d H:i:s',$timestamp);

$select='*';    
$where='dateTime="'.$timestamp.'" order by id asc';  
$rs=GetPageRecord($select,'trashMailMaster',$where); 
 if(mysqli_num_rows($rs)<1){ 
 if($subject!='Mail delivery failed: returning message to sender' && $subject!='Undelivered Mail Returned to Sender' && $subject!='OTP for TravCRM login'  && $subject!='Mail Delivery System'){
 if (strpos($subject, '#00') !== false) { } else {
 
$select1='*';  
$where1='mailId="'.$email_number.'" and deletestatus=0'; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$editresult2=mysqli_fetch_array($rs1); 
 
?> 
<div onclick="funreadmailsection('<?php echo $email_number; ?>');" class="list<?php if($messagestatus=='unread'){ ?> new<?php } ?>" id="mailiddiv<?php echo $email_number; ?>" <?php if($editresult2['id']!=''){ ?>style="border-left: 2px #09a748 solid !important;background-color:#F0FFE1;"<?php } ?>>
<div class="dateright"><?php echo date('h:i A',strtotime($date)); ?> - <?php if(date('Y-m-d',strtotime($date))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($date)); } ?></div>
<div class="heading"> <?php echo stripslashes($mailUserName); ?></div>
<div class="shorttext"><?php if($editresult2['id']!=''){ ?><i class="fa fa-address-card" aria-hidden="true" style="color:#09a748;"></i><?php } ?> &nbsp;<?php echo substr(stripslashes($subject),0,500); ?>...</div>
</div>
		  
	<?php  if($messagestatus=='unread'){ $n++;} $totalmail++;  } }
	}
	
	
	
	 }} }  ?>
	
	
	
	
	
	
	
	
	
	
<script>
$('.newmailcome').text('<?php echo $n-1; ?>');
</script>
	
	 <?php }  
	 
	 
	 
if($_REQUEST['mailtype']==8){

$wheremail='';
$where2='';

if($_REQUEST['mailtype']=='8'){
$where2=' and mailStatus=1 ';
}



if($_REQUEST['searchkeyword']!=''){
$wheremail=' and subject like "%'.$_REQUEST['searchkeyword'].'%" or mailUserName like "%'.$_REQUEST['searchkeyword'].'%" or mailFrom like "%'.$_REQUEST['searchkeyword'].'%"';
}


 include('incomingMailSetting.php');




$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to domain:' . imap_last_error()); 

$emails = imap_search($inbox,'UNSEEN');   
if($emails){  
$output = ''; 
 
rsort($emails);  
$totalmail=0;
$n=1;
foreach($emails as $email_number) { 

if($totalmail<100){ 




$subject='';  
$message='';  
$body='';  
$email='';  
$date='';
 

$overview = imap_fetch_overview($inbox,$email_number,0);  
$subject = $subject=$overview[0]->subject; 

  

$messagestatus =  $overview[0]->seen ? 'read' : 'unread';

$mailUserName = addslashes(strip_tags($overview[0]->from));
$email=$from=$overview[0]->from;  
   
$ccemail=$from=$overview[0]->cc;    
preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails);   
$email= str_replace('["','',json_encode($found_mails[0]));   
$email=  str_replace('"]','',$email);  
$structure = imap_fetchstructure($inbox, $email_number); 
 
$timestamp = strtotime($date=$overview[0]->date);  
date_default_timezone_set('asia/kolkata');  
$date = date('Y-m-d H:i:s',$timestamp);

$select='*';    
$where='dateTime="'.$timestamp.'" order by id asc';  
$rs=GetPageRecord($select,'trashMailMaster',$where); 
 if(mysqli_num_rows($rs)<1){ 
 
 if($subject!='Mail delivery failed: returning message to sender' && $subject!='Mail Delivery System' && $subject!='OTP for TravCRM login'){
 
 
  if (strpos($subject, '#00') !== false) { } else {
?> 
<div onclick="funreadmailsection('<?php echo $email_number; ?>');" class="list<?php if($messagestatus=='unread'){ ?> new<?php } ?>" id="mailiddiv<?php echo $email_number; ?>">
<div class="dateright"><?php echo date('h:i A',strtotime($date)); ?> - <?php if(date('Y-m-d',strtotime($date))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($date)); } ?></div>
<div class="heading"> <?php echo stripslashes($mailUserName); ?></div>
<div class="shorttext"><?php echo substr(stripslashes($subject),0,100); ?>...</div>
</div>
		  
	<?php $n++; } $totalmail++;  } } }} } ?>
	
	
	
	
	
	
	
	
	
	
<script>
<?php
$tmail=$n-1;

if($tmail=='-1'){
$tmail='0';
}

?>

$('.newmailcome').text('<?php echo $tmail; ?>');
</script>
	
	 <?php }  
	 
	 
	 
	 
	 
	 
	 ////////////////////Mail Type 12  STart	 

if($_REQUEST['mailtype']==12){ 

$wheremail='';
$where2='';

if($_REQUEST['mailtype']=='12'){
$where2=' and mailStatus=1 ';
}



if($_REQUEST['searchkeyword']!=''){
$wheremail=' and subject like "%'.$_REQUEST['searchkeyword'].'%" or mailUserName like "%'.$_REQUEST['searchkeyword'].'%" or mailFrom like "%'.$_REQUEST['searchkeyword'].'%"';
}


 include('incomingMailSetting.php');




$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to domain:' . imap_last_error()); 

$emails = imap_search($inbox,'ALL');   
if($emails){  
$output = ''; 
 
rsort($emails);  
$totalmail=0;
$n=1;
foreach($emails as $email_number) { 

if($totalmail<100){ 




$subject='';  
$message='';  
$body='';  
$email='';  
$date='';
 

$overview = imap_fetch_overview($inbox,$email_number,0);  
$subject = $subject=$overview[0]->subject; 

  

$messagestatus =  $overview[0]->seen ? 'read' : 'unread';

$mailUserName = addslashes(strip_tags($overview[0]->from));
$email=$from=$overview[0]->from;  
   
$ccemail=$from=$overview[0]->cc;    
preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails);   
$email= str_replace('["','',json_encode($found_mails[0]));   
$email=  str_replace('"]','',$email);  
$structure = imap_fetchstructure($inbox, $email_number); 
 
$timestamp = strtotime($date=$overview[0]->date);  
date_default_timezone_set('asia/kolkata');  
$date = date('Y-m-d H:i:s',$timestamp);

$select1='*';  
$where1='mailId="'.$email_number.'" and deletestatus=0'; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$queryiddata=mysqli_fetch_array($rs1);
$countUnconvertedMail = mysqli_num_rows($rs1);

$select='*';    
$where='dateTime="'.$timestamp.'" order by id asc';  
$rs=GetPageRecord($select,'trashMailMaster',$where); 
 if(mysqli_num_rows($rs)<1){ 
 if($subject!='Mail delivery failed: returning message to sender' && $subject!='Mail Delivery System' && $subject!='OTP for TravCRM login' && $messagestatus!='unread' && $countUnconvertedMail < 1){
 
 
  if (strpos($subject, '#00') !== false) { } else {
  

$select='*';    
$where=' mailId="'.$email_number.'" order by id asc';  
$rs=GetPageRecord($select,'unattendedMailMaster',$where);  
$costSheetListing=mysqli_fetch_array($rs);

  

if(mysqli_num_rows($rs)>0){  
$namevalue ='mailSubject="'.$mailUserName.'",mailBody="'.$subject.'",dateTime="'.strtotime($date).'",addedBy="'.$_SESSION['userid'].'"';
$where1='mailId="'.$email_number.'"'; 
updatelisting('unattendedMailMaster',$namevalue,$where1); 
}else{  
$namevalue ='mailSubject="'.$mailUserName.'",mailId="'.$email_number.'",mailBody="'.$subject.'",dateTime="'.strtotime($date).'",addedBy="'.$_SESSION['userid'].'"';   
 addlistinggetlastid('unattendedMailMaster',$namevalue);  
}
  
  
  
?> 
<div onclick="funreadmailsection('<?php echo $email_number; ?>');" class="list<?php if($messagestatus=='unread'){ ?> new<?php } ?>" id="mailiddiv<?php echo $email_number; ?>">
<div class="dateright"><?php echo date('h:i A',strtotime($date)); ?> - <?php if(date('Y-m-d',strtotime($date))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($date)); } ?></div>
<div class="heading"> <?php echo stripslashes($mailUserName); ?></div>
<div class="shorttext"><?php echo substr(stripslashes($subject),0,100); ?>...</div>
</div>
		  
	<?php $n++; } $totalmail++;  } }  }} } ?> 
	
<script>
<?php
$tmail=$n-1;

if($tmail=='-1'){
$tmail='0';
}

?>

$('.unconvertedcome').text('<?php echo $tmail; ?>');
</script>
	
	 <?php }  
////////////////////Mail Type 12 End	 
	 	 
	 





/*<!----------------------------------------------------------------------Trash Mails Start--------------------------------------------------->*/
if($_REQUEST['mailtype']==5){ 


$wheremail='';
$where2='';

if($_REQUEST['mailtype']=='12'){
$where2=' and mailStatus=1 ';
}



if($_REQUEST['searchkeyword']!=''){
$wheremail=' and subject like "%'.$_REQUEST['searchkeyword'].'%" or mailUserName like "%'.$_REQUEST['searchkeyword'].'%" or mailFrom like "%'.$_REQUEST['searchkeyword'].'%"';
}


 include('incomingMailSetting.php');




$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to domain:' . imap_last_error()); 

$emails = imap_search($inbox,'ALL');   
if($emails){  
$output = ''; 
 
rsort($emails);  
$totalmail=0;
$n=1;
foreach($emails as $email_number) { 

if($totalmail<100){ 




$subject='';  
$message='';  
$body='';  
$email='';  
$date='';
 

$overview = imap_fetch_overview($inbox,$email_number,0);  
$subject = $subject=$overview[0]->subject; 

  

$messagestatus =  $overview[0]->seen ? 'read' : 'unread';

$mailUserName = addslashes(strip_tags($overview[0]->from));
$email=$from=$overview[0]->from;  
   
$ccemail=$from=$overview[0]->cc;    
preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails);   
$email= str_replace('["','',json_encode($found_mails[0]));   
$email=  str_replace('"]','',$email);  
$structure = imap_fetchstructure($inbox, $email_number); 
 
$timestamp = strtotime($date=$overview[0]->date);  
date_default_timezone_set('asia/kolkata');  
$date = date('Y-m-d H:i:s',$timestamp);

$select1='*';  
$where1='mailId="'.$email_number.'" and deletestatus=0'; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$queryiddata=mysqli_fetch_array($rs1);
$countUnconvertedMail = mysqli_num_rows($rs1);
 
 if($subject!='Mail delivery failed: returning message to sender' && $subject!='Mail Delivery System' && $subject!='OTP for TravCRM login' && $messagestatus!='unread' && $countUnconvertedMail < 1){
 
 
  if (strpos($subject, '#00') !== false) { } else {
  

$select='*';    
 $where='dateTime="'.strtotime($date).'" order by id desc';  
$rs=GetPageRecord($select,'trashMailMaster',$where);  
$costSheetListing=mysqli_fetch_array($rs); 
if(mysqli_num_rows($rs)>0){  
 $getdatatrash=mysqli_fetch_array($rs);
   
?> 
<div onclick="funreadmailsection('<?php echo $email_number; ?>');" class="list<?php if($messagestatus=='unread'){ ?> new<?php } ?>" id="mailiddiv<?php echo $email_number; ?>">
<div class="dateright"><?php echo date('h:i A',strtotime($date)); ?> - <?php if(date('Y-m-d',strtotime($date))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($date)); } ?></div>
<div class="heading"> <?php echo stripslashes($mailUserName); ?></div>
<div class="shorttext"><?php echo substr(stripslashes($subject),0,100); ?>...</div>
</div>
		  
	<?php $n++; } } $totalmail++;  }    }} } ?> 
	
<script>
<?php
$tmail=$n-1;

if($tmail=='-1'){
$tmail='0';
}

?>

$('.unconvertedcome').text('<?php echo $tmail; ?>');
</script>
	
	 <?php  }

/*<!----------------------------------------------------------------------Trash Mails End--------------------------------------------------->*/






if($_REQUEST['mailtype']==3){




$select1='*';    
$where1='id="'.$_SESSION['userid'].'"';  
$rs1=GetPageRecord($select1,'userMaster',$where1);  
$getusername=mysqli_fetch_array($rs1);  
 
 


$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' mailStatus=3  and fromSection="'.$getusername['email'].'" order by mailDate desc limit 0,200';  
$rs=GetPageRecord($select,_MAIL_SECTION_MASTER_,$where);  
while($maillist=mysqli_fetch_array($rs)){  

?> 
		<div onclick="funreadmailsection('<?php echo $maillist['id']; ?>');" class="list<?php if($maillist['mailStatus']==1){ ?> new<?php } ?>" id="mailiddiv<?php echo $maillist['id']; ?>">
		<div class="dateright"><?php echo date('h:i A',strtotime($maillist['mailDate'])); ?> - <?php if(date('Y-m-d',strtotime($maillist['mailDate']))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($maillist['mailDate'])); } ?></div>
		<div class="heading"><?php echo substr(stripslashes($maillist['subject']),0,100); ?></div>
		<div class="shorttext"><?php echo stripslashes($maillist['mailFrom']); ?></div>
		</div>
	<?php if($maillist['mailStatus']==1){ $n++; } } ?>
 
	
	 <?php }  





if($_REQUEST['mailtype']==5){
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' mailStatus=5  and fromSection="'.$mainmailid['email1'].'" order by mailDate desc limit 0,200';  
$rs=GetPageRecord($select,_MAIL_SECTION_MASTER_,$where);  
while($maillist=mysqli_fetch_array($rs)){  

?> 
		<div onclick="funreadmailsection('<?php echo $maillist['id']; ?>');" class="list<?php if($maillist['mailStatus']==1){ ?> new<?php } ?>" id="mailiddiv<?php echo $maillist['id']; ?>">
		<div class="dateright"><?php echo date('h:i A',strtotime($maillist['mailDate'])); ?> - <?php if(date('Y-m-d',strtotime($maillist['mailDate']))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($maillist['mailDate'])); } ?></div>
		<div class="heading"><?php echo stripslashes($maillist['mailUserName']); ?></div>
		<div class="shorttext"><?php echo substr(stripslashes($maillist['subject']),0,100); ?>...</div>
		</div>
	<?php   } ?>
 
 <script>
$('.mailarearight .fa').hide();
</script>
	
	 <?php } ?> 
	 
	 
	 
	 
	 
	 
	 
	 
 <script>
$('.mailarearight .heading').hide();
$('#newmailcreate').show();
$('#showloadmailloading').hide();

</script>
		 
	 
	 