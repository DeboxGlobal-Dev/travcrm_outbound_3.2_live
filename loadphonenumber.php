<?php
include "inc.php"; 
include "config/logincheck.php";  
$id=$_REQUEST['id'];
?>

 <div id="phoneid<?php echo $id; ?>">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%" align="left"><select id="PhoneTypeId<?php echo $id; ?>" name="PhoneTypeId<?php echo $id; ?>" class="gridfield"  autocomplete="off"  style="padding: 9px; height: 37px;">
      <option value="">Select Type</option>
      <?php 

      $select='*';    
      $where=' status=1 order by id asc';  
      $rs=GetPageRecord($select,_PHONE_TYPE_MASTER_,$where); 
      while($restype=mysqli_fetch_array($rs)){  

      ?>
      <option value="<?php echo strip($restype['id']); ?>" <?php if($restype['id']==$reslisting['phonetype']){ ?>selected="selected"<?php } ?>><?php echo strip($restype['name']); ?></option>
      <?php } ?>
    </select></td>
    <td width="0%" align="left">&nbsp;&nbsp;</td>
    <td align="left" style="padding-right:10px; width:8%;"><input name="countryCode<?php echo $id; ?>" type="text" class="gridfield" id="countryCode<?php echo $id; ?>" placeholder="+91" value="<?php echo ""; ?>" maxlength="5" /></td>
    <td width="" align="left" style="padding-right:10px;"><input name="PhoneNo<?php echo $id; ?>" type="text" class="gridfield" id="PhoneNo<?php echo $id; ?>" value="" maxlength="14" /></td>
    <td width="15%" align="left">
      <select id="EmailTypeId<?php echo $id; ?>" name="EmailTypeId<?php echo $id; ?>" class="gridfield" autocomplete="off" style="padding: 9px; height: 37px;">

    <?php
      $select = '*';
      $where = ' status=1 order by id asc';
      $rs = GetPageRecord($select, _EMAIL_TYPE_MASTER_, $where);
      while ($restype = mysqli_fetch_array($rs)) {
        ?>
      <option value="<?php echo strip($restype['id']); ?>" <?php if ($restype['id'] == $reslisting['emailtype']) { ?>selected="selected" <?php } ?>><?php echo strip($restype['name']); ?></option> <?php } ?>
      </select>
    </td>
        <td width="0%" align="left">&nbsp;&nbsp;</td>
    <td width="" align="left" ><input name="Email<?php echo $id; ?>" type="email" class="gridfield" displayname="Email" id="Email<?php echo $id; ?>" value="<?php echo $emailNew; ?>" maxlength="100" /></td>

    <td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
      <lable>
        <input class="CV" name="primaryValue<?php echo $id; ?>" id="primaryValue<?php echo $id; ?>" type="checkbox" value="1" style="display:block;" onChange="removeChecked(<?php echo $id; ?>);">
      </lable>
    </div></td>
    <td width="6%" align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removephoneNumbers(<?php echo $id; ?>);" style="cursor:pointer;"/></td>
  </tr>
</table>
</div> 