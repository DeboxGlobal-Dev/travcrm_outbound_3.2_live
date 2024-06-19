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
<!-- <div id='printableArea<?php echo strip($resultpage['id']); ?>'> -->
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">			
	<?php 
	// $hotelNo = 1;
	$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$QueryDaysData['id'].'" '.$singQuery.' order by fromDate asc ');  
	while($hotelQuotData=mysqli_fetch_array($b)){ 
	
		$rsh=GetPageRecord('*','finalQuote',' quotationId="'.clean($QueryDaysData['id']).'" and hotelQuotationId="'.$hotelQuotData['id'].'" order by id desc LIMIT 1');  
		$listingyes=mysqli_fetch_array($rsh); 
		
		$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
		$hotelData=mysqli_fetch_array($d);
			
		$hotelCatQuery=GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' id='.$hotelData['hotelCategoryId'].' order by hotelCategory asc'); 
		$hotelCategoryData=mysqli_fetch_array($hotelCatQuery);

		// $getguestid=GetPageRecord('*','roomingList',' id!="" and roomType!="" '); 
		// $hotelCategoryData=mysqli_fetch_array($hotelCatQuery);
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
				<div style="font-size:15px; font-weight:400; padding:5px;   padding-left:0px;position:relative;">Room Type: <strong>Single</strong></div>
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
    <td style="width: 22%;">
	
	<select id="guest1Idsingle1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" name="guestIdsingle"  class="select2" style="width:100%; padding:8px;"  onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','single','<?php echo $no; ?>','single1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');"> 
	<option value="0" >Select</option> 
	<?php 
	$bbsingle=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsuppliersingle=mysqli_fetch_array($bbsingle)){ 
	?>
	<option value="<?php echo $listsuppliersingle['id']; ?>" <?php if($itshave['guest1Id']==$listsuppliersingle['id']){ ?> selected="selected" <?php } ?>><?php echo $listsuppliersingle['firstName'].' '.$listsuppliersingle['middleName'].' '.$listsuppliersingle['lastName']; ?></option> 
	<?php } ?>
	</select>
	
	</td>	
    <td><?php echo $rtype ?></td>

<td id="singleremarkhide"><input type="text" placeholder="Remarks" name="remarkSingle" id="remarkSingle1<?php echo $no.$hotelData['id']; ?>" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','single','<?php echo $no; ?>','Single1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" style="width: 96%; padding: 7px;" value="<?php echo $itshave['guest1remark']; ?>" ></td>

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
	
    <td><select class="select2" style="width:100%; padding:8px;" id="guest1Iddouble1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" name="guestIddouble" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','double','<?php echo $no; ?>','double1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
    <td rowspan="2"><?php echo $rtype ?></td>
		<td><input type="text" placeholder="Remarks" value="<?php echo $itshave['guest1remark']; ?>" name="remarkDouble" id="remarkDouble1<?php echo $no.$hotelData['id']; ?>" style="width: 96%; padding: 7px;" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','double','<?php echo $no; ?>','Double1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');"></td>
									
  </tr>
  <tr>
    <td width="5%" align="center">2</td>
     <td style="width: 22%;"><select   class="select2" style="width:100%; padding:8px;"  id="guest2Iddouble2<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','double','<?php echo $no; ?>','double2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" value="<?php echo $itshave['guest2remark']; ?>" name="remarks" id="remarkDouble2<?php echo $no.$hotelData['id']; ?>" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','double','<?php echo $no; ?>','Double2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" style="width: 96%; padding: 7px;"></td>
    </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>
				<!-- ============================ Triple Room Starts ============================= -->

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
    <td style="width: 22%;"><select   class="select2" style="width:100%; padding:8px;"  id="guest1Idtriple1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tripple','<?php echo $no; ?>','triple1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
			while($listsupplier=mysqli_fetch_array($bb)){ 
			?>
			<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
			<?php } ?>
    </select></td>
    <td rowspan="3"><?php echo $rtype; ?></td>
		<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tripple','<?php echo $no; ?>','Triple1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');" id="remarkTriple1<?php echo $no.$hotelData['id']; ?>" style="width: 96%; padding: 7px;" value="<?php echo $itshave['guest1remark'] ?>" ></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest2Idtriple2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"   onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tripple','<?php echo $no; ?>','triple2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
							while($listsupplier=mysqli_fetch_array($bb)){ 
							?>
							<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
							<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tripple','<?php echo $no; ?>','Triple2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" id="remarkTriple2<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest2remark'] ?>" style="width: 96%; padding: 7px;"></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest3Idtriple3<?php echo $no; ?><?php echo $hotelData['id'];  ?>"   onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tripple','<?php echo $no; ?>','triple3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest3Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tripple','<?php echo $no; ?>','Triple3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3');" id="remarkTriple3<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest3remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
  
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>
<!-- ============================ Triple Room ends ============================== -->
				
