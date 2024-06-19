<?php  
include "inc.php"; 
$select=''; 
$where=''; 
$rs='';  
$select='*'; 
$where='id="'.$_SESSION['userid'].'" and email="'.$_SESSION['username'].'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$LoginUserDetails=mysqli_fetch_array($rs); 
$id=$LoginUserDetails['id'];
$select1='*';  
$where1='id="'.$id.'"'; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

if($_REQUEST['id']!='' && $_REQUEST['id']!='na' && $_REQUEST['id']!='newmail'){ 
include('incomingMailSetting.php'); 
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to domain:' . imap_last_error()); 
$emails = imap_search($inbox,'ALL');   
if($emails){   
$output = ''; 
 
rsort($emails);  
$totalmail=0;
$n=1;
foreach($emails as $email_number) { 
if($email_number==$_REQUEST['id']){  
$subject='';  
$message='';  
$body='';  
$email='';  
$date='';
  
$overview = imap_fetch_overview($inbox,$email_number,0);   
$subject = $subject=$overview[0]->subject;  
$message='';
    
	$message = (imap_fetchbody($inbox,$email_number,'2'));
	
	if (count(explode(' ', trim($message))) > 2) {} else {
	$message = nl2br(imap_fetchbody($inbox,$email_number,1));
	$g='1';
	} 
	
	if(trim($message)=='' && $g!='1'){
	$message = nl2br(imap_fetchbody($inbox,$email_number,'1'));
	}
   
   
   $mailUserName = addslashes(strip_tags($overview[0]->from));
$email=$mailUserName=$overview[0]->from;   
$ccemail=$from=$overview[0]->cc;    
preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $email, $found_mails);   
$email= str_replace('["','',json_encode($found_mails[0]));   
$email=  str_replace('"]','',$email);   
 
$timestamp = strtotime($date=$overview[0]->date);  
date_default_timezone_set('asia/kolkata');  
$date = date('Y-m-d H:i:s',$timestamp);
  
  $wheredel='dateTime<="'.strtotime("-1 month").'"';
  deleteRecord('trashMailMaster',$wheredel);
$select='*';    
$where='dateTime="'.($timestamp).'" order by id desc';  
$rs=GetPageRecord($select,'trashMailMaster',$where);  
if(mysqli_num_rows($rs)>0){ 
  ?>
  <script> 
  setTimeout(function(){
  parent.$('#dlebtn').hide();
  }, 1000);
  </script>
  <?php
  }
 
     } }}   
	
	 
 
 
 
$select1='*';  
$where1='mailId="'.$_REQUEST['id'].'" and deletestatus=0'; 
$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1); 
$queryiddata=mysqli_fetch_array($rs1); 
 
