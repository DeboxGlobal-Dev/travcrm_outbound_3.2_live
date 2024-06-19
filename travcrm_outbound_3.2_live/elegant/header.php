<?php 
include "../inc.php";
$id= decode($_REQUEST['id']);
$rs1='';
$rs1=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$id.'"');
$quotationData=mysqli_fetch_array($rs1);

$rs2='';
$rs2=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'"');
$querydata=mysqli_fetch_array($rs2);

$quotationStatus = $quotationData['status'];
$quotationId = $quotationData['id'];
$queryId = $quotationData['queryId'];
$quotationName = $quotationData['quotationSubject'];
$quotationNights = $quotationData['night'];
$assignTo = $querydata['assignTo'];

$dayN = 1;
$Destinations = '';
$cityQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" and addstatus=0 and deletestatus=0 group by cityId order by srdate asc');
$totalNights = mysqli_num_rows($cityQuery);
while($destData=mysqli_fetch_array($cityQuery)){
    $cityId = $destData['cityId'];
    if($dayN == ($totalNights-1)){
    	$Destinations .= getDestination($cityId).' and ';
    }else{
    	$Destinations .= getDestination($cityId).', ';
    }
    $dayN++;
}
$Destinations = rtrim($Destinations,', ');

if($querydata['clientType'] == 1){ $sectionType='corporate'; }else{ $sectionType='contacts'; }
$clientName = showClientTypeUserName($querydata['clientType'],$querydata['companyId']);
$clientPhone = getPrimaryPhone($querydata['companyId'],$sectionType);
$clientEmail = getPrimaryEmail($querydata['companyId'],$sectionType);

$comres = GetPageRecord('*','companySettingsMaster','companyName!=" " ');
$companydata = mysqli_fetch_assoc($comres);
$companyName = $companydata['companyName'];

$opsre = GetPageRecord('*','userMaster','id="'.$assignTo.'" ');
$Operationps = mysqli_fetch_assoc($opsre);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex" />
    <title><?php echo ucfirst($page); ?> - <?php echo $quotationName; ?></title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css' />
    <link href="<?php echo $fullurl; ?>elegant/css/intlTelInput.min.css" rel='stylesheet' type='text/css'>
    <link href="<?php echo $fullurl; ?>elegant/css/style.css" rel='stylesheet' type='text/css'>
    <style id="themeCustomiser"></style>
    <style id="customStyleSheetDI"></style>
	<style>
		.nav-back{
			background: white!important;
		}
		.nav-back li a{
			color: black !important;
		}
		/* {
			color: white !important;
		} */
		@media only screen and (max-width: 600px) {
			.mobile-view{
				width: 330px!important;
    			font-size: 18px!important;

			}
			.secondary-mob{
				left: -100%;
    			top: 35%;

			}
			.nav-mob{
				text-align: justify;
			}
			.consult-info{
				display: none;
			}
			.header-baner-mob{
				height: 100%!important;
    			width: 100%!important;
			}
		}
	</style>

    <!-- Demo css -->
    <link rel="stylesheet" href="<?php echo $fullurl; ?>elegant/css/jquery.animateSlider.css">
    <link rel="stylesheet" href="<?php echo $fullurl; ?>elegant/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $fullurl; ?>elegant/css/normalize.css">
    <link rel="stylesheet" href="<?php echo $fullurl; ?>elegant/css/anim-slider.css">
    <link rel="stylesheet" href="<?php echo $fullurl; ?>elegant/css/home.css">

    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@" />
    <meta name="twitter:title" content="Golden Triangle Tour" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="images/1.jpg" />

</head>
<body>


    <?php if($page != 'home'){ ?>
    <div id="page-wrapper" style="" data-id="48787">
		<div id="header" class="tabbed-header standard header-baner-mob" style="background-image: url('<?php echo $fullurl;?>elegant/images/defaultBanner.jpg'); height: 210px;">
		    <div id="logoName" class="logo-small own-logo ">
		        <div>
		            <div>
		                <h1 id="itinerary-name" class="classic-itinerary-name inverted mobile-view"><span class="operator-name"><?php echo $clientName; ?>: </span><?php echo $quotationName; ?></h1>
		            </div>
		        </div>
		    </div>

		    <div id="header-contact" class="">
		        <div class="sharing-wrap">
		            <!-- 
		            <div id="social-sharing" class="custom_overlay ">
		                <div id="social-content">
		                    <span class="custom_caption inverted">Share:</span>
		                    <div id="social-icons">
		                        <a target="_blank" class="custom_social_icons icon-icon-facebook- facebook round" href="https://www.facebook.com/deboxglobal"><img src="images/48-round-facebook.svg" /></a>
		                        <a target="_blank" class="custom_social_icons icon-icon-twitter twitter round" href="https://twitter.com/share?text=Click%20the%20link%20to%20view%20this%20awesome%20itinerary&amp;url=deboxglobal"><img src="images/48-round-twitter.svg" /></a>
		                    </div>
		                </div>
		            </div>
		            <div id="book-now">
		                <button class="book-now custom_cta h4">Book Now!</button>
		            </div> -->
		        </div>
		        <div id="contact-details" class="consult-info expand custom_border_colour secondary secondary-mob">
		            <div class="custom_title-bar custom_border_colour secondary">
		                <h3>Consultant Info</h3>
		            </div>
		            <div id="consultant-detail">
		                <div>
		                    <p class="name"><strong><?php echo $Operationps['firstName'].' '.$Operationps['firstName']; ?></strong></p>
		                    <p class="phone"><i class="icon-icon_telephone custom_icon"></i><?php echo $Operationps['mobile']; ?></p>
		                    <p class="email"><i class="icon-icon_email custom_icon"></i><a href="mailto:<?php echo $Operationps['email']; ?>"><?php echo $Operationps['email']; ?></a></p>
		                    <!-- <p class="website"><i class="icon-icon_web custom_icon"></i><a target="_blank" href="http://www,deboxglobal.com">http://www.deboxglobal.com</a></p> -->
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<ul id="nav" class="custom_nav tabbed primary custom_bg_primary nav-mob nav-back">
			<li <?php if($page == 'home'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/Home/<?php echo $_REQUEST['id']; ?>">Home</a></li>       
			<li <?php if($page == 'overview'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/Overview/<?php echo $_REQUEST['id']; ?>">Overview</a></li>
			<li <?php if($page == 'destinations'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/Destinations/<?php echo $_REQUEST['id']; ?>">Destinations</a></li>
			<li <?php if($page == 'accommodation'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/Accommodation/<?php echo $_REQUEST['id']; ?>">Accommodation</a></li>
			<li <?php if($page == 'dailyInfo'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/DailyInfo/<?php echo $_REQUEST['id']; ?>">Daily Information</a></li>
			<!-- <li <?php if($page == 'destinations'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/destinations/<?php echo $_REQUEST['id']; ?>">Map</a></li> -->
			<li <?php if($page == 'transport'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/Transport/<?php echo $_REQUEST['id']; ?>">Transport</a></li>
			<li <?php if($page == 'information'){ ?>class='selected'<?php } ?>><a class="h4 " href="<?php echo $fullurl; ?>Elegant/Information/<?php echo $_REQUEST['id']; ?>">Information</a></li>
		</ul>
		<?php } ?>