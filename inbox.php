<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>IMAP mailbox - iBacor</title>
		<!-- Custom style -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css">
		<style>
			pre {
				white-space: pre;
				white-space: pre-wrap;
				word-wrap: break-word;
			}
		</style>
	</head>
	<body>
		<div class="alert alert-info alert-dismissable">Tutorial: <a style="color:#333;text-decoration:underline" href="http://ibacor.com/blog/reading-emails-from-a-imap-mailbox-php-example/" target="_BLANK">Reading emails from a IMAP mailbox - PHP example</a></div>
		<?php
		error_reporting(0);
    // Multiple email account
		$emails = array(
			array(
				'no'		=> '1',
				'label' 	=> 'Inbox Email 1',
				'host' 		=> '{mail.travcrm.in:143/notls}',
				'username' 	=> 'info@travcrm.in',
				'password' 	=> 'DeBox@6060!'
			) 
			// bla bla bla ...
		);
				
		foreach ($emails as $email) {
			$read = imap_open($email['host'],$email['username'],$email['password']) or die('<div class="alert alert-danger alert-dismissable">Cannot connect to yourdomain.com: ' . imap_last_error().'</div>');
			$array = imap_search($read,'ALL');
			if($array) {
				$html = '';
				rsort($array);
				$html.= '<div class="panel panel-default">
							<div class="panel-heading">
								'.$email['label'].'
							</div>
							<div class="panel-body">
								<div class="panel-group" id="accordion">';
								
				foreach($array as $result) {
					$overview = imap_fetch_overview($read,$result,0);
					
																 	
					$message = imap_fetchbody($read, $result, "1.2");

if ($message == "") {
   $message = imap_fetchbody($read, $result, "1");
}
																						
					$reply = imap_headerinfo($read,$result,0);
																		
					$html.= '	<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$email['no'].$result.'">
												<span class="subject">'.substr(strip_tags($overview[0]->subject),0,50).'.. </span>
												<span class="from">'.$overview[0]->from.'</span>
												<span class="date">on '.$overview[0]->date.'</span>
											</a>
										</h4>
									</div>
									<div id="'.$email['no'].$result.'" class="panel-collapse collapse">
										<div class="panel-body">
											<pre>'.quoted_printable_decode($message).'<hr>From: '.$reply->from[0]->mailbox.'@'.$reply->from[0]->host.'</pre>
										</div>
									</div>
								</div>';												
				}
								
				$html.= '</div>
					</div>
				</div>';
				echo $html;
			}
			imap_close($read);
						
		}
		?>

		<!-- Javascript -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	</body>
</html>