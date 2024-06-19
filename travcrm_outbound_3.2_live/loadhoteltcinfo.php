<?php
include "inc.php";
$hotelId = $_REQUEST['hotelId'];
$rs2=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId .'"'); 
$editresult2=mysqli_fetch_array($rs2); 


 
?>  
<style>
.allfields{
padding: 5px;
    text-align: center;
    width: 70px;
    border: 1px solid #ccc;
    border-radius: 3px;
	}
</style>
<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;">
<table width="100%" border="0"  bgcolor="#DDDDDD"  cellspacing="0" cellpadding="5" >
  <tr>
    <td width="92%" align="left"><strong style="font-size: 18px;padding-left: 15PX;"><?php echo $editresult2['hotelName']; ?></strong></td>
    <td width="8%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#viewinfo').hide();"></i></td>
  </tr> 
</table>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addquohotelroomprice" target="actoinfrm"  id="addquohotelroomprice">
  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable" style=" margin-bottom:20px;">
    
     <tr>
       <td><strong>Hotel Information</strong><br><br><?php echo $editresult2['hoteldetail']; ?></td> 
     </tr>
     <tr>
       <td><strong>Policy</strong><br><br><?php echo $editresult2['policy']; ?></td>
     </tr>
     <tr>
       <td><strong>T&C</strong><br><br><?php echo $editresult2['termAndCondition']; ?></td>
     </tr>
     

</table> 
</form>
<br>
</div>
<script>
$(document).on("input", ".numeric", function() {
this.value = this.value.replace(/\D/g,'');
}); 
</script> 