<!-- Twin room starts -->

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
    <td style="width: 22%;"><select   class="select2"   style="width:100%; padding:8px;"  id="guest1Idtwin1<?php echo $no; ?><?php echo $hotelData['id'];  ?>"  onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','twin','<?php echo $no; ?>','twin1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   
	<?php 
		$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
		while($listsupplier=mysqli_fetch_array($bb)){ 
		?>
		<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
		<?php } ?>
    </select></td>
    <td rowspan="2"><?php echo $rtype; ?></td>
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','double','<?php echo $no; ?>','Twin1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" id="remarkTwin1<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest1remark'] ?>" style="width: 96%; padding: 7px;"></td>									
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td style="width: 22%;"><select   class="select2"   style="width:100%; padding:8px;"  id="guest2Idtwin2<?php echo $no; ?><?php echo $hotelData['id'];  ?>"  onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','twin','<?php echo $no; ?>','twin2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','double','<?php echo $no; ?>','Twin2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" id="remarkTwin2<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest2remark'] ?>" style="width: 96%; padding: 7px;"></td>
    </tr>
  
	
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>
				<!-- ==================== Extra Bed Adult Starts ==================== -->
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
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest1IdEBedAdult1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','EBedAdult','<?php echo $no; ?>','EBedAdult1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
    <td><?php echo $rtype ?></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','EBedAdult','<?php echo $no; ?>','Extra<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" id="remarkExtra<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest1remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>

					<!-- ==================== Quad Room Starts ==================== -->
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
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest1IdquadRoom1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','quadRoom1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
    <td rowspan="4"><?php echo $rtype ?></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','Quad1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" id="remarkQuad1<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest1remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <tr>
    
    <td width="5%" align="center">2</td>
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest2IdquadRoom2<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','quadRoom2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','Quad2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" id="remarkQuad2<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest2remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <tr>
    
    <td width="5%" align="center">3</td>
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest3IdquadRoom3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','quadRoom3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest3Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','Quad3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3');" id="remarkQuad3<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest3remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <tr>
    
    <td width="5%" align="center">4</td>
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest4IdquadRoom4<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','quadRoom4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest4Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','quadRoom','<?php echo $no; ?>','Quad4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4');" id="remarkQuad4<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest4remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>

<!-- quad room ends -->

			<!-- ======================= Teen Room Starts =========================== -->

			<?php if($listingyes['teenNoofRoom']>0){ ?>
		<div style="font-size:15px; font-weight:400; padding:5px; padding-left:0px; position:relative;">Room Type: <strong>Teen Room</strong></div>
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
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest1IdteenRoom1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','teenRoom','<?php echo $no; ?>','teenRoom1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
    <td><?php echo $rtype ?></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','teenRoom','<?php echo $no; ?>','Teen<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" id="remarkTeen<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest1remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>

			<!-- ======================= Teen Room Ends =========================== -->
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
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest1IdCWBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','CWBed','<?php echo $no; ?>','CWBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
    <td><?php echo $rtype ?></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','CWBed','<?php echo $no; ?>','CWBed<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" id="remarkCWBed<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest1remark'] ?>" style="width: 96%; padding: 7px;"></td>
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
    <td style="width: 22%;">
	<select   class="select2" style="width:100%; padding:8px;"  id="guest1IdCNBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','CNBed','<?php echo $no; ?>','CNBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype ?>');">
    <option value="0" >Select</option>   <?php 
	$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
	while($listsupplier=mysqli_fetch_array($bb)){ 
	?>
	<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
	<?php } ?>
    </select></td>
    <td><?php echo $rtype ?></td>
									
<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','CNBed','<?php echo $no; ?>','CNBed<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1');" id="remarkCNBed<?php echo $no.$hotelData['id'];  ?>" value="<?php echo $itshave['guest1remark'] ?>" style="width: 96%; padding: 7px;"></td>
  </tr>
  <?php $no++; } ?>
  
