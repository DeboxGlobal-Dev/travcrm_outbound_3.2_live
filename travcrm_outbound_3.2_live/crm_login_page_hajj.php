<?php   
if(isset($_SESSION['otpvar'])){
	unset($_SESSION['otpvar']);
} 
if(isset($_SESSION['user_name'])){
	unset($_SESSION['user_name']);
} 
if(isset($_SESSION['user_pass'])){
	unset($_SESSION['user_pass']);
}  
include "inc.php"; 
$rscms=GetPageRecord('*','companySettingsMaster','id=1'); 
$editresultcsm=mysqli_fetch_array($rscms); 
$masterLogo = $editresultcsm['logoupload'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Login - <?php echo $systemname; ?></title>
      <?php  include "headerinclude.php"; ?>
      <link href="css/main.css" rel="stylesheet" type="text/css" />
      <link href="loginpage/login7.css" rel="stylesheet" type="text/css" />
      <style>
         #loginwindoworcolor {
       		  background-color: #<?php echo $loginColortwo; ?>;
         }
		.logo-hajj img{
		        margin-top: 15px;
                margin-left: 44px;
                display: inline;
                width: 306px;
		}
		.timeline-umrah img{
		    margin-top: 50px;
            margin-left: -8px;
            display: inline;
            width: 474px;
        }
		}
      </style>
      <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
      <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
      <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
      <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
      <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
      <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
      <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
      <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
      <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
      <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
      <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
      <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
      <link rel="manifest" href="/manifest.json">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
      <meta name="theme-color" content="#ffffff">
   </head>
   <body style="background-color: #ffffff;">
      <div style="width:100%;">
         <div style="width:100%;float:left;display: block;min-height: 600px;background-image:url(loginpage/images/TRAVCRM-Hajj-and-Umrah-Login-Page-v2-BG.jpg);background-repeat:no-repeat;background-position: 0 0;background-size: 100% 100%;z-index: 999999999;overflow: visible;">&nbsp;
         
        <!--kaba logo code started-->
        <div class="row">
            <div class="logo-hajj" style="">
                <img src="loginpage/images/TRAVCRM_Hajj-and-Umrah-Kaba-Logo-op4-c.png" alt="kaba img" >
            </div>
        </div> 
         <!--kaba logo code ended-->
         </div>
         
         <!--<div  class="middlebox">-->
         <!--   <table width="100%" border="0" cellpadding="0" cellspacing="0">-->
         <!--      <tr>-->
         <!--         <td colspan="3" align="center">&nbsp;</td>-->
         <!--      </tr>-->
         <!--      <tr>-->
         <!--         <td colspan="3" align="center">&nbsp;</td>-->
         <!--      </tr>-->
             
               <!--<tr>-->
               <!--   <td colspan="3" align="right"><img src="loginpage/images/icon.png" style=" width: 60%; "/></td>-->
               <!--</tr>-->
         <!--      <tr>-->
         <!--         <td height="100" colspan="3" align="center" >&nbsp;</td>-->
         <!--      </tr> -->
               <!--<tr>-->
               <!--   <td colspan="3" align="center"><img src="loginpage/images/award.png" style="width: 140%;margin-left: -30%;" /></td>-->
               <!--</tr>-->
         <!--   </table>-->
         <!--</div>-->
         
         
         <div 
         style="    width: 40%;
                    float: right;
                    text-align: center;
                    position: absolute;
                    /* margin-top: -40px; */
                    margin-top: -65px;
                    right: 0; ">
            <div class="login-first-section"  >
               <div class="First-inner-block">
                    <img src="<?php echo $fullurl;?>dirfiles/<?php echo $masterLogo;?>" style="margin-top: -20px; width: 28%;" />
                    
                    <!--<h4 class="heading">Journey of a lifetime...</h4>-->
               <!--   <div class="bodr"></div>-->
               <!--</div>-->
               <div class="second-section" id="lodingloadbox" style="text-align:center;"><img src="loginpage/loadinglogin.gif" /></div>
               <script>
                  $('#lodingloadbox').load('lodingloadbox.php');
               </script> 
               <!--<div style="max-width: 292px; margin: auto; overflow: hidden; margin-top: 15px;display:nones; ">-->
               <!--<table border="0" align="right" cellpadding="0" cellspacing="0">-->
               <!--   <tr>-->
               <!--      <td colspan="2">Powered By&nbsp;&nbsp; </td>-->
               <!--      <td><img src="loginpage/images/powered.png" height="32" /></td>-->
               <!--   </tr>-->
               <!--</table>-->
               <!-- </div>-->
               
               
            </div>
            
        </div>
        
        <!--kaba hajj umrah time line code started-->
        <div class="Hajj-timeline">
            <div class="row">
            <div class="timeline-umrah" style="">
                <img src="loginpage/images/TRAVCRM-Hajj&Umrah-timeline.png" alt="kaba img" >
            </div>
        </div>
        </div>
        <!--kaba hajj umrah time line code ended-->
      </div>
      
      
      <!-- position: fixed; -->
      <!--<img src="loginpage/images/Bottom.png" style=" left:0px; bottom:0px; width:100%;height:150px;" />-->
      
      
      <script>
         login(1);
      </script>
	  <style>
	  .backtoLogin{
		padding:10px 0;
		text-align:center; 
	  } 
	  .heading{
	  	text-align:center;
	  }
	   	.middlebox{
			width: 30%;padding-top: 100px;float:left;text-align:center;
		 }
		 .middlebox table, .middlebox tbody{ 
				/*min-height: 700px!important;*/
		 }
		 .middlebox table tr, .middlebox table tr td, .middlebox table tbody, .middlebox table{ 
				display:block!important;
		 }
		 .middlebox table  td{
			
		 }
	  .login-first-section{
	  	max-width: 50%;
		margin: auto;
		margin-right: 70px;
        margin-top: 117px;
		text-align: left;
		border: 1px solid #91919100;
		/*min-height: 350px;*/
		min-height: 240px;
		box-shadow: 2px 2px 10px -5px black;
	  }
	  .login-first-section input{
		
	  
	  }
	  </style>
   </body>
