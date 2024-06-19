<?php
	session_start();
   	include "inc.php"; 	
	//echo $_SESSION['user_name']."-".$_SESSION['user_pass']."-".$_SESSION['otpvar'];
	$sectionBox = 1; 
	// LOGIN FORM
   	if(trim($_REQUEST['username'])!='' && trim($_REQUEST['userpass'])!=''){  
		$username = $_REQUEST['username'];  
		$password = $_REQUEST['userpass'];  
		
		$select=''; 
		$where=''; 
		$rs=''; 
		
		$select=' * '; 
		$where=" email='".$username."'"; 
		$rs=GetPageRecord($select,_USER_MASTER_,$where); 
		$userinfo=mysqli_fetch_array($rs);
		$no_users = mysqli_num_rows($rs);
		
		if($no_users > 0){
			if( trim($_SESSION['otpvar'])!='' && trim($_REQUEST['otp'])==''){
				unset($_SESSION['otpvar']);
			}
			//unset session  
			unset($_SESSION['user_name']);
			unset($_SESSION['user_pass']); 
		
			$loginreturn = login($username,$password);
			if($loginreturn=='yes'){
				$sectionBox = 3; // 3 mean PIN Box 
				 
				$select=''; 
				$where=''; 
				$rs=''; 
				
				$select=' pin '; 
				$where="email='".$username."' and  password='".md5($password)."'"; 
				$rs=GetPageRecord($select,_USER_MASTER_,$where); 
				$userinfo=mysqli_fetch_array($rs);
				
				
				if($userinfo['pin']!='' && $userinfo['pin']!=0){ 
					$genOTP=$userinfo['pin'];
				}else{
					$email = $username;
					$cLogin = date('Y-m-d H:i:s');
					$currentIp = $_SERVER['REMOTE_ADDR'];
					$genOTPs=mt_rand(100000, 999999); // generate login otp 
					//$genOTP='210210';
					$updateQuery="update "._USER_MASTER_." set currentIp='$currentIp',pin ='$genOTPs' where email='$email'"; 
					if(mysqli_query(db(),$updateQuery)){
						$forgotOtp = $genOTPs;    
						$sectionBox = 5;
						$errorlogin = 6; 
						
						// email template
						$from = $email;  
						$subject = "PIN Recovery Information";
						$message= " Email Address:  ".$email."\n";
						$message.= "PIN Number:   ".$forgotOtp."\n";
						$headers = "From: $from";
						$emailStatus = @mail($from, $subject, $message, $headers); // returned = 1
						if($emailStatus == 1){
							$_SESSION['otpvar'] = $forgotOtp;
						}
						//echo "valid email and pin sent";
					} 
				} 
				 // set session  
				$_SESSION['user_name'] = $username;
				$_SESSION['user_pass'] = $password; 
				$_SESSION['otpvar']=$genOTP;
				 
			} 
			else {
				$errorlogin=1; // 1 incorrect password
			}
		}
		else{
			$errorlogin = 11; //acount does not exit
		} 
   	}
   
		// PIN FOR LOGIN AFTER FORGOT PIN BACK TO PIN BOX
	if($_SESSION['user_name']!='' && $_SESSION['user_pass']!='' && $_SESSION['otpvar']!='' && $_REQUEST['reenterOTP']==1){
		$sectionBox = 3; // OPEN OTP BOX
		//echo "OTP BOX";
	}
	
	// PASS FOR LOGIN AFTER FORGOT PASS BACK TO PASS BOX
	if($_SESSION['user_name']!='' && $_SESSION['user_pass']!='' && $_REQUEST['reenterPASS']==1){
		$sectionBox = 1; //OPEN LOGIN BOX
		unset($_SESSION['otpvar']);
	}
	
	// PIN FOR LOGIN
	if(isset($_SESSION['user_name']) && trim($_SESSION['user_pass'])!=''  && trim($_SESSION['user_name'])!='' && trim($_SESSION['otpvar'])!='' && trim($_REQUEST['otp'])!=''){ 
		
		
		$username = $_SESSION['user_name'];
		$password = $_SESSION['user_pass'];
		$otp = $_REQUEST['otp'];     
		$sessOTP = $_SESSION['otpvar']; 
		
		$sectionBox = 3;// 3 mean OTP Box 
		//$loginreturn = login($username,$password);
		if( $otp==$sessOTP ){ //$loginreturn=='yes' &&
			//echo "correct OTP";
			$loginprosess=1; 
			?>
			<script>
			  	window.location.href = "<?php echo $fullurl; ?>";
			</script>
			<?php 
	   	} else {
			$errorlogin=3; // mean otp is false
	   	} 
	}
	
	// EMAIL FOR PASSWORD
	if( trim($_REQUEST['forgotPass'])==1){ 
		$sectionBox = 2; 		//2 mean PASS Box
		
		$email = trim($_REQUEST['emailid']);
		if( $email!='' ){ 
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 

				$select=''; 
				$where=''; 
				$rs=''; 
				
				$select=' * '; 
				$where=" email='".$email."'"; 
				$rs=GetPageRecord($select,_USER_MASTER_,$where); 
				$userinfo=mysqli_fetch_array($rs);
				$no_users = mysqli_num_rows($rs);
				
				if($no_users > 0){ 
					
					// email valid   
					$Email_pass = strtoupper(substr($email,0,4)).mt_rand(1000,9999);
					$Updt_haspass = md5($Email_pass);
					$cLogin = date('Y-m-d H:i:s');
					$currentIp = $_SERVER['REMOTE_ADDR'];  
					
					$updateQuery="update "._USER_MASTER_." set currentIp='$currentIp',password ='$Updt_haspass' where email='$email'"; 
					if(mysqli_query(db(),$updateQuery)){
						// unset user detail
						unset($_SESSION['user_name']);
						unset($_SESSION['user_pass']);  
						$errorlogin = 4;
						
						// email template
						$e_name = $userinfo['firstName'].$userinfo['lastName'];
						$e_password = $Email_pass;
						$from = $email;  
						$subject = "Password Recovery Information";
						$message = ' <style type="text/css" rel="stylesheet" media="all"> 
										@import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
										body {
										  width: 100% !important;
										  height: 100%;
										  margin: 0;
										  -webkit-text-size-adjust: none;
										}
										
										a {
										  color: #3869D4;
										}
										
										a img {
										  border: none;
										}
										
										td {
										  word-break: break-word;
										}
										
										.preheader {
										  display: none !important;
										  visibility: hidden;
										  mso-hide: all;
										  font-size: 1px;
										  line-height: 1px;
										  max-height: 0;
										  max-width: 0;
										  opacity: 0;
										  overflow: hidden;
										} 
										
										body,
										td,
										th {
										  font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
										}
										
										h1 {
										  margin-top: 0;
										  color: #333333;
										  font-size: 22px;
										  font-weight: bold;
										  text-align: left;
										}
										
										h2 {
										  margin-top: 0;
										  color: #333333;
										  font-size: 16px;
										  font-weight: bold;
										  text-align: left;
										}
										
										h3 {
										  margin-top: 0;
										  color: #333333;
										  font-size: 14px;
										  font-weight: bold;
										  text-align: left;
										}
										
										td,
										th {
										  font-size: 16px;
										}
										
										p,
										ul,
										ol,
										blockquote {
										  margin: .4em 0 1.1875em;
										  font-size: 16px;
										  line-height: 1.625;
										}
										
										p.sub {
										  font-size: 13px;
										}     
										.align-right {
										  text-align: right;
										}
										
										.align-left {
										  text-align: left;
										}
										
										.align-center {
										  text-align: center;
										} 
										
										.button {
										  background-color: #3869D4;
										  border-top: 10px solid #3869D4;
										  border-right: 18px solid #3869D4;
										  border-bottom: 10px solid #3869D4;
										  border-left: 18px solid #3869D4;
										  display: inline-block;
										  color: #FFF;
										  text-decoration: none;
										  border-radius: 3px;
										  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
										  -webkit-text-size-adjust: none;
										  box-sizing: border-box;
										}
										
										.button--green {
										  background-color: #22BC66;
										  border-top: 10px solid #22BC66;
										  border-right: 18px solid #22BC66;
										  border-bottom: 10px solid #22BC66;
										  border-left: 18px solid #22BC66;
										}
										
										.button--red {
										  background-color: #FF6136;
										  border-top: 10px solid #FF6136;
										  border-right: 18px solid #FF6136;
										  border-bottom: 10px solid #FF6136;
										  border-left: 18px solid #FF6136;
										}
										
										@media only screen and (max-width: 500px) {
										  .button {
											width: 100% !important;
											text-align: center !important;
										  }
										} 
										
										.attributes {
										  margin: 0 0 21px;
										}
										
										.attributes_content {
										  background-color: #F4F4F7;
										  padding: 16px;
										}
										
										.attributes_item {
										  padding: 0;
										} 
										
										.related {
										  width: 100%;
										  margin: 0;
										  padding: 25px 0 0 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										}
										
										.related_item {
										  padding: 10px 0;
										  color: #CBCCCF;
										  font-size: 15px;
										  line-height: 18px;
										}
										
										.related_item-title {
										  display: block;
										  margin: .5em 0 0;
										}
										
										.related_item-thumb {
										  display: block;
										  padding-bottom: 10px;
										}
										
										.related_heading {
										  border-top: 1px solid #CBCCCF;
										  text-align: center;
										  padding: 25px 0 10px;
										} 
										
										.discount {
										  width: 100%;
										  margin: 0;
										  padding: 24px;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										  background-color: #F4F4F7;
										  border: 2px dashed #CBCCCF;
										}
										
										.discount_heading {
										  text-align: center;
										}
										
										.discount_body {
										  text-align: center;
										  font-size: 15px;
										} 
										
										.social {
										  width: auto;
										}
										
										.social td {
										  padding: 0;
										  width: auto;
										}
										
										.social_icon {
										  height: 20px;
										  margin: 0 8px 10px 8px;
										  padding: 0;
										} 
										
										.purchase {
										  width: 100%;
										  margin: 0;
										  padding: 35px 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										}
										
										.purchase_content {
										  width: 100%;
										  margin: 0;
										  padding: 25px 0 0 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										}
										
										.purchase_item {
										  padding: 10px 0;
										  color: #51545E;
										  font-size: 15px;
										  line-height: 18px;
										}
										
										.purchase_heading {
										  padding-bottom: 8px;
										  border-bottom: 1px solid #EAEAEC;
										}
										
										.purchase_heading p {
										  margin: 0;
										  color: #85878E;
										  font-size: 12px;
										}
										
										.purchase_footer {
										  padding-top: 15px;
										  border-top: 1px solid #EAEAEC;
										}
										
										.purchase_total {
										  margin: 0;
										  text-align: right;
										  font-weight: bold;
										  color: #333333;
										}
										
										.purchase_total--label {
										  padding: 0 15px 0 0;
										}
										
										body {
										  background-color: #F2F4F6;
										  color: #51545E;
										}
										
										p {
										  color: #51545E;
										}
										
										.email-wrapper {
										  width: 100%;
										  margin: 0;
										  padding: 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										  background-color: #F2F4F6;
										}
										
										.email-content {
										  width: 100%;
										  margin: 0;
										  padding: 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										} 
										
										.email-masthead {
										  padding: 25px 0;
										  text-align: center;
										}
										
										.email-masthead_logo {
										  width: 94px;
										}
										
										.email-masthead_name {
										  font-size: 16px;
										  font-weight: bold;
										  color: #A8AAAF;
										  text-decoration: none;
										  text-shadow: 0 1px 0 white;
										} 
										
										.email-body {
										  width: 100%;
										  margin: 0;
										  padding: 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										}
										
										.email-body_inner {
										  width: 570px;
										  margin: 0 auto;
										  padding: 0;
										  -premailer-width: 570px;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										  background-color: #FFFFFF;
										}
										
										.email-footer {
										  width: 570px;
										  margin: 0 auto;
										  padding: 0;
										  -premailer-width: 570px;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										  text-align: center;
										}
										
										.email-footer p {
										  color: #A8AAAF;
										}
										
										.body-action {
										  width: 100%;
										  margin: 30px auto;
										  padding: 0;
										  -premailer-width: 100%;
										  -premailer-cellpadding: 0;
										  -premailer-cellspacing: 0;
										  text-align: center;
										}
										
										.body-sub {
										  margin-top: 25px;
										  padding-top: 25px;
										  border-top: 1px solid #EAEAEC;
										}
										
										.content-cell {
										  padding: 45px;
										} 
										
										@media only screen and (max-width: 600px) {
									
										  .email-body_inner,
										  .email-footer {
											width: 100% !important;
										  }
										}
										
										@media (prefers-color-scheme: dark) {
										  body,
										  .email-body,
										  .email-body_inner,
										  .email-content,
										  .email-wrapper,
										  .email-masthead,
										  .email-footer {
											background-color: #333333 !important;
											color: #FFF !important;
										  }
										  p,
										  ul,
										  ol,
										  blockquote,
										  h1,
										  h2,
										  h3 {
											color: #FFF !important;
										  }
										  .attributes_content,
										  .discount {
											background-color: #222 !important;
										  }
										  .email-masthead_name {
											text-shadow: none !important;
										  }
										}
										</style>
   	 								<!--<span class="preheader">Use this link to reset your password. The link is only valid for 24 hours.</span>-->
							<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
								<tr>
								<td align="center">
								  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
									<tr>
									  <td class="email-masthead">
										<a href="'.$fullurl.'" class="f-fallback email-masthead_name"> <img src="'.$fullurl.'loginpage/images/logo.png" width="" /> </a>
									  </td>
									</tr>
									<!-- Email Body -->
									<tr>
									  <td class="email-body" width="570" cellpadding="0" cellspacing="0">
										<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
										  <!-- Body content -->
										  <tr>
											<td class="content-cell">
											  <div class="f-fallback">
												<h1>Hi '.$e_name.',</h1>
												<p>You recently requested to reset your password for your TravCrm account. <!--Use the button below to reset it. <strong>This password reset is only valid for the next 24 hours.--> Please find your password and <a href="'.$fullurl.'">login</a> again.</strong></p>
												<!-- Action -->
												<table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
												  <tr>
													<td align="center">
													  <!-- Border based button  https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
													  <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
														<tr>
														  <td align="center">
															<span class="f-fallback button button--green" target="_blank">'.$e_password.'</span>
														  </td>
														</tr>
													  </table>
													</td>
												  </tr>
												</table>
												<p>For security, this request was received from a desktop device using chrome. If you did not request a password reset, please ignore this email or <a href="https://www.deboxglobal.com/contact.html">contact support</a> if you have questions.</p>
												<p>Thanks,
												  <br>
												  The TravCrm Team</p>
												<!-- Sub copy -->
											  </div></td>
										  </tr>
										</table>
									  </td>
									</tr>
									<tr>
									  <td>
										<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
										  <tr>
											<td class="content-cell" align="center">
											  <p class="f-fallback sub align-center">&copy; 2020 TravCrm. All rights reserved.</p>
											  <p class="f-fallback sub align-center">
												DeBox Global Pvt. Ltd.
												<br>
												C-75, Sec 2, Noida,
												<br>
												UP 201301
											  </p>
											</td>
										  </tr>
										</table>
									  </td>
									</tr>
								  </table>
								</td>
								</tr>
								</table>
						"; 
						$headers = "From: $from";
						$emailStatus = @mail($from, $subject, $message, $headers);  
						if($emailStatus == 1){
							//set user pass session
							$_SESSION['user_name'] = $email;
							$_SESSION['user_pass'] = $Email_pass;
						}
					}
				
				}else{
					$errorlogin = 21;
				}
			} else {
				$errorlogin = 2;
				// email invalid
			} 
		} 
		// send pass to email here 
	} 
	  
	// EMAIL FOR PIN
	if( trim($_REQUEST['forgotOtp'])==1 ){ 
		$sectionBox = 5; 		//5 mean PIN Box 
		$email = trim($_REQUEST['emailid']);
		if( $email!='' ){  
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
				$select=''; 
				$where=''; 
				$rs=''; 
				
				$select=' * '; 
				$where=" email='".$email."'"; 
				$rs=GetPageRecord($select,_USER_MASTER_,$where); 
				$userinfo=mysqli_fetch_array($rs);
				$no_users = mysqli_num_rows($rs);
				
				if($no_users > 0){
					// email valid  
					$forgotOtp=mt_rand(100000, 999999); 
					$cLogin = date('Y-m-d H:i:s');
					$currentIp = $_SERVER['REMOTE_ADDR']; 
					
					$updateQuery="update "._USER_MASTER_." set currentIp='$currentIp',pin='$forgotOtp' where email='$email'"; 
					if(mysqli_query(db(),$updateQuery)){ 
						unset($_SESSION['otpvar']);  
						$errorlogin = 6; 
						
						// email template
						$from = $email;  
						$subject = "PIN Recovery Information";
						$message= " Email Address:  ".$email."\n";
						$message.= "PIN Number:   ".$forgotOtp."\n";
						$headers = "From: $from";
						$emailStatus = @mail($from, $subject, $message, $headers); // returned = 1
						if($emailStatus == 1){
							$_SESSION['otpvar'] = $forgotOtp; 
						}
						//echo "valid email and pin sent";
					} 
				}else{
					$errorlogin = 51;
				}
			} else {
				$errorlogin = 5; 
				// email invalid
			} 
		} 
		// send pass to email here 
	}   

   ?>
