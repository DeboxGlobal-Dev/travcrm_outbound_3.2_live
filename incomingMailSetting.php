<?php
$select1='*';    
$where1='id="'.$_SESSION['userid'].'"';  
$rs1=GetPageRecord($select1,'userMaster',$where1);  
$getusername=mysqli_fetch_array($rs1);  

$select='*';  
$where='email="'.$getusername['email'].'"';  
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);  

if(mysqli_num_rows($rs) == 0){
    // lets pick default one.
	$select='*';  
	$where=' 1 and isDefault=1 ';  
	$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);  
}

if(mysqli_num_rows($rs) > 0){
    
    $emailsetting=mysqli_fetch_array($rs);    
    
    $imap_server=clean($emailsetting['imap_server']); // should be same as smtp_server
    $imap_port=clean($emailsetting['imap_port']);  // 143/993
    $imap_security_type=clean($emailsetting['imap_security_type']);  // ssl/notls 
    $imap_filter=clean($emailsetting['imap_filter']);  
    
    $hostname = '{'.$imap_server.':'.$imap_port.'/imap/'.$imap_security_type.'}'.$imap_filter.'';  
    
    // $hostname = '{'.$smtp_server.':143/notls}';  
    // $hostname = "{imappro.zoho.com:993/imap/ssl}INBOX"; 
    // $hostname = "{mail.traveldeckdmc.com:993/imap/ssl}INBOX";
    // $hostname = "{smtp.office365.com:993/ssl}INBOX";
    
    $username=clean($emailsetting['email']);  
    $password=decode($emailsetting['password']);   

    $is_emailsetting = 1;
}else{
    $is_emailsetting = 0;
    ?>
    <script>
    alert('No email settings found for this user and no default settings available.');
    </script>
    <?php
    header('location:'.$fullurl);
    exit();
}
?>