?>	
<script>
<?php if($queryiddata['id']==''){ ?>
//alert();
$('#converttoquerybtn').css('display','block');
$('#gotoquerybtn').css('display','none');
<?php } else { ?>
$('#converttoquerybtn').css('display','none');
$('#gotoquerybtn').css('display','block'); 
<?php } ?>
$('#mailiddiv<?php echo $_REQUEST['id']; ?>').removeClass('new');
$('#showloadmailloading').hide();
function gotoquery(){ 
window.location.href = 'showpage.crm?module=query&view=yes&id=<?php echo encode($queryiddata['id']); ?>';
}
</script>
<div class="readmailboxtop">
	<div class="rightdate"><?php echo date('h:i A',strtotime($date)); ?> - <?php if(date('Y-m-d',strtotime($date))==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',strtotime($date)); } ?></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" valign="top">
	<i class="fa fa-user maileruser"></i>
	</td>
    <td width="95%" align="left" valign="top"><div class="mailusername"><?php echo stripslashes($mailUserName); ?></div>
      <div class="mailuseremail"><?php if($email!=''){ echo 'From: '.$email; } else {  echo stripslashes($mailUserName); } ?></div></td>
  </tr>
</table>
</div>
	<div id="readmailbox">
	<div class="subjectdiv" style="position:relative;"><?php echo stripslashes($subject); ?>
	<?php if($readmaildata['assignToQuery']>0){ ?>
	<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($readmaildata['assignToQuery']); ?>"><div style="position: absolute;
    right: 0px;
    top: 0px;
    font-size: 13px;
    background-color: #09a748;
    color: #FFFFFF;
    padding: 7px 20px;
    border-radius: 5px;">View Query</div></a>
	<?php } ?>
	</div>
	<div class="bodydiv"><?php echo stripslashes(imap_qprint($message)); ?></div>
	
	<div style="margin-top:20px; margin-bottom:20px; overflow:hidden;">
	<?php
	$value2='';
	$string='';
	$string = $readmaildata['mailAttachment'];
$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
$array = explode(',', $string); //split string into array seperated by ', '
foreach($array as $value) //loop over values
{ 
if($value!='' && $value2!=$value){
$value2=$value;
?>
   <a href="upload/<?php echo $value; ?>" target="_blank" style="padding: 10px;
    border: 1px #ccc solid;
    float: left;
    display: block;
    border-radius: 4px;
    color: #292929 !important;
    outline: none;
    text-decoration: none;
    margin-right: 5px;
    background-color: #dadada3b;"><i class="fa fa-download" aria-hidden="true"></i> <?php echo $value; ?></a> 
<?php } }
?>
	
	
	</div>
	</div>
<script>
function gototrash(){ 

var subjectmail = encodeURI('<?php echo $subject; ?>');
var dateTime = Number('<?php echo $timestamp; ?>');  
$('#shortmail').load('load_short_mail.php?id=<?php echo $_REQUEST['id']; ?>&dateTimeadd=<?php echo $timestamp; ?>&status=5&mailtype=1&mailid=<?php echo $_REQUEST['mailid']; ?>&subjectmail='+subjectmail);


funreadmailsection('na');
}
$('.mailarearight .heading').hide();
$('.mailarearight .fa').show();
$('#mailiddiv<?php echo $readmaildata['id']; ?>').removeClass('new');
<?php if($readmaildata['assignToQuery']>0){ ?>
$('.writeclass').hide();
<?php } ?>
<?php if($readmaildata['mailStatus']==5){ ?>
$('.mailarearight .fa-trash').hide();
<?php } ?>
function replymail(){
//$('#readmailsection').load('load_read_mail.php?id=newmail&mailid=<?php echo $readmaildata['id']; ?>&reply=1&mailid=<?php echo $_REQUEST['mailid']; ?>');
$('#readmailsection').load('load_read_mail.php?id=newmail&mailid=<?php echo $readmaildata['id']; ?>&reply=1');
}
function forwordmail(){
$('#readmailsection').load('load_read_mail.php?id=newmail&mailid=<?php echo $readmaildata['id']; ?>&mailid=<?php echo $_REQUEST['mailid']; ?>');
}
function converttoqueryfunction(){  
window.location.href = 'showpage.crm?module=query&add=yes&incomingid=<?php echo encode($_REQUEST['id']); ?>&mailid=<?php echo $_REQUEST['mailid']; ?>&email=<?php echo encode($email); ?>'; 
}
</script>	
	
	
	 
<?php 


} 
if($_REQUEST['id']=='na'){ ?>
<?php if($_REQUEST['sent']==1){ ?>
<div class="readmailboxtop" style="text-align:center; padding:200px; border:0px;"><img src="images/inboxiconanimation_30.gif" width="200" />
  <br />
  <br />
Mail Sent
<?php } else { ?>
<div class="readmailboxtop" style="text-align:center; padding:200px; border:0px;"><img src="images/nomailicon.png" width="100" />
  <br />
  <br />
No Mail Selected</div>
<?php } ?>
<script>
$('.mailarearight .fa').hide();
$('.mailarearight .heading').hide();
$('#newmailcreate').show();
</script> 
<?php } ?>
<script>
$('#newmailcreate').show();
</script>
<?php if($_REQUEST['id']=='newmail'){
if($_REQUEST['mailid']!='13'){  
$select1='*';  
$where1='id="'.$_REQUEST['mailid'].'"';  
$rs1=GetPageRecord($select1,_MAIL_SECTION_MASTER_,$where1);  
$readmaildata=mysqli_fetch_array($rs1); 
} 
 ?> 
<script src="tinymce/tinymce.min.js"></script> 
<script type="text/javascript"> 
    tinymce.init({ 
        selector: "#description", 
        themes: "modern",    
        plugins: [ 
            "advlist autolink lists link image charmap print preview anchor", 
            "searchreplace visualblocks code fullscreen"  
        ], 
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"  
    });
 
    </script>
 
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery"> 
<div id="readmailbox" style="padding:30px;"> 
<select id="fromMail" name="fromMail"   autocomplete="off"   style="padding:10px; font-size:14px; width:100%; box-sizing:border-box; margin-bottom:10px; border: 1px #ccc solid;"   >  
<?php 
$select=''; 
$where=''; 
$rs='';   
$select='*';   
if($_SESSION['userid']==37){ 
$where=' status=1 order by id asc'; 
} else {  
$where=' status=1 and email1="'.$LoginUserDetails['email'].'" order by id asc'; 
}  
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where); 
while($rest=mysqli_fetch_array($rs)){  
?> 
<option value="<?php echo $rest['email1']; ?>">From: <?php echo $rest['from_name1']; ?> - <?php echo $rest['email1']; ?></option>  
<?php } ?> 
</select> 
<input name="to" type="text" id="to" value="<?php if($_REQUEST['reply']==1){ echo stripslashes($readmaildata['mailFrom']); } ?>"  style="padding:10px; font-size:14px; width:100%; box-sizing:border-box; margin-bottom:10px; border: 1px #ccc solid;" placeholder="To (Example: mail@domainname.com)"/>
<input name="subject" type="text" id="subject" value="<?php echo stripslashes($readmaildata['subject']); ?>"  style="padding:10px; font-size:14px; width:100%; box-sizing:border-box; margin-bottom:10px;    border: 1px #ccc solid;" placeholder="Subject"/>
<textarea name="description" rows="10" class="gridfield" id="description"><br><br><br><?php echo stripslashes($LoginUserDetails['emailsignature']); ?></textarea>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
  <tr>
    <td colspan="2" align="left" valign="top"><label>
      <div style="margin-bottom:5px; display:none;">Attachment</div><input name="uploadfile" type="file" id="uploadfile"  style="display:none;" />
    </label></td>
    <td width="50%" align="right" valign="top"><input type="submit" name="Submit" value="Send Mail" class="bluembutton" /></td>
  </tr>
</table>
</div>
<input name="action" type="hidden" id="action" value="createnewmail" />
</form>
<script>
$('#converttoquerybtn').hide();
$('#gotoquerybtn').hide();
$('.mailarearight .fa').hide();
$('.mailarearight .heading').show();
$('.mailarearight .heading').text('New Mail');
$('#newmailcreate').hide();
</script> 
<?php } ?>
<?php if($mailStatusval==1){ ?>
<script>
var newmailcome = Number($('.newmailcome').text());
if(newmailcome!=0){
$('.newmailcome').text(Number(newmailcome-1));
}
</script>
<?php } ?>
<?php if($readmaildata['convertQuery']>0){ ?> 
<script>
$('#converttoquerybtn').hide();
$('#gotoquerybtn').show();
$('#gotoquerybtn').removeClass('hideclass');
$('#gotoqueryspan').text('(#<?php echo makeQueryId($queryiddata['id']); ?>)');
</script> 
<?php } ?>
<?php if($readmaildata['convertQuery']=='0'){ ?> 
<script>
$('#converttoquerybtn').show();
$('#gotoquerybtn').hide();
</script> 
<?php } ?>
	

