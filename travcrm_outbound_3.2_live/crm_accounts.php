<style>
		.dataTables_wrapper .dataTables_filter {
		float: left;
		top: -43px;
		position: absolute;
	}
	.dataTables_wrapper .dataTables_info {
		padding: 15px!important;
	}
	.dataTables_wrapper .dataTables_length {
		padding: 10px!important;
	}
	.dataTables_wrapper .dataTables_paginate {
		padding: 10px!important;
	}
	.dataTables_wrapper  .dt-buttons{
		position: absolute;
		top: -42px;
		left: 30%;
		z-index: 9;
	}
	
	.dataTables_wrapper .dt-buttons .dt-button{
		background-color: #f9f9f9;
		border: 1px solid #ccc;
		border-radius: 20px;
		padding: 8px 20px;
		cursor:pointer;
	}
	.dataTables_filter label{
	margin-left: 15px;
	}
	.dataTables_wrapper .dataTables_filter input {
		border: 1px solid #e2dcdc!important;
		border-radius: 16px!important;
		padding: 8px!important;
		min-width: 250px;
	}
	.gridtable .header{
		padding: 15px;
	}
	#example_filter {
		position: absolute;
		top: -44px;
		left: 0%;
	}
	
	#example_filter label {
		font-size: 18px;
	}
	
	#example_filter input {
		height: 34px;
		width: 306px;
		border-radius: 42px;
	}
	.makeclass{
		position: relative;
		top: auto;
		right: auto;
		bottom: auto;
		left: auto;
		padding: 7px;
		border-radius: 42px;
		border: 1px solid #ccc;
		cursor: pointer;
		text-align: center;
	}
	.h1:hover{
	background-color:#4caf50;
	color:#fff;
	}
	.selected{ background-color:#64aefb; color:#fff; }
	
.cmsouter{
text-align:center;
}
.cmsouter .iconbox {
		display: inline-block;
		text-align: center;
		padding: 5px 10px;
		min-width: 130px;
		width: 8%;
		border: 1px #dddddd59 solid;
		border-radius: 3px;
		background-color: #ffffff;
		box-shadow: 1px 1px 6px #e6e6e694;
		color: white;
	}
.cmsouter .iconbox img{
height: 60px;
padding: 10px 0;
float: left;
}
.container_box .rightBox .rightsectionheader {
background-color: #f8f8f8;
border-bottom: 1px solid #eee;
padding: 15px 25px 15px 36px!important;
font-weight: 500;
color: #333333;
font-size: 22px;
margin-top: 0;
position: relative!important;
width: auto;
z-index: 999;
}
.container_box #pagelisterouter .addeditpagebox{
padding: 0px!important;
}
.container_box .rightBox .headingm {
text-align: left!important;
margin: 0!important;
padding:0!important;
}
.container_box .rightBox #topheadingmain a img{
margin-right: 15px!important;
margin-bottom: -3px!important;
margin-left: 25px!important;
}
#pagelisterouter{
padding-left: 0!important;
margin-left: 25px;
padding-top: 25px;
}
.cmsouter .iconbox:hover{
background-color:#fcffe1;
}
.cmsouter .iconbox:hover .text{
color:#000000;
}
.cmsouter .text{
font-size:14px;
color:#000000;
text-decoration:none;
}
.container_box{
padding-top: 56px;
width: 100%;
display: block;
overflow: hidden;
}
.container_box .leftBox{
		display: inline-block;
		overflow-x: auto;
		height: 80%;
		border-right: 5px solid #7a96ff;
		width: 98%;
}
.container_box .leftBox .iconbox{
text-align: left;
padding: 10px ;
	width: 90%;
border-bottom: 1px #eae8e8 solid;
border-radius: 0px;
background-color: #ffffff;
display: table;
}
	.container_box .leftBox .iconbox .fa{
		display: table-cell;
		width: 14px;
	}
	.container_box .leftBox .iconbox .text{
display: table-cell;
vertical-align: middle;
padding-left: 15px;
color: #000000;
		font-weight:500;
font-size: 14px;
font-family: 'Roboto', sans-serif;
}
.container_box .leftBox .iconbox img{
height: auto;
width: 30px;
display: inline-flex;
vertical-align: middle;
}
.container_box .leftBox .iconbox:hover{
background-color:#ffffff;
}
.container_box .leftBox .iconbox:hover .text{
color: #233a49;
font-weight: 600;
}
.container_box  .cms_title{
margin: 0 0px;
		margin-top:56px;
text-align: left;
padding: 15px;
font-size: 20px;
color: #233a49;
text-shadow: 1px 1px 2px white;
box-shadow: 1px 1px 13px -3px #4caf50;
background-color: #f2f2f287;
margin-bottom: 15px;
}
.ExploreLogo{
background-color: #f8f8f8!important;
margin-bottom: 0px!important;
padding: 15px!important;
padding-left: 8%!important;
}
.container_box .cmsouter #pagelisterouter{
padding: 3%!important;
padding-top: 0%!important;
margin: 0!important;
}
.style1{
color: #f41f06
}
	.makeclass{
		padding: 10px 20px;
		color: #484848;
	}
	
	
	
	.sidebar, .sidebar-collapsed, .leftBox, .toggleBtn, .sidebar-collapsed .fa:before {
		transition:all .5s ease-in-out;
		-webkit-transition:all .5s ease-in-out;
	}
	
	.sidebar {
		background:lightgrey;
		width:200px;
		height:100vh;
		position:absolute;
		top:0;
		left:0;
		width:18%;
	}
	.sidebar-collapsed{
		width:4%!important;
	}
	/*.sidebar-collapsed {
		transform:translateX(-100%);
		-webkit-transform:translateX(-100%);
	}*/
	
	.sidebar-collapsed .toggleBtn {
		left: 12px;
	top: 68px;
	}
	.sidebar-collapsed .cms_title{
		visibility: hidden;
	}
	.sidebar-collapsed .hd{
		background-color: #233a49!important;
	}
	.sidebar-collapsed .leftBox{
		width: 90%;
}
	.sidebar-collapsed  .fa:before {
		content: "\f09d";
		font-size: 20px;
	}
	/*-------------------------------*/
	/*       Hamburger-Cross         */
	/*-------------------------------*/
	
	.hamburger {
		position: absolute;
		right: 10px;
		top: 67px;
		width: 30px;
		height: 30px;
		border: none;
		background: transparent;
	}
	.hamburger:hover,
	.hamburger:focus,
	.hamburger:active {
	outline: none;
	}
	.sidebar-collapsed .hamburger:before {
	content: '';
	display: block;
	width: 100px;
	font-size: 14px;
	color: #fff;
	line-height: 32px;
	text-align: center;
	opacity: 0;
	-webkit-transform: translate3d(0,0,0);
	-webkit-transition: all .35s ease-in-out;
	}
	.sidebar-collapsed .hamburger:hover:before {
	opacity: 1;
	display: block;
	-webkit-transform: translate3d(-100px,0,0);
	-webkit-transition: all .35s ease-in-out;
	}
	
	.sidebar-collapsed .hamburger .hamb-top,
	.sidebar-collapsed .hamburger .hamb-middle,
	.sidebar-collapsed .hamburger .hamb-bottom,
	.sidebar .hamburger .hamb-top,
	.sidebar .hamburger .hamb-middle,
	.sidebar .hamburger .hamb-bottom {
	position: absolute;
	left: 0;
	height: 4px;
	width: 100%;
	}
	.sidebar-collapsed .hamburger .hamb-top,
	.sidebar-collapsed .hamburger .hamb-middle,
	.sidebar-collapsed .hamburger .hamb-bottom {
	background-color: #1a1a1a;
	}
	.sidebar-collapsed .hamburger .hamb-top {
	top: 5px;
	-webkit-transition: all .35s ease-in-out;
	}
	.sidebar-collapsed .hamburger .hamb-middle {
	top: 50%;
	margin-top: -2px;
	}
	.sidebar-collapsed .hamburger .hamb-bottom {
	bottom: 5px;
	-webkit-transition: all .35s ease-in-out;
	}
	
	.sidebar .hamburger .hamb-top,
	.sidebar .hamburger .hamb-middle,
	.sidebar .hamburger .hamb-bottom {
	background-color: #1a1a1a;
	}
	.sidebar .hamburger .hamb-top,
	.sidebar .hamburger .hamb-bottom {
	top: 50%;
	margin-top: -2px;
	}
	.sidebar .hamburger .hamb-top {
	-webkit-transform: rotate(45deg);
	-webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
	}
	.sidebar .hamburger .hamb-middle { display: none; }
	.sidebar .hamburger .hamb-bottom {
	-webkit-transform: rotate(-45deg);
	-webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
	}
	.sidebar .hamburger:before {
	content: '';
	display: block;
	width: 100px;
	font-size: 14px;
	color: #fff;
	line-height: 32px;
	text-align: center;
	opacity: 0;
	-webkit-transform: translate3d(0,0,0);
	-webkit-transition: all .35s ease-in-out;
	}
	.sidebar .hamburger:hover:before {
	opacity: 1;
	display: block;
	-webkit-transform: translate3d(-100px,0,0);
	-webkit-transition: all .35s ease-in-out;
	}

	.dataTables_wrapper{
	    overflow: auto!important;
		height: 450px!important;

	}
