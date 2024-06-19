<?php
error_reporting(0);
include "inc.php";
include "config/logincheck.php";

$type ='';
$supplierRate = '';
$supplierConfirmation = '';
$n=1;
$select='';
$where='';
$rs='';
 
$rs=GetPageRecord('*',_SUPPLIER_COMMUNICATION_,'queryid='.$_REQUEST['id'].' group by supplierId order by id desc');
while($querylisting=mysqli_fetch_array($rs)){
    
     
    $rs2a=GetPageRecord('*',_SUPPLIERS_MASTER_,'id='.$querylisting['supplierId'].'');
    $resultpage=mysqli_fetch_array($rs2a);
     
    $rs2x=GetPageRecord('*',_SUPPLIERS_TYPE_MASTER_,'id='.$querylisting['supplierType'].'');
    $resultpage2=mysqli_fetch_array($rs2x);
    $supplierRate = $querylisting['supplierRate'];
    $supplierConfirmation = $querylisting['confirmation'];
    
    $result = mysqli_query(db(),'select id FROM '._SUPPLIER_COMMUNICATION_MAIL_.'  where queryId='.$_REQUEST['id'].' and supplierId='.$resultpage['id'].' and replyStatus=1');
    $rows = mysqli_num_rows($result);
    $total = $rows;
    ?>
  
<script src="tinymce/tinymce.min.js"></script> 
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="querymaillisting boxlistingw" style="position:relative;height:35px;padding: 8px 10px;"  id="maintab<?php echo $querylisting['id']; ?>">
  <ul class="head_ulbox">
    <li>
      <img src="images/suppliericon.png" width="20"  />
    </li>
    <li>
      <div class="block">&nbsp;&nbsp;&nbsp;</div>
      <div class="maintitle" id="titleid<?php echo $querylisting['id']; ?>" style="padding-left: 5px;display: none;position: absolute;top: 0; "> 
    
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%" colspan="2" align="left" valign="top"><div style="font-size:14px; color:#000000; position:relative;"><?php echo $resultpage['name'] ?></div> </td>
            <td width="24%" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </div>    
    </li>
    <li>&nbsp;</li> 
    <li>
      <div class="datetimequ"><?php $originalDate = $querylisting['dateAdded']; echo date("d-m-Y h:i a", $originalDate); ?></div>
    </li>
  </ul>
  <style type="text/css">
    ul.head_ulbox{
      list-style: none;
      display: block;
      position: relative;
      padding-left: 5px;
      width: 100%;
      /*overflow: hidden;*/
      margin: 0;
    }
    ul.head_ulbox li{
      width:calc(100% / 4);
      float: left;
    }
    ul.head_ulbox li select {
    padding: 8px; 
    border: 1px #CCCCCC solid;
    border-radius: 3px;
    width: 100%;
    box-sizing: border-box;
    }
    ul.head_ulbox li .datetimequ {
      font-size: 11px;
      color: #999999;
      position: relative;
      margin: 0;
      text-align: right;
      top: 4px;
    }
  </style>
</div>
<div class="displaytab" id="displaymaintab<?php echo $querylisting['id']; ?>" style="display:block;background-color: #f8f8f8;">
  <div style="position:relative;">
    <!-- Show form data here --> 
    <div style="margin-bottom:10px; font-size:16px;"><?php echo $resultpage['name']; ?></div>
  
    <div style="background-color:#f3f3f354; padding:10px; border:1px #CCCCCC solid; margin-bottom:5px; display:none;" id="replaysupbox<?php echo $querylisting['id']; ?>">
     
        <form action="frm_action.crm" method="post" enctype="multipart/form-data" target="actoinfrm"  >
      
            <div class="addeditpagebox" style="padding: 0px; width: 100%; display: block;">
                <div class="griddiv" style="width: 40%; float: left; margin-right: 10px;"> 
                    <div style="border-bottom:1px #d8d8d8 solid; padding-bottom:5px; color:#8a8a8a; border-bottom:0px;">Reply template</div>
                    <select id="emailTemplateId2" name="emailTemplateId" class="gridfield" onchange="emailloadotherItinerary<?php echo $querylisting['id']; ?>('<?php echo $querylisting['id']; ?>',this.value,'<?php echo $resultpage['id']; ?>')" >
                    <option value="">Select Template</option>
                    <?php 
                    $rstmp=GetPageRecord('*',_EMAIL_TEMPLATE_MASTER_,' deletestatus=0 order by subject asc');
                    while($resListingtemp=mysqli_fetch_array($rstmp)){
                    ?>
                    <option value="<?php echo strip($resListingtemp['id']); ?>" <?php if($resListingtemp['id']==$emailTemplateId){ ?>selected="selected"<?php } ?>><?php echo strip($resListingtemp['subject']); ?></option>
                    <?php 
                    }
                    ?>
                    </select>
                </div>
                <div class="griddiv" style="width: 40%; float: left; margin-right: 10px;">
                    <div style="border-bottom:1px #d8d8d8 solid; padding-bottom:5px; color:#8a8a8a; border-bottom:0px;">Add more emails</div>
                    <input type="text" name="ccSupplier" id="ccSupplier" placeholder="test@example.com,test@example.com" class="gridfield"/>
                </div>  
            </div>
            
            <div style="border-bottom:1px #d8d8d8 solid; padding-bottom:5px; color:#8a8a8a; border-bottom:0px;">Response</div>
            <div class="" id="reply_supp_box<?php echo $querylisting['id']; ?>">Loading...</div>
             
            <div style="margin-top:10px; overflow:hidden;text-align:right;">
                <input name="queryId" type="hidden" id="queryId" value="<?php echo $_REQUEST['id']; ?>" />
                <input name="suppId" type="hidden" id="suppId" value="<?php echo $resultpage['id']; ?>" />
                <input name="action" type="hidden" id="action" value="suppierReplyaction" />
                
                <input type="submit" class="bluembutton submitbtn" name="submitbtn" value="Reply" id="submitbtn">
                <input type="button" class="whitembutton" name="submitbtn" value="Cancel" id="submitbtn" onclick="replysupcomclose(<?php echo $querylisting['id']; ?>);" >
            </div>
              
        </form>
     
    </div>
  
  
    <?php 
    // echo 'queryId='.$_REQUEST['id'].' and supplierId="'.$resultpage['id'].'" order by dateAdded desc';
    $rsrs=GetPageRecord('*',_SUPPLIER_COMMUNICATION_MAIL_,'queryId='.$_REQUEST['id'].' and supplierId="'.$resultpage['id'].'" order by dateAdded desc');
    while($supmails=mysqli_fetch_array($rsrs)){ ?>

      <div style="border:1px #ccc solid; margin-bottom:5px;">
        <div style="padding:10px; background-color:#F3F3F3; <?php if($supmails['replyStatus']==1){ ?>background-color:#ffc1155e;<?php } ?> color:#333333; cursor:pointer; margin-bottom:0px;" id="mailtrailtab<?php echo $supmails['id']; ?>" onclick="openclosemailtrail('<?php echo $supmails['id']; ?>');readsuppliermailfun('<?php echo $supmails['id']; ?>');">
          <i class="fa fa-window-close" aria-hidden="true" style="position: absolute; right: 0px; font-size: 22px; top: -4px;  color: #ce0707; cursor: pointer;" onclick="replysupcomclose(<?php echo $querylisting['id']; ?>);"></i>
          <i class="fa fa <?php if($supmails['replyBy']==0){ ?>fa-mail-reply<?php } else {  ?>fa-mail-forward<?php } ?>" aria-hidden="true" ></i>
          &nbsp;&nbsp;
          <?php if($supmails['fromMail']!=''){ echo strip_tags(substr($supmails['subject'],0,100)); } else { echo strip_tags(substr($supmails['detail'],0,100)); } ?> ... <?php echo date('d-m-Y h:i a',strtotime($supmails['dateAdded'])); ?>
        </div>
        
        <div class="mailtrailcontent<?php echo $querylisting['id']; ?>" style="padding:15px; background-color:#FFFFFF; display:none; box-shadow: 0px 0px 10px #ccc;" id="mailtrailcontent<?php echo $supmails['id']; ?>">
          <div class="mailusers">
            <div class="mailusersbox"><strong>Supplier: </strong><?php echo trim(getPrimaryEmail($supmails['supplierId'],'suppliers')); ?></div>
            <div class="mailusersbox"><strong>CC mails: </strong><?php echo $supmails['ccmail']; ?></div>
          </div>
          <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:1px #ccc solid; font-size:12px; color:#666666; position:relative;">
            <i class="fa <?php if($supmails['replyBy']==0){ ?>fa-mail-reply<?php } else {  ?>fa-mail-forward<?php } ?>" aria-hidden="true" ></i>
            &nbsp;&nbsp; 
            <?php if($supmails['fromMail']!=''){ ?>
              <strong>From:</strong> <?php echo stripslashes($supmails['fromMail']); ?> - 
            <?php } 
            echo date('d-m-Y h:i a',strtotime($supmails['dateAdded'])); ?>
            <i class="fa fa-window-close" aria-hidden="true" style="position: absolute; right: 0px; font-size: 22px; top: -4px;  color: #ce0707; cursor: pointer;" onclick="closesuptab('<?php echo $supmails['id']; ?>');"></i>
          </div>
          <?php
          if($supmails['directReply']==0){
            // nl2br()
            echo (stripslashes($supmails['detail']));
          } else{
            echo (stripslashes($supmails['detail']));
          }
          ?>
        </div>
        <script>
          function openclosemailtrail(id){
            $('#mailtrailtab'+id).toggle();
            $('#mailtrailcontent'+id).toggle();
          }
        </script>
      </div>
      
      <?php 
    } ?> 
    <!-- End form data here --> 
    <input name="Reply" type="button" class="greenbuttonx2" id="reply<?php echo $querylisting['id']; ?>" value="Reply" style="position: absolute;  padding: 5px 8px; right:-7px; font-size: 12px;top: -6px;" onclick="replysupcom('<?php echo $querylisting['id']; ?>','<?php echo $resultpage['id']; ?>');" />
  </div>
  </div>
  <script>
  <?php if($_REQUEST['s']!=''){ ?>
  openclosesuptab('<?php echo $querylisting['id']; ?>');
  <?php } ?>
  </script>
  <?php $n++; } ?>
  <?php if($n==1){ ?>
  <div style="text-align:center; padding:20px; color:#999999;">No Supplier</div>
  <?php } ?>
  <style>
  .graytextm{color:#999999;border-bottom:1px solid #f3f3f3;}
  .borderrow{border-bottom:1px solid #f3f3f3;}
  .redbox{margin: auto;
  width: 80px;
  color: #FFFFFF;
  padding: 4px;
  background-color: #CC0000;
  text-align: center;
  font-size: 13px;
  font-weight: 500;
  border-radius: 4px;}
    
    .greenbox{
  background-color: #82b767; }
    .boxlistingw{border-bottom: 1px #e6e6e6 solid;    padding: 10px;}
  </style>
  <script type="text/javascript">
    function replysupcom(id,suppId){ 
        $('#replaysupbox'+id).show();
        $('#reply'+id).hide();
      emailloadotherItinerary(id,'0',suppId);
    } 
    function emailloadotherItinerary(boxId,emailTemplateId,suppId){ 
        $('#reply_supp_box'+boxId).load('frmaction.php?id='+emailTemplateId+'&action=loadWelcomeNoteSupplier&suppId='+suppId);
    }  
    function replysupcomclose(id){ 
        $('#replaysupbox'+id).hide();
        $('#mailtempSelectBox'+id).hide();
        $('#reply'+id).show();
        $('.mailtrailcontent'+id).hide();
    }
</script>
  <script>
  function openclosesuptab(id){
  $('#displaymaintab'+id).show();
  $('#maintab'+id).hide();
  }
  function closesuptab(id){
  $('#mailtrailtab'+id).show();
  $('#mailtrailcontent'+id).hide();
  }
  function readsuppliermailfun(id){
  $('#actiondiv').load('frmaction.php?queryId=<?php echo $_REQUEST['id']; ?>&action=readsuppliermail&suppliermailid='+id);
  $('#mailtrailtab'+id).css('background-color','#F3F3F3');
  }
  </script>