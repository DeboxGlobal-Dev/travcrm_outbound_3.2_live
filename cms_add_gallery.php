<?php 
$type='memoriesGallery';
$pagetitle = "Photo Gallery"; 	
$backpage = "showpage.crm?module=cms&page=gallery"; 
$targetpage = "showpage.crm?module=cms&page=gallery"; 
$tableName = "post_list";
$addeditpage = "showpage.crm?module=cms&page=add-gallery"; 

/*-----------------Edit Commond---------------*/


if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}

$title=addslashes($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);

    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=addslashes($_POST['home_text']); 
$description=addslashes($_POST['description']);
$status=addslashes($_POST['status']);
$edituser=$_SESSION['username'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];


$namevalue ='title="'.$title.'",home_text="'.$home_text.'",category="'.$package_theme.'",subcategory="'.$destination.'",description="'.$description.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",feature_img="'.$image.'",type="'.$type.'",status="'.$status.'"'; 

if($_REQUEST['edit']=="edit"){
$where='id="'.$id.'"';  
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 
header("location:showpage.crm?module=cms&page=gallery&alt=2");		
}
if(isset($_REQUEST['add'])){
$add = addlisting(_POST_LIST_MASTER_,$namevalue);  
header("location:showpage.crm?module=cms&page=gallery&alt=2");}



$select1='*';  
$where1='id="'.$_REQUEST['id'].'"'; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$title=clean($editresult['title']); 
$home_text=clean($editresult['home_text']); 
$description=clean($editresult['description']); 
$feature_img=clean($editresult['feature_img']);
?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<div class="innerouter">
  	<div class="innertitlebox">
  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="36"><img src="images/addpage.png" width="32" height="32" /></td>
      <td>
  	<h3><?php if($_REQUEST['id']!=""){ echo "Edit"; } else {  echo "Add"; } ?>
  	    <?php echo $_REQUEST['pagetitle']; ?></h3>	 </td>
      <td width="151" align="right" style="width:150px;"><a href="showpage.crm?module=cms&page=gallery" onclick="globalloading();" ><input type="button" name="Submit2" value="Back To List" class="gradiantbtn" /></a></td>
    </tr>
  </table>
  	</div>
  	<div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
  	<form action="" method="post" enctype="multipart/form-data">

  	<div class="listingbox addeditpage">
  	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="77%" align="left" valign="top"><table width="100%" border="0" cellpadding="8" cellspacing="0">
          <tr>
            <td width="20%" align="left" valign="top">Gallery Title</td>
            <td width="80%" align="left" valign="top">
              <input name="title" type="text" id="title" style="width:96%;" value="<?php  echo stripslashes($title); ?>" />
            </td>
          </tr>
          <tr>
            <td align="left" valign="top">Destination as(Tags)</td>
            <td align="left" valign="top">
              <select name="destination[]" id="destination"  style="width: 100%;" data-placeholder="Select Gallery Tags" multiple >
                 <option value="0">--Choose Option--</option>
                <?php 
                $tagsQuery=mysqli_query("select * from destinationMaster where status='1' order by name asc");
                while($tagsData=mysqli_fetch_array($tagsQuery)){ 
                $isSelected_destination = array_map('trim', explode(",", $editresult['subcategory']));
                ?>
                  <option value="<?php echo $tagsData['id']; ?>" <?php if(in_array($tagsData['id'],$isSelected_destination)) { ?> selected="selected" <?php } ?>>
                  <?php echo $tagsData['name']; ?>
                  </option>
                <?php 
                } 
                ?>
              </select>
            </td>
          </tr>
          <tr width="77%" align="left" valign="top">
              <td width="17%" align="left" valign="top">
                  <span>Package Theme</span>
              </td>
              <td width="88%" align="left" valign="top">
                <select name="package_theme[]" id="package_theme"  data-placeholder="Select Themes" multiple  style="width: 100%;" >
                  <option value="0">Select Themes </option>
                  <?php 
                  $package_themeSql=mysqli_query("select * from packageThemeMaster where status='1' order by name asc");
                  while($package_themeData=mysqli_fetch_array($package_themeSql)){ 
                  $isSelected_theme = array_map('trim', explode(",", $editresult['category'])); 
                  ?> 
                  <option  value="<?php echo $package_themeData['id']; ?>" <?php if(in_array($package_themeData['id'],$isSelected_theme)) { ?> selected="selected" <?php } ?>>
                  <?php echo $package_themeData['name']; ?>
                  </option>
                  <?php 
                  } 
                  ?>
                </select>
              </td>
            </tr> 
            <tr>
              <td align="left" valign="middle">Gallery Preview Image</td>
              <td align="left" valign="top">
                <input name="file1" type="file" class="grybutton" id="file1"/>
  			        <input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
              </td>
            </tr>
            <tr>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
                <div id="fimagech">
                  <?php if($feature_img!=""){ ?>
                  <img src="upload/<?php echo $feature_img; ?>" width="200" />
                  <?php } ?> 
                </div>
              </td>
            </tr>
            <tr>
              <td align="left" valign="middle">Active  </td>
              <td align="left" valign="top">
                <select name="status" id="status">
                  <option value="1" <?php if($editresult['status']==1){ ?>selected="selected"<?php } ?>>Yes</option>
                  <option value="2" <?php if($editresult['status']==2){ ?>selected="selected"<?php } ?>>No</option>
                </select>          
              </td>
            </tr>
        </table>
      </td>
      <td width="23%" align="left" valign="top" style="width:250px;">
  	<div style="margin-left:10px;" class="featureimagebox">
  	 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <input name="Submit" type="submit" class="bluebutton" id="Submit" value="   Save and Publish   "  onclick="globalloading();"  />
        <?php if($_REQUEST['id']!=""){ ?><input name="edit" type="hidden" id="edit" value="edit" /><input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
        <?php } else { ?><input name="add" type="hidden" id="add" value="add" /><?php } ?>
        <input name="backpage" type="hidden" id="backpage" value="<?php echo $_REQUEST['backpage']; ?>" /></td>
      </tr>
    </table>
  	 </div><br />
  	<?php if($_REQUEST['id']!=""){ ?>
  	<div class="gradiantbtn" style="padding-top:20px; font-size:12px; margin-left:10px;">
  	  <div align="center" style="padding-bottom:10px;">Added on: 
  	    <em>
  	     <?php
  	echo date("g:ia jS F Y", strtotime($post_result['add_date']));?></em></div>
  	<?php if($post_result['add_date']!="0000-00-00 00:00:00"){ ?><div align="center" style="padding-bottom:10px;">Last update: 
  	    <em>
  	     <?php
  	echo date("g:ia jS F Y", strtotime($post_result['edit_date']));?></em></div>
  	</div> <?php } } ?>
  	</td>
    </tr>
  </table>
  	</div>




  		</form>
  	</div>
	  <script type="text/javascript">
    $('#destination').select2();
    $('#package_theme').select2();
  </script>