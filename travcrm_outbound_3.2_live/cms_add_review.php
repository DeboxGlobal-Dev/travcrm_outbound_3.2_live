<?php 

	/*-----------------Add Review---------------*/
	if($_REQUEST['action']=="add") { 
		$reviewId=addslashes($_POST['reviewId']);
		$title=addslashes($_POST['title']);
		$blog_comment=addslashes($_POST['blog_comment']);
		$createdBy=$_POST['createdBy'];
		$comment_id=$_POST['comment_id'];
		$review_star=$_POST['review_star'];

		$createdOn=date("Y-m-d H:i:s");
		$namevalue ='title="'.$title.'",blog_comment="'.$blog_comment.'",comment_id="'.$comment_id.'",review_star="'.$review_star.'",createdBy="'.$createdBy.'",createdOn="'.$createdOn.'"'; 
	   	// $where='id="'.$reviewId.'"';  
		$add = addlisting(_BLOG_COMMENT_,$namevalue); 
	 	header("location:showpage.crm?module=cms&page=review&subpage=".$_REQUEST['backpage']."&alt=1");		
	}

	/*-----------------Edit Review---------------*/
	if($_REQUEST['action']=="edit") { 
		$reviewId=addslashes($_POST['reviewId']);
		$title=addslashes($_POST['title']);
		$blog_comment=addslashes($_POST['blog_comment']);
		$createdBy=$_POST['createdBy'];
		$review_star=$_POST['review_star'];
		$updatedOn=date("Y-m-d H:i:s");
		$comment_id=$_POST['comment_id'];
		$namevalue ='title="'.$title.'",blog_comment="'.$blog_comment.'",comment_id="'.$comment_id.'",review_star="'.$review_star.'",createdBy="'.$createdBy.'", updatedOn="'.$updatedOn.'"'; 
	   	$where='id="'.$reviewId.'"';  
		$update = updatelisting(_BLOG_COMMENT_,$namevalue,$where); 
	 	header("location:showpage.crm?module=cms&page=review&subpage=".$_REQUEST['backpage']."&alt=2");		
	}

	$reviewId=$_REQUEST['id'];
	$select1='*';  
	$where1='id="'.$reviewId.'"'; 
	$rs1=GetPageRecord($select1,_BLOG_COMMENT_,$where1); 
	$editresult=mysqli_fetch_array($rs1);

	$title=clean($editresult['title']); 
	$createdBy=clean($editresult['createdBy']); 
	$blog_comment=$editresult['blog_comment']; 
	$comment_id=clean($editresult['comment_id']);
