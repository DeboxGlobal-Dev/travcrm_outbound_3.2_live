<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<style type="text/css">
		.main-container{
			display: block;
			/*width: 700px;*/
			margin: 0px auto;
			position: relative; 
			font-size: 12px;
			border: 0px solid #ccc;
			background-color: #fff;
			color: #3c3a3a;
		}
		body{
			/*background-color: #ddd;*/
		}
		table{
			page-break-before: auto;
		}
		tr{
			page-break-inside: auto;	
		}
		.blank_line{
			margin: 5px 0;
		}
		.hr_line{
			margin: 10px 0px;
			height: 0;
			page-break-before: auto;
			border-top: 1px solid #ddd;
		}
		ul {
			list-style-type: circle;
			color: #383636;
			list-style-position: outside;
		}
		@page { margin: 40px 20px; }
	    .firstpage { 
	      	margin-top: -20px!important;
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
	    	page-break-after: auto;
	    	page-break-before: auto;
	    }
	    .dayTitle{
		    font-weight: 600;
		    line-height: 20px;
		    font-size:18px;
		    margin-bottom:10px; 
		    text-align:center;
	    }
	    .serviceTitle{
	      	font-size: 15px;
		    font-weight: 600;
		    padding-bottom: 5px;
		    line-height: 20px;
	    }
	    .serviceDesc{
	    	text-align: justify;
	    	font-size: 14px;
		    padding-bottom: 5px;
		    line-height: 18px;
	    }
	    img{
	    	margin-top: 2px;
	    }
	    .table-service img{
	    	margin-top: 5px;
	    }
	</style>
