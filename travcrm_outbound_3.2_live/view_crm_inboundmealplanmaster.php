<?php 
if(decode($_REQUEST['inboundmealplanNameId'])!=''){  
	$restaurantQ=GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,' id="'.decode($_REQUEST['inboundmealplanNameId']).'"'); 
	$inboundmealplanD=mysqli_fetch_array($restaurantQ);
}
?> 

<style>
    .topaboxouter {
        margin: 30px;
        margin-top: 160px;
    }
    .addGreenHeader {
        background: rgba(186, 228, 193, 0.75);
        padding: 10px;
        font-size: 15px;
        font-weight: bold;
    }
    .myclass {
        background-color: rgb(242, 255, 247);
        border-collapse: collapse;
        margin: 5px;
    }
    #addTriffRoom{
        border: 2px rgba(186, 228, 193, 0.75) solid;
    }

</style>

<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%" align="center">
       <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>&amp;keyword=<?php echo $_REQUEST['keyword'];?>"><input type="button" name="Submit22" value="Back" class="whitembutton"> </a>  
     </td>
    <td width="95%" align="left"><?php echo $inboundmealplanD['mealPlanName']; ?></td>
  </tr>
</table>
</div>

<?php 
$serviceId = decode($_GET['inboundmealplanNameId']);
$rest = GetPageRecord('*',_INBOUND_MEALPLAN_MASTER_,'id="'.decode($_REQUEST['inboundmealplanNameId']).'"');
   $resListing = mysqli_fetch_assoc($rest);
?>

<div class="topaboxouter">
    <div id="addTriffRoom" class="addeditpagebox " style="display:block;padding: 0;">
        <div class="addGreenHeader"><?php echo ' Add '.$resListing['mealPlanName'].' Rate'; ?> </div>
        <form action="frm_action.crm" method="post" name="addrestaurantrate" target="actoinfrm" id="addrestaurantrate">
        <table border="1" cellspacing="0" cellpadding="10" class="myclass">
            <!-- <tr>
                <td colspan="5">
                    <div id="alertsumessage" style="display: none;background-color: #00800021;padding: 10px; text-align: center;
                border: 1px solid #00800040;"><strong>Meal Type already exist, Please Select another Meal Type</strong></div>
                </td>
            </tr> -->
            
            <tr>
                <td width="150">
                    <div class="griddiv">
                        <label>
                            <div class="gridlable w100">Meal Type<span class="redmind"></span></div>
                            <select id="mealPlanType" name="mealPlanType" class="gridfield validate" displayname="Meal Type" autocomplete="off">
                                <?php
                                $rs2 = GetPageRecord('*', 'restaurantsMealPlanMaster', ' 1 and status=1 and deletestatus=0');
                                while ($userss = mysqli_fetch_array($rs2)) {
                                ?>
                                    <option value="<?Php echo $userss['id']; ?>"><?Php echo $userss['name']; ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>
                </td>
                <td width="100">
                    <div class="griddiv">
                        <label>
                            <div class="gridlable w100">Currency<span class="redmind"></span></div>
                            <select id="currencyId" name="currencyId" class="gridfield validate" displayname="Currency" autocomplete="off">
                                <?php

                                $select = '';
                                $where = '';
                                $rs = '';
                                $select = '*';
                                $where = ' deletestatus=0 and status=1 order by name asc';
                                $rs = GetPageRecord($select, _QUERY_CURRENCY_MASTER_, $where);
                                while ($resListing = mysqli_fetch_array($rs)) {
                                ?>
                                    <option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['setDefault'] == 1) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>
                </td>
                <td width="100">
                    <div class="griddiv"><label>
                            <div class="gridlable w100">Adult Cost<span class="redmind"></span></div>
                            <input name="adultCostRest" type="text" class="gridfield number_only validate" id="adultCostRest" displayname="Adult&nbsp;Cost" value="<?php echo strip($editresult['adultCostRest']); ?>" />
                        </label>
                    </div>
                </td> 
                <td width="100">
                    <div class="griddiv"><label>
                            <div class="gridlable w100">Child Cost<span class="redmind"></span></div>
                            <input name="childCostRest" type="text" class="gridfield number_only validate" id="childCostRest" displayname="Child&nbsp;Cost" value="<?php echo strip($editresult['childCostRest']); ?>" />
                        </label>
                    </div>
                </td>
                <td width="150">
                    <div class="griddiv"><label>


                            <div class="gridlable w100">GST&nbsp;SLAB(%)<span class="redmind"></span></div>
                            <select id="RestaurantGST" name="RestaurantGST" class="gridfield" displayname="Restaurant GST" autocomplete="off" style="width: 100%;">
                                <?php
                                $rs2 = "";
                                $rs2 = GetPageRecord('*', 'gstMaster', ' 1 and serviceType="Restaurant" and status=1');
                                while ($gstSlabData = mysqli_fetch_array($rs2)) {
                                ?>
                                    <option value="<?php echo $gstSlabData['id']; ?>"><?php echo $gstSlabData['gstSlabName']; ?>&nbsp;(<?php echo $gstSlabData['gstValue']; ?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                </td>

                <td width="10%" align="left" valign="middle"  >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Type</div>
                    <select name="markupType" id="markupType" class="gridfield validate" displayname="Markup Type" autocomplete="off" style="width: 100%;" >
                        <option value="1">%</option>
                        <option value="2">Flat</option>
                    </select>
                    </label>
                </div>	
            </td>
            <td width="10%" align="left" valign="middle"  >
                <div class="griddiv"><label>
                    <div class="gridlable">Markup&nbsp;Cost</div>
                    <input name="markupCost" type="text" class="gridfield" id="markupCost" maxlength="6" onkeyup="numericFilter(this);" />
                    </label>
                </div>	
            </td>
            
                <input type="hidden" name="serviceId" id="serviceId" value="<?php echo $serviceId; ?>">
                <input type="hidden" name="action" id="action" value="saverestaurantsmealplan">
                <td width="40" align="center">
                <input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="+Add" onclick="formValidation('addrestaurantrate','submitbtn','0');" style="width: 100%; margin-left:0px !important;"/>
                    
                </td>
            </tr>
        </table>
        </form>
    </div>

    <br>
    <br>
    <div style=" padding:5px; border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
        <div id="loadmeal"></div>
    </div>
      
</div>

</div>
<div id="loadrestaurantmaster" ></div>
<script>  
function funloadinboundmealplanmaster(){ 
$('#loadmeal').load('loadinboundmealplanmaster.php?serviceId=<?php echo decode($_REQUEST['inboundmealplanNameId']); ?>'); 
}
funloadinboundmealplanmaster();
<?php if(decode($_REQUEST['inboundmealplanNameId']!='')){?>
    funloadinboundmealplanmaster();
<?php } ?>

$('#addnewuserbtn').show();


  function deleterate(tariffId) {
 if(confirm('Are you sure want to Delete?')==true) {
  $('#loadmeal').load('frmaction.php?action=deleterestaurantsmealplan&serviceId=<?php echo $serviceId; ?>&tariffId='+tariffId);
    }
 }
</script>