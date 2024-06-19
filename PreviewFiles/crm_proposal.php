<?php 
include "../inc.php";  
$quotationId = decode($_REQUEST['id']);
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');  
$resultpageQuotation=mysqli_fetch_array($rsp); 
 
$q_token = $resultpageQuotation['q_token'];




if($_REQUEST['q_token']==$q_token && isset($_REQUEST['q_token'])){
	$isMenu = 1;
	// include "../logincheck.php";  
	if($_SESSION['username']=="" || $_SESSION['sessionid']!=session_id() || $_SESSION['userid']=="" || $_SESSION['uSession']=="" || $_SESSION['otpvar']==""){ 
		header("Location:404.html");
		exit(); 
	}
}elseif($_REQUEST['q_token']!=$q_token || !isset($_REQUEST['q_token'])){
	$isMenu = 0;
}else{
	die();
}

$propNum = $_REQUEST['propNum'];
if($propNum!=''){
	$propNum=$propNum;
}else{
	$propNum=4;
}
if($propNum==1){
	$proName='costsheet_proposal';
}
if($propNum==2){
	$proName='brief_proposal';
}
if($propNum==3){
	$proName='detailed_proposal';
}
if($propNum==4){
	$proName='elite_proposal';
}
if($propNum==6){
	$proName='vivid_proposal';
}
if($propNum==7){
	$proName='indian_proposal';
}
if($propNum==9){
	$proName='vista_proposal';
}
if($propNum==10){
	$proName='text_proposal';
}
if($propNum==5){
	$proName='send_supplier';
}


$select='*';  
$where='id='.$resultpageQuotation['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 

if($resultpage['clientType']==2){
	$clientType = 'contacts';
}else{
	$clientType = 'corporate';
}
$clinetWhatsappNumber = getContactPersonPhone($resultpage['companyId'],$clientType);

$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];

$totalRooms = $resultpageQuotation['sglRoom']+$resultpageQuotation['dblRoom']+$resultpageQuotation['tplRoom']+$resultpageQuotation['twinRoom']+$resultpageQuotation['sixNoofBedRoom']+$resultpageQuotation['eightNoofBedRoom']+$resultpageQuotation['tenNoofBedRoom'];

$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];
$dayWise= $resultpage['dayWise'];

$dayWiseQ= $resultpageQuotation['dayWise'];



$travelType= $resultpage['travelType'];
$isUni_Mark= $resultpage['isUni_Mark'];
$isSer_Mark= $resultpage['isSer_Mark'];

// $itineraryintrText = '';



$rsto=GetPageRecord('*',_OVERVIEW_MASTER_,'id="'.$resultpageQuotation['overviewId'].'" and deletestatus=0 and status=1 order by overviewname asc'); 
$resListingTO=mysqli_fetch_array($rsto);

if($resListingTO['overviewTitle_1']==''){
	$overviewTitle = strtoupper('Overview Information');
}else{
	$overviewTitle = strtoupper($resListingTO['overviewTitle_1']);
}

if($resListingTO['overviewTitle_2']==''){
	$overviewHiTitle = strtoupper('Hightlight Information');
}else{
	$overviewHiTitle = strtoupper($resListingTO['overviewTitle_2']);
}

if($resListingTO['overviewTitle_3']==''){
	$itinerarySumTitle = strtoupper('Itinerary Summary');
}else{
	$itinerarySumTitle = strtoupper($resListingTO['overviewTitle_3']);
}

if($resListingTO['overviewTitle_4']==''){
	$itineraryIntroTitle = strtoupper('Itinerary introduction');
}else{
	$itineraryIntroTitle = strtoupper($resListingTO['overviewTitle_4']);
}