</table> 
				</div>
				<?php } ?>	
				
	<!-- ========================= Extra Child No Bed Ends ============================ -->

	<!--========================== Six Bed Rooms Start =========================== -->

					
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
    <td style="width: 22%;"><select   class="select2" style="width:100%; padding:8px;"  id="guest1IdsixBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
			while($listsupplier=mysqli_fetch_array($bb)){ 
			?>
			<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
			<?php } ?>
    </select></td>
    <td rowspan="6"><?php echo $rtype; ?></td>
		<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');" id="remarksixBed1<?php echo $no.$hotelData['id']; ?>" style="width: 96%; padding: 7px;" value="<?php echo $itshave['guest1remark'] ?>" ></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest2IdsixBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
							while($listsupplier=mysqli_fetch_array($bb)){ 
							?>
							<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
							<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" id="remarksixBed2<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest2remark'] ?>" style="width: 96%; padding: 7px;"></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest3IdsixBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest3Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3');" id="remarksixBed3<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest3remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
	<tr>
    <td width="5%" align="center">4</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest4IdsixBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>"   onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest4Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4');" id="remarksixBed4<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest4remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">5</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest5IdsixBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>','5','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest5Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>','5');" id="remarksixBed5<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest5remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
	<tr>
    <td width="5%" align="center">6</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest6IdsixBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>','6','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest6Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','sixBedRoom','<?php echo $no; ?>','sixBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>','6');" id="remarksixBed6<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest6remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
  
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>

	<!--========================== Six Bed Rooms Ends =========================== -->
	<!--========================== Eight Bed Rooms Starts =========================== -->
			
						
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
    <td style="width: 22%;"><select   class="select2" style="width:100%; padding:8px;"  id="guest1IdeightBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
			while($listsupplier=mysqli_fetch_array($bb)){ 
			?>
			<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
			<?php } ?>
    </select></td>
    <td rowspan="8"><?php echo $rtype; ?></td>
		<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');" id="remarkeightBed1<?php echo $no.$hotelData['id']; ?>" style="width: 96%; padding: 7px;" value="<?php echo $itshave['guest1remark'] ?>" ></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest2IdeightBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
							while($listsupplier=mysqli_fetch_array($bb)){ 
							?>
							<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
							<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" id="remarkeightBed2<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest2remark'] ?>" style="width: 96%; padding: 7px;"></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest3IdeightBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest3Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3');" id="remarkeightBed3<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest3remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
	<tr>
    <td width="5%" align="center">4</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest4IdeightBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest4Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4');" id="remarkeightBed4<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest4remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">5</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest5IdeightBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>','5','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest5Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>','5');" id="remarkeightBed5<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest5remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
	<tr>
    <td width="5%" align="center">6</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest6IdeightBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>','6','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest6Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>','6');" id="remarkeightBed6<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest6remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">7</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest7IdeightBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>','7','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest7Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>','7');" id="remarkeightBed7<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest7remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">8</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest8IdeightBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>','8','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest8Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','eightBedRoom','<?php echo $no; ?>','eightBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>','8');" id="remarkeightBed8<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest8remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
  
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>

	<!--========================== Eight Bed Rooms Ends =========================== -->
	<!--========================== Ten Bed Rooms Starts =========================== -->

							
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
    <td style="width: 22%;"><select   class="select2" style="width:100%; padding:8px;"  id="guest1IdtenBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
			$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
			while($listsupplier=mysqli_fetch_array($bb)){ 
			?>
			<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest1Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
			<?php } ?>
    </select></td>
    <td rowspan="10"><?php echo $rtype; ?></td>
		<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed1<?php echo $no; ?><?php echo $hotelData['id'];  ?>','1','<?php echo $rtype; ?>');" id="remarktenBed1<?php echo $no.$hotelData['id']; ?>" style="width: 96%; padding: 7px;" value="<?php echo $itshave['guest1remark'] ?>" ></td>
  </tr>
   <tr>
    <td width="5%" align="center">2</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest2IdtenBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
							$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
							while($listsupplier=mysqli_fetch_array($bb)){ 
							?>
							<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest2Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
							<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed2<?php echo $no; ?><?php echo $hotelData['id'];  ?>','2');" id="remarktenBed2<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest2remark'] ?>" style="width: 96%; padding: 7px;"></td>
    </tr>
    <tr>
    <td width="5%" align="center">3</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest3IdtenBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest3Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed3<?php echo $no; ?><?php echo $hotelData['id'];  ?>','3');" id="remarktenBed3<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest3remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
	<tr>
    <td width="5%" align="center">4</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest4IdtenBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest4Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed4<?php echo $no; ?><?php echo $hotelData['id'];  ?>','4');" id="remarktenBed4<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest4remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">5</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest5IdtenBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>','5','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest5Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed5<?php echo $no; ?><?php echo $hotelData['id'];  ?>','5');" id="remarktenBed5<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest5remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
	<tr>
    <td width="5%" align="center">6</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest6IdtenBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>','6','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest6Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed6<?php echo $no; ?><?php echo $hotelData['id'];  ?>','6');" id="remarktenBed6<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest6remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">7</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest7IdtenBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>','7','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest7Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed7<?php echo $no; ?><?php echo $hotelData['id'];  ?>','7');" id="remarktenBed7<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest7remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">8</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest8IdtenBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>','8','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest8Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed8<?php echo $no; ?><?php echo $hotelData['id'];  ?>','8');" id="remarktenBed8<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest8remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">9</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest9IdtenBed9<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed9<?php echo $no; ?><?php echo $hotelData['id'];  ?>','9','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest9Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed9<?php echo $no; ?><?php echo $hotelData['id'];  ?>','9');" id="remarktenBed9<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest9remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>

	<tr>
    <td width="5%" align="center">10</td>
    <td><select   class="select2"   style="width:100%; padding:8px;"  id="guest10IdtenBed10<?php echo $no; ?><?php echo $hotelData['id'];  ?>" onchange="savefinalqt('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed10<?php echo $no; ?><?php echo $hotelData['id'];  ?>','10','<?php echo $rtype; ?>');">
    <option value="0" >Select</option>   <?php 
						$bb=GetPageRecord('*',_CONTACT_MASTER_,'queryId2= "'.$resultpage['id'].'" and contactType=3'); 
						while($listsupplier=mysqli_fetch_array($bb)){ 
						?>
						<option value="<?php echo $listsupplier['id']; ?>" <?php if($itshave['guest10Id']==$listsupplier['id']){ ?> selected="selected"<?php } ?>><?php echo $listsupplier['firstName'].' '.$listsupplier['middleName'].' '.$listsupplier['lastName']; ?></option> 
						<?php } ?>
    </select></td>
	<td><input type="text" placeholder="Remarks" name="remarks" onchange="updateRoomRemark('<?php echo $hotelData['id'];  ?>','tenBedRoom','<?php echo $no; ?>','tenBed10<?php echo $no; ?><?php echo $hotelData['id'];  ?>','10');" id="remarktenBed10<?php echo $no.$hotelData['id']; ?>" value="<?php echo $itshave['guest10remark'] ?>" style="width: 96%; padding: 7px;"></td>
	</tr>
    
  
  <?php $no++; } ?>
  
