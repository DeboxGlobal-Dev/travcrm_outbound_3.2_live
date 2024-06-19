<?php

use Predis\Command\ScriptCommand;

include "inc.php";

$select='*';   
$where='id="'.($_GET['queryId']).'"';   
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 
$queryId = $resultpage['id'];

$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"  '); 
$QueryDaysData=mysqli_fetch_array($rsp); 
$quotationId = $QueryDaysData['id']; 
  
$singQuery = "";   
if($QueryDaysData['quotationType'] == 2){ 
	$singQuery = " and categoryId='".$QueryDaysData['finalcategory']."'";
}  
?>
<div id='printableArea<?php echo strip($resultpage['id']); ?>'>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;" id="refreshhtmlId">			
	<?php 
	// $hotelNo = 1;
	$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$QueryDaysData['id'].'" '.$singQuery.' order by fromDate asc ');  
	while($hotelQuotData=mysqli_fetch_array($b)){ 
	
		$rsh=GetPageRecord('*','finalQuote',' quotationId="'.clean($QueryDaysData['id']).'" and hotelQuotationId="'.$hotelQuotData['id'].'" order by id desc limit 1');  
		$listingyes=mysqli_fetch_array($rsh); 
		
		$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
		$hotelData=mysqli_fetch_array($d);
		
		$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' id='.$hotelData['hotelCategoryId'].' order by hotelCategory asc'); 
		$hotelCategoryData=mysqli_fetch_array($hotelCatQuery);
		
		?>
					<thead>
						<tr>  
						<th align="left" bgcolor="#ddd">
						<?php echo strip($hotelData['hotelName']);  ?>&nbsp;|&nbsp;<?php echo $hotelCategoryData['hotelCategory']; ?>&nbsp;Star <span style="margin-bottom:10px; font-size:12px;">|&nbsp;&nbsp;<?php 
						$earlier = new DateTime($hotelQuotData['fromDate']);
						$later = new DateTime($hotelQuotData['toDate']);
						$nightstay=0;
						$nightstay=$later->diff($earlier)->format("%a");
						if($nightstay == 0){ $nightstay = $nightstay+1;}else{ $nightstay; }
						echo $nightstay;
						
						?>
						 Night(s)</span> 
						 </th>
						</tr>
					</thead>
					<tbody >
					<tr>
					<td width="100%" align="left" valign="top" style="padding:10px !important; ">
				<?php if($listingyes['roomSingle']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px;position:relative;">Room Type: <strong>Single</strong></div>
				<div style="margin-bottom:20px;"> 
				
				<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4" style="width: 22%;"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td> 
    <td bgcolor="#F4F4F4"><strong>Remarks </strong></td> 
    <!-- <td bgcolor="#F4F4F4" style="width: 10%;"><strong>&nbsp;</strong></td>  -->

  </tr>
  	<?php
	 
  	$no=1;
  	for ($k = 0 ; $k < $listingyes['roomSingle']; $k++){ 
	  
		$rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="single" and roomNo="'.$no.'" order by id desc');  
		$itshave=mysqli_fetch_array($rshg); 
	
		if($itshave['id']==''){
						
			$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="single",roomNo="'.$no.'"';   
			addlisting('roomingList',$namevalue);	
		} 
		$select12='*';  
		$where12='id="'.$hotelQuotData['roomType'].'"'; 
		$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
		$editresult2=mysqli_fetch_array($rs12);
		$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%">Room <?php echo $no; ?></td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1Idsingle1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	<?php 
	$bbsingle=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	$listsuppliersingle=mysqli_fetch_array($bbsingle);
	?>
	<?php echo $listsuppliersingle['firstName'].' '.$listsuppliersingle['middleName'].' '.$listsuppliersingle['lastName']; ?>
	</td>	
    <td width="20%"><?php echo $rtype ?></td>

<td id="remarkSingle1<?php echo $no.$hotelData['id']; ?>" ><?php echo $itshave['guest1remark']; ?></td>

  <?php $no++;  } ?>
 
</table>
 </div>
	<?php } ?>

				
				<?php if($listingyes['roomDouble']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px;  padding-left:0px;position:relative;">Room Type: <strong>Double</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4" style="width: 22%;"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                           
	<td bgcolor="#F4F4F4"><strong>Remarks</strong></td>
  </tr>
  
  <?php $no=1;
 
  for ($k = 0 ; $k < $listingyes['roomDouble']; $k++){ 
  
  
  
  $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="double" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="double",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
			$select12='*';  
			$where12='id="'.$hotelQuotData['roomType'].'"'; 
			$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
			$editresult2=mysqli_fetch_array($rs12);
			$rtype=$editresult2['name'];						

  ?>
  <tr>
    <td width="15%" rowspan="2">Room <?php echo $no; ?> </td>
    <td width="5%" align="center">1</td>
	
    <td id="guest1Iddouble1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
    <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'"'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
	<?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?> 
	</td>
    <td rowspan="2"><?php echo $rtype ?></td>
	<td id="remarkDouble1<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest1remark']; ?></td>							
  </tr>
  <tr>
    <td width="5%" align="center">2</td>
     <td style="width: 22%;" id="guest2Iddouble2<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
     <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
    <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></td>

	<td id="remarkDouble2<?php echo $no.$hotelData['id']; ?>" ><?php echo $itshave['guest2remark']; ?></td>
    </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>
				<!-- ====================== Tirple Room start ================= -->
<?php if($listingyes['roomTriple']>0){ ?>
<div style="font-size:15px; font-weight:400; padding:5px;   padding-left:0px; position:relative;">Room Type: <strong>Triple</strong></div>
<div style="margin-bottom:20px;"> 
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                           
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                           

  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['roomTriple']; $k++){ 
  
  
  
  
  
  $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="tripple" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="tripple",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

}

		$select12='*';  
		$where12='id='.$hotelQuotData['roomType'].''; 
		$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
		$editresult2=mysqli_fetch_array($rs12);
		$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%" rowspan="3">Room <?php echo $no; ?>   </td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1Idtriple1<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'"'); 
			$listsupplier=mysqli_fetch_array($bb);
			?>
            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
            </td>
    <td rowspan="3"><?php echo $rtype; ?></td>
		<td id="remarkTriple1<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td id="guest2Idtriple2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
							$listsupplier=mysqli_fetch_array($bb);
							?>
                            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	                </td>
	    <td id="remarkTriple2<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest2remark'] ?></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td id="guest3Idtriple3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest3Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkTriple3<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest3remark'] ?></td>
	</tr>
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>
	<!-- triple Room ends -->

				<?php if($listingyes['roomTwin']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px;  padding-left:0px; position:relative;">Room Type: <strong>TWIN</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                           
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                           
  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['roomTwin']; $k++){ 
  
  $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="twin" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="twin",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
									$select12='*';  
									$where12='id='.$hotelQuotData['roomType'].''; 
									$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%" rowspan="2">Room <?php echo $no; ?> </td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1Idtwin1<?php echo $no; ?><?php echo $hotelData['id'];  ?>"> 
	<?php 
		$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'" and contactType=3'); 
		$listsupplier=mysqli_fetch_array($bb);
		 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></td>
    <td rowspan="2"><?php echo $rtype; ?></td>
<td id="remarkTwin1<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest1remark'] ?></td>									
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td style="width: 22%;" id="guest2Idtwin2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
	    $listsupplier=mysqli_fetch_array($bb);
       echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
<td id="remarkTwin2<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest2remark'] ?></td>
    </tr>
  
	
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>
				
				<?php if($listingyes['roomEBedA']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px; position:relative;">Room Type: <strong>Extra Bed Adult</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest </strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                          
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                          
  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['roomEBedA']; $k++){ 
  
  
    $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="EBedAdult" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="EBedAdult",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
									$select12='*';  
									$where12='id='.$hotelQuotData['roomType'].''; 
									$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%">Room <?php echo $no; ?></td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1Idextra1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	 <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
    <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	</td>
    <td><?php echo $rtype ?></td>
									
<td id="remarkExtra<?php echo $no.$hotelData['id'];  ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>

				<!--====================== Quad room starts ================= -->

				<?php if($listingyes['quadNoofRoom']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px; position:relative;">Room Type: <strong>Quad Room</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest </strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                          
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                          
  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['quadNoofRoom']; $k++){ 
  
  
    $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="quadRoom" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="quadRoom",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
									$select12='*';  
									$where12='id='.$hotelQuotData['roomType'].''; 
									$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%" rowspan="4">Room <?php echo $no; ?></td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdquadRoom1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	 <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
    <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	</td>
    <td rowspan="4"><?php echo $rtype ?></td>
									
<td id="remarkQuad<?php echo $no.$hotelData['id'];  ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
  <tr>

    <td width="5%" align="center">2</td>
    <td style="width: 22%;" id="guest2IdquadRoom2<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	 <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
    <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	</td>
									
<td id="remarkQuad2<?php echo $no.$hotelData['id'];  ?>"><?php echo $itshave['guest2remark'] ?></td>
  </tr>
  <tr>
<td width="5%" align="center">3</td>
<td style="width: 22%;" id="guest3IdquadRoom3<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
 <?php 
$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest3Id'].'" and contactType=3'); 
$listsupplier=mysqli_fetch_array($bb);
?>
<?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
</td>
								
<td id="remarkQuad3<?php echo $no.$hotelData['id'];  ?>"><?php echo $itshave['guest3remark'] ?></td>
</tr>
<tr>
<td width="5%" align="center">4</td>
<td style="width: 22%;" id="guest4IdquadRoom4<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
 <?php 
$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest4Id'].'" and contactType=3'); 
$listsupplier=mysqli_fetch_array($bb);
?>
<?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
</td>							
<td id="remarkQuad4<?php echo $no.$hotelData['id'];  ?>"><?php echo $itshave['guest4remark'] ?></td>
</tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>

				

				<!--====================== Quad room ends ================= -->
	<!-- ======================= Teen Room Starts ============================== -->
	
	<?php if($listingyes['teenNoofRoom']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px; position:relative;">Room Type: <strong>Quad Room</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest </strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                          
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                          
  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['teenNoofRoom']; $k++){ 
  
  
    $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="teenRoom" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="teenRoom",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
									$select12='*';  
									$where12='id='.$hotelQuotData['roomType'].''; 
									$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%">Room <?php echo $no; ?></td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdteenRoom1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	 <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
    <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	</td>
    <td><?php echo $rtype ?></td>
									
<td id="remarkTeen<?php echo $no.$hotelData['id'];  ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>

				

	<!-- ======================= Teen Room Ends ============================== -->



				<?php if($listingyes['roomEBedC']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px; position:relative;">Room Type: <strong>Child With Bed</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest </strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                          
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                          
  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['roomEBedC']; $k++){ 
  
  
    $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="CWBed" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="CWBed",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
									$select12='*';  
									$where12='id='.$hotelQuotData['roomType'].''; 
									$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%">Room <?php echo $no; ?></td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdCWBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	<?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
	<?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	</td>
    <td><?php echo $rtype ?></td>
									
<td id="remarkCWBed<?php echo $no.$hotelData['id'];  ?>" ><?php echo $itshave['guest1remark'] ?></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>



				<?php if($listingyes['roomENBedC']>0){ ?>
				<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px; position:relative;">Room Type: <strong>Child Without Bed</strong></div>
				<div style="margin-bottom:20px;"> <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest </strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                          
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                          
  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['roomENBedC']; $k++){ 
  
  
    $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="CNBed" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="CNBed",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

} 
									$select12='*';  
									$where12='id='.$hotelQuotData['roomType'].''; 
									$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%">Room <?php echo $no; ?></td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdCNBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>">
	<?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'" and contactType=3'); 
	$listsupplier=mysqli_fetch_array($bb);
	?>
	<?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	</td>
    <td><?php echo $rtype ?></td>
									
<td id="remarkCNBed<?php echo $no.$hotelData['id'];  ?>" ><?php echo $itshave['guest1remark'] ?></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>	

<!-- ============================= Six Bed Room starts ========================= -->

<?php if($listingyes['sixNoofBedRoom']>0){ ?>
<div style="font-size:15px; font-weight:400; padding:5px;   padding-left:0px; position:relative;">Room Type: <strong>Six Bed Room</strong></div>
<div style="margin-bottom:20px;"> 
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                           
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                           

  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['sixNoofBedRoom']; $k++){ 
  
  
  
  
  
  $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="sixBedRoom" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="sixBedRoom",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

}

		$select12='*';  
		$where12='id='.$hotelQuotData['roomType'].''; 
		$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
		$editresult2=mysqli_fetch_array($rs12);
		$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%" rowspan="6">Room <?php echo $no; ?>   </td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdsixBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'"'); 
			$listsupplier=mysqli_fetch_array($bb);
			?>
            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
            </td>
    <td rowspan="6"><?php echo $rtype; ?></td>
		<td id="remarksixBed1<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td id="guest2IdsixBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
							$listsupplier=mysqli_fetch_array($bb);
							?>
                            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	                </td>
	    <td id="remarksixBed2<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest2remark'] ?></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td id="guest3IdsixBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest3Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarksixBed3<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest3remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">4</td>
    <td id="guest4IdsixBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest4Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarksixBed4<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest4remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">5</td>
    <td id="guest5IdsixBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest5Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarksixBed5<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest5remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">6</td>
    <td id="guest6IdsixBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest6Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarksixBed6<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest6remark'] ?></td>
	</tr>
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>

<!-- ============================= Six Bed Room ends ========================= -->
<!-- ============================= Eight Bed Room starts ========================= -->

<?php if($listingyes['eightNoofBedRoom']>0){ ?>
<div style="font-size:15px; font-weight:400; padding:5px;   padding-left:0px; position:relative;">Room Type: <strong>Eight Bed Room</strong></div>
<div style="margin-bottom:20px;"> 
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                           
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                           

  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['eightNoofBedRoom']; $k++){ 
  
  
  
  
  
  $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="eightBedRoom" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="eightBedRoom",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

}

		$select12='*';  
		$where12='id='.$hotelQuotData['roomType'].''; 
		$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
		$editresult2=mysqli_fetch_array($rs12);
		$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%" rowspan="8">Room <?php echo $no; ?>   </td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdeightBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'"'); 
			$listsupplier=mysqli_fetch_array($bb);
			?>
            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
            </td>
    <td rowspan="8"><?php echo $rtype; ?></td>
		<td id="remarkeightBed1<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td id="guest2IdeightBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
							$listsupplier=mysqli_fetch_array($bb);
							?>
                            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	                </td>
	    <td id="remarkeightBed2<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest2remark'] ?></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td id="guest3IdeightBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest3Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkeightBed3<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest3remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">4</td>
    <td id="guest4IdeightBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest4Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkeightBed4<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest4remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">5</td>
    <td id="guest5IdeightBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest5Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkeightBed5<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest5remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">6</td>
    <td id="guest6IdeightBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest6Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkeightBed6<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest6remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">7</td>
    <td id="guest7IdeightBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest7Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkeightBed7<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest7remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">8</td>
    <td id="guest8IdeightBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest8Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarkeightBed8<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest8remark'] ?></td>
	</tr>
	
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>

<!-- ============================= Eight Bed Room ends ========================= -->
<!-- ============================= Ten Bed Room starts ========================= -->


<?php if($listingyes['tenNoofBedRoom']>0){ ?>
<div style="font-size:15px; font-weight:400; padding:5px;   padding-left:0px; position:relative;">Room Type: <strong>Ten Bed Room</strong></div>
<div style="margin-bottom:20px;"> 
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="font-size:12px;">
  <tr>
    <td width="15%" bgcolor="#F4F4F4"><strong>Room</strong></td>
    <td width="5%" align="center" bgcolor="#F4F4F4"><strong>Pax</strong></td>
    <td bgcolor="#F4F4F4"><strong>Guest</strong></td>
    <td bgcolor="#F4F4F4"><strong>Room Category </strong></td>                           
    <td bgcolor="#F4F4F4"><strong>Remarks</strong></td>                           

  </tr>
  
  <?php
  $no=1;
  for ($k = 0 ; $k < $listingyes['tenNoofBedRoom']; $k++){ 
  
  
  
  
  
  $rshg=GetPageRecord('*','roomingList','queryId='.$_GET['queryId'].' and quotationId="'.$_REQUEST['quotationId'].'" and hotelId="'.$hotelData['id'].'" and roomType="tenBedRoom" and roomNo="'.$no.'"');  
$itshave=mysqli_fetch_array($rshg); 

if($itshave['id']==''){
				
$namevalue ='queryId='.$_GET['queryId'].',quotationId="'.$_REQUEST['quotationId'].'",hotelId="'.$hotelData['id'].'",roomType="tenBedRoom",roomNo="'.$no.'"';   
addlisting('roomingList',$namevalue); 	

}

		$select12='*';  
		$where12='id='.$hotelQuotData['roomType'].''; 
		$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
		$editresult2=mysqli_fetch_array($rs12);
		$rtype=$editresult2['name'];
  ?>
  <tr>
    <td width="15%" rowspan="10">Room <?php echo $no; ?>   </td>
    <td width="5%" align="center">1</td>
    <td style="width: 22%;" id="guest1IdtenBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest1Id'].'"'); 
			$listsupplier=mysqli_fetch_array($bb);
			?>
            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
            </td>
    <td rowspan="10"><?php echo $rtype; ?></td>
		<td id="remarktenBed1<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest1remark'] ?></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td id="guest2IdtenBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"><?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest2Id'].'" and contactType=3'); 
							$listsupplier=mysqli_fetch_array($bb);
							?>
                            <?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
	                </td>
	    <td id="remarktenBed2<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest2remark'] ?></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td id="guest3IdtenBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest3Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed3<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest3remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">4</td>
    <td id="guest4IdtenBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest4Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed4<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest4remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">5</td>
    <td id="guest5IdtenBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest5Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed5<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest5remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">6</td>
    <td id="guest6IdtenBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest6Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed6<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest6remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">7</td>
    <td id="guest7IdtenBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest7Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed7<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest7remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">8</td>
    <td id="guest8IdtenBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest8Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed8<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest8remark'] ?></td>
	</tr>

	<tr>
    <td width="5%" align="center">9</td>
    <td id="guest9IdtenBed9<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest9Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed9<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest9remark'] ?></td>
	</tr>
	<tr>
    <td width="5%" align="center">10</td>
    <td id="guest10IdtenBed10<?php echo $no; ?><?php echo $hotelData['id'];  ?>" ><?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'id= "'.$itshave['guest10Id'].'" and contactType=3'); 
						$listsupplier=mysqli_fetch_array($bb); 

						 echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?>
    </td>
	<td id="remarktenBed10<?php echo $no.$hotelData['id']; ?>"><?php echo $itshave['guest10remark'] ?></td>
	</tr>
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>

<!-- ============================= Ten Bed Room ends ========================= -->


</td>
			
				<style>
					@media print {
						#singleremarkhide{
							display: none !important;
						}
						#singleremarkid{
							display: block !important;
							padding: 7px !important;
						}
                        #loadprintablefile{
                            display: block !important;
                        }
						
					}
					@page{
						size: 'A4';  

						margin: 10px !important;
					}
				</style>

				
				<?php
				 $hotelNo++; } ?>


 

					</tbody>

</table>
</div>

<div id="savechageId" style="background-color: #F7F7F7; padding: 5px; border: 1px solid #e5e5e5; margin-bottom:10px; margin-top:0px; margin-bottom:20px; margin-top: -10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td> <input type="button" style="cursor: pointer;" value="Save Changes" onclick="savechanges();" ></td>
    <td width="50%" align="right"><input type="button" name="Submit" value="Print"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding: 5px 15px; font-size: 15px;" onclick="printDiv('printableArea<?php echo strip($resultpage['id']); ?>')" class="a" /></td>
  </tr>
</table>
</div>
<style>
		@media print{    

    button{
        display: none !important;
    }
    html, body {
    height:auto; 
    margin: 0 !important; 
    padding: 0 !important;
    overflow: auto;
  }
  #savechageId{
      display: none !important;
  }

}

	@page {

    size: auto;  
    margin: 30px !important; 
	page-break-after: always;
}
</style>

<div style="display:none;" id="saveroomlisting"></div>

<script>

 function updateRoomRemark(hotelId,roomType,roomNo,fieldid,pax){
	var guestremark1 = $('#remark'+fieldid).val();
	$('#saveroomlisting').load('saveroomlisting.php?action=updateguestRemark&queryId=<?php echo ($_GET['queryId']); ?>&quotationId=<?php echo $QueryDaysData['id']; ?>&hotelId='+hotelId+'&roomType='+roomType+'&roomNo='+roomNo+'&guestremark1='+encodeURI(guestremark1)+'&pax='+pax);
 }


function savefinalqt(hotelId,roomType,roomNo,fieldid,pax,roomName){
	
	var guest1Gender = $('#guest1Gender'+fieldid).val();
	var guest1Id = $('#guest1Id'+fieldid).val();
	var guest2Gender = $('#guest2Gender'+fieldid).val();
	var guest2Id = $('#guest2Id'+fieldid).val();
	var guest3Gender = $('#guest3Gender'+fieldid).val();
	var guest3Id = $('#guest3Id'+fieldid).val();
	var guest4Gender = $('#guest4Gender'+fieldid).val();
	var guest4Id = $('#guest4Id'+fieldid).val(); 
	 
	
	$('#saveroomlisting').load('saveroomlisting.php?action=saveguestlist&queryId=<?php echo ($_GET['queryId']); ?>&quotationId=<?php echo $QueryDaysData['id']; ?>&hotelId='+hotelId+'&roomType='+roomType+'&roomNo='+roomNo+'&guest1Gender='+guest1Gender+'&guest1Id='+guest1Id+'&guest2Gender='+guest2Gender+'&guest2Id='+guest2Id+'&guest3Gender='+guest3Gender+'&guest3Id='+guest3Id+'&guest4Gender='+guest4Gender+'&guest4Id='+guest4Id+'&pax='+pax+'&roomTypeName='+encodeURI(roomName)); 

	// $('#guest1Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest1Id); 
	// $('#guest1Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest1Id); 
	
	// $('#guest2Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest2Id); 
	// $('#guest2Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest2Id); 
	
	// $('#guest3Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest3Id); 
	// $('#guest3Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest3Id); 
	
	// $('#guest4Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest4Id); 
	// $('#guest4Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest4Id); 
	
}

function printDiv(divName) {

 $('#printableArea<?php echo strip($resultpage['id']); ?>').load('loadupdateroomwiseguest.php?queryId=<?php echo $_REQUEST['queryId']; ?>&quotationId=<?php echo $_REQUEST['quotationId']; ?>');

var printContents = document.getElementById(divName).innerHTML;

var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;

window.print();

document.body.innerHTML = originalContents;
location.reload();
}

function savechanges(){
	alert("Data Saved!");
	// location.reload();
	$("#saveroomlisting").load('loadupdateroomwiseguest.php?queryId=<?php echo $resultpage['id']; ?>&quotationId=<?php echo $_REQUEST['quotationId']; ?>');
}
</script>
