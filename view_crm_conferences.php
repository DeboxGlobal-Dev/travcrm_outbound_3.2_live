<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
 

if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.' '; 
$rs1=GetPageRecord($select1,'conferencesMaster',$where1); 
$resultlists=mysqli_fetch_array($rs1); 
 
 
 } 
 
 if($_REQUEST['did']!=''){
 $sql_del="delete from conferencesPagesMaster where id='".decode($_GET['did'])."'"; 
 mysqli_query($sql_del) or die(mysqli_error());
 }
 
 
 
  if($_REQUEST['rdid']!=''){
 $sql_del="delete from conferencesFee where id='".decode($_GET['rdid'])."'"; 
 mysqli_query($sql_del) or die(mysqli_error());
 }
 
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<div style="margin-top:60px; padding:20px;">

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><?php echo strip($resultlists['name']); ?></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td> </td>
         
        <td style="padding-right:20px;"><a href="showpage.crm?module=conferences"><input type="button" name="Submit2" value="Back" class="whitembutton"   /></a></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div class="contabs">
<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>" <?php if($_REQUEST['sec']==''){ ?>class="active"<?php } ?>>CONFERENCES DETAILS</a> 

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=2" <?php if($_REQUEST['sec']=='2'){ ?>class="active"<?php } ?>>CONFERENCES PAGES</a>

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=3" <?php if($_REQUEST['sec']=='3'){ ?>class="active"<?php } ?>>ABSTRACT</a>

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=4"  <?php if($_REQUEST['sec']=='4'){ ?>class="active"<?php } ?>>REGISTRATION FEE</a>

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=5" <?php if($_REQUEST['sec']=='5'){ ?>class="active"<?php } ?>>REGISTRATION</a>

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=6" <?php if($_REQUEST['sec']=='6'){ ?>class="active"<?php } ?>>HOTEL</a>

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=7" <?php if($_REQUEST['sec']=='7'){ ?>class="active"<?php } ?>>CAR</a>

