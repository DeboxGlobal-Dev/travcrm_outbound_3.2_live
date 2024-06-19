<?php
include "inc.php";
$id=$_REQUEST['queryid'];
?>
<?php 
$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,_INVOICE_SETTING_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$logo=stripslashes($editresult['logo']); 
$editcompanyname=clean($editresult['companyname']);

$where='id='.$id.'';
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   
$resultpage=mysqli_fetch_array($rs);  
?>
<div style="width: 100%; max-width: 604px; background: #fbfbfb; padding: 15px 15px 30px; border: 1px solid #e2e2e2; margin: auto; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#4a4a4a;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="<?php $fullurl; ?>download/<?php echo $logo; ?>" height="70" /></td>
          <td width="50%" align="right"><table style="font-size:12px; font-weight:600; color:#4a4a4a;">
            <tbody>
              <tr>
                <td align="right">CHECKOUT DATE</td>
              </tr>
              <tr>
                <td align="right" style="color:#a2a2a2;"><?php if($resultpage['toDate']!=''){ echo date('j-F-Y',strtotime($resultpage['toDate'])); }?></td>
              </tr>
            </tbody>
          </table>          </td>
        </tr>
        
      </table></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top" style="background-color:#4CAF50; color:#FFFFFF;">
	  <div style="padding:10px; text-align:center; font-size:14px; text-transform:uppercase; font-weight:600;">SHARE YOUR EXPERIENCE</div>	  </td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"><img src="<?php echo $fullurl; ?>/images/feedbackbanner.jpg"  width="100%"/></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top" style=" color:#828282; font-size:13px;">Dear <?php echo showClientTypeUserName($resultpage['clientType'],$resultpage['companyId']); ?>,<br />
<br />

Hope you had a pleasant trip. <br />
<br />

We at <?php echo $editcompanyname; ?> are constantly trying to improve your travel experience. To help us do that, please spare a few minutes for a brief survey about your trip.
<br />
<br />
Your feedback is important to us.</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"><a href="<?php echo $fullurl; ?>client_submitfeedback.php?i=<?php echo encode($id); ?>" style="background:#f34f4f;color:#fff;padding:10px 20px;display:inline-block;border-radius:3px;text-decoration:none;font-size:12px;line-height:16px" target="_blank">Submit your Feedback</a></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top" style=" color:#828282; font-size:13px; line-height:20px;"><span style=" color:#4a4a4a;">Best Regards</span><br />

Team <?php echo $editcompanyname; ?></td>
    </tr>
  </table>
</div>
