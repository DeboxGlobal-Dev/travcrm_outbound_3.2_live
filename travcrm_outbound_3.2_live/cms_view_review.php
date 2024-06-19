<?php $pageName='MANAGE REVIEW DETAIL'; 
$id = $_REQUEST['id'];
//----Page Settings-----
//----change status-----
if($_REQUEST['status']!=""){
	$cid=$_REQUEST['cid'];
	$status=$_REQUEST['status'];
	$sql_ins="update "._PACKAGE_REVIEW_." set status='$status' where id = ".$cid."";
	mysqli_query($sql_ins) or die(mysqli_error(db()));
}
//----SHOW ON HOME
if($_REQUEST['home']!=""){
	$id=$_REQUEST['id'];
	$home=$_REQUEST['home'];
	$sql_ins="update "._PACKAGE_REVIEW_." set home='$home' where id = ".$id."";
	mysqli_query($sql_ins) or die(mysqli_error(db()));
}
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
			.review_detail{
				padding: 30px 10px;
				width: 100%;
				position: relative;
				display: inline-block;
			}
			.package_name{
				padding: 10px 10px;
				height: 82px;
				width: 100%;
				position: relative;
				display: inline-block;
			}
			.wecare_review_img{
				padding: 10px 10px;
				height: auto;
				width: 100%;
				position: relative;
				overflow: hidden;
				display: inline-block;
			}
			.review_img{
				width: 100px;
    			height: 80px;
    			border: 1px solid #eee;
			}
			.gradiantbtn {
    border: 1px #3b3e48 solid;
    padding: 5px 10px;
    outline: 0px;
    background-color: #3b3e48;
    color: #fff;
    border-radius: 4px;
}
		</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
	<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Destination','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?>
        <td style="padding-right:20px;"><a href="showpage.crm?module=cms&page=review" onclick="globalloading();" >
	 		<input type="button" name="Submit2" value="Back To List" class="gradiantbtn" />
	 	</a></td>
        <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="banner" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<?php  
	 	$queryDetail = "SELECT * FROM "._PACKAGE_REVIEW_." where id='$id'";
	 	$queryDetailQuery = mysqli_query($queryDetail);
	 	$queryDetailData = mysqli_fetch_array($queryDetailQuery);
	 	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>
   <tr>
      
      <th colspan="8" align="left" class="header" style="background-color:#f7f7f7;">
	  <div >
          		<?php  
          		$package_id =  $queryDetailData['package_id']; 
          		$packageSql = "select * from packageBuilderDetail where id ='".$package_id."'";
				$packageQuery = mysqli_query($packageSql);
				$packageData = mysqli_fetch_array($packageQuery);
          		?>
          		<h3><?php echo $packageData['pacakageName'];?></h3>
          		</div>	 </th>
      </tr>
	  <th colspan="8" align="left" class="header" >
	   <div >
          		<div >
          		<?php 
                $r_images = array_map('trim', explode(",", rtrim($queryDetailData['images'],','))); 
                foreach ($r_images as $value) {
                ?>  
                <img src="upload/<?php echo $value;?>" class="review_img">
                <?php
                }
                ?>
          		</div>				</th>
      </tr>
	  <th colspan="8" align="left" class="header" ><div >
          		          		<div >
          			<div class="review_title">
          				<h3><?php  echo stripslashes($queryDetailData['title']); ?></h3>	
          			</div>
            		<p><?php  echo stripslashes($queryDetailData['description']); ?></p>
				</div></th>
      </tr>
   <tr>
      <th width="5%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
      <th align="left" class="header" >SR. NO.</th>
      <th align="left" class="header" >COMMENT</th>

	 <th  align="left" class="header" >Status</th>
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
  
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].')';  
 
$where='where review_id='.$id.' order by createdOn desc '; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 
$rs=GetRecordList($select,_PACKAGE_REVIEW_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
/*$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);*/

?>
  <tr>
    <td align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
    <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
    <td width="7%" align="left"><span class="graylist"><?php echo ++$start; ?></span></td>
    <td width="80%" align="left"><?php  echo stripslashes($resultlists['description']); ?></td>
	

	<td width="8%" align="left">
	<?php if($resultlists['status']==1){ ?>
		            <a href="showpage.crm?module=cms&page=view-review&cid=<?php echo $resultlists['id']; ?>&status=0&id=<?php echo $id;?>" onclick="globalloading();">
		            	<img src="images/unlock.png" width="30" border="0" />		            </a>
		            <?php } else { ?>
		            <a href="showpage.crm?module=cms&page=view-review&cid=<?php echo $resultlists['id']; ?>&status=1&id=<?php echo $id;?>" onclick="globalloading();">
		            	<img src="images/lock.png" />		            </a>
		        <?php } ?>	</td>
  </tr>
  
 
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No Comments<?php //echo $pageName; ?></div>
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