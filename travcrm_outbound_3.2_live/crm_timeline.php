<?php
$where='userId="'.$loginusersuperParentId.'" and replyPostowner='.$loginuserID.'';  
deleteRecord(_NOTIFICATION_MASTER_,$where);

$where='userId="'.$loginusersuperParentId.'" and parentId='.$loginuserID.'';  
deleteRecord(_NOTIFICATION_MASTER_,$where);  
$selectedPage=1;
?>
<link href="css/main.css" rel="stylesheet" type="text/css">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9%" align="left" valign="top" class="leftsettingmenutd"><div class="leftsettingmenu">
	<h2><?php echo $pageName; ?></h2>
	<div id="outerscroll">
	<div class="mainbox">
	 
	<div class="linkbox" id="op1">  
 
  
 <a href="showpage.crm?module=timeline" <?php if($_GET['my']!=1){ ?>class="active"<?php } ?>>All Posts</a>
 <a href="showpage.crm?module=timeline&my=1" <?php if($_GET['my']==1){ ?>class="active"<?php } ?>>My Posts</a>
  </div>
	
	</div>
	
	 
	
	 
	
	 
	</div>
	</div></td>
    <td width="91%" align="left" valign="top">
	 <div id="pagelisterouter" style="padding-top: 50px;">
 <div class="addeditpagebox vieweditpagebox"  id="loadtimeline">
 Loading...
 </div></div><input name="mypost" type="hidden"  value="<?php echo clean($_GET['my']); ?>">
	</td>
  </tr>
</table>

<script>
function showsubmitfrombtn(){
var attachpostsubmit = $('#attachpostsubmit').val();
var postsubmitfield = $('#postsubmitfield').val();

if(attachpostsubmit!='' || postsubmitfield!=''){
$('#submitpostbtndiv').show();
} else {
$('#submitpostbtndiv').hide();
}

}


function attachsubmitpostfile(){
var attachpostsubmit = $('#attachpostsubmit').val();
attachpostsubmit = attachpostsubmit.substring(attachpostsubmit.lastIndexOf("\\") + 1, attachpostsubmit.length);
$('#submitattach span').text(attachpostsubmit);
sfd();
}

 

function loadtimelinefunc(){ 
$('#loadtimeline').load('loadtimeline.php?my=<?php echo $_REQUEST['my']; ?>&page=<?php echo $_GET['page']; ?>'); 
}


function loadpostreply(id,addby){
$('#replydiv'+id).load('post_reply.php?id='+id+'&addby='+addby); 
}


loadtimelinefunc(); 




function sfd() {
    var input, file;

    // (Can't use `typeof FileReader === "function"` because apparently
    // it comes back as "object" on some browsers. So just see if it's there
    // at all.)
    if (!window.FileReader) {
        bodyAppend("p", "The file API isn't supported on this browser yet.");
        return;
    }

    input = document.getElementById('attachpostsubmit');
    if (!input) {
        
    }
    else if (!input.files) {
         
    }
    else if (!input.files[0]) {
         
    }
    else {
        file = input.files[0];
		
		var totalfilesize = file.size;
		totalfilesize = totalfilesize/1024/1024;
        
		if(totalfilesize>20){
		alertspopupopen('action=filemorethen20&ac=timelinepost','600px','auto');
		}
		var ext = file.name.split('.').pop();
		if(ext=='jpg' || ext=='jpeg' || ext=='JPG' || ext=='JPEG' || ext=='png' || ext=='PNG' || ext=='GIF' || ext=='gif' || ext=='txt' || ext=='psd' || ext=='docx' || ext=='doc' || ext=='xlsx' || ext=='xlsm' || ext=='xls' || ext=='pptx' || ext=='pdf' || ext=='PDF' || ext=='ppt' || ext=='zip'){
		
		} else {
		alertspopupopen('action=filetypenot&ac=timelinepost','600px','auto');
		}
		 
    }
}

function sfd2(id,addby) {
    var input, file;

    // (Can't use `typeof FileReader === "function"` because apparently
    // it comes back as "object" on some browsers. So just see if it's there
    // at all.)
    if (!window.FileReader) {
        bodyAppend("p", "The file API isn't supported on this browser yet.");
        return;
    }

    input = document.getElementById('attachpostsubmit'+id);
    if (!input) {
        
    }
    else if (!input.files) {
         
    }
    else if (!input.files[0]) {
         
    }
    else {
        file = input.files[0];
		
		var totalfilesize = file.size;
		totalfilesize = totalfilesize/1024/1024;
        
		if(totalfilesize>20){
		alertspopupopen('action=filemorethen20&ac=timelinereply&id='+id+'&addedBy='+addby+'','600px','auto');
		}
		var ext = file.name.split('.').pop();
		if(ext=='jpg' || ext=='jpeg' || ext=='JPG' || ext=='JPEG' || ext=='png' || ext=='PNG' || ext=='GIF' || ext=='gif' || ext=='txt' || ext=='psd' || ext=='docx' || ext=='doc' || ext=='xlsx' || ext=='xlsm' || ext=='xls' || ext=='pptx' || ext=='pdf' || ext=='PDF' || ext=='ppt' || ext=='zip'){
		
		} else {
		alertspopupopen('action=filetypenot&ac=timelinereply&id='+id+'&addedBy='+addby+'','600px','auto');
		}
		 
    }
}


 function selectreplyuploadfile(id,addby){ 
 sfd2(id,addby);
 var fval = $('#attachpostsubmit'+id).val();
 fval = fval.substring(fval.lastIndexOf("\\") + 1, fval.length);
 $('#spanattach'+id).text(fval);
 }


function replaceuploadreply(id){
var upreplyhtml = $('#attre'+id).html();
$('#attre'+id).html(upreplyhtml);
$('#spanattach'+id).text('Attach File');
}


function dltposts(id){
startloading();
$('#actiondiv').load('frmaction.php?action=deletetimelinepost&id='+id);
}
</script>
 