?>

	<script src="tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "#blog_comment",
			themes: "modern",
			plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
	</script>
	
	
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<form action="" method="post" enctype="multipart/form-data">
		<div class="rightsectionheader">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		      	<td>
		      	<div class="headingm" style="margin-left:20px;">
		      		<span id="topheadingmain">
		      			<a href="showpage.crm?module=cms&page=review&subpage=<?php echo $_REQUEST['backpage']; ?>">
		      				<img src="images/backicon.png" width="20" style=" cursor:pointer;">
		      			</a>
		      			<span>
				        <?php if($_REQUEST['id']!=''){ ?>
				        Update
				        <?php } else { ?>
				        Add
				        <?php } ?>
						<?php echo ucfirst($editresult['type']); ?> 
						</span>
					</div>
				</td>
		  		<td align="right">
		  			<table border="0" cellpadding="0" cellspacing="0">
			          <tr>
			            <td></td>
			            <td>
			            	<input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');"/></td>
			            <td style="padding-right:20px;">
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			          </tr>
			      	</table>
			  	</td>
			</tr>
		  </table>
		</div>
		<style type="text/css">
			.w30{
			   width: 30%;
			   display: inline-block;
			}
			.pd15{
				padding-right: 20px;
		   		padding-left: 20px;
		   		border-bottom: 0px #eee solid!important;
			}
			.mg15_{
				    margin-right: -20px;
		    		margin-left: -20px;
			}
		</style>
		<div id="pagelisterouter"  class="cmsPageBox">
			<div class="addeditpagebox">
			  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  	<tr>
					    <td colspan="2" align="left" valign="top"  >
					    	<div class="mg15_">
								<?php if( $editresult['type'] == 'package') { ?>
								<div class="griddiv w30 pd15">
									<label>
										<div class="gridlable">Title </div>
										<input type="text" name="title" id="title" value="<?php echo $title; ?>" class="gridfield validate" autocomplete="off">
									</label>
								</div>
								<?php } ?>
								<div class="griddiv w30 pd15">
									<label>
										<div class="gridlable">Select User</div>
										<select id="createdBy" name="createdBy" class="gridfield " autocomplete="off"   >
								          	<?php 
								          	if ($editresult['userType'] == 2) {
								      			$reviewUserSql="select * from corporateMaster where username!='' order by username asc";
								          	}else{
								      			$reviewUserSql="select * from contactsMaster where username!='' order by username asc";
								          	}
										    $reviewUserQuery = mysqli_query($reviewUserSql);
										    while($reviewUserData = mysqli_fetch_array($reviewUserQuery)){
								      		?>
											<option value="<?php echo $reviewUserData['id'];?>" <?php if($createdBy==$reviewUserData['id']){ ?>selected="selected"<?php } ?>>
												<?php echo $reviewUserData['username'];?>
											</option>
											<?php 
											}
								      		?>
										</select>
									</label>
								</div>
								
								<div class="griddiv w30 pd15">
									<label>
										<div class="gridlable">Select <?php echo ucfirst($editresult['type']); ?></div>
										<select name="blog_id" id="blog_id" class="gridfield " autocomplete="off"   >
											<?php 
											if ( $editresult['type'] == 'package') {
												$packageSql = "select * from packageBuilderDetail where status ='1' order by pacakageName asc";
											}elseif ($editresult['type'] == 'hotel') {
												$packageSql = "select * from packageBuilderHotelMaster where status ='1' order by hotelName asc";
											}elseif ($editresult['type'] == 'destn') {
												$packageSql = "select * from destinationMaster where status ='1' and deletestatus=0 order by name asc";
											}else{
												$packageSql = "select * from post_list where status ='1' and type='blog' order by title asc";
											}
								      		
											$packageQuery = mysqli_query($packageSql);
										    while($itemData = mysqli_fetch_array($packageQuery)){
										    	if ( $editresult['type'] == 'package') {
													$itemName = $itemData['pacakageName']; 
												}elseif ($editresult['type'] == 'hotel') {
													$itemName = $itemData['hotelName']; 
												}elseif ($editresult['type'] == 'destn') {
													$itemName = $itemData['name']; 
												}else{
													$itemName = $itemData['title']; 
												}
									      		?>
									        	<option value="<?php echo $itemData['id'];?>" <?php if($blog_id==$itemData['id']){ ?>selected="selected"<?php } ?>><?php echo $itemName;?></option>
									      		<?php 
											}
								      		?>
								      	</select> 
									</label>
								</div>
					    	</div>
							<div class="griddiv">
								<label>
									<div class="gridlable">Description</div>
									<textarea name="blog_comment" rows="10" class="gridfield" id="blog_comment"><?php echo stripslashes($blog_comment); ?></textarea>
								</label>
							</div>
							<?php if( $editresult['type'] == 'package') { ?>
							<div class="griddiv">
								<label>
									<div class="gridlable">Review Star</div>
									<select name="review_star" id="review_star" class="gridfield " autocomplete="off"   >
										<option value="1" <?php if($editresult['review_star']==1){ ?>selected="selected"<?php } ?>>1 Star</option>
										<option value="2" <?php if($editresult['review_star']==2){ ?>selected="selected"<?php } ?>>2 Star</option>
										<option value="3" <?php if($editresult['review_star']==3){ ?>selected="selected"<?php } ?>>3 Star</option>
										<option value="4" <?php if($editresult['review_star']==4){ ?>selected="selected"<?php } ?>>4 Star</option>
										<option value="5" <?php if($editresult['review_star']==5){ ?>selected="selected"<?php } ?>>5 Star</option>
									 </select>
								</label>
							</div>
							<?php } ?>
						 	
							<!-- 	<div class="griddiv">
								<label>
									<div class="gridlable">Image</div>
									<input type="file" name="file1" id="file1"  class="gridfield"/>
									<input name="feature_img2" type="hidden" class="grybutton" id="feature_img2" value="<?php echo $feature_img2; ?>"/>
								</label>
							</div> -->
							<!--<table width="50%" border="0" cellspacing="0" cellpadding="0">
								<?php if($feature_img!=""){ ?>
								<tr>
						          <td width="17%" align="left" valign="top">&nbsp;</td>
						          <td width="83%" align="left" valign="top"><strong>OR</strong></td>
						        </tr>
								<tr>
							      	<td width="17%" align="left" valign="top">&nbsp;</td>
							      	<td width="83%" align="left" valign="top">
									 	<img src="upload/<?php echo $feature_img; ?>" width="67"  />
										<input name="feature_img" type="hidden" id="feature_img" value="<?php echo $feature_img; ?>" />
									</td>
							    </tr>
								<?php } ?>
							</table> -->
						</td>
				    </tr>
				</table>
			</div>
			<div class="rightfootersectionheader">
				
				<table border="0" cellpadding="0" cellspacing="0">
			      	<tr>
			      		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			        	<td>
			        		<input name="action" type="hidden"  value="<?php if($_REQUEST['id']!=''){ echo("edit"); }else{ echo("add"); }?>" />
                			<input name="reviewId" type="hidden" value="<?php echo $reviewId; ?>" />
			        		<input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  />
			        	</td>
			      	</tr>
				</table>
			</div>
		</div>
	</form>
<script>  

function changePriority(){
	var adult = $('#adult').val();
	if(adult>9){ 
		$('#queryPriority').val('3');
	} 
}

window.setInterval(function(){
	changePriority()
}, 1000);
comtabopenclose('linkbox','op2');
function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
}
function showDays(firstDate,secondDate){ 
  var startDay = new Date(firstDate);
  var endDay = new Date(secondDate);
  var millisecondsPerDay = 1000 * 60 * 60 * 24;

  var millisBetween = startDay.getTime() - endDay.getTime();
  var days = millisBetween / millisecondsPerDay;

  // Round down.
  return ( Math.floor(days));
}

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  var night = totaldays;
if(night<6){
$('#queryPriority').val('3');
}
  } 
} 




</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}

</style>
<script type="text/javascript">
	$('#createdBy').select2();
</script>