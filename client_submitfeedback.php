<?php
include "inc.php";  
$id=decode($_REQUEST['i']);
if($_REQUEST['d']!=1){
$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,_INVOICE_SETTING_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$logo=stripslashes($editresult['logo']); 
$editcompanyname=clean($editresult['companyname']); 

$where='id='.$id.'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   
$resultpage=mysqli_fetch_array($rs);
}


if($_REQUEST['rating']!='' && $_REQUEST['submitfeedback']=='yes' && $_REQUEST['id']!=''){ 
    
$queryid=$_REQUEST['id'];
$rating=$_REQUEST['rating'];
$comment=addslashes($_POST['comment']);

$where1='id='.$queryid.'';  
$rs1=GetPageRecord('*',_QUERY_MASTER_,$where1);   
while($resultlist=mysqli_fetch_array($rs1)){
$queryid = $resultlist['id'];
$companyId = $resultlist['companyId'];
$clientType = $resultlist['clientType'];
$fromDate = $resultlist['fromDate']; 
$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' queryId="'.$queryid.'"');  
$quotationData=mysqli_fetch_array($rs2);
$quotationId=$quotationData['id'];
}
 
$uploadPhoto='';
if($_FILES['images']['name']!=''){ 
$uploadPhoto=$_FILES['images']['name']; 
$uploadPhoto=time().'-'.$uploadPhoto; 
copy($_FILES['images']['tmp_name'],"dirfiles/".$uploadPhoto);  
}


$namevalue ='clientType="'.$clientType.'",queryId="'.$queryid.'",quotationId="'.$quotationId.'",companyId="'.$companyId.'",clientrating="'.$rating.'",feedbackDate="'.date('Y-m-d H:i:s').'",clientexperience="'.$comment.'",feedbackImage="'.$uploadPhoto.'",fromDate="'.$fromDate.'"';

addlisting('clientfeedbackmaster',$namevalue); 
 
header('location:client_submitfeedback.php?d=1');
}


 
?>
<title>Submit Your Feedback - <?php echo $editcompanyname; ?></title>
<div style="width: 100%; max-width: 604px; background: #fbfbfb; padding: 15px 15px 30px; border: 1px solid #e2e2e2; margin: auto; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#4a4a4a;">

<?php if($resultpage['feedbackStar']!='0' && $_REQUEST['d']!=1){ ?>
<div style=" padding:30px; text-align:center; color:#FF0000; font-size:16px;">Oops, the survey URL has expired!</div>
<?php } else { ?>
<form action="" method="post" enctype="multipart/form-data"  >
<?php if($_REQUEST['d']==1){ ?>
<div style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:600; margin-bottom:10px; color:#009900;">Thank You</div>
<div style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; margin-bottom:10px;">Thank you for taking the time and we are glad to provide you our services!</div>
<?php }  else { ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="<?php echo $fullurl; ?>download/<?php echo $logo; ?>" height="70" /></td>
          <td width="50%" align="right"><table style="font-size:12px; font-weight:600; color:#4a4a4a;">
            <tbody>
              <tr>
                <td align="right">CHECKOUT DATE</td>
              </tr>
              <tr>
                <td align="right" style="color:#a2a2a2;"><?php echo date('j-F-Y',strtotime($resultpage['toDate'])); ?></td>
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
	  <div style="padding:10px; text-align:center; font-size:14px; text-transform:uppercase; font-weight:600;">Feedback - <?php echo strip($resultpage['subject']); ?></div>	  </td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"> </td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top" style="font-size:17px; line-height:26px;">Thinking about your trip experience, how well were all your requirements <br />
      taken into consideration?</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"><div style="padding:10px; background-color:#FFFFFF; border:1px solid #ccc;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
        <tr>
          <td width="83%" align="center"><table border="0" cellpadding="5" cellspacing="0" style="font-size:16px;">
            <tr>
              <td align="center" bgcolor="#DDFFD9" style="width: 128px;"><?php echo "&#128546;" ?></td>
              <td align="center" bgcolor="#BAFFB3" style="width: 128px;"><?php echo "&#128528;" ?></td>
              <td align="center" bgcolor="#DDFFD9" style="width: 128px;"><?php echo "&#128522;" ?></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#DDFFD9"><label>Sad<input name="rating" type="radio" value="1" /></label></td>
              <td align="center" bgcolor="#BAFFB3"><label>Neutral<input name="rating" type="radio" value="2" /></label></td>
              <td align="center" bgcolor="#DDFFD9"><label>Happy<input name="rating" type="radio" value="3" /></label></td>
            </tr>
            
          </table></td>
        </tr>
        
      </table></div></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top" style="font-size:17px; line-height:26px;">Your Experience </td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"><textarea name="comment" id="comment" style="width:100%; max-width:100%; box-sizing:border-box; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:13px; height:120px; border:1px solid #ccc;"></textarea></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top" style="font-size:17px; line-height:26px;">Picture</td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"><input type="file" name="images" /></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top"><input name="submitfeedback" type="hidden" id="submitfeedback" value="yes" /><input name="id" type="hidden" id="id" value="<?php echo $resultpage['id']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="3" align="right" valign="top"> 
        <input type="submit" name="Submit" value="Submit Your Feedback" style="padding:10px 30px; border:0px; outline:0px; background-color:#4CAF50; font-size:14px; font-weight:600; color:#fff; cursor:pointer;" />
  </td>
    </tr>
     
  </table>
<?php } ?>
</form>

<?php } ?>
</div>
