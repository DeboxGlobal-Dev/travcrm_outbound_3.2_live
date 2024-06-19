<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<!--<link rel="manifest" href="/manifest.json">11-->

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<style>
#headerstrip {
background-color: #fff !important;
}
#headerstrip #navigationleft .active {
background-color: #fff !important;
}
#navigationright a {
border-left: 1px #404346 solid;
border-right: 1px #404346 solid;
}
a{text-decoration:none !important;outline:none !important;}
</style>
<div id="headerstrip">
<div id="navigationleft">
    <div id="navigationleftin">
        <a href="<?php echo $fullurl; ?>" <?php if($selectedPage==0){ ?>class="active"<?php } ?> style="width:82px;">
            <img src="images/WhatsApp Image 2024-02-27 at 12.47.58 PM.jpeg" he style="position:absolute; top:0px; left:10px; width:80px;" />&nbsp;
        </a>
        <?php
        $select='';
        $where='';
        $rs='';
        $select='*';
        $where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1  ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.')  and mainmenu=1 order by sr';
        $rs=GetPageRecord($select,_MODULE_MASTER_,$where);
        while($menulist=mysqli_fetch_array($rs)){

            $select2='moduleName,url,id,parentId';
            $where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
            $rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
            $modName=mysqli_fetch_array($rs2);
            if($loginuserprofileId=='48'){
            
                if($modName['id']=='116' || $menulist['id']=='36' || $menulist['id']=='38'){ ?>
                    <a href="showpage.crm?module=<?php echo $modName['url']; ?>" <?php if($selectedPage==$modName['parentId']){ ?>class="active"<?php } ?>><?php echo $modName['moduleName'].$modName['moduleName']; ?></a>
                    <?php 
                }  
            } else { 
                if($menulist['id']!=68){ 
                    ?>
                    <a href="showpage.crm?module=<?php echo $modName['url'];if($modName['url']=='query'){ echo '&daterange='.date('01-m-Y').'+-+'.date('d-m-Y').''; } ?>" <?php if($selectedPage==$modName['parentId']){ ?>class="active"<?php } if($menulist['id']=='1'){ ?> style="position:relative;" <?php } ?> >
                        <?php 
                        echo $modName['moduleName']; 
                        if($menulist['id']=='1'){ 
                            $selectcs='*';
                            $wherecs='1 and tatDate>="'.date("Y-m-d h:i:s").'"';
                            $rscs=GetPageRecord($selectcs,'timelineMaster',$wherecs);
                            $countrowss=mysqli_num_rows($rscs);
                            if($countrowss>0){ ?>
                            <!--<div class="nbox" style="background-color: #ff0000; color: #fff;width: 14px; height: 14px; padding: 3px; position: absolute; right: 0; top: 3px; text-align: center; border-radius: 50%; font-size: 12px; vertical-align: top; line-height: 17px;">
                                <?php //echo $countrowss; ?>
                            </div>-->
                            <?php } ?>
                            <?php 
                        } ?>
                    </a>
                    <?php 
                } else {  ?>
                    <a href="#" class="salesmenu <?php if('69'==$selectedPage || '70'==$selectedPage || '71'==$selectedPage || '72'==$selectedPage || '73'==$selectedPage){ ?>active2<?php } ?>" ><?php echo $modName['moduleName']; ?></a>
                    <div class="dropmenu" id="salesmenumenudropdown" style="display:none;">
                        <?php
                        $select='';
                        $where='';
                        $rs='';
                        $select='*';
                        $where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and mainmenu=4 order by sr';
                        $rs=GetPageRecord($select,_MODULE_MASTER_,$where);
                        while($menulist=mysqli_fetch_array($rs)){
                            $select2='moduleName,url';
                            $where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
                            $rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
                            $modName=mysqli_fetch_array($rs2);
                            ?>
                            <a href="showpage.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
                            <?php 
                        } ?>
                    </div>
                    <?php 
                } 
            }
        } ?>
    </div>
    <?php if($loginuserprofileId!='48'){ ?>
    <a href="#" class="downarrow">&nbsp;&nbsp;</a>
    <?php } ?>
    <div class="dropmenu" id="menudropdown" style="display:none;">
        <?php
        $select='';
        $where='';
        $rs='';
        $select='*';
        $where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and mainmenu=2 and disableStatus=0 order by sr';
        $rs=GetPageRecord($select,_MODULE_MASTER_,$where);
        while($menulist=mysqli_fetch_array($rs)){
        $select2='moduleName,url';
        $where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
        $rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
        $modName=mysqli_fetch_array($rs2);
        if ($modName['moduleName']!='Series List' && $modName['moduleName']!='Series Builder') {
        ?>
        <a href="showpage.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
        <?php 
        }
    } ?>
    </div>