</style>
<div class="container_box">
	<div class="sidebarBtn sidebar " style="background-color: #ffffff;  left: 0px; top: 0px; position: fixed; width: 18%;height:100%;">
		<h5 class="cms_title ExploreLogo" style="margin-top:56px;">Accounts</h5>
		<button type="button" class="hamburger animated fadeInLeft toggleBtn" data-toggle="offcanvas">
		<span class="hamb-top"></span>
		<span class="hamb-middle"></span>
		<span class="hamb-bottom"></span>
		</button>
		<div class="leftBox">
			<div class="iconbox hd" style="margin-top: 10px;"><div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">AGENT PAYMENTS</div></div>
			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=18"><div class="iconbox" <?php if($_REQUEST['sr']==18){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==18){ ?> style="color: #fff;"<?php } ?>>Agent Payment Schedule</div></div></a>

			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=1"><div class="iconbox" <?php if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?> style="color: #fff;"<?php } ?>>Agent Pending Payment</div></div></a>

			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=3"><div class="iconbox" <?php if($_REQUEST['sr']==3){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==3){ ?> style="color: #fff;"<?php } ?>>Agent Overdue Report</div></div></a>
			<a href="showpage.crm?fromDate=<?php echo date('d-m-Y', strtotime(' -90 day'));?>&toDate=<?php echo date('d-m-Y', strtotime(' -1 day'));?>&module=accounts&sr=19"><div class="iconbox <?php if($_REQUEST['report']==7){?> active <?php } ?>"><img src="images/user_group.png" /><div class="text">Daily Sales Report</div></div></a>
			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=2"><div class="iconbox" <?php if($_REQUEST['sr']==2){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-get-pocket" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==2){ ?> style="color: #fff;"<?php } ?>>Received from Agent</div></div></a>
			
			
			<div class="iconbox hd"><div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">SUPPLIER PAYMENTS</div></div>
			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=6"><div class="iconbox" <?php if($_REQUEST['sr']==6){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-handshake-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==6){ ?> style="color: #fff;"<?php } ?>>Supplier Payment Schedule</div></div></a>
			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=4"><div class="iconbox" <?php if($_REQUEST['sr']==4){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==4){ ?> style="color: #fff;"<?php } ?>>Supplier Pending Payment</div></div></a>
			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=5"><div class="iconbox" <?php if($_REQUEST['sr']==5){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-get-pocket"j aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==5){ ?> style="color: #fff;"<?php } ?>>Paid to Supplier</div></div></a>
			<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=7"><div class="iconbox" <?php if($_REQUEST['sr']==7){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==7){ ?> style="color: #fff;"<?php } ?>>Supplier Overdue Report</div></div></a>
			
			
			<div class="iconbox"><div class="text" style="padding-left: 0px;color: #fa7f00; font-size: 13px; font-weight: 600;">ACCOUNT SUMMARY</div></div>
                <a href="<?php echo $fullurl; ?>?sr=9"><div class="iconbox" <?php if($_REQUEST['sr']==9){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?> ><i class="fa fa-credit-card" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==9){ ?> style="color: #fff;"<?php } ?>>Payable Vs Receivable</div></div></a>
                <a href="<?php echo $fullurl; ?>?sr=11"><div class="iconbox" <?php if($_REQUEST['sr']==11){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==11){ ?> style="color: #fff;"<?php } ?>>Profit Report</div></div></a>

                <a href="<?php echo $fullurl; ?>?sr=12"><div class="iconbox" <?php if($_REQUEST['sr']==12){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==12){ ?> style="color: #fff;"<?php } ?>>Tax Report</div></div></a>

                <a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=13"><div class="iconbox" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==13){ ?> style="color: #fff;"<?php } ?>>Non Invoice Report</div></div></a>
				
				<a href="<?php echo $fullurl; ?>?showpage.crm?module=accounts&sr=40"><div class="iconbox" <?php if($_REQUEST['sr']==40){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==40){  ?> style="color: #fff;"<?php } ?>>Turnover&nbsp;Statement&nbsp;Executive&nbsp;Wise</div></div></a>

				<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=34"><div class="iconbox" <?php if($_REQUEST['sr']==34){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==34){  ?> style="color: #fff;"<?php } ?>>Turnover&nbsp;Statement&nbsp;Country&nbsp;Wise</div></div></a>

				<a href="<?php echo $fullurl; ?>showpage.crm?module=accounts&sr=41"><div class="iconbox" <?php if($_REQUEST['sr']==41){ ?> style="color: #fff; background-color: #6ebac7;"<?php } ?>><i class="fa fa-clock-o" aria-hidden="true"></i><div class="text" <?php if($_REQUEST['sr']==41){ ?> style="color: #fff;"<?php } ?>>File&nbsp;Wise&nbsp;Liability&nbsp;Report</div></div></a>
			
		</div>
	</div>
	
	<div id="contentBox" style="background-color: #ffffff;  right: 0px; top: 0px; position: fixed; width: 80%; overflow: scroll;">
		
		<!-- Below filter for agent reports -->
		<?php if($_REQUEST['sr']==18 || $_REQUEST['sr']==1 || $_REQUEST['sr']==3 || $_REQUEST['sr']==2){ ?>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative;">
			<tr>
				<td width="91%" align="left" valign="top">
					<form id="listform" name="listform" method="get">
						<input name="module" id="module" type="hidden" value="accounts" />
						<input name="sr" id="report" type="hidden" value="<?php echo $_REQUEST['sr'];?>" />
						<div class="">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px 5px 0;border-bottom: 1px solid #ccc;">
								<tr>
									<h3 class="cms_title"> <?php if($_REQUEST['sr']==18){ ?> Agent Payment Schedule Report <?php } if($_REQUEST['sr']==1){ ?> Agent Payment Pending Report <?php }if($_REQUEST['sr']==3){ ?> Agent Overdue Report <?php }if($_REQUEST['sr']==2){ ?> Received from Agent Report <?php } ?> </h3>
									<td width="25%">
									</td>
									
									<td width="75%">
										<table width="100%" border="0" cellspacing="0" cellpadding="3" >
											<tr >
												
												<td  align="right" width="40%">
												</td>
												<td  align="right" width="30%">
													<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 180px; border-radius: 42px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y',strtotime(' -90 day')).' - '.date('d-m-Y', strtotime(' -1 day')); } ?>" size="100" maxlength="100" placeholder="Travel Date"/>
												</td>
												<td  align="right" width="20%">
													<select name="agentCode" id="agentCode" class="makeclass T5<?php if($_REQUEST['agentCode']!='') { ?> selected <?php } ?>">
														<option value="">Select Agent</option>
														<?php
														$a12=GetPageRecord('*',_CORPORATE_MASTER_,' 1 and name!=""  and deletestatus=0  order by name asc');
														while($guideData=mysqli_fetch_array($a12)){
														?>
														<option <?php echo "value='".strip($guideData['id'])."'"; if(isset($_REQUEST['agent']) && $_REQUEST['agent']==strip($guideData['id'])){echo 'selected';} ?> ><?php echo $guideData['name'];?></option>
														<?php
														}
														?>
													</select>
												</td>
												<td  align="right" width="10%">
													<input type="submit" name="Submit" value="Search" class="   makeclass" style="background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;" /></td>
												</tr>
											</table>
											
										</td>
									</tr>
								</table>
							</div>
						</form>
					</td>
				</tr>
			</table>
		<?php }?>


