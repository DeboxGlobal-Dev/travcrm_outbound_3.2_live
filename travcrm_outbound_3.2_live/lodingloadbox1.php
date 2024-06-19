<?php
   	include "inc.php"; 	
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
			//unset session if exist 
			if(isset($_SESSION['otpvar'])){
				unset($_SESSION['otpvar']);
			} 
			if(isset($_SESSION['user_name'])){
				unset($_SESSION['user_name']);
			} 
			if(isset($_SESSION['user_pass'])){
				unset($_SESSION['user_pass']);
			} 
			
		 
			$loginreturn = login($username,$password);
			if($loginreturn=='yes'){
				$sectionBox = 3; 
				// 3 mean PIN Box 
				 
				$select=''; 
				$where=''; 
				$rs=''; 
				
				$select=' pin '; 
				$where="email='".$username."' and  password='".md5($password)."'"; 
				$rs=GetPageRecord($select,_USER_MASTER_,$where); 
				$userinfo=mysqli_fetch_array($rs);

				// remember me coockies
				if($_REQUEST['rememberMe']==='yes'){
					setcookie('userName',$username,time()+(86400*30),'/');
					setcookie('password',$password,time()+(86400*30),'/');
				}else{
					setcookie('userName',$username,time()-(86400*30),'/');
					setcookie('password',$password,time()-(86400*30),'/');
				}
				
				
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
				 
			}else{
				$errorlogin=1; // 1 incorrect password
			}
		}else{
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
			  	window.location.href = "<?php  echo $fullurl; ?>";
			 // 	window.location.href = "https://travcrm.in/Stratos/showpage.crm?module=query";
			  	
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
					$Email_pass = trim(strtoupper(substr($email,0,4)).mt_rand(1000,9999));
					$Updt_haspass = md5($Email_pass);
					$cLogin = date('Y-m-d H:i:s');
					$currentIp = $_SERVER['REMOTE_ADDR'];  
					
					$updateQuery="update "._USER_MASTER_." set currentIp='$currentIp',password ='$Updt_haspass',showPassword='$Email_pass' where email='$email'"; 
					if(mysqli_query(db(),$updateQuery)){
						// unset user detail
						if(isset($_SESSION['user_name'])){
							unset($_SESSION['user_name']);
						}
						if(isset($_SESSION['user_pass'])){
							unset($_SESSION['user_pass']);
						}   
						$errorlogin = 4;
						
						// email template
						$from = $email;  
						$subject = "Password Recovery Information";
						$message = "Email Address:  ".$email."\n";
						$message.= "Password :   ".$Email_pass."\n";
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
						if(isset($_SESSION['otpvar'])){
							unset($_SESSION['otpvar']);
						}   
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

	$userName_Coockie='';
	$password_Coockie='';
	if(isset($_COOKIE['userName']) && isset($_COOKIE['password'])){
		$userName_Cookie = $_COOKIE['userName'];
		$password_Cookie = $_COOKIE['password'];
		$checkbox_Cookie = 'checked="checked"';
	}

   ?>

   <!-- <div> -->
   <!-- <img src="loginpage/images/debox-logo.png" height="32"  
   style="height: 50px;
    margin-bottom: 20px;"/>
   </div> -->
<div style="text-align:left;">
   <?php 
    // action is processing all code in it
    if($loginprosess!=1){
	
	 	// LOGIN FORM
		if($sectionBox=='1'){
			// reset to none and make it again
			if(isset($_SESSION['otpvar'])){
				unset($_SESSION['otpvar']);
			}
			if(isset($_SESSION['user_name'])){
				unset($_SESSION['user_name']);
			}
			if(isset($_SESSION['user_pass'])){
				unset($_SESSION['user_pass']);
			}
			 
		 	?>
			<!-- <table border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                     <td colspan="2">Powered By&nbsp;&nbsp; </td>
                     <td><img src="loginpage/images/powered.png" height="32" /></td>
                  </tr>
               </table> -->

			<!--<h4 class="heading">LOGIN</h4>-->
			<!--<hr style="width: 140px;margin-bottom: 30px;background: #f2eeee8f;border: 1px solid #f7f0f0;">-->
			<div class="bodr_a"></div>
			<?php 
		   // login error box 
		   if($errorlogin==11){ ?>
		   <div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">That TravCrm account doesn't exist!</div>
		   <?php }  if($errorlogin==1){ ?>
		   <div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">Incorrect Password!</div>
		   <?php } ?>
		   <div class="text-boxes">
                 <div style="background: #1c1c41;color: white;border-top-left-radius: 9px;border-bottom-left-radius: 9px;"><i style="font-size: 19px;display: block;width: max-content;margin: 14px auto;" class="fa fa-user"></i></div>
            <!--<label for="email" style="letter-spacing: 0.1em;font-weight: 500;text-transform: uppercase;color: #ed9d46;">Username</label>-->
			  <input type="text" class="form-control" name="username" id="username" style="box-sizing: border-box;" placeholder="Email Address" value="<?php echo $userName_Cookie; ?>"> 
			  <!--<i class="fa fa-user"></i>-->
		   </div>
		   
		   <div class="text-boxes">
		       <div style="background: #1c1c41;color: white;border-top-left-radius: 9px;border-bottom-left-radius: 9px;"><i style="font-size: 19px;display: block;width: max-content;margin: 14px auto;" class="fa fa-lock"></i></div>
			  <!--<label for="password"  style="letter-spacing: 0.1em;font-weight: 500;text-transform: uppercase;color: #ed9d46;">Password</label>-->
			  <input type="password" class="form-control" name="userpass" id="userpass"  style="box-sizing: border-box;" placeholder="Password" value="<?php echo $password_Cookie; ?>"> 
			  <!--<i class="fa fa-lock"></i>-->
		   </div>
		  
		   
		   <div class="login-button" style="width: 100%; text-align: center; margin-top: 15px;">
			  <input type="button" name="submit" value="Login" onClick="login(2);" style="margin-top: 8px;width: 65%;font-weight: 500;text-transform: uppercase;background-color: #fec724; cursor:pointer; text-align: center; padding: 11px; font-size: 17px; color: #fff; border: 0px solid; outline: 0px; border-radius: 5px;">
		   </div> 
		   
			<div class="row" style="">
				<div class="col-6">
				<div class="form-group row">
				
				
			</div>
				</div>
				<div class="col-6">
				<div class="forget-password" >
				<div class="two-links" style="float: left;text-align: left;">
						<input class="form-check-input" type="checkbox" <?php echo $checkbox_Cookie; ?> id="rememberMe" name="rememberMe" style="display: block;">
							<label class="form-check-label" for="gridCheck1" style="color: #3e3939;font-size: 14px;font-weight: 500;width: 200px;margin-left: 15%;margin-top: -11%;">
							Remember me
					</label>
			  		</div>
					  
			  		<div class="two-links" style="float: left;text-align: right;margin-top: 3px;">
			  			<a onClick="sendPass(1);" style="color:#3e3939;font-size: 14px;font-weight: 500;" >Forgot Password?</a>
			  		</div>
		   		</div>
				</div>
			</div>
		   <!-- <a href="https://www.deboxglobal.com/">
   <img src="loginpage/images/Powered-by-De-Box.png" height="32" style="position: absolute;
    top: 491px;
    width: 140px;
    height: 38px;
    margin-left: 7px;" />
   </a> -->
			<?php 
		} 
		
		// PIN FOR LOGIN
		if($sectionBox=='3'){
		 	?>
			<h4 class="heading">PIN NUMBER</h4>
			<div class="bodr"></div>
			<?php 
			// pin error box for Login 
		 	if($errorlogin==3){ ?>
				<div style="background-color:#CC3300;color:#FFFFFF;font-size:12px;padding: 10px 10px;text-align:center;margin-bottom:10px;border-radius: 2px;">Invalid PIN</div>
				<?php 
		 	} 
			?>
			<div class="text-boxes"> 
	       <div style="background: #1c1c41;color: white;border-top-left-radius: 9px;border-bottom-left-radius: 9px;"><i style="font-size: 19px;display: block;width: max-content;margin: 14px auto;" class="fa fa-key"></i></div>

			  <!--<label for="email" style=" font-weight: 500;margin-left: 42px;">Enter 6 Digit PIN</label>-->
			  <input type="password" id="otp" class="form-control" displayname="PIN" placeholder="Enter 6 digit PIN"  maxlength="12" style="box-sizing:border-box;" > 
			</div>
			<div class="forget-password" >
			  <div class="two-links" style="float: left;text-align: left;">
			  	<a onClick="sendOtp(1);" style="color:#424040;font-size: 14px;font-weight: 500;" >Forgot PIN?</a>
			  </div>
		   </div>
			<div class="login-button" style="width: 100%; text-align: center; margin-top: 15px;">
			  <input type="button" name="submit" value="Login" onClick="loginotp();" style="width: 65%;background-color: #fec724;cursor: pointer;text-align: center;padding: 11px;font-size: 18px;color: #fff;border: 0px solid;outline: 0px;border-radius: 5px;text-transform: uppercase;font-weight: 500;">
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
			  	<input type="button" name="submit" value="Submit" onClick="sendPass(2);" style="width: 100%;    background-color: #919191; cursor:pointer; text-align: center; padding: 10px; font-size: 12px; color: #fff; border: 0px solid; outline: 0px; border-radius: 2px;">
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
			  <input type="button" name="submit" value="Submit" onClick="sendOtp(2);" style="width: 100%;    background-color: #919191; cursor:pointer; text-align: center; padding: 10px; font-size: 12px; color: #fff; border: 0px solid; outline: 0px; border-radius: 2px;">
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
	   if($('#rememberMe').is(":checked")){
		var rememberMe = 'yes';
	   }else{
		rememberMe='';
	   }
	  
	   // without action load user and pass box
	   if(id==1){
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox1.php');
	   } 
	   // first action 
	   else if(id==2 && username!='' && userpass!=''){  
            $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
            $('#lodingloadbox').load('lodingloadbox1.php?username='+username+'&userpass='+userpass+'&rememberMe='+rememberMe);
	   }
	   else if(id==3){
	   		$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   	$('#lodingloadbox').load('lodingloadbox1.php?reenterOTP=1');
	   }
	   else if(id==4){
	   		$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   	$('#lodingloadbox').load('lodingloadbox1.php?reenterPASS=1');
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
		   $('#lodingloadbox').load('lodingloadbox1.php?otp='+otp);
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
				$('#lodingloadbox').load('lodingloadbox1.php?emailid='+emailid+'&forgotPass=1');
			}else{
				$('#emailid').focus(); 
			}
		   
	   } else if(id==2 && emailid==''){
			$('#emailid').focus();
	   } else{
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox1.php?forgotPass=1');
	   }
	}
	
	// FORGOT EMAIL FOR PIN
	function sendOtp(id){
	   var emailid = $('#emailid').val();  
	   if(id==2 && emailid!=''){
			if(isValidEmail(emailid) == true){
				$('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
				$('#lodingloadbox').load('lodingloadbox1.php?emailid='+emailid+'&forgotOtp=1');
			}else{
				$('#emailid').focus(); 
			} 
	   } else if(id==2 && emailid==''){
			$('#emailid').focus();
	   } else{
		   $('#lodingloadbox').html('<img src="loginpage/loadinglogin.gif" />');
		   $('#lodingloadbox').load('lodingloadbox1.php?forgotOtp=1');
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