</div>
    <div id="navigationright">
        <div class="dropmenu" id="menudropdownadd" style="display:none;right:58px; max-height:510px !important;">
            <?php
            $select='';
            $where='';
            $rs='';
            $select='*';
            $where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$loginusersuperParentId.' and status=1 ) and id in (select moduleId from '._PERMISSION_MASTER_.' where view=1 and profileId='.$loginuserprofileId.') and mainmenu=3 and id!=51 order by sr';
            $rs=GetPageRecord($select,_MODULE_MASTER_,$where);
            while($menulist=mysqli_fetch_array($rs)){
                $select2='moduleName,url';
                $where2='userId='.$loginusersuperParentId.' and parentId='.$menulist['id'].'';
                $rs2=GetPageRecord($select2,_USER_MODULE_MASTER_,$where2);
                $modName=mysqli_fetch_array($rs2);
                ?>
                <a href="showpage.crm?module=<?php echo $modName['url']; ?>"><?php echo $modName['moduleName']; ?></a>
                <?php 
            } ?>
        </div>
        <style>
            .micbox {
            padding: 0px 0px;
            overflow: auto;
            max-height: 410px;
            box-shadow: 0px 6px 15px #ccc;
            width: 500px;
            background-color: #ffffff;
            position: absolute;
            border: 1p #CCCCCC solid;
            z-index: 9999;
            right: 0px;
            top: 51px;
            border: 0px;
            color: #676767; overflow:hidden;
            }
            .micbox .micstartrec {
            padding: 20px 25px;
            font-size: 24px;
            background-color: #03C255;
            color: #fff;
            float: left;
            cursor: pointer;
            }
            .micbox .micstartrecstart{
            padding: 20px 25px;
            font-size: 24px;
            color: #fff;
            float: left;
            cursor: pointer;
            -webkit-animation: bgcolorchange 4s infinite; /* Chrome, Safari, Opera */
            animation: 4s infinite bgcolorchange;
            }
            @keyframes bgcolorchange {
            0% {
            background-color: red;
            }
            25% {
            background-color: #ff8d00;
            }
            50% {
            background-color: red;
            }
            75% {
            background-color: #ff8d00;
            }
            100% {
            background-color: red;
            }
            }
            /* Chrome, Safari, Opera */
            @-webkit-keyframes bgcolorchange {
            0%   {background: red;}
            25%  {background: #ff8d00;}
            75%  {background: red;}
            100% {background: #ff8d00;}
            }
            
            .micrightbox{float: right;
            padding: 10px;
            width: 410px;
            font-weight: 400;
            font-size: 12px;}
            .micrightbox #note-textarea{border:0px; width:100%; box-sizing:border-box; outline:0px; margin-top: 12px;}
            .micrightbox #note-textarea::placeholder{color:#999999;}
        </style>
        <div style="padding: 13px 7px 15px 13px; float: left; height: 20px; position: relative;">
            <?php
            $profileeeDataq=GetPageRecord('profileId','userMaster'," 1 and id='".$_SESSION['userid']."'");
            $userinfoselectbox=mysqli_fetch_array($profileeeDataq);
            $profileeeDataaaaaq=GetPageRecord('adminDashboard,salesDashboard,operationsDashboard,agentOption,accountDashboard','profileMaster',"1 and id='".$userinfoselectbox['profileId']."' and ( adminDashboard=1 or salesDashboard=1 or operationsDashboard=1)");
            $profileeeDataaaaa=mysqli_fetch_array($profileeeDataaaaaq);
            ?>
                <select name="switchDashboard" id="switchDashboard" style="padding: 5px 10px; background-color: transparent; border: 0; outline: none !important; color: #4285f4; font-size: 15px; font-weight: 600; width:170px;" onchange="changedashboard(this.value);">
                    <option value="0">Switch Dashboard</option>
                    <?php if($profileeeDataaaaa['adminDashboard']==1){ ?>
                    <option value="1" <?php if($_SESSION['dashboardid']==1){ ?> selected="selected" <?php } ?>>Admin Dashboard</option>
                    <?php } if($profileeeDataaaaa['salesDashboard']==1){ ?>
                    <option value="2" <?php if($_SESSION['dashboardid']==2){ ?> selected="selected" <?php } ?>>Sales Dashboard</option>
                    <?php } if($profileeeDataaaaa['operationsDashboard']==1){ ?>
                    <option value="3" <?php if($_SESSION['dashboardid']==3){ ?> selected="selected" <?php } ?>>Operations Dashboard</option>
                    <?php } if($profileeeDataaaaa['accountDashboard']==1){ ?>
                    <option value="4" <?php if($_SESSION['dashboardid']==4){ ?> selected="selected" <?php } ?>>Finance Dashboard</option>
                    <?php } ?>
                </select>
        </div>
        <div id="changedashboard" style="display:none;"></div>
        <script>
        function changedashboard(id){
        $('#changedashboard').load('<?php echo $fullurl; ?>changedashboard.php?id='+id);
        }
        </script>
        <?php
        $select2='errorStatus';
        $where2='id=1';
        $rs2=GetPageRecord($select2,'mailConnectionMaster',$where2);
        $modName=mysqli_fetch_array($rs2);
        if($modName['errorStatus']==1){
        ?>
        <a style="position:relative;" class=""><img src="images/emailerror.png" width="15" />&nbsp;Mail Error&nbsp; </a>
        <?php  }else{ ?>
        <a style="position:relative;" class=""><img src="images/connected.png" width="15" />&nbsp;Mail Connected&nbsp; </a>
        <?php } ?>
        <?php if($loginuserprofileId!='48'){ ?>
        <!-- <a href="showpage.crm?module=calendar"  style="position:relative;" class="mic" ><i class="fa fa-calendar" style="padding: 3px 9px 9px 4px; font-size: 20px;"></i></a> -->
        <a  style="position:relative;" class="mic" onclick="showrecordingpanel();"><i class="fa fa-microphone" style="padding: 4px 9px 9px 4px; font-size: 20px;"></i></a>
        <a class="bellicon" onclick="loadFollowUp();"><div class="nbox" style="background-color:#ff0000;color:#fff;">
            <?php
            $selectc='*';
            $countfollow=0;
            /*$wherec='status!="2" and DATE(reminderDate)>= "'.date("Y-m-d").'" order by reminderDate desc';
            $rsc=GetPageRecord($selectc,'queryNotesMaster',$wherec);
            while($countrows=mysqli_fetch_array($rsc)){
            $dbdatetime=strtotime($countrows['reminderDate'].' '.$countrows['reminderTime']);
            $currentdatetime=strtotime(date("Y-m-d h:i A"));
            if($dbdatetime>=$currentdatetime) {
            ++$countfollow;
            }
            }*/
            echo $countfollow;
            ?>
        </div>&nbsp;</a>
        
        
        <div id="followupclass" style="display:none;"></div>
        
        
        <style>
        #followupclass {
        width: 450px;
        background-color: #f8f8f8;
        position: absolute;
        right: 190px;
        top: 55px;
        border: 1px #cccccc solid;
        box-shadow: 0px 3px 8px #e0e0e0;
        border-radius: 2px;
        max-height: 400px;
        overflow: auto;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
        }
        .follow-up{
        width:100%;
        position: relative;
        display: block;
        }
        .follow-up .first-class {
        padding: 6px 10px;
        display: block;
        margin-bottom: 5px;
        color: #fff;
        font-size: 14px;
        border: 1px #2ca1cc9e solid;
        background-color: #2ca1cc9e;
        }
        </style>
        <script>
        function loadFollowUp(){
        $('#followupclass').show();
        $('#followupclass').load('loadfollowup.php?t=<?php echo time(); ?>');
        }
        </script>
        
        
        <!-- <a id="headercal"><img src="images/calicontop.png" width="17" style="margin-top:3px;"/>&nbsp;</a>-->
        <?php } ?>
        
        <a href="#" style="padding-left:44px; padding-right:5px;" class="settingmod">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="position:relative;"><div id="topuserbox"><img src="<?php if($loginuserprofilePhoto!=''){ ?>profilepic/<?php echo $loginuserprofilePhoto; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
                    <td style="padding-left:2px; font-size:12px; line-height:22px;"><span><?php echo $fullloginusername; ?></span> &nbsp;&nbsp;<img src="images/downarrow2.png" width="10" />&nbsp;</td>
                </tr>
            </table></a>
            <div class="settingmenu" id="menudropdownsetting" style="display:none;">
                <div class="inner">
                    <?php if($loginuserprofileId!='48'){ ?> <a href="setup.crm">Setup</a>
                    <?php if($userRemainingDays<30){ ?><a href="#">Subscription <span><?php echo $userRemainingDays; ?> Days Left</span></a><?php } ?>
                    <a href="http://www.deboxglobal.com/" target="_blank">Help/Contact Support</a>
                    
                    <div class="lable" style="margin-bottom:0px;">General</div>
                    <a onclick="setupbox('setupsetting.crm?module=personalsettings');" style="padding:0px !important;"> <div style="margin-bottom:5px; border-bottom:1px #e2e2e2 solid; padding-bottom:5px; padding-top:5px;"><table border="0" cellpadding="2" cellspacing="0">
                        <tr>
                            <td align="left"><div class="profileimgbox"><img src="<?php if($loginuserprofilePhoto!=''){ ?>profilepic/<?php echo $loginuserprofilePhoto; ?><?php } else { ?>images/user.png<?php } ?>" /></div></td>
                            <td align="left" style="padding-left:10px;"><strong><?php echo $fullloginusername; ?></strong><br />
                            ID: <?php echo $loginuseraccountId; ?></td>
                        </tr>
                        
                    </table>
                </div></a>
                <a href="setupsetting.crm?module=personalsettings">Personal Settings</a>
                <?php } ?>
                <a href="logout.crm" >Logout</a>
                <a style="width:100%" href="#" style="
                    border-top: 1px solid #dfdede8c !important;
                    font-size: 11px !important;
                    color: #000000b5 !important;
                    text-align: right;font-style:italic;
                    <?php
                    $select='';
                    $where='';
                    $rs='';
                    $select='*';
                    $where='id="1" order by versionNo';
                    $rs=GetPageRecord($select,'companyVersionInfoSetting',$where);
                    $companyVersion=mysqli_fetch_array($rs);
                    ?>
                ">Version: <?= $companyVersion['versionNo'];?>, <?= $companyVersion['dateAdded'];?>,<br>DB :<?= $companyVersion['databaseName'];?>,</a>
            </div>
        </div>
    </div>
    
    
    
    <!--<div id="searchbox">
        <div id="searchinner"><input name="" type="text"  placeholder="Search"/><span>x</span></div>
        
    </div>-->
    
    <div id="notificationbox" style="display:none;">
        
    </div>
</div>

<div class="micbox" style="display:none; position:fixed;">
    <i class="fa fa-refresh fa-spin" style="font-size:20px; position:absolute; right:20px; top:22px; color:#999999; display:none;" id="recogiconmic"></i>
    <div class="micstartrec" onclick="startrec();statvoicing();" id="start-record-btn"><i class="fa fa-microphone"></i></div>
    <div class="micstartrecstart" style="display:none;" onclick="stoprec();" id="pause-record-btn"><i class="fa fa-microphone"></i></div>
    <div class="micrightbox">
        <div id="recording-instructions" style="margin-top: 6px; display:none;">Press the Start Recognition</strong> button and allow access.</div>
        <input  type="text" id="note-textarea" placeholder="Press the Start Recognition button and allow access." readonly="readonly"/>
        <div>
            
            
        </div>
        <style>
        .submenuvoice {
        padding: 10px;
        float: left;
        width: 100%;
        box-sizing: border-box;
        border-top: 1px #ebebeb solid;
        }
        .submenuvoice a {
        padding: 8px 10px;
        display: block;
        margin-bottom: 5px;
        color: #0066CC;
        border: 1px #b7e0f1 solid;
        background-color: #EAFCFF;
        }
        .submenuvoice a .fa{margin-right:5px;}
        .submenuvoice a:hover{background-color:#f9f9f9;}
        </style>
    </div>
    <div class="submenuvoice">
        <a onclick="calldefinedtext('query report');"><i class="fa fa-volume-up" aria-hidden="true"></i> Query Report</a>
        <a onclick="calldefinedtext('sales report');"><i class="fa fa-volume-up" aria-hidden="true"></i> Monthly Sales Report</a>
        <a onclick="calldefinedtext('monthly collection and expenses');" style="margin-bottom:0px;"><i class="fa fa-volume-up" aria-hidden="true"></i> Monthly Collection and Expenses</a>
    </div>
    <input type="range" id="pitch" min="0" max="2" value="12" style="display:none;" />
    <input type="range" id="rate" min="1" max="100" value="10" style="display:none;" />
    <!-- <select id="voices" style="display:none;"></select> -->
    
    <div id="loadspeech"></div>
</div>
<script src="speech/script.js"></script> 
<script>
var corporatevoice=0;
function startrec(){
    $('.micstartrec').hide();
    $('.micstartrecstart').show();
    $('#note-textarea').attr('placeholder','Hearing...');
    $('#recogiconmic').show();
}
function stoprec(){
    $('.micstartrec').show();
    $('.micstartrecstart').hide();
    $('#note-textarea').attr('placeholder','Press mic button and ask me.');
    $('#recogiconmic').hide();
}

function showrecordingpanel(){
    stoprec();
    $('.micbox').toggle();
}
 
function loadnotificationboxed(){
    $('#notificationbox').show();
    $('#notificationbox').load('crm_notification_inner.php');
}

function calldefinedtext(text){
    $('#note-textarea').val(text);
    callvoicegotopage();
}

</script>

<script type="text/javascript">

    // speechSynthesis.onvoiceschanged = function() {

    //   var $voicelist = 9;

    //   if($voicelist.find('option').length == 0) {

    //     speechSynthesis.getVoices().forEach(function(voice, index) {

    //       var $option = $('<option>')

    //       .val(index)

    //       .html(voice.name + (voice.default ? ' (default)' :''));

    //       $voicelist.append($option);

    //     });

    //     $voicelist.material_select();

    //   }

    // }



function speektotalk(){
    var text = $('#note-textarea').val();
    var msg = new SpeechSynthesisUtterance();
    var voices = window.speechSynthesis.getVoices();
    msg.voice = voices[$('#voices').val()];
    msg.rate = $('#rate').val() / 10;
    msg.pitch = $('#pitch').val();
    msg.text = text;
    msg.onend = function(e) {
      console.log('Finished in ' + event.elapsedTime + ' seconds.');        
    };
    speechSynthesis.speak(msg);
} 
  

function statvoicing(){
  setTimeout(function(){ 
  var recordingtest = $('#recording-instructions').text(); 
  if(recordingtest!=''){ 
  $('#recording-instructions').text('Press mic button and speek');

  stopwriting(); 
  stoprec();
  savevoicetottext(); 
  callvoicegotopage();
  } 
  }, 6000);
}


function hasNumbers(t)
{
var regex = /\d/g;
return regex.test(t);
}

function wordInString(s, word){
  return new RegExp( '\\b' + word + '\\b', 'i').test(s);
}

function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}

function openInNewTab(id, type){
    $.ajax({
            type: "GET",
            data: "key="+id,
            async: false,
            url: id,
            success: function (msg) {
                window.open(id, "autologin", "toolbar=no,width=500");
            }
        });
    }


function callvoicegotopage(){ 
    var voicetext = $('#note-textarea').val(); 

    if(voicetext!=''){

        var allreadywhatis=0;
        allreadyquery=0;
        var getsearch=0;

        //------------------Open Websites------------------
        var voicetextfilter = wordInString(voicetext, 'query'); 
        if(voicetextfilter && hasNumbers(voicetext)){ 
            $('#note-textarea').val('Opening Query'); 

            var sd = voicetext.replace(/[^0-9]/gi, ''); // Replace everything that is not a number with nothing
            var number = parseInt(sd, 10); 

            $('#loadspeech').load('voiceaction.php?action=query&id='+number);

            getsearch=1;
            allreadyquery=1;
        }
        var voicetextfilter = wordInString(voicetext, 'who is'); 
        if(voicetextfilter){
            $('#note-textarea').val('Opening Google Search'); 
            speektotalk(); 
            var voicetext = voicetext.replace("who is", "");
            voicetext = voicetext.replace(" ", ""); 
            voicetext = voicetext.replace("http://", "");  
            window.open('https://www.google.com/search?q='+voicetext+'', '_blank');
            getsearch=1;
        }
        var voicetextfilter = wordInString(voicetext, 'What is your');
        if(voicetextfilter){ 
            $('#note-textarea').val('I dont really like talking about myself.'); 
            speektotalk(); 
            allreadywhatis=1;
            getsearch=1;
        }
        var voicetextfilter = wordInString(voicetext, 'what is');
        if(allreadywhatis!=1){
            if(voicetextfilter){
                $('#note-textarea').val('Opening Google Search'); 
                speektotalk(); 
                var voicetext = voicetext.replace("what is", "");
                voicetext = voicetext.replace(" ", ""); 
                voicetext = voicetext.replace("http://", "");  
                window.open('https://www.google.com/search?q='+voicetext+'', '_blank');
                getsearch=1;
            }
        }
        var voicetextfilter = wordInString(voicetext, 'who are you');
        if(voicetextfilter){ 
            $('#note-textarea').val('I am Trav CRM voice assistant.'); 
            speektotalk(); 
            getsearch=1;
        }
        //------------------CRM Pages Search------------------

        if(corporatevoice==1){
            var voicetextfilter = wordInString(voicetext, 'search');
            if(voicetextfilter){ 
                voicetext = voicetext.replace("search", "");
                $('#note-textarea').val('Searching '+voicetext+''); 
                speektotalk(); 
                $('#searchField').val(voicetext);
                $('#innersearchfrm').submit();
                getsearch=1;

            }

        }

        var voicetextfilter = wordInString(voicetext, 'open'); 
        if(voicetextfilter && allreadyquery!=1){
            $('#note-textarea').val('Opening'); 
            speektotalk(); 
            var voicetext = voicetext.replace("open", "");
            voicetext = voicetext.replace(" ", ""); 
            voicetext = voicetext.replace("http://", "");  
            window.open('https://www.google.com/search?q='+voicetext+'', '_blank');
            getsearch=1;
        }

        //--------------------------CRM Query Report---------------------------
        var voicetextfilter = wordInString(voicetext, 'query report'); 
        if(voicetextfilter){  
            $('#loadspeech').load('voiceaction.php?action=queryreport'); 
            getsearch=1;
            allreadyquery=1;
        }
        var voicetextfilter = wordInString(voicetext, 'sales report'); 
        if(voicetextfilter){  
            $('#loadspeech').load('voiceaction.php?action=salesreport'); 
            getsearch=1;
            allreadyquery=1;
        }
        var voicetextfilter = wordInString(voicetext, 'monthly collection and expenses'); 
        if(voicetextfilter){  
            $('#loadspeech').load('voiceaction.php?action=monthlycollection'); 
            getsearch=1;
            allreadyquery=1;
        }
        //------------------CRM Pages Search------------------
        var voicetextfilter = wordInString(voicetext, 'Hi how can i assist you'); 
        if(voicetextfilter){ 
            getsearch=1;
        }
        if(getsearch==0){
            $('#note-textarea').val('I really dont understand what you are trying to say'); 
            speektotalk(); 
        }
    }
    setTimeout(function(){ 
        $('#note-textarea').val(''); 
    }, 4000);
    
}



// recognition.start();
// var d=0;
// setInterval(function(){ 
//     var notetextarea = $('#note-textarea').val();  
//     if(notetextarea=='hi David'){
//         $('.micstartrecstart').show();  
//         savevoicetottext(); 
//         startrec();
//         $('#note-textarea').val('Hi how can i assist you'); 
//         speektotalk();   
//         $('.micbox').show();
//         d++;
//     } 
//     if(d>0 && notetextarea!=''){
//         callvoicegotopage(); 
//         startrec();
//     }

//     savevoicetottext(); 
//     recognition.start(); 

// }, 5000);

// $('#voices').val('9');





</script>