<a href="showpage.crm?module=conferences&view=yes&id=<?php echo $_REQUEST['id']; ?>&sec=8" <?php if($_REQUEST['sec']=='8'){ ?>class="active"<?php } ?>>AIRLINE</a>
</div>


 <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
  <tr>
    <td align="left" valign="top" width="60%">	</td>
    <td width="40%" align="left" valign="top" style="padding-left:20px;">		</td>
  </tr>
 <?php if($_REQUEST['sec']==''){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase;">Conferences Details</div>
	<div style="padding:20px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><div style="padding:5px; border:1px solid #ccc; background-color:#FFFFFF;"><img src="<?php if($resultlists['logo']!=''){ ?>upload/<?php echo $resultlists['logo']; ?><?php } else { ?>images/nologo.jpg<?php } ?>" width="120"  ></div></td>
    <td width="87%" align="left" valign="top" style="padding-left:20px; position:relative; "><a href="showpage.crm?module=conferences&add=yes&id=<?php echo encode($resultlists['id']); ?>" style="font-size:25px;color: #ff430d; position:absolute; right:0px; top:0px;"><i class="fa fa-pencil-square" aria-hidden="true" ></i></a><h2 style="font-weight:500;"><?php echo strip($resultlists['name']); ?></h2>
	<div style="font-size:13px; margin-top:10px;"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('j, F Y',strtotime($resultlists['startDate'])); ?> to <?php echo date('j, F Y',strtotime($resultlists['endDate'])); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $resultlists['cDuration']; ?> Days&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo getDestination($resultlists['cityId']); ?></div>
	
	<div style="font-size:13px; margin-top:10px;"><span style="font-weight:500;">Address:</span>  <?php echo $resultlists['address']; ?></div>	</td>
  </tr>
</table>
	</div>
	</div>
	
	<div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase;">Import CONFERENCES Days plan (Agenda)</div>
	<div style="padding:10px; background-color:#F1FFE6; border:1px solid #339900; font-weight:500; font-size:13px; color:#006600; display:none;" id="changessaved"><i class="fa fa-check" aria-hidden="true"></i> Changes Saved </div>
	
	 

	  
	<div style="padding:10px; background-color:#F4F4F4; text-align:left;">
	
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="aaa" target="actoinfrm" id="aaa">
	<table border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2"><label>
      <input name="importfield" type="file" id="importfield" />
      <input name="action" type="hidden" id="action" value="uploaddaywiseplan" />
      <input name="cid" type="hidden" id="cid" value="<?php echo $id; ?>" />
    </label></td>
    <td><input name="addnewuserbtn" type="submit" class="bluembutton submitbtn" id="addnewuserbtn" value="Upload" style="    border-radius: 4px;  "   ></td>
    <td>&nbsp;&nbsp;</td>
    <td><a href="CONFERENCE-DAYS-PLAN.xls" target="_blank">Download Format</a> </td>
  </tr>
</table>
</form>
	</div>
	</div>
	
	<div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase;">CONFERENCES Days plan</div>
	<div style="padding:10px; background-color:#F1FFE6; border:1px solid #339900; font-weight:500; font-size:13px; color:#006600; display:none;" id="changessaved"><i class="fa fa-check" aria-hidden="true"></i> Changes Saved </div>
	
	 

	  
	<div style="padding:10px; background-color:#F4F4F4; text-align:left;">
	<div style="width:100%; max-width:100%; overflow:auto; max-height:400px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" style="padding-bottom:10px;" >Session </th>

     <th align="left" class="header"style="padding-bottom:10px;" >Hall </th>

     <th align="left" class="header"style="padding-bottom:10px;" >Date</th>
     <th align="left" class="header"style="padding-bottom:10px;" >TIME</th>
     <th align="left" class="header"style="padding-bottom:10px;" >TOPIC</th>
     <th align="left" class="header"style="padding-bottom:10px;" >SPEAKER</th>
     <th align="left" class="header"style="padding-bottom:10px;" >CHAIRPERSON</th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php
 $select='';  
$where='';  
$rs='';   
$select='*';    
$where=' cid='.$id.' order by dayDate asc';   
$rs=GetPageRecord($select,'confrenceDays',$where);  
while($resListing=mysqli_fetch_array($rs)){  
?>
  <tr>
    <td align="left"><?php echo stripslashes($resListing['sessionList']); ?></td>

    <td align="left"><?php echo stripslashes($resListing['hall']); ?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($resListing['dayDate'])); ?></td>
    <td align="left"><?php echo stripslashes($resListing['dayTime']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['topic']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['speaker']); ?></td>
    <td align="left"><?php echo stripslashes($resListing['chairpersonName']); ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
	</div>
	</div>
	</div>	</td>
    </tr><?php } ?>
 <?php if($_REQUEST['sec']=='2'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">Conferences Pages <div style="padding:10px 20px; color:#FFFFFF; background-color:#009900; color:#FFFFFF; font-weight:500; position:absolute; right:0px; top:0px; cursor:pointer;" onclick="alertspopupopen('action=addconferencespages&cid=<?php echo strip($resultlists['id']); ?>','700px','auto');"><i class="fa fa-plus" aria-hidden="true"></i> Add New Page</div></div>
	<div style="padding:20px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	
	<div style="padding:15px; background-color:#F2F8FF; border:1px solid #B7DEFF;  font-size:14px; margin-bottom:10px;"><strong style="font-weight:500;">Page:</strong> <a href="<?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/home.html" target="_blank" style="color:#0066CC !important;"><?php echo $fullurl; ?>confrence/<?php echo encode($resultlists['id']); ?>/home.html</a></div>
	
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="pagessave" target="actoinfrm" id="pagessave">
	<ul class="slides">
	<?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and cid='.$resultlists['id'].' and parentPage=0 order by sr asc';  
		$rs=GetPageRecord($select,'conferencesPagesMaster',$where); 
		while($resListing=mysqli_fetch_array($rs)){  
		?>
	<li class="slide"><div  style="    margin-bottom: 10px; cursor:move;
    padding: 10px;
    font-size: 16px;
    position: relative;
    padding-left: 40px;
    padding-right: 40px;
    font-weight: 500;
    background-color: #fff;
    border-radius: 4px;
    border: 1px solid #cccccc80;  "><i class="fa fa-file-text" aria-hidden="true" style="position: absolute;
    left: 0px;
    color: #CCCCCC;
    font-size: 21px;
    left: 10px;"></i> <?php echo strip($resListing['name']); ?> 
	
	<a  href="#" onclick="alertspopupopen('action=addconferencespages&cid=<?php echo strip($resultlists['id']); ?>&id=<?php echo strip($resListing['id']); ?>','700px','auto');" style="    position: absolute; 
    color: #ec2121;
    font-size: 21px;
    right: 35px; z-index:9;">
	<i class="fa fa-pencil-square" aria-hidden="true" style="color:#009900;"   ></i>	</a>
	
	
	<a onclick="return confirm('Are you sure you want to delete this page?');" href="showpage.crm?module=conferences&view=yes&did=<?php echo encode($resListing['id']); ?>&id=<?php echo $_REQUEST['id']; ?>" style="    position: absolute; 
    color: #ec2121;
    font-size: 21px;
    right: 10px; z-index:9;">
	<i class="fa fa-trash" aria-hidden="true" style="color:#CC3300;"   ></i>	</a>
	</div><input   type="hidden" value="<?php echo strip($resListing['id']); ?>" id="mm<?php echo $no; ?>" name="check_listmenu[]"  /></li>
	
	<?php 
	 
		$select3='*';    
		$where3=' 1 and cid='.$resultlists['id'].' and parentPage='.$resListing['id'].' order by sr asc';  
		$rs3=GetPageRecord($select3,'conferencesPagesMaster',$where3); 
		while($resListing3=mysqli_fetch_array($rs3)){  
		?>
	<li class="slide"><div  style="    margin-bottom: 10px; cursor:move;
    padding: 10px;
    font-size: 16px;
    position: relative;
    padding-left: 40px;
    padding-right: 40px;
    font-weight: 500;
    background-color: #fff;
    border-radius: 4px;
    border: 1px solid #cccccc80;    margin-left: 40px;
    border-left: 2px #06b362 solid; "><i class="fa fa-file-text" aria-hidden="true" style="position: absolute;
    left: 0px;
    color: #CCCCCC;
    font-size: 21px;
    left: 10px;"></i> <?php echo strip($resListing3['name']); ?> 
	
	<a  href="#" onclick="alertspopupopen('action=addconferencespages&cid=<?php echo strip($resultlists['id']); ?>&id=<?php echo strip($resListing3['id']); ?>','700px','auto');" style="    position: absolute; 
    color: #ec2121;
    font-size: 21px;
    right: 35px; z-index:9;">
	<i class="fa fa-pencil-square" aria-hidden="true" style="color:#009900;"   ></i>	</a>
	
	
	<a onclick="return confirm('Are you sure you want to delete this page?');" href="showpage.crm?module=conferences&view=yes&did=<?php echo encode($resListing3['id']); ?>&id=<?php echo $_REQUEST['id']; ?>&sec=2" style="    position: absolute; 
    color: #ec2121;
    font-size: 21px;
    right: 10px; z-index:9;">
	<i class="fa fa-trash" aria-hidden="true" style="color:#CC3300;"   ></i>	</a>
	</div><input   type="hidden" value="<?php echo strip($resListing3['id']); ?>" id="mm<?php echo $no; ?>" name="check_listmenu[]"  /></li>
	
	<?php } ?>
	
	
	<?php } ?>
	</ul>
	
	<input   type="hidden" value="setpageing" id="action" name="action"  />
	</form>
	</div>
	
	</div></td>
  </tr><?php } ?>
 <?php if($_REQUEST['sec']=='3'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">Abstract  </div>
	<div style="padding:5px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="50%" bgcolor="#F0F0F0"><strong>Name of presenting author</strong></td>
    <td width="10%" align="center" bgcolor="#F0F0F0"><strong>Date</strong></td>
    <td width="10%" align="center" bgcolor="#F0F0F0"><strong>Oral</strong></td>
    <td width="10%" align="center" bgcolor="#F0F0F0"><strong>Video</strong></td>
    <td width="10%" align="center" bgcolor="#F0F0F0"><strong>Poster</strong></td>
    <td width="10%" align="center" bgcolor="#F0F0F0"><strong>Reject</strong></td>
  </tr>
  <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and cid='.$resultlists['id'].' order by 	addDate desc';  
		$rs=GetPageRecord($select,'conferencesAbstractForm',$where); 
		while($listofabstract=mysqli_fetch_array($rs)){  
		?>
  <tr>
 
    <td width="50%"><div  onclick="alertspopupopen('action=showabstractsubmit&id=<?php echo $listofabstract['id']; ?>','800px','auto');" style="color:#333333 !important; cursor:pointer;"><?php echo $listofabstract['nameOfPerson']; ?></div></td>
    <td width="10%" align="center"><?php echo date('d/m/Y',strtotime($listofabstract['addDate'])); ?></td>
    <td width="10%" align="center" <?php if($listofabstract['typeOfPersentation']=='Oral - Original study/ Case Presentation'){ ?>style="background-color:#DEFFBF"<?php } ?>><input name="oral<?php echo $listofabstract['id']; ?>" type="checkbox" id="oral<?php echo $listofabstract['id']; ?>" onclick="changeabstractstatus('<?php echo $listofabstract['id']; ?>');" style="display: block;" value="checkbox" <?php if($listofabstract['oral']=='1'){ ?>checked="checked"<?php } ?> /></td>
    <td width="10%" align="center" <?php if($listofabstract['typeOfPersentation']=='Video Presentation'){ ?>style="background-color:#DEFFBF"<?php } ?>> 
      <label><input name="video<?php echo $listofabstract['id']; ?>" type="checkbox" id="video<?php echo $listofabstract['id']; ?>" style="display: block;" value="checkbox"  onclick="changeabstractstatus('<?php echo $listofabstract['id']; ?>');" <?php if($listofabstract['video']=='1'){ ?>checked="checked"<?php } ?>/></label> </td>
    <td width="10%" align="center" <?php if($listofabstract['typeOfPersentation']=='Poster - Original Study / Case Presentation'){ ?>style="background-color:#DEFFBF"<?php } ?>><label><input name="poster<?php echo $listofabstract['id']; ?>" type="checkbox" id="poster<?php echo $listofabstract['id']; ?>"  style="display: block;"  onclick="changeabstractstatus('<?php echo $listofabstract['id']; ?>');" value="checkbox"  <?php if($listofabstract['poster']=='1'){ ?>checked="checked"<?php } ?> /></label></td>
    <td width="10%" align="center">
      <input name="reject<?php echo $listofabstract['id']; ?>" type="checkbox" id="reject<?php echo $listofabstract['id']; ?>"  style="display: block;" value="checkbox"  onclick="changeabstractstatus('<?php echo $listofabstract['id']; ?>');"  <?php if($listofabstract['reject']=='1'){ ?>checked="checked"<?php } ?>  /></td>
  </tr> 
  
  <?php } ?>
  
  <script>
  function changeabstractstatus(id){
  
  
  

  if ($('input#reject'+id).is(':checked')) {
  var reject=1;  
  } else {
  var reject=0;
  }
  
   if(reject==1){
  $('#oral'+id).prop('checked', false); 
  $('#video'+id).prop('checked', false); 
  $('#poster'+id).prop('checked', false); 
  }
  
  
  if ($('input#oral'+id).is(':checked')) {
  var oral=1;
  } else {
  var oral=0;
  }
  
    if ($('input#video'+id).is(':checked')) {
   var video=1; 
  } else {
  var video=0;
  }


  if ($('input#poster'+id).is(':checked')) { 
   var poster=1; 
  } else {
  var poster=0;
  }

 
	
	$('#changeabstractstatusdiv').load('frmaction.php?action=changeabstractstatus&id='+id+'&oral='+oral+'&video='+video+'&poster='+poster+'&reject='+reject);
  
  }
  </script>
</table>
<div style="display:none;" id="changeabstractstatusdiv"></div>
	 </div>
	</div></td>
  </tr><?php } ?>
 <?php if($_REQUEST['sec']=='4'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">Registration Fee
  <div style="padding:10px 20px; color:#FFFFFF; background-color:#009900; color:#FFFFFF; font-weight:500; position:absolute; right:0px; top:0px; cursor:pointer;" onclick="alertspopupopen('action=addconferencesfee&cid=<?php echo strip($resultlists['id']); ?>','300px','auto');"><i class="fa fa-plus" aria-hidden="true"></i> Add Fee</div></div>
	<div style="padding:5px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td bgcolor="#F0F0F0"><strong>Type</strong></td>
    <td width="15%" align="center" bgcolor="#F0F0F0"><strong>From</strong></td>
    <td width="15%" align="center" bgcolor="#F0F0F0"><strong>To</strong></td>
    <td width="15%" align="center" bgcolor="#F0F0F0"><strong>Registration&nbsp;Fee</strong></td>
    <td width="5%" align="center" bgcolor="#F0F0F0">&nbsp;</td>
    <td width="5%" align="center" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <?php 
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' 1 and cid='.$resultlists['id'].' order by 	id asc';  
		$rs=GetPageRecord($select,'conferencesFee',$where); 
		while($listofabstract=mysqli_fetch_array($rs)){  
		?>
  <tr>
 
    <td><div   style="color:#333333 !important;  ">
	<?php 
$where13='id="'.$listofabstract['feeType'].'" '; 
$rs13=GetPageRecord('*','confrenceFeeCategory',$where13); 
$typename=mysqli_fetch_array($rs13); 
?>
	
	<?php echo $typename['name']; ?></div></td>
    <td width="15%" align="center" style="position:relative;"><?php echo date('d/m/Y',strtotime($listofabstract['startDate'])); ?></td>
    <td width="15%" align="center" style="position:relative;"><?php echo date('d/m/Y',strtotime($listofabstract['endDate'])); ?></td>
    <td width="15%" align="center" style="position:relative;"><?php echo $listofabstract['fee']; ?></td>
    <td width="5%" align="center" style="position:relative;"><a href="#" onclick="alertspopupopen('action=addconferencesfee&cid=<?php echo strip($resultlists['id']); ?>&id=<?php echo $listofabstract['id']; ?>','300px','auto');" style="    position: absolute; 
    color: #ec2121;
    font-size: 21px;
    right:10px; z-index:9; top:2px;">
	<i class="fa fa-pencil-square" aria-hidden="true" style="color:#009900;"></i>
	</a></td>
    <td width="5%" align="center" style="position:relative;"><a onclick="return confirm('Are you sure you want to delete this fee?');" href="showpage.crm?module=conferences&view=yes&rdid=<?php echo encode($listofabstract['id']); ?>=&id=<?php echo $_REQUEST['id']; ?>&sec=4" style="    position: absolute; 
    color: #ec2121;
    font-size: 21px;
    right:10px; z-index:9; top:2px;">
	<i class="fa fa-trash" aria-hidden="true" style="color:#CC3300;"></i>
	</a></td>
  </tr> 
  
  <?php } ?>
  
  <script>
  function changeabstractstatus(id){
  
  
  

  if ($('input#reject'+id).is(':checked')) {
  var reject=1;  
  } else {
  var reject=0;
  }
  
   if(reject==1){
  $('#oral'+id).prop('checked', false); 
  $('#video'+id).prop('checked', false); 
  $('#poster'+id).prop('checked', false); 
  }
  
  
  if ($('input#oral'+id).is(':checked')) {
  var oral=1;
  } else {
  var oral=0;
  }
  
    if ($('input#video'+id).is(':checked')) {
   var video=1; 
  } else {
  var video=0;
  }


  if ($('input#poster'+id).is(':checked')) { 
   var poster=1; 
  } else {
  var poster=0;
  }

 
	
	$('#changeabstractstatusdiv').load('frmaction.php?action=changeabstractstatus&id='+id+'&oral='+oral+'&video='+video+'&poster='+poster+'&reject='+reject);
  
  }
  </script>
</table>
<div style="display:none;" id="changeabstractstatusdiv"></div>
	 </div>
	</div></td>
  </tr><?php } ?>
 <?php if($_REQUEST['sec']=='5'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">Registration   <a href="export_conference_registration.php?id=<?php echo strip($resultlists['id']); ?>"><div style="padding:10px 20px; color:#FFFFFF; background-color:#009900; color:#FFFFFF; font-weight:500; position:absolute; right:0px; top:0px; cursor:pointer;" ><i class="fa fa-download" aria-hidden="true"></i> Export </div></a>
	</div>
	<div style="padding:5px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td bgcolor="#F0F0F0"><strong>ID</strong></td>
    <td bgcolor="#F0F0F0"><strong>Date</strong></td>
    <td bgcolor="#F0F0F0"><strong>Name</strong></td>
    <td bgcolor="#F0F0F0"><strong>Email</strong></td>
    <td bgcolor="#F0F0F0"><strong>Phone/Mobile</strong></td>
    <td bgcolor="#F0F0F0"><strong>Delegate</strong></td>
    <td bgcolor="#F0F0F0"><strong>Type</strong></td>
    <td align="left" bgcolor="#F0F0F0"><strong>From</strong></td>
    <td align="left" bgcolor="#F0F0F0"><strong>To</strong></td>
    <td align="left" bgcolor="#F0F0F0"><strong>Fee&nbsp;(INR) </strong></td>
    <td align="center" bgcolor="#F0F0F0"><strong>Hotel</strong></td>
    <td align="center" bgcolor="#F0F0F0"><strong>Car</strong></td>
    <td align="center" bgcolor="#F0F0F0"><strong>Flight</strong></td>
    <td align="center" bgcolor="#F0F0F0"><strong>Accommodation</strong></td>
  </tr>
  <?php 
 
		$select='*';    
		$where=' 1 and cid='.$resultlists['id'].' order by 	id desc';  
		$rs=GetPageRecord($select,'confrenceBooking',$where); 
		while($listofabstract=mysqli_fetch_array($rs)){  
		
		  $select12='*';  
$where12='id="'.$listofabstract['userId'].'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$userlists=mysqli_fetch_array($rs12);
		?>
  <tr>
    <td><?php echo strtoupper(substr($resultlists['name'],0,2)); ?><?php echo $userlists['id']; ?></td>
    <td><?php echo date('d/m/Y',strtotime($listofabstract['addDate'])); ?></td>
 
    <td><?php echo $userlists['name']; ?></td>
    <td><?php echo $userlists['email']; ?></td>
    <td><?php echo $userlists['phone']; ?></td>
    <td><?php echo $listofabstract['ccy']; ?></td>
    <td> 
		<?php 
$where13='id="'.$listofabstract['dayType'].'" '; 
$rs13=GetPageRecord('*','confrenceFeeCategory',$where13); 
$typename=mysqli_fetch_array($rs13); 
  echo $typename['name']; ?>	</td>
    <td align="left"  ><?php echo date('d/m/Y',strtotime($listofabstract['startDate'])); ?></td>
    <td align="left"  ><?php echo date('d/m/Y',strtotime($listofabstract['endDate'])); ?></td>
    <td align="left"  ><?php echo $listofabstract['dayFee']; ?></td>
    <td align="center"  >
	<?php 	$a='';
			$rs1=GetPageRecord('id','confrenceHotelMaster','userId='.$userlists['id'].''); 
			$a=mysqli_fetch_array($rs1); 
			
			if($a['id']!=''){ echo 'Yes'; } else { echo 'No'; }
			?>	</td>
    <td align="center"  ><?php 	$a='';
			$rs1=GetPageRecord('id','confrenceCarMaster','userId='.$userlists['id'].''); 
			$a=mysqli_fetch_array($rs1); 
			
			if($a['id']!=''){ echo 'Yes'; } else { echo 'No'; }
			?></td>
    <td align="center"  ><?php 	$a='';
			$rs1=GetPageRecord('id','confrenceAirlineMaster','userId='.$userlists['id'].''); 
			$a=mysqli_fetch_array($rs1); 
			
			if($a['id']!=''){ echo 'Yes'; } else { echo 'No'; }
			?></td>
    <td align="center"  ><a href="#" onclick="alertspopupopen('action=viewaccommodationconfrence&cid=<?php echo $id; ?>&userId=<?php echo $userlists['id']; ?>','900px','auto');"><strong>View</strong></a></td>
  </tr> 
  
  <?php } ?>
  
  <script>
  function changeabstractstatus(id){
  
  
  

  if ($('input#reject'+id).is(':checked')) {
  var reject=1;  
  } else {
  var reject=0;
  }
  
   if(reject==1){
  $('#oral'+id).prop('checked', false); 
  $('#video'+id).prop('checked', false); 
  $('#poster'+id).prop('checked', false); 
  }
  
  
  if ($('input#oral'+id).is(':checked')) {
  var oral=1;
  } else {
  var oral=0;
  }
  
    if ($('input#video'+id).is(':checked')) {
   var video=1; 
  } else {
  var video=0;
  }


  if ($('input#poster'+id).is(':checked')) { 
   var poster=1; 
  } else {
  var poster=0;
  }

 
	
	$('#changeabstractstatusdiv').load('frmaction.php?action=changeabstractstatus&id='+id+'&oral='+oral+'&video='+video+'&poster='+poster+'&reject='+reject);
  
  }
  </script>
</table>
<div style="display:none;" id="changeabstractstatusdiv"></div>
	 </div>
	</div></td>
  </tr><?php } ?>
  
  
   <?php if($_REQUEST['sec']=='6'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">hOTEL   <a href="export_conference_hotel.php?id=<?php echo strip($resultlists['id']); ?>">
	<div style="padding:10px 20px; color:#FFFFFF; background-color:#009900; color:#FFFFFF; font-weight:500; position:absolute; right:0px; top:0px; cursor:pointer;" ><i class="fa fa-download" aria-hidden="true"></i> Export </div></a>
	</div>
	<div style="padding:5px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
 
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
   .header{background-color:#0066CC; color:#fff; text-transform:uppercase; font-size:12px; font-weight:600; padding:10px;}
   #mainsectiontable tr td{padding:10px; border-bottom:1px solid #eaeaea; padding:10px; font-size:12px;}
   #mainsectiontable tr:nth-child(even) {background-color: #f2f2f2;}
   div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
    padding: 8px;
    border-radius: 4px;
    border: 2px solid #ccc;
    width:210px;
    margin-bottom: 16px; outline:0px;
}

.pagination{list-style:none; padding:0px; margin:0px; float: right;}
.pagination li{float:left; margin:0px 5px; }
.pagination a {
    color: #333333;
    background-color: #F5F5F5;
    padding: 4px 9px;
    outline: 0px;
    text-decoration: none;
    border-radius: 3px;
}.pagination .active a{background-color:#0066CC; color:#FFFFFF !important;}
#mainsectiontable_length{ display:none;}
div.dataTables_wrapper div.dataTables_filter {
    text-align: left;
    margin-top: 20px;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination { 
    margin-top: -19px;
}
   </style>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
     <th width="5%" align="left" class="header" style="padding-bottom:10px;" >Date</th>
     <th width="6%" align="left" class="header" style="padding-bottom:10px;" >Guest  </th>
     <th width="5%" align="left" class="header" style="padding-bottom:10px;" >Email</th>
     <th width="13%" align="left" class="header" style="padding-bottom:10px;" ><strong>Phone/Mobile</strong></th>
     <th width="13%" align="left" class="header" style="padding-bottom:10px;" ><span class="header" style="padding-bottom:10px;">Hotel</span></th>

     <th width="11%" align="left" class="header"style="padding-bottom:10px;" >From Date </th>

     <th width="8%" align="left" class="header"style="padding-bottom:10px;" >To Date</th>
     <th width="6%" align="left" class="header"style="padding-bottom:10px;" >Nights</th>
     <th width="10%" align="left" class="header"style="padding-bottom:10px;" >Occupancy</th>
     <th width="6%" align="left" class="header"style="padding-bottom:10px;" >Guest</th>
     <th width="11%" align="left" class="header"style="padding-bottom:10px;" >Cost (INR) </th>
     </tr>
   </thead>

 


 

  <tbody>
<?php 
	 $k=1;
		$select='*';    
		$where='  confrenceId="'.$id.'" and userId!=0 order by id asc';  
		$rs=GetPageRecord($select,'confrenceHotelMaster',$where); 
		while($datad=mysqli_fetch_array($rs)){  
		
		
			$select1='*';  
			$where1='id='.$datad['hotel'].' '; 
			$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
			$hanme=mysqli_fetch_array($rs1); 
			
			$select1='*';  
			$where1='serviceid='.$hanme['id'].' and singleoccupancy!="0" and doubleoccupancy!="0" and tripleoccupancy!="0" order by singleoccupancy asc '; 
			$rs1=GetPageRecord($select1,'dmcroomTariff',$where1); 
			$roomrate=mysqli_fetch_array($rs1); 
			
			
					  $select12='*';  
$where12='id="'.$datad['userId'].'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$userlists=mysqli_fetch_array($rs12);
	
		?>
  <tr>
    <td align="left"><?php echo date('d/m/Y',strtotime($userlists['addDate'])); ?></td>
    <td align="left"><?php echo $userlists['name']; ?></td>
    <td align="left"><?php echo $userlists['email']; ?></td>
    <td align="left"><?php echo $userlists['phone']; ?></td>
    <td align="left"><?php echo $hanme['hotelName']; ?><br />
<strong><?php echo $datad['category']; ?> Star</td>

    <td align="left"><?php echo date('d/m/Y',strtotime($datad['fromDate'])); ?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($datad['toDate'])); ?></td>
    <td align="left"><?php
	$date1 = strtotime($datad['fromDate']);
$date2 = strtotime($datad['toDate']);

echo $finalnights=round(abs($date2 - $date1) / (60*60*24),0);
?></td>
    <td align="left"><?php if($datad['occupancy']=='1'){ echo 'Single'; } if($datad['occupancy']=='2'){ echo 'Double'; }if($datad['occupancy']=='3'){ echo 'Triple'; } ?></td>
    <td align="left"><?php echo $datad['guest']; ?></td>
    <td align="left"><?php if($datad['occupancy']=='1'){
	
	echo  $finalnights*$datad['guest']*$roomrate['singleoccupancy']; 
	 
	 } if($datad['occupancy']=='2'){
 $doublecost=0;
	 
	 $doublecost = ceil($datad['guest']/$datad['occupancy']);
	 $roomratefianle=$roomrate['doubleoccupancy']*$doublecost;
	 echo round($finalnights*$roomratefianle);  
	  
	  }if($datad['occupancy']=='3'){
	  
	   $doublecost=0;
	 
	 $doublecost = ceil($datad['guest']/$datad['occupancy']);
	 $roomratefianle=$roomrate['tripleoccupancy']*$doublecost;
	 echo round($finalnights*$roomratefianle);  
	  } ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>

 <script>
$(document).ready(function() {
     $('#mainsectiontable').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
} );
</script>
	 </div>
	</div></td>
  </tr><?php } ?>
  
   <?php if($_REQUEST['sec']=='7'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">Cars   <a href="export_conference_car.php?id=<?php echo strip($resultlists['id']); ?>">
	<div style="padding:10px 20px; color:#FFFFFF; background-color:#009900; color:#FFFFFF; font-weight:500; position:absolute; right:0px; top:0px; cursor:pointer;" ><i class="fa fa-download" aria-hidden="true"></i> Exports</div>
	</a></div>
	<div style="padding:5px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
 
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
   .header{background-color:#0066CC; color:#fff; text-transform:uppercase; font-size:12px; font-weight:600; padding:10px;}
   #mainsectiontable tr td{padding:10px; border-bottom:1px solid #eaeaea; padding:10px; font-size:12px;}
   #mainsectiontable tr:nth-child(even) {background-color: #f2f2f2;}
   div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
    padding: 8px;
    border-radius: 4px;
    border: 2px solid #ccc;
    width:210px;
    margin-bottom: 16px; outline:0px;
}

.pagination{list-style:none; padding:0px; margin:0px; float: right;}
.pagination li{float:left; margin:0px 5px; }
.pagination a {
    color: #333333;
    background-color: #F5F5F5;
    padding: 4px 9px;
    outline: 0px;
    text-decoration: none;
    border-radius: 3px;
}.pagination .active a{background-color:#0066CC; color:#FFFFFF !important;}
#mainsectiontable_length{ display:none;}
div.dataTables_wrapper div.dataTables_filter {
    text-align: left;
    margin-top: 20px;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination { 
    margin-top: -19px;
}
   </style>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
     <th width="5%" align="left" class="header" style="padding-bottom:10px;" >Date</th>
     <th width="6%" align="left" class="header" style="padding-bottom:10px;" >Guest  </th>
     <th width="5%" align="left" class="header" style="padding-bottom:10px;" >Email</th>
     <th width="13%" align="left" class="header" style="padding-bottom:10px;" ><strong>Phone/Mobile</strong></th>
     <th width="13%" align="left" class="header" style="padding-bottom:10px;" ><span class="header" style="padding-bottom:10px;">Transfer</span></th>

     <th width="11%" align="left" class="header"style="padding-bottom:10px;" >From Date </th>

     <th width="8%" align="left" class="header"style="padding-bottom:10px;" >To Date</th>
     <th width="6%" align="left" class="header"style="padding-bottom:10px;" ><strong>Vehicle</strong></th>
     <th width="10%" align="left" class="header"style="padding-bottom:10px;" ><strong>No. of Vehicle</strong></th>
     <th width="6%" align="left" class="header"style="padding-bottom:10px;" >Guest</th>
     <th width="11%" align="left" class="header"style="padding-bottom:10px;" ><strong>Pickup Time</strong></th>
     </tr>
   </thead>

 


 

  <tbody>
<?php 
	
	 $k=1;
		$select='*';    
		$where='  confrenceId="'.$id.'" and userId!=0 order by id asc';  
		$rs=GetPageRecord($select,'confrenceCarMaster',$where); 
		while($datad=mysqli_fetch_array($rs)){  
 
	$select1='*';  
			$where1='id='.$datad['transferId'].' '; 
			$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_TRANSFER_MASTER,$where1); 
			$hanme=mysqli_fetch_array($rs1); 
			
			$select1='*';  
			$where1='id='.$datad['vehicleId'].' '; 
			$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
			$vehicle=mysqli_fetch_array($rs1);
			
					  $select12='*';  
$where12='id="'.$datad['userId'].'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$userlists=mysqli_fetch_array($rs12);
	
		?>
  <tr>
    <td align="left"><?php echo date('d/m/Y',strtotime($userlists['addDate'])); ?></td>
    <td align="left"><?php echo $userlists['name']; ?></td>
    <td align="left"><?php echo $userlists['email']; ?></td>
    <td align="left"><?php echo $userlists['phone']; ?></td>
    <td align="left"><?php echo $hanme['transferName']; ?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($datad['fromDate'])); ?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($datad['toDate'])); ?></td>
    <td align="left"><?php echo $vehicle['name']; ?></td>
    <td align="left"><?php echo $datad['pax']; ?></td>
    <td align="left"><?php echo $datad['guest']; ?></td>
    <td align="left"><?php echo $datad['start_Time']; ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>

 <script>
$(document).ready(function() {
     $('#mainsectiontable').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
} );
</script>
	 </div>
	</div></td>
  </tr><?php } ?>
  
   <?php if($_REQUEST['sec']=='8'){?> <tr>
    <td colspan="2" align="left" valign="top"><div style="border:1px solid #cccccc6e; margin-bottom:20px;">
	
	<div style="padding:10px; background-color:#3366CC; color:#FFFFFF; font-weight:500; font-size:12px; text-transform:uppercase; position:relative; overflow:hidden;">Airlines   <a href="export_conference_airline.php?id=<?php echo strip($resultlists['id']); ?>">
	<div style="padding:10px 20px; color:#FFFFFF; background-color:#009900; color:#FFFFFF; font-weight:500; position:absolute; right:0px; top:0px; cursor:pointer;" ><i class="fa fa-download" aria-hidden="true"></i> Exports</div>
	</a></div>
	<div style="padding:5px; background-color: #f8f8f8; border-bottom: 1px solid #eee;">
	  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
 
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
   .header{background-color:#0066CC; color:#fff; text-transform:uppercase; font-size:12px; font-weight:600; padding:10px;}
   #mainsectiontable tr td{padding:10px; border-bottom:1px solid #eaeaea; padding:10px; font-size:12px;}
   #mainsectiontable tr:nth-child(even) {background-color: #f2f2f2;}
   div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
    padding: 8px;
    border-radius: 4px;
    border: 2px solid #ccc;
    width:210px;
    margin-bottom: 16px; outline:0px;
}

.pagination{list-style:none; padding:0px; margin:0px; float: right;}
.pagination li{float:left; margin:0px 5px; }
.pagination a {
    color: #333333;
    background-color: #F5F5F5;
    padding: 4px 9px;
    outline: 0px;
    text-decoration: none;
    border-radius: 3px;
}.pagination .active a{background-color:#0066CC; color:#FFFFFF !important;}
#mainsectiontable_length{ display:none;}
div.dataTables_wrapper div.dataTables_filter {
    text-align: left;
    margin-top: 20px;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination { 
    margin-top: -19px;
}
   </style>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="table table-striped table-bordered" id="mainsectiontable">

   <thead>

   <tr>
     <th align="left" class="header" style="padding-bottom:10px;" >Date</th>
     <th align="left" class="header" style="padding-bottom:10px;" >Guest  </th>
     <th align="left" class="header" style="padding-bottom:10px;" >Email</th>
     <th align="left" class="header" style="padding-bottom:10px;" ><strong>Phone/Mobile</strong></th>
     <th align="left" class="header" style="padding-bottom:10px;" ><strong>On Board Meal </strong></th>

     <th align="left" class="header"style="padding-bottom:10px;" >From Date </th>

     <th align="left" class="header"style="padding-bottom:10px;" >To Date</th>
     <th align="left" class="header"style="padding-bottom:10px;" ><strong>Preferred Timing</strong></th>
     <th align="left" class="header"style="padding-bottom:10px;" ><strong>Preferred Airline</strong></th>
     <th align="left" class="header"style="padding-bottom:10px;" >Guest</th>
     <th align="left" class="header"style="padding-bottom:10px;" ><strong>Hub</strong></th>
     </tr>
   </thead>

 


 

  <tbody>
<?php 
	
		 $k=1;
		$select='*';    
		$where='   confrenceId="'.$id.'" and userId!=0 order by id asc';  
		$rs=GetPageRecord($select,'confrenceAirlineMaster',$where); 
		while($datad=mysqli_fetch_array($rs)){  
			
					  $select12='*';  
$where12='id="'.$datad['userId'].'" '; 
$rs12=GetPageRecord($select12,'confrenceRegister',$where12); 
$userlists=mysqli_fetch_array($rs12);
	
		?>
  <tr>
    <td align="left"><?php echo date('d/m/Y',strtotime($userlists['addDate'])); ?></td>
    <td align="left"><?php echo $userlists['name']; ?></td>
    <td align="left"><?php echo $userlists['email']; ?></td>
    <td align="left"><?php echo $userlists['phone']; ?></td>
    <td align="left"><?php if($datad['onboardmeal']==1){ echo 'Yes'; } else { echo 'No'; }?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($datad['fromDate'])); ?></td>

    <td align="left"><?php echo date('d/m/Y',strtotime($datad['toDate'])); ?></td>
    <td align="left"><?php echo $datad['preferredTiming']; ?></td>
    <td align="left"><?php echo $datad['preferredAirline']; ?></td>
    <td align="left"><?php echo $datad['guest']; ?></td>
    <td align="left"><?php echo $datad['hubAirline']; ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>

 <script>
$(document).ready(function() {
     $('#mainsectiontable').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true
    } );
} );
</script>
	 </div>
	</div></td>
  </tr><?php } ?>
</table>


 
</div>

<script>
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>

<style>
.slides {
    list-style: none;
    margin: 0;
    padding: 0; 
}
.slide { 
}

.slide-placeholder {
    background: #DADADA;
    position: relative;
}
.slide-placeholder:after {
    content: " ";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 15px;
    background-color: #FFF;
}
 
</style>
 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(".slides").sortable({
     placeholder: 'slide-placeholder',
    axis: "y",
    revert: 150,
    start: function(e, ui){
        
        placeholderHeight = ui.item.outerHeight();
        ui.placeholder.height(placeholderHeight + 15);
        $('<div class="slide-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
    
    },
    change: function(event, ui) {
        
        ui.placeholder.stop().height(0).animate({
            height: ui.item.outerHeight() + 15
        }, 300);
        
        placeholderAnimatorHeight = parseInt($(".slide-placeholder-animator").attr("data-height"));
        
        $(".slide-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
            height: 0
        }, 300, function() {
            $(this).remove();
            placeholderHeight = ui.item.outerHeight();
            $('<div class="slide-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
        });
        
    },
    stop: function(e, ui) {
        
        $(".slide-placeholder-animator").remove();
		$('#pagessave').submit();
        
    },
});
 
</script>
<style>
.contabs {overflow:hidden; margin-top:60px; border-bottom:2px solid #3366CC; margin-bottom:20px; margin-top: }
.contabs a{
    background-color: #efefef;
    padding: 14px !important;
    float: left;
    font-weight: 500; margin-right:5px; color:#000 !important;
}
.contabs .active{background-color:#3366CC; color:#FFFFFF !important;}


.gridtable .header{padding-bottom:10px !important;}
</style>