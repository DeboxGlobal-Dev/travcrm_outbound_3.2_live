<?php 
$type='other_offices';
$pageName = "Office Details";
// include 'smart_resize_image.function.php';
$resultId = $_REQUEST['id'];
/*-----------------Edit our team---------------*/
if($_REQUEST['action']=="edit" && $_REQUEST['otherofficesId']!=""){
// 	// about us images upload *************************************************************************
// 	if($_FILES['image1']['name']!=''){ 
// 		$post_img = $_FILES['image1']['name'];
// 		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
// 		// get the full size image
// 		if(makeDir('upload/otheroffices/') === true){
// 			$fileName = getfilename($post_img); // rename the file befor upload
// 			$directoryName ='upload/otheroffices/';
// 			$image = $directoryName.$fileName; // uploaded file path with customize name
// 			$width      = 250; //$_POST['width'];
// 			$height     = 250; //$_POST['height'];
// 			$quality    = 80;//$_POST['quality'];
// 			smart_resize_image($temp_img , null, $width , $height , false , $image , false , false ,$quality ); //excute the code to resize image
// 		} 
// 	} else {
// 		$image=$_REQUEST['image11'];
// 	}
	// image code **************************************************************************
	
  $srn=addslashes($_POST['srn']); //office srn
  $title=addslashes($_POST['title']); //office contact number
  $email=addslashes($_POST['email']); //designation
  // $heading=addslashes($_POST['heading']); //office name
  // $detail1=addslashes($_POST['detail1']); //designation
  // $detail2=addslashes($_POST['detail2']); //designation
  // $detail3=addslashes($_POST['detail3']); //designation
  // $detail4=addslashes($_POST['detail4']); //designation
  // $detail5=addslashes($_POST['detail5']); //designation
    $description=addslashes($_POST['description']); //office details
    $shortdescription=addslashes($_POST['shortdescription']); //office details
    $otherofficesId=addslashes($_POST['otherofficesId']); //office name
    $edituser=$_SESSION['username']; 
    $edit_date=date("Y-m-d H:i:s");
    $lastip=$_SERVER['REMOTE_ADDR'];

    $namevalue ='title="'.$title.'",email="'.$email.'",detail1="'.$detail1.'",detail2="'.$detail2.'",detail3="'.$detail3.'",detail4="'.$detail4.'",detail5="'.$detail5.'",type="'.$type.'",srn="'.$srn.'",description="'.$description.'",shortdescription="'.$shortdescription.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",image1="'.$image.'"'; 
    $where='id="'.$otherofficesId.'"';  
    $update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 
      header("location:showpage.crm?module=cms&page=otheroffices&alt=2");		
}