if($resultpage['paxType'] == 1){
	$rsFG=GetPageRecord('*','gitIncExcMaster','id="'.$resultpageQuotation['fitGitId'].'" and deletestatus=0 and status=1 order by gitName desc'); 
}elseif($resultpage['paxType'] == 2){
	$rsFG=GetPageRecord('*','fitIncExcMaster','id="'.$resultpageQuotation['fitGitId'].'" and deletestatus=0 and status=1 order by fitName desc'); 
}


	$resListingFG=mysqli_fetch_array($rsFG);
		if($resListingFG['title_1']==''){
		$inclusionTitle = strtoupper('Inclusion');
	}else{
		$inclusionTitle = strtoupper($resListingFG['title_1']);
	}

	if($resListingFG['title_2']==''){
		$exclusioinTitle = strtoupper('Exclusion');
	}else{
		$exclusioinTitle = strtoupper($resListingFG['title_2']);
	}

	if($resListingFG['title_3']==''){
		$termCTitle = strtoupper('Terms & Conditions');
	}else{
		$termCTitle = strtoupper($resListingFG['title_3']);
	}

	if($resListingFG['title_4']==''){
		$cancelPTitle = strtoupper('CANCELLATION POLICIES');
	}else{
		$cancelPTitle = strtoupper($resListingFG['title_4']);
	}

	if($resListingFG['title_5']==''){
		$serviceUpTitle = strtoupper('Service Upgradation');
	}else{
		$serviceUpTitle = strtoupper($resListingFG['title_5']);
	}

	if($resListingFG['title_6']==''){
		$opsTourTitle = strtoupper('Optional Tour');
	}else{
		$opsTourTitle = strtoupper($resListingFG['title_6']);
	}

	if($resListingFG['title_7']==''){
		$paymentPTitle = strtoupper('Payment Policy');
	}else{
		$paymentPTitle = strtoupper($resListingFG['title_7']);
	}

	if($resListingFG['title_8']==''){
		$remarksTitle = strtoupper('Remarks');
	}else{
		$remarksTitle = strtoupper($resListingFG['title_8']);
	}


$overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText=$serviceupgradationText=$optionaltourText=$itineraryintrText=$itinerarysummText='';
if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
	$overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText'])); 
}
if($resultpageQuotation['itineraryintrText']!='' || $resultpageQuotation['itineraryintrText']!='undefined'){
	$itineraryintrText=preg_replace('/\\\\/', '',clean($resultpageQuotation['itineraryintrText'])); 
}
if($resultpageQuotation['itinerarysummText']!='' || $resultpageQuotation['itinerarysummText']!='undefined'){
	$itinerarysummText=preg_replace('/\\\\/', '',clean($resultpageQuotation['itinerarysummText'])); 
}
if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
	$highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
}
if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
	$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['serviceupgradationText']!='' || $resultpageQuotation['serviceupgradationText']!='undefined'){
	$serviceupgradationText=preg_replace('/\\\\/', '',clean($resultpageQuotation['serviceupgradationText']));
}
if($resultpageQuotation['optionaltourText']!='' || $resultpageQuotation['optionaltourText']!='undefined'){
	$optionaltourText=preg_replace('/\\\\/', '',clean($resultpageQuotation['optionaltourText']));
}

if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
	$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
	$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
}
if($resultpageQuotation['specialText']!='' || $resultpageQuotation['specialText']!='undefined'){
	$specialText=preg_replace('/\\\\/', '',clean($resultpageQuotation['specialText']));
}
if($resultpageQuotation['paymentpolicy']!='' || $resultpageQuotation['paymentpolicy']!='undefined'){
	$paymentpolicy=preg_replace('/\\\\/', '',clean($resultpageQuotation['paymentpolicy']));
}
if($resultpageQuotation['remarks']!='' || $resultpageQuotation['remarks']!='undefined'){
	$remarks=preg_replace('/\\\\/', '',clean($resultpageQuotation['remarks']));
}

$colorres = GetPageRecord('*','proposalSettingMaster','deletestatus=0 and proposalNum="'.$propNum.'"');
$colorResult = mysqli_fetch_assoc($colorres);

