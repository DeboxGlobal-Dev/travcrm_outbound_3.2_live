<?php
include "inc.php";
if($_REQUEST['id']!=''){
$id=$_REQUEST['id'];



$select1='*';  
$where1='id='.decode($id).' '; 
$rs1=GetPageRecord($select1,'conferencesMaster',$where1); 
$resultlists=mysqli_fetch_array($rs1); 

 




if($_REQUEST['pid']!='home' && $_REQUEST['pid']!='Agenda' && $_REQUEST['pid']!='registration' && $_REQUEST['pid']!='accommodation'){
$select12='*';  
$where12='pageurl="'.$_REQUEST['pid'].'" and cid='.$resultlists['id'].' '; 
$rs12=GetPageRecord($select12,'conferencesPagesMaster',$where12); 
$resultlistspage=mysqli_fetch_array($rs12);

$pagename=$resultlistspage['name'];
}  else { 
$pagename=$_REQUEST['pid'];

}
}  


if($_REQUEST['logoutyes']=='1'){

$_SESSION['conlogin']='';
}


if($_REQUEST['action']=='login' && $_REQUEST['email']!='' && $_REQUEST['password']!=''){

 
$email=$_REQUEST['email']; 
$password=$_REQUEST['password'];  
$cid=$_REQUEST['cid'];  
 

$select12='*';  
$where12='cid="'.$cid.'" and email="'.$email.'" and password="'.$password.'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$resultlistspage2=mysqli_fetch_array($rs12);

if($resultlistspage2['id']==''){
?>
<script>
alert('Invalid Login.');
</script>

<?php
  
} else {
 
 $_SESSION['conlogin']=$email; 
 
 header("location: ".$fullurl."confrence/".$id."/registration.html");

}  

}  





if($_REQUEST['action']=='confrenceRegister' && $_REQUEST['cid']!='' && $_REQUEST['name']!='' && $_REQUEST['email']!='' && $_REQUEST['password']!='' && $_REQUEST['password2']!='' && $_REQUEST['logoutyes']!='1'){


$cid=$_REQUEST['cid'];
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$phone=$_REQUEST['phone'];
$password=$_REQUEST['password']; 
$password2=$_REQUEST['password2']; 


$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$select12='*';  
$where12='cid="'.$cid.'" and email="'.$email.'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$resultlistspage2=mysqli_fetch_array($rs12);

if($resultlistspage2['id']!=''){
?>
<script>
alert('Email Address is Already Registered.');
</script>

<?php
  
}

if($password!=$password2){
?>
<script>
alert('Password and confirm password does not match.');
</script>

<?php
 }


if($resultlistspage2['id']=='' && $password==$password2){

$namevalue ='cid="'.$cid.'",name="'.$name.'",phone="'.$phone.'",password="'.$password.'",email="'.$email.'",addDate="'.date('Y-m-d H:i:s').'"'; 
addlisting('confrenceRegister',$namevalue); 
$_SESSION['conlogin']=$email; 

}

}  






if($_REQUEST['action']=='confrencebooking' && $_REQUEST['cid']!='' && $_REQUEST['ccy']!='' && $_REQUEST['fee_id']!='' && $_REQUEST['userId']!='' && $_REQUEST['logoutyes']!='1'){


$fee_id=$_REQUEST['fee_id'];  

$select12='*';  
$where12='feeType="'.$fee_id.'" and startDate<="'.date('Y-m-d').'" and endDate>="'.date('Y-m-d').'" '; 
$rs12=GetPageRecord($select12,'conferencesFee',$where12);  
$resultlistspage4=mysqli_fetch_array($rs12);

$cid=$_REQUEST['cid'];
$userId=$_REQUEST['userId'];
$dayType=$resultlistspage4['feeType'];
$dayFee=$resultlistspage4['fee'];
$startDate=$resultlistspage4['startDate'];
$endDate=$resultlistspage4['endDate']; 
$ccy=$_REQUEST['ccy'];


$namevalue ='cid="'.$cid.'",userId="'.$userId.'",dayType="'.$dayType.'",dayFee="'.$dayFee.'",ccy="'.$ccy.'",startDate="'.$startDate.'",endDate="'.$endDate.'",addDate="'.date('Y-m-d H:i:s').'"'; 
addlisting('confrenceBooking',$namevalue); 

include "config/mail.php"; 


$select12='*';  
$where12='email="'.$_SESSION['conlogin'].'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$resultlistspage2=mysqli_fetch_array($rs12);


$subject='Registration Confirmation ('.$resultlists['name'].')';
$maildescription='Dear '.$resultlistspage2['name'].',<br><br>

You have successfully registered for conference.<br>
for more details please visit to following url:<br><br>
'.$fullurl.'confrence/'.encode($resultlists['id']).'/home.html<br><br><br><br>Thank You<br>Team DeBox';

send_template_mail($fromemail,$_SESSION['conlogin'],$subject,$maildescription,'');



}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo ucfirst($pagename);if($_REQUEST['pid']=='agenda'){ echo 'Agenda'; } ?> - <?php echo strip($resultlists['name']); ?></title>

<script type="text/javascript" src="<?php echo $fullurl; ?>js/jquery.min.js"></script> 
<script defer src="<?php echo $fullurl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $fullurl; ?>js/zebra_datepicker.js"></script>
<link href="<?php echo $fullurl; ?>css/default.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $fullurl; ?>css/flexslider.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>