<!-- Daily sales report -->
		
<?php if($_REQUEST['sr']=='19'){



$strWhere='';



if($fromDate!='' && $toDate!=''){



$fromDate = date('Y-m-d', strtotime( $fromDate ));



$toDate = date('Y-m-d', strtotime( $toDate ));



$strWhere.=' queryDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';



}



if($assignto!=''){  



$strWhere.=' and assignTo='.$assignto.'';



}



if($destinationId!=''){  



$strWhere.=' and destinationId='.$destinationId.'';



}



if($categoryId!=''){  



$strWhere.=' and categoryId='.$categoryId.'';



}



if($tourType!=''){  



$strWhere.=' and tourType='.$tourType.'';



}



if($clientType!=''){  



$strWhere.=' and clientType='.$clientType.'';



}



// if($Clients!=''){  



// $strWhere.=' and companyId='.$Clients.'';



// }



?>



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



<tr>




<td width="91%" align="left" valign="top">



<form method="get">



<div class=""><table width="100%" border="0" cellpadding="0" cellspacing="0">




<tr>



<h3 class="cms_title" style="padding-left:90px">Daily Sales Report</h3>
&nbsp;<span class="doExpand" style="padding:10px;cursor:pointer;border:1px black solid;border-radius:50px;position:absolute;top:67px;">Expand</span>


<td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"> </span>



<div id="deactivatebtn" style="display:none;">



<?php if($deletepermission==1){ ?> 







<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />



<?php } ?>



</div>







</div></td>



<td align="right"><table border="0" cellpadding="0" cellspacing="0">



<tr>



<td >



<table width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<td><input name="fromDate" type="text"  class="topsearchfiledmain" id="fromDate" style="width:80px;"  size="6"  placeholder="From"  value="<?php echo  date('d-m-Y', strtotime($fromDate)); ?>"/></td>



<td style="padding:0px 0px 0px 5px;" > 



<input name="toDate" type="text"  class="topsearchfiledmain" id="toDate" style="width:80px;"   size="6"   placeholder="To" value="<?php echo date('d-m-Y', strtotime($toDate)); ?>"/> </td>







<td style="padding:0px 0px 0px 5px;" ><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:180px; " >



<option value="">All Sales Person</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' userType=0 and status=1 order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($assignto==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;" ><select name="destinationId" id="destinationId" class="topsearchfiledmainselect" style="width:140px; " >



<option value="">All Destinations</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 order by name asc';  



$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo $resListing['id']; ?>" <?php if($destinationId==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['name']; ?> </option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;" ><select name="categoryId" id="categoryId" class="topsearchfiledmainselect" style="width:150px; " >



<option value="">All Hotel Category</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' deletestatus=0 and status=1 order by id asc ';  



$rs=GetPageRecord($select,_HOTEL_CATEGORY_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$categoryId){ ?>selected="selected"<?php } ?>>
<?php if($resListing['hotelCategory']==3){echo '3 star';}
if($resListing['hotelCategory']==4){echo '4 star';}
if($resListing['hotelCategory']==5){echo '5 star';}
?>
</option>



<?php } ?>



