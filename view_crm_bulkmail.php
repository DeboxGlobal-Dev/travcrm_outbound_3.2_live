<?php
$id=decode($_REQUEST['id']);
$select='*';
$where='displayId='.$id.'';  
$rs=GetPageRecord($select,'bulkEmailCategory',$where);  
$resultlists=mysqli_fetch_array($rs); 

$select='id,email';
$where='from_name="Bulk Email"';  
$rs=GetPageRecord($select,'emailSettingmaster',$where);  
$resultEmail=mysqli_fetch_array($rs); 
 
?>
<script language="JavaScript" type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="ckeditor/ckfinder/ckfinder.js"></script> 
<script>
corporatevoice=1;
</script>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top"><div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?> - <?php echo $resultlists['name']; ?> (<?php if($resultlists['displayId']=='200'){ echo countlisting('id','corporateMaster','where deletestatus=0'); } if($resultlists['displayId']=='201'){ echo countlisting('id','contactsMaster','where deletestatus=0'); } if($resultlists['displayId']!='201' && $resultlists['displayId']!='200'){ echo countlisting('id','queryMaster','where queryStatus='.$resultlists['displayId'].' and deletestatus=0'); } ?>)</span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Company','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr> 
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Cancel" onclick="cancel();" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div> 
    <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
	  <div style="width:70%; margin:auto; overflow:hidden; margin-top: 150px; background-color:#f8f8f8; padding:20px; border: 2px #efefef solid;">
        <div style="margin-bottom:15px;">
          <input name="bulkemailsender" id="bulkemailsender" type="text" style="padding:10px; font-size:18px; border:1px solid #ccc; width:100%; box-sizing:border-box;" value="<?php echo $resultEmail['email']; ?>" />
        </div>
	    <div style="margin-bottom:15px;">
	      <input name="bulkmailsubject" id="bulkmailsubject" type="text" style="padding:10px; font-size:18px; border:1px solid #ccc; width:100%; box-sizing:border-box;" placeholder="Subject" />
	      </div>
	    <div style="margin-bottom:15px;">
	      <textarea name="description" id="description" rows="20" class="gridfield" style="height:220px;"></textarea>
          <div style="margin-top:15px; text-align:right;">
            <input name="addnewuserbtn2" id="addnewuserbtn2" type="submit" class="bluembutton" id="addnewuserbtn2" value="Send Mail Now" />
            <input name="action" type="hidden" id="action" value="sendbulkmail" />
            <input name="mailtoId" type="hidden" id="mailtoId" value="<?php echo $resultEmail['id']; ?>" />
            <input name="bulkemailcategory" type="hidden" id="bulkemailcategory" value="<?php echo $resultlists['displayId']; ?>" />
          </div>
	      <script type="text/javascript">
	                var editor = CKEDITOR.replace('description');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script>
	      </div>
	    </div>
	</form></td>
  </tr>
</table>

 