</table> 
</div>
<?php } ?>

	<!--========================== Ten Bed Rooms Ends =========================== -->

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
					}
				</style>

				
				<?php
				 $hotelNo++; } ?>


 

					</tbody>

</table>
</div>

<div id="savechageId" style="background-color: #F7F7F7; padding: 5px; border: 1px solid #e5e5e5; margin-bottom:10px; margin-top:0px; margin-bottom:20px; margin-top: -10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	  <td>
	  </tr>
		<td > <input type="button" style="cursor: pointer;" value="Save Changes" onclick="savechanges();" ></td>
	  </td>
    <td width="50%" align="right"><input type="button" name="Submit" value="Print" style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding: 5px 15px; font-size: 15px;" onclick="printDiv('printableArea<?php echo strip($resultpage['id']); ?>')" class="a" /></td>
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
  #loadprintablefile{
	  display: block !important;
		margin: 20px !important;
  }
  #savechageId{
	  display: none !important;
  }

}

	@page {

    size: auto;  

    margin: 0;

}
</style>

<div style="display:none;" id="saveroomlisting"></div>
<div id="printableArea<?php echo strip($resultpage['id']); ?>" style="display:none;"></div>

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
	var guest5Gender = $('#guest5Gender'+fieldid).val();
	var guest5Id = $('#guest5Id'+fieldid).val(); 
	var guest6Gender = $('#guest6Gender'+fieldid).val();
	var guest6Id = $('#guest6Id'+fieldid).val(); 
	var guest7Gender = $('#guest7Gender'+fieldid).val();
	var guest7Id = $('#guest7Id'+fieldid).val(); 
	var guest8Gender = $('#guest8Gender'+fieldid).val();
	var guest8Id = $('#guest8Id'+fieldid).val(); 
	var guest9Gender = $('#guest9Gender'+fieldid).val();
	var guest9Id = $('#guest9Id'+fieldid).val(); 
	var guest10Gender = $('#guest10Gender'+fieldid).val();
	var guest10Id = $('#guest10Id'+fieldid).val(); 
	 
	
	$('#saveroomlisting').load('saveroomlisting.php?action=saveguestlist&queryId=<?php echo ($_GET['queryId']); ?>&quotationId=<?php echo $QueryDaysData['id']; ?>&hotelId='+hotelId+'&roomType='+roomType+'&roomNo='+roomNo+'&guest1Gender='+guest1Gender+'&guest1Id='+guest1Id+'&guest2Gender='+guest2Gender+'&guest2Id='+guest2Id+'&guest3Gender='+guest3Gender+'&guest3Id='+guest3Id+'&guest4Gender='+guest4Gender+'&guest4Id='+guest4Id+'&pax='+pax+'&roomTypeName='+encodeURI(roomName)+'&guest5Id='+guest5Id+'&guest6Id='+guest6Id+'&guest7Id='+guest7Id+'&guest8Id='+guest8Id+'&guest9Id='+guest9Id+'&guest10Id='+guest10Id); 

	// $('#guest1Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest1Id); 
	// $('#guest1Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest1Id); 
	
	// $('#guest2Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest2Id); 
	// $('#guest2Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest2Id); 
	
	// $('#guest3Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest3Id); 
	// $('#guest3Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest3Id); 
	
	// $('#guest4Id'+fieldid+'meal').load('loadroomingpreference.php?action=loadrooming_mealpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest4Id); 
	// $('#guest4Id'+fieldid+'sc').load('loadroomingpreference.php?action=loadrooming_physConpreference&queryId=<?php echo ($_GET['queryId']); ?>&guestId='+guest4Id); 
	
	$('#printableArea<?php echo strip($resultpage['id']); ?>').load('loadupdateroomwiseguest.php?queryId=<?php echo $_REQUEST['queryId']; ?>&quotationId=<?php echo $_REQUEST['quotationId']; ?>');
}

$('#printableArea<?php echo strip($resultpage['id']); ?>').load('loadupdateroomwiseguest.php?queryId=<?php echo $resultpage['id']; ?>&quotationId=<?php echo $_REQUEST['quotationId']; ?>');

function printDiv(divName){
$("#printableArea<?php echo strip($resultpage['id']); ?>").show();

var printContents = document.getElementById(divName).innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();
document.body.innerHTML = originalContents;
location.reload();
}

function savechanges(){

	$("#saveroomlisting").load('loadupdateroomwiseguest.php?queryId=<?php echo $resultpage['id']; ?>&quotationId=<?php echo $_REQUEST['quotationId']; ?>');
}
</script>