</select></td>



<td style="padding:0px 0px 0px 5px;" ><select name="tourType" id="tourType" class="topsearchfiledmainselect" style="width:120px; " >



<option value="">All Tour Type</option>



<?php 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' deletestatus=0 and status=1 order by name asc';  



$rs=GetPageRecord($select,_TOUR_TYPE_MASTER_,$where); 



while($resListing=mysqli_fetch_array($rs)){  



?>



<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$tourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>



<?php } ?>



</select></td>



<script>



function loadsearchClients(){



var clientType = $('#clientType').val();



$('#Clients').load('loadsearchClient.php?userId=<?php echo $clients; ?>&usrType='+clientType);



}



</script>



<td style="padding:0px 0px 0px 5px;" ><select onChange="loadsearchClients();" id="clientType" name="clientType" class="topsearchfiledmainselect" displayname="Client Type" autocomplete="off" style="width:110px; " > 



<option value=""  <?php if($clientType==0){ ?>selected="selected"<?php } ?>>All Clients</option> 



<option value="1"  <?php if($clientType==1){ ?>selected="selected"<?php } ?>>Agent</option> 



<option value="2"  <?php if($clientType==2){ ?>selected="selected"<?php } ?>>B2C</option> 



</select></td>



<!-- <td style="padding:0px 0px 0px 5px;" ><select name="Clients" id="Clients" class="topsearchfiledmainselect" style="width:120px; " >



