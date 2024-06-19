<?php
if($_GET['qid']!=''){
  $select1='*';
  $where1='id="'.decode($_REQUEST['qid']).'" and status=1 order by id desc';
  $rs1=GetPageRecord($select1,_QUOTATION_MASTER_,$where1);
  $result=mysqli_fetch_array($rs1);
 
  if($setDefaultTemplate==1){
      $vouceherFile = 'loadcreatevoucher_client.php';
  }elseif($setDefaultTemplate==2 || $setDefaultTemplate==3){
    $vouceherFile = 'loadcreatevoucher_client_dmc.php';
  }elseif($setDefaultTemplate==4){
    $vouceherFile = 'loadcreatevoucher_client4.php';
  }

}
?> 
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain" style="font-size: 22px !important;">
      <?php echo $pageName; ?> </span></div></td>
      <td align="right">
        <table border="0" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td></td>
            <td>
              <?php if($setDefaultTemplate==2 || $setDefaultTemplate==3){ ?>
                <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($result['queryId']); ?>&dmcvoucher=<?php echo trim($result['id']).'_'.trim($_REQUEST['module']);  ?>&quotationId=<?php echo encode($result['id']); ?>" class="bluembutton submitbtn">Send DMC Voucher</a>
             <?php }elseif($setDefaultTemplate==4){ ?> 
              <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($result['queryId']); ?>&voucherURLString=<?php echo trim($result['id']).'_'.trim($_REQUEST['module']).'_1'; ?>&allVoucherURLString=yes" class="bluembutton submitbtn" target="_blank">Send Vouchers</a>
              <?php }else{ ?> 
              <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($result['queryId']); ?>&allvoucher=<?php echo trim($result['id']).'_'.trim($_REQUEST['module']).'_1'; ?>" class="bluembutton submitbtn" target="_blank">Send Vouchers</a>
              <?php } ?>
            </td>
            <td style="padding-right:20px;">
               <a href="showpage.crm?module=query&view=yes&id=<?php echo encode($result['queryId']); ?>&b2bquotation=1"><input type="button" name="Submit22" value="Back" class="whitembutton" ></a>
            </td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;padding-top: 115px;">
  <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
    
    <div class="addeditpagebox" style="background-color: #dedede;">
      <input name="action" type="hidden" id="action" value="<?php if($_GET['id']!=''){ echo 'saveinvoice';} else { echo 'addquery'; } ?>" />
      <input name="savenew" type="hidden" id="savenew" value="0" />
      <div class="col-md-6" style="width:915px;margin: auto;
        border: 1px #ccc solid;
        background-color: #fff;">
        <!-- general form elements -->
        <div class="box box-primary">
          <div style="padding:20px;">
            
            <div id="loadcreateitinerary"  style="padding:0px;text-align:left; margin-bottom:0px; " >Loading...</div>
            <script>
            $('#loadcreateitinerary').load('<?php echo $vouceherFile; ?>?quotationId=<?php echo decode($_REQUEST['qid']); ?>&module=<?php echo clean($_GET['module']); ?>');
            </script>
          </div>
           
        </div>
        
      </div>
    </div>
    <div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
          </td>
          <td>&nbsp;</td>
          <td style="padding-right:20px;display:none;">&nbsp;</td>
        </tr>
        
      </table></td>
    </tr>
    
  </table>
</div>

</form>

</div>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
width: 100% !important;
}
.form-control {
display: block;
width: 100%;
height: 34px;
padding: 6px 12px;
font-size: 14px;
line-height: 1.42857143;
color: #555;
background-color: #fff;
background-image: none;
border: 1px solid #ccc;
border-radius: 4px;
-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
  box-sizing: border-box;
}
.btn-default {
background-color: #f4f4f4;
color: #444;
border-color: #ddd;
}
.btn {
border-radius: 3px;
-webkit-box-shadow: none;
box-shadow: none;
border: 1px solid transparent;padding: 8px;
}
.btn-info {
background-color: #00c0ef;
border-color: #00acd6; color:#fff;
}
</style>