if($resultpageQuotation['quotationSubject']!=''){
	$quotationSubject = preg_replace('/\\\\/', '',clean($resultpageQuotation['quotationSubject']));
}else{
	$quotationSubject = strtoupper(strip($resultpage['subject']));
} 
?>  
<!DOCTYPE html>
<html>
<head>
	<!--<meta charset="utf-8">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta content="MIME-Version: 1.0">-->
    <!--<meta content="Content-type:text/html;charset=UTF-8">-->
    
    <title ><?php echo $quotationSubject; ?></title>
    <link  rel="preconnect" href="https://fonts.googleapis.com">
    <link  rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link  href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,600;1,700;1,900&display=swap" rel="stylesheet"> 
    
    <link  rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>plugins/font-awesome/css/font-awesome.min.css?t=<?php echo time(); ?>">
    <link  rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>PreviewFiles/css/proposal-main.css?t=<?php echo time(); ?>">
    <script  src="<?php echo $fullurl; ?>PreviewFiles/js/proposal-main.js?t=<?php echo time(); ?>"></script> 
    
    <link  href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <script  src="<?php echo $fullurl; ?>js/jquery-3.5.0.min.js?t=<?php echo time(); ?>"></script> 
    <script  src="<?php echo $fullurl; ?>js/main.js?t=<?php echo time(); ?>"></script> 
    <script  src="<?php echo $fullurl; ?>js/validation.js?t=<?php echo time(); ?>"></script> 
    <style  type="text/css">
    	.calcostsheet{
    		display: none;
    		visibility: hidden;
    	}
    </style>	 
	<?php if($propNum == 1){ ?>
		<style type="text/css"> 
			@media print{
			    .main-container,body{
			        background-color: #ffffff !important;
			        margin-top: -30px!important;
			    }
			    div,ul,li,body,button{
					margin: 0;
				    padding: 0;
				    border: 0;
				    font: inherit;
				    vertical-align: baseline;
				    font-family: 'Roboto', sans-serif;
				}
				.firstpage .docTitle{
					padding: 15px 30px 5px 30px;
				}
				.firstpage .docTitleArrow{
				    position: absolute;
				    right: -33px;
				    top: 0px;
				    height: 0;
				    width: 0;
				    border-left: 0px solid #233a4900;
				    border-bottom: 53px solid #233a49;
				    border-right: 40px solid #fff0;
				    border-top: 0px solid #233a49;
				}
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				font-size: 14px;
				color: #3c3a3a;
				font-weight: 400;
/*				background-color: #cadbec;*/
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer{
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        } 
	        /*end teseting*/

			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}

			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    
		    .dayTitle{
		    	line-height: 25px;
		    	font-size: 18px;
		    	text-align: left;
			    padding: 8px;
			    margin-bottom: 10px;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/
		    }
		    .serviceTitle{
		      	font-size: 18px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		   
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    	/*background-color: #233a49;*/
		    	/*color: #ffffff;*/
		    	padding: 7px;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
				background-color: #233a49;
			    padding: 4px 29px;
			    color: #fff;
			    font-weight: bold;
			    font-size: 20px;
			    position: relative;
			    /*display: inline-block;*/
			    height: 33px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid #233a4900;
			    border-bottom: 41px solid #233a49;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid #233a49;
			}
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 22px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: auto;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
			 .serviceTitle{
			 	color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    }
		</style>
	<?php }elseif($propNum == 2){ ?>
		<style type="text/css"> 
			@media print{
			    .main-container,body{
			        background-color: #ffffff !important;
			        margin-top: -30px!important;
			    }
			    div,ul,li,body,button{
					margin: 0;
				    padding: 0;
				    border: 0;
				    font: inherit;
				    vertical-align: baseline;
				    font-family: 'Roboto', sans-serif;
				}
				.firstpage .docTitle{
					padding: 15px 30px 5px 30px;
				}
				.firstpage .docTitleArrow{
				    position: absolute;
				    right: -33px;
				    top: 0px;
				    height: 0;
				    width: 0;
				    border-left: 0px solid #233a4900;
				    border-bottom: 53px solid #233a49;
				    border-right: 40px solid #fff0;
				    border-top: 0px solid #233a49;
				}
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				font-size: 14px;
				color: #3c3a3a;
				font-weight: 400;
/*				background-color: #cadbec;*/
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer {
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        }   
	        /*end teseting*/
		     
			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .dayTitle{
		    	line-height: 25px;
		    	font-size: 18px;
		    	text-align: left;
			    padding: 8px;
			    margin-bottom: 10px;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/
		    }
		    .serviceTitle{
		      	font-size: 18px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    	/*background-color: #233a49;*/
		    	/*color: #ffffff;*/
		    	/*text-align: left;*/
		    	padding: 7px;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
				background-color: #233a49;
			    padding: 4px 29px;
			    color: #fff;
			    font-weight: bold;
			    font-size: 20px;
			    position: relative;
			    /*display: inline-block;*/
			    height: 33px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid #233a4900;
			    border-bottom: 41px solid #233a49;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid #233a49;
			}
			
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 22px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: always;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
		</style>

		<!-- text proposal related css started -->
	<?php }elseif($propNum == 10){ ?>
		<style type="text/css"> 
			@media print{
				.whatsAppSBtn{
					display: none;
				}
			    .main-container,body{
			        background-color: #ffffff !important;
			        margin-top: -30px!important;
			    }
			    div,ul,li,body,button{
					margin: 0;
				    padding: 0;
				    border: 0;
				    font: inherit;
				    vertical-align: baseline;
				    font-family: 'Roboto', sans-serif;
				}
				.firstpage .docTitle{
					padding: 15px 30px 5px 30px;
				}
				.firstpage .docTitleArrow{
				    position: absolute;
				    right: -33px;
				    top: 0px;
				    height: 0;
				    width: 0;
				    border-left: 0px solid #233a4900;
				    border-bottom: 53px solid #233a49;
				    border-right: 40px solid #fff0;
				    border-top: 0px solid #233a49;
				}
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				font-size: 14px;
				color: #3c3a3a;
				font-weight: 400;
/*				background-color: #cadbec;*/
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer {
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        }   
	        /*end teseting*/
		     
			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .dayTitle{
		    	line-height: 25px;
		    	font-size: 18px;
		    	text-align: left;
			    padding: 8px;
			    margin-bottom: 10px;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/
		    }
		    .serviceTitle{
		      	font-size: 18px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:black;
		    	background-color: hsl(218.46deg 52.7% 70.98%);
		    	/*background-color: #233a49;*/
		    	/*color: #ffffff;*/
		    	/*text-align: left;*/
		    	padding: 7px;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
				background-color: #233a49;
			    padding: 4px 29px;
			    color: #fff;
			    font-weight: bold;
			    font-size: 20px;
			    position: relative;
			    /*display: inline-block;*/
			    height: 33px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid #233a4900;
			    border-bottom: 41px solid #233a49;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid #233a49;
			}
			
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 22px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: always;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
		</style>
		<!-- text proposal related css ended -->
	<?php }elseif($propNum == 3 || $propNum == 5 || $propNum == 11){ ?>
		<style type="text/css"> 
			
				@media print{
					.main-container,body{
						background-color: #ffffff !important;
						margin-top: -30px!important;
					}
					div,ul,li,body,button{
						margin: 0;
						padding: 0;
						border: 0; 
						vertical-align: baseline;
						font-family: 'Roboto', sans-serif;
					}
					.firstpage .docTitle{
						padding: 15px 30px 5px 30px;
					}
					.firstpage .docTitleArrow{
						position: absolute;
						right: -33px;
						top: 0px;
						height: 0;
						width: 0;
						border-left: 0px solid #233a4900;
						border-bottom: 53px solid #233a49;
						border-right: 40px solid #fff0;
						border-top: 0px solid #233a49;
					}
				}
			div,ul,li,body,button{
				margin: 0;
			    padding: 0;
			    border: 0; 
			    vertical-align: baseline;
			    font-family: 'Roboto', sans-serif;
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				font-size: 14px!important;
				color: #3c3a3a;
				font-weight: 400;
/*				background-color: #cadbec;*/
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer {
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        }   
	        /*end teseting*/
		     

			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .dayTitle{
		        line-height: 22px;
			    font-size: 18px;
			    padding: 8px;
			    margin-bottom: 10px;
			    text-align: left;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/
		    }
		    .serviceTitle{
		      	font-size: 18px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;

		    	/*color: #ffffff;*/
		    	/*background-color: #233a49;*/
		    	/*text-align: left;*/
		    	padding: 7px;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: #fff;*/
				/*background-color: #233a49;*/
			    padding: 4px 30px;
			    font-weight: 400;
			    font-size: 18px;
			    position: relative;
			    height: 33px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid #233a4900;
			    border-bottom: 41px solid #233a49;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid #233a49;
			}
			
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 18px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: always;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 14px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 14px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
		</style>
	<?php }elseif($propNum == 4){ ?>
		<style type="text/css"> 
			@media print{
			    .main-container,body{
			        background-color: #ffffff !important;
			        margin-top: -30px!important;
			    }
			    div,ul,li,body,button{
					margin: 0;
				    padding: 0;
				    font-size: 14px!important;
				    border: 0;
				    vertical-align: baseline;
				    font-family: 'Roboto', sans-serif;
				}
				.firstpage .docTitle{
					padding: 15px 30px 5px 30px;
				}
				.firstpage .docTitleArrow{
				    position: absolute;
				    right: -33px;
				    top: 0px;
				    height: 0;
				    width: 0;
				    border-left: 0px solid transparent;
				    border-bottom: 53px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
				    border-right: 40px solid #fff0;
				    border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
				}
			}
			div,ul,li,body,button{
				margin: 0;
			    padding: 0;
			    font-size: 14px!important;
			    border: 0;
			    vertical-align: baseline;
			    font-family: 'Roboto', sans-serif;
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				color: #3c3a3a;
				font-size: 14px!important;
				font-weight: 400;
				/* background-color: #cadbec; */
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer {
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        }   
	        /*end teseting*/
		    

			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .dayTitle{
			    line-height: 22px;
			    font-size: 18px!important;
			    padding: 8px;
			    margin-bottom: 10px;
			    text-align: left;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/

		    }
		    .serviceTitle{
		      	font-size: 18px!important;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;

		    	/*color: #ffffff;*/
		    	/*background-color: #233a49;*/
		    	/*text-align: left;*/
		    	padding: 7px;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: #fff;*/
				/*background-color: #233a49;*/
			    padding: 4px 29px;
			    font-weight: 400;
			    font-size: 18px!important;
			    position: relative;
			    display: inline-block;
			    height: 33px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid transparent;
			    border-bottom: 41px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			}
			
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 18px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: always;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 14px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 14px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
		</style>
		<!-- Started Vista Proposal related css -->
	<?php }elseif($propNum == 9){ ?>
		<style type="text/css"> 
			@media print{
			    .main-container,body{
			        background-color: #ffffff !important;
			        margin-top: -30px!important;
			    }
			    div,ul,li,body,button{
					margin: 0;
				    padding: 0;
				    font-size: 14px!important;
				    border: 0;
				    vertical-align: baseline;
				    font-family: 'Roboto', sans-serif;
				}
				.firstpage .docTitle{
					padding: 15px 30px 5px 30px;
				}
				.firstpage .docTitleArrow{
				    position: absolute;
				    right: -33px;
				    top: 0px;
				    height: 0;
				    width: 0;
				    border-left: 0px solid transparent;
				    border-bottom: 53px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
				    border-right: 40px solid #fff0;
				    border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
				}
			}
			div,ul,li,body,button{
				margin: 0;
			    padding: 0;
			    font-size: 14px!important;
			    border: 0;
			    vertical-align: baseline;
			    font-family: 'Roboto', sans-serif;
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				color: #3c3a3a;
				font-size: 14px!important;
				font-weight: 400;
				/* background-color: #cadbec; */
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer {
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        }   
	        /*end teseting*/
		    

			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .dayTitle{
			    line-height: 22px;
			    font-size: 18px!important;
			    padding: 8px;
			    margin-bottom: 10px;
			    text-align: left;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/

		    }
		    .serviceTitle{
		      	font-size: 18px!important;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;

		    	/*color: #ffffff;*/
		    	/*background-color: #233a49;*/
		    	/*text-align: left;*/
		    	padding: 7px;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: #fff;*/
				/*background-color: #233a49;*/
			    padding: 4px 29px;
			    font-weight: 400;
			    font-size: 18px!important;
			    position: relative;
			    display: inline-block;
			    height: 33px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid transparent;
			    border-bottom: 41px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			}
			
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 18px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: always;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 14px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 14px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
		</style>
		<!-- Ended Vista Proposal related css -->
	<?php }elseif($propNum == 6){ ?>
		<style type="text/css"> 
			@media print{
			    .main-container,body{
			        background-color: #ffffff !important;
			        margin-top: -30px!important;
			    }
			    div,body,button {
					margin: 0;
				    padding: 0;
				    border: 0;
				    font: inherit;
				    vertical-align: baseline;
				    font-family: 'Roboto', sans-serif;
				}
				.firstpage .docTitle{
					padding: 15px 30px 5px 30px;
				}
				.firstpage .docTitleArrow{
				    position: absolute;
				    right: -33px;
				    top: 0px;
				    height: 0;
				    width: 0;
				    border-left: 0px solid #233a4900;
				    border-bottom: 53px solid #233a49;
				    border-right: 40px solid #fff0;
				    border-top: 0px solid #233a49;
				}
			}
	     	@page {
	            margin: 0;
	            margin-bottom: 80px;
	            margin-top: 50px;
	        }
	        body{
				font-size: 14px;
				color: #3c3a3a;
				font-weight: 400;
/*				background-color: #cadbec;*/
				font-family: 'Source Sans Pro', sans-serif;
	        }
		   	footer {
	            position: fixed; 
	            bottom: -80px; 
	            left: 0cm; 
				/*background-color: #ff0000;*/
	            right: 0cm; 
	            height: 80px; 
	        }   
	        /*end teseting*/
		     
			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 40px 0px; 
			} 
			div,body,button{
				margin: 0;
			    padding: 0;
			    border: 0;
			    font-size: 14px!important;
			    vertical-align: baseline;
			    font-family: 'Roboto', sans-serif;
			}
			ul {
				list-style-position: inside;
				padding: 0;
	    		margin: 0;
			}
			.propsal_nav ul {
				list-style: none;
				color: #424244;
				list-style-position: inside;
				padding-left: 10px;
	    		margin: 0;
			}
			.propsal_nav ul li{
			    margin-bottom: 10px;
			}
			
		    .table-service{
				page-break-inside: avoid;
				page-break-after: auto;
				page-break-before: auto;
		    }
		    .row-service{
		    	page-break-inside: avoid;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .row-titleDesc{ 
		    	page-break-inside: auto;
		    	page-break-after: auto;
		    	page-break-before: auto;
		    }
		    .dayTitle{
		        line-height: 22px;
			    font-size: 25px!important;
			    padding: 5px;
			    padding-bottom: 8px;
			    margin-bottom: 10px;
			    text-align: center;
			    color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: white;*/
			    /*background-color: #233a49;*/
		    }
		    .serviceTitle{
		      	font-size: 18px!important;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .subHeading{
		      	font-size: 15px;
			    line-height: 20px;
			    color: #233a49;
			    font-weight: 700;
		    }
		    .serviceDesc{
		    	text-align: justify;
		    	page-break-inside: auto;
		    	font-size: 14px;
			    padding-bottom: 5px;
			    line-height: 18px;
		    }
		    table{
		    	border-collapse: collapse;
		    }
		    table.borderedTable{
		    	width: 100%;
		    }
		    table.borderedTable th{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
		    	/*color: #ffffff;*/
		    	/*background-color: #233a49;*/
		    	padding: 7px;
		    	/*text-align: left;*/
		    	font-weight: 400;
		    }
		    .calcostsheet{
		    	display:none;
		    	visibility: hidden;
		    	height: 0;
		    	width: 0;
		    	position: fixed;
		    	left: 0;
		    	top: 0;
		    }
		    .docTitle{
		    	color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>;
		    	background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#233a49'; } ?>;
			    /*color: #fff;*/
				/*background-color: #233a49;*/
			    padding: 4px 29px;
			    /*font-weight: bold;*/
			    font-size: 18px!important;
			    position: relative;
			    height: 30px;
			    line-height: 30px;
			}
			.docTitleArrow{
			    position: absolute;
			    right: -33px;
			    top: 0px;
			    height: 0;
			    width: 0;
			    border-left: 0px solid #233a4900;
			    border-bottom: 41px solid #233a49;
			    border-right: 33px solid #fff0;
			    border-top: 0px solid #233a49;
			}
			
			/*docBanner*/
			.docBanner{
				position: relative;
			}
			.bannerText{
			    position: absolute;
			    top: 30px;
			    left: 30px;
			    right: 30px;
			    text-align: left;
			    display: block; 
			}
			.bannerText1 {
			    position: absolute;
			    bottom: 15px;
			    left: 30px;
			    right: 30px;
			    text-align: center;
			    display: block;
			    background-color: #233a49cc;
			    padding: 5px;
			}
			.bannerText strong, .bannerText1 strong{
				font-weight: 600;
			}
			.colorSize1{
			    color: #fff;
			    font-size: 27px;
			}
			.colorSize2{
			    font-size: 16px;
			}
			.colorSize3 strong{
				font-size: 22px;
				padding: 0px 5px;
			}
			.text1{
			    font-weight: 500;
			    display: block;
			}
			.text2{
				font-weight: 600;
				display: block;
			}
			.overviewBox{
				padding: 30px;
				padding-bottom: 10px;
				display: block;
				page-break-after: always;
			}
			.overviewBox .serviceTitle{
				padding-bottom: 10px; 
				display: block;
				color: #424244;
			}
			.overviewBox .serviceDesc{
				padding-bottom: 10px;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
				font-family: 'Source Sans Pro', sans-serif;
			}
			.dayItineraryInfo{
				padding: 30px;
				padding-bottom: 10px;
			    /*background-color: #ccc;*/
			    display: block;
			    position: relative;
			    font-size: 16px;
				color: #424244;
				font-weight: 400;
			    font-family: 'Source Sans Pro', sans-serif;
			}
			.itineraryTitle{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
			.itineraryDesc{
				text-align: justify;
			    page-break-inside: auto;
			    padding-bottom: 20px;
			}
		    .text-center{
		    	text-align: center!important;
		    }
		    .valignBottom{

		    }
		    .pd30{
		    	padding: 30px;
		    }
		    .w60{
		    	width: 60%;
		    }
			.imgbox{
				width: 200px;
				height: 130px;
				border-radius: 10px;
				overflow: hidden;
			    border: 1px solid #ffffff;
			    box-shadow: 3px 3px 7px 0px rgb(185 185 185);
			}
			.imgbox img{ 
				object-fit: cover;
			}
		</style>
	<?php }elseif($propNum == 8){ ?>
		<style type="text/css">

			.dscmgn p{
				margin-right: 10px;
			}
			.qid-mp{
				font-weight: 100;
				width: 200px;
				font-size: 14px;
				position: relative;
				left: 48%;
				text-align: right;
				margin-top: 10px;
			}
			.subject-proposal{
				background: #49497d;
				height: 40px;
				color: white;
				text-align: center;
				position: relative;
			}
			.subject-proposal h2{
				padding-top: 7px;
			}
			.meg-pro-inner-sec{
				background: #f8f3f3;
				border: 1px solid gray;
				border-radius: 5px;
			}
			.qid-mp{
				/* margin-left: 54%; */
			}
			.mg-name-qid{
				display: flex;
				width: 100%;
			}
			.trav-dt-ss{
				position: relative;
				left: 15%;
			}
			.daywisempro{
				background: #49497d;
				height: 40px;
				color: white;
				position: relative;
				width: 60%;
			}
			.daywisemproh2{
				padding-top: 5px;
				padding-left: 20px;
				font-weight: 200;
			}
			.day-title-des h4{
				font-size: 16px;
				/* font-weight: 100; */
				font-weight: bold;
			}
			.day-title-des{
				padding: 0px 30px;
			}
			.time-hours{
				border: 2px solid #ceb2b2;
				padding: 10px 20px;
				width: 70px;
				font-weight: 700;
			}
			.desc-mgpro{
				border-left: 1px solid grey;
				padding: 7px 13px;
				background: #f0e6e6;
				position: relative;
				/* left: 20%; */
				top: -40px;
				/* width: 80%; */
				min-width: 600px;
    			margin-left: 130px;
			}
			.servicetimedesc-mgpr{
				padding: 10px 30px
			}

			/* inclusion and exclusion and term and cond. etc. css started*/
			.incexctermcan{
				/* background: #49497d;
				height: 40px;
				color: white;
				position: relative;
				width: 30%; */
			}
			.incexctermcanh2{
				padding-top: 5px;
				padding-left: 20px;
				font-weight: 200;
				background: #49497d;
				height: 40px;
				color: white;
				position: relative;
				width: 30%;
			}
			.incexctermcanh23{
				padding-top: 5px;
				padding-left: 20px;
				font-weight: 200;
				background: #49497d;
				height: 40px;
				color: white;
				position: relative;
				width: 40%;
			}
			.incexctermcan-sec{
				padding: 1px 2px;
			}
			.incexctermcan-sec ul li{
				padding: 5px 10px;
				font-size: 18px;
				font-family: sans-serif;
			}

			.vaservices-details-tdate{
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
				margin-top: -20px;
			}
			.end-of-doc-sec{
				margin-top: 5%;
			}
			.trav-dt-ss2{
				background: #49497d;
				height: 40px;
				color: white;
			}
			.cnt-pro-m{
				border: 1px solid #837878;
			}
			.docTitleArrow{
				position: absolute;
				right: -33px;
				top: 0px;
				height: 0;
				width: 0;
			}
		</style> 
	<?php } ?>
    <style>  
	    .fullwidth{
	        width: 822px !important;;
	    } 
        .imgwidth{
	        /*width: 720px!important;*/
	        /*height:auto;*/
	    }
		.main-container{
			display: block; 
			margin: 0 auto;
			position: relative; 
			/*border: 0px solid #ffffff;*/
			background-color: #ffffff;
		} 
		.skiptranslate{
		    height:0;
		    width:0;
		}
		.goog-te-combo {
            position: fixed;
            top: 6px;
            left: auto;
            right: 24%;
            background-color: #233a49;
            z-index: 999999;
            color: #fff; 
            width: 145px;
            padding: 7px 10px;
        }
        .goog-te-gadget span{
            /*display:none;*/
        }
        
    </style>
</head>
<body style="background-color:#dddddd" >
	<iframe id="actoinfrm" name="actoinfrm" src="" style="display:none;" class="removeDiv"></iframe>
	<div id="proposal_alertbox" style="display:none; background-image:url(img/bgpop.png); background-repeat:repeat;" class="removeDiv">
	 	<div id="proposal_alertswhitebox"><i class="fa fa-globe" aria-hidden="true"></i> </div> 
	</div> 
	<?php 
	if($isMenu == 1){
		include_once("proposal_header.php"); 
	}
	?>
	<div class="calcostsheet removeDiv" id="removeDiv">
	<?php  
	if($resultpageQuotation['queryType']==13){
		include_once("../loadMultiServicesCostSheet.php");
	}else{
	$costsheetNM = '';
	if($travelType==2){
		$costsheetNM = '_domestic';
	}
	
	if($resultpageQuotation['calculationType']==2){
		include_once("../loadPackageWiseCostSheet.php"); 
	}elseif($resultpageQuotation['calculationType']==3){
		include_once("../loadCompletePackageCostSheet.php"); 
	}else{
		include_once("../loadCostSheet".$costsheetNM.".php"); 
	}
	}
	$queryId = $resultpageQuotation['queryId'];
	$quotationId= $resultpageQuotation['id'];
	?>
	</div> 
	<div id="printBox" style="margin: 0px;" class="mgc fullwidth">
	<?php include_once("proposal_0".$propNum.".php"); ?> 
	</div> 
	 
	<!-- Google translatore create -->
	
	 <script type="text/javascript"> 
      function googleTranslateElementInit() {
        new google.translate.TranslateElement(
          {
            pageLanguage: "en",
            includedLanguages: "hi,en,ar,fr,es,zh-CN,zh-TW,de,ja,bn",
            autoDisplay: "true",
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL,
          },
          "google_translate_element"
        );
      }
    </script>
    
    <div id="google_translate_element" style="display:none1;"></div>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <!--<script src="runtime-es2015.b0b5b30fef9b4c09d82c.js" type="module"></script><script src="polyfills-es2015.1685c7ac5d3f495ce262.js" type="module"></script><script src="runtime-es5.9bc1b881a58a5626cf5e.js" nomodule=""></script><script src="polyfills-es5.007f48576e9e062ee66c.js" nomodule=""></script>-->
    <!--<script src="main-es2015.4e32d02ea4f7b1d12561.js" type="module"></script><script src="main-es5.f92f1d0327dc36332dd6.js" nomodule=""></script>-->
</body>
</html>
