<?php 
  $type='aboutus';
  include 'smart_resize_image.function.php';


  /*-----------------Edit Commond---------------*/

  if($_REQUEST['edit']=="edit") { 

   	// company images upload //
  	if($_FILES['image2']['name']!=''){
    		$post_img = $_FILES['image2']['name'];
    		$temp_img = $_FILES['image2']['tmp_name'];//full path of the image of OR temp path of the file
    		// get the full size image
    		if(makeDir('upload/') === true){
      			$fileName = getfilename($post_img); // rename the file befor upload
      			$directoryName ='upload/';
      			$image2 = $directoryName.$fileName; // uploaded file path with customize name
      			$width      = 570; //$_POST['width'];
      			$height     = 350; //$_POST['height'];
      			$quality    = 100;//$_POST['quality'];
      			smart_resize_image($temp_img , null, $width , $height , false , $image2 , false , false ,$quality ); //excute the code to resize image
    		} 
  	} 
    else{
  		  $image2=$_REQUEST['image21'];
  	}

  	// about us images upload *************************************************************************
  	if($_FILES['image1']['name']!=''){
    		$post_img = $_FILES['image1']['name'];
    		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
    		// get the full size image
    		if(makeDir('upload/') === true){
      			$fileName = getfilename($post_img); // rename the file befor upload
      			$directoryName ='upload/';
      			$image1 = $directoryName.$fileName; // uploaded file path with customize name
      			$width      = 570; //$_POST['width'];
      			$height     = 302; //$_POST['height'];
      			$quality    = 100;//$_POST['quality'];
      			smart_resize_image($temp_img , null, $width , $height , false , $image1 , false , false ,$quality ); 
            //excute the code to resize image
    		}
  	}
    else{
  		  $image1=$_REQUEST['image11'];
  	}
  	// image code **************************************************************************
  	

    $title=addslashes($_POST['title']);
    $home_text=addslashes($_POST['home_text']); 
    $detail1=addslashes($_POST['detail1']); 
    $shortdescription=addslashes($_POST['shortdescription']);
    $description=addslashes($_POST['description']);
    $edituser=$_SESSION['username'];
    $edit_date=date("Y-m-d H:i:s");
    $lastip=$_SERVER['REMOTE_ADDR'];

    $namevalue ='title="'.$title.'",home_text="'.$home_text.'",detail1="'.$detail1.'",description="'.$description.'",shortdescription="'.$shortdescription.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",image2="'.$image2.'",image1="'.$image1.'"'; 

      $where='type="'.$type.'"';  
      $update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 

     header("location:showpage.crm?module=cms&module=cms");		

  }


  $select1='*';  
  $where1='type="'.$type.'"'; 
  $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
  $editresult=mysqli_fetch_array($rs1);
  // about us
  $title=clean($editresult['title']); 
  $home_text=clean($editresult['home_text']); 
  $detail1=clean($editresult['detail1']); 
  $description=clean($editresult['description']); 
  $image1=clean($editresult['image1']);
  $image2=clean($editresult['image2']);
  // about company
  $shortdescription=$editresult['shortdescription']; 


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
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<form action="" method="post" enctype="multipart/form-data">
  <div class="rightsectionheader">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><a href="showpage.crm?module=cms"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a>
          <?php if($_GET['id']!=''){ ?>
          <!-- Update -->
          <?php } else { ?>
          
          <?php } ?>
            <?php echo "About Us"; ?> </span></div></td>
        <td align="right"><table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
              <td><input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  /></td>
               
              <td style="padding-right:20px;">

              </td>
            </tr>
        </table></td>
      </tr>
    </table>
  </div>
  <div id="pagelisterouter" class="cmsPageBox">

   
    <div class="addeditpagebox">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
       <!--  <tr>
          <td colspan="2" align="left" valign="top" >
            <div class="innerbox" style="margin-top: 20px;display: block;z-index: 9;">
               <h2 style="line-height: 38px;"><span style="padding: 5px 10px;border:1px solid #ccc; border-radius: 15px; color:#e97713"> About Us</span></h2>
            </div>
          </td>
        </tr> -->
    
        <tr>
          <td  align="left"  valign="top"  >
            <div class="griddiv">
              <label>
                <div class="gridlable">Title <span class="redmind"></span></div>
                <input name="title" type="text" id="title" value="<?php  echo $title; ?>"   class="gridfield validate"  autocomplete="off" />
              </label>
            </div>
          </td>
          <td   align="left" valign="top"  >
            <div class="griddiv" style="overflow:hidden;border:0px solid">
              <label>
                <div class="gridlable">&nbsp;</div>
                <div style="overflow:hidden;margin-left:50px;" ><input type="file" name="image1" id="image1"  class="gridfield form-control" style="height: 35px;"/></div>
              </label>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"  >
            <div class="griddiv" >
              <label>
                <div class="gridlable">Heading <span class="redmind"></span></div>
                <!-- <textarea name="home_text" rows="4" class="gridfield" id="home_text"><?php echo $home_text; ?></textarea> -->
                <input name="home_text" type="text" id="home_text" value="<?php  echo $home_text; ?>"   class="gridfield validate"  autocomplete="off" />
              </label>
            </div>
            <div class="griddiv">
              <label>
                <div class="gridlable">Description</div>
                <textarea name="description" rows="10" class="gridfield" id="description"><?php echo $description; ?></textarea>
              </label>
            </div>
            
          </td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top" >
            <div style="width: 400px;position: relative;display: inline-block;overflow: hidden;">
                <?php if($image1!=""){ ?>
                    <img src="<?php echo $image1; ?>" style="width: 100%;height:100%;object-fit: contain;position: relative;" />
                    <input name="image11" type="hidden" id="feature_img" value="<?php echo $image1; ?>" />
                <?php } ?>
            </div>
          </td>
        </tr>
    <!--       <tr>
          <td colspan="2" align="left" valign="top" >
            <div class="innerbox" style="margin-top: 20px;display: block;z-index: 9;">
               <h2 style="line-height: 38px;"><span style="padding: 5px 10px;border:1px solid #ccc; border-radius: 15px; color:#e97713 "> Company information</span></h2>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center" valign="top" >
             <table width="50%" border="0" cellspacing="0" cellpadding="0" style="width:400px;">
                <?php if($image2!=""){ ?>
                <tr>
                  <td width="17%" align="left" valign="top">&nbsp;</td>
                  <td width="83%" align="left" valign="top"><strong></strong></td>
                </tr>
                <tr>
                  <td width="17%" align="left" valign="top">&nbsp;</td>
                  <td width="83%" align="left" valign="top">
                    <img src="<?php echo $image2; ?>" width="200"  />
                    <input name="image21" type="hidden" id="image21" value="<?php echo $image2; ?>" />
                  </td>
                </tr>
                <?php } ?>
              </table>
            </td>
        </tr>
         <tr>
          <td  align="left"  valign="top"  >
            <div class="griddiv">
              <label>
                <div class="gridlable" style="padding: 5px 0">Title <span class="redmind"></span></div>
                <input name="detail1" type="text" id="detail1" value="<?php  echo $detail1; ?>"   class="gridfield validate"  autocomplete="off" />
              </label>
            </div>
          </td>
          <td   align="left" valign="top"  >
            <div class="griddiv" style="overflow:hidden;">
              <label>
                <div class="gridlable">&nbsp; Select Image</div>
                <div style="overflow:hidden;margin-left:50px;" ><input type="file" name="image2" id="image2"  class="gridfield form-control" style="height: 35px;"/></div>
              </label>
            </div>
          </td>
        </tr>
   -->
    <!--        <tr>
          <td  align="left" colspan="2" valign="top"  >
            <div class="griddiv">
              <label>
                <div class="gridlable" style="padding: 5px 0;">Company Information </div>
                <textarea name="shortdescription" rows="10" class="gridfield" id="shortdescription"><?php echo $shortdescription; ?></textarea>
              </label>
            </div>
          </td>
        </tr>
   -->
      </table>
  </div>
  <div class="rightfootersectionheader">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td> 
  		<input name="edit" type="hidden" id="edit" value="edit" />
  		<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
  		
  	 
  		</td>
          <td><input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  />
  		
  		<!--<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
          
          <td style="padding-right:20px;"><?php if($_REQUEST['rpage']!=''){ ?>
      <a href="<?php echo decode($_REQUEST['rpage']); ?>"><input type="button" name="Submit22" value="Cancel" class="whitembutton"/></a>
      <?php } else { ?>
      <input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  />
      <?php } ?>-->
      </td>
        </tr>
        
      </table></td>
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
  if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp) {
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