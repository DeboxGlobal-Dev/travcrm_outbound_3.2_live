<?php
include "inc.php"; 
include "config/logincheck.php"; 
 
if($_GET['id']!=''){
$where2=''; 
$rs2='';   
$select2='*'; 
$where2='queryId='.$_GET['id'].''; 
$rs2=GetPageRecord($select2,_ITINERARY_MASTER_,$where2); 
$resultpage2=mysqli_fetch_array($rs2); 
$thankNotes=$resultpage2['thankNotes'];

$emailTemplateId=$resultpage2['emailTemplateId'];

if($_REQUEST['emailTemplateId']!=''){ 
$emailTemplateId=$_REQUEST['emailTemplateId'];
$where2=''; 
$rs2='';   
$select2='*'; 
$where2='id='.$_REQUEST['emailTemplateId'].''; 
$rs2=GetPageRecord($select2,_EMAIL_TEMPLATE_MASTER_,$where2); 
$resemail=mysqli_fetch_array($rs2); 
$thankNotes=$resemail['mailbody'];
}
}
?>




<?php if($_REQUEST['tab']=='3'){ ?>
<script type="text/javascript"> 

tinymce.init({ selector: "#inclusion", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"});

tinymce.init({ selector: "#exclusion", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"});

</script>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight" target="actoinfrm"  id="addflight">  
<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Inclusion:</div>
<textarea name="inclusion" rows="20" class="gridfield" id="inclusion" style="height:220px;"><?php echo stripslashes($resultpage2['inclusion']); ?></textarea>
</div>



<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Exclusion:</div>
<textarea name="exclusion" rows="20" class="gridfield" id="exclusion" style="height:220px;"><?php echo stripslashes($resultpage2['exclusion']); ?></textarea>
</div>
<div style="text-align:right;"><input type="submit" name="Submit" value="    Save    " class="bluembutton" style="margin-top:20px;background-color: #45b558 !important;border: 1px #45b558 solid !important;  margin-top: 0px;">
</div>
<input name="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
<input name="action" type="hidden" value="saveothertab3" />
</form>
<?php } ?>

<?php if($_REQUEST['tab']=='4'){ ?>
<script type="text/javascript"> 

tinymce.init({ selector: "#cost", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"});

tinymce.init({ selector: "#terms", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"});

</script>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight" target="actoinfrm"  id="addflight">  
<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Cost:</div>
<textarea name="cost" rows="20" class="gridfield" id="cost" style="height:220px;"><?php echo stripslashes($resultpage2['cost']); ?></textarea>
</div>



<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Term & Condition:</div>
<textarea name="terms" rows="20" class="gridfield" id="terms" style="height:220px;"><?php echo stripslashes($resultpage2['terms']); ?></textarea>
</div>
<div style="text-align:right;"><input type="submit" name="Submit" value="    Save    " class="bluembutton" style="margin-top:20px;background-color: #45b558 !important;border: 1px #45b558 solid !important;  margin-top: 0px;">
</div>
<input name="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
<input name="action" type="hidden" value="saveothertab4" />
</form>
<?php } ?>

<?php if($_REQUEST['tab']=='5'){ ?>
<script type="text/javascript"> 

tinymce.init({ selector: "#tipsdetails", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"});

tinymce.init({ selector: "#otherinfo", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"});

</script>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight" target="actoinfrm"  id="addflight">  
<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Tips:</div>
<textarea name="tipsdetails" rows="20" class="gridfield" id="tipsdetails" style="height:220px;"><?php echo stripslashes($resultpage2['tipsdetails']); ?></textarea>
</div>



<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Other Information:</div>
<textarea name="otherinfo" rows="20" class="gridfield" id="otherinfo" style="height:220px;"><?php echo stripslashes($resultpage2['otherinfo']); ?></textarea>
</div>
<div style="text-align:right;"><input type="submit" name="Submit" value="    Save    " class="bluembutton" style="margin-top:20px;background-color: #45b558 !important;border: 1px #45b558 solid !important;  margin-top: 0px;">
</div>
<input name="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
<input name="action" type="hidden" value="saveothertab5" />
</form>
<?php } ?>

<?php if($_REQUEST['tab']=='6'){ ?>
<script src="tinymce/tinymce.min.js"></script>
<script type="text/javascript"> 

tinymce.init({ selector: "#thankNotes", 
themes: "modern", plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen"], toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"}); 

</script>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight" target="actoinfrm"  id="addflight">  
<div style="margin-bottom:20px;">
<div style="margin-bottom:5px; font-size:16px;">Welcome Note:</div>
<select id="emailTemplateId" name="emailTemplateId" class="gridfield"  onchange="emailloadotherItinerary('6')"  autocomplete="off" style="padding:10px; border:1px #CCCCCC solid; margin-bottom:5px; width:100%; box-sizing:border-box;"   >
 <option value="0">Select Template</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0  order by id asc';  
$rs=GetPageRecord($select,_EMAIL_TEMPLATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$emailTemplateId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['subject']); ?></option>
<?php } ?>
</select>

<textarea name="thankNotes" rows="20" class="gridfield" id="thankNotes" style="height:220px;"><?php echo stripslashes($thankNotes); ?></textarea>
</div>
 
 
<div style="text-align:right;"><input type="submit" name="Submit" value="    Save    " class="bluembutton" style="margin-top:20px;background-color: #45b558 !important;border: 1px #45b558 solid !important;  margin-top: 0px;">
</div>
<input name="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
<input name="action" type="hidden" value="saveothertab6" />
</form>
<?php } ?>