</head>
<body >
<div class="main-container">
	<table class="firstpage" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
		<tr>
			<td align="center" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/dirfiles/1638248105proposal-logo.jpg" width="100%" ><div class="hr_line">&nbsp;</div></td>
		</tr>
		<tr>
			<td align="center" style="padding: 20px 0;font-size:22px;text-align:center;">
				<strong>Golden Triangle Tour  NightsGolden Triangle Tour NightsGolden Triangle Tour | 2 Adults - 4 Nights</strong> 
			</td>
		</tr>
		<tr>
			<td align="center"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/dirfiles/1643442301_D000001_800x400.jpg" width="100%" height="500" style="width: 100%;">
			</td>
		</tr> 
		</tbody>
	</table>
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:14px">
		<tbody>
			<tr>
				<td width="50%" align="right" style="color:#FF9900;"><div align="right"><strong>DESTINATION COVERED</strong></div></td>
				<td width="50%" align="left" style="color:#000; border-left:1px solid #ddd;"><strong>Delhi, Agra and Jaipur</strong>
				</td>
			</tr>
			<tr>
				<td width="50%" align="right" style="color:#FF9900;"><div align="right"><strong>DURATION</strong></div></td>
				<td width="50%" align="left" style="color:#000;border-left:1px solid #ddd;"><strong>1 Nights / 2 Days </strong></td>
			</tr>
			<tr>
				<td width="50%" align="right" style="color:#FF9900;"><div align="right"><strong>TRAVELLERS</strong></div></td>
				<td width="50%" align="left" style="color:#000;border-left:1px solid #ddd;"><strong>9 Adults / </strong></td>
			</tr>
		</tbody>
	</table>
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:14px;">
		<tbody>
			<tr>
				<td align="center" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/images/location-package.png" width="60" height="60"></td>
			</tr>
			<tr>
				<td align="center" valign="top" style="font-size:14px;">
					<span>Delhi</span>&nbsp;&nbsp;
					<img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/images/right-location.png" height="13" width="13">&nbsp;&nbsp;
					<span>Agra</span>&nbsp;&nbsp;
					<img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/images/right-location.png" height="13" width="13">&nbsp;&nbsp;
					<span>Jaipur</span>
				</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;page-break-before: always;">
		<tbody>
			<tr >
				<td  align="center" valign="top"><strong style="font-size: 30px;">Itinerary</strong></td>
			</tr>		
		</tbody>
	</table>
	<div class="blank_line">&nbsp;</div>
	<!-- day wise loop  -->
	<!-- title and description -->
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
			<tr class="row-titleDesc">
				<td align="left" valign="top">
					<div class="dayTitle">Day 1 - Delhi - Monday 01-08-2022</div> 
					<div class="hr_line">&nbsp;</div>
					<strong class="serviceTitle">Arrival at Delhi Airport - Creative</strong>
					<span class="serviceDesc"><p>Delhi to Flight Arrive in Delhi. On arrival, you will be greeted and assisted by our representative and transferred.</p>
					<p>Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</p></span>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- start services -->
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<!-- title and description -->
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
			<tr class="row-titleDesc">
				<td align="left" valign="top">
					<div class="dayTitle">Day 1 - Delhi - Monday 01-08-2022</div> 
					<div class="hr_line">&nbsp;</div>
					<strong class="serviceTitle">Arrival at Delhi Airport - Creative</strong>
					<span class="serviceDesc"><p>Delhi to Flight Arrive in Delhi. On arrival, you will be greeted and assisted by our representative and transferred.</p>
					<p>Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</p></span>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- start services -->
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	
	<!-- title and description -->
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
			<tr class="row-titleDesc">
				<td align="left" valign="top">
					<div class="dayTitle">Day 1 - Delhi - Monday 01-08-2022</div> 
					<div class="hr_line">&nbsp;</div>
					<strong class="serviceTitle">Arrival at Delhi Airport - Creative</strong>
					<span class="serviceDesc"><p>Delhi to Flight Arrive in Delhi. On arrival, you will be greeted and assisted by our representative and transferred.</p>
					<p>Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</p></span>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- start services -->
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	
	<!-- title and description -->
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
			<tr class="row-titleDesc">
				<td align="left" valign="top">
					<div class="dayTitle">Day 1 - Delhi - Monday 01-08-2022</div> 
					<div class="hr_line">&nbsp;</div>
					<strong class="serviceTitle">Arrival at Delhi Airport - Creative</strong>
					<span class="serviceDesc"><p>Delhi to Flight Arrive in Delhi. On arrival, you will be greeted and assisted by our representative and transferred.</p>
					<p>Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</p></span>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- start services -->
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	
	<!-- title and description -->
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tbody>
			<tr class="row-titleDesc">
				<td align="left" valign="top">
					<div class="dayTitle">Day 1 - Delhi - Monday 01-08-2022</div> 
					<div class="hr_line">&nbsp;</div>
					<strong class="serviceTitle">Arrival at Delhi Airport - Creative</strong>
					<span class="serviceDesc"><p>Delhi to Flight Arrive in Delhi. On arrival, you will be greeted and assisted by our representative and transferred.</p>
					<p>Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</p></span>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- start services -->
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	<div class="hr_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service">
		<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/OutBound1.5/TravCRMExtension/travcrm-dev/docFiles/Destinations/Delhi/Activities/foodies-delight-in-delhi-1643454650-380x246.png" width="130" height="80">
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
				<tbody>
					<tr>
						<td ><strong class="serviceTitle">Foodies Delight in Delhi 3</strong></td>
					</tr>
					<tr>
						<td ><div class="serviceDesc">Explore the sights, sounds, and distinct flavors on this day-long culinary journey through Old and New Delhi. Dive into the thriving street food scene of India's capital, which brings together influences aplenty from neighboring regions. Sample up to different types of dishes while you whistle-stop from one legendary eatery to another in the bustling streets of Old Delhi.</div>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		</tr>
		</tbody>
	</table>
	
	<!-- end services -->
	<div class="blank_line">&nbsp;</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="center" valign="top">
				<div ><a href="http://www.deboxglobal.com/travcrm.html" target="_blank" >Generated by TravCRM</a></div>
			</td>
		</tr>
	</table>
</div>
</body>
</html
