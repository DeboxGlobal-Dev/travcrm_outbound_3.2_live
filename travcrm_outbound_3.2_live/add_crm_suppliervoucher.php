<?php 
if($_GET['qid']!=''){ 
$select1='*';  
$where1='id="'.decode($_REQUEST['qid']).'" order by id desc'; 
$rs1=GetPageRecord($select1,_QUOTATION_MASTER_,$where1); 
$result=mysqli_fetch_array($rs1);
 }
 
?>
 

	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
    <div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain">
        <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td style="padding-right:20px;"><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
           
            <td style="padding-right:20px;display:none;"><input type="button" name="Submit22" value="Cancel" class="whitembutton" <?php if($_get['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
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
 
   <div id="loadcreateitinerary"  style="  padding:0px; overflow:auto; text-align:left; margin-bottom:0px; " >Loading...</div>
  <script>
  $('#loadcreateitinerary').load('loadcreatevoucher.php?queryId=<?php echo decode($_REQUEST['queryId']); ?>&qid=<?php echo decode($_REQUEST['qid']); ?>&module=<?php echo clean($_GET['module']); ?>');
  </script>
</div>
               
            

               
       
          </div>
          

        </div> 


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo $resultinvoicepage['id']; ?>" />
		<input name="queryId" type="hidden" id="queryId" value="<?php echo $lastId; ?>" />
		 <input name="mice" type="hidden" id="mice" value="<?php echo $_REQUEST['mice']; ?>" />
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
	 
		</td>
        <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         
        <td style="padding-right:20px;display:none;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
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
 