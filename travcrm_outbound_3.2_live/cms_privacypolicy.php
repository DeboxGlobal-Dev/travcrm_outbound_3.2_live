<?php 
$privacy_id='1';
$terms_id='2';
 

/*-----------------Edit Commond---------------*/

if($_REQUEST['edit']=="edit")

{ 
if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}
$remove=$_POST['remove'];
if($remove=='1'){$image='';}

$title=addslashes($_POST['title']);

$home_text=addslashes($_POST['home_text']); 
$description=addslashes($_POST['description']);
$edituser=$_SESSION['username'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];

$namevalue ='title="'.$title.'",home_text="'.$home_text.'",description="'.$description.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",feature_img="'.$image.'"'; 

   $where='id="'.$privacy_id.'"';  
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 

///////terms and conditions///////////

$title=addslashes($_POST['title2']);

$home_text=addslashes($_POST['home_text2']); 
$description=addslashes($_POST['description2']);
$edituser=$_SESSION['username'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];

$namevalue ='title="'.$title.'",home_text="'.$home_text.'",description="'.$description.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",feature_img="'.$image.'"'; 

   $where='id="'.$terms_id.'"';  
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 

 header("location:showpage.crm?module=cms&page=privacypolicy&alt=2");		

}


$select1='*';  
$where1='id="'.$privacy_id.'"'; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$title=clean($editresult['title']); 
$home_text=clean($editresult['home_text']); 
$description=stripslashes($editresult['description']); 
$feature_img=clean($editresult['feature_img']);

$select1='*';  
$where1='id="'.$terms_id.'"'; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$title2=clean($editresult['title']); 
$home_text2=clean($editresult['home_text']); 
$description2=stripslashes($editresult['description']); 
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
        selector: "#description2",
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
            <?php if($_GET['id']!=''){ ?>
            Update
            <?php } else { ?>
            Update Privacy Policy
            <?php } ?>
            <?php //echo $pageName; ?> 
          </span>
        </div>
      </td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <a href="showpage.crm?module=cms" class="bluembutton submitbtn"> Back </a>
            </td>
            <td>
              <input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value=" Save "  onclick="formValidation('addeditfrm','submitbtn','0');"  />
            </td>
             
            <td style="padding-right:20px;">
<!--<?php if($_REQUEST['rpage']!=''){ ?>
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
<div id="pagelisterouter" class="cmsPageBox" style="padding-top: 20px!important;">

 
  <div class="addeditpagebox">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="left" valign="top" ><div class="innerbox">
        <h2>Privacy Policy</h2>
      </div></td>
      </tr>
    <tr>
      <td width="50%" align="left" valign="top" style="padding-right:20px;">
  	
  	<div class="griddiv" style="display:none;">
  	<label>
  	<div class="gridlable">Heading <span class="redmind"></span></div>
  	<input name="home_text" type="text" id="home_text" value="<?php  echo $home_text; ?>"   class="gridfield validate"  autocomplete="off" />
  	</label>
  	</div>
  	
  	
  	  
  	 
  	
  	  		
  	
  	
  		</td>
      <td width="50%" align="left" valign="top" style="padding-left:20px;">
  	
   </td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"  >
        	
        	 
        	<div class="griddiv">
          	<label>
            	<div class="gridlable">Title (Privacy Policy)<span class="redmind"></span></div>
            	<input name="title" type="text" id="title" value="<?php  echo $title; ?>"   class="gridfield validate"  autocomplete="off" />
          	</label>
        	</div>
        	
        	<div class="griddiv">
            <label>
            	<div class="gridlable">Description (Privacy Policy)</div>
            	<textarea name="description" rows="10" class="gridfield" id="description"><?php echo $description; ?></textarea>
        	  </label>
        	</div>

        		
      	</td>
      </tr>
    </table>
    <br />

  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="left" valign="top" ><div class="innerbox">
        <h2>Terms & Conditions</h2>
      </div></td>
      </tr>
    <tr>
      <td width="50%" align="left" valign="top" style="padding-right:20px;">
  	
  	<div class="griddiv" style="display:none;">
  	<label>
  	<div class="gridlable">Heading <span class="redmind"></span></div>
  	<input name="home_text2" type="text" id="home_text2" value="<?php  echo $home_text2; ?>"   class="gridfield validate"  autocomplete="off" />
  	</label>
  	</div>
  	
  	
  	  
  	 
  	
  	  		
  	
  	
  		</td>
      <td width="50%" align="left" valign="top" style="padding-left:20px;">
  	
   </td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="top"  >
      	<div class="griddiv">
        	<label>
          	<div class="gridlable">Title (Terms & Conditions)<span class="redmind"></span></div>
          	<input name="title2" type="text" id="title2" value="<?php  echo $title2; ?>"   class="gridfield validate"  autocomplete="off" />
        	</label>
      	</div>
      	
      	<div class="griddiv"><label>
        	<div class="gridlable">Description (Terms & Conditions)</div>
        	<textarea name="description2" rows="10" class="gridfield" id="description2"><?php echo $description2; ?></textarea>
        	</label>
      	</div>
      	
      <!--<div class="griddiv" style="overflow:hidden;"><label>
      	<div class="gridlable">Image</div>
      	<div style="overflow:hidden;"><input type="file" name="file1" id="file1"  class="gridfield" style="width:200px; float:left;"/>
      	<input name="feature_img2" type="hidden" class="grybutton" id="feature_img2" value="<?php echo $feature_img2; ?>"/></div>
      	</label>
      	</div>
      	

      	<table width="160" border="0" cellspacing="0" cellpadding="0" style="width:300px; float:left;">
      <?php if($feature_img!=""){ ?>
      		<tr>
                <td width="83%" align="left" valign="top"><strong>OR</strong><br /><br />

      </td>
              </tr>
      		<tr>
                	<td width="83%" align="left" valign="top">
      			 	<img src="upload/<?php echo $feature_img; ?>" width="67"  />


      				<input name="feature_img" type="hidden" id="feature_img" value="<?php echo $feature_img; ?>" /> &nbsp;&nbsp;<table width="37%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>Remove it:</td>
          <td>&nbsp;</td>
          <td><input name="remove" type="checkbox" id="remove" value="1"  style="display:block; "/></td>
        </tr>
      </table>			</td>
              </tr>
      		<?php } ?>
      </table>-->


      		
      	</td>
      </tr>
  </table>

</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
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