/*-----------------Edit our team---------------*/
if($_REQUEST['action']=="add"){
// 	// about us images upload *************************************************************************
// 	if($_FILES['file1']['name']!=''){ 
// 		$post_img = $_FILES['file1']['name'];
// 		$temp_img = $_FILES['file1']['tmp_name'];//full path of the image of OR temp path of the file
// 		// get the full size image
// 		if(makeDir('upload/otheroffices/') === true){
// 			$fileName = getfilename($post_img); // rename the file befor upload
// 			$directoryName ='upload/otheroffices/';
// 			$image = $directoryName.$fileName; // uploaded file path with customize name
// 			$width      = 250; //$_POST['width'];
// 			$height     = 250; //$_POST['height'];
// 			$quality    = 80;//$_POST['quality'];
// 			smart_resize_image($temp_img , null, $width , $height , false , $image , false , false ,$quality ); //excute the code to resize image
// 		} 
// 	} else {
// 		$image=$_REQUEST['image11'];
// 	}
	// image code **************************************************************************
	
  $srn=addslashes($_POST['srn']); //office name
  $title=addslashes($_POST['title']); //office name
  $heading=addslashes($_POST['heading']); //office name
  $email=addslashes($_POST['email']); //designation

  // $detail1=addslashes($_POST['detail1']); //designation
  // $detail2=addslashes($_POST['detail2']); //designation
  // $detail3=addslashes($_POST['detail3']); //designation
  // $detail4=addslashes($_POST['detail4']); //designation
  // $detail5=addslashes($_POST['detail5']); //designation
  $description=addslashes($_POST['description']); //office details
  $shortdescription=addslashes($_POST['shortdescription']); //office details
  $adduser=$_SESSION['username']; 
  $add_date=date("Y-m-d H:i:s");
  $lastip=$_SERVER['REMOTE_ADDR'];

  $namevalue ='title="'.$title.'",email="'.$email.'",detail1="'.$detail1.'",detail2="'.$detail2.'",detail3="'.$detail3.'",detail4="'.$detail4.'",detail5="'.$detail5.'",type="'.$type.'",srn="'.$srn.'",shortdescription="'.$shortdescription.'",description="'.$description.'",adduser="'.$adduser.'",add_date="'.$add_date.'",lastip="'.$lastip.'",image1="'.$image.'"'; 
  $add = addlisting(_POST_LIST_MASTER_,$namevalue);  
    header("location:showpage.crm?module=cms&page=otheroffices&alt=1");    
}

  $select1='*';  
  $where1='id="'.$resultId.'"'; 
  $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
  $editresult=mysqli_fetch_array($rs1);

  $srn=clean($editresult['srn']); //serial number of the office by sorting for 
  $title=clean($editresult['title']); //contact number fo the s the multiple addres
  $email=clean($editresult['email']); //email address multiple 
  $description=$editresult['description']; //office address
  $shortdescription=$editresult['shortdescription']; //map location
  $otherofficesId=$editresult['id']; // single office address id for edit purpose 
  $image1=clean($editresult['image1']); //there no imiage for office address editing time
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
              <div class="headingm" style="margin-left:20px;">
                <span id="topheadingmain"><a href="showpage.crm?module=cms"><img src="images/backicon.png" width="20" style=" cursor:pointer;"></a>
                  <?php if($_GET['id']!=''){ ?>
                  Update
                  <?php } else { ?>
                  Add
                  <?php } ?>
                  <?php echo $pageName; ?> 
                </span>
              </div>
            </td>
              <td align="right">
                <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td></td>
                    <td><!-- <input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  /> --></td>
                    <td style="padding-right:20px;">
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
<!--           <tr>
            <td colspan="2" align="left" valign="top" >
              <div class="innerbox">
                <h2><?php echo $pageName; ?> </h2>
              </div>
            </td>
          </tr> -->
          <tr>
            <td colspan="2" align="left" valign="top"  >
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" colspan="5" valign="top" >
                      <div class="griddiv" >
                        <label>
                          <div class="gridlable">Sr. No <span class="redmind"></span></div>
                          <input name="srn" type="number" id="srn" value="<?php  echo $srn; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left"  colspan="5" valign="top" >
                      <div class="griddiv" >
                        <label>
                          <div class="gridlable" style="width: 100%!important;">Contact Number ( Use comma for multiple numbers like +91 9999999,+91 99990000)<span class="redmind"></span></div>
                          <input name="title" type="text" id="title" value="<?php  echo $title; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" colspan="5" valign="top" >
                      <div class="griddiv" >
                        <label>
                          <div class="gridlable" style="width: 100%!important;">Email ( Use comma for multiple email address like abc@gmail.com,abc@gmail.com)<span class="redmind"></span></div>
                          <input name="email" type="text" id="email" value="<?php  echo $email; ?>" class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                  </tr>
                  <!-- <tr>
                    <td  colspan="5" align="left" valign="top" >
                      <div style="margin: 15px auto ; ">Fill the social profile fields ( full url ), All of Optional</div>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" >
                      <div class="griddiv" style="width:94%;">
                        <label>
                          <div class="gridlable">Facebook <span class="redmind"></span></div>
                          <input name="detail1" type="text" id="fb_url" value="<?php  echo $fb_url; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                    <td align="left" valign="top" >
                      <div class="griddiv"  style="width:92%;">
                        <label>
                          <div class="gridlable">Instagram  <span class="redmind"></span></div>
                          <input name="detail2" type="text" id="insta_url" value="<?php  echo $insta_url; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                    <td align="left" valign="top" >
                      <div class="griddiv" style="width:92%;">
                        <label>
                          <div class="gridlable">Twitter <span class="redmind"></span></div>
                          <input name="detail3" type="text" id="twitter_url" value="<?php  echo $twitter_url; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                    <td align="left" valign="top" >
                      <div class="griddiv" style="width:92%;">
                        <label>
                          <div class="gridlable">LinkedIn <span class="redmind"></span></div>
                          <input name="detail4" type="text" id="linkedIn" value="<?php  echo $linkedIn; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                    <td align="left" valign="top" >
                      <div class="griddiv" style="width: 100%;">
                        <label>
                          <div class="gridlable">Pinterest <span class="redmind"></span></div>
                          <input name="detail5" type="text" id="linkedIn" value="<?php  echo $linkedIn; ?>"   class="gridfield validate"  autocomplete="off" />
                        </label>
                      </div>
                    </td>
                  </tr> -->
 <!--                  <tr>
                    <td align="left" colspan="1" valign="top" >

                      <div class="griddiv" style="overflow:hidden;margin-top: 20px; ">
                        <label>
                          <div class="gridlable">Photo</div>
                          <div style="overflow:hidden;"><input type="file" name="image1" id="image1"  class="gridfield" style="width:200px; float:left;"/>
                          <input name="image11" type="hidden" class="grybutton" id="image11" value="<?php echo $image1; ?>"/></div>
                       </label>
                      </div> -->

                     <!--  <table width="50%" border="0" cellspacing="0" cellpadding="0" style="width:200px; float:left;">
                        <?php if($feature_img!=""){ ?>
                          <tr>
                            <td width="17%" align="left" valign="top">&nbsp;</td>
                            <td width="83%" align="left" valign="top"><strong>OR</strong></td>
                          </tr>
                          <tr>
                              <td width="17%" align="left" valign="top">&nbsp;</td>
                              <td width="83%" align="left" valign="top">
                                <img src="upload/<?php echo $feature_img; ?>" width="180"  />
                                <input name="feature_img" type="hidden" id="feature_img" value="<?php echo $feature_img; ?>" />
                             </td>
                          </tr>
                        <?php } ?>
                      </table> 
                    
                    </td>-->
                    <tr>
                      <td align="left" colspan="5" valign="top" >
                        <div class="griddiv">
                          <label>
                              <div class="gridlable">Office Address</div>
                              <textarea name="description" rows="5" class="gridfield"><?php echo stripslashes($description); ?></textarea>
                          </label>
                        </div>
                      </td>
                    </tr>
                   <!--  <tr>
                      <td align="left" colspan="5" valign="top" >
                        <div class="griddiv">
                          <label>
                              <div class="gridlable">Map Location</div>
                              <textarea name="shortdescription" rows="5" class="gridfield"><?php echo stripslashes($shortdescription); ?></textarea>
                          </label>
                        </div>
                      </td>
                    </tr> -->
                </table>
              </td>
            </tr>
        </table>
      </div>

      <div class="rightfootersectionheader" style="">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="right">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td> 
                		<input name="action" type="hidden" value="<?php if($_REQUEST['id']!=''){ echo("edit"); }else{ echo("add"); }?>" />
                		<input name="otherofficesId" type="hidden" value="<?php echo $otherofficesId; ?>" />
              		</td>
                  <td>
                    <input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  />
                  </td>
                </tr>
              </table>
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
      if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp){
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