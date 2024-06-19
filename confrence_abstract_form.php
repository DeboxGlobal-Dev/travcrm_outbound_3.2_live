
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><a href="<?php echo $fullurl; ?>abstract.docx" target="_blank"><input type="button" name="Submit" value="    Download Form    " style="padding: 10px 20px;
    background-color: #18a502;
    color: #fff;
    border: 0px;
    border-radius: 5px;
    cursor: pointer;
    border: 2px solid #ffffff96;"  ></a></td>
    <td style="padding-left:20px;">Click to download abstract form. </td>
  </tr>
</table><br />
<br />

<div style="width:70%; padding:20px 40px; border:1px solid #ccc; background-color:#FBFBFB; margin:auto;">
<style>
.ourtfieldsbx{overflow:hidden; font-size:13px;}
.ourtfieldsbx .lable{margin-bottom:5px;}
.ourtfieldsbx .textfieldclass{border:1px solid #ccc; padding:10px; width:100%; box-sizing:border-box;}

</style>

<iframe src="" style="display:none;" id="abstractformframe" name="abstractformframe"></iframe>
<form action="../../frmaction.php" method="post" enctype="multipart/form-data" name="abstractform" id="abstractform" target="abstractformframe">
<table width="100%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td align="left" valign="top">
	<div class="ourtfieldsbx">
	 <div class="lable">Name of presenting author: <span style="color:#CC3300;">*</span>
	   <input name="action" type="hidden" id="action" value="saveabstractform" />
	   <input name="cid" type="hidden" id="cid" value="<?php echo $resultlists['id']; ?>" />
	 </div>
	  <input name="nameOfPerson" type="text" class="textfieldclass" id="nameOfPerson">
	</div>	</td>
    <td width="50%" align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Affiliation of Presenting author:</div>
	  <input name="nameOfAuthor" type="text" class="textfieldclass" id="nameOfAuthor">
	</div></td>
  </tr>
  <tr>
    <td align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Postal Address: <span style="color:#CC3300;">*</span></div>
	  <input name="address" type="text" class="textfieldclass" id="address">
	</div></td>
    <td align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Mobile: <span style="color:#CC3300;">*</span></div>
	  <input name="mobile" type="text" class="textfieldclass" id="mobile">
	</div></td>
  </tr>
  <tr>
    <td align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Email: <span style="color:#CC3300;">*</span></div>
	  <input name="email" type="text" class="textfieldclass" id="email">
	</div></td>
    <td align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Names and affiliations of co-authors:</div>
	  <input name="nameOfCoAuthors" type="text" class="textfieldclass" id="nameOfCoAuthors">
	</div></td>
  </tr>
  <tr>
    <td align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Type of presentation: <span style="color:#CC3300;">*</span></div>
	   
 
	  <select name="typeOfPersentation"  class="textfieldclass" id="typeOfPersentation">
	    <option value="0">Select</option>
	    <option value="Oral - Original study/ Case Presentation">Oral - Original study/ Case Presentation</option>
	    <option value="Video Presentation">Video Presentation</option>
	    <option value="Poster - Original Study / Case Presentation">Poster - Original Study / Case Presentation</option>
	    </select>
	 
    </div></td>
    <td align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Title of paper: <span style="color:#CC3300;">*</span></div>
	  <input name="titleOfpaper" type="text" class="textfieldclass" id="titleOfpaper">
	</div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><div class="ourtfieldsbx">
	 <div class="lable">Body of abstract (must be within 250 words and in the prescribed format):	<span style="color:#CC3300;">*</span></div>
	  <textarea name="details" rows="5" class="textfieldclass" id="details"></textarea>
	</div></td>
    </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top"><input type="button" name="Submit" value="    Submit    " style="padding: 10px 20px;
    background-color: #0066CC;
    color: #fff;
    border: 0px;
    border-radius: 5px;
    cursor: pointer;
    border: 2px solid #ffffff96;" onClick="submitabstfrm();" /></td>
  </tr>
</table>
</form>


<div style="text-align:center; padding:20px; background-color:#F7F7F7; display:none;" id="thankyouabstractform">
<div style="font-size:25px; color:#009900; margin-bottom:10px;">Thank You</div>
<div style="font-size:15px; ">We will review your submission and will get back to you shortly.</div>


</div>


</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
function submitabstfrm(){
var nameOfPerson = $('#nameOfPerson').val();
var address = $('#address').val();
var mobile = $('#mobile').val();
var email = $('#email').val();
var nameOfCoAuthors = $('#nameOfCoAuthors').val();
var typeOfPersentation = $('#typeOfPersentation').val();
var titleOfpaper = $('#titleOfpaper').val();
var details = $('#details').val();




if(nameOfPerson!='' && address!='' && mobile!='' && email!='' && nameOfCoAuthors!='' && typeOfPersentation!='0' && titleOfpaper!='' && details!=''){ 
$('#abstractform').submit();
} else {

swal({
  title: "System Alert",
  text: "Please fill in the required fields (*)",
  icon: "warning",
  button: "Ok",
});

}


}

</script>