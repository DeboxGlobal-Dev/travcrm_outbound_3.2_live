<?php 
  $id='4';
  $pageName = "Additional Information";
  $type = "other_info";
  /*-----------------Edit Commond---------------*/
  if($_REQUEST['edit']=="edit") { 
      if($_FILES['file1']['name']!=''){ 
        $file_name=$_FILES['file1']['name']; 
        $ext=$file_name;
        $file_name=str_replace (" ", "",$datef.$ext);
        copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
        $image=$file_name;
      } 
      else {
        $image=$_REQUEST['image2'];
      }
      $remove=$_POST['remove'];
      if($remove=='1'){$image='';}
      // First block 
      $addinfotitle=addslashes($_POST['addinfotitle']);
      $addinfo_description=addslashes($_POST['addinfo_description']);

      $edituser=$_SESSION['username'];
      $edit_date=date("Y-m-d H:i:s");
      $lastip=$_SERVER['REMOTE_ADDR'];
      $namevalue ='title="'.$addinfotitle.'",description="'.$addinfo_description.'",type="'.$type.'",edituser="'.$edituser.'",edit_date="'.$edit_date.'",lastip="'.$lastip.'",image2="'.$image.'"'; 
      $where='id="'.$id.'"';  
      $update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where); 
      // header("location:showpage.crm?module=cms&page=".$_REQUEST['page']."&alt=2");		
  }

  $select1='*';  
  $where1='1 and id=4 and type = "other_info"'; 
  $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
  $editresult=mysqli_fetch_array($rs1);
  // GST information
  $addinfotitle=stripslashes($editresult['title']); 
  $addinfo_description=stripslashes($editresult['description']); 
  $image2=clean($editresult['image2']);
  ?>
  <script src="tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
    tinymce.init({
        selector: "#addinfo_description",
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
        selector: "#quick_description",
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
        Update
        <?php } else { ?>
        Add 
        <?php } ?>
        <?php echo $pageName; ?> </span></div></td>
      <td align="right">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><a href="showpage.crm?module=cms" class="bluembutton submitbtn"> Back </a></td>
            <td>
              <input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="   Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  />
            </td>
            <td style="padding-right:20px;"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" class="cmsPageBox" style="padding-top: 20px!important;">
  <div class="addeditpagebox">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>
        <td colspan="2" align="left" valign="top"  >
    	    <div class="griddiv">
          	<label>
            	<div class="gridlable">Header<span class="redmind"></span></div>
            	<input name="addinfotitle" type="text" id="addinfotitle" value="<?php  echo $addinfotitle; ?>"class="gridfield validate" />
          	</label>
    	    </div>
    	    <div class="griddiv">
            <label>
      	      <div class="gridlable">Description</div>
      	      <textarea name="addinfo_description" rows="10" id="addinfo_description"><?php echo $addinfo_description; ?></textarea>
      	    </label>
    	    </div>
          <div class="griddiv" style="overflow:hidden;">
            <label>
            	<div class="gridlable">Image</div>
            	<div style="overflow:hidden;"><input type="file" name="file1" id="file1"  class="gridfield" style="float:left;"/></div>
          	</label>
        	</div>
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:auto; float:left;">
          <?php if($image2!=""){ ?>
          		<tr>
                  <td width="100%" align="left" valign="top">
            			 	<img src="upload/<?php echo $image2; ?>" width="auto"  />
                  </td>
              </tr>
              <tr>
                  <td width="100%" align="left" valign="top">
                    <br>
                    <br>
                      <strong>OR</strong><br /><br />
                  </td>
              </tr>
              <tr>
              	<td width="100%" align="left" valign="top">
          				<input name="image2" type="hidden" id="image2" value="<?php echo $image2; ?>" /> &nbsp;&nbsp;
                  <table width="37%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Remove it:</td>
                      <td>&nbsp;</td>
                      <td><input name="remove" type="checkbox" id="remove" value="1"  style="display:block; "/></td>
                    </tr>
                  </table>			
                </td>
              </tr>
          <?php } ?>
        </table>
        
  	   </td>
      </tr>
    </table>
  </div>

  <div class="rightfootersectionheader" style="background-color: transparent; width: auto;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right">
          <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td> 
            		<input name="edit" type="hidden" id="edit" value="edit" />
            		<input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
      		    </td>
              <td>
                <input name="Submit" type="submit" class="bluembutton submitbtn" id="Submit" value="  Save   "  onclick="formValidation('addeditfrm','submitbtn','0');"  />
          	   	<!--<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
                <td style="padding-right:20px;"><?php if($_REQUEST['rpage']!=''){ ?>
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