<option value="">All Clients</option>







</select></td> -->



<td style="padding-right:20px;"><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />







<input name="report" id="report" type="hidden" value="7" />







<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>



</tr>



</table><input name="reportSubmit" id="reportSubmit" type="hidden" value="1" />



</td>







</tr>







</table></td>



</tr>







</table>



<script>



loadsearchClients();



</script>



</div>



</form>







<div id="pagelisterouter"  style="padding-left: 0px; padding: 10px; padding-top: 2px;">







<?php if($_REQUEST['fromDate']=='' && $_REQUEST['toDate']==''){ ?>



<div class="norec">Please Select From Date and To Date then Press Search </div>



<?php } else { ?>



<div id="boxreport"><table border="0" cellpadding="2" cellspacing="2" class="tablesorter gridtable">



<thead>



<tr>



<th align="left" valign="middle" class="header" ><label for="checkAll"><span></span>Name</label></th> 



<th align="center" valign="middle" class="header" ><label for="checkAll"><span></span>Queries</label></th> 



<th align="center" class="header">Tasks</th>



<th align="center" class="header">Meetings</th>



<th align="center" class="header">Calls</th>



<!-- <th align="center" class="header">TAT&nbsp;followed</th>-->



<th align="center" class="header"> Sales</th>



</tr>



</thead>











<tbody>



<?php 
// $queryTotal=0;
// $confirmedTotal=0;
// $assignedTotal=0;
// $revertedTotal=0;
////////////if assign to is not blank. Comes from search.////////////
if($assignto!=''){ 
?>



<tr style="font-size:13px;">



<td align="left" valign="middle"><?php echo getUserName($_REQUEST['assignto']); ?></td>



<td align="center" valign="middle"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=3";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?> </td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=2";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<td align="center"><?php  



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and queryStatus=1";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);?></td>



<style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>



<!--   <td align="center"></td>-->



<td align="center">







<?php







$suppliertotalcost_sum=0;



$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 ");



while($res_menu=mysqli_fetch_array($menu)){



$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 



$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 



$result2=mysqli_fetch_array($rs3);  



$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 



$row = mysqli_fetch_assoc($result); 



$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];



}



echo $suppliertotalcost_sum;



?>  </td>



</tr>







<?php } else {







////////////if assign to is blank comes from report////////////



$strWhere='';



if($fromDate!='' && $toDate!=''){



$fromDate = date('Y-m-d', strtotime( $fromDate ));



$toDate = date('Y-m-d', strtotime( $toDate ));



$strWhere.=' fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 and status=3 ';



} 



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' userType=0 and status=1 order by firstName asc';  



$rs=GetPageRecord($select,_USER_MASTER_,$where); 


while($resListing=mysqli_fetch_array($rs)){  



?>



<tr style="font-size: 13px;">



<td align="left" valign="middle"><?php echo $resListing['firstName']; ?></td>



<td align="center" valign="middle"><?php 



$sql5="select id from "._QUERY_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']." ";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



if($tquery=='' && $tquery!='0'){echo '0';}







$queryTotal=$tquery+$queryTotal;



?></td>



<td align="center"><?php  



$sql5="select id from "._TASKS_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$confirmedTotal=$tquery+$confirmedTotal;



?> </td>



<td align="center"><?php  



$sql5="select id from "._MEETINGS_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$revertedTotal=$tquery+$revertedTotal;



?></td>



<td align="center"><?php  



$sql5="select id from "._CALLS_MASTER_." where ".$strWhere." and assignTo=".$resListing['id']."";



$res5 = mysqli_query(db(),$sql5);



echo $tquery=mysqli_num_rows($res5);



$assignedTotal=$tquery+$assignedTotal;



?></td>



<style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>



<!--   <td align="center"></td>-->




<td align="center">







<?php



$strWhere='';



if($fromDate!='' && $toDate!=''){



$fromDate = date('Y-m-d', strtotime( $fromDate ));



$toDate = date('Y-m-d', strtotime( $toDate ));



$strWhere.=' followupdate BETWEEN "'.$fromDate.'" and "'.$toDate.'" and deletestatus=0 ';



}







$suppliertotalcost_sum=0;



//$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where ".$strWhere." and queryStatus=3 and assignTo=".$resListing['id']."");



$menu=mysqli_query(db(),"select id from "._QUERY_MASTER_."    where  queryStatus=3 and assignTo=".$resListing['id']."");



while($res_menu=mysqli_fetch_array($menu)){



$sql3="select id from "._PAYMENT_REQUEST_MASTER_." where queryid='".$res_menu['id']."' and deletestatus=0"; 


// var_dump($sql3);
$rs3=mysqli_query(db(),$sql3) or die(mysqli_error(db())); 



$result2=mysqli_fetch_array($rs3);  



$result = mysqli_query(db(),"SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id'].""); 

// var_dump("SELECT SUM(suppliertotalcost) AS suppliertotalcost_sum from "._PAYMENT_SUPPLIER_LIST_MASTER_." where  paymentId=".$result2['id']."");

$row = mysqli_fetch_assoc($result); 



$suppliertotalcost_sum = $suppliertotalcost_sum+$row['suppliertotalcost_sum'];



}



echo $suppliertotalcost_sum;



$salesTotal=$suppliertotalcost_sum+$salesTotal;



?>  </td>



</tr> 







<?php } ?>







<!--Total start-->



<tr style="font-size: 13px; background-color:#f1f1f1; font-weight:bold;">



<td align="left" valign="middle"><strong>Total</strong></td>



<td align="center" valign="middle"><?php  echo $queryTotal;?></td>



<td align="center"><?php  echo $confirmedTotal;?> </td>



<td align="center"><?php  echo $revertedTotal;?></td>



<td align="center"><?php  echo $assignedTotal;?></td>



<style>/* and id in (select queryId from "._VOUCHER_MASTER_." where emailsent=1)*/</style>



<!--   <td align="center"></td>-->



<td align="center">







<?php echo $salesTotal;?>   </td>



</tr> 







<!--Total end-->



<?php  }?>



</tbody></table>



</div>



<div style="text-align:center; margin-top:30px;">



<form method="post" name="downloadrtm" id="downloadrtm" action="allReports/download_report.php" target="actoinfrm"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Report"  style="margin-left:0px;" onClick="copydatatodata();" ><textarea name="reportdata" id="reportdata" cols="" rows="" style=" display:none;"></textarea></form></div>



<script>



function copydatatodata(){



var boxreport = $('#boxreport').html();



$('#reportdata').val(boxreport);  



$('#downloadrtm').submit();  



}



</script>



<?php } ?>



