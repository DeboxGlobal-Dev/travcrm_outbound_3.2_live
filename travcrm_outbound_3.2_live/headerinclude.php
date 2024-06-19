<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
     <?php
if($pageTypeMaster == 1){
?>
<link href="css/main.css?id=<?php echo time(); ?>" rel="stylesheet" type="text/css" />   
<?php 
}
if($pageTypeMaster == 2){
?>
<link href="css/main1.css?id=<?php echo time(); ?>" rel="stylesheet" type="text/css" />   
<?php 
}
?>
<link href="css/default.css" rel="stylesheet" type="text/css" /> 
<link href="css/toastr.css" rel="stylesheet" type="text/css" />
<link href="css/toastr.min.css" rel="stylesheet" type="text/css" />  
<link href="css/select2.min.css" rel="stylesheet" type="text/css" /> 
<script src="js/sweetalert.min.js"></script>
 <style>
.loginleftcolorbg{background-color:#<?php echo $loginColorone;?> !important;}
.loginrightcolorbg{background-color:#<?php echo $loginColortwo;?> !important;}
.bbuttonlogin{background-color:#<?php echo $buttonColor;?> !important;}
#headerstrip {border-bottom: 4px #<?php echo $topLineColor;?> solid !important;}
.dropmenu a:hover {background-color: #<?php echo $buttonColor;?> !important;}
.bluelink{color: #<?php echo $linkColor;?> !important;}
table a{color: #<?php echo $linkColor;?> !important;} 
.bluembutton{background-color:#<?php echo $buttonColor;?> !important;border: 1px #<?php echo $buttonColor;?> solid !important;}
.leftsettingmenutd .mainbox .linkbox .active{background-color:#<?php echo $buttonColor;?> !important;}
 
#headerstrip #navigationleft .active2 { background-color: #26292c !important;}

.salestimeline_sectionbox .tag{padding:5px 7px; color:#FFFFFF; font-size:12px; right:10px; top:10px;    border-radius: 3px;display: inline-block;    text-align: center; width:70px;}
.salestimeline_sectionbox .shedule{ background-color:#FF6600;}
.salestimeline_sectionbox .confirm{ background-color:#82b767;}
.salestimeline_sectionbox .canceled{ background-color:#CC3300;}

.maintablist{    color: #fff !important;
    background-color: #167cd4;
    font-size: 12px;
    padding: 4px 10px;
    float: left;
    border-radius: 20px;}
	
#toast-container {
    position: fixed;
    z-index: 999999;
    pointer-events: none;
    margin-top: 50px !important;
}


</style> 
<script src="js/jquery-3.5.0.min.js?id=<?php echo time(); ?>"></script> 
<!-- <script src="js/jquery-1.11.3.min.js?id=<?php echo time(); ?>"></script>   -->
<!-- <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>   -->
<link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css?id=<?php echo time(); ?>">
<!--<script type="text/javascript" src="js/jquery.timepicker.js?id=<?php echo time(); ?>"></script>-->
 <script src="js/zebra_datepicker.js?id=<?php echo time(); ?>"></script>  
<script type="text/javascript"> 
$(document).ready(function() { 

  let expirydate = document.getElementById("expirydate");
  if (expirydate!== null){
      //content
      $('#expirydate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }

  let birthDate = document.getElementById("birthDate");
  if (birthDate!== null){
      //content
      $('#birthDate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  } 

  let anniversaryDate = document.getElementById("anniversaryDate");
  if (anniversaryDate!== null){
      //content
      $('#anniversaryDate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  } 

  let zebraDate = document.getElementById("zebraDate");
  if (zebraDate!== null){
      //content
      $('#zebraDate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }  

  let travelDate = document.getElementById("travelDate");
  if (travelDate!== null){
      //content
      $('#travelDate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }  

  let fromDate1 = document.getElementById("fromDate1");
  let toDate1 = document.getElementById("toDate1");
  if (fromDate1!== null && toDate1!== null){
      //content
       $('#fromDate1').Zebra_DatePicker({ 
        direction: true,
        format: 'd-m-Y',  
        pair: $('#toDate1')
      }); 
  }   

  let paymentreminderdate = document.getElementById("paymentreminderdate");
  if (paymentreminderdate!== null){
      //content
      $('#paymentreminderdate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }  

  let paymentdate = document.getElementById("paymentdate");
  if (paymentdate!== null){
      //content
      $('#paymentdate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }  

  let followupdate = document.getElementById("followupdate");
  if (followupdate!== null){
      //content
      $('#followupdate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }   

  let closerDate = document.getElementById("closerDate");
  if (closerDate!== null){
      //content
      $('#closerDate').Zebra_DatePicker({ 
        format: 'd-m-Y',  
      }); 
  }   

});


<?php if($sessionTimeName['sessionTime']!=''){ ?>
  setTimeout(function(){ 
  window.location.href = 'logout.crm';
}, <?php echo $sessionTimeName['sessionTime']*60000; ?>);
<?php } ?>
 
</script>

<?php 
class env {

  public static $IP;

  public static $MAC;

  //get ip

  public function getIP()

  {

    env::$IP = $_SERVER['REMOTE_ADDR'];

  }

  //get mac

  public function getMAC($ip)

  {

    $macCommandString	=	"arp $ip | awk 'BEGIN{ i=1; } { i++; if(i==3) print $3 }'";	// awk command to crawl mac from string

    $mac = exec($macCommandString);

    env::$MAC =	$mac;

  }

  //constructor codes

  function __construct()

  {

    $this->getIP();

    $this->getMAC(env::$IP);

  }

}

//test . creating object

$envObj = new env();

//print mac of user

"mac: " .env::$MAC;

//print ip of user

"IP : " .env::$IP;
?> 
 
<script src="js/main.js?id=<?php echo time(); ?>"></script>  
<script src="js/validation.js?id=<?php echo time(); ?>"></script> 
<script src="js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="js/tablesortingjquery.js"></script> 
<script src="js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php $fullurl; ?>plugins/font-awesome/css/font-awesome.min.css">
  
