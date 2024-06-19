<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Mrs. Sinha</title>
		<style type="text/css">
			@font-face {
				font-family: 'Roboto', sans-serif;
				src: url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap') format('truetype');
			}
			body{ font-family: 'Roboto', sans-serif; font-weight: 300;  }
			strong{ font-family: 'Roboto', sans-serif; font-weight: 500; }
		@page {
		margin: 0cm 0cm;
		}
		body {
		margin-top: 1cm;
		margin-left: 20px;
		margin-right: 20px;
		margin-bottom: 1cm;
		}
		/*
		header {
		position: fixed;
		top: 0cm;
		left: 0cm;
		right: 0cm;
		height: 1cm;
		background-color: #ffc20f;
		color: white;
		text-align: center;
		line-height: 25px;
		}
		*/
		footer {
		position: absolute;
		bottom: 0cm;
		left: 0cm;
		right: 0cm;
		height: 1cm;
		/*background-color: #414143;*/
		color: #000;
		/*border-top: 1px solid #414143;*/
		font-size: 10px;
		text-align: center;
		line-height: 25px;
		}
		footer a{
		text-decoration: none;
		color: #000;
		}
		/*end teseting*/
		.firstpage {
			margin-top: -20px!important;
		}
		
			.main-container{
				display: block;
				/*width: 755px;*/
				/*comment above line to generate pdf*/
				margin: 0px auto;
				position: relative;
				font-size: 14px;
				border: 0px solid #ccc;
				background-color: #fff;
				color: #3c3a3a;
				font-weight: 400;
			}
			.blank_line{
				margin: 5px 0;
				height: 0;
				width: 0;
			}
			.hr_line{
				margin: 10px 0px;
				height: 0;
				border-top: 1px solid #ddd;
			}
			ul {
				list-style-type: circle;
				color: #383636;
				list-style-position: outside;
				padding-left: 20px;
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
			font-size: 25px;
			padding: 5px;
			color: white;
			padding-bottom: 8px;
			margin-bottom: 10px;
			text-align: center;
			background-color: #133f6d;
		}
		.serviceTitle{
			font-size: 16px;
			padding-bottom: 5px;
			line-height: 20px;
			color: #133f6d;
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
			background-color: #133f6d;
			color: #ffffff;
			text-align: left;
		}
		img{
			margin-top: 1px;
		}
		.table-service img{
			margin-top: 8px;
		}
		.table-service.transfer img,
		.table-service.hotel img,
		.table-service.train img,
		.table-service.flight img{
			margin-top: 12px;
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
		.text-center{
			text-align: center!important;
		}
		.valignBottom{
		}
		</style>
	</head>
	<body >
		<div class="calcostsheet">
			
			<h1 style="text-align:left; position:relative;">Cost&nbsp;Sheet&nbsp;|&nbsp;DB000749-A<a href="loadFITCostSheet.php?export=yes&quotationId=&finalcategory=" style="position:absolute; right:3px; top:2px;">
				<input name="Cancel" type="button" class="whitembutton"  value="Export"  style="background-color: #fff !important; padding: 4px 20px;"></a>
				</h1>
				<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">
					<tr>
						<td width="10%" align="left" valign="middle"><strong>Tour Id : </strong></td>
						<td align="left" valign="middle">22/08/0023/SK</td>
						<td width="10%" align="left" valign="middle"><strong>Operation Person </strong></td>
						<td align="left" valign="middle">Mohd Adnan</td>
					</tr>
					<tr>
						<td align="left" valign="middle"><strong>Arrival Date :</strong></td>
						<td align="left" valign="middle">1 August, 2022</td>
						<td align="left" valign="middle"><strong>Sales Person </strong></td>
						<td align="left" valign="middle">Samay khan</td>
					</tr>
					<tr>
						<td align="left" valign="middle"><strong>Agent Name: </strong></td>
						<td align="left" valign="middle">Praveen Kumar Sharma</td>
						<td align="left" valign="middle"><strong>R.O.E:</strong></td>
						<td align="left" valign="middle">INR&nbsp;1&nbsp;As&nbsp;on:&nbsp;
						04-10-2021    </td>
					</tr>
					<tr>
						<td align="left" valign="middle"><strong>Lead Pax Name </strong></td>
						<td align="left" valign="middle">Mrs. Sinha</td>
						<td align="left" valign="middle"><strong>Printed On:</strong></td>
						<td align="left" valign="middle">26-02-2022 02:56 PM</td>
					</tr>
				</table>
				
				<div style="padding-top:10px; margin-top:10px; border-top:1px solid #ccc;">
					<!-- Cost sheet service list -->
					<div style="text-align:center;font-size: 18px;margin-bottom:10px;"><strong>Cost Sheet Detail</strong></div>
					<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000" style="font-size:12px;">
						<tr>
							<td width="45" align="left" bgcolor="#F5F5F5"><strong>Day/Date</strong></td>
							<td align="left" bgcolor="#F5F5F5"><strong>City </strong></td>
							<td width="93" align="left" bgcolor="#F5F5F5"><strong>Hotels</strong></td>
							<td colspan="7" align="center" bgcolor="#F5F5F5"><strong>Hotel Rates</strong></td>
							<td width="104" align="center" bgcolor="#F5F5F5"><strong></strong></td>
							<td width="48" align="center" bgcolor="#F5F5F5"><strong></strong></td>
							<td width="48" colspan="2" align="center" bgcolor="#F5F5F5"><strong>Flight</strong></td>
							<td width="48"  colspan="2" align="center" bgcolor="#F5F5F5"><strong>Train</strong></td>
							<td width="48"  colspan="2" align="center" bgcolor="#F5F5F5"><strong>Monuments</strong></td>
							<td align="center" bgcolor="#F5F5F5" colspan="8"> <strong>Per Person</strong></td>
						</tr>
						<tr>
							<td width="118" align="left" bgcolor="#F5F5F5">&nbsp;</td>
							<td width="94" align="left" bgcolor="#F5F5F5">&nbsp;</td>
							<td align="left" bgcolor="#F5F5F5">&nbsp;</td>
							<td width="32" align="right" bgcolor="#F5F5F5"><strong>SGL</strong></td>
							<td width="32" align="right" bgcolor="#F5F5F5"><strong>DBL</strong></td>
							<td width="40" align="right" bgcolor="#F5F5F5"><strong>E.Bed(A)</strong></td>
							<td width="40" align="right" bgcolor="#F5F5F5"><strong>E.Bed(C)</strong></td>
							<td width="24" align="right" bgcolor="#F5F5F5">B</td>
							<td width="24" align="right" bgcolor="#F5F5F5"><strong>L</strong></td>
							<td width="24" align="right" bgcolor="#F5F5F5"><strong>D</strong></td>
							<td align="right" bgcolor="#F5F5F5"><strong>Transport</strong></td>
							<td align="right" bgcolor="#F5F5F5"><strong>Guide</strong></td>
							<!-- below flight cols -->
							<td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
							<td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
							<!-- Below Train cols -->
							<td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
							<td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
							<!-- Below Monuments cols-->
							<td width="43" align="right" bgcolor="#F5F5F5"><strong>Adult</strong></td>
							<td width="43" align="right" bgcolor="#F5F5F5"><strong>Child</strong></td>
							<td width="44" align="right" bgcolor="#F5F5F5"><strong>Porter</strong></td>
							<td width="52" align="right" bgcolor="#F5F5F5"><strong>Activity</strong></td>
							<td width="55" align="right" bgcolor="#F5F5F5"><strong>Enroute</strong></td>
							<td width="75" align="right" bgcolor="#F5F5F5"><strong>Restaurant</strong></td>
							<td width="82" align="right" bgcolor="#F5F5F5"><strong>Additional</strong></td>
						</tr>
						<tr>
							<td width="118" align="left">D01 - 01-08-2022    </td>
							<td width="94" align="left">
								Delhi
							</td>
							<td align="left">Guest:-1 Hyaat    </td>
							<td align="right">1000.00</td>
							<td align="right">1500.00</td>
							<td align="right">800.00</td>
							<td align="right">600.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">
							17024.00    </td>
							<td align="right">0.00    </td>
							
							<td align="right" >0.00    </td>
							<td align="right" >0.00    </td>
							<td align="right" >7000.00    </td>
							<td align="right" >3000.00    </td>
							<td align="right" >0.00
							</td>
							<td align="right" >0.00
							</td>
							<td align="right" >0.00    </td>
							<td align="right" >0.00
							</td>
							<td align="right">0.00    </td>
							<td align="right">0.00    </td>
							<td align="right" >0.00    </td>
						</tr>
						<tr>
							<td width="118" align="left"></td>
							<td width="94" align="left"></td>
							<td align="left">Guest&nbsp;Early&nbsp;Arrival:-&nbsp;Adithya&nbsp;Nature&nbsp;Resort&nbsp;&&nbsp;Spa        </td>
							<td align="right">3920.00</td>
							<td align="right">3920.00</td>
							<td align="right">1120.00</td>
							<td align="right">840.00</td>
							<td align="right">500.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right"></td>
							<td align="right"></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
						</tr>
						
						<tr>
							<td width="118" align="left"></td>
							<td width="94" align="left"></td>
							<td align="left">Local&nbsp;Escort:-&nbsp;Adithya&nbsp;Nature&nbsp;Resort&nbsp;&&nbsp;Spa        </td>
							<td align="right">3920.00</td>
							<td align="right">3920.00</td>
							<td align="right">1120.00</td>
							<td align="right"></td>
							<td align="right">530.00</td>
							<td align="right">560.00</td>
							<td align="right">560.00</td>
							<td align="right"></td>
							
							<td align="right"></td>
							<td align="right" >0.00        </td>
							<td align="right" ></td>
							<td align="right" >0.00        </td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
							<td align="right" ></td>
						</tr>
						<tr>
							<td width="118" align="left">D02 - 02-08-2022    </td>
							<td width="94" align="left">
								Agra
							</td>
							<td align="left">    </td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">0.00</td>
							<td align="right">
							0.00    </td>
							<td align="right">0.00    </td>
							
							<td align="right" >5000.00    </td>
							<td align="right" >3000.00    </td>
							<td align="right" >0.00    </td>
							<td align="right" >0.00    </td>
							<td align="right" >0.00
							</td>
							<td align="right" >0.00
							</td>
							<td align="right" >0.00    </td>
							<td align="right" >0.00
							</td>
							<td align="right">0.00    </td>
							<td align="right">0.00    </td>
							<td align="right" >0.00    </td>
						</tr>
						
						
						<tr>
							<td colspan="3" align="right" bgcolor="#deb887"><strong>Total</strong></td>
							<td align="right" bgcolor="#deb887"><strong>4920.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>5420.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>1920.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>1440.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>500.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>17024.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							
							<td align="right" bgcolor="#deb887"><strong>5000.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>3000.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>7000.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>3000.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
							<td align="right" bgcolor="#deb887"><strong>0.00</strong></td>
						</tr>
						<tr>
							<td colspan="3" align="right" bgcolor="#dec7c7"><strong>Local Escort Total</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>3920.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>3920.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>1120.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>530.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>560.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>560.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>0.00</strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></td>
							<td align="right" bgcolor="#dec7c7"><strong>0.00</strong></td>
							<td align="right" bgcolor="#dec7c7"></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
							<td align="right" bgcolor="#dec7c7"><strong></strong></td>
						</tr>
					</table>
					<!-- START PER PAX BLOCK -->
					<table width="100%" cellpadding="0" cellspacing="0" >
						<tr>
							<td valign="top" width="40%">
								<div style="text-align:center;font-size: 18px;margin: 15px 0;"><strong>Per Pax Cost</strong></div>
								<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PARTICULARS</strong></td>
										<td align="center" colspan="2" bgcolor="#F5F5F5"><strong>1-9&nbsp;PAX( D.F-8)</strong></td>
										<td align="center" colspan="2" bgcolor="#F5F5F5"><strong>ESCORTS</strong></td>
									</tr>
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong></strong></td>
										<td align="center" bgcolor="#deb887" ><strong>ADULT&nbsp;COST</strong></td>
										<td align="center" bgcolor="#deb887" ><strong>CHILD&nbsp;COST</strong></td>
										<td align="center" bgcolor="#dec7c7"><strong>LOCAL</strong></td>
										<td align="center" bgcolor="#d4d5f0"><strong>FORIEGN</strong></td>
									</tr>
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>MEAL+B+L+D</strong></td>
										<td align="right" bgcolor="#deb887" >500.00</td>
										<td align="right" bgcolor="#deb887" >500.00</td>
										<td align="right" bgcolor="#dec7c7">412.50</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRAIN</strong></td>
										<td align="right" bgcolor="#deb887" >7000.00</td>
										<td align="right" bgcolor="#deb887" >3000.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>FLIGHT</strong></td>
										<td align="right"  bgcolor="#deb887" >5000.00
										</td>
										<td align="right"  bgcolor="#deb887" >3000.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>TRANSPORT</strong></td>
										<td align="right" bgcolor="#deb887" >2128.00</td>
										<td align="right" bgcolor="#deb887" >2128.00</td>
										<td align="right" bgcolor="#dec7c7">532.00</td>
										<td align="right" bgcolor="#d4d5f0">532.00</td>
									</tr>
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>GUIDE</strong></td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>PORTER</strong></td>
										<td align="right" bgcolor="#deb887" >0.00        </td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>MONUMENTS</strong></td>
										<td align="right" bgcolor="#deb887" >0.00        </td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ENROUTES</strong></td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ACTIVITIES</strong></td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5"><strong>ADDITIONALS</strong></td>
										<td align="right" bgcolor="#deb887" >0.00        </td>
										<td align="right" bgcolor="#deb887" >0.00</td>
										<td align="right" bgcolor="#dec7c7">0.00</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									<tr height="18">
										<td height="18" colspan="2" align="right" bgcolor="#F5F5F5">
											<strong>TOTAL COST (&nbsp;INR&nbsp;)</strong>
										</td>
										<td align="right" bgcolor="#deb887" >14628.00</td>
										<td align="right" bgcolor="#deb887" >8628.00</td>
										<td align="right" bgcolor="#dec7c7">944.50</td>
										<td align="right" bgcolor="#d4d5f0">532.00</td>
									</tr>
								</table>
								<br>
								<strong style="font-size:12px;text-transform: uppercase;">Per Pax Cost</strong>
								<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
									<tr>
										<td align="left" bgcolor="#F5F5F5" ><strong>Occupancy</strong></td>
										<td align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost</strong></td>
									</tr>
									<tr>
										<td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Single&nbsp;Basis</td>
										<td align="right" >20525.40</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;Double&nbsp;Basis</td>
										<td align="right" >18204.90</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#F5F5F5" >Per&nbsp;Child&nbsp;Cost&nbsp;On&nbsp;ExtraBed(Child)&nbsp;Basis</td>
										<td align="right" >10571.40</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#F5F5F5" >Per&nbsp;Person&nbsp;Cost&nbsp;On&nbsp;ExtraBed(Adult)&nbsp;Basis</td>
										<td align="right" >17375.40</td>
									</tr>
								</table>
							</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								<div style="text-align:center;font-size: 18px;margin: 15px 0;"><strong>Total Tour Cost</strong></div>
								<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
									<tr>
										<td align="center" bgcolor="#F5F5F5"><strong>Itinerary&nbsp;Services</strong></td>
										<td align="center" bgcolor="#F5F5F5"><strong>Unit&nbsp;Cost</strong></td>
										<td align="center" bgcolor="#F5F5F5"><strong>Volume&nbsp;Type</strong></td>
										<td align="center" bgcolor="#F5F5F5"><strong>Qty&nbsp;Total</strong></td>
										<td align="center" bgcolor="#F5F5F5"><strong>Total&nbsp;Cost</strong></td>
									</tr>
									<tr >
										<td align="left" bgcolor="#deb887"><strong>Single&nbsp;Room</strong></td>
										<td align="right" bgcolor="#deb887">4920.00</td>
										<td align="center" bgcolor="#deb887">Room</td>
										<td align="right" bgcolor="#deb887">1</td>
										<td align="right" bgcolor="#deb887">4920.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#deb887"><strong>Double&nbsp;Room</strong></td>
										<td align="right" bgcolor="#deb887">5420.00</td>
										<td align="center" bgcolor="#deb887">Room</td>
										<td align="right" bgcolor="#deb887">1</td>
										<td align="right" bgcolor="#deb887">5420.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#deb887"><strong>Twin&nbsp;Room</strong></td>
										<td align="right" bgcolor="#deb887">5420.00</td>
										<td align="center" bgcolor="#deb887">Room</td>
										<td align="right" bgcolor="#deb887">1</td>
										<td align="right" bgcolor="#deb887">5420.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#deb887"><strong>Tipple&nbsp;Room</strong></td>
										<td align="right" bgcolor="#deb887">7340.00</td>
										<td align="center" bgcolor="#deb887">Room</td>
										<td align="right" bgcolor="#deb887">1</td>
										<td align="right" bgcolor="#deb887">7340.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#deb887"><strong>Extra&nbsp;Bed(&nbsp;Child&nbsp;)</strong></td>
										<td align="right" bgcolor="#deb887">1440.00</td>
										<td align="center" bgcolor="#deb887">Room</td>
										<td align="right" bgcolor="#deb887">1</td>
										<td align="right" bgcolor="#deb887">1440.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#deb887"><strong>Monuments(Adult)</strong></td>
										<td align="right" bgcolor="#deb887">14628.00</td>
										<td align="center" bgcolor="#deb887">Pax</td>
										<td align="right" bgcolor="#deb887">8</td>
										<td align="right" bgcolor="#deb887">117024.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#deb887"><strong>Monuments(Child)</strong></td>
										<td align="right" bgcolor="#deb887">8628.00</td>
										<td align="center" bgcolor="#deb887">Pax</td>
										<td align="right" bgcolor="#deb887">1</td>
										<td align="right" bgcolor="#deb887">8628.00</td>
									</tr>
									<tr>
										<td align="left" colspan="4" ><strong>Escort</strong><hr style="float:right;width: 88%;"></td>
										<td align="left" ></td>
									</tr>
									<tr>
										<td align="left" bgcolor="#dec7c7"><strong>Single&nbsp;Room(Local)</strong></td>
										<td align="right" bgcolor="#dec7c7">980.00</td>
										<td align="center" bgcolor="#dec7c7">Room</td>
										<td align="right" bgcolor="#dec7c7">1</td>
										<td align="right" bgcolor="#dec7c7">980.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#d4d5f0"><strong>Single&nbsp;Room(Foriegn)</strong></td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
										<td align="center" bgcolor="#d4d5f0">Room</td>
										<td align="right" bgcolor="#d4d5f0">1</td>
										<td align="right" bgcolor="#d4d5f0">0.00</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#dec7c7"><strong>Monuments(Local)</strong></td>
										<td align="right" bgcolor="#dec7c7">944.50</td>
										<td align="center" bgcolor="#dec7c7">Pax</td>
										<td align="right" bgcolor="#dec7c7">1</td>
										<td align="right" bgcolor="#dec7c7">944.50</td>
									</tr>
									<tr>
										<td align="left" bgcolor="#d4d5f0"><strong>Monuments(Foriegn)</strong></td>
										<td align="right" bgcolor="#d4d5f0">532.00</td>
										<td align="center"bgcolor="#d4d5f0">Pax</td>
										<td align="right" bgcolor="#d4d5f0">1</td>
										<td align="right" bgcolor="#d4d5f0">532.00</td>
									</tr>
									<tr>
										<td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Cost&nbsp;of the Trip (INR) </strong></td>
										<td align="right" >152648.50
										</td>
									</tr>
									
									<tr>
										<td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>(+) MarkUp (5%)</strong></td>
										<td align="right" >7632.43</td>
									</tr>
									<tr>
										<td colspan="4" align="right" bgcolor="#F5F5F5" ><strong>Total&nbsp;Cost With Markup (INR)</strong></td>
										<td align="right" >160280.93</td>
									</tr>
									
								</table>
							</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								<div style="text-align:center;font-size: 18px;margin: 15px 0;"><strong>Genral Info.</strong></div>
								<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Adult&nbsp;Pax</strong></td>
										<td align="right" >8</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Child&nbsp;Pax</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Local&nbsp;Escort&nbsp;Pax</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Foreign&nbsp;Escort&nbsp;Pax</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" colspan="2" bgcolor="#F5F5F5" ></td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Single&nbsp;Room</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Double&nbsp;Room</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Triple&nbsp;Room</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Twin&nbsp;Room</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>E.Bed(C)</strong></td>
										<td align="right" >1</td>
									</tr>
									<tr>
										<td align="right" colspan="2" bgcolor="#F5F5F5" ></td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>
										MarkUp(%)        </strong></td>
										<td align="right" >5</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>
										Discount(%)        </strong></td>
										<td align="right" >0</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>
										GST(%)        </strong></td>
										<td align="right" >0</td>
									</tr>
								</table>
								<hr>
								<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
									<tr>
										<td align="right" bgcolor="#F5F5F5" ><strong>Client&nbsp;Cost(In INR)</strong></td>
										<td align="right" >160280.93</td>
									</tr>
									
								</table>
							</td>
						</tr>
					</table>
					<!-- END PER PAX BLOCK AND TOTAL TOUR COST BLOCK -->
					<br>
					<!-- START PER PAX BLOCK -->
					<table width="100%" cellpadding="0" cellspacing="0" >
						<tr>
							<td valign="top" width="40%">
								<!-- <div style="text-align:center;font-size: 18px;margin: 15px 0;"><strong>Break-up&nbsp;Cost</strong></div> -->
								<table border="0" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
									<tr>
										<td align="left" width="50%" >
											<strong style="font-size:12px;text-transform: uppercase;">Transport Break-up Cost</strong>
											<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
												<tr>
													<td align="left" bgcolor="#F5F5F5" width="10%" ><strong>Date</strong></td>
													<td align="left" bgcolor="#F5F5F5" width="10%" ><strong>City</strong></td>
													<td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
													<td align="right" bgcolor="#F5F5F5" width="15%" ><strong>Service&nbsp;Cost(In INR)</strong></td>
												</tr>
												<tr>
													<td align="left" bgcolor="#F5F5F5" >01-08-2022</td>
													<td align="left" bgcolor="#F5F5F5" >Delhi</td>
													<td align="left" bgcolor="#F5F5F5" >delhi transport | Toyota (Innova) for 1 Vehicle</td>
													<td align="right" >17024.00</td>
												</tr>
												<tr>
													<td align="right" bgcolor="#F5F5F5" colspan="3">Total Transport Cost</td>
													<td align="right" >17024.00</td>
												</tr>
											</table>
											<br>
										<!--  </td>
										<td align="left" valign="top"  > -->
											<strong style="font-size:12px;text-transform: uppercase;">Train Break-up Cost</strong>
											<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
												<tr>
													<td align="left" bgcolor="#F5F5F5" width="10%" ><strong>Date</strong></td>
													<td align="left" bgcolor="#F5F5F5" width="10%" ><strong>City</strong></td>
													<td align="left" bgcolor="#F5F5F5" ><strong>Service&nbsp;Name</strong></td>
													<td align="right" bgcolor="#F5F5F5" width="15%" ><strong>Adult&nbsp;Cost(In INR)</strong></td>
													<td align="right" bgcolor="#F5F5F5" width="15%" ><strong>Child&nbsp;Cost(In INR)</strong></td>
												</tr>
												<tr>
													<td align="left" bgcolor="#F5F5F5" >01-08-2022</td>
													<td align="left" bgcolor="#F5F5F5" >Delhi</td>
													<td align="left" bgcolor="#F5F5F5" >Akash train</td>
													<td align="right" >7000.00</td>
													<td align="right" >3000.00</td>
												</tr>
												<tr>
													<td align="right" bgcolor="#F5F5F5" colspan="3">Total Train Cost </td>
													<td align="right" >7000.00</td>
													<td align="right" >3000.00</td>
												</tr>
											</table>
											<br>
											
											<strong style="font-size:12px;text-transform: uppercase;">Flight Break-up Cost</strong>
											<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000"  style="font-size:12px;">
												<tr>
													<td align="left" bgcolor="#F5F5F5" width="10%" ><strong>Date</strong></td>
													<td align="left" bgcolor="#F5F5F5" width="10%" ><strong>City</strong></td>
													<td align="left" bgcolor="#F5F5F5" ><strong>Service Name</strong></td>
													<td align="right" bgcolor="#F5F5F5" width="15%" ><strong>Adult&nbsp;Cost(In INR)</strong></td>
													<td align="right" bgcolor="#F5F5F5" width="15%" ><strong>Child&nbsp;Cost(In INR)</strong></td>
												</tr>
												<tr>
													<td align="left" bgcolor="#F5F5F5" >02-08-2022</td>
													<td align="left" bgcolor="#F5F5F5" >Agra</td>
													<td align="left" bgcolor="#F5F5F5" >Air India Express</td>
													<td align="right" >5000.00</td>
													<td align="right" >3000.00</td>
												</tr>
												<tr>
													<td align="right" bgcolor="#F5F5F5" colspan="3">Total Flight Cost</td>
													<td align="right" >5000.00</td>
													<td align="right" >3000.00</td>
												</tr>
											</table>
											<br>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<div style="overflow:hidden; margin-top:20px;">
						<table border="0" align="right" cellpadding="5" cellspacing="0">
							<tbody><tr>
								<td>
									<input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Close" onclick="alertspopupopenClose();">
								</td>
								
							</tr>
						</tbody></table></div>
					</div>
				</div>
				<footer>
					<table align="center" ><tr>
						<td valign="bottom"></td>
						<td valign="top"><a href="mailto:" target="_blank" ></a></td>
						<td valign="bottom"></td>
						<td valign="bottom"><a href="" target="_blank" ></a></td></tr>
					</table>
				</footer>
				<div class="main-container">
					<table class="firstpage" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
						<tbody>
							<tr>
								<td align="center" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/dirfiles/1644228596debox-proposal-logo.jpg" width="100%" ><div class="hr_line"></div></td>
							</tr>
							<tr>
								<td align="center" style="padding: 20px 0;font-size:22px;text-align:center;">
									<strong>Mrs. Sinha</strong>
								</td>
							</tr>
							<tr>
								<td align="center"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/sample-proposal.jpg" width="100%" height="500" style="width: 100%;">
								</td>
							</tr>
						</tbody>
					</table>
					<br />
					<table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:14px">
						<tbody>
							<tr>
								<td width="50%" align="right" style="color:#FF9900;"><div align="right"><strong>DESTINATION COVERED</strong></div></td>
								<td width="50%" align="left" style="color:#000; border-left:1px solid #ddd;"><strong>Delhi, Agra</strong>
								</td>
							</tr>
							<tr>
								<td width="50%" align="right" style="color:#FF9900;"><div align="right"><strong>DURATION</strong></div></td>
								<td width="50%" align="left" style="color:#000;border-left:1px solid #ddd;"><strong>1 Nights / 2 Days</strong></td>
							</tr>
							<tr>
								<td width="50%" align="right" style="color:#FF9900;"><div align="right"><strong>TRAVELLERS</strong></div></td>
								<td width="50%" align="left" style="color:#000;border-left:1px solid #ddd;"><strong>9 Adults / </strong></td>
							</tr>
						</tbody>
					</table>
					<br />
					<table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size:14px;">
						<tbody>
							<tr>
								<td align="center" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/location-package.png" width="60" height="60"></td>
							</tr>
							<tr>
								<td align="center" valign="top" style="font-size:14px;"><span>Delhi</span>
								<img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/right-location.png" height="13" width="13" />
								<span>Agra</span>
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
				
				<!--day num ,  title and description -->
				<br />
				<br />
				<table width="100%" border="0" cellpadding="0" cellspacing="0"  >
					<tbody>
						<tr class="row-titleDesc">
							<td align="left" valign="top">
								<div class="dayTitle"> Day 1 - Delhi | Monday 01-08-2022</div>
								<div class="hr_line"></div>
							</td>
						</tr>
						<tr class="row-titleDesc">
							<td align="left" valign="top">
								<strong class="serviceTitle"></strong>
							</td>
						</tr>
					</tbody>
				</table>
				<br />
				<br />
				
				<div class="serviceDesc"></div>
				<div class="hr_line"></div>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service train">
					<tbody><tr class="row-service">
						<td width="20%" align="left" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/train.jpg" width="130" height="80" />
						</td>
						<td width="80%" align="left" valign="top" >
							<table width="100%" border="0" cellpadding="4" cellspacing="0" >
								<tr>
									<td colspan="5" ><div class="serviceTitle">Guest Train Akash train</div></td>
								</tr>
								<tr>
									<td width="15%" ><strong>Journey&nbsp;Type</strong></td>
									<td width="20%" ><strong>TrainNumber</strong></td>
									<td width="15%" ><strong>TrainClass</strong></td>
									<td width="25%" ><strong>Dept-Arr</strong></td>
									<td width="25%" ><strong>Dept-Arr&nbsp;Time</strong></td>
								</tr>
								<tr>
									<td width="15%" >Day</td>
									<td width="20%" >FFF3D35FG</td>
									<td width="15%" >AC 2-Tier</td>
									<td width="25%" >Delhi-Agra</td>
									<td width="25%" >/@1210/-1400 Hrs</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="hr_line"></div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service hotel">
				<tbody><tr class="row-service">
					<td width="20%" align="left" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/hotelthumbpackage.png" width="130" height="80"></td>
					<td width="80%" align="left" valign="top" >
						<table width="100%" border="0" cellpadding="4" cellspacing="0" >
							<tbody>
								<tr>
									<td colspan="3"><strong class="serviceTitle">Local Escort Hotel | Adithya Nature Resort & Spa</strong></td>
								</tr>
								<tr>
									<td width="15%" ><strong>Category</strong></td>
									<td width="35%" ><strong>Room Type</strong></td>
									<td width="25%" ><strong>Meal Plan</strong></td>
								</tr>
								<tr>
									<td width="15%"  >7	 Star
									</td>
									<td width="35%">Ruby Villa</td>
									<td width="25%">CP</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="hr_line"></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service hotel">
			<tbody><tr class="row-service">
				<td width="20%" align="left" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/hotelthumbpackage.png" width="130" height="80"></td>
				<td width="80%" align="left" valign="top" >
					<table width="100%" border="0" cellpadding="4" cellspacing="0" >
						<tbody>
							<tr>
								<td colspan="3"><strong class="serviceTitle">Guest Hotel | 1 Hyaat</strong></td>
							</tr>
							<tr>
								<td width="15%" ><strong>Category</strong></td>
								<td width="35%" ><strong>Room Type</strong></td>
								<td width="25%" ><strong>Meal Plan</strong></td>
							</tr>
							<tr>
								<td width="15%"  >5	 Star
								</td>
								<td width="35%">Standard Room</td>
								<td width="25%">CP</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="hr_line"></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service transfer">
		<tbody><tr class="row-service">
			<td width="20%" align="left" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/transfer.jpeg" width="130" height="80" />
			</td>
			<td width="80%" align="left" valign="top" >
				<table width="100%" border="0" cellpadding="4" cellspacing="0" >
					<tr>
						<td colspan="3" align="left" >
							<strong class="serviceTitle">Delhi transport</strong>
						</td>
					</tr>
					<tr>
						<td align="left" width="15%" >Type</td>
						<td align="left" width="35%" >VehicleName</td>
						<td align="left" width="35%" >VehicleType</td>
						<!--  <td align="left" width="25%" >Maxpax</td> -->
					</tr>
					<tr>
						<td align="left" width="15%" >Private</td>
						<td align="left" width="35%" >Innova </td>
						<td align="left" width="35%" >SUV - Crysta</td>
						<!--  <td align="left" width="25%" >0 </td> -->
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<!--day num ,  title and description -->
<br />
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0"  >
	<tbody>
		<tr class="row-titleDesc">
			<td align="left" valign="top">
				<div class="dayTitle"> Day 2 - Agra | Tuesday 02-08-2022</div>
				<div class="hr_line"></div>
			</td>
		</tr>
		<tr class="row-titleDesc">
			<td align="left" valign="top">
				<strong class="serviceTitle"></strong>
			</td>
		</tr>
	</tbody>
</table>
<br />
<br />

<div class="serviceDesc"></div>
<div class="hr_line"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-service flight">
	<tbody><tr class="row-service">
		<td width="20%" align="left" valign="top"><img src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev/images/flight.jpg" width="130" height="80" />
		</td>
		<td width="80%" align="left" valign="top" >
			<table width="100%" border="0" cellpadding="4" cellspacing="0" >
				<tr>
					<td colspan="4" ><strong class="serviceTitle">Guest Flight Air India Express</strong></td>
				</tr>
				<tr>
					<td width="20%"><strong>FlightNumber</strong></td>
					<td width="20%"><strong>FlightClass</strong></td>
					<td width="30%"><strong>Departure-Arrival</strong></td>
					<td width="30%"><strong>Departure-Arrival Time</strong></td>
				</tr>
				<tr>
					<td width="20%">QF1500</td>
					<td width="20%">First_Class</td>
					<td width="30%">Delhi-Delhi</td>
					<td width="30%">@1205-1225 Hrs</td>
				</tr>
			</table>
		</td>
	</tr>
</tbody>
</table>
<br />
<br />
<table align="center" ><tr>
<td valign="bottom">**************</td>
<td valign="top"><div class="serviceDesc text-center" >END OF THE TOUR</div></td>
<td valign="bottom">**************</td></tr>
</table>
<br /><br />
<div class="table-service" >
<div class="serviceTitle">Hotels Proposed</div>
<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service">
	<tr>
		<th width="20%" align="left" valign="middle" ><strong>Dates</strong></th>
		<th width="12%" align="left" valign="middle" ><strong>City</strong></th>
		<th width="27%" align="left" valign="middle" ><strong>Hotel</strong></th>
		<th width="16%" align="left" valign="middle" ><strong>Room Type</strong></th>
		<th width="25%" align="left" valign="middle" ><strong>Remarks</strong></th>
	</tr>
	
	<tr>
		<td valign="middle">
		31 Jul 2022						</td>
		<td valign="middle">Delhi</td>
		<td valign="middle">Guest Hotel- Adithya Nature Resort & Spa</td>
		<td valign="middle">Ruby Villa</td>
		<td valign="middle"></td>
	</tr>
	
	<tr>
		<td valign="middle">
		1 Aug 2022						</td>
		<td valign="middle">Delhi</td>
		<td valign="middle">Local Escort Hotel- Adithya Nature Resort & Spa</td>
		<td valign="middle">Ruby Villa</td>
		<td valign="middle"></td>
	</tr>
	
	<tr>
		<td valign="middle">
		1 Aug 2022						</td>
		<td valign="middle">Delhi</td>
		<td valign="middle">Guest Hotel- 1 Hyaat</td>
		<td valign="middle">Standard Room</td>
		<td valign="middle"></td>
	</tr>
</table>
</div>
<!-- Total Tour Cost and per person basis costs details -->
<br />
<br />
<div class="table-service" >
<div class="serviceTitle">QUOTATION</div>
<table border="1" cellpadding="5" cellspacing="0" borderColor="#ccc" class="borderedTable table-service" >
	<tr>
		<th width="20%" align="right" rowspan="2" valign="middle"><strong>Total Cost(In INR)</strong></th>
		<th width="80%" colspan="4" align="center" valign="middle"><strong>Per Person Cost(In INR)</strong></th>
	</tr>
	<tr>
		<th width="20%" valign="middle"><div align="right"><strong>Single Basis</strong></div></th>
		<th width="20%" valign="middle"><div align="right"><strong>Double Basis</strong></div></th>
		<th width="20%" valign="middle"><div align="right"><strong>ExtraBed(Adult) Basis</strong></div></th>
		<th width="20%" valign="middle"><div align="right"><strong>ExtraBed(child) Basis</strong></div></th>
	</tr>
	
	<tr>
		<td valign="middle"><div align="right">
		160280.93				</div></td>
		<td valign="middle">
			<div align="right">
			20525.40					</div>
		</td>
		<td valign="middle">
			<div align="right">
			18204.90					</div>
		</td>
		<td valign="middle">
			<div align="right">
			17375.40					</div>
		</td>
		<td valign="middle">
			<div align="right">
			10571.40					</div>
		</td>
	</tr>
</table>
</div>
<br />

<table border="0" cellpadding="4" cellspacing="0"  width="100%" style="font-size:12px" >
<tr >
	<td align="left" valign="middle" class="table-service" ><div class="serviceTitle"><u>INCLUSIONS</u></div><ul>
	<li>Well appointed A/c room Accommodation in above mentioned hotels.</li>
	<li>A/c Vehicle for all transfer &amp; Sightseeing at all the places/islands but not at disposal basis(Only Point to Point Service).</li>
	<li>Meals plan as mentioned above.</li>
	<li>All entry permits, entry tickets (Except Ross &amp; North bay Island) included to all sight-seeing points, inter island ferry tickets and forest area permits wherever applicable.</li>
	<li>Private Cruise tickets in Green Ocean in Deluxe class (Base category) from Port Blair - Havelock Island.</li>
	<li>Private Cruise tickets in Green Ocean / Makruzz in Deluxe/Premium class (Base category) respectively from Havelock Island &ndash; Port Blair.</li>
	<li>Private Cruise tickets in Green Ocean / Makruzz in Deluxe/Premium class (Base category) respectively from Havelock Island &ndash; Neil &ndash; Port Blair.</li>
	<li>GST included.</li>
</ul></td>
</tr>
<tr >
<td align="left" valign="middle" class="table-service" ><div class="serviceTitle"><u>EXCLUSIONS:</u></div><ul>
<li>Any meals other than those mentioned above.</li>
<li>Any Airfare.</li>
<li>Tour guide services at any sightseeing place.</li>
<li>Entrance fees of Rs. 30 per person at Ross Island and Rs. 10 per person at North Bay island to be paid directly.</li>
<li>All Water sport activities like Snorkling, Scuba diving, Glass Bottom ride, Sea Walking Etc... Etc...</li>
<li>Any portage at airports and hotels, tips, insurance, wine, mineral water, telephone charges, and all items of personal nature.</li>
<li>Any services not specifically mentioned in the inclusions.</li>
<li>Expenses caused by factors beyond our control like flight delays, cancellation of Ferry operation, bad weather, vehicle malfunctions, political disturbances etc.</li>
</ul></td>
</tr>
</table>
</div>
<div style="position: absolute;bottom: 0;left: 0; right: 0;height: 656;width:100%;page-break-before: always;"  ><img width="100%" alt="Thank You" src="http://localhost/FD_Branche1.5/TravCRMInBound/travcrm-dev//images/thanksyou-debox.jpeg" /></div>
</body>
</html