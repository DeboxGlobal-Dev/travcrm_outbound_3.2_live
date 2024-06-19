<?php 

if($_REQUEST['showemail']!=''){
$select1='*';  
$where1='id='.($_REQUEST['showemail']).''; 
$rs1=GetPageRecord($select1,_EMAIL_SETTING_MASTER_,$where1); 
$editresult2=mysqli_fetch_array($rs1); 

} else {
$select1='*';  
$where1=' 1 and isDefault=1 '; 
$rs1=GetPageRecord($select1,_EMAIL_SETTING_MASTER_,$where1); 
$editresult2=mysqli_fetch_array($rs1);
}
?>

<style>
.mailsectionheader{ margin-top: 55px;/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e5e5e5+0,d2d2d2+100 */
 background: -moz-linear-gradient(top, #e5e5e5 0%, #d2d2d2 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #e5e5e5 0%,#d2d2d2 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #e5e5e5 0%,#d2d2d2 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e5e5', endColorstr='#d2d2d2',GradientType=0 ); /* IE6-9 */ border-bottom:1px #b2b2b2 solid;}
.mailsectionheader .heading{font-size:16px; font-weight:500; padding:13px 20px; border-right:1px #a7a5a8 solid; position:relative;}
.mailsectionheader .mailarea{width:501px; overflow:hidden;}
.mailsectionheader .mailarearight {
    overflow: hidden;
    border-left: 1px solid #ffffff;
    height: 45px;
}

.writeclass {font-size: 16px;    width: 18px; text-align:center;
    position: absolute;
    right: 10px;
    padding: 10px;
    color: #333333;
    border: 1px solid #9b9b9d;
   /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f2f2f4+0,d6d6d6+100 */
background: #f2f2f4; /* Old browsers */
background: -moz-linear-gradient(top, #f2f2f4 0%, #d6d6d6 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #f2f2f4 0%,#d6d6d6 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #f2f2f4 0%,#d6d6d6 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f2f4', endColorstr='#d6d6d6',GradientType=0 ); /* IE6-9 */
    top: 7px;
    padding: 7px;
    border-radius: 4px;
    cursor: pointer;
}
.mailandinboxbox{width:501px; overflow:auto; height:100%; overflow:hidden;}
.inboxlist{background-color:#eceff4; border-right:#d8d8d8 solid 1px; height:100%; width:200px; float:left;}
.inboxlist .topmailname{padding:15px; color:#63666b;}
.inboxlist .topmailname img{width:40px;}
.inboxlist .topmailname .profileimgbox{overflow:hidden; height:40px; width:40px;    border-radius: 40px;}
.inboxlist .listanch{    margin-top:0px; }
.inboxlist .listanch a {
    color: #3f7baf !important;
    text-decoration: none;
        padding: 15px 0px 15px 17px;
    display: block;
    text-align: left;
    font-weight: 500;
    font-size: 14px; position:relative;
}
.inboxlist .listanch .newmailcome {  position: absolute;
    padding: 4px 8px;
    color: #333333;
    right: 9px;
    top: 11px;}
.inboxlist .listanch .selected .newmailcome {
    position: absolute;
    padding: 4px 8px;
    color: #333333;
    right: 9px;
    top: 11px;
    background-color: #3f7baf;
    color: #fff;
    border-radius: 4px;
    border-bottom: 1px solid #ffffff8c;
}

.inboxlist .listanch a:hover{background-color:#d7e4ef;}
.inboxlist .listanch a:hover{background-color:#d7e4ef;}

.inboxlist .listanch .selected{/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#73b7e6+0,458bd1+100 */
background: #73b7e6; /* Old browsers */
background: -moz-linear-gradient(top, #73b7e6 0%, #458bd1 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #73b7e6 0%,#458bd1 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #73b7e6 0%,#458bd1 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#73b7e6', endColorstr='#458bd1',GradientType=0 ); /* IE6-9 */ color:#fff !important; border-top:1px solid #789fc8; border-bottom:1px solid #4072a5;}

.mailandinboxbox #shortmail{width:300px; float:left; overflow:auto; max-height:650px;}
.mailandinboxbox #shortmail .list{border-bottom: #d8d8d8 solid 1px; padding:15px; overflow:hidden; position:relative; cursor:pointer;}
.mailandinboxbox #shortmail .list:hover{background-color:#E1F9FF;}
.mailandinboxbox #shortmail .active{background-color:#E1F9FF;}

.mailandinboxbox #shortmail .list .dateright {
    color: #478fd7;
    position: absolute;
    right: 9px;
    top: 11px;
    font-size: 11px;
    font-weight: 500;
    background-color: #fff;
    padding: 3px 4px;
}
.mailandinboxbox #shortmail .list .heading{ font-weight:500; color:#444446; font-size:13px; margin-bottom:5px;}
.mailandinboxbox #shortmail .list .shorttext{color:#666666; font-size:13px;}
.mailandinboxbox #shortmail .new{background-color:#f2f2f4;}

.mailandinboxbox #shortmail .new .dateright {
    color: #478fd7;
    position: absolute;
    right: 9px;
    top: 11px;
    font-size: 11px;
    font-weight: 500;
    background-color: #2fc069;
    padding: 3px 4px;
    color: #fff;
    border-radius: 3px;
}

#readmailbox{padding:15px; overflow:hidden;  }
.readmailboxtop{border-bottom: #d8d8d8 solid 1px; padding: 13px; overflow:hidden; position:relative;}
.maileruser {
    color: #6666668f;
    background-color: #cccccc61;
    padding: 10px;
    font-size: 22px;
    width: 20px;
    border-radius: 60px;
    height: 20px; margin-right:10px;
}

.mailusername{font-size:13px; font-weight:500; margin-bottom:4px;color:#444446; margin-top:4px; }
.mailuseremail{color:#666666; font-size:12px;}
.readmailboxtop .rightdate {
    position: absolute;
    right: 15px;
    top: 27px;
    color: #999999;
    font-size: 11px;
    font-weight: 500;
}
#readmailbox .subjectdiv{margin-bottom:20px; font-size:24px; color:#444446;}
#readmailbox .bodydiv {
    font-family: 13px;
    color: #2c2c2c;
    font-size: 13px;
    line-height: 20px;
}


.mailarearight .heading {
    font-size: 16px;
    font-weight: 500;
    padding: 13px 20px;
    border-right: 1px #a7a5a8 solid;
    position: relative;
}

</style>
<body style="height:90% !important;">
<div class="mailsectionheader">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top"><div class="mailarea">
<div class="heading"><i class="fa fa-envelope"></i> Email Marketing   <i class="fa fa-edit writeclass" id="newmailcreate" onClick="funreadmailsection('newmail');"  ></i>
  <div style="position: absolute; right: 56px; top: 7px;"><input name="searchkeyword" id="searchkeyword" type="text" style="padding: 7px; border: 1px solid #ababab;  width: 160px;  border-radius: 4px; outline:0px;" placeholder="Search Mail" onKeyUp="loadmails('1');"></div>
	</div>
	</div></td>
    <td width="75%" align="left" valign="top"><div class="mailarearight" style="position:relative;">
	<i class="fa fa-trash writeclass" onClick="gototrash();" ></i>
	<i class="fa fa-share writeclass" onClick="converttoqueryfunction();"  style=" right: 55px;
    width: 128px;
    display: block;
    padding: 0px;"><span style="
    display: block;
    width: 113px;
    font-family: arial;
    font-size: 13px;
    padding: 8px;">Convert to Query</span></i>
<!--	<i class="fa fa-share writeclass"  style="right:55px; display:none !important;"  onClick="forwordmail();"></i>
	<i class="fa fa-reply writeclass"  style="right:100px; display:none !important;" onClick="replymail();" ></i>-->
	<div class="heading" style="display:none;">New Mail</div>
	</div></td>
  </tr>
</table>

</div>
<table width="100%" height="85%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" style="border-right:#d8d8d8 solid 1px;">
	<div class="mailandinboxbox">
	<div class="inboxlist">
	<div class="topmailname">
	<div style="margin-bottom:5px; font-size:12px;"><?php echo $editresult2['from_name']; ?></div>
	<form method="get" id="showmailform">
	<select id="showemail" name="showemail" autocomplete="off"   style="padding:10px; font-size:14px; width:100%; box-sizing:border-box;  border: 1px #ccc solid;" onChange="$('#showmailform').submit();"   > 
<?php
$select='';
$where='';
$rs=''; 
$select='*';  
if($_SESSION['userid']==37){
$where=' status=1 order by id asc';
} else { 
$where=' status=1 and email="'.$LoginUserDetails['email'].'" order by id asc';
}
$rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where);
while($rest=mysqli_fetch_array($rs)){ 
?>
<option value="<?php echo $rest['id']; ?>" <?php if($rest['id']==$_REQUEST['showemail']){ ?>selected="selected"<?php } ?>><?php echo $rest['email']; ?></option> 
<?php } ?>
</select><input name="module" id="module" type="hidden" value="incomingquery">
</form>
	</div>
	
	<div class="listanch">
	<a href="#" class="selected" id="t1" onClick="changetb('1');loadmails('1');"><i class="fa fa-inbox"></i>&nbsp;&nbsp;Inbox <div class="newmailcome">0</div>
	</a>
	<a href="#" id="t2" onClick="changetb('2');loadmails('3');"><i class="fa fa-share-square"></i>&nbsp;&nbsp;Sent</a><!--
	<a href="#" id="t3" onClick="changetb('3');loadmails('4');"><i class="fa fa-file"></i>&nbsp;&nbsp;Drafts</a>-->
	<a href="#" id="t4" onClick="changetb('4');loadmails('5');"><i class="fa fa-trash"></i>&nbsp;&nbsp;Trash</a>
	
	<script>
	function changetb(id){
	$('.listanch a').removeClass('selected');
	
	$('#t'+id).addClass('selected');
	}
	</script>
	</div>
	</div>
	 
	<div id="shortmail"></div>
	</div>
	</td>
    <td width="73%" align="left" valign="top" id="readmailsection"></td>
  </tr>
</table>

</body>
<script>
function loadmails(id){
var searchkeyword = encodeURIComponent($('#searchkeyword').val());

if(searchkeyword!=''){
searchkeyword=searchkeyword;
} else { 
searchkeyword='';
} 

$('#shortmail').load('load_short_mail.php?mailid=<?php echo $editresult2['id']; ?>&mailtype='+id+'&searchkeyword='+searchkeyword);
$('#readmailsection').load('load_read_mail.php?mailid=<?php echo $editresult2['id']; ?>&id=na&mailid=<?php echo $editresult2['id']; ?>');
}

function funreadmailsection(id){
$('#readmailsection').load('load_read_mail.php?mailid=<?php echo $editresult2['id']; ?>&id='+id);
$('.list').removeClass('active');
$('#mailiddiv'+id).addClass('active');
}


function funreadmailsectionsent2(id){
$('#readmailsection').load('load_read_mail.php?mailid=<?php echo $editresult2['id']; ?>&id='+id+'&sent=1');
$('.list').removeClass('active');
$('#mailiddiv'+id).addClass('active');
}
loadmails('1');
</script>

<style>
body{height:80% !Important; }
.fa-mail-forward:before, .fa-share:before { display:none;
    content: "\f064";
}
</style>