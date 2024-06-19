<?php 
$type='contactus';
/*-----------------Edit Commond---------------*/
if($_REQUEST['edit']=="edit") { 
	if($_FILES['file1']['name']!=''){ 
		echo $file_name=$_FILES['file1']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
		$image=$file_name;
	} 
	else {
		$image=$_REQUEST['feature_img'];
	}
	$activity_duration=addslashes($_POST['activity_duration']);
	$title=addslashes($_POST['title']);
	$email=addslashes($_POST['email']);
	$category=addslashes($_POST['category']);
	$detail1=addslashes($_POST['detail1']);
	$detail2=addslashes($_POST['detail2']);
	$detail3=addslashes($_POST['detail3']);
	$detail4=addslashes($_POST['detail4']);
	$detail5=addslashes($_POST['detail5']);
	$detail6=addslashes($_POST['detail6']);
	$description=addslashes($_POST['description']); 
	$shortdescription=addslashes($_POST['shortdescription']);
	$edituser=$_SESSION['username'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];

	$namevalue ='title="'.$title.'",activity_duration="'.$activity_duration.'",email="'.$email.'",category="'.$category.'",detail1="'.$detail1.'",detail2="'.$detail2.'",detail3="'.$detail3.'",detail4="'.$detail4.'",detail5="'.$detail5.'",detail6="'.$detail6.'",description="'.$description.'",shortdescription="'.$shortdescription.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",feature_img="'.$image.'"'; 
	$where='type="'.$type.'"';  
	$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 

	header("location:showpage.crm?module=cms&page=social&alt=2");		
}

	$select1='*';  
	$where1='type="'.$type.'"'; 
	$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1);

	$title=stripslashes($editresult['title']); 
	$activity_duration=stripslashes($editresult['activity_duration']); 
	$email=stripslashes($editresult['email']); 
	$detail6=stripslashes($editresult['detail6']); 
	$description=stripslashes(($editresult['description'])); 
	$category=stripslashes($editresult['category']);
	$shortdescription=stripslashes($editresult['shortdescription']);
	$detail1=stripslashes($editresult['detail1']);
	$detail2=stripslashes($editresult['detail2']);
	$detail3=stripslashes($editresult['detail3']);
	$detail4=stripslashes($editresult['detail4']);
	$detail5=stripslashes($editresult['detail5']);
