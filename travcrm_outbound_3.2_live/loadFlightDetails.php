<?php
include "inc.php"; 
include "config/logincheck.php";  
$id=$_REQUEST['id'];
?>

 <div id="guestid<?php echo $id; ?>" style="margin-top: 5px;">
 <table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="37%" align="left"><input name="flightDetails<?php echo $id; ?>" type="text" class="gridfield "   id="flightDetails<?php echo $id; ?>" value=""  placeholder="Flight Details" style="padding: 9px; border-radius: 3px; margin-left: 5px; border: 1px solid #ccc; width: 100%; min-height: 30px; margin-top: 5px;" /></td>
    <td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removeguestNames('<?php echo $id; ?>');" style="cursor:pointer;"/></td>
  </tr>
</table>
</div>