</div>  </td>



</tr>



</table>



<script> 



window.setInterval(function(){ 



checked = $("#listform .gridtable td input[type=checkbox]:checked").length;







if(!checked) { 



$("#deactivatebtn").hide();



$("#topheadingmain").show();



} else {



$("#deactivatebtn").show();



$("#topheadingmain").hide();



} 



}, 100);



comtabopenclose('linkbox','op2');



</script>



<?php } ?>


<!-- Daily sales Report end -->


		<!-- Below filters for supplier reports -->
		<?php if($_REQUEST['sr']==6 || $_REQUEST['sr']==4 || $_REQUEST['sr']==3 || $_REQUEST['sr']==2){ ?>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="position:relative; overflow: scroll;">
			<tr>
				<td width="91%" align="left" valign="top">
					<form id="listform" name="listform" method="get">
						<input name="module" id="module" type="hidden" value="accounts" />
						<input name="sr" id="report" type="hidden" value="<?php echo $_REQUEST['sr'];?>" />
						<div class="">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px 5px 0;border-bottom: 1px solid #ccc;">
								<tr>
									<h3 class="cms_title"> <?php if($_REQUEST['sr']==6){ ?> Supplier Payment Schedule Report <?php } if($_REQUEST['sr']==4){ ?> Supplier Payment Pending Report <?php }if($_REQUEST['sr']==3){ ?> Agent Overdue Report <?php }if($_REQUEST['sr']==2){ ?> Received from Agent Report <?php } ?> </h3>
									<td width="25%">
									</td>
									
									<td width="75%">
										<table width="100%" border="0" cellspacing="0" cellpadding="3" >
											<tr >
												
												<td  align="right" width="40%">
												</td>
												<td  align="right" width="30%">
													<input name="daterange" type="text" readonly=""  class="topsearchfiledmain" id="daterange" style="width: 180px; border-radius: 42px;" value="<?php if($_GET['daterange']!=''){ echo $_GET['daterange']; } else { echo date('d-m-Y',strtotime(' -90 day')).' - '.date('d-m-Y', strtotime(' -1 day')); } ?>" size="100" maxlength="100" placeholder="Travel Date"/>
												</td>
												<td  align="right" width="20%">
													<select name="agentCode" id="agentCode" class="makeclass T5<?php if($_REQUEST['agentCode']!='') { ?> selected <?php } ?>">
														<option value="">Select Supplier</option>
														<?php
														$a12=GetPageRecord('*',_CORPORATE_MASTER_,' 1 and name!=""  and deletestatus=0  order by name asc');
														while($guideData=mysqli_fetch_array($a12)){
														?>
														<option <?php echo "value='".strip($guideData['id'])."'"; if(isset($_REQUEST['agent']) && $_REQUEST['agent']==strip($guideData['id'])){echo 'selected';} ?> ><?php echo $guideData['name'];?></option>
														<?php
														}
														?>
													</select>
												</td>
												<td  align="right" width="10%">
													<input type="submit" name="Submit" value="Search" class="   makeclass" style="background-color: #4CAF50; border: 1px solid #4CAF50; color: #fff;width: 83px;" /></td>
												</tr>
											</table>
											
										</td>
									</tr>
								</table>
							</div>
						</form>
					</td>
				</tr>
			</table>
		<?php }?>
		<div class="rightBox cmsouter" id="loadAccountsReports"  >No Records Found!</div></div>
			
		</div>
		<script>
		<?php

		// Agent Reports
		// if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?>
		// 	$('#loadAccountsReports').load("loadAgentPaymentPendingReport.php?sr=<?php
		// 	echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']).'&paymentstatus='.urlencode($_REQUEST['paymentstatus']); ?>");
		// 	<?php
		// }

		if($_REQUEST['sr']==1 || $_REQUEST['sr']==''){ ?>
			$('#loadAccountsReports').load("loadAgentPaymentPendingReport.php?<?php 
			if(isset($_REQUEST['agentCode']))
			echo 'agentCode='.urlencode($_REQUEST['agentCode']).'&';
			if(isset($_REQUEST['daterange']))
			echo 'daterange='.urlencode($_REQUEST['daterange']).'&'; 
			if(isset($_REQUEST['paymentstatus']))
			echo 'paymentstatus='.urlencode($_REQUEST['paymentstatus']).'&'; 
			?>");
			<?php
		}
		
		if($_REQUEST['sr']==18){ ?>
			$('#loadAccountsReports').load("agentPaymentScheduleReport.php?sr=<?php
			echo urlencode($_GET['sr']);
			if(isset($_REQUEST['daterange']))
			echo '&daterange='.urlencode($_REQUEST['daterange']);
			else
			echo '&fromDate='.urlencode(date('d-m-Y', strtotime(' -90 day'))).'&toDate='.urlencode(date('d-m-Y', strtotime(' -1 day')));
			?>");
			<?php
		}
		
		if($_REQUEST['sr']==2 ){ ?>
			$('#loadAccountsReports').load('loadReceivedFromAgentReport.php?sr=<?php echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']).'&paymentstatus='.urlencode($_REQUEST['paymentstatus']); ?>');
		<?php
		}
		if($_REQUEST['sr']==3 ){ ?>
			$('#loadAccountsReports').load("loadAgentOverdueReport.php?sr=<?php
			echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']).'&paymentstatus='.urlencode($_REQUEST['paymentstatus']); ?>");
			<?php
		}


		// Suppplier reports
		if($_REQUEST['sr']==6 ){ ?>
			$('#loadAccountsReports').load("loadSupplierScheduleReport.php?sr=<?php
			echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']).'&paymentstatus='.urlencode($_REQUEST['paymentstatus']); ?>");
			<?php
		}
		if($_REQUEST['sr']==4 ){ ?>
			$('#loadAccountsReports').load('loadSupplierPendingPaymentReport.php?sr=<?php echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']).'&paymentstatus='.urlencode($_REQUEST['paymentstatus']); ?>');
			<?php
		}
		if($_REQUEST['sr']==5 ){ ?>
			$('#loadAccountsReports').load('loadPaidToSupplierReport.php?sr=<?php echo $_GET['sr']; ?>');
			<?php
		}
		if($_REQUEST['sr']==7 ){ ?>
			$('#loadAccountsReports').load('loadSupplierOverdueReport.php?sr=<?php
			echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']).'&paymentstatus='.urlencode($_REQUEST['paymentstatus']); ?>');
			<?php
		}
		if($_REQUEST['sr']==8 ){ ?>
			$('#loadAccountsReports').load('loadAccountsSupplierPayableNotUpdated.php?sr=<?php echo $_GET['sr']; ?>');
			<?php
		}
		
		if($_REQUEST['sr']==9){ ?>
			$('#loadAccountsReports').load("loadAccountsPayableVsReceivableReport.php?<?php 
			if(isset($_REQUEST['agentCode']))
			echo 'agentCode='.urlencode($_REQUEST['agentCode']);
			?>");
			<?php
		  }

		//   if($_REQUEST['sr']==9){ ?>
        //     $('#loadAccountsReports').load("loadAccountsPayableVsReceivableReport.php?<?php 
        //     if(isset($_REQUEST['agentCode']))
        //     echo 'agentCode='.urlencode($_REQUEST['agentCode']);
        //     ?>");
        //     <?php
        //   }

          if($_REQUEST['sr']==11){ ?>
            $('#loadAccountsReports').load("loadAccountsProfitReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            ?>");
            <?php
          }

          if($_REQUEST['sr']==12){ ?>
            $('#loadAccountsReports').load("loadAccountsTaxReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            ?>");
            <?php
          }

          if($_REQUEST['sr']==13){ ?>
            $('#loadAccountsReports').load("loadAccountsNonInvoiceReport.php?<?php 
            if(isset($_REQUEST['agentCode']))
            echo 'agentCode='.urlencode($_REQUEST['agentCode']);
            ?>");
            <?php
          }
          ?>
			




		<?php
		// if($_REQUEST['sr']==11 ){ ?>
		// 	$('#loadAccountsReports').load('loadAccountsProfitReport.php?sr=<?php echo $_GET['sr']; ?>');
		// 	<?php
		// }
		// if($_REQUEST['sr']==12 ){ ?>
		// 	$('#loadAccountsReports').load('loadAccountsProfitReport.php?sr=<?php echo $_GET['sr']; ?>');
		// 	<?php
		// }
		if($_REQUEST['sr']==15 ){ ?>
			$('#loadAccountsReports').load('accountReportsinfo.php?sr=<?php
			echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']);?>');
			<?php
		}
		if($_REQUEST['sr']==16 ){ ?>
			$('#loadAccountsReports').load('accountReportsinfo.php?sr=<?php
			echo urlencode($_GET['sr']).'&daterange='.urlencode($_REQUEST['daterange']);?>');
			<?php
		} ?>
		
		<?php
		if($_REQUEST['sr']==17 ){   ?>
			$('#loadAccountsReports').load('accountReportsinfo.php?sr=<?php
			echo $_GET['sr'];
			if(isset($_REQUEST['assignto']))
			echo '&assignto='.$_REQUEST['assignto'];
			if(isset($_REQUEST['country']))
			echo '&country='.$_REQUEST['country'];
			if(isset($_REQUEST['client']))
			echo '&client='.$_REQUEST['client'];
			if(isset($_REQUEST['fromDate']))
			echo '&fromDate='.$_REQUEST['fromDate'];
			if(isset($_REQUEST['toDate']))
			echo '&toDate='.$_REQUEST['toDate'];
			else
			echo '&fromDate='.date('d-m-Y', strtotime(' -90 day')).'&toDate='.date('d-m-Y', strtotime(' -1 day'));
			?>');
			<?php 
		} ?>
		
		<?php 
		if($_REQUEST['sr']==19){ ?>
			$('#loadAccountsReports').load("dailyWiseSupplierPaymentPendingReport.php?sr=<?php
			echo urlencode($_GET['sr']);
			if(isset($_REQUEST['daterange']))
			echo '&daterange='.urlencode($_REQUEST['daterange']);
			if(isset($_REQUEST['supplier']))
			echo '&supplier='.urlencode($_REQUEST['supplier']);
			if(isset($_REQUEST['contact_person']))
			echo '&contact_person='.urlencode($_REQUEST['contact_person']);
			else
			echo '&fromDate='.urlencode(date('d-m-Y', strtotime(' -90 day'))).'&toDate='.urlencode(date('d-m-Y', strtotime(' -1 day')));
			?>");
			<?php 
		} ?>
		

		function getSupplierOverduefun(filterId){
			$('#loadAccountsReports').load('loadSupplierOverdueReport.php?filterId='+filterId+'&sr=<?php
			echo urlencode($_GET['sr']); ?>');
		}
		
		function getSupplierReceivedfun(filterId){
			$('#loadAccountsReports').load('loadPaidToSupplierReport.php?filterId='+filterId+'&sr=<?php
			echo urlencode($_GET['sr']); ?>');
		}
		
		function getPayableVsReceivablefun(filterId){
			$('#loadAccountsReports').load('loadAccountsPayableVsReceivableReport.php?filterId='+filterId+'&sr=<?php
			echo urlencode($_GET['sr']); ?>');
		}
		function getAccountsProfitReportfun(filterId){
			$('#loadAccountsReports').load('loadAccountsProfitReport.php?filterId='+filterId+'&sr=<?php
			echo urlencode($_GET['sr']); ?>');
		}
		
		
		</script>
		<style type="text/css">
		.cmslistBox{
		display: block;
		position: relative;
		width: 100%;
		overflow: hidden;
		height: 300px;
		padding: 30px;
		}
		.leftlistBox{
		position: relative;
		display: inline-block;
		float: left;
		width: 46%;
		}
		.rightlistBox{
		position: relative;
		display: inline-block;
		float: left;
		width: 46%;
		}
		.cmslistBox_dsdsds{
		}
		</style>
		<link href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css" rel="stylesheet"/>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	
		<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<script>
		//for date picker load solution
			jQuery('#daterange').daterangepicker({
				"autoApply": true,
				opens: 'right',
				locale:
				{
					format: 'DD-MM-YYYY'
				}
			},
			function(start, end, label) {
			
			}),
		
		$(document).ready(function() {
		
			//toggleBtn side bar
			$('.toggleBtn').on('click', function() {
				$('.sidebarBtn').toggleClass("sidebar-collapsed");
				$('.sidebarBtn').toggleClass("sidebar");
				
				if($('.sidebarBtn').hasClass('sidebar-collapsed') == true ){
					$('#contentBox').css('width','96%');
					$('.sidebarBtn .text').hide();
				}else{
					$('#contentBox').css('width','80%');
					$('.sidebarBtn .text').show();
				}
			});
			
			
			//Data Tables
			$('#exampleDiv').DataTable(
			{
				dom: 'Bfrtilp',
					buttons: [
						'copyHtml5',
						'excelHtml5',
						'pdfHtml5'
					],
				language: {
				search: "Search: ",
				searchPlaceholder: "Agent Name, Contact Person , Mobile Number",
				},
					
			}
			);
		} );
		</script>