?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">
    tinymce.init({
        selector: "#description",
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
      		<div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><a href="showpage.crm?module=cms"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a>
	        <?php if($_GET['id']!=''){ ?>
	        Update
	        <?php } else { ?>
	        Update Contact Us
	        <?php } ?>
	          <?php //echo $pageName; ?> </span></div>
	    </td>
      	<td align="right">
      		<table border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td></td>
	            <td><input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  /></td>
	             
	            <td style="padding-right:20px;">
					<!--<?php if($_REQUEST['rpage']!=''){ ?>
					<a href="<?php echo decode($_REQUEST['rpage']); ?>"><input type="button" name="Submit22" value="Cancel" class="whitembutton"/></a>
					<?php } else { ?>
					<input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
					<?php } ?>-->
				</td>
	          </tr>
	      	</table>
	  	</td>
		</tr>
	</table>
</div>
<div id="pagelisterouter" class="cmsPageBox">
<div class="addeditpagebox">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  	<tr>
		<td colspan="2" align="left" valign="top"  >
	    <!-- 	<div class="griddiv" style="display:none;">
				<label>
					<div class="gridlable">Heading <span class="redmind"></span></div>
					<input name="home_text" type="text" id="home_text" value="<?php  echo $home_text; ?>"   class="gridfield validate"  autocomplete="off" />
				</label>
			</div>
			
			
			<div class="griddiv" style="display: none;">
				<label>
				<div class="gridlable">Available Time <span class="redmind"></span></div>
					<textarea name="activity_duration" rows="10" class="gridfield" id="activity_duration"><?php echo $activity_duration; ?></textarea>
					<script type="text/javascript">
					    tinymce.init({
					        selector: "#shortdescription",
					        themes: "modern",   
					        plugins: [
					            "advlist autolink lists link image charmap print preview anchor",
					            "searchreplace visualblocks code fullscreen" 
					        ],
					        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   
					    });
				    </script>
				</label>
			</div>

			

			 <div class="griddiv" style="display: none;">
			<label>
			<div class="gridlable">Email (+Optional) <span class="redmind"></span></div>
			<input name="detail6" type="text" id="detail6" value="<?php  echo $detail6; ?>"   class="gridfield validate"  autocomplete="off" />
			</label>
			</div>
			
			<div class="griddiv">
				<label>
					<div class="gridlable">Office Address</div>
					<textarea name="description" rows="10" class="gridfield" id="description"><?php echo $description; ?></textarea>
				</label>
			</div>
		 -->

		 	<div class="griddiv">
				<label>
					<div class="gridlable" style="width: 100%!important;">Contact Number (for footer and top header )<span class="redmind"></span></div>
					<input name="title" type="text" id="title" value="<?php  echo $title; ?>"   class="gridfield validate"  autocomplete="off" />
				</label>
			</div>

			<div class="griddiv">
				<label>
					<div class="gridlable" style="width: 100%!important;">Email ( for footer )<span class="redmind"></span></div>
					<input name="email" type="text" id="email" value="<?php  echo $email; ?>"   class="gridfield validate"  autocomplete="off" />
				</label>
			</div>

		 	<div class="griddiv">
				<label>
					<div class="gridlable">Explore India address For footer <span class="redmind"></span></div>
					<input name="category" type="text" id="category" value="<?php  echo $category; ?>"   class="gridfield validate"  autocomplete="off" />
				</label>
			</div>

		 	<div class="griddiv">
				<label>
					<div class="gridlable">Map Location <span class="redmind"></span></div>
					<textarea name="shortdescription" rows="10" class="gridfield" id="shortdescription"><?php echo $shortdescription; ?></textarea>
				</label>
			</div>

			<div class="griddiv">
				<label>
					<div class="gridlable">Facebook <span class="redmind"></span></div>
					<input name="detail1" type="text" id="detail1" value="<?php  echo $detail1; ?>" placeholder="Paster here full url"  class="gridfield "  autocomplete="off" />
				</label>
			</div>

			<div class="griddiv">
				<label>
					<div class="gridlable">Google+ <span class="redmind"></span></div>
					<input name="detail2" type="text" id="detail2" value="<?php  echo $detail2; ?>" placeholder="Paster here full url"  class="gridfield "  autocomplete="off" />
				</label>
			</div>

			<div class="griddiv">
				<label>
					<div class="gridlable">Instagram <span class="redmind"></span></div>
					<input name="detail3" type="text" id="detail3" value="<?php  echo $detail3; ?>" placeholder="Paster here full url"  class="gridfield "  autocomplete="off" />
				</label>
			</div>
			
			<div class="griddiv">
				<label>
					<div class="gridlable">Twitter <span class="redmind"></span></div>
					<input name="detail4" type="text" id="detail4" value="<?php  echo $detail4; ?>" placeholder="Paster here full url"  class="gridfield "  autocomplete="off" />
				</label>
			</div>
			<div class="griddiv">
				<label>
					<div class="gridlable">LinkedIn <span class="redmind"></span></div>
					<input name="detail5" type="text" id="detail5" value="<?php  echo $detail5; ?>" placeholder="Paster here full url"  class="gridfield "  autocomplete="off" />
				</label>
			</div>
		</td>
	</tr>
</table>


</div>

<div class="rightfootersectionheader" style="width: 100%;bckground-color: #fff;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> 
		<input name="edit" type="hidden" id="edit" value="edit" />
		<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
		
	 
		</td>
        <td><input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  />

</td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 



 
</div></form>
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