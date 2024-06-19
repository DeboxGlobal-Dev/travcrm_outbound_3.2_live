<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
 
if($_GET['id']!=''){
$id=clean(decode($_GET['id'])); 
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,'languageMaster',$where1); 
$editresult=mysqli_fetch_array($rs1); 
$editUserId=clean($editresult['id']);
$editComapnyanme=clean($editresult['name']);  
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php echo $editComapnyanme; ?></td>
  </tr>
  
</table>
</div></td>
    <td align="right"><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
      </tr>
      
    </table><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
 <div class="addeditpagebox vieweditpagebox" id="loadlanglist"> 
</div>

  
 
</div>
<script>  
function editnewword(updateid){
var englishword = encodeURI($('#englishword'+updateid).val());
var newhword = encodeURI($('#newhword'+updateid).val()); 
$('#loadlanglist').load('loadlanglist.php?id=<?php echo $editUserId; ?>&englishword='+englishword+'&newhword='+newhword+'&updateid='+updateid);
}



function addnewword(){ 
var englishword = encodeURI($('#englishword').val());
var newhword = encodeURI($('#newhword').val()); 
$('#loadlanglist').load('loadlanglist.php?id=<?php echo $editUserId; ?>&addnew=1&englishword='+englishword+'&newhword='+newhword);
}



$('#loadlanglist').load('loadlanglist.php?id=<?php echo $editUserId; ?>');
comtabopenclose('linkbox','op4');
</script>
