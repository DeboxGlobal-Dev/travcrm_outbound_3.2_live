<?php 
$statuswise = $_GET['statuswise'];
include 'tableSorting.php';
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td width="7%">
       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    
     </td> 
    <td><div class="headingm" style="margin-left:5px;"><span id="topheadingmain"  width="3%"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=letter','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0" style="display:nones">
        <tr>
          <!-- <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Proposal" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" /></td> -->  
        </tr> 
    </table></td>
  </tr> 
</table>
</div> 
<div id="pagelisterouter" style="padding-left:0px;">
<input name="action" id="action" type="hidden" value="deleteletter" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable"> 
  <thead> 
  <tr>
      <th align="left" class="header" width="2%">SRN</th>
      <th align="left" class="header" width="80">Proposal&nbsp;Num</th>
      <th align="left" class="header" width="12%">Proposal&nbsp;Name</th>
      <th align="left" class="header" width="15%">Background&nbsp;Color</th>
      <th align="left" class="header" width="15%">Text&nbsp;Color</th>
      <th align="left" class="header" width="20%">Header&nbsp;Image(790x100)</th>
      <!-- <th align="left" class="header" width="20%">Footer&nbsp;Image(790x100)</th> -->
      <th align="left" class="header" width="30%">Banner&nbsp;Image(800x300)</th>
      <!-- <th align="left" class="header" width="80">&nbsp;</th> -->
  </tr>
  </thead>
  <tbody>
	<?php 	
	$no=1; 
	$select='*'; 
	$where=''; 
	$rs='';  
	$wheresearch=''; 
	$limit=clean($_GET['records']);   
  $where='where disableStatus=0 order by id asc';  
  // $where='where 1 order by proposalNum asc';  
	// $where='where 1 && proposalNum!="6" order by proposalNum asc';  
	$page=$_GET['page'];
	$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
	$rs=GetRecordList($select,'proposalSettingMaster',$where,$limit,$page,$targetpage); 
	$totalentry=$rs[1]; 
	$paging=$rs[2];
  $propName=''; 
	while($resultlists=mysqli_fetch_array($rs[0])){    
		$dateAdded=clean($resultlists['dateAdded']);
		$modifyDate=clean($resultlists['modifyDate']);
    
    // if ($resultlists['proposalName']=='Detailed Proposal') {
    //   $propName='detailed';
    // }elseif ($resultlists['proposalName']=='Brief Proposal') {
    //   $propName='brief';
    // }elseif ($resultlists['proposalName']=='Elite Proposal') {
    //   $propName='elite';
    // }elseif ($resultlists['proposalName']=='Vivid Proposal') {
    //   $propName='vivid';
    // }elseif ($resultlists['proposalName']=='Elegant Proposal') {
    //   $propName='elegant';
    // }
    ?>
    <tr>
      <td width="2%"><?= $no ?></td> 
      <td width="5%" align="left"><div style=" width: fit-content; color: #7a96ff ;"><?php echo 'P'.str_pad($resultlists['proposalNum'], 3, '0', STR_PAD_LEFT); ?></div></td>
      <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','600px','auto');" ><?php echo $resultlists['proposalName']; ?></div>   
      </td>
      <td><?php if($resultlists['proposalColor']==''){ ?> <div style="border:2px solid #ccc; width: 99%;padding-top: 5px;padding-bottom: 5px;text-align:center;">No Color Chosen!</div> <?php }else{ ?><div style="border:2px solid #ccc; background-color:<?php echo $resultlists['proposalColor']; ?>;width: 99%;height: 24px;"></div> <?php } ?></td>

      <td><?php if($resultlists['textColor']==''){?> <div style="border:2px solid #ccc; width: 99%;padding-top: 5px;padding-bottom: 5px;text-align:center;">No Color Chosen!</div> <?php }else{ ?><div style="border:2px solid #ccc; background-color:<?php echo $resultlists['textColor']; ?>;width: 99%;height: 24px;"></div> <?php } ?></td>

  <?php   
  $resh=GetPageRecord('*','imageGallery',' parentId = "'.$resultlists['id'].'" and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc )  order by id desc');
  $imagePathData = mysqli_fetch_assoc($resh);
  ?> 
  <td>
    <div>
      <?php
        $proposalPhotoheader = geDocFileSrc($imagePathData['fileId']);
        if($imagePathData['fileId']!='' && file_exists($proposalPhotoheader)==true){ 
          ?>
          <a href="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotoheader); ?>" target="_blank" >
            <img src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotoheader); ?>" alt="" style="object-fit: contain;max-width: 130px;"/>
          </a>
          <?php 
        }
        ?>
        <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add" onclick="masters_alertspopupopen('action=addeditGallery&galleryType=proposalheader&parentId=<?php echo $resultlists['id']; ?>&module=proposalsetting','800px','auto');" style="float: right;" />
        <br>
  </div>
  </td> 
  <?php   
  // $pfooterquery=GetPageRecord('*','imageGallery',' parentId = "'.$resultlists['id'].'" and galleryType="proposalfooter" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc )  order by id desc');
  // $pfooterD = mysqli_fetch_assoc($pfooterquery);
  ?> 
  <!-- <td>
    <div>
      <?php
        // $proposalfooterPhoto = geDocFileSrc($pfooterD['fileId']);
        // if($pfooterD['fileId']!='' && file_exists($proposalfooterPhoto)==true){ 
          ?>
          <a href="<?php echo $fullurl.str_replace(' ','%20',$proposalfooterPhoto); ?>" target="_blank" >
            <img src="<?php echo $fullurl.str_replace(' ','%20',$proposalfooterPhoto); ?>" alt="" style="object-fit: contain;max-width: 130px;"/>
          </a>
          <?php 
        //}
        ?>
        <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add" onclick="masters_alertspopupopen('action=addeditGallery&galleryType=proposalfooter&parentId=<?php echo $resultlists['id']; ?>&module=proposalsetting','800px','auto');" style="float: right;" />
        <br>
    </div>
  </td> -->
  <td  align="left" valign="middle">
    <?php 
    $pPhotoQuery='';
    $proposalPhoto ='';
    $pPhotoQuery=GetPageRecord('*','imageGallery',' parentId = "'.$resultlists['id'].'" and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension in ("800x300","750x500") order by id desc ) order by id desc LIMIT 1');
    if(mysqli_num_rows($pPhotoQuery)>0){  
      $proposalPhotoD=mysqli_fetch_array($pPhotoQuery);
        $proposalBanner = geDocFileSrc($proposalPhotoD['fileId']);
        if($proposalPhotoD['fileId']!='' && file_exists($proposalBanner)==true){
          ?>
          <a href="<?php echo $fullurl.str_replace(' ','%20',$proposalBanner); ?>" target="_blank" >
          <img src="<?php echo $fullurl.str_replace(' ','%20',$proposalBanner); ?>" alt="" style="object-fit: contain;max-width: 130px;"/>
          </a>
        <?php 
        }else{
        ?><div style="">File Not Exists.</div>
          <?php
        }
    }else{ ?>
      <div style="height: 60px;width:75px; padding:3px; border-radius:3px; background:#CCCCCC; float: left;"><div style="margin: auto; font-size: 13px; color: #666666; margin-top: 20px; text-align: center;">No Image.</div></div>
      <?php
    }
    ?>
    <div  style="float: right;">
      <input class="ppbtn" name="addnewuserbtn" type="button" id="addnewuserbtn" value="+ Add Banner Image" onclick="masters_alertspopupopen('action=addeditGallery&amp;galleryType=proposalbanner&amp;parentId=<?php echo $resultlists['id']; ?>&amp;module=<?php echo $_REQUEST['module'] ?>','800px','auto');">
      <p>Required Size <?php echo $resultlists['photoDimension'] ?></p>
    </div>
  </td>
    </tr> 
	<?php $no++; } ?>
    <!-- For Vivid Proposal -->

    <?php 	
	$no=1; 
	$select='*'; 
	$where=''; 
	$rs='';  
	$wheresearch=''; 
	$limit=clean($_GET['records']);   
	$where='where proposalNum="0" order by proposalNum asc';  
	$page=$_GET['page'];
	$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
	$rs=GetRecordList($select,'proposalSettingMaster',$where,$limit,$page,$targetpage); 
	$totalentry=$rs[1]; 
	$paging=$rs[2];
  $propName=''; 
	while($resultlists=mysqli_fetch_array($rs[0])){    
		$dateAdded=clean($resultlists['dateAdded']);
		$modifyDate=clean($resultlists['modifyDate']);
    ?>
    <tr>
      <td width="2%"><?= $no ?></td> 
      <td width="5%" align="left"><div style=" width: fit-content; color: #7a96ff ;"><?php echo 'P'.str_pad($resultlists['proposalNum'], 3, '0', STR_PAD_LEFT); ?></div></td>
      <td align="left"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','600px','auto');" ><?php echo $resultlists['proposalName']; ?></div>   
      </td>
      <td><div style="border:2px solid #ccc;background-color:<?php echo $resultlists['proposalColor']; ?>;width: 99%;height: 24px;"></div></td>
      <td><div style="border:2px solid #ccc;background-color:<?php echo $resultlists['textColor']; ?>;width: 99%;height: 24px;"></div></td>

  <?php   
  $resh=GetPageRecord('*','imageGallery',' parentId = "'.$resultlists['id'].'" and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc )  order by id desc');
  $imagePathData = mysqli_fetch_assoc($resh);
  ?> 
  <td>
    <div>
      <?php
        $proposalPhotoheader = geDocFileSrc($imagePathData['fileId']);
        if($imagePathData['fileId']!='' && file_exists($proposalPhotoheader)==true){ 
          ?>
          <a href="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotoheader); ?>" target="_blank" >
            <img src="<?php echo $fullurl.str_replace(' ','%20',$proposalPhotoheader); ?>" alt="" style="object-fit: contain;max-width: 130px;"/>
          </a>
          <?php 
        }
        ?>
        <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add" onclick="masters_alertspopupopen('action=addeditGallery&galleryType=proposalheader&parentId=<?php echo $resultlists['id']; ?>&module=proposalsetting','800px','auto');" style="float: right;" />
        <br>
  </div>
  </td> 
  <?php   
  // $pfooterquery=GetPageRecord('*','imageGallery',' parentId = "'.$resultlists['id'].'" and galleryType="proposalfooter" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc )  order by id desc');
  // $pfooterD = mysqli_fetch_assoc($pfooterquery);
  ?> 
  <!-- <td>
    <div>
      <?php
        // $proposalfooterPhoto = geDocFileSrc($pfooterD['fileId']);
        // if($pfooterD['fileId']!='' && file_exists($proposalfooterPhoto)==true){ 
          ?>
          <a href="<?php echo $fullurl.str_replace(' ','%20',$proposalfooterPhoto); ?>" target="_blank" >
            <img src="<?php echo $fullurl.str_replace(' ','%20',$proposalfooterPhoto); ?>" alt="" style="object-fit: contain;max-width: 130px;"/>
          </a>
          <?php 
        //}
        ?>
        <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add" onclick="masters_alertspopupopen('action=addeditGallery&galleryType=proposalfooter&parentId=<?php echo $resultlists['id']; ?>&module=proposalsetting','800px','auto');" style="float: right;" />
        <br>
    </div>
  </td> -->
  <td  align="left" valign="middle">
    <?php 
    $pPhotoQuery='';
    $proposalPhoto ='';
    $pPhotoQuery=GetPageRecord('*','imageGallery',' parentId = "'.$resultlists['id'].'" and galleryType="proposalbanner" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="750x500" order by id desc ) order by id desc LIMIT 1');
    if(mysqli_num_rows($pPhotoQuery)>0){  
      $proposalPhotoD=mysqli_fetch_array($pPhotoQuery);
        $proposalBanner = geDocFileSrc($proposalPhotoD['fileId']);
        if($proposalPhotoD['fileId']!='' && file_exists($proposalBanner)==true){
          ?>
          <a href="<?php echo $fullurl.str_replace(' ','%20',$proposalBanner); ?>" target="_blank" >
          <img src="<?php echo $fullurl.str_replace(' ','%20',$proposalBanner); ?>" alt="" style="object-fit: contain;max-width: 130px;"/>
          </a>
        <?php 
        }else{
        ?><div style="">File Not Exists.</div>
          <?php
        }
    }else{ ?>
      <div style="height: 60px;width:75px; padding:3px; border-radius:3px; background:#CCCCCC; float: left;"><div style="margin: auto; font-size: 13px; color: #666666; margin-top: 20px; text-align: center;">No Image.</div></div>
      <?php
    }
    ?>
    <div  style="float: right;">
      <input class="ppbtn" name="addnewuserbtn" type="button" id="addnewuserbtn" value="+ Add Banner Image" onclick="masters_alertspopupopen('action=addeditGallery&amp;galleryType=proposalbanner&amp;parentId=<?php echo $resultlists['id']; ?>&amp;module=<?php echo $_REQUEST['module'] ?>','800px','auto');">
      <p>Required Size <?php echo $resultlists['photoDimension'] ?></p>
    </div>
  </td>
    </tr> 
  
	<?php $no++; }
  
  // $res = GetPageRecord('*','proposalSettingMaster','proposalName!="" ');
  // $rsData = mysqli_fetch_assoc($res);
  
  ?>

  <!-- <tr><td colspan="7" align="right"><input type="checkbox" <?php if($rsData['isProposalCost']==1){ echo 'checked'; } ?> name="showCost" id="showCost" onclick="showHideProposalCost();" style="display: inline-block;">&nbsp;&nbsp;Show Proposal Total Cost</td></tr> -->

</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>

<div class="pagingdiv">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>
    <td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >
      <option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>
      <option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>
      <option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>
      <option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>
      <option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>
    </select></td>
  </tr>
  
</table></td>

    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>

  </tr>
</tbody></table>
	</div>
</div></form>	</td>
  </tr>
</table>
 <style type="text/css">
   .ppbtn{
    background-color: #7a96ff;
    padding: 4px 6px !important;
    margin-left: 10px;
    color: #FFFFFF!important;
    font-size: 12px;
    border: 1px #7a96ff solid;
    cursor: pointer;
    border-radius: 10px;
   }
 </style>

 