</html><?php  
//if(){
	unset($_SESSION['otpvar']); 
	unset($_SESSION['user_name']);
	unset($_SESSION['user_pass']);  
//}
include "inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Login - <?php echo $systemname; ?></title>
      <?php  include "headerinclude.php"; ?>
      <link href="css/main.css" rel="stylesheet" type="text/css" />
      <link href="loginpage/login7.css" rel="stylesheet" type="text/css" />
      <style>
         #loginwindoworcolor {
       		  background-color: #<?php echo $loginColortwo; ?>;
         }
		
      </style>
      <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
      <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
      <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
      <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
      <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
      <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
      <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
      <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
      <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
      <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
      <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
      <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
      <link rel="manifest" href="/manifest.json">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
      <meta name="theme-color" content="#ffffff">
   </head>
   <body style="background-color: #ffffff;">
      <div style="width:100%;">
         <div style="width:30%;float:left;display: block;min-height: 500px;background-image:url(loginpage/images/backm.png);background-repeat:no-repeat;background-position: 0 0;background-size: 100% 100%;z-index: 999999999;overflow: visible;">&nbsp;</div>
         <div  class="middlebox">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                  <td colspan="3" align="center">&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="3" align="center">&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="3" align="center">&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="3" align="center">&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="3" align="right"><img src="loginpage/images/icon.png" style=" width: 50%; "/></td>
               </tr>
               <tr>
                  <td height="100" colspan="3" align="center" >&nbsp;</td>
               </tr> 
               <tr>
                  <td colspan="3" align="center"><img src="loginpage/images/award.png" style="width: 140%;margin-left: -30%;" /></td>
               </tr>
            </table>
         </div>
         <div style=" width:40%; float:left; text-align:center; ">
            <div class="login-first-section"  style="min-height: 240px;">
               <div class="First-inner-block">
                    <img src="<?php echo $fullurl;?>images/weCare.png" style=" width: 50%; " /> 
                    <img src="<?php echo $fullurl;?>loginpage/images/weCare.png" style="margin-top: 5px;width: 60%;" />
                    <!--<h4 class="heading">Journey of a lifetime...</h4>-->
                  <div class="bodr"></div>
               </div>
               <div class="second-section" id="lodingloadbox" style="text-align:center;"><img src="loginpage/loadinglogin.gif" /></div>
               <script>
                  $('#lodingloadbox').load('lodingloadbox.php');
               </script> 
               <div style="max-width: 292px; margin: auto; overflow: hidden; margin-top: 15px;display:nones;">
               <table border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                     <td colspan="2">Powered By&nbsp;&nbsp; </td>
                     <td><img src="loginpage/images/powered.png" height="32" /></td>
                  </tr>
               </table>
            </div>
            </div>
            
         </div>
      </div>
      <!-- position: fixed; -->
      <img src="loginpage/images/Bottom.png" style=" left:0px; bottom:0px; width:100%;height:150px;" />
      <script>
         login(1);
      </script>
	  <style>
	  .backtoLogin{
		padding:10px 0;
		text-align:center; 
	  } 
	  .heading{
	  	text-align:center;
	  }
	   	.middlebox{
			width: 30%;padding-top: 100px;float:left;text-align:center;
		 }
		 .middlebox table, .middlebox tbody{ 
				min-height: 700px!important;
		 }
		 .middlebox table tr, .middlebox table tr td, .middlebox table tbody, .middlebox table{ 
				display:block!important;
		 }
		 .middlebox table  td{
			
		 }
	  .login-first-section{
	  	max-width: 50%;
		margin: auto;
		margin-top: 50px;
		text-align: left;
		border: 1px solid #91919100;
		/*min-height: 350px;*/
		/*min-height: 241px;*/
		box-shadow: 2px 2px 10px -5px black;
	  }
	  .login-first-section input{
		
	  
	  }
	  </style>
   </body>
</html>