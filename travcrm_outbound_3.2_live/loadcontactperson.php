<?php
include "inc.php";
include "config/logincheck.php";
$id=$_REQUEST['id'];
?>
<div id="phoneidcp<?php echo $id; ?>">
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td width="321" align="left">
        <select id="division<?php echo $id; ?>" name="division<?php echo $id; ?>" class="gridfield" displayname="Division" autocomplete="off"  placeholder="Division" >
          <option value="">Division</option>
          <?php
          $selectD='*';
          $whereD=' deletestatus=0 and status=1 order by name asc';
          $rsD=GetPageRecord($selectD,_DIVISION_MASTER_,$whereD);
          while($resListingD=mysqli_fetch_array($rsD)){
          ?>
          <option value="<?php echo strip($resListingD['id']); ?>"><?php echo strip($resListingD['name']); ?></option>
          <?php } ?>
        </select>
      </td>
      <td width="321" align="left">
        <input name="contactPerson<?php echo $id; ?>" type="text" class="gridfield" id="contactPerson" value=""  maxlength="100" placeholder="Contact Person" />
      </td>
      <td width="288" align="left">
        <input name="designation<?php echo $id; ?>" type="text" class="gridfield" id="designation" value="" placeholder="Designation" />
      </td>
      <td width="144" align="center">
        <input name="countryCode<?php echo $id; ?>" type="text" class="gridfield" id="countryCode" value="" placeholder="+91" />
      </td>
      <td width="251" align="center">
        <input name="phone<?php echo $id; ?>" type="text" class="gridfield" id="phone" value=""  placeholder="Phone" maxlength="14"/>
      </td>
      <td width="354" align="center">
        <input name="email<?php echo $id; ?>" type="text" class="gridfield" id="email" value=""  placeholder="Email" />
      </td>
      <td width="354" align="center">
        <input name="secondemail<?php echo $id; ?>" type="text" class="gridfield" id="secondemail" value=""  placeholder="Secondary Email" />
      </td>
      <td width="70" align="center">
        <input name="primaryvalue" class="gridfield" type="radio" value="<?php echo $id; ?>"  />
      </td>
      <td width="70" align="center">
        <img src="images/deleteicon.png" width="12" height="16" onclick="removecontactperson(<?php echo $id; ?>);" style="cursor:pointer;"/>
      </td>
    </tr>
  </table>
</div>