body{margin:0px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#333333; background-color:#F9F9F9;}
.menumain{overflow:hidden; text-align:center; color:#FFFFFF; background-color:#0066CC;}
.menumain a {
    display: inline-block;
    color: #fff;
    text-decoration: none;
    padding: 14px 20px;
    font-size: 15px;
    border-left: #ffffff1c solid 1px;
    border-right: #ffffff1c solid 1px;
}
.menumain a:hover{background-color: #004673;}
.menumain .active{background-color: #004673;}
.listouterb{    border: 1px solid #cccccc75;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #cccccc1c;
    box-shadow: 2px 2px 2px #cccccc57;}
</style>
</head>

<body>
<div style=" background-color:#FFFFFF;     padding: 10px 0px 0px;
    text-align: center;
    box-shadow: 0px 0px 10px #ccc;
    border-bottom: 0px solid #0470cc;    position: relative;">
<div style="margin-bottom:10px;"><a href="<?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/home.html"><img src="<?php echo $fullurl; ?><?php if($resultlists['logo']!=''){ ?>upload/<?php echo $resultlists['logo']; ?><?php } else { ?>images/nologo.jpg<?php } ?>" width="150" border="0"  ></a></div>
<h2 style="    font-size: 30px;
    line-height: 20px;
    margin: 0px;
    padding: 0px; color:#004c98; margin-bottom:10px;"><?php echo strip($resultlists['name']); ?></h2>
	<div style="text-align:center; margin-bottom:20px; font-size:16px;"><?php echo date('j, F Y',strtotime($resultlists['startDate'])); ?> to <?php echo date('j, F Y',strtotime($resultlists['endDate'])); ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $resultlists['address']; ?></div>
	
	
	<div class="menumain">
	<div class="dropdown"><a href="<?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/home.html"  <?php if($_REQUEST['pid']=='home'){ ?>class="active"<?php } ?>>Home</a></div>
	<div class="dropdown"><a href="<?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/agenda.html"  <?php if($_REQUEST['pid']=='agenda'){ ?>class="active"<?php } ?>>Agenda</a></div>
	<div class="dropdown"><a href="<?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/registration.html"  <?php if($_REQUEST['pid']=='registration'){ ?>class="active"<?php } ?>>Registration</a></div>
	
	<div class="dropdown"><a href="<?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/accommodation.html"  <?php if($_REQUEST['pid']=='accommodation'){ ?>class="active"<?php } ?>>Accommodation</a></div>
	
	<?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and cid='.$resultlists['id'].' and name!="Home Content" and parentPage=0 order by sr asc';  
		$rs=GetPageRecord($select,'conferencesPagesMaster',$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
		<div class="dropdown">
	<a href="<?php echo $fullurl; ?>confrence/<?php echo $_REQUEST['id']; ?>/<?php echo $resListing['pageurl']; ?>.html" <?php if($_REQUEST['pid']==$resListing['pageurl']){ ?>class="active"<?php } ?>><?php echo strip($resListing['name']); ?></a> 
	
	 <div class="dropdown-content">
	 <?php 
		 
		$select3='*';    
		$where3=' 1 and cid='.$resultlists['id'].' and name!="Home Content" and parentPage='.$resListing['id'].' order by sr asc';  
		$rs3=GetPageRecord($select,'conferencesPagesMaster',$where3); 
		while($resListing3=mysqli_fetch_array($rs3)){  
		?>
    <a href="<?php echo $fullurl; ?>confrence/<?php echo $_REQUEST['id']; ?>/<?php echo $resListing3['pageurl']; ?>.html"><?php echo strip($resListing3['name']); ?></a> 
	
	<?php } ?>
  </div></div>
	<?php } ?>
	
	</div>
</div>

<?php if($_REQUEST['pid']=='home'){ ?>
<div style="width:100%; overflow:hidden; max-height:500px; overflow:hidden;">
<div class="flexslider"> 
  <ul class="slides">
 

	<li><img src="<?php echo $fullurl; ?>images/banner.jpg" /></li> 


	<li><img src="<?php echo $fullurl; ?>images/banner.jpg" /></li>
  </ul>
</div>
</div>
<?php } ?>

<div style="padding:50px 30px; background-color:#FFFFFF; max-width:1100px; margin:auto; font-size:14px; box-shadow: 0px 0px 10px #ccc;">
<?php
$select12='*';  

if($_REQUEST['pid']=='home'){
$where12='name="Home Content" and cid='.$resultlists['id'].' '; 
} else {
$where12='pageurl="'.$_REQUEST['pid'].'" and cid='.$resultlists['id'].' ';
} 

$rs12=GetPageRecord($select12,'conferencesPagesMaster',$where12); 
$homecontent=mysqli_fetch_array($rs12);


 if($_REQUEST['pid']!='home'){ ?><h1 style="text-align:center; font-size:35px; margin-bottom:30px;"><?php echo stripslashes($homecontent['name']); ?></h1><?php } 
 
 
 
   if($_REQUEST['pid']=='accommodation'){ 
   
   
   
    
   if($_REQUEST['action']=='accommodation' && $_REQUEST['category']!='0' && $_REQUEST['hotel']!='0' && $_REQUEST['fromDate']!='' && $_REQUEST['toDate']!='' && $_REQUEST['occupancy']!='0'){ 
    $category=$_REQUEST['category'];
   $hotel=$_REQUEST['hotel'];
   $fromDate=date('Y-m-d',strtotime($_REQUEST['fromDate']));
   $toDate=date('Y-m-d',strtotime($_REQUEST['toDate']));
   $occupancy=$_REQUEST['occupancy'];
   $guest=$_REQUEST['guest'];
   $id=decode($_REQUEST['id']);
   $addDate=date('Y-m-d H:i:s');
   $userId='0'; 
 
 $namevalue ='category="'.$category.'",hotel="'.$hotel.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",occupancy="'.$occupancy.'",guest="'.$guest.'",confrenceId="'.$id.'",addDate="'.$addDate.'",userId="'.$userId.'"';   
addlistinggetlastid('confrenceHotelMaster',$namevalue);

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

header("location: ".$actual_link."");
   }
   
   
     if($_REQUEST['action']=='deleteairlineacc' && $_REQUEST['did']!=''){ 
 $sql_del="delete from 	confrenceAirlineMaster  where id='".$_REQUEST['did']."'"; 
 mysqli_query($sql_del) or die(mysqli_error(db()));
	}
	
	
		if($_REQUEST['action']=='deletecaracc' && $_REQUEST['did']!=''){ 
		$sql_del="delete from 	confrenceCarMaster  where id='".$_REQUEST['did']."'"; 
		mysqli_query($sql_del) or die(mysqli_error(db()));
		}
	
   
    if($_REQUEST['action']=='deletehotelacc' && $_REQUEST['did']!=''){ 
 $sql_del="delete from confrenceHotelMaster  where id='".$_REQUEST['did']."'"; 
 mysqli_query($sql_del) or die(mysqli_error(db()));
	}
   
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
   
   
   
   ?><h1 style="text-align:center; font-size:35px; margin-bottom:30px;">Accommodation</h1>
  
  
  <style>
  .tabsacc{overflow:hidden;}
  .tabsacc a{    float: left;
    padding: 15px 0px;
    width: 33.33%;
    color: #0066CC;
    font-size: 17px;
    font-weight: 600;
    background-color: #efefef;
    text-align: center;
    text-decoration: none;}
	
	.tabsacc .active{background-color:#0066CC !Important; color:#FFFFFF;}
	
	.tbcontentbox{border:2px solid #0066CC; padding:0px;}
  </style>
  
  
  <script>
  function contabsfun(id){
  $('.contabs').hide();
  $('.gdfd').removeClass('active');
  
  $('#'+id).show();
    $('#'+id+'bt').addClass('active');

  }
  </script>
  <?php if($_REQUEST['action']!='continewaccommodation'){
   
   ?>
   <div>
  <div class="tabsacc">
  <a href="#" class="gdfd active" id="confrencehoteltbbt" onClick="contabsfun('confrencehoteltb');"><i class="fa fa-bed" aria-hidden="true"></i>&nbsp;&nbsp;Book Hotel</a>
  <a href="#" class="gdfd"  id="confrencecartbbt"  onclick="contabsfun('confrencecartb');"><i class="fa fa-car" aria-hidden="true"></i>&nbsp;&nbsp;Book Car</a>
  <a href="#" class="gdfd"  id="confrenceflighttbbt"  style="float:right;" onClick="contabsfun('confrenceflighttb');"><i class="fa fa-plane" aria-hidden="true"></i>&nbsp;&nbsp;Book Flight</a>
  </div>

  </div>
    <div class="tbcontentbox">
	<div class="contabs" id="confrencehoteltb">
	<div style="padding:20px; background-color:#F5F5F5;">
	<form action="" method="post" enctype="multipart/form-data" name="addeditquery" >
	<table border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
  <td colspan="2">
  
  <script>
  function loadconfrencehotel(){
  var category = $('#category').val();
  $('#hotel').load('../../loadconfrencehotel.php?hotelCategory='+category+'&cityId=<?php echo str_replace(' ','%20',getDestination($resultlists['cityId'])); ?>');
  }
  </script>
	<select name="category" id="category" onChange="loadconfrencehotel();"  style="width:150px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" >
	<option value="0">Select Category</option>
	 <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where='  hotelCity="'.getDestination($resultlists['cityId']).'" group by hotelCategory order by hotelCategory asc';  
		$rs=GetPageRecord($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where); 
		while($datad=mysqli_fetch_array($rs)){  
		?>
	  <option value="<?php echo $datad['hotelCategory']; ?>"><?php echo $datad['hotelCategory']; ?> Star</option>
	  <?php } ?>
	</select>	</td>
    <td colspan="2">
	<select name="hotel" id="hotel"  style="width:260px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" >
	<option value="0">Select Hotel</option>
	</select>	</td>
    <td><input name="fromDate" type="text" id="fromDate" style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;" value="<?php echo date('Y-m-d',strtotime($resultlists['startDate'])); ?>"  placeholder="From Date" /></td>
    <td><input name="toDate" type="text" id="toDate" style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;" value="<?php echo date('Y-m-d',strtotime($resultlists['endDate'])); ?>"   placeholder="To Date" /></td>
 
    <td><select name="occupancy" id="occupancy"  style="width:120px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" >
	<option value="0">Occupancy</option>
	<option value="1">Single</option>
	<option value="2">Double</option>
	<option value="3">Triple</option>
	</select></td>
    <td><select name="guest" id="guest"  style="width:100px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" >
	<option value="1">1 Guest</option>
	<option value="2">2 Guest</option>
	<option value="3">3 Guest</option>
	<option value="4">4 Guest</option>
	<option value="5">5 Guest</option>
	<option value="6">6 Guest</option>
	<option value="7">7 Guest</option>
	<option value="8">8 Guest</option>
	<option value="9">9 Guest</option>
	<option value="10">10 Guest</option>
	</select></td>
    <td> 
      <input type="submit" name="Submit2" value="Save" style="width:100px; padding:8px; border:1px solid #0066CC; box-sizing:border-box; background-color:#0066CC; color:#fff;" />
     </td>
  </tr>
  
</table>
<input name="action" type="hidden" id="action" value="accommodation" />
<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
</form>
</div>

<div style="padding:20px;">

<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#E2E2E2" id="showhoteltbl">
  <tr>
    <td width="13%" bgcolor="#E9E9E9">&nbsp;</td>
    <td colspan="2" bgcolor="#E9E9E9"><strong>Hotel Name </strong></td>
    <td width="12%" align="center" bgcolor="#E9E9E9"><strong>From Date </strong></td>
    <td width="10%" align="center" bgcolor="#E9E9E9"><strong>To Date </strong></td>
    <td width="8%" align="center" bgcolor="#E9E9E9"><strong>Nights</strong></td>
    <td width="12%" align="center" bgcolor="#E9E9E9"><strong>Occupancy</strong></td>
    <td width="8%" align="center" bgcolor="#E9E9E9"><strong>Guest</strong></td>
    <td width="12%" align="right" bgcolor="#E9E9E9"><strong>Cost (INR) </strong></td>
    <td width="3%" align="right" bgcolor="#E9E9E9">&nbsp;</td>
  </tr>
  
   <?php 
	 $k=1;
		$select='*';    
		$where='  confrenceId="'.decode($_REQUEST['id']).'" and userId=0 order by id asc';  
		$rs=GetPageRecord($select,'confrenceHotelMaster',$where); 
		while($datad=mysqli_fetch_array($rs)){  
		
		
			$select1='*';  
			$where1='id='.$datad['hotel'].' '; 
			$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
			$hanme=mysqli_fetch_array($rs1); 
			
			$select1='*';  
			$where1='serviceid='.$hanme['id'].' and singleoccupancy!="0" and doubleoccupancy!="0" and tripleoccupancy!="0" order by singleoccupancy asc '; 
			$rs1=GetPageRecord($select1,'dmcroomTariff',$where1); 
			$roomrate=mysqli_fetch_array($rs1); 
	
		?>
  <tr>
    <td><?php if($hanme['hotelImage']!=''){ ?><img src="<?php echo $fullurl; ?>packageimages/<?php echo $hanme['hotelImage']; ?>" width="105" height="91" /><?php } ?></td>
    <td colspan="2"><?php echo $hanme['hotelName']; ?><br />
<strong><?php echo $datad['category']; ?> Star</strong></td>
    <td align="center"><?php echo date('d/m/Y',strtotime($datad['fromDate'])); ?></td>
    <td align="center"><?php echo date('d/m/Y',strtotime($datad['toDate'])); ?></td>
    <td align="center">
	<?php
	$date1 = strtotime($datad['fromDate']);
$date2 = strtotime($datad['toDate']);

echo $finalnights=round(abs($date2 - $date1) / (60*60*24),0);
?>	</td>
    <td align="center"><?php if($datad['occupancy']=='1'){ echo 'Single'; } if($datad['occupancy']=='2'){ echo 'Double'; }if($datad['occupancy']=='3'){ echo 'Triple'; } ?></td>
    <td align="center"><?php echo $datad['guest']; ?></td>
    <td align="right"><?php if($datad['occupancy']=='1'){
	
	echo  $finalnights*$datad['guest']*$roomrate['singleoccupancy']; 
	 
	 } if($datad['occupancy']=='2'){
 $doublecost=0;
	 
	 $doublecost = ceil($datad['guest']/$datad['occupancy']);
	 $roomratefianle=$roomrate['doubleoccupancy']*$doublecost;
	 echo round($finalnights*$roomratefianle);  
	  
	  }if($datad['occupancy']=='3'){
	  
	   $doublecost=0;
	 
	 $doublecost = ceil($datad['guest']/$datad['occupancy']);
	 $roomratefianle=$roomrate['tripleoccupancy']*$doublecost;
	 echo round($finalnights*$roomratefianle);  
	  } ?>	 </td>
    <td align="right">
	<form action="" method="post" enctype="multipart/form-data" name="addeditquery" id="did<?php echo $datad['id']; ?>" >
	<a href="#" style="color:#CC3300;" onClick="$('#did<?php echo $datad['id']; ?>').submit();"><i class="fa fa-trash" aria-hidden="true" style="font-size:18px; color:#CC3300;"></i></a>
<input name="action" type="hidden" id="action" value="deletehotelacc" />
<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
<input name="did" type="hidden" id="did" value="<?php echo $datad['id']; ?>" />
</form>	</td>
  </tr>  <?php $k++; } ?>
 <?php if($k>'1'){ ?> <tr>
    <td colspan="10" align="right"><input type="button" onclick="$('#accommodationbooking').submit();" name="Submit2" value="       Continue       " style=" padding:8px; border:1px solid #009900; box-sizing:border-box; background-color:#009900; cursor:pointer; color:#fff;" /></td>
    </tr>
<?php } ?>
</table>
<?php if($k<2){ ?>
<div style="text-align:center; padding:20px;">No Hotel Selected</div>
<style>
#showhoteltbl{display:none;}
</style>
<?php } ?>
</div>

</div>


<div class="contabs" id="confrencecartb" style="display:none;">

<div style="padding:20px; background-color:#F5F5F5;">
	<form action="" method="post" enctype="multipart/form-data" name="addeditquery" >
	<table border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
  <td colspan="2">
  <?php
  if($_REQUEST['action']=='careadd' && $_REQUEST['transferId']!='0' && $_REQUEST['vehicleId']!='0' && $_REQUEST['pax']!='0' && $_REQUEST['fromDate']!='' && $_REQUEST['toDate']!='' && $_REQUEST['start_Time']!='0' && $_REQUEST['guest']!='0'){ 
  
  
    $transferId=$_REQUEST['transferId'];
   $vehicleId=$_REQUEST['vehicleId'];
   $fromDate=date('Y-m-d',strtotime($_REQUEST['fromDate']));
   $toDate=date('Y-m-d',strtotime($_REQUEST['toDate']));
   $pax=$_REQUEST['pax'];
   $start_Time=$_REQUEST['start_Time'];
   $guest=$_REQUEST['guest'];
   $id=decode($_REQUEST['id']);
   $addDate=date('Y-m-d H:i:s');
   $userId='0'; 
 
 $namevalue ='transferId="'.$transferId.'",vehicleId="'.$vehicleId.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",pax="'.$pax.'",guest="'.$guest.'",confrenceId="'.$id.'",addDate="'.$addDate.'",userId="'.$userId.'",start_Time="'.$start_Time.'"';   
addlistinggetlastid('confrenceCarMaster',$namevalue);

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

header("location: ".$actual_link."");
   }
   
   
  
  
  ?>
   
  Transfer<br />
  <select name="transferId" id="transferId"   style="width:150px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" > 
<option value="0">Select</option> 

      <?php 



$select=''; 



$where=''; 



$rs='';   
$select='*';   

$where=' status=1 order by transferName asc';   

$rs=GetPageRecord($select,_PACKAGE_BUILDER_TRANSFER_MASTER,$where);  
while($resListing=mysqli_fetch_array($rs)){   


?>



      <option value="<?php echo strip($resListing['id']); ?>"><?php echo strip($resListing['transferName']); ?></option>



      <?php } ?>
  </select></td>
    <td colspan="2">
		Vehicle<br />

	<select name="vehicleId" id="vehicleId"  style="width:150px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" > 
	

	 <option value="">Select</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



//$where=' deletestatus=0 and status=1 and id in (select vehicleId from dmcsightseeingRate where sightseeingNameId='.$_REQUEST['signtseeingid'].' ) order by name asc';  



$where=' deletestatus=0 and status=1   order by name asc';  



$rs=GetPageRecord($select,_VEHICLE_MASTER_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['roomType']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>



<?php } ?>
	</select>	</td>
    <td>No. of Vehicle<br />

	<input type="number" id="pax" name="pax"  style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;"  placeholder=""  value=""  />	</td>
    <td>Pickup Time<br />

	<select id="transferstartTime<?php echo $resListing['id']; ?>" name="start_Time"  class="gridfield validate" autocomplete="off"   style="width:150px; padding:8px; border:1px solid #ccc; box-sizing:border-box;"   > 



		



		  <option value="0" >Start Time</option>



<?php



$start=strtotime('00:00');



   $end=strtotime('23:30');



    for ($i=$start;$i<=$end;$i = $i + 15*60)



    { ?>



   <option value="<?php echo date('g:i A',$i); ?>" ><?php echo date('g:i A',$i); ?></option>;



    <?php  }  ?>



        </select>	</td>
    <td>From Date<br />
<input name="fromDate" type="text" id="fromDate3" style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;" value="<?php echo date('Y-m-d',strtotime($resultlists['startDate'])); ?>"  placeholder="From Date" /></td>
    <td>To Date<br />
<input name="toDate" type="text" id="toDate3" style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;" value="<?php echo date('Y-m-d',strtotime($resultlists['endDate'])); ?>"   placeholder="To Date" /></td>
 
    <td>Guest<br />
<select name="guest" id="guest"  style="width:100px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" >
	<option value="1">1 Guest</option>
	<option value="2">2 Guest</option>
	<option value="3">3 Guest</option>
	<option value="4">4 Guest</option>
	<option value="5">5 Guest</option>
	<option value="6">6 Guest</option>
	<option value="7">7 Guest</option>
	<option value="8">8 Guest</option>
	<option value="9">9 Guest</option>
	<option value="10">10 Guest</option>
	</select></td>
    <td> 
      &nbsp;<br />

      <input type="submit" name="Submit2" value="Save" style="width:100px; padding:8px; border:1px solid #0066CC; box-sizing:border-box; background-color:#0066CC; color:#fff;" />     </td>
  </tr>
</table>
<input name="action" type="hidden" id="action" value="careadd" />
<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
</form>

<div style="padding:20px;">

<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#E2E2E2" id="showhoteltbl">
  <tr>
    <td colspan="2" bgcolor="#E9E9E9"><strong>Transfer </strong></td>
    <td width="12%" align="center" bgcolor="#E9E9E9"><strong>From Date </strong></td>
    <td width="10%" align="center" bgcolor="#E9E9E9"><strong>To Date </strong></td>
    <td width="20%" align="center" bgcolor="#E9E9E9"><strong>Vehicle</strong></td>
    <td width="20%" align="left" bgcolor="#E9E9E9"><strong>No. of Vehicle</strong></td>
    <td width="8%" align="center" bgcolor="#E9E9E9"><strong>Guest</strong></td>
    <td width="12%" align="left" bgcolor="#E9E9E9"><strong>Pickup Time </strong></td>
    <td width="3%" align="right" bgcolor="#E9E9E9">&nbsp;</td>
  </tr>
  
   <?php 
   
   
	 $k=1;
		$select='*';    
		$where='  confrenceId="'.decode($_REQUEST['id']).'" and  userId=0 order by id asc';  
		$rs=GetPageRecord($select,'confrenceCarMaster',$where); 
		while($datad=mysqli_fetch_array($rs)){  
 
	$select1='*';  
			$where1='id='.$datad['transferId'].' '; 
			$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_TRANSFER_MASTER,$where1); 
			$hanme=mysqli_fetch_array($rs1); 
			
			$select1='*';  
			$where1='id='.$datad['vehicleId'].' '; 
			$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
			$vehicle=mysqli_fetch_array($rs1); 
		?>
  <tr>
    <td colspan="2"><?php echo $hanme['transferName']; ?>      </strong></td>
    <td align="center"><?php echo date('d/m/Y',strtotime($datad['fromDate'])); ?></td>
    <td align="center"><?php echo date('d/m/Y',strtotime($datad['toDate'])); ?></td>
    <td width="20%" align="center">
	<?php echo $vehicle['name']; ?>	</td>
    <td width="20%" align="left"><?php echo $datad['pax']; ?></td>
    <td align="center"><?php echo $datad['guest']; ?></td>
    <td align="left"><?php echo $datad['start_Time']; ?>	 </td>
    <td align="right">
	<form action="" method="post" enctype="multipart/form-data" name="addeditquery" id="didcar<?php echo $datad['id']; ?>" >
	<a href="#" style="color:#CC3300;" onClick="$('#didcar<?php echo $datad['id']; ?>').submit();"><i class="fa fa-trash" aria-hidden="true" style="font-size:18px; color:#CC3300;"></i></a>
<input name="action" type="hidden" id="action" value="deletecaracc" />
<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
<input name="did" type="hidden" id="did" value="<?php echo $datad['id']; ?>" />
</form>	</td>
  </tr>  <?php $k++; } ?>
  <?php if($k>'1'){ ?> <tr>
    <td colspan="9" align="right"><input type="button"  onclick="$('#accommodationbooking').submit();" name="Submit2" value="       Continue       " style=" padding:8px; border:1px solid #009900; box-sizing:border-box; background-color:#009900; cursor:pointer; color:#fff;" /></td>
    </tr><?php } ?>
</table>
<?php if($k<2){ ?>
<div style="text-align:center; padding:20px;">No Car Selected</div>
<style>
#showhoteltbl{display:none;}
</style>
<?php } ?>
</div>
</div>
</div>


<div class="contabs" id="confrenceflighttb" style="display:none;">

<div style="padding:20px; background-color:#F5F5F5;">
	<form action="" method="post" enctype="multipart/form-data" name="addeditquery" >
	<table border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
  <td colspan="2">
  <?php
  if($_REQUEST['action']=='airlineadd' && $_REQUEST['onboardmeal']!='0' && $_REQUEST['preferredTiming']!='0' && $_REQUEST['preferredAirline']!='0' && $_REQUEST['fromDate']!='' && $_REQUEST['toDate']!='' && $_REQUEST['hubAirline']!='0' && $_REQUEST['guest']!='0'){ 
  
  
    $onboardmeal=$_REQUEST['onboardmeal'];
   $preferredTiming=$_REQUEST['preferredTiming'];
   $fromDate=date('Y-m-d',strtotime($_REQUEST['fromDate']));
   $toDate=date('Y-m-d',strtotime($_REQUEST['toDate']));
   $preferredAirline=$_REQUEST['preferredAirline'];
   $hubAirline=$_REQUEST['hubAirline'];
   $guest=$_REQUEST['guest'];
   $id=decode($_REQUEST['id']);
   $addDate=date('Y-m-d H:i:s');
   $userId='0'; 
 
 $namevalue ='onboardmeal="'.$onboardmeal.'",preferredTiming="'.$preferredTiming.'",fromDate="'.$fromDate.'",toDate="'.$toDate.'",preferredAirline="'.$preferredAirline.'",guest="'.$guest.'",confrenceId="'.$id.'",addDate="'.$addDate.'",userId="'.$userId.'",hubAirline="'.$hubAirline.'"';   
addlistinggetlastid('confrenceAirlineMaster',$namevalue);

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

header("location: ".$actual_link."");
   }
   
   
  
  
  ?>
   
  On Board Meal<br />
  <select name="onboardmeal" id="onboardmeal"   style="width:150px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" > 
    <option value="1" >Yes</option>
    <option value="2" >No</option>
  </select></td>
    <td colspan="2">
	Preferred Timing<br />

	<select name="preferredTiming" id="preferredTiming"  style="width:150px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" > 
	<option value="Early Morning" >Early Morning</option>  
	 <option value="Afternoon" >Afternoon</option>  
	 <option value="Evening" >Evening</option>   
	 <option value="Late Night" >Late Night</option>  
	</select>	</td>
    <td>Preferred Airline<br />

	<select name="preferredAirline" id="preferredAirline"  style="width:180px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" > 

	<option value="0">Select</option> 



	<?php  

$select2='*';    

$where2='status=1   order by flightName';  

$rs2=GetPageRecord($select2,'packageBuilderAirlinesMaster',$where2);  

while($flight=mysqli_fetch_array($rs2)){   

?>



	<option value="<?php echo $flight['flightName']; ?>" <?php if($flight['flightName']==$airline['preferredAirline']){ ?> selected="selected"<?php } ?>><?php echo $flight['flightName']; ?></option> 



	<?php } ?> 


	</select>	</td>
    <td>From Date<br />
<input name="fromDate" type="text" id="fromDate2" style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;" value="<?php echo date('Y-m-d',strtotime($resultlists['startDate'])); ?>"  placeholder="From Date" /></td>
    <td>To Date<br />
<input name="toDate" type="text" id="toDate2" style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;" value="<?php echo date('Y-m-d',strtotime($resultlists['endDate'])); ?>"   placeholder="To Date" /></td>
 
    <td>
	Hub<br />
	<input type="text" id="hubAirline" name="hubAirline"  style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box;"  placeholder=""  value=""  /></td>
    <td>Guest<br />
<select name="guest" id="guest"  style="width:100px; padding:8px; border:1px solid #ccc; box-sizing:border-box;" >
	<option value="1">1 Guest</option>
	<option value="2">2 Guest</option>
	<option value="3">3 Guest</option>
	<option value="4">4 Guest</option>
	<option value="5">5 Guest</option>
	<option value="6">6 Guest</option>
	<option value="7">7 Guest</option>
	<option value="8">8 Guest</option>
	<option value="9">9 Guest</option>
	<option value="10">10 Guest</option>
	</select></td>
    <td> 
      &nbsp;<br />

      <input type="submit" name="Submit2" value="Save" style="width:100px; padding:8px; border:1px solid #0066CC; box-sizing:border-box; background-color:#0066CC; color:#fff;" />     </td>
  </tr>
</table>
<input name="action" type="hidden" id="action" value="airlineadd" />
<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
</form>

<div style="padding:20px;">

<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#E2E2E2" id="showhoteltbl">
  <tr>
    <td colspan="2" bgcolor="#E9E9E9"><strong>On Board Meal </strong></td>
    <td width="12%" align="center" bgcolor="#E9E9E9"><strong>From Date </strong></td>
    <td width="10%" align="center" bgcolor="#E9E9E9"><strong>To Date </strong></td>
    <td width="20%" align="center" bgcolor="#E9E9E9"><strong>Preferred Timing</strong></td>
    <td width="20%" align="left" bgcolor="#E9E9E9"><strong>Preferred Airline</strong></td>
    <td width="8%" align="center" bgcolor="#E9E9E9"><strong>Guest</strong></td>
    <td width="12%" align="left" bgcolor="#E9E9E9"><strong>Hub </strong></td>
    <td width="3%" align="right" bgcolor="#E9E9E9">&nbsp;</td>
  </tr>
  
   <?php 
   
   
	 $k=1;
		$select='*';    
		$where='  confrenceId="'.decode($_REQUEST['id']).'" and  userId=0  order by id asc';  
		$rs=GetPageRecord($select,'confrenceAirlineMaster',$where); 
		while($datad=mysqli_fetch_array($rs)){  
 
	
		?>
  <tr>
    <td colspan="2"><?php if($datad['onboardmeal']==1){ echo 'Yes'; } else { echo 'No'; }?> </strong></td>
    <td align="center"><?php echo date('d/m/Y',strtotime($datad['fromDate'])); ?></td>
    <td align="center"><?php echo date('d/m/Y',strtotime($datad['toDate'])); ?></td>
    <td width="20%" align="center">
	<?php echo $datad['preferredTiming']; ?>	</td>
    <td width="20%" align="left"><?php echo $datad['preferredAirline']; ?></td>
    <td align="center"><?php echo $datad['guest']; ?></td>
    <td align="left"><?php echo $datad['hubAirline']; ?>	 </td>
    <td align="right">
	<form action="" method="post" enctype="multipart/form-data" name="addeditquery" id="didair<?php echo $datad['id']; ?>" >
	<a href="#" style="color:#CC3300;" onClick="$('#didair<?php echo $datad['id']; ?>').submit();"><i class="fa fa-trash" aria-hidden="true" style="font-size:18px; color:#CC3300;"></i></a>
<input name="action" type="hidden" id="action" value="deleteairlineacc" />
<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
<input name="did" type="hidden" id="did" value="<?php echo $datad['id']; ?>" />
</form>	</td>
  </tr>  <?php $k++; } ?>
 <?php if($k>'1'){ ?> <tr>
    <td colspan="9" align="right"><input type="button"  onclick="$('#accommodationbooking').submit();" name="Submit2" value="       Continue       " style=" padding:8px; border:1px solid #009900; box-sizing:border-box; background-color:#009900; cursor:pointer; color:#fff;" /></td>
    </tr><?php } ?>
</table>
<?php if($k<2){ ?>
<div style="text-align:center; padding:20px;">No Airline Selected</div>
<style>
#showhoteltbl{display:block;}
</style>
<?php } ?>
</div>
</div>
</div>

	</div>
  <?php } else {
  if($_SESSION['conlogin']==''){
  header("location: ".$fullurl."confrence/".$id."/registration.html");
  exit();
  }
  
    $select12='*';  
$where12='email="'.$_SESSION['conlogin'].'" and cid="'.decode($id).'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$resultlistspage3=mysqli_fetch_array($rs12);

 

$namevalue='userId="'.$resultlistspage3['id'].'"';   
$update = updatelisting('confrenceHotelMaster',$namevalue,'userId=0'); 
 
$update = updatelisting('confrenceCarMaster',$namevalue,'userId=0'); 
   
$update = updatelisting('confrenceAirlineMaster',$namevalue,'userId=0'); 

 
  ?>
  <div style="padding:20px; border:1px solid #ccc; text-align:center;">
   <h2>Pay for accommodation booking </h2>
   <table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td width="50%" align="right">Name:</td>
    <td width="50%" align="left"> 
      <?php echo $resultlistspage3['name']; ?>    </td>
  </tr>
  <tr>
    <td width="50%" align="right">Phone/Mobile:</td>
    <td width="50%" align="left"><?php echo $resultlistspage3['phone']; ?></td>
  </tr>
  <tr>
    <td width="50%" align="right">Email Address:</td>
    <td width="50%" align="left"> 
      <?php echo $resultlistspage3['email']; ?>    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
</table>

   <input type="button" name="Submit" value="Pay Now" style="padding:10px 20px; background-color:#0066CC; color:#fff; border:0px;" />
  </div>
  
  
  
  
  <?php
  
   } ?>
  
  <form action="" name="accommodationbooking" id="accommodationbooking" method="post" enctype="multipart/form-data"  >
  <input name="cid" type="hidden" id="cid" value="<?php echo decode($id); ?>" />
  <input name="action" type="hidden" id="action" value="continewaccommodation" />
  </form>
  
  <?php $c++; } 
 
 
 
 
  if($_REQUEST['pid']=='agenda'){ $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?><h1 style="text-align:center; font-size:35px; margin-bottom:30px;">Agenda</h1>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
   <style>
   .header{background-color:#0066CC; color:#fff; text-transform:uppercase; font-size:12px; font-weight:600; padding:10px;}
   #mainsectiontable tr td{padding:10px; border-bottom:1px solid #eaeaea; padding:10px; font-size:12px;}
   #mainsectiontable tr:nth-child(even) {background-color: #f2f2f2;}
   div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
    padding: 8px;
    border-radius: 4px;
    border: 2px solid #ccc;
    width:210px;
    margin-bottom: 16px; outline:0px;
}

.pagination{list-style:none; padding:0px; margin:0px; float: right;}
.pagination li{float:left; margin:0px 5px; }
.pagination a {
    color: #333333;
    background-color: #F5F5F5;
    padding: 4px 9px;
    outline: 0px;
    text-decoration: none;
    border-radius: 3px;
}.pagination .active a{background-color:#0066CC; color:#FFFFFF;}
#mainsectiontable_length{ display:none;}

   </style>
<div style="position:relative;">
<div style="position:absolute; left:0px; left:0px; top:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><a href="<?php echo $fullurl; ?>export-confrence-agenda.php?cid=<?php echo $id; ?>" target="_blank" style="color:#FFFFFF; background-color:#00a54d; float:left; padding:6px 12px; text-decoration:none; font-size:14px;    border-radius: 3px;"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download</a></td>
    <td>&nbsp;</td>
    <td><a href="<?php echo $actual_link; ?>"  style="color:#FFFFFF; background-color:#00a54d; float:left; padding:6px 12px; text-decoration:none; font-size:14px;    border-radius: 3px;"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;All Programme </a></td>
    <?php
 $select='';  
$where='';  
$rs='';   
$select='*';    
$where=' cid='.decode($id).' group by dayDate order by dayDate asc';   
$rs=GetPageRecord($select,'confrenceDays',$where);  
while($resListing2=mysqli_fetch_array($rs)){  
?>
   
    <td>&nbsp;</td>
    <td><a  onclick="$('#sdate').val('<?php echo $resListing2['dayDate']; ?>');$('#innersearchfrm').submit();" style="color:#FFFFFF; background-color:#00a54d; float:left; padding:6px 12px; text-decoration:none; font-size:14px;    border-radius: 3px; cursor:pointer; <?php if($resListing2['dayDate']==$_REQUEST['sdate']){ ?>background-color:#333333;<?php } ?>"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;<?php echo date('j M Y',strtotime($resListing2['dayDate'])); ?></a></td>
	
	<?php } ?>
  </tr>
  
</table>

 <form action="" id="innersearchfrm" method="post" style="display:none;">
 <input name="sdate" id="sdate" type="hidden" value="" />
 </form>
</div>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="mainsectiontable" class="table table-striped table-bordered">

   <thead>

   <tr>
      <th align="left" class="header" style="padding-bottom:10px;" >Session </th>

     <th align="left" class="header"style="padding-bottom:10px;" >Hall </th>

     <th align="left" class="header"style="padding-bottom:10px;" >Date</th>
     <th align="left" class="header"style="padding-bottom:10px;" >TIME</th>
     <th align="left" class="header"style="padding-bottom:10px;" >TOPIC</th>
     <th align="left" class="header"style="padding-bottom:10px;" >SPEAKER</th>
     <th align="left" class="header"style="padding-bottom:10px;" >CHAIRPERSON</th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php
  $wheremain='';
  if($_REQUEST['sdate']!=''){
   $wheremain=' and dayDate="'.$_REQUEST['sdate'].'"';
  }
  
  
 $select='';  
$where='';  
$rs='';   
$select='*';    
$where=' cid='.decode($id).' '.$wheremain.' order by dayDate asc';   
$rs=GetPageRecord($select,'confrenceDays',$where);  
while($resListing=mysqli_fetch_array($rs)){  
?>
  <tr>
    <td align="left"><?php echo stripslashes($resListing['sessionList']); ?></td>

    <td align="left"><?php echo stripslashes($resListing['hall']); ?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($resListing['dayDate'])); ?></td>
    <td align="left"><?php echo stripslashes($resListing['dayTime']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['topic']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['speaker']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['chairpersonName']); ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
</div>

<script>
$(document).ready(function() {
     $('#mainsectiontable').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
} );
</script>
  
  <?php $c++; } 
  
  
  
  
   if($_REQUEST['pid']=='registration'){ ?><h1 style="text-align:center; font-size:35px; margin-bottom:30px;">Registration</h1>
   
   <?php if($_REQUEST['action']!='confrencebooking'){ ?>
  <form action="" id="registrationfrm" method="post" enctype="multipart/form-data"  >
 <?php if($_SESSION['conlogin']!=''){?>
 
  <div class="listouterb">
  <h2>Joining Delegate</h2>
  <div class="checks checksCCY">
					<p>
				<input type="radio" value="Indian Delegate" name="ccy" checked=""  >
				<label>
                    Indian Delegate				</label>
			</p>
					<p>
				<input type="radio" value="International Delegate" name="ccy"  >
				<label>
                    International Delegate				</label>
			</p>
	  </div>
  </div>
<?php } ?>

 <div class="listouterb">
  <h2>Joining Fee</h2>
  <table width="100%" border="1" cellpadding="8" cellspacing="0" bordercolor="#CCCCCC" class="registration_slab fTable" cellborder="0">
		<tbody><tr class="heading">
			<?php if($_SESSION['conlogin']!=''){?><td align="left" bordercolor="#FFFFFF" bgcolor="#CCCCCC">&nbsp;</td>
			<?php } ?>
			<td align="left" bordercolor="#FFFFFF" bgcolor="#CCCCCC"><strong>Category</strong></td>
			
			<?php        
		$rs22=GetPageRecord('*','conferencesFee',' 1 and cid='.decode($_REQUEST['id']).' group by startDate order by startDate asc'); 
		while($datelisting=mysqli_fetch_array($rs22)){  
		?>
			<td align="left" bordercolor="#FFFFFF" bgcolor="#CCCCCC" class="headingDate"><strong><?php if($datelisting['startDate']!=$datelisting['endDate']){ echo date('j M',strtotime($datelisting['startDate'])); ?> - <?php echo date('j M Y',strtotime($datelisting['endDate'])); } else {  echo date('j M',strtotime($datelisting['startDate'])); } ?></strong></td>
			<?php } ?>
			
		</tr>
	
	 <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and cid='.decode($_REQUEST['id']).' group by feeType order by feeType asc';  
		$rs=GetPageRecord($select,'conferencesFee',$where); 
		while($listofabstract=mysqli_fetch_array($rs)){  
		?>
		<tr class="trtype" style="border-bottom:1px solid #ccc;">
		 	<?php if($_SESSION['conlogin']!=''){?><td align="left" valign="top">
					<input type="radio" name="fee_id" value="<?php echo $listofabstract['feeType']; ?>" id="fee<?php echo $listofabstract['id']; ?>"  ></td> <?php } ?>
				<td align="left"><div class="registration_fee"><?php 
$where13='id="'.$listofabstract['feeType'].'" '; 
$rs13=GetPageRecord('*','confrenceFeeCategory',$where13); 
$typename=mysqli_fetch_array($rs13); 
?>
	
	<?php echo $typename['name']; ?> <span class="lowlight"></span></div></td>
				<?php        
		$rs22=GetPageRecord('*','conferencesFee',' 1 and cid='.decode($_REQUEST['id']).' group by startDate order by startDate asc'); 
		while($datelisting=mysqli_fetch_array($rs22)){  
		?>
		<td class="registration_cost" align="left" nowrap=""  <?php if($datelisting['startDate']<=date('Y-m-d') && $datelisting['endDate']>=date('Y-m-d')){ ?> style="background-color:#fff5a3;"<?php } ?>>INR.		  <?php  
$rs13=GetPageRecord('*','conferencesFee',' 1 and cid='.decode($_REQUEST['id']).' and feeType="'.$listofabstract['feeType'].'" and startDate="'.$datelisting['startDate'].'"'); 
$typename=mysqli_fetch_array($rs13); 
echo $typename['fee'];
?></td>
		<?php } ?>
		  </tr>
		  		<?php } ?>
	</tbody></table>
  </div>
  
  <div class="listouterb">
  <?php if($_SESSION['conlogin']==''){?> <h2>Start Registration</h2><?php } else { ?><h2>Your Details</h2><?php } ?>
  
  <?php if($_SESSION['conlogin']==''){?>
  <table width="100%" border="0" cellpadding="10" cellspacing="0" id="registerforms">
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="left">Already registered? <a href="javascript:void(0);" onclick="$('#action').val('login');$('#registerforms').hide();$('#loginforms').show();">click here</a> to login.  </td>
  </tr>
  <tr>
    <td colspan="2" align="right">* Name:</td>
    <td width="60%" align="left"> 
      <input name="name" type="text" id="name"  style="width:300px; padding:8px; border:1px solid #ccc;" />    </td>
  </tr>
  <tr>
    <td colspan="2" align="right">* Email Address:</td>
    <td width="60%" align="left"> 
      <input name="email" type="email" id="email"  style="width:300px; padding:8px; border:1px solid #ccc;" />    </td>
  </tr>
  <tr>
    <td colspan="2" align="right">Phone/Mobile:</td>
    <td align="left"><input name="phone" type="text" id="phone"  style="width:300px; padding:8px; border:1px solid #ccc;" maxlength="14" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right">* Create a Password:</td>
    <td width="60%" align="left"><input name="password" type="password" id="password"  style="width:300px; padding:8px; border:1px solid #ccc;" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right">* Confirm Password:</td>
    <td width="60%" align="left"><input name="password2" type="password" id="password2"  style="width:300px; padding:8px; border:1px solid #ccc;" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
    <td width="60%" align="left"> 
      <input type="submit" name="Submit" value="Save &amp; Continue" style="padding:10px 20px; background-color:#0066CC; color:#fff; border:0px;" /> </td>
  </tr>
</table>



<table width="100%" border="0" cellpadding="10" cellspacing="0" id="loginforms" style="display:none;">
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left">Not Registered ? <a href="javascript:void(0);" onclick="$('#action').val('confrenceRegister');$('#registerforms').show();$('#loginforms').hide();">click here</a> to Sign Up.  </td>
  </tr>
  <tr>
    <td align="right">* Email Address:</td>
    <td width="60%" align="left"> 
      <input name="email" type="email" id="email"  style="width:300px; padding:8px; border:1px solid #ccc;" />    </td>
  </tr>
  <tr>
    <td align="right">*  Password:</td>
    <td width="60%" align="left"><input name="password" type="password" id="password"  style="width:300px; padding:8px; border:1px solid #ccc;" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td width="60%" align="left"> 
      <input type="submit" name="Submit" value="Login" style="padding:10px 20px; background-color:#0066CC; color:#fff; border:0px;" /> </td>
  </tr>
</table>
  <?php } else {
   
  $select12='*';  
$where12='email="'.$_SESSION['conlogin'].'" and cid="'.decode($id).'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$resultlistspage3=mysqli_fetch_array($rs12);
  
    ?>
  <table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td align="right">Name:</td>
    <td width="60%" align="left"> 
      <?php echo $resultlistspage3['name']; ?>    </td>
  </tr>
  <tr>
    <td align="right">Phone/Mobile:</td>
    <td align="left"><?php echo $resultlistspage3['phone']; ?></td>
  </tr>
  <tr>
    <td align="right">Email Address:</td>
    <td width="60%" align="left"> 
      <?php echo $resultlistspage3['email']; ?>    </td>
  </tr>
  <tr>
    <td align="right">Register Date: </td>
    <td width="60%" align="left"><?php echo date('j, F Y h:i A',strtotime($resultlistspage3['addDate'])); ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td width="60%" align="left"> 
      <input type="submit" name="Submit" value="Process to Joining" style="padding:10px 20px; background-color:#0066CC; color:#fff; border:0px;" />
	  
	  
	  <input name="userId" type="hidden" id="userId" value="<?php echo $resultlistspage3['id']; ?>" /> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <a href="#" onClick="$('#logoutyes').val('1');$('#registrationfrm').submit();">Logout</a> </td>
  </tr>
</table>
  
  <?php } ?>
  
  


  </div>
  <input name="action" type="hidden" id="action" value="<?php if($_SESSION['conlogin']!=''){?>confrencebooking<?php } else { ?>confrenceRegister<?php } ?>" />
  <input name="cid" type="hidden" id="cid" value="<?php echo decode($id); ?>" />
  <input name="logoutyes" type="hidden" id="logoutyes" value="0" />
  </form>
  <?php } else { ?>
  
   <div style="padding:20px; border:1px solid #ccc; text-align:center;">
   <h2>Pay for this booking </h2>
   <table border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td colspan="2"><strong>Type:</strong></td>
    <td align="left"> 
	
	<?php 
$where13='id="'.$resultlistspage4['feeType'].'" '; 
$rs13=GetPageRecord('*','confrenceFeeCategory',$where13); 
$typename=mysqli_fetch_array($rs13); 
  echo $typename['name']; ?>
	</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Fee:</strong></td>
    <td align="left">Rs. <?php echo $resultlistspage4['fee']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

   <input type="button" name="Submit" value="Pay Now" style="padding:10px 20px; background-color:#0066CC; color:#fff; border:0px;" />
   </div>
  
  
  <?php } ?>
  
  
  
  <?php $c++; } ?>
  
  
  
  
  
  
 
<?php

echo stripslashes($homecontent['details']); if($homecontent['name']=='Abstract'){  include "confrence_abstract_form.php"; } ?>
</div>
 
 <div style="background-color:#333333; color:#FFFFFF; text-align:center; padding:20px 0px; border-top:5px solid #0066CC;">Powered by <?php
$select12='*';  
$where12='id=1 '; 
$rs12=GetPageRecord($select12,'invoiceSettingMaster',$where12); 
$po=mysqli_fetch_array($rs12);
echo stripslashes($po['companyname']); ?></div>

<script type="text/javascript">



$(window).load(function(){



  $('.flexslider').flexslider({



	animation: "slide",



	controlNav: true,



	start: function(slider){



	  //$('body').removeClass('loading');



	}



  });



});



</script>

<style>
h6, h5, h4, h3{margin:0px !important padding:0px !important}
.flex-direction-nav a:before { 
    color: rgba(255, 255, 255, 1) !important; 
}
.Zebra_DatePicker_Icon_Wrapper{width:110px !important;}
</style>



<script>

 $(document).ready(function() { 
 $('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});  
 $('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});    


 $('#fromDate2').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});  
 $('#toDate2').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 

 $('#fromDate3').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});  
 $('#toDate3').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 

});   
</script>

<style>

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #09519a;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  color:#fff;
}
.dropdown{ display:inline-block;}
.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}

.menumain a { 
    font-size: 13px; 
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #2879cb;
    color: #fff;
}
</style>
</body>
</html>
