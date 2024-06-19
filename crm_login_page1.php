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
      <?php
if($pageTypeMaster == 1){
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
      <link href="loginpage/login7.css" rel="stylesheet" type="text/css" /><?php 
}
if($pageTypeMaster == 2){
?>
<link href="css/main1.css" rel="stylesheet" type="text/css" />
      <link href="loginpage/login8.css" rel="stylesheet" type="text/css" /><?php 
}
?>
      
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
      
         <div style="position: absolute;width:100%;height: 100vh;background-image:url(loginpage/images/login-background.png);background-repeat:no-repeat;background-position: center;background-size:cover;z-index: 999999999;overflow: visible;">
      <div style="display: grid;grid-template-columns: 1fr 1fr;width:70%;margin:auto;height: 100vh;">
         <div class="second-block">
             <!--<h1 style="margin: 20px auto 0;text-align: center;color: #2491ca;">WELCOME TO TRAVEL WORLD</h1>-->
             <img style="display: block;margin: 10px auto;width: 40%;" src="<?php echo $fullurl;?>dirfiles/WhatsApp Image 2024-02-27 at 12.47.58 PM.jpeg" />
            <div style="margin: 14% auto 0;"><img style="width: 169px;height: 103px;display: block;margin: auto;" src="loginpage/images/THINK BEYOND BOUNDARIES (2).png" /></div>    
            </div>
            <div class="login-first-section">
            <div class="First-inner-block" style="margin: 19px 0 30px 0;;">
                    <img src="<?php echo $fullurl;?>dirfiles/<?php echo $masterLogo;?>" style="margin-top: 0px;width: 37%;" />
                    <!--<h4 class="heading">Journey of a lifetime...</h4>-->
                  <!-- <div class="bodr"></div> -->
               </div>
               
               <div class="second-section" id="lodingloadbox" style="text-align:center;"><img src="loginpage/loadinglogin.gif" /></div>
               <script>
                  $('#lodingloadbox').load('lodingloadbox1.php');
               </script> 
       			<hr style="width: 65%;margin: 15px auto 15px;background: #f2eeee8f;border: 1px solid #8c8282;">

               <div style="max-width: 292px; overflow: hidden;float: right;display:nones;margin-right: 16%;">
               <table border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                     <td colspan="2" style="color: black;font-size: 13px;font-weight: 500;">Powered By&nbsp;&nbsp; </td>
                     <td><img src="loginpage/images/powered.png" height="32" /></td>
                  </tr>
               </table>
            </div>
            
           </div>
           </div>
            
            
            
      </div>
     
        
      </div>
      <!-- position: fixed; -->
      <!-- <img src="loginpage/images/Bottom.png" style=" left:0px; bottom:0px; width:100%;height:150px;" /> -->
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
          width: 95%;
    margin-top: 18%;
    height: 73vh;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    box-shadow: 2px 2px 10px -5px black;
     }
     .second-block{
      margin-top: 18%;
    width: 100%;
    height: 73vh;
    background: #ffffffc7;
    box-shadow: 2px 2px 10px -5px black;
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
    margin-left: 0px;
     }
     .text-boxes{
             display: grid;
    grid-template-columns: 0.55fr auto;
        width: 65%;
        margin:12px auto;

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
       <?php
if($pageTypeMaster == 1){
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
      <link href="loginpage/login7.css" rel="stylesheet" type="text/css" /><?php 
}
if($pageTypeMaster == 2){
?>
<link href="css/main1.css" rel="stylesheet" type="text/css" />
      <link href="loginpage/login8.css" rel="stylesheet" type="text/css" /><?php 
}
?>
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
            <div class="login-first-section"  >
               <div class="First-inner-block">
               <img src="<?php echo $fullurl;?>dirfiles/<?php echo $masterLogo;?>" style="margin-top: 5px;width: 60%;" />
                    <!-- <h4 class="heading">Journey of a lifetime...</h4> -->
                  <div class="bodr"></div>
               </div>
               <div class="second-section" id="lodingloadbox" style="text-align:center;"><img src="loginpage/loadinglogin.gif" /></div>
               <script>
                  $('#lodingloadbox').load('lodingloadbox1.php');
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
     
     
     </style>
   </body>
</html>