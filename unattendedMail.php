<?php include('inc.php');  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Unattended Mails</title>
<style>
body{

    background-color: #5f5f5f;
font-family:Arial, Helvetica, sans-serif;
}
.maildiv{
margin:auto;
width:790px;
padding:10px; 
border:1px solid #cccc;
border-radius:3px;
background:#FFFFFF;

}
.titlediv{
    text-align: center;
    font-size: 30px;
    color: #ff661f;
    font-weight: 600;
    margin-top: 37px;
}
.mailbody{
margin-top:20px;
font-size: 14px;
margin-bottom: 20px;
background-color: #ffe8c5;
padding: 10px;  
}
.subj{
float: left;
color: #e99a23;
width: 50%;
font-size:15px;
}
.subjtime{
float: right;
width: 50%;
text-align: right;
}
.maildes{
margin-top: 25px !important;
}
.countMail{
border: 1px solid #ccc;
border-radius: 3px;
padding: 7px; 
text-align: center;
margin-top: 40px;
color: #fff;
background-color: #1f95b8;
}

.norecords{
margin: 50px 0px 20px 0px;
text-align: center;
}

</style>
</head>

<body>
<div class="maildiv">
<div class="titlediv">Unattended Mails Report <?php echo date('d-m-Y'); ?></div>
<?php
$select='addedBy';    
$where='sendMailStatus=0 group by addedBy order by dateTime desc';  
$rs=GetPageRecord($select,'unattendedMailMaster',$where);
if(mysqli_num_rows($rs)>0){  
while($costSheetListing=mysqli_fetch_array($rs)){

$selectc='*';    
$wherec='addedBy="'.$costSheetListing['addedBy'].'" and sendMailStatus=0 order by dateTime desc';  
$rsc=GetPageRecord($selectc,'unattendedMailMaster',$wherec); 
?>
<div class="countMail">Mails <?php echo mysqli_num_rows($rsc); ?>&nbsp;&nbsp;<?php echo getUserName($costSheetListing['addedBy']); ?></div> 
<?php
$selectr='*';    
$wherer=' addedBy="'.$costSheetListing['addedBy'].'" and sendMailStatus=0 and mailBody NOT Like "%Unattended Mails Report%" and mailBody NOT Like "%Todays Query Status Report%" and mailBody NOT Like "%User Wise Query Report%" order by dateTime desc';  
$rsr=GetPageRecord($selectr,'unattendedMailMaster',$wherer);
while($getmail=mysqli_fetch_array($rsr)){
 ?>  
<div class="mailbody">
<div class="subj"> <?php echo substr($getmail['mailSubject'],0,40); ?> </div>
<div class="subjtime"> <?php echo date('h:i A',$getmail['dateTime']); ?> - <?php if(date('Y-m-d',$getmail['dateTime'])==date('Y-m-d')){ ?> Today<?php } else {  echo date('d-m-Y',$getmail['dateTime']); } ?> </div>
<div class="maildes"><?php echo substr($getmail['mailBody'],0,70); ?></div>
</div>
<?php 

if($_REQUEST['sendreport']==1){
$namevalue ='sendMailStatus="1",sendMailDate="'.time().'"';
$where1='dateTime="'.$getmail['dateTime'].'"'; 
//updatelisting('unattendedMailMaster',$namevalue,$where1);
}

 } } }else{
 ?>
 <div class="norecords">No Mails Found...</div>
 <?php
 } ?>
</div>
</body>
</html>