<div style="text-align:left;">
   <?php
//   echo " (".$loginprosess."-loginprosess)";
//   echo " (".$sectionBox."-sectionBox)";
//   echo " (".$_SESSION['user_name']."-username)";
//   echo " (".$_SESSION['user_pass']."-user_pass)";
//   echo " (".$_SESSION['otpvar']."-otpvar)";
//   echo " (".$errorlogin."-errorlogin)";
    // action is processing all code in it
    if($loginprosess!=1){
	
	 	// LOGIN FORM
		if($sectionBox=='1'){
			// reset to none and make it again
			unset($_SESSION['otpvar']);
			unset($_SESSION['user_name']);
			unset($_SESSION['user_pass']);
		 	?>
			<h4 class="heading">LOGIN</h4><div class="bodr"></div>
			<?php 
		   // login error box 
		   if($errorlogin==11){ ?>
		   <div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">That TravCrm account doesn't exist!</div>
		   <?php }  if($errorlogin==1){ ?>
		   <div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">Incorrect Password!</div>
		   <?php } ?>
		   <div class="text-boxes">
			  <label for="email" style="font-weight: 500;">Email Address:</label>
			  <input type="text" class="form-control" placeholder="Enter Your Email Address" name="username" id="username" style="box-sizing: border-box;" value=""> 
		   </div>
		   <div class="text-boxes">
			  <label for="password"  style="font-weight: 500;">Password:</label>
			  <input type="password" class="form-control" placeholder="Enter Your Password" name="userpass" id="userpass"  style="box-sizing: border-box;" value=""> 
		   </div>
		   <div class="forget-password" >
			  <div class="two-links" style="float: left;text-align: left;">
			  	<a onClick="sendPass(1);" style="color:#5a5050;font-size: 11px;font-weight: 500;" >Forgot Password?</a>
			  </div>
		   </div>
		   <div class="login-button" style="width: 100%; text-align: center; margin-top: 15px;">
			  <input type="button" name="submit" value="Login" onClick="login(2);" style="width: 100%;    background-color: #ffc115; cursor:pointer; text-align: center; padding: 10px; font-size: 12px; color: #fff; border: 0px solid; outline: 0px; border-radius: 2px;">
		   </div> 
			<?php 
		} 
		
		// PIN FOR LOGIN
		if($sectionBox=='3'){
		 	?>
			<h4 class="heading">PIN NUMBER</h4><div class="bodr"></div>
			<?php 
			// pin error box for Login 
		 	if($errorlogin==3){ ?>
				<div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">Invalid PIN</div>
				<?php 
		 	} 
			?>
			<div class="text-boxes"> 
			  <label for="email" style=" font-weight: 500;">Enter 6 Digit PIN</label>
			  <input type="password" id="otp" class="form-control" displayname="PIN" placeholder="Enter 6 digit PIN"  maxlength="6" style="box-sizing:border-box;" > 
			</div>
			<div class="forget-password" >
			  <div class="two-links" style="float: left;text-align: left;">
			  	<a onClick="sendOtp(1);" style="color:#5a5050;font-size: 11px;font-weight: 500;" >Forgot PIN?</a>
			  </div>
		   </div>
			<div class="login-button" style="width: 100%; text-align: center; margin-top: 15px;">
			  <input type="button" name="submit" value="Login" onClick="loginotp();" style="width: 100%;     background-color: #ffc115;cursor:pointer; text-align: center; padding: 10px; font-size: 12px; color: #fff; border: 0px solid; outline: 0px; border-radius: 2px;">
			</div>
			<div class="backtoLogin" > 
			  	<span onClick="login(1);" class="backbtn" >Back to Login</span> 
		    </div> 
			<?php 
		} 
		
		// EMAIL FOR PASSWORD
		if($sectionBox=='2'){
			if($errorlogin!='4' && $emailStatus != 1){ ?> <h4 class="heading">FORGOT PASSWORD</h4> <?php } ?>
			 <div class="bodr"></div>
			<?php 
			// email error box for PIN
		 	if($errorlogin==2 || $errorlogin==21){ ?>
				<div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;"> Invalid Email Address</div>
				<?php 
		 	}  
			//$emailStatus == 1; //email is sent
			if($errorlogin==4 && $emailStatus == 1){ ?>
				<div style="text-align:center">
					<img src="loginpage/images/link_sent_to_email.png" width="100px;">
					<p style="text-align:center"><strong> Password Reset Email Sent </strong></p>
					<p style="text-align:center">An email has been sent to your email address. Follow the directions in the email to reset your password.</p>
				</div>
				<br> 
				<div style="background-color:#55ad3c; color:#FFFFFF; font-size:12px;  text-align:center; margin-bottom:10px;border-radius: 2px;">
					<div class="backtoLogin" > 
						<span onClick="login(4);" class="backbtn" >Back to Login</span> 
					</div
				></div>
				<?php 
		 	}else{
			?>
			<div class="text-boxes"> 
			  <label for="emailid" style=" font-weight: 500;">Enter Your Email Address</label>
			  <input type="email" id="emailid" name="emailid" class="form-control" placeholder="Enter Your Email Address"   style="box-sizing:border-box;" >
			</div>
			<div class="login-button" style="width: 100%; text-align: center; margin-top: 15px;">
			  	<input type="button" name="submit" value="Submit" onClick="sendPass(2);" style="width: 100%;    background-color: #ffc115; cursor:pointer; text-align: center; padding: 10px; font-size: 12px; color: #fff; border: 0px solid; outline: 0px; border-radius: 2px;">
			 	<div class="backtoLogin" > 
			  		<span onClick="login(1);" class="backbtn" >Back to Login</span> 
		    	</div>
			</div>
			<?php 
		 	}  
		}
		
		// EMAIL FOR PIN
		if($sectionBox=='5'){
		 ?>
			<?php if($errorlogin!='6' && $emailStatus != 1){ ?> <h4 class="heading">FORGOT PIN</h4><?php } ?>
			<div class="bodr"></div>
			<?php 
			// email error box for PIN
		 	if($errorlogin==5 || $errorlogin == 51){ ?>
				<div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">
					Invalid Email Address.</div>
				<?php 
		 	}  
			//$emailStatus == 1; //email is sent
			if($errorlogin==6 && $emailStatus == 1){ ?>
				<div style="text-align:center">
					<img src="loginpage/images/link_sent_to_email.png" width="100px;">
					<p style="text-align:center"><strong> PIN Sent to Your Email </strong></p>
					<p style="text-align:center">An mail has been sent to your email address and use this pin for login.</p>
				</div>
				<br> 
				<div style="background-color:#55ad3c; color:#FFFFFF; font-size:12px;  text-align:center; margin-bottom:10px;border-radius: 2px;">
					<div class="backtoLogin" > 
						<span onClick="login(3);" class="backbtn" >Back to PIN</span> 
					</div
				></div>
				<?php 
		 	} else{
			?>
			<div class="text-boxes"> 
			  <label for="emailid" style=" font-weight: 500;">Enter Your Email Address</label>
			  <input type="email" id="emailid" name="emailid" class="form-control" placeholder="Enter Your Email Address"   style="box-sizing:border-box;" >
			</div> 
			<div class="login-button" style="width: 100%; text-align: center; margin-top: 15px;">
			  <input type="button" name="submit" value="Submit" onClick="sendOtp(2);" style="width: 100%;    background-color: #ffc115; cursor:pointer; text-align: center; padding: 10px; font-size: 12px; color: #fff; border: 0px solid; outline: 0px; border-radius: 2px;">
			</div>
			<div class="backtoLogin" > 
			  	<span onClick="login(3);" class="backbtn" >Back to PIN</span> 
		    </div> 
			<?php 
			}
		} 
	} else { 
		?>
		<div style="padding:40px 0px; text-align:center; font-size:14px;"><br><br><img src="loginpage/loadinglogin.gif" style="width: 40px;" /><br><br>Login Processing..</div>
		<?php 
	}   
   ?>
</div>
<script> 
	// LOGIN FORM
	function login(id) {
	   var username = $('#username').val();
	   var userpass = $('#userpass').val(); 
	   // without action load user and pass box
	   if(id==1){
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox.php');
	   } 
	   // first action 
	   else if(id==2 && username!='' && userpass!=''){  
			if(isValidEmail(username) == true){
				$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
				$('#lodingloadbox').load('lodingloadbox.php?username='+username+'&userpass='+userpass);
			}else{
				$('#username').focus(); 
			}
	   }
	   else if(id==3){
	   		$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   	$('#lodingloadbox').load('lodingloadbox.php?reenterOTP=1');
	   }
	   else if(id==4){
	   		$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   	$('#lodingloadbox').load('lodingloadbox.php?reenterPASS=1');
	   } 
	   else {
			$('#username').focus();
	   }
	}
	
	// PIN FOR LOGIN
	function loginotp(){ 
	   var otp = $('#otp').val();  
	   if(otp!='' && otp.length==6){
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox.php?otp='+otp);
	   }
	   if( otp==''  || otp.length!=6 ){
			$('#otp').focus(); 
	   }
	}
	
	// FORGOT EMAIL FOR PASS
	function sendPass(id){
	   var emailid = $('#emailid').val();  
	   if(id==2 && emailid!=''){
			if(isValidEmail(emailid) == true){
				$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
				$('#lodingloadbox').load('lodingloadbox.php?emailid='+emailid+'&forgotPass=1');
			}else{
				$('#emailid').focus(); 
			}
		   
	   } else if(id==2 && emailid==''){
			$('#emailid').focus();
	   } else{
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox.php?forgotPass=1');
	   }
	}
	
	// FORGOT EMAIL FOR PIN
	function sendOtp(id){
	   var emailid = $('#emailid').val();  
	   if(id==2 && emailid!=''){
			if(isValidEmail(emailid) == true){
				$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
				$('#lodingloadbox').load('lodingloadbox.php?emailid='+emailid+'&forgotOtp=1');
			}else{
				$('#emailid').focus(); 
			} 
	   } else if(id==2 && emailid==''){
			$('#emailid').focus();
	   } else{
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox.php?forgotOtp=1');
	   }
	}
	
	
	function isValidEmail(email){
		return /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test(email)
			&& /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(email);
	}
    
   $("#userpass").keypress(function(e) {
       if(e.which == 13) { 
       		login(2);
       }
   }); 
   $("#username").keypress(function(e) {
       if(e.which == 13) { 
       		login(2);
       }
   });  
   $("#otp").keypress(function(e) {
       if(e.which == 13) { 
       		loginotp();
       }
   });
   $("#emailid").keypress(function(e) {
       if(e.which == 13) { 
       		sendPass(2